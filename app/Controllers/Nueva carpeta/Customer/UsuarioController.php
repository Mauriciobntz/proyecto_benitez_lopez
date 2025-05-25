<?php namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\PersonaModel;

class UsuarioController extends BaseController
{
    protected $usuarioModel;
    protected $personaModel;
    
    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->personaModel = new PersonaModel();
    }

    /**
     * Muestra el perfil del usuario
     */
    public function profile()
    {
        $usuario_id = session()->get('id_usuario');
        $usuario = $this->usuarioModel->find($usuario_id);
        $persona = $this->personaModel->getByUsuario($usuario_id);

        return view('customer/usuario/profile', [
            'usuario' => $usuario,
            'persona' => $persona
        ]);
    }

    /**
     * Actualiza los datos básicos del usuario
     */
    public function updateProfile()
    {
        $usuario_id = session()->get('id_usuario');
        
        $rules = [
            'username' => "permit_empty|min_length[3]|max_length[50]|is_unique[usuarios.username,id_usuario,{$usuario_id}]",
            'email' => "required|valid_email|is_unique[usuarios.email,id_usuario,{$usuario_id}]",
            'nombre' => 'permit_empty|max_length[100]',
            'apellido' => 'permit_empty|max_length[100]',
            'telefono' => 'required|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Actualizar datos de usuario
        $this->usuarioModel->update($usuario_id, [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email')
        ]);

        // Actualizar o crear datos personales
        $personaData = [
            'usuario_id' => $usuario_id,
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'telefono' => $this->request->getPost('telefono'),
            'telefono_alternativo' => $this->request->getPost('telefono_alternativo')
        ];

        $persona = $this->personaModel->getByUsuario($usuario_id);
        if ($persona) {
            $this->personaModel->update($persona->id_persona, $personaData);
        } else {
            $this->personaModel->insert($personaData);
        }

        return redirect()->to('/perfil')->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Actualiza la contraseña del usuario
     */
    public function updatePassword()
    {
        $usuario_id = session()->get('id_usuario');
        
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $usuario = $this->usuarioModel->find($usuario_id);

        // Verificar contraseña actual
        if (!password_verify($this->request->getPost('current_password'), $usuario->contraseña_hash)) {
            return redirect()->back()
                ->with('error', 'La contraseña actual no es correcta');
        }

        // Actualizar contraseña
        $this->usuarioModel->update($usuario_id, [
            'contraseña_hash' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/perfil')->with('success', 'Contraseña actualizada correctamente');
    }

    /**
     * Desactiva la cuenta del usuario (soft delete)
     */
    public function deactivateAccount()
    {
        $usuario_id = session()->get('id_usuario');
        
        // Verificar contraseña
        $rules = [
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('error', 'Debes ingresar tu contraseña para confirmar');
        }

        $usuario = $this->usuarioModel->find($usuario_id);

        if (!password_verify($this->request->getPost('password'), $usuario->contraseña_hash)) {
            return redirect()->back()
                ->with('error', 'Contraseña incorrecta');
        }

        // Desactivar cuenta (soft delete)
        $this->usuarioModel->delete($usuario_id);

        // Cerrar sesión
        session()->destroy();

        return redirect()->to('/')->with('success', 'Tu cuenta ha sido desactivada. Lamentamos que te vayas.');
    }

    /**
     * Muestra el historial de pedidos del usuario
     */
    public function orderHistory()
    {
        $usuario_id = session()->get('id_usuario');
        $pedidos = model('PedidoModel')
            ->where('usuario_id', $usuario_id)
            ->orderBy('fecha_pedido', 'DESC')
            ->findAll();

        return view('customer/usuario/order_history', [
            'pedidos' => $pedidos
        ]);
    }

    /**
     * Muestra las reseñas del usuario
     */
    public function myReviews()
    {
        $usuario_id = session()->get('id_usuario');
        $resenas = model('ResenaModel')
            ->where('usuario_id', $usuario_id)
            ->orderBy('fecha', 'DESC')
            ->findAll();

        return view('customer/usuario/my_reviews', [
            'resenas' => $resenas
        ]);
    }
}