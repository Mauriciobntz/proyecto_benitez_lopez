<?php
namespace App\Controllers;

use App\Models\CarritoModel;
use App\Models\CarritoItemModel;
use App\Models\ProductoModel;
use App\Models\VentaModel;
use App\Models\VentaItemModel;
use App\Models\PagoModel;
use App\Models\DireccionEnvioModel;
use App\Models\DireccionModel;
use App\Models\FacturaModel;
use App\Models\HistoricoVentaModel;

class CarritoController extends BaseController
{
    protected $carritoModel;
    protected $carritoItemModel;
    protected $productoModel;
    protected $ventaModel;
    protected $ventaItemModel;
    protected $pagoModel;
    protected $direccionEnvioModel;
    protected $direccionModel;
    protected $facturaModel;
    protected $historicoVentaModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->carritoItemModel = new CarritoItemModel();
        $this->productoModel = new ProductoModel();
        $this->ventaModel = new VentaModel();
        $this->ventaItemModel = new VentaItemModel();
        $this->pagoModel = new PagoModel();
        $this->direccionEnvioModel = new DireccionEnvioModel();
        $this->direccionModel = new DireccionModel();
        $this->facturaModel = new FacturaModel();
        $this->historicoVentaModel = new HistoricoVentaModel();
    }

    // Ver carrito
    public function verCarrito()
    {
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        
        $items = [];
        $total = 0;
        
        if ($carrito) {
            // Limpiar productos desactivados automáticamente
            $productosEliminados = $this->limpiarProductosDesactivados($carrito['id_carrito']);
            
            // Mostrar mensaje si se eliminaron productos
            if (!empty($productosEliminados)) {
                $mensaje = 'Los siguientes productos ya no están disponibles y han sido removidos del carrito: ' . implode(', ', $productosEliminados);
                session()->setFlashdata('warning', $mensaje);
            }
            
            $items = $this->carritoItemModel->getItemsByCarrito($carrito['id_carrito']);
            
            foreach ($items as &$item) {
                $producto = $this->productoModel->find($item['producto_id']);
                if (!$producto) {
                    continue;
                }
                $item['producto'] = $producto;
                $item['subtotal'] = $producto['precio'] * $item['cantidad'];
                $total += $item['subtotal'];
            }
        }
        
        $data = [
            'titulo' => 'Mi Carrito',
            'items' => $items,
            'total' => $total
        ];
        
        return view('header', $data) . view('navbar') . view('usuario/carrito', $data) . view('footer');
    }

    // Agregar producto al carrito
    public function agregarProducto($producto_id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'cantidad' => 'required|numeric|greater_than[0]|less_than[100]'
        ], [
            'cantidad' => [
                'required' => 'La cantidad es requerida',
                'numeric' => 'La cantidad debe ser un número',
                'greater_than' => 'La cantidad debe ser mayor que 0',
                'less_than' => 'La cantidad no puede ser mayor a 99'
            ]
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $cantidad = $this->request->getPost('cantidad') ?? 1;
        $usuario_id = session()->get('id_usuario');
        
        if (!$usuario_id) {
            return redirect()->to('login')->with('error', 'Debes iniciar sesión para agregar productos al carrito');
        }
        
        $producto = $this->productoModel->getProductoActivo($producto_id);
        if (!$producto) {
            return redirect()->back()->with('error', 'El producto no existe o no está disponible');
        }
        
        if ($producto['stock'] < $cantidad) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible. Stock actual: ' . $producto['stock']);
        }
        
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        if (!$carrito) {
            $carrito_id = $this->carritoModel->crearCarrito($usuario_id);
            $carrito = $this->carritoModel->find($carrito_id);
        }
        
        $this->carritoItemModel->agregarProducto($carrito['id_carrito'], $producto_id, $cantidad);
        
        return redirect()->to('carrito')->with('message', 'Producto agregado al carrito');
    }

    // Actualizar cantidad de un item
    public function actualizarCantidad($item_id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'cantidad' => 'required|numeric|greater_than[0]|less_than[100]'
        ], [
            'cantidad' => [
                'required' => 'La cantidad es requerida',
                'numeric' => 'La cantidad debe ser un número',
                'greater_than' => 'La cantidad debe ser mayor que 0',
                'less_than' => 'La cantidad no puede ser mayor a 99'
            ]
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('carrito')->withInput()->with('errors', $validation->getErrors());
        }
        
        $cantidad = $this->request->getPost('cantidad');
        $item = $this->carritoItemModel->find($item_id);
        
        if (!$item) {
            return redirect()->to('carrito')->with('error', 'Ítem no encontrado');
        }
        
        $producto = $this->productoModel->find($item['producto_id']);
        if (!$producto) {
            return redirect()->to('carrito')->with('error', 'Producto no encontrado');
        }
        
        if ($producto['stock'] < $cantidad) {
            return redirect()->to('carrito')->with('error', 'No hay suficiente stock disponible. Stock actual: ' . $producto['stock']);
        }
        
        $this->carritoItemModel->actualizarCantidad($item_id, $cantidad);
        return redirect()->to('carrito')->with('message', 'Cantidad actualizada');
    }

    // Eliminar item del carrito
    public function eliminarItem($item_id)
    {
        $this->carritoItemModel->eliminarItem($item_id);
        return redirect()->to('carrito')->with('message', 'Producto eliminado del carrito');
    }

    // Vaciar carrito
    public function vaciarCarrito()
    {
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        
        if ($carrito) {
            $this->carritoItemModel->vaciarCarrito($carrito['id_carrito']);
        }
        
        return redirect()->to('carrito')->with('message', 'Carrito vaciado');
    }

    // Limpiar productos desactivados del carrito
    private function limpiarProductosDesactivados($carrito_id)
    {
        $items = $this->carritoItemModel->getItemsByCarrito($carrito_id);
        $productosEliminados = [];
        
        foreach ($items as $item) {
            if (!$this->productoModel->isProductoActivo($item['producto_id'])) {
                $producto = $this->productoModel->find($item['producto_id']);
                $productosEliminados[] = $producto['nombre'] ?? 'Producto desconocido';
                $this->carritoItemModel->eliminarItem($item['id_item']);
            }
        }
        
        return $productosEliminados;
    }
}