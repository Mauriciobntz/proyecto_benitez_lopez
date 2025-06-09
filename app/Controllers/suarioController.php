<?php
namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Session\Session;

class UsuarioController extends BaseController
{
    protected $session;
    protected $usuarioModel;

    public function __construct()
    {
        $this->session = session();
        $this->usuarioModel = new UsuarioModel();
    }
    
public function showRegisterForm()
    {
        $data['titulo'] = 'Sign';
        return view('header', $data).view('navbar').view('sign').view('footer');
    }

    public function processRegistration()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('sign');
        }
        
        // Validación
        $rules = $this->usuarioModel->getRegistrationRules();
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                            ->withInput()
                            ->with('errors', $this->validator->getErrors());
        }

        // Insertar el nuevo usuario
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password_hash' => $this->request->getPost('password'), // El modelo hasheará la contraseña
            'rol' => 'cliente'
        ];

        if ($this->usuarioModel->insert($data)) {
            return redirect()->to('login')
                            ->with('message', '¡Registro exitoso! Ahora puedes iniciar sesión.');
        } else {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Ocurrió un error al registrar el usuario');
        }
    }

    public function showLoginForm()
    {
        $data['titulo'] = 'Login';
        return view('header', $data).view('navbar').view('login').view('footer');
    }

    public function processLogin()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('login');
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('pass');

        // Validación básica
        $rules = [
            'email' => 'required|valid_email',
            'pass' => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                            ->withInput()
                            ->with('errors', $this->validator->getErrors());
        }

        // Buscar usuario por email
        $usuario = $this->usuarioModel->findByEmail($email);

        if (!$usuario || !password_verify($password, $usuario['password_hash'])) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Credenciales incorrectas');
        }

        // Crear sesión
        $sessionData = [
            'id_usuario' => $usuario['id_usuario'],
            'username' => $usuario['username'],
            'email' => $usuario['email'],
            'rol' => $usuario['rol'],
            'logged_in' => true
        ];

        $this->session->set($sessionData);

        return redirect()->to('principal')->with('message', 'Bienvenido '.$usuario['username']);
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('login')->with('message', 'Has cerrado sesión correctamente');
    }
}

