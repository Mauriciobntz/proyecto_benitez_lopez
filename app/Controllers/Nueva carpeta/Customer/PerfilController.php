<?php namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\PersonaModel;
use App\Models\DireccionModel;

class PerfilController extends BaseController
{
    protected $usuarioModel;
    protected $personaModel;
    protected $direccionModel;
    
    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->personaModel = new PersonaModel();
        $this->direccionModel = new DireccionModel();
    }
    
    public function index()
    {
        $usuario_id = session()->get('id_usuario');
        
        $data = [
            'usuario' => $this->usuarioModel->find($usuario_id),
            'persona' => $this->personaModel->getByUsuario($usuario_id),
            'direcciones' => $this->direccionModel->getByUsuario($usuario_id)
        ];
        
        return view('customer/perfil/index', $data);
    }
    
    public function update()
    {
        $usuario_id = session()->get('id_usuario');
        $rules = [
            'username' => 'permit_empty|min_length[3]|max_length[50]',
            'email' => "required|valid_email|is_unique[usuarios.email,id_usuario,$usuario_id]",
            'telefono' => 'required|max_length[20]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Actualizar usuario
        $this->usuarioModel->update($usuario_id, [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username')
        ]);
        
        // Actualizar o crear datos personales
        $persona = $this->personaModel->getByUsuario($usuario_id);
        $personaData = [
            'usuario_id' => $usuario_id,
            'telefono' => $this->request->getPost('telefono'),
            'telefono_alternativo' => $this->request->getPost('telefono_alternativo')
        ];
        
        if ($persona) {
            $this->personaModel->update($persona->id_persona, $personaData);
        } else {
            $this->personaModel->insert($personaData);
        }
        
        return redirect()->to('/perfil')->with('success', 'Perfil actualizado correctamente');
    }
    
    public function updatePassword()
    {
        $usuario_id = session()->get('id_usuario');
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $usuario = $this->usuarioModel->find($usuario_id);
        
        if (!password_verify($this->request->getPost('current_password'), $usuario->contraseña_hash)) {
            return redirect()->back()->with('error', 'La contraseña actual no es correcta');
        }
        
        $this->usuarioModel->update($usuario_id, [
            'contraseña_hash' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT)
        ]);
        
        return redirect()->to('/perfil')->with('success', 'Contraseña actualizada correctamente');
    }
}