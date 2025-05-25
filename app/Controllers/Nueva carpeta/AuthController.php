<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function sign()
    {
        return view('sign');
    }

    public function register()
    {
        $usuarioModel = new UsuarioModel();
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol' => 'usuario'
        ];
        $usuarioModel->insert($data);
        return redirect()->to('login');
    }

    public function authenticate()
    {
        $usuarioModel = new UsuarioModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $usuario = $usuarioModel->where('email', $email)->first();
        if ($usuario && password_verify($password, $usuario['password'])) {
            $session = session();
            $session->set('usuario_id', $usuario['id']);
            $session->set('usuario_nombre', $usuario['nombre']);
            $session->set('usuario_rol', $usuario['rol']);
            return redirect()->to('/');
        }
        return redirect()->to('login');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
} 