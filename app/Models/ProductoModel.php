<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $allowedFields = [
        'nombre', 'descripcion', 'marca', 'modelo', 'precio', 'stock',
        'imagen_url', 'categoria_id', 'especificaciones', 'garantia_meses',
        'peso_kg', 'dimensiones', 'activo'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_alta';
    protected $updatedField = '';

    public function getProductosDestacados($limit = 10)
    {
        return $this->where('activo', 1)
                   ->orderBy('fecha_alta', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    public function getProductosByCategoria($categoria_id)
    {
        return $this->where(['categoria_id' => $categoria_id, 'activo' => 1])->findAll();
    }

    public function buscarProductos($termino, $filtros = [])
    {
        $builder = $this->where('activo', 1);
        
        // Búsqueda en múltiples campos
        $builder->groupStart()
                ->like('nombre', $termino)
                ->orLike('descripcion', $termino)
                ->orLike('marca', $termino)
                ->orLike('modelo', $termino)
                ->orLike('especificaciones', $termino)
                ->groupEnd();
        
        // Aplicar filtros
        if (!empty($filtros['categoria_id'])) {
            $builder->where('categoria_id', $filtros['categoria_id']);
        }
        
        if (!empty($filtros['stock_disponible'])) {
            $builder->where('stock >', 0);
        }
        
        if (!empty($filtros['precio_min'])) {
            $builder->where('precio >=', $filtros['precio_min']);
        }
        
        if (!empty($filtros['precio_max'])) {
            $builder->where('precio <=', $filtros['precio_max']);
        }
        
        // Ordenación
        $orden = 'fecha_alta DESC'; // Orden por defecto (más relevantes)
        if (!empty($filtros['orden'])) {
            switch($filtros['orden']) {
                case 'menor_precio':
                    $orden = 'precio ASC';
                    break;
                case 'mayor_precio':
                    $orden = 'precio DESC';
                    break;
                case 'a_z':
                    $orden = 'nombre ASC';
                    break;
                case 'z_a':
                    $orden = 'nombre DESC';
                    break;
            }
        }
        
        return $builder->orderBy($orden)->findAll();
    }

    public function actualizarStock($producto_id, $cantidad)
    {
        $producto = $this->find($producto_id);
        if ($producto) {
            $nuevo_stock = $producto['stock'] - $cantidad;
            return $this->update($producto_id, ['stock' => $nuevo_stock]);
        }
        return false;
    }

    public function incrementarStock($producto_id, $cantidad)
    {
        return $this->where('id_producto', $producto_id)
                    ->set('stock', 'stock + ' . (int)$cantidad, false)
                    ->update();
    }
}