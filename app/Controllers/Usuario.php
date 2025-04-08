<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UsuarioModel;

class Usuario extends BaseController
{
    public function login()
    {
        $data = [];
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'email' => 'required',
                'password' => 'required|validateUser[email,password]',
            ];
            $messages = [
                'password' => [
                    'validateUser' => 'Credenciales incorrectas, intentelo nuevamente',
                    'required' => 'Ingrese la contraseña'
                ],
                'email' => [
                    'required' => 'Ingrese el correo electrónico'
                ]
            ];
            
            if (!$this->validate($rules, $messages)) {
                $data['validation'] = $this->validator;
            } else {
                $model = new UsuarioModel();
                $user = $model->where('email', $this->request->getVar('email'))
                    ->first();
                $this->setUserSession($user);
                return redirect()->to('home');
            }
        }
        return view('Usuario/login', $data);
    }

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'username' => $user['username'],
            'nombre' => $user['nombre'],
            'apellido' => $user['apellido'],
            'activo' => $user['deleted_at'],
            'email' => $user['email'],
            'admin' => $user['admin'],
            'isLoggedIn' => true,
        ];
        session()->set($data);
        return true;
    }

    public function index()
    {
        $data['vista'] = 'usuario';
        return view('Usuario/usuario', $data);
    }

    public function obtenerData()
    {
        if ($this->request->isAJAX()) {
            $usuarioModel = new UsuarioModel();
            $data['data'] = $usuarioModel->withDeleted()->findAll();
            foreach ($data['data'] as $i => $row) {
                $btnEditar = "";
                $btnBorrar = "";
                if (session()->get('admin') == 1 || session()->get('id') == $row['id']) {
                    $btnEditar = '<button type="button" class="btn-shadow btn btn-primary" onclick="edit(' . $row['id'] . ')" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></button>';
                }
                if (session()->get('admin') == 1 && session()->get('id') != $row['id']) {
                    $btnBorrar = $row['deleted_at'] == null ? '<button type="button" class="btn btn-danger" onclick="activar_desactivar(' . $row['id'] . ')" data-toggle="tooltip" data-placement="top" title="Desactivar"><i class="fas fa-trash-alt"></i></button>' : '<button type="button" class="btn btn-warning" onclick="activar_desactivar(' . $row['id'] . ')" data-toggle="tooltip" data-placement="top" title="Activar"><i class="fas fa-recycle"></i></button>';
                }
                $data['data'][$i]['admin'] = $data['data'][$i]['admin'] == 1 ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>';
                $data['data'][$i]['created_at'] = date('d/m/Y H:i:s', strtotime($data['data'][$i]['created_at']));
                $data['data'][$i]['deleted_at'] = $data['data'][$i]['deleted_at'] == null ? 'Activo' : 'Desactivado';
                $data['data'][$i]['opciones'] = '<div class="btn-group">' . $btnEditar . $btnBorrar . '</div>';
            }

            return json_encode($data);
        }
    }

    public function agregar()
    {
        if ($this->request->isAJAX()) {
            $rules = [
                'nombre' => 'required|max_length[50]',
                'apellido' => 'required|max_length[50]',
                'username' => 'required|max_length[50]|is_unique[usuario.username]',
                'email' => 'required|valid_email|max_length[255]|is_unique[usuario.email]',
                'password' => 'required|min_length[8]',
                'password_confirm' => 'required|matches[password]'
            ];
            $messages = [
                'nombre' => [
                    'required' => 'Debe ingresar el Nombre',
                    'max_length' => 'Nombre excede el largo de 50 caracteres'
                ],
                'apellido' => [
                    'required' => 'Debe ingresar el Apellido',
                    'max_length' => 'Apellido excede el largo de 50 caracteres'
                ],
                'username' => [
                    'required' => 'Debe ingresar el Nombre de Usuario',
                    'max_length' => 'Nombre de Usuario excede el largo de 50 caracteres',
                    'is_unique' => 'El nombre de usuario ingresado ya esta en uso'
                ],
                'email' => [
                    'required' => 'Debe ingresar su Email',
                    'valid_email' => 'Formato de email no valido',
                    'max_length' => 'Email excede el largo de 255 caracteres',
                    'is_unique' => 'El email ingresado ya esta en uso'
                ],
                'password' => [
                    'required' => 'Debe ingresar su contraseña',
                    'min_length' => 'Su contraseña debe tener como minimo 8 caracteres'
                ],
                'password_confirm' => [
                    'required' => 'Debe confirmar su contraseña',
                    'matches' => 'Su contraseña no coincide'
                ]
            ];
            if (!$this->validate($rules, $messages)) {
                $msg['error'] = [
                    'nombre' => $this->validator->getError('nombre'),
                    'apellido' => $this->validator->getError('apellido'),
                    'username' => $this->validator->getError('username'),
                    'email' => $this->validator->getError('email'),
                    'password' => $this->validator->getError('password'),
                    'password_confirm' => $this->validator->getError('password_confirm'),
                ];
            } else {
                $usuarioModel = new UsuarioModel();
                $datos = [
                    'nombre' => $this->request->getPost('nombre'),
                    'apellido' => $this->request->getPost('apellido'),
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password')
                ];
                $usuarioModel->save($datos);
                $msg['success'] = 'Usuario Ingresado Correctamente';
            }
            return json_encode($msg);
        }
    }

    public function editar()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $usuarioModel = new UsuarioModel();
            $data = $usuarioModel->withDeleted()->find($id);
            $msg['success'] = view("Usuario/usuario_editar", $data);
            return json_encode($msg);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $rules = [
                'nombre' => 'required|max_length[50]',
                'apellido' => 'required|max_length[50]',
                'email' => "required|valid_email|max_length[255]|is_unique[usuario.email,id,$id]",
            ];

            $messages = [
                'nombre' => [
                    'required' => 'Debe ingresar el Nombre',
                    'max_length' => 'Nombre excede el largo de 50 caracteres'
                ],
                'apellido' => [
                    'required' => 'Debe ingresar el Apellido',
                    'max_length' => 'Apellido excede el largo de 50 caracteres'
                ],
                'email' => [
                    'required' => 'Debe ingresar su Email',
                    'valid_email' => 'Formato de email no valido',
                    'max_length' => 'Email excede el largo de 255 caracteres',
                    'is_unique' => 'El email ingresado ya esta en uso'
                ]
            ];
            if ($this->request->getPost('check-pass') !== null) {
                $rules = [
                    'password' => 'required|validatePass[$id,password]',
                    'new_password' => 'required|min_length[8]',
                    'password_confirm' => 'required|matches[new_password]'
                ];
                $messages = [
                    'password' => [
                        'required' => 'Debe ingresar su contraseña actual',
                        'validatePass' => 'Su contraseña es erronea',
                    ],
                    'new_password' => [
                        'required' => 'Debe ingresar su nueva contraseña',
                        'min_length' => 'Su contraseña debe tener como minimo 8 caracteres'
                    ],
                    'password_confirm' => [
                        'required' => 'Debe confirmar su contraseña',
                        'matches' => 'Su contraseña no coincide'
                    ]
                ];
            }
            if (!$this->validate($rules, $messages)) {
                $msg['error'] = [
                    'nombre' => $this->validator->getError('nombre'),
                    'apellido' => $this->validator->getError('apellido'),
                    'email' => $this->validator->getError('email'),
                    'password' => $this->validator->getError('password'),
                    'new_password' => $this->validator->getError('new_password'),
                    'password_confirm' => $this->validator->getError('password_confirm'),
                ];
            } else {
                $usuarioModel = new UsuarioModel();
                $datos = [
                    'nombre' => $this->request->getPost('nombre'),
                    'apellido' => $this->request->getPost('apellido'),
                    'email' => $this->request->getPost('email'),
                ];
                if($this->request->getPost('password')){
                    $datos['password'] = $this->request->getPost('new_password');
                }
                $usuarioModel->update($id, $datos);
                $msg['success'] = "Usuario #{$id} modificado exitosamente";
            }
            return json_encode($msg);
        }
    }

    public function borrar()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getVar('id');
			$usuarioModel = new UsuarioModel();

			$data = $usuarioModel->withDeleted()->find($id);
			$msg['success'] = view("Usuario/usuario_borrar", $data);
			return json_encode($msg);
		}
	}

	public function delete()
	{
		if ($this->request->isAJAX()) {
			$usuarioModel = new UsuarioModel();
			$id = $this->request->getVar('id');
			$usuario = $usuarioModel->withDeleted()->find($id);
			if ($usuario) {
				if ($usuario['deleted_at'] === null) {
					$usuarioModel->delete($id);
					$msg['success'] = "Usuario #{$id} desactivado";
				} else {
					$usuarioModel->update($id, ['deleted_at' => null]);
					$msg['success'] = "Usuario #{$id} activado";
				}
			} else {
				$msg['error'] = "Error al intentar modificar Usuario #{$id}";
			}
			return json_encode($msg);
		}
	}

    public function logout()
    {
        session()->destroy();
        return redirect()->route('login');
    }
}
