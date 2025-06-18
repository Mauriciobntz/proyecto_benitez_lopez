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

public function getUsuariosConFiltros($filtros = [])
{
    $builder = $this->db->table('usuarios u');
    $builder->select('u.*, p.nombre, p.apellido, p.tipo_documento, p.documento, p.telefono');
    $builder->join('personas p', 'p.usuario_id = u.id_usuario', 'left');
    
    if (!empty($filtros['q'])) {
        $builder->groupStart()
            ->like('u.email', $filtros['q'])
            ->orLike('u.username', $filtros['q'])
            ->orLike('p.nombre', $filtros['q'])
            ->orLike('p.apellido', $filtros['q'])
            ->groupEnd();
    }
    
    if (!empty($filtros['rol'])) {
        $builder->where('u.rol', $filtros['rol']);
    }
    
    if (!empty($filtros['desde'])) {
        $builder->where('u.fecha_registro >=', $filtros['desde']);
    }
    
    return $builder->get()->getResultArray();
}

    public function getUsuarioCompleto($usuario_id)
    {
        $usuario = $this->find($usuario_id);
        if (!$usuario) {
            return null;
        }

        $db = \Config\Database::connect();
        $persona = $db->table('personas')->where('usuario_id', $usuario_id)->get()->getRowArray();
        $usuario['persona'] = $persona;
        
        return $usuario;
    }
    
    public function getPersona($usuario_id)
    {
        $db = \Config\Database::connect();
        return $db->table('personas')->where('usuario_id', $usuario_id)->get()->getRowArray();
    }
}