<?php
namespace App\Models;

use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table = 'carritos';
    protected $primaryKey = 'id_carrito';
    protected $allowedFields = ['usuario_id', 'fecha_creacion'];
    protected $useTimestamps = false;

    public function getCarritoByUsuario($usuario_id)
    {
        return $this->where('usuario_id', $usuario_id)->first();
    }

    public function crearCarrito($usuario_id)
    {
        $data = [
            'usuario_id' => $usuario_id,
            'fecha_creacion' => date('Y-m-d H:i:s')
        ];
        return $this->insert($data);
    }
}