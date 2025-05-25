<?php namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\CarritoModel;
use App\Models\PagoModel;

class PedidoController extends BaseController
{
    protected $pedidoModel;
    protected $carritoModel;
    protected $pagoModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->carritoModel = new CarritoModel();
        $this->pagoModel = new PagoModel();
    }

    public function crear()
    {
        $usuario_id = session()->get('usuario_id');
        $carrito = $this->carritoModel->where('usuario_id', $usuario_id)->first();

        if (!$carrito) {
            return redirect()->to('/carrito')->with('error', 'El carrito está vacío');
        }

        $items = $this->carritoModel->items($carrito->id_carrito);
        $total = array_reduce($items, fn($sum, $item) => $sum + ($item->precio * $item->cantidad), 0);

        // Crear pedido
        $pedido_id = $this->pedidoModel->insert([
            'usuario_id' => $usuario_id,
            'estado' => 'pendiente',
            'total' => $total
        ]);

        // Crear pago (simulado)
        $this->pagoModel->insert([
            'pedido_id' => $pedido_id,
            'monto' => $total,
            'metodo_pago' => 'tarjeta',
            'estado' => 'exitoso'
        ]);

        // Vaciar carrito
        $this->carritoModel->vaciar($carrito->id_carrito);

        return redirect()->to("/pedidos/$pedido_id")->with('message', 'Pedido creado con éxito');
    }

    public function mostrar($id)
    {
        $data['pedido'] = $this->pedidoModel->find($id);
        $data['items'] = $this->pedidoModel->items($id);
        return view('pedidos/mostrar', $data);
    }
}