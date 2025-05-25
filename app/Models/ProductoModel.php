<?php namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $allowedFields = ['nombre', 'descripcion', 'precio', 'stock', 'categoria_id', 'activo'];
    
    protected $validationRules = [
        'nombre' => 'required|max_length[150]',
        'precio' => 'required|decimal',
        'stock' => 'required|integer',
        'categoria_id' => 'permit_empty|integer'
    ];
    
    public function conCategoria($categoria_id = null)
    {
        if ($categoria_id) {
            return $this->where('categoria_id', $categoria_id)->findAll();
        }
        return $this->findAll();
    }
}