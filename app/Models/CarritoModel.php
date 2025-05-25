<?php namespace App\Models;

use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table = 'carritos';
    protected $primaryKey = 'id_carrito';
    protected $allowedFields = ['usuario_id'];
    
    public function items($carrito_id)
    {
        return $this->db->table('carrito_items')
            ->where('carrito_id', $carrito_id)
            ->join('productos', 'productos.id_producto = carrito_items.producto_id')
            ->get()
            ->getResult();
    }
}