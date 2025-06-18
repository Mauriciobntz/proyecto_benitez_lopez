<?php
namespace App\Models;

use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    protected $allowedFields = ['usuario_id', 'fecha_venta', 'fecha_actualizacion', 'estado', 'total', 'id_direccion_envio'];
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

    public function getItemsVenta($venta_id)
    {
        return $this->db->table('venta_items')
            ->select('venta_items.*, productos.nombre, productos.marca, productos.imagen_url')
            ->join('productos', 'productos.id_producto = venta_items.producto_id')
            ->where('venta_items.venta_id', $venta_id)
            ->get()
            ->getResultArray();
    }
}