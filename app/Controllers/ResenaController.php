<?php namespace App\Controllers;

use App\Models\ResenaModel;
use App\Models\ProductoModel;

class ResenaController extends BaseController
{
    protected $resenaModel;
    protected $productoModel;

    public function __construct()
    {
        $this->resenaModel = new ResenaModel();
        $this->productoModel = new ProductoModel();
    }

    public function crear($producto_id)
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'producto_id' => $producto_id,
                'usuario_id' => session()->get('usuario_id'),
                'calificacion' => $this->request->getPost('calificacion'),
                'comentario' => $this->request->getPost('comentario')
            ];

            $this->resenaModel->save($data);
            return redirect()->to("/productos/$producto_id")->with('message', 'Reseña agregada');
        }

        $data['producto'] = $this->productoModel->find($producto_id);
        return view('resenas/crear', $data);
    }

    public function porProducto($producto_id)
    {
        $data['resenas'] = $this->resenaModel->delProducto($producto_id);
        $data['producto'] = $this->productoModel->find($producto_id);
        return view('resenas/por_producto', $data);
    }
}