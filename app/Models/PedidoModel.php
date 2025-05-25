<?php namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';
    protected $allowedFields = ['usuario_id', 'estado', 'total'];
    protected $useTimestamps = true;
    
    protected $validationRules = [
        'usuario_id' => 'required|integer',
        'estado' => 'required|in_list[pendiente,pagado,enviado,entregado,cancelado]'
    ];
    
    public function items($pedido_id)
    {
        return $this->db->table('pedido_items')
            ->where('pedido_id', $pedido_id)
            ->join('productos', 'productos.id_producto = pedido_items.producto_id')
            ->get()
            ->getResult();
    }
}