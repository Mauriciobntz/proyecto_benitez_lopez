<?php namespace App\Controllers\Admin;

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
        
        // Verificar rol de administrador
        if (session()->get('rol') != 'admin') {
            throw new \CodeIgniter\Exceptions\PageForbiddenException();
        }
    }

    /**
     * Listado de usuarios con paginación
     */
    public function index()
    {
        $perPage = 20;
        $currentPage = $this->request->getVar('page') ?? 1;
        
        $usuarios = $this->usuarioModel
            ->select('usuarios.*, personas.nombre, personas.apellido')
            ->join('personas', 'personas.usuario_id = usuarios.id_usuario', 'left')
            ->orderBy('usuarios.created_at', 'DESC')
            ->paginate($perPage, 'default', $currentPage);
            
        $pager = $this->usuarioModel->pager;

        return view('admin/usuarios/index', [
            'usuarios' => $usuarios,
            'pager' => $pager
        ]);
    }

    /**
     * Crear nuevo usuario desde admin
     */
    public function create()
    {
        return view('admin/usuarios/create');
    }

    public function store()
    {
        $rules = [
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'username' => 'permit_empty|min_length[3]|is_unique[usuarios.username]',
            'password' => 'required|min_length[8]',
            'rol' => 'required|in_list[admin,cliente,editor]',
            'nombre' => 'required|max_length[100]',
            'apellido' => 'required|max_length[100]',
            'telefono' => 'required|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Crear usuario
        $usuarioData = [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'contraseña_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol' => $this->request->getPost('rol')
        ];

        $this->db->transStart();
        
        $usuarioId = $this->usuarioModel->insert($usuarioData);
        
        // Crear datos personales
        $personaData = [
            'usuario_id' => $usuarioId,
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'telefono' => $this->request->getPost('telefono'),
            'tipo_documento' => $this->request->getPost('tipo_documento'),
            'documento' => $this->request->getPost('documento')
        ];
        
        $this->personaModel->insert($personaData);
        
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el usuario');
        }

        return redirect()->to("/admin/usuarios/{$usuarioId}")
            ->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Mostrar detalles de usuario
     */
    public function show($id)
    {
        $usuario = $this->usuarioModel
            ->select('usuarios.*, personas.*')
            ->join('personas', 'personas.usuario_id = usuarios.id_usuario', 'left')
            ->find($id);

        if (!$usuario) {
            return redirect()->to('/admin/usuarios')
                ->with('error', 'Usuario no encontrado');
        }

        // Obtener estadísticas del usuario
        $pedidos = model('PedidoModel')->where('usuario_id', $id)->countAllResults();
        $resenas = model('ResenaModel')->where('usuario_id', $id)->countAllResults();

        return view('admin/usuarios/show', [
            'usuario' => $usuario,
            'pedidos' => $pedidos,
            'resenas' => $resenas
        ]);
    }

    /**
     * Editar usuario
     */
    public function edit($id)
    {
        $usuario = $this->usuarioModel
            ->select('usuarios.*, personas.*')
            ->join('personas', 'personas.usuario_id = usuarios.id_usuario', 'left')
            ->find($id);

        if (!$usuario) {
            return redirect()->to('/admin/usuarios')
                ->with('error', 'Usuario no encontrado');
        }

        return view('admin/usuarios/edit', ['usuario' => $usuario]);
    }

    public function update($id)
    {
        $rules = [
            'email' => "required|valid_email|is_unique[usuarios.email,id_usuario,{$id}]",
            'username' => "permit_empty|min_length[3]|is_unique[usuarios.username,id_usuario,{$id}]",
            'rol' => 'required|in_list[admin,cliente,editor]',
            'nombre' => 'required|max_length[100]',
            'apellido' => 'required|max_length[100]',
            'telefono' => 'required|max_length[20]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Actualizar usuario
        $usuarioData = [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'rol' => $this->request->getPost('rol')
        ];

        // Actualizar contraseña si se proporcionó
        if ($this->request->getPost('password')) {
            $usuarioData['contraseña_hash'] = password_hash(
                $this->request->getPost('password'), 
                PASSWORD_DEFAULT
            );
        }

        $this->db->transStart();
        
        $this->usuarioModel->update($id, $usuarioData);
        
        // Actualizar datos personales
        $personaData = [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'telefono' => $this->request->getPost('telefono'),
            'tipo_documento' => $this->request->getPost('tipo_documento'),
            'documento' => $this->request->getPost('documento')
        ];
        
        $persona = $this->personaModel->where('usuario_id', $id)->first();
        if ($persona) {
            $this->personaModel->update($persona->id_persona, $personaData);
        } else {
            $personaData['usuario_id'] = $id;
            $this->personaModel->insert($personaData);
        }
        
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el usuario');
        }

        return redirect()->to("/admin/usuarios/{$id}")
            ->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Eliminar usuario (soft delete)
     */
    public function delete($id)
    {
        if ($this->usuarioModel->delete($id)) {
            return redirect()->to('/admin/usuarios')
                ->with('success', 'Usuario desactivado correctamente');
        }

        return redirect()->back()
            ->with('error', 'Error al desactivar el usuario');
    }

    /**
     * Restaurar usuario eliminado
     */
    public function restore($id)
    {
        if ($this->usuarioModel->restore($id)) {
            return redirect()->to("/admin/usuarios/{$id}")
                ->with('success', 'Usuario reactivado correctamente');
        }

        return redirect()->back()
            ->with('error', 'Error al reactivar el usuario');
    }

    /**
     * Buscar usuarios (para AJAX)
     */
    public function search()
    {
        $term = $this->request->getVar('term');
        
        $usuarios = $this->usuarioModel
            ->select('id_usuario, email, username')
            ->groupStart()
                ->like('email', $term)
                ->orLike('username', $term)
            ->groupEnd()
            ->where('deleted_at', null)
            ->limit(10)
            ->findAll();

        return $this->response->setJSON($usuarios);
    }
}