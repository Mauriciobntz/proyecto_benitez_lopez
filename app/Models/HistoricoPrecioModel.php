<?php
namespace App\Models;

use CodeIgniter\Model;

class HistoricoPrecioModel extends Model
{
    protected $table = 'historico_precios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['producto_id', 'precio_anterior', 'precio_nuevo'];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_cambio';
    protected $updatedField = '';

    public function registrarCambioPrecio($producto_id, $precio_anterior, $precio_nuevo)
    {
        $data = [
            'producto_id' => $producto_id,
            'precio_anterior' => $precio_anterior,
            'precio_nuevo' => $precio_nuevo
        ];
        return $this->insert($data);
    }

    public function getHistorialProducto($producto_id)
    {
        return $this->where('producto_id', $producto_id)
                   ->orderBy('fecha_cambio', 'DESC')
                   ->findAll();
    }
}