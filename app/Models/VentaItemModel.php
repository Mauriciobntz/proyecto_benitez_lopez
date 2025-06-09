<?php
namespace App\Models;

use CodeIgniter\Model;

class VentaItemModel extends Model
{
    protected $table = 'venta_items';
    protected $primaryKey = 'id_item';
    protected $allowedFields = ['venta_id', 'producto_id', 'cantidad', 'precio_unitario'];
    protected $useTimestamps = false;

    public function getItemsByVenta($venta_id)
    {
        return $this->where('venta_id', $venta_id)->findAll();
    }

    public function agregarItem($venta_id, $producto_id, $cantidad, $precio_unitario)
    {
        $data = [
            'venta_id' => $venta_id,
            'producto_id' => $producto_id,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio_unitario
        ];
        return $this->insert($data);
    }
}