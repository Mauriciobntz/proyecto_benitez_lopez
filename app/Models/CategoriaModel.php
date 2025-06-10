<?php
namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    protected $allowedFields = ['nombre', 'descripcion'];
    protected $useTimestamps = false;

    public function getCategoriasConProductos()
    {
        return $this->select('categorias.*, COUNT(productos.id_producto) as total_productos')
                   ->join('productos', 'productos.categoria_id = categorias.id_categoria', 'left')
                   ->groupBy('categorias.id_categoria')
                   ->findAll();
    }

    public function getCategoriasParaSelect()
    {
        $categorias = $this->orderBy('nombre', 'ASC')->findAll();
        $options = ['' => 'Seleccione una categoría'];
        
        foreach ($categorias as $categoria) {
            $options[$categoria['id_categoria']] = $categoria['nombre'];
        }
        
        return $options;
    }
}