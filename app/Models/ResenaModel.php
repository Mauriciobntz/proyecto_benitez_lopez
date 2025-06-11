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

    public function getResenasByProducto($producto_id)
    {
        return $this->select('resenas.*, usuarios.username as usuario_nombre')
                   ->join('usuarios', 'usuarios.id_usuario = resenas.usuario_id')
                   ->where('producto_id', $producto_id)
                   ->orderBy('fecha', 'DESC')
                   ->findAll();
    }

    public function getPromedioCalificacion($producto_id)
    {
        return $this->selectAvg('calificacion', 'calificacion')
                   ->where('producto_id', $producto_id)
                   ->first();
    }

    public function usuarioYaReseno($producto_id, $usuario_id)
    {
        return $this->where('producto_id', $producto_id)
                   ->where('usuario_id', $usuario_id)
                   ->countAllResults() > 0;
    }
}