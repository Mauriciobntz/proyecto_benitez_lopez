<?php namespace App\Models;

use CodeIgniter\Model;

class PersonaModel extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id_persona';
    protected $allowedFields = ['usuario_id', 'nombre', 'apellido', 'telefono'];
    
    protected $validationRules = [
        'usuario_id' => 'required|integer',
        'nombre' => 'required|max_length[100]',
        'apellido' => 'required|max_length[100]',
        'telefono' => 'required|max_length[20]'
    ];
}