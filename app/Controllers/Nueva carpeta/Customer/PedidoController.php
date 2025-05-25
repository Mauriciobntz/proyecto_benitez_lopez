<?php namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\PedidoItemModel;
use App\Models\CarritoModel;
use App\Models\CarritoItemModel;
use App\Models\DireccionModel;
use App\Models\PagoModel;

class PedidoController extends BaseController
{
    protected $pedidoModel;
    protected $pedidoItemModel;
    protected $carritoModel;
    protected $carritoItemModel;
    protected $direccionModel;
    protected $pagoModel;
    
    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->pedidoItemModel = new PedidoItemModel();
        $this->carritoModel = new CarritoModel();
        $this->carritoItemModel = new CarritoItemModel();
        $this->direccionModel = new DireccionModel();
        $this->pagoModel = new PagoModel();
    }
    
    public function index()
    {
        $usuario_id = session()->get('id_usuario');
        $pedidos = $this->pedidoModel->where('usuario_id', $usuario_id)
                                    ->orderBy('fecha_pedido', 'DESC')
                                    ->findAll();
        
        return view('customer/pedidos/index', ['pedidos' => $pedidos]);
    }
    
    public function show($id)
    {
        $usuario_id = session()->get('id_usuario');
        $pedido = $this->pedidoModel->find($id);
        
        if (!$pedido || $pedido->usuario_id != $usuario_id) {
            return redirect()->to('/pedidos')->with('error', 'Pedido no encontrado');
        }
        
        $items = $this->pedidoModel->getItems($id);
        $pagos = $this->pagoModel->getByPedido($id);
        
        return view('customer/pedidos/show', [
            'pedido' => $pedido,
            'items' => $items,
            'pagos' => $pagos
        ]);
    }
    
    public function create()
    {
        $usuario_id = session()->get('id_usuario');
        
        // Obtener carrito y direcciones
        $carrito = $this->carritoModel->where('usuario_id', $usuario_id)->first();
        $direcciones = $this->direccionModel->getByUsuario($usuario_id);
        
        if (!$carrito) {
            return redirect()->to('/carrito')->with('error', 'El carrito está vacío');
        }
        
        $items = $this->carritoModel->getItems($carrito->id_carrito);
        
        if (empty($items)) {
            return redirect()->to('/carrito')->with('error', 'El carrito está vacío');
        }
        
        // Calcular total
        $total = 0;
        foreach ($items as $item) {
            $total += $item->precio * $item->cantidad;
        }
        
        return view('customer/pedidos/create', [
            'items' => $items,
            'total' => $total,
            'direcciones' => $direcciones
        ]);
    }
    
    public function store()
    {
        $usuario_id = session()->get('id_usuario');
        $carrito = $this->carritoModel->where('usuario_id', $usuario_id)->first();
        
        if (!$carrito) {
            return redirect()->to('/carrito')->with('error', 'El carrito está vacío');
        }
        
        $items = $this->carritoModel->getItems($carrito->id_carrito);
        
        if (empty($items)) {
            return redirect()->to('/carrito')->with('error', 'El carrito está vacío');
        }
        
        // Validar dirección
        $direccion_id = $this->request->getPost('direccion_id');
        $direccion = $this->direccionModel->find($direccion_id);
        
        if (!$direccion || $direccion->usuario_id != $usuario_id) {
            return redirect()->back()->with('error', 'Dirección no válida');
        }
        
        // Calcular total
        $total = 0;
        foreach ($items as $item) {
            $total += $item->precio * $item->cantidad;
        }
        
        // Crear pedido
        $pedido_id = $this->pedidoModel->insert([
            'usuario_id' => $usuario_id,
            'estado' => 'pendiente',
            'direccion_envio' => json_encode($direccion),
            'total' => $total
        ]);
        
        // Crear items del pedido
        foreach ($items as $item) {
            $this->pedidoItemModel->insert([
                'pedido_id' => $pedido_id,
                'producto_id' => $item->producto_id,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio
            ]);
            
            // Actualizar stock
            $this->productoModel->decrement('stock', $item->cantidad, ['id_producto' => $item->producto_id]);
        }
        
        // Vaciar carrito
        $this->carritoItemModel->where('carrito_id', $carrito->id_carrito)->delete();
        
        return redirect()->to("/pedidos/$pedido_id")->with('success', 'Pedido creado exitosamente');
    }
}