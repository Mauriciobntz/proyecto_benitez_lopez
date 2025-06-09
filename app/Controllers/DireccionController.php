<?php
namespace App\Controllers;

use App\Models\DireccionModel;

class DireccionController extends BaseController
{
    protected $direccionModel;

    public function __construct()
    {
        $this->direccionModel = new DireccionModel();
        helper(['form', 'url']);
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
        $validation->setRules([
            'alias' => 'required|min_length[3]',
            'direccion' => 'required|min_length[10]',
            'codigo_postal' => 'required',
            'ciudad' => 'required',
            'provincia' => 'required'
        ]);

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
            'pais' => $this->request->getPost('pais') ?? 'España',
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
        $this->direccionModel->delete($direccion_id);
        return redirect()->to('direcciones')->with('message', 'Dirección eliminada');
    }
}