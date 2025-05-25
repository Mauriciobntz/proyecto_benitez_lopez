<?php namespace App\Models;

use CodeIgniter\Model;

class ResenaModel extends Model
{
    protected $table = 'reseñas';
    protected $primaryKey = 'id_reseña';
    protected $allowedFields = ['producto_id', 'usuario_id', 'calificacion', 'comentario'];
    protected $useTimestamps = true;
    
    protected $validationRules = [
        'producto_id' => 'required|integer',
        'usuario_id' => 'required|integer',
        'calificacion' => 'required|integer|between[1,5]'
    ];
    
    public function delProducto($producto_id)
    {
        return $this->where('producto_id', $producto_id)->findAll();
    }
}