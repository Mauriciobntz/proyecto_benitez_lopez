<?php namespace App\Controllers;

use App\Models\CarritoModel;
use App\Models\ProductoModel;

class CarritoController extends BaseController
{
    protected $carritoModel;
    protected $productoModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->productoModel = new ProductoModel();
    }

    public function agregar($producto_id)
    {
        // Obtener el carrito del usuario (simplificado)
        $usuario_id = session()->get('usuario_id');
        $carrito = $this->carritoModel->where('usuario_id', $usuario_id)->first();

        if (!$carrito) {
            $carrito_id = $this->carritoModel->insert(['usuario_id' => $usuario_id]);
        } else {
            $carrito_id = $carrito->id_carrito;
        }

        // Agregar producto al carrito
        $this->carritoModel->agregarProducto($carrito_id, $producto_id, 1);

        return redirect()->back()->with('message', 'Producto agregado al carrito');
    }

    public function ver()
    {
        $usuario_id = session()->get('usuario_id');
        $carrito = $this->carritoModel->where('usuario_id', $usuario_id)->first();

        if ($carrito) {
            $data['items'] = $this->carritoModel->items($carrito->id_carrito);
        } else {
            $data['items'] = [];
        }

        return view('carrito/ver', $data);
    }
}