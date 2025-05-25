<?php namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class UsuarioController extends Controller
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        helper(['form']);
    }

    // Listar usuarios
    public function index()
    {
        $data['usuarios'] = $this->usuarioModel->findAll();
        return view('usuarios/index', $data);
    }

    // Mostrar formulario de registro
    public function create()
    {
        return view('usuarios/create');
    }
public function register()
{
    // Añadir regla de confirmación de contraseña
    $rules = array_merge($this->usuarioModel->validationRules, [
        'password_confirm' => 'required|matches[password]'
    ]);
    
    $messages = array_merge($this->usuarioModel->validationMessages, [
        'password_confirm' => [
            'required' => 'La confirmación de contraseña es requerida',
            'matches' => 'Las contraseñas no coinciden'
        ]
    ]);

    if (!$this->validate($rules, $messages)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $data = [
        'username' => $this->request->getPost('username'),
        'email' => $this->request->getPost('email'),
        'contraseña_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
    ];

    $this->usuarioModel->save($data);

    return redirect()->to('/login')->with('success', 'Registro exitoso. Por favor inicie sesión.');
}
}