<?php
namespace App\Models;

use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    // Backup del array original
    // protected $allowedFields = ['usuario_id', 'direccion_id', 'estado', 'total', 'subtotal', 'costo_envio', 'iva', 'total_iva'];
    protected $allowedFields = ['usuario_id', 'direccion_id', 'fecha_venta', 'estado', 'total', 'subtotal', 'costo_envio', 'iva', 'total_iva', 'fecha_actualizacion'];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_venta';
    protected $updatedField = 'fecha_actualizacion';

public function getVentasConFiltros($filtros = [])
{
    $builder = $this->select('ventas.*');
    
    if (!empty($filtros['id'])) {
        $builder->where('id_venta', $filtros['id']);
    }
    
    if (!empty($filtros['estado'])) {
        $builder->where('estado', $filtros['estado']);
    }
    
    if (!empty($filtros['desde'])) {
        $builder->where('fecha_venta >=', $filtros['desde'] . ' 00:00:00');
    }
    
    if (!empty($filtros['hasta'])) {
        $builder->where('fecha_venta <=', $filtros['hasta'] . ' 23:59:59');
    }
    
    // Cambiamos paginate por findAll para obtener todos los resultados
    return $builder->orderBy('fecha_venta', 'DESC')
                  ->findAll();
}

    public function getVentasByUsuario($usuario_id)
    {
        return $this->where('usuario_id', $usuario_id)
                   ->orderBy('fecha_venta', 'DESC')
                   ->findAll();
    }
}