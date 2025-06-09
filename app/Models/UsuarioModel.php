<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['email', 'password_hash', 'rol', 'username'];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_registro';
    protected $updatedField = ''; // No usamos campo de actualización

}