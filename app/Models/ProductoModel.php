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

    public function buscarProductos($termino)
    {
        return $this->like('nombre', $termino)
                   ->orLike('descripcion', $termino)
                   ->orLike('marca', $termino)
                   ->where('activo', 1)
                   ->findAll();
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
}