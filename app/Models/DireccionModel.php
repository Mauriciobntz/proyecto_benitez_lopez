<?php
namespace App\Models;

use CodeIgniter\Model;

class DireccionModel extends Model
{
    protected $table = 'direcciones';
    protected $primaryKey = 'id_direccion';
    protected $allowedFields = [
        'usuario_id', 'tipo', 'alias', 'direccion', 
        'codigo_postal', 'ciudad', 'provincia', 'pais', 'es_principal'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_creacion';
    protected $updatedField = '';

    public function getDireccionesByUsuario($usuario_id)
    {
        return $this->where('usuario_id', $usuario_id)->orderBy('es_principal', 'DESC')->findAll();
    }

    public function getDireccionPrincipal($usuario_id)
    {
        return $this->where(['usuario_id' => $usuario_id, 'es_principal' => 1])->first();
    }

    public function setDireccionPrincipal($direccion_id, $usuario_id)
    {
        // Quitar principal de otras direcciones
        $this->where('usuario_id', $usuario_id)->set(['es_principal' => 0])->update();
        
        // Establecer esta como principal
        return $this->update($direccion_id, ['es_principal' => 1]);
    }
}