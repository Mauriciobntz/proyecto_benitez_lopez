<?php
namespace App\Models;

use CodeIgniter\Model;

class ResenaModel extends Model
{
    protected $table = 'resenas';
    protected $primaryKey = 'id_resena';
    protected $allowedFields = ['producto_id', 'usuario_id', 'calificacion', 'comentario', 'fecha'];
    protected $useTimestamps = true;
    protected $createdField = 'fecha';
    protected $updatedField = 'fecha';

    /**
     * Obtiene reseñas con filtros opcionales
     */
    public function getResenasConFiltros($filtros = [])
    {
        $builder = $this->select('resenas.*, productos.nombre as producto_nombre, usuarios.username as usuario_nombre')
                        ->join('productos', 'productos.id_producto = resenas.producto_id')
                        ->join('usuarios', 'usuarios.id_usuario = resenas.usuario_id');
        
        if (!empty($filtros['producto_id'])) {
            $builder->where('resenas.producto_id', $filtros['producto_id']);
        }
        
        if (!empty($filtros['usuario_id'])) {
            $builder->where('resenas.usuario_id', $filtros['usuario_id']);
        }
        
        if (!empty($filtros['calificacion'])) {
            $builder->where('resenas.calificacion', $filtros['calificacion']);
        }
        
        if (!empty($filtros['desde'])) {
            $builder->where('resenas.fecha >=', $filtros['desde'] . ' 00:00:00');
        }
        
        if (!empty($filtros['hasta'])) {
            $builder->where('resenas.fecha <=', $filtros['hasta'] . ' 23:59:59');
        }
        
        return $builder->orderBy('resenas.fecha', 'DESC')
                      ->findAll();
    }

    /**
     * Obtiene reseñas por producto
     */
    public function getResenasByProducto($producto_id)
    {
        return $this->select('resenas.*, usuarios.username as usuario_nombre')
                   ->join('usuarios', 'usuarios.id_usuario = resenas.usuario_id')
                   ->where('producto_id', $producto_id)
                   ->orderBy('fecha', 'DESC')
                   ->findAll();
    }

    /**
     * Obtiene el promedio de calificación de un producto
     */
    public function getPromedioCalificacion($producto_id)
    {
        return $this->selectAvg('calificacion', 'promedio')
                   ->where('producto_id', $producto_id)
                   ->first();
    }

    /**
     * Verifica si un usuario ya ha reseñado un producto
     */
    public function usuarioYaReseno($producto_id, $usuario_id)
    {
        return $this->where('producto_id', $producto_id)
                   ->where('usuario_id', $usuario_id)
                   ->countAllResults() > 0;
    }

    public function getProductosCompradosNoResenados($usuario_id)
    {
        return $this->db->table('venta_items vi')
            ->select('p.id_producto, p.nombre, p.imagen_url, MAX(v.fecha_venta) as fecha_compra')
            ->join('ventas v', 'v.id_venta = vi.venta_id')
            ->join('productos p', 'p.id_producto = vi.producto_id')
            ->where('v.usuario_id', $usuario_id)
            ->where('v.estado', 'entregado') // Solo productos entregados
            ->whereNotIn('vi.producto_id', function($builder) use ($usuario_id) {
                $builder->select('producto_id')
                        ->from('resenas')
                        ->where('usuario_id', $usuario_id);
            })
            ->groupBy('p.id_producto, p.nombre, p.imagen_url')
            ->orderBy('fecha_compra', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Verifica si el usuario ha comprado un producto
     */
    public function usuarioComproProducto($usuario_id, $producto_id)
    {
        return $this->db->table('venta_items vi')
            ->join('ventas v', 'v.id_venta = vi.venta_id')
            ->where('v.usuario_id', $usuario_id)
            ->where('vi.producto_id', $producto_id)
            ->where('v.estado', 'entregado') // Solo productos entregados
            ->countAllResults() > 0;
    }
}