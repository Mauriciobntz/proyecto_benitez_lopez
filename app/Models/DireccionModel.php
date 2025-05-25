<?php namespace App\Models;

use CodeIgniter\Model;

class DireccionModel extends Model
{
    protected $table = 'direcciones';
    protected $primaryKey = 'id_direccion';
    protected $allowedFields = ['usuario_id', 'direccion', 'ciudad', 'codigo_postal'];
    
    protected $validationRules = [
        'usuario_id' => 'required|integer',
        'direccion' => 'required',
        'ciudad' => 'required|max_length[100]',
        'codigo_postal' => 'required|max_length[10]'
    ];
    
    public function delUsuario($usuario_id)
    {
        return $this->where('usuario_id', $usuario_id)->findAll();
    }
}