<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Config\Services;

class UsuarioController extends BaseController
{
    protected $session;
    protected $usuarioModel;


    public function formularioLogin(): string
    {
        $data['titulo'] = 'Iniciar Sesión';
        return view('header', $data).view('navbar').view('login').view('footer');
    }

    public function procesarLogin()
    {
        $this->usuarioModel = new UsuarioModel();
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();
        $session = session();

        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ], [
            'email' => [
                'required' => 'El correo es obligatorio',
                'valid_email' => 'La dirección de correo debe ser válida'
            ],
            'password' => [
                'required' => 'La contraseña es obligatoria',
                'min_length' => 'La contraseña debe tener como mínimo 8 caracteres'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            $data['titulo'] = 'Iniciar Sesión';
            $data['validation'] = $validation->getErrors();
            return view('header', $data).view('navbar').view('login').view('footer');
        }

        $email = $request->getPost('email');
        $password = $request->getPost('password');

        $usuario = $this->usuarioModel->where('email', $email)->first();
        
        if ($usuario && password_verify($password, $usuario['password_hash'])) {
            $data = [
                'id_usuario' => $usuario['id_usuario'],
                'email' => $usuario['email'],
                'username' => $usuario['username'],
                'rol' => $usuario['rol'],
                'logged_in' => TRUE
            ];

            $session->set($data);

        if ($usuario['rol'] === 'admin') {
            return redirect()->to('panel')->with('message_welcome', 'Bienvenido '.$usuario['username']);
        } else {
            return redirect()->to('principal')->with('message_welcome', 'Bienvenido '.$usuario['username']);
        }
    } else {
        return redirect()->to('login')->with('error', 'Usuario y/o contraseña incorrectos');
    }
    }

    public function cerrarSesion()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('login');
    }

    public function formularioRegistro(): string
    {
        $data['titulo'] = 'Registro de Usuario';
        return view('header', $data).view('navbar').view('sign').view('footer');
    }

    public function procesarRegistro()
    {
        $this->usuarioModel = new UsuarioModel();
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'username' => 'required|min_length[4]|is_unique[usuarios.username]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]'
        ], [
            'email' => [
                'required' => 'El correo es obligatorio',
                'valid_email' => 'La dirección de correo debe ser válida',
                'is_unique' => 'Este correo ya está registrado'
            ],
            'username' => [
                'required' => 'El nombre de usuario es obligatorio',
                'min_length' => 'El nombre de usuario debe tener al menos 4 caracteres',
                'is_unique' => 'Este nombre de usuario ya está en uso'
            ],
            'password' => [
                'required' => 'La contraseña es obligatoria',
                'min_length' => 'La contraseña debe tener como mínimo 8 caracteres'
            ],
            'confirm_password' => [
                'required' => 'Debes confirmar la contraseña',
                'matches' => 'Las contraseñas no coinciden'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            $data['titulo'] = 'Registro de Usuario';
            $data['validation'] = $validation;
            return view('header', $data).view('navbar').view('sign').view('footer');
        }

        $data = [
            'username' => $request->getPost('username'),
            'email' => $request->getPost('email'),
            'password_hash' => password_hash($request->getPost('password'), PASSWORD_DEFAULT),
            'rol' => 'cliente'
        ];

        if ($this->usuarioModel->insert($data)) {
            return redirect()->to('login')->with('message', '¡Registro exitoso! Ahora puedes iniciar sesión.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al registrar el usuario');
        }
    }
}