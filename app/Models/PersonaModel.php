<?php
namespace App\Models;

use CodeIgniter\Model;

class PersonaModel extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id_persona';
    protected $allowedFields = [
        'usuario_id', 'tipo_documento', 'documento', 'nombre', 'apellido',
        'fecha_nacimiento', 'genero', 'telefono'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_creacion';
    protected $updatedField = 'fecha_actualizacion';

    public function getPersonaByUsuario($usuario_id)
    {
        return $this->where('usuario_id', $usuario_id)->first();
    }

    public function actualizarDatosPersonales($usuario_id, $data)
    {
        return $this->where('usuario_id', $usuario_id)->update($this->primaryKey, $data);
    }


}