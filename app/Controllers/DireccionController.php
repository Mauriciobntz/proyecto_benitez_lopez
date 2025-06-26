<?php
namespace App\Controllers;

use App\Models\DireccionModel;

class DireccionController extends BaseController
{
    protected $direccionModel;
    protected $validationRules;
    protected $validationMessages;

    public function __construct()
    {
        $this->direccionModel = new DireccionModel();
        helper(['form', 'url']);
        
        // Definir reglas de validación
        $this->validationRules = [
            'tipo' => 'required|in_list[particular,fiscal,envio,trabajo]',
            'alias' => 'required|min_length[3]|max_length[50]',
            'direccion' => 'required|min_length[10]|max_length[255]',
            'codigo_postal' => 'required|numeric|min_length[4]|max_length[10]',
            'ciudad' => 'required|min_length[3]|max_length[100]|alpha_space',
            'provincia' => 'required|min_length[3]|max_length[100]|alpha_space',
            'pais' => 'permit_empty|max_length[50]|alpha_space',
            'es_principal' => 'permit_empty|in_list[0,1]'
        ];
        
        // Mensajes personalizados
        $this->validationMessages = [
            'tipo' => [
                'required' => 'El tipo de dirección es obligatorio',
                'in_list' => 'Seleccione un tipo de dirección válido'
            ],
            'alias' => [
                'required' => 'El alias es obligatorio',
                'min_length' => 'El alias debe tener al menos 3 caracteres',
                'max_length' => 'El alias no puede exceder los 50 caracteres'
            ],
            'direccion' => [
                'required' => 'La dirección es obligatoria',
                'min_length' => 'La dirección debe tener al menos 10 caracteres',
                'max_length' => 'La dirección no puede exceder los 255 caracteres'
            ],
            'codigo_postal' => [
                'required' => 'El código postal es obligatorio',
                'numeric' => 'El código postal debe contener solo números',
                'min_length' => 'El código postal debe tener al menos 4 dígitos',
                'max_length' => 'El código postal no puede exceder los 10 dígitos'
            ],
            'ciudad' => [
                'required' => 'La ciudad es obligatoria',
                'min_length' => 'La ciudad debe tener al menos 3 caracteres',
                'max_length' => 'La ciudad no puede exceder los 100 caracteres',
                'alpha_space' => 'La ciudad solo puede contener letras y espacios'
            ],
            'provincia' => [
                'required' => 'La provincia es obligatoria',
                'min_length' => 'La provincia debe tener al menos 3 caracteres',
                'max_length' => 'La provincia no puede exceder los 100 caracteres',
                'alpha_space' => 'La provincia solo puede contener letras y espacios'
            ],
            'pais' => [
                'max_length' => 'El país no puede exceder los 50 caracteres',
                'alpha_space' => 'El país solo puede contener letras y espacios'
            ]
        ];
    }

    public function listar()
    {
        $usuario_id = session()->get('id_usuario');
        $direcciones = $this->direccionModel->getDireccionesByUsuario($usuario_id);
        
        $data = [
            'titulo' => 'Mis Direcciones',
            'direcciones' => $direcciones
        ];

        return view('header', $data) . view('navbar') . view('direcciones') . view('footer');
    }

    public function crear()
    {
        $validation = \Config\Services::validation();
        $validation->setRules($this->validationRules, $this->validationMessages);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $usuario_id = session()->get('id_usuario');
        $es_principal = $this->request->getPost('es_principal') ? 1 : 0;

        $data = [
            'usuario_id' => $usuario_id,
            'tipo' => $this->request->getPost('tipo'),
            'alias' => $this->request->getPost('alias'),
            'direccion' => $this->request->getPost('direccion'),
            'codigo_postal' => $this->request->getPost('codigo_postal'),
            'ciudad' => $this->request->getPost('ciudad'),
            'provincia' => $this->request->getPost('provincia'),
            'pais' => $this->request->getPost('pais') ?? 'Argentina',
            'es_principal' => $es_principal
        ];

        $this->direccionModel->insert($data);

        if ($es_principal) {
            $this->direccionModel->setDireccionPrincipal($this->direccionModel->getInsertID(), $usuario_id);
        }

        return redirect()->to('direcciones')->with('message', 'Dirección agregada correctamente');
    }

    public function setPrincipal($direccion_id)
    {
        $usuario_id = session()->get('id_usuario');
        $this->direccionModel->setDireccionPrincipal($direccion_id, $usuario_id);
        return redirect()->to('direcciones')->with('message', 'Dirección principal actualizada');
    }

    public function eliminar($direccion_id)
    {
        $usuario_id = session()->get('id_usuario');
        $direccion = $this->direccionModel->find($direccion_id);
        
        if (!$direccion || $direccion['usuario_id'] != $usuario_id) {
            return redirect()->to('direcciones')->with('error', 'Dirección no encontrada o no tienes permisos');
        }
        
        $this->direccionModel->delete($direccion_id);
        return redirect()->to('direcciones')->with('message', 'Dirección eliminada correctamente');
    }

    public function editar($direccion_id)
    {
        $usuario_id = session()->get('id_usuario');
        $direccion = $this->direccionModel->find($direccion_id);
        
        if (!$direccion || $direccion['usuario_id'] != $usuario_id) {
            return redirect()->to('direcciones')->with('error', 'Dirección no encontrada o no tienes permisos');
        }

        $data = [
            'titulo' => 'Editar Dirección',
            'direccion' => $direccion
        ];

        return view('header', $data) . view('navbar') . view('editar_direccion') . view('footer');
    }

    public function actualizar()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'tipo' => 'required|in_list[particular,fiscal,envio,trabajo]',
            'alias' => 'required|min_length[3]|max_length[50]',
            'direccion' => 'required|min_length[10]|max_length[255]',
            'codigo_postal' => 'required|numeric|min_length[4]|max_length[10]',
            'ciudad' => 'required|min_length[3]|max_length[100]|alpha_space',
            'provincia' => 'required|min_length[3]|max_length[100]|alpha_space',
            'pais' => 'permit_empty|max_length[50]|alpha_space',
            'es_principal' => 'permit_empty|in_list[0,1]'
        ], [
            'tipo' => [
                'required' => 'El tipo de dirección es obligatorio',
                'in_list' => 'Seleccione un tipo de dirección válido'
            ],
            'alias' => [
                'required' => 'El alias es obligatorio',
                'min_length' => 'El alias debe tener al menos 3 caracteres',
                'max_length' => 'El alias no puede exceder los 50 caracteres'
            ],
            'direccion' => [
                'required' => 'La dirección es obligatoria',
                'min_length' => 'La dirección debe tener al menos 10 caracteres',
                'max_length' => 'La dirección no puede exceder los 255 caracteres'
            ],
            'codigo_postal' => [
                'required' => 'El código postal es obligatorio',
                'numeric' => 'El código postal debe contener solo números',
                'min_length' => 'El código postal debe tener al menos 4 dígitos',
                'max_length' => 'El código postal no puede exceder los 10 dígitos'
            ],
            'ciudad' => [
                'required' => 'La ciudad es obligatoria',
                'min_length' => 'La ciudad debe tener al menos 3 caracteres',
                'max_length' => 'La ciudad no puede exceder los 100 caracteres',
                'alpha_space' => 'La ciudad solo puede contener letras y espacios'
            ],
            'provincia' => [
                'required' => 'La provincia es obligatoria',
                'min_length' => 'La provincia debe tener al menos 3 caracteres',
                'max_length' => 'La provincia no puede exceder los 100 caracteres',
                'alpha_space' => 'La provincia solo puede contener letras y espacios'
            ],
            'pais' => [
                'max_length' => 'El país no puede exceder los 50 caracteres',
                'alpha_space' => 'El país solo puede contener letras y espacios'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $direccion_id = $this->request->getPost('direccion_id');
        $usuario_id = session()->get('id_usuario');
        $es_principal = $this->request->getPost('es_principal') ? 1 : 0;

        $data = [
            'alias' => $this->request->getPost('alias'),
            'direccion' => $this->request->getPost('direccion'),
            'codigo_postal' => $this->request->getPost('codigo_postal'),
            'ciudad' => $this->request->getPost('ciudad'),
            'provincia' => $this->request->getPost('provincia'),
            'pais' => $this->request->getPost('pais') ?? 'Argentina',
            'es_principal' => $es_principal
        ];

        if ($es_principal) {
            $this->direccionModel->setDireccionPrincipal($direccion_id, $usuario_id);
        }

        $this->direccionModel->update($direccion_id, $data);

        return redirect()->to('direcciones')->with('message', 'Dirección actualizada correctamente');
    }
}