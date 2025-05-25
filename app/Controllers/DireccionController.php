<?php namespace App\Controllers;

use App\Models\DireccionModel;

class DireccionController extends BaseController
{
    protected $direccionModel;

    public function __construct()
    {
        $this->direccionModel = new DireccionModel();
    }

    public function guardar()
    {
        $usuario_id = session()->get('usuario_id');

        $data = [
            'usuario_id' => $usuario_id,
            'direccion' => $this->request->getPost('direccion'),
            'ciudad' => $this->request->getPost('ciudad'),
            'codigo_postal' => $this->request->getPost('codigo_postal')
        ];

        $this->direccionModel->save($data);
        return redirect()->to('/perfil')->with('message', 'Dirección guardada');
    }

    public function listar($usuario_id)
    {
        $data['direcciones'] = $this->direccionModel->delUsuario($usuario_id);
        return view('direcciones/listar', $data);
    }
}