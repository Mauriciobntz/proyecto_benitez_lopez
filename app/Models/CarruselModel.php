<?php namespace App\Models;

use CodeIgniter\Model;

class CarruselModel extends Model
{
    protected $table = 'carrusel';
    protected $primaryKey = 'id';
    protected $allowedFields = ['imagen', 'titulo', 'descripcion', 'enlace', 'orden', 'activo'];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_creacion';
    protected $updatedField = 'fecha_actualizacion';

    public function getSlidesActivos()
    {
        return $this->where('activo', 1)
                   ->orderBy('orden', 'ASC')
                   ->findAll();
    }

    public function getSlideById($id)
    {
        return $this->find($id);
    }

    public function getMaxOrden()
    {
        return $this->selectMax('orden')->get()->getRow()->orden ?? 0;
    }

    public function getSlidesConFiltros($filtros = [])
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