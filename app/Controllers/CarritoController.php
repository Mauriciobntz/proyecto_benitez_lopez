<?php
namespace App\Controllers;

use App\Models\CarritoModel;
use App\Models\CarritoItemModel;
use App\Models\ProductoModel;

class CarritoController extends BaseController
{
    protected $carritoModel;
    protected $carritoItemModel;
    protected $productoModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->carritoItemModel = new CarritoItemModel();
        $this->productoModel = new ProductoModel();
    }

    public function verCarrito()
    {
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        
        if (!$carrito) {
            return redirect()->to('productos')->with('message', 'Tu carrito está vacío');
        }

        $items = $this->carritoItemModel->getItemsByCarrito($carrito['id_carrito']);
        $productos = [];
        $total = 0;

        foreach ($items as $item) {
            $producto = $this->productoModel->find($item['producto_id']);
            if ($producto) {
                $producto['cantidad'] = $item['cantidad'];
                $producto['subtotal'] = $producto['precio'] * $item['cantidad'];
                $productos[] = $producto;
                $total += $producto['subtotal'];
            }
        }

        $data = [
            'titulo' => 'Mi Carrito',
            'productos' => $productos,
            'total' => $total
        ];

        return view('header', $data) . view('navbar') . view('carrito') . view('footer');
    }

    public function agregarProducto($producto_id)
    {
        $cantidad = $this->request->getPost('cantidad') ?? 1;
        $usuario_id = session()->get('id_usuario');
        
        // Verificar si el usuario tiene carrito
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        if (!$carrito) {
            $carrito_id = $this->carritoModel->crearCarrito($usuario_id);
        } else {
            $carrito_id = $carrito['id_carrito'];
        }

        // Verificar stock
        $producto = $this->productoModel->find($producto_id);
        if (!$producto || $producto['stock'] < $cantidad) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible');
        }

        // Agregar producto al carrito
        $this->carritoItemModel->agregarProducto($carrito_id, $producto_id, $cantidad);
        
        return redirect()->to('carrito')->with('message', 'Producto agregado al carrito');
    }

    public function actualizarCantidad($item_id)
    {
        $cantidad = $this->request->getPost('cantidad');
        $item = $this->carritoItemModel->find($item_id);
        
        if ($item && $cantidad > 0) {
            $producto = $this->productoModel->find($item['producto_id']);
            if ($producto['stock'] >= $cantidad) {
                $this->carritoItemModel->actualizarCantidad($item_id, $cantidad);
                return redirect()->to('carrito')->with('message', 'Cantidad actualizada');
            }
        }
        
        return redirect()->to('carrito')->with('error', 'No hay suficiente stock disponible');
    }

    public function eliminarItem($item_id)
    {
        $this->carritoItemModel->eliminarItem($item_id);
        return redirect()->to('carrito')->with('message', 'Producto eliminado del carrito');
    }

    public function vaciarCarrito()
    {
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        
        if ($carrito) {
            $this->carritoItemModel->vaciarCarrito($carrito['id_carrito']);
            return redirect()->to('carrito')->with('message', 'Carrito vaciado');
        }
        
        return redirect()->to('productos')->with('message', 'Tu carrito ya está vacío');
    }
}