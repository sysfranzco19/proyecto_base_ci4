<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitSeed extends Seeder
{
    public function run()
    {
        //Primer usuario Administrador
		$data = [
			'username' 	=> 'admin', //Recuerde cambiar
			'nombre'    => '',
			'apellido' 	=> '',
            'email' 	=> 'admin@mail.com',
			'admin'		=> 1, //Administrador se indentifica con un 1
			'password'  => password_hash('1234', PASSWORD_DEFAULT), //Contraseña por defecto 1234 RECUERDE CAMBIAR
			'created_at' => date("Y-m-d H:i:s")
		];
		$this->db->table('usuario')->insert($data);
    }
}
