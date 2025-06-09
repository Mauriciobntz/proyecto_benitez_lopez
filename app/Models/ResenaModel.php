<?php
namespace App\Models;

use CodeIgniter\Model;

class ResenaModel extends Model
{
    protected $table = 'reseñas';
    protected $primaryKey = 'id_reseña';
    protected $allowedFields = ['producto_id', 'usuario_id', 'calificacion', 'comentario'];
    protected $useTimestamps = true;
    protected $createdField = 'fecha';
    protected $updatedField = '';

    public function getResenasProducto($producto_id)
    {
        return $this->where('producto_id', $producto_id)
                   ->orderBy('fecha', 'DESC')
                   ->findAll();
    }

    public function getPromedioCalificacion($producto_id)
    {
        return $this->where('producto_id', $producto_id)
                   ->selectAvg('calificacion')
                   ->first();
    }

    public function usuarioYaReseno($producto_id, $usuario_id)
    {
        return $this->where(['producto_id' => $producto_id, 'usuario_id' => $usuario_id])
                   ->countAllResults() > 0;
    }
}