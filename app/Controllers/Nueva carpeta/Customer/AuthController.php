<?php namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class AuthController extends BaseController
{
    protected $usuarioModel;
    
    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }
    
    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            
            $usuario = $this->usuarioModel->where('email', $email)->first();
            
            if ($usuario && password_verify($password, $usuario->contraseña_hash)) {
                // Establecer sesión
                $session = session();
                $session->set([
                    'id_usuario' => $usuario->id_usuario,
                    'email' => $usuario->email,
                    'rol' => $usuario->rol,
                    'logged_in' => true
                ]);
                
                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', 'Credenciales incorrectas');
            }
        }
        
        return view('login');
    }
    
    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            // Validar datos
            $rules = [
                'username' => 'required|min_length[3]|is_unique[usuarios.username]',
                'email' => 'required|valid_email|is_unique[usuarios.email]',
                'password' => 'required|min_length[8]',
                'password_confirm' => 'required|matches[password]'
            ];
            
            if (!$this->validate($rules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }
            
            // Preparar datos para guardar
            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'contraseña_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'rol' => 'cliente' // Rol por defecto
            ];
            
            try {
                if ($this->usuarioModel->save($data)) {
                    return redirect()->to('/login')
                        ->with('success', 'Registro exitoso. Por favor inicia sesión.');
                } else {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Error al crear la cuenta. Por favor intente nuevamente.');
                }
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Error al crear la cuenta: ' . $e->getMessage());
            }
        }
        
        return view('sign');
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}