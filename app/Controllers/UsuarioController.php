<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Config\Services;
use App\Controllers\BaseController;
use App\Models\ConsultaModel;

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

        $consultaModel = new \App\Models\ConsultaModel();
        $consultas_sin_leer = $consultaModel->contarSinLeer();
        $session->set('consultas_sin_leer', $consultas_sin_leer);

        
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

    // Método listarUsuarios actualizado
    public function listarUsuarios()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para esta sección');
        }

        $request = service('request');
        $filtros = [
            'q' => $request->getGet('q'),
            'rol' => $request->getGet('rol'),
            'desde' => $request->getGet('desde')
        ];

        $this->usuarioModel = new \App\Models\UsuarioModel();
        $usuarios = $this->usuarioModel->getUsuariosConFiltros($filtros);

        $data = [
            'titulo' => 'Gestión de Usuarios',
            'usuarios' => $usuarios,
            'request' => $request
        ];

        return view('header', $data) . view('navbar') . view('admin/usuarios/listar', $data) . view('footer');
    }

    // Mostrar formulario para editar usuario
    public function editarUsuario($usuario_id = null)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para esta acción');
        }

        $this->usuarioModel = new \App\Models\UsuarioModel(); // Agrega esta línea

        $usuario = $this->usuarioModel->getUsuarioCompleto($usuario_id);

        if (!$usuario) {
            return redirect()->to('admin/usuarios')->with('error', 'Usuario no encontrado');
        }

        $data = [
            'titulo' => 'Editar Usuario: ' . ($usuario['persona']['nombre'] ?? $usuario['username']),
            'usuario' => $usuario,
            'validation' => session()->get('validation')
        ];

        return view('header', $data) . view('navbar') . view('admin/usuarios/editar') . view('footer');
    }

    // Procesar actualización de usuario
// Método actualizarUsuario modificado para ser consistente con VentaController
public function actualizarUsuario($usuario_id)
{
    // Verificar permisos
    if (session()->get('rol') !== 'admin') {
        return redirect()->to('denegado')->with('error', 'No tienes permisos para esta acción');
    }

    // Validar que el ID existe
    if (!$usuario_id) {
        return redirect()->to('admin/usuarios/listar')->with('error', 'ID de usuario no proporcionado');
    }

    $this->usuarioModel = new \App\Models\UsuarioModel();
    $usuario = $this->usuarioModel->find($usuario_id);

    // Verificar que el usuario existe
    if (!$usuario) {
        return redirect()->to('admin/usuarios/listar')->with('error', 'Usuario no encontrado');
    }

    // Configurar reglas de validación
    $validation = \Config\Services::validation();
    $request = \Config\Services::request();

    $validation->setRules([
        'username' => [
            'label' => 'Nombre de usuario',
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'El nombre de usuario es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no debe exceder los 255 caracteres.',
            ]
        ],
        'email' => [
            'label' => 'Correo electrónico',
            'rules' => "required|valid_email|max_length[255]|is_unique[usuarios.email,id_usuario,{$usuario_id}]",
            'errors' => [
                'required' => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Debe ser un correo válido.',
                'max_length' => 'No debe superar los 255 caracteres.',
                'is_unique' => 'Este correo ya está registrado por otro usuario.'
            ]
        ],
        'rol' => [
            'label' => 'Rol',
            'rules' => 'required|in_list[admin,cliente]',
            'errors' => [
                'required' => 'El rol es obligatorio.',
                'in_list' => 'Rol inválido.',
            ]
        ],
    ]);

    // Ejecutar validación
    if (!$validation->withRequest($request)->run()) {
        return redirect()->back()
            ->withInput()
            ->with('validation', $validation);
    }

    // Preparar datos para actualización
    $datosActualizados = [
        'username' => $request->getPost('username'),
        'email' => $request->getPost('email'),
        'rol' => $request->getPost('rol'),
    ];

    // Actualizar datos personales si existen
    $db = \Config\Database::connect();
    $persona = $db->table('personas')->where('usuario_id', $usuario_id)->get()->getRowArray();

    if ($persona) {
        $datosPersona = [
            'nombre' => $request->getPost('nombre'),
            'apellido' => $request->getPost('apellido'),
            'tipo_documento' => $request->getPost('tipo_documento'),
            'documento' => $request->getPost('documento'),
            'telefono' => $request->getPost('telefono'),
        ];

        $db->table('personas')
            ->where('usuario_id', $usuario_id)
            ->update($datosPersona);
    }

    // Actualizar usuario
    if ($this->usuarioModel->update($usuario_id, $datosActualizados)) {
        return redirect()->to('admin/usuarios/listar')->with('message', 'Usuario actualizado correctamente');
    } else {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Ocurrió un error al actualizar el usuario');
    }
}


    // Buscar usuarios (para admin)
    public function buscarUsuarios()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para esta acción');
        }

        $termino = $this->request->getGet('q');
        $usuarios = $this->usuarioModel->buscarUsuarios($termino);

        $data = [
            'titulo' => 'Resultados de búsqueda: ' . $termino,
            'usuarios' => $usuarios,
            'termino' => $termino
        ];

        return view('header', $data) . view('navbar') . view('admin/usuarios/busqueda') . view('footer');
    }

    // Mostrar perfil del usuario actual
    public function miPerfil()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $usuario_id = session()->get('id_usuario');
        $usuario = $this->usuarioModel->getUsuarioCompleto($usuario_id);

        $data = [
            'titulo' => 'Mi Perfil',
            'usuario' => $usuario,
            'validation' => session()->get('validation')
        ];

        return view('header', $data) . view('navbar') . view('usuario/perfil') . view('footer');
    }


}