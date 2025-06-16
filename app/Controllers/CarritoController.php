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

    public function verCarrito()
    {
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        
        $items = [];
        $total = 0;
        
        if ($carrito) {
            $items = $this->carritoItemModel->getItemsByCarrito($carrito['id_carrito']);
            
            // Obtener información completa de los productos
            foreach ($items as &$item) {
                $producto = $this->productoModel->find($item['producto_id']);
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

    public function agregarProducto($producto_id)
    {
        $cantidad = $this->request->getPost('cantidad') ?? 1;
        $usuario_id = session()->get('id_usuario');
        
        // Verificar stock
        $producto = $this->productoModel->find($producto_id);
        if (!$producto || $producto['stock'] < $cantidad) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible');
        }
        
        // Obtener o crear carrito
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        if (!$carrito) {
            $carrito_id = $this->carritoModel->crearCarrito($usuario_id);
            $carrito = $this->carritoModel->find($carrito_id);
        }
        
        // Agregar producto al carrito
        $this->carritoItemModel->agregarProducto($carrito['id_carrito'], $producto_id, $cantidad);
        
        return redirect()->to('usuario/carrito')->with('message', 'Producto agregado al carrito');
    }

    public function actualizarCantidad($item_id)
    {
        $cantidad = $this->request->getPost('cantidad');
        $item = $this->carritoItemModel->find($item_id);
        
        if ($item) {
            $producto = $this->productoModel->find($item['producto_id']);
            if ($producto['stock'] >= $cantidad) {
                $this->carritoItemModel->actualizarCantidad($item_id, $cantidad);
                return redirect()->to('usuario/carrito')->with('message', 'Cantidad actualizada');
            }
        }
        
        return redirect()->to('usuario/carrito')->with('error', 'No hay suficiente stock disponible');
    }

    public function eliminarItem($item_id)
    {
        $this->carritoItemModel->eliminarItem($item_id);
        return redirect()->to('usuario/carrito')->with('message', 'Producto eliminado del carrito');
    }

    public function vaciarCarrito()
    {
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        
        if ($carrito) {
            $this->carritoItemModel->vaciarCarrito($carrito['id_carrito']);
        }
        
        return redirect()->to('usuario/carrito')->with('message', 'Carrito vaciado');
    }

    public function checkout()
    {
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        
        if (!$carrito) {
            return redirect()->to('usuario/carrito')->with('error', 'No hay productos en el carrito');
        }
        
        $items = $this->carritoItemModel->getItemsByCarrito($carrito['id_carrito']);
        if (empty($items)) {
            return redirect()->to('usuario/carrito')->with('error', 'No hay productos en el carrito');
        }
        
        // Verificar stock antes de continuar
        foreach ($items as $item) {
            $producto = $this->productoModel->find($item['producto_id']);
            if ($producto['stock'] < $item['cantidad']) {
                return redirect()->to('usuario/carrito')->with('error', 'No hay suficiente stock para ' . $producto['nombre']);
            }
        }
        
        // Calcular totales
        $subtotal = 0;
        foreach ($items as &$item) {
            $producto = $this->productoModel->find($item['producto_id']);
            $item['producto'] = $producto;
            $item['subtotal'] = $producto['precio'] * $item['cantidad'];
            $subtotal += $item['subtotal'];
        }
        
        $costo_envio = 5.99; // Costo fijo de envío
        $iva = $subtotal * 0.21; // IVA del 21%
        $total = $subtotal + $costo_envio + $iva;
        
        // Obtener direcciones del usuario
        $direcciones = $this->direccionModel->getDireccionesByUsuario($usuario_id);
        
        $data = [
            'titulo' => 'Finalizar Compra',
            'items' => $items,
            'subtotal' => $subtotal,
            'costo_envio' => $costo_envio,
            'iva' => $iva,
            'total' => $total,
            'direcciones' => $direcciones
        ];
        
        return view('header', $data) . view('navbar') . view('usuario/checkout', $data) . view('footer');
    }

    public function procesarCompra()
    {
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->getCarritoByUsuario($usuario_id);
        
        if (!$carrito) {
            return redirect()->to('usuario/carrito')->with('error', 'No hay productos en el carrito');
        }
        
        $items = $this->carritoItemModel->getItemsByCarrito($carrito['id_carrito']);
        if (empty($items)) {
            return redirect()->to('usuario/carrito')->with('error', 'No hay productos en el carrito');
        }
        
        // Validar dirección de envío
        $direccion_id = $this->request->getPost('direccion_id');
        $direccion = $this->direccionModel->find($direccion_id);
        
        if (!$direccion || $direccion['usuario_id'] != $usuario_id) {
            return redirect()->to('usuario/checkout')->with('error', 'Selecciona una dirección de envío válida');
        }
        
        // Validar método de pago
        $metodo_pago = $this->request->getPost('metodo_pago');
        if (!in_array($metodo_pago, ['tarjeta', 'transferencia', 'paypal'])) {
            return redirect()->to('usuario/checkout')->with('error', 'Selecciona un método de pago válido');
        }
        
        // Calcular totales
        $subtotal = 0;
        foreach ($items as $item) {
            $producto = $this->productoModel->find($item['producto_id']);
            $subtotal += $producto['precio'] * $item['cantidad'];
        }
        
        $costo_envio = 5.99;
        $iva = $subtotal * 0.21;
        $total = $subtotal + $costo_envio + $iva;
        
        // Crear venta
        $venta_id = $this->ventaModel->insert([
            'usuario_id' => $usuario_id,
            'estado' => 'pendiente',
            'total' => $total,
        ]);
        
        // Registrar dirección de envío
        $this->direccionEnvioModel->insert([
            'venta_id' => $venta_id,
            'direccion' => $direccion['direccion'],
            'ciudad' => $direccion['ciudad'],
            'provincia' => $direccion['provincia'],
            'codigo_postal' => $direccion['codigo_postal'],
            'pais' => $direccion['pais'],
            'nombre_destinatario' => session()->get('username'),
            'telefono_contacto' => $this->request->getPost('telefono_contacto')
        ]);
        
        // Registrar items de la venta
        foreach ($items as $item) {
            $producto = $this->productoModel->find($item['producto_id']);
            
            $this->ventaItemModel->insert([
                'venta_id' => $venta_id,
                'producto_id' => $item['producto_id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $producto['precio']
            ]);
            
            // Actualizar stock
            $this->productoModel->actualizarStock($item['producto_id'], $item['cantidad']);
            $this->productoModel->incrementarVentas($item['producto_id'], $item['cantidad']);
        }
        
        // Registrar pago
        $this->pagoModel->insert([
            'venta_id' => $venta_id,
            'monto' => $total,
            'metodo_pago' => $metodo_pago,
            'estado' => 'exitoso'
        ]);
        
        // Actualizar estado de la venta
        $this->ventaModel->update($venta_id, ['estado' => 'pagado']);
        
        // Registrar en el historial
        $this->historicoVentaModel->insert([
            'venta_id' => $venta_id,
            'estado_anterior' => 'pendiente',
            'estado_nuevo' => 'pagado',
            'accion' => 'Compra realizada',
            'usuario_id' => $usuario_id
        ]);
        
        // Vaciar carrito
        $this->carritoItemModel->vaciarCarrito($carrito['id_carrito']);
        
        // Redirigir a confirmación
        return redirect()->to("usuario/confirmacion/$venta_id");
    }

    public function confirmacionCompra($venta_id)
    {
        $usuario_id = session()->get('id_usuario');
        $venta = $this->ventaModel->find($venta_id);
        
        if (!$venta || $venta['usuario_id'] != $usuario_id) {
            return redirect()->to('/')->with('error', 'Pedido no encontrado');
        }
        
        // Obtener items de la venta
        $items = $this->ventaItemModel->where('venta_id', $venta_id)->findAll();
        foreach ($items as &$item) {
            $producto = $this->productoModel->find($item['producto_id']);
            $item['producto'] = $producto;
            $item['subtotal'] = $item['precio_unitario'] * $item['cantidad'];
        }
        
        // Obtener dirección de envío
        $direccion = $this->direccionEnvioModel->where('venta_id', $venta_id)->first();
        
        // Obtener método de pago
        $pago = $this->pagoModel->where('venta_id', $venta_id)->first();
        
        $data = [
            'titulo' => 'Confirmación de Compra',
            'venta' => $venta,
            'items' => $items,
            'direccion' => $direccion,
            'pago' => $pago
        ];
        
        return view('header', $data) . view('navbar') . view('usuario/confirmacion', $data) . view('footer');
    }
}