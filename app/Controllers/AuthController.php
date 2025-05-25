<?php namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\PersonaModel;

class AuthController extends BaseController
{
    protected $usuarioModel;
    protected $personaModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->personaModel = new PersonaModel();
        helper(['form', 'url']);
    }

    public function sign()
    {
        return view('sign');
    }

    public function register()
    {
        // Reglas de validación
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[usuarios.username]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'matches[password]'
        ];

        // Mensajes de error personalizados
        $errors = [
            'password_confirm' => [
                'matches' => 'Las contraseñas no coinciden'
            ]
        ];

        if (!$this->validate($rules, $errors)) {
            return redirect()->back()
                            ->withInput()
                            ->with('errors', $this->validator->getErrors());
        }

        // Datos del usuario
        $userData = [
    'username'            => $this->request->getPost('username'),
    'email'               => $this->request->getPost('email'),
    'password_hash'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
    'rol'                 => 'cliente',
    'fecha_registro'      => date('Y-m-d H:i:s'),
    'verificado'          => 0,
    'fecha_verificacion'  => null,
    'ultimo_login'        => null,
    'activo'              => 1,
    'token_verificacion'  => bin2hex(random_bytes(16))
];

        // Insertar usuario
        $usuario_id = $this->usuarioModel->insert($userData);

        if ($usuario_id) {
            // Crear registro en Persona (puedes expandir esto con más datos)
            $this->personaModel->save([
                'usuario_id' => $usuario_id,
                'nombre' => $this->request->getPost('username') // Usamos el username como nombre inicial
            ]);

            // Establecer sesión
            $session = session();
            $session->set([
                'usuario_id' => $usuario_id,
                'username' => $userData['username'],
                'email' => $userData['email'],
                'rol' => $userData['rol'],
                'logged_in' => true
            ]);

            return redirect()->to('/')->with('message', '¡Registro exitoso!');
        }

        return redirect()->back()
                        ->withInput()
                        ->with('error', 'Ocurrió un error al registrar el usuario');
    }
}