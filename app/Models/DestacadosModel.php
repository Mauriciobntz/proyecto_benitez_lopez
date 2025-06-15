<?php namespace App\Models;

use CodeIgniter\Model;

class DestacadosModel extends Model
{
    protected $table = 'destacados';
    protected $primaryKey = 'id_destacado';
    protected $allowedFields = ['producto_id', 'titulo', 'subtitulo', 'video_url', 'url_producto', 'orden', 'activo'];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_creacion';
    protected $updatedField = 'fecha_actualizacion';

public function getDestacadosActivos()
{
    return $this->select('destacados.*, productos.precio, productos.nombre as producto_nombre, productos.marca, productos.modelo')
               ->join('productos', 'productos.id_producto = destacados.producto_id')
               ->where('destacados.activo', 1)
               ->orderBy('destacados.orden', 'ASC')
               ->findAll();
}
    public function getDestacadoById($id)
    {
        return $this->find($id);
    }

    public function getMaxOrden()
    {
        return $this->selectMax('orden')->get()->getRow()->orden ?? 0;
    }

    public function getDestacadosConFiltros($filtros = [])
    {
        $builder = $this->select('*');
        
        if (!empty($filtros['titulo'])) {
            $builder->like('titulo', $filtros['titulo']);
        }
        
        if (!empty($filtros['estado'])) {
            $builder->where('activo', $filtros['estado'] == 'activo' ? 1 : 0);
        }
        
        if (!empty($filtros['orden_min'])) {
            $builder->where('orden >=', $filtros['orden_min']);
        }
        
        if (!empty($filtros['orden_max'])) {
            $builder->where('orden <=', $filtros['orden_max']);
        }
        
        return $builder->orderBy('orden', 'ASC')
                      ->findAll();
    }
}