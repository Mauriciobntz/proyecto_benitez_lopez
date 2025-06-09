<?php
namespace App\Controllers;

use App\Models\VentaModel;
use App\Models\VentaItemModel;
use App\Models\CarritoModel;
use App\Models\CarritoItemModel;
use App\Models\ProductoModel;
use App\Models\PagoModel;
use App\Models\FacturaModel;
use App\Models\DireccionModel;

class VentaController extends BaseController
{
    protected $ventaModel;
    protected $ventaItemModel;
    protected $carritoModel;
    protected $carritoItemModel;
    protected $productoModel;
    protected $pagoModel;
    protected $facturaModel;
    protected $direccionModel;

    public function __construct()
    {
        $this->ventaModel = new VentaModel();
        $this->ventaItemModel = new VentaItemModel();
        $this->carritoModel = new CarritoModel();
        $this->carritoItemModel = new CarritoItemModel();
        $this->productoModel = new ProductoModel();
        $this->pagoModel = new PagoModel();
        $this->facturaModel = new FacturaModel();
        $this->direccionModel = new DireccionModel();
    }

    public function misCompras()
    {
        $usuario_id = session()->get('id_usuario');
        $ventas = $this->ventaModel->getVentasByUsuario($usuario_id);
        
        $data = [
            'titulo' => 'Mis Compras',
            'ventas' => $ventas
        ];

        return view('header', $data) . view('navbar') . view('mis_compras') . view('footer');
    }

    public function checkout()
    {
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        
        if (!$carrito) {
            return redirect()->to('carrito')->with('error', 'No hay productos en tu carrito');
        }

        $items = $this->carritoItemModel->getItemsByCarrito($carrito['id_carrito']);
        if (empty($items)) {
            return redirect()->to('carrito')->with('error', 'No hay productos en tu carrito');
        }

        // Verificar stock
        foreach ($items as $item) {
            $producto = $this->productoModel->find($item['producto_id']);
            if ($producto['stock'] < $item['cantidad']) {
                return redirect()->to('carrito')->with('error', 'No hay suficiente stock para ' . $producto['nombre']);
            }
        }

        $direcciones = $this->direccionModel->getDireccionesByUsuario($usuario_id);
        $total = $this->calcularTotalCarrito($carrito['id_carrito']);

        $data = [
            'titulo' => 'Finalizar Compra',
            'items' => $items,
            'direcciones' => $direcciones,
            'total' => $total
        ];

        return view('header', $data) . view('navbar') . view('checkout') . view('footer');
    }

    public function procesarCompra()
    {
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        
        if (!$carrito) {
            return redirect()->to('carrito')->with('error', 'No hay productos en tu carrito');
        }

        $items = $this->carritoItemModel->getItemsByCarrito($carrito['id_carrito']);
        if (empty($items)) {
            return redirect()->to('carrito')->with('error', 'No hay productos en tu carrito');
        }

        // Validar dirección
        $direccion_id = $this->request->getPost('direccion_id');
        $direccion = $this->direccionModel->find($direccion_id);
        
        if (!$direccion || $direccion['usuario_id'] != $usuario_id) {
            return redirect()->back()->with('error', 'Debes seleccionar una dirección válida');
        }

        // Calcular total
        $total = $this->calcularTotalCarrito($carrito['id_carrito']);

        // Crear venta
        $venta_id = $this->ventaModel->crearVenta($usuario_id, $direccion_id, $total);

        // Agregar items a la venta
        foreach ($items as $item) {
            $producto = $this->productoModel->find($item['producto_id']);
            $this->ventaItemModel->agregarItem(
                $venta_id,
                $item['producto_id'],
                $item['cantidad'],
                $producto['precio']
            );
            
            // Actualizar stock
            $this->productoModel->actualizarStock($item['producto_id'], $item['cantidad']);
        }

        // Registrar pago (simulado)
        $metodo_pago = $this->request->getPost('metodo_pago');
        $this->pagoModel->registrarPago($venta_id, $total, $metodo_pago);

        // Generar factura (simulado)
        $datos_fiscales = "Nombre: " . session()->get('username') . ", Email: " . session()->get('email');
        $pdf_url = "https://ejemplo.com/facturas/factura-" . str_pad($venta_id, 5, '0', STR_PAD_LEFT) . ".pdf";
        $this->facturaModel->generarFactura($venta_id, $datos_fiscales, $pdf_url);

        // Vaciar carrito
        $this->carritoItemModel->vaciarCarrito($carrito['id_carrito']);
        $this->carritoModel->delete($carrito['id_carrito']);

        // Actualizar estado de la venta
        $this->ventaModel->actualizarEstado($venta_id, 'pagado');

        return redirect()->to('mis-compras')->with('message', 'Compra realizada con éxito');
    }

    private function calcularTotalCarrito($carrito_id)
    {
        $items = $this->carritoItemModel->getItemsByCarrito($carrito_id);
        $total = 0;

        foreach ($items as $item) {
            $producto = $this->productoModel->find($item['producto_id']);
            $total += $producto['precio'] * $item['cantidad'];
        }

        return $total;
    }
}