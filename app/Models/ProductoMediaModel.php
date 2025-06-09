<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductoMediaModel extends Model
{
    protected $table = 'productos_media';
    protected $primaryKey = 'id_media';
    protected $allowedFields = ['producto_id', 'tipo', 'url', 'orden'];
    protected $useTimestamps = false;

    public function getMediaByProducto($producto_id)
    {
        return $this->where('producto_id', $producto_id)
                   ->orderBy('orden', 'ASC')
                   ->findAll();
    }

    public function agregarMedia($producto_id, $tipo, $url, $orden = 0)
    {
        $data = [
            'producto_id' => $producto_id,
            'tipo' => $tipo,
            'url' => $url,
            'orden' => $orden
        ];
        return $this->insert($data);
    }

    public function eliminarMedia($media_id)
    {
        return $this->delete($media_id);
    }
}