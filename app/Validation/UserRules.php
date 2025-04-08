<?php

namespace App\Validation;

use App\Models\UsuarioModel;

class UserRules
{
    public function validateUser(string $str, string $fields, array $data) {
        $model = new UsuarioModel();
        $user = $model->where('email', $data['email'])->where('deleted_at',null)
                ->first();
        if (!$user) {
            return false;
        }
        return password_verify($data['password'], $user['password']);
    }
    public function validatePass(string $str, string $fields, array $data) {
        $model = new UsuarioModel();
        $user = $model->where('id', $data['id'])
                ->first();

        if (!$user) {
            return false;
        }
        return password_verify($data['password'], $user['password']);
    }
}
