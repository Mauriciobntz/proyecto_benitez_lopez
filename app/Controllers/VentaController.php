<?php
namespace App\Controllers;

use App\Models\VentaModel;
use App\Models\VentaItemModel;
use App\Models\UsuarioModel;
use App\Models\DireccionModel;
use App\Models\PagoModel;
use App\Models\FacturaModel;
use App\Models\ProductoModel;
use App\Models\HistoricoVentaModel;

class VentaController extends BaseController
{
    protected $ventaModel;
    protected $ventaItemModel;
    protected $usuarioModel;
    protected $direccionModel;
    protected $pagoModel;
    protected $facturaModel;
    protected $productoModel;
    protected $historicoVentaModel;

    public function __construct()
    {
        $this->ventaModel = new VentaModel();
        $this->ventaItemModel = new VentaItemModel();
        $this->usuarioModel = new UsuarioModel();
        $this->direccionModel = new DireccionModel();
        $this->pagoModel = new PagoModel();
        $this->facturaModel = new FacturaModel();
        $this->productoModel = new ProductoModel();
        $this->historicoVentaModel = new HistoricoVentaModel();
    }

public function listar()
{
    // Verificar si el usuario es administrador
    if (session()->get('rol') !== 'admin') {
        return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
    }

    // Filtros
    $filtros = [
        'id' => $this->request->getGet('id'),
        'estado' => $this->request->getGet('estado'),
        'desde' => $this->request->getGet('desde'),
        'hasta' => $this->request->getGet('hasta')
    ];

    // Obtener todas las ventas sin paginación
    $ventas = $this->ventaModel->getVentasConFiltros($filtros);

    // Obtener información de clientes
    foreach ($ventas as &$venta) {
        $usuario = $this->usuarioModel->find($venta['usuario_id']);
        $persona = $this->usuarioModel->getPersona($venta['usuario_id']);
        
        $venta['nombre_cliente'] = $persona ? $persona['nombre'] . ' ' . $persona['apellido'] : $usuario['username'];
        $venta['metodo_pago'] = $this->pagoModel->where('venta_id', $venta['id_venta'])->first()['metodo_pago'] ?? null;
    }

    $data = [
        'titulo' => 'Gestión de Ventas',
        'ventas' => $ventas,
        'request' => $this->request // Pasar el request a la vista
    ];

    return view('header', $data) . view('navbar') . view('admin/ventas/listar', $data) . view('footer');
}

    public function detalle($venta_id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('denegado')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $venta = $this->ventaModel->find($venta_id);
        if (!$venta) {
            return redirect()->to('admin/ventas/listar')->with('error', 'Venta no encontrada');
        }

        // Obtener items de la venta con información de productos
        $items = $this->ventaItemModel->select('venta_items.*, productos.nombre, productos.marca, productos.imagen_url')
                                     ->join('productos', 'productos.id_producto = venta_items.producto_id')
                                     ->where('venta_id', $venta_id)
                                     ->findAll();

        // Obtener dirección de envío
        $direccion = $this->direccionModel->find($venta['direccion_id']) ?? [];

        // Obtener información del cliente
        $usuario = $this->usuarioModel->find($venta['usuario_id']);
        $persona = $this->usuarioModel->getPersona($venta['usuario_id']);
        
        if ($persona) {
            $direccion['nombre'] = $persona['nombre'] . ' ' . $persona['apellido'];
            $direccion['telefono'] = $persona['telefono'];
        } else {
            $direccion['nombre'] = $usuario['username'];
            $direccion['telefono'] = 'N/A';
        }

        // Obtener método de pago
        $pago = $this->pagoModel->where('venta_id', $venta_id)->first();
        $venta['metodo_pago'] = $pago['metodo_pago'] ?? null;

        // Obtener historial de estados
        $historial = $this->historicoVentaModel->where('venta_id', $venta_id)
                                             ->orderBy('fecha', 'ASC')
                                             ->findAll();

        $data = [
            'titulo' => 'Detalle de Venta #' . $venta_id,
            'venta' => $venta,
            'items' => $items,
            'direccion' => $direccion,
            'historial' => $historial
        ];

        return view('header', $data) . view('navbar') . view('admin/ventas/detalle_venta', $data) . view('footer');
    }

    public function actualizarEstado($venta_id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $venta = $this->ventaModel->find($venta_id);
        if (!$venta) {
            return redirect()->to('admin/ventas/listar')->with('error', 'Venta no encontrada');
        }

        $nuevoEstado = $this->request->getPost('nuevo_estado');
        if (!$nuevoEstado) {
            return redirect()->back()->with('error', 'Debes seleccionar un estado válido');
        }

        // Registrar cambio en el historial
        $this->historicoVentaModel->insert([
            'venta_id' => $venta_id,
            'estado_anterior' => $venta['estado'],
            'estado_nuevo' => $nuevoEstado,
            'accion' => 'Estado cambiado a ' . $nuevoEstado,
            'usuario_id' => session()->get('id_usuario')
        ]);

        // Actualizar estado de la venta
        $this->ventaModel->update($venta_id, ['estado' => $nuevoEstado]);

        // Si se cancela la venta, devolver stock
        if ($nuevoEstado == 'cancelado') {
            $items = $this->ventaItemModel->where('venta_id', $venta_id)->findAll();
            foreach ($items as $item) {
                $this->productoModel->incrementarStock($item['producto_id'], $item['cantidad']);
            }
        }

        return redirect()->back()->with('message', 'Estado actualizado correctamente');
    }

    public function generarFactura($venta_id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos para realizar esta acción');
        }

        $venta = $this->ventaModel->find($venta_id);
        if (!$venta) {
            return redirect()->to('admin/ventas/listar')->with('error', 'Venta no encontrada');
        }

        // Verificar si ya existe una factura
        $factura = $this->facturaModel->where('venta_id', $venta_id)->first();
        if (!$factura) {
            // Obtener información del cliente
            $usuario = $this->usuarioModel->find($venta['usuario_id']);
            $persona = $this->usuarioModel->getPersona($venta['usuario_id']);
            
            $datosFiscales = $persona 
                ? "{$persona['tipo_documento']}: {$persona['documento']}, Nombre: {$persona['nombre']} {$persona['apellido']}"
                : "Cliente: {$usuario['username']}";

            // Generar factura (simulado)
            $facturaData = [
                'venta_id' => $venta_id,
                'datos_fiscales' => $datosFiscales,
                'pdf_url' => "facturas/factura-{$venta_id}.pdf"
            ];
            
            $this->facturaModel->insert($facturaData);
            $factura = $this->facturaModel->where('venta_id', $venta_id)->first();
        }

        // Aquí iría la lógica para generar el PDF real
        // Por ahora redirigimos a la URL simulada
        return redirect()->to($factura['pdf_url']);
    }
}