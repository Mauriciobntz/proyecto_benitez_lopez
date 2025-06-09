<?php
namespace App\Models;

use CodeIgniter\Model;

class CarritoItemModel extends Model
{
    protected $table = 'carrito_items';
    protected $primaryKey = 'id_item';
    protected $allowedFields = ['carrito_id', 'producto_id', 'cantidad'];
    protected $useTimestamps = false;

    public function getItemsByCarrito($carrito_id)
    {
        return $this->where('carrito_id', $carrito_id)->findAll();
    }

    public function agregarProducto($carrito_id, $producto_id, $cantidad = 1)
    {
        $item = $this->where(['carrito_id' => $carrito_id, 'producto_id' => $producto_id])->first();
        
        if ($item) {
            return $this->update($item['id_item'], ['cantidad' => $item['cantidad'] + $cantidad]);
        } else {
            $data = [
                'carrito_id' => $carrito_id,
                'producto_id' => $producto_id,
                'cantidad' => $cantidad
            ];
            return $this->insert($data);
        }
    }

    public function actualizarCantidad($item_id, $cantidad)
    {
        return $this->update($item_id, ['cantidad' => $cantidad]);
    }

    public function eliminarItem($item_id)
    {
        return $this->delete($item_id);
    }

    public function vaciarCarrito($carrito_id)
    {
        return $this->where('carrito_id', $carrito_id)->delete();
    }
}