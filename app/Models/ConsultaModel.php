<?php
namespace App\Models;

use CodeIgniter\Model;

class ConsultaModel extends Model
{
    protected $table = 'consultas';
    protected $primaryKey = 'id_consulta';
    protected $allowedFields = [
        'nombre', 
        'razon_social',
        'correo',
        'telefono',
        'asunto',
        'mensaje',
        'preferencia_contacto',
        'estado',
        'fecha_actualizacion'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_creacion';
    protected $updatedField = 'fecha_actualizacion';
    protected $beforeUpdate = ['actualizarFecha'];

    protected function actualizarFecha(array $data)
    {
        $data['data']['fecha_actualizacion'] = date('Y-m-d H:i:s');
        return $data;
    }

    // Obtener consultas con filtros
    public function getConsultas($filtros = [])
    {
        $builder = $this->builder();
        
        // Aplicar filtros
        if (!empty($filtros['search'])) {
            $builder->groupStart()
                   ->like('nombre', $filtros['search'])
                   ->orLike('correo', $filtros['search'])
                   ->orLike('mensaje', $filtros['search'])
                   ->groupEnd();
        }
        
        if (!empty($filtros['estado'])) {
            $builder->where('estado', $filtros['estado']);
        }
        
        if (!empty($filtros['asunto'])) {
            $builder->where('asunto', $filtros['asunto']);
        }
        
        if (!empty($filtros['desde'])) {
            $builder->where('fecha_creacion >=', $filtros['desde'] . ' 00:00:00');
        }
        
        if (!empty($filtros['hasta'])) {
            $builder->where('fecha_creacion <=', $filtros['hasta'] . ' 23:59:59');
        }

        return $builder->orderBy('fecha_creacion', 'DESC')
                      ->get()
                      ->getResultArray();
    }

    // Actualizar estado de una consulta
    public function actualizarEstado($id_consulta, $estado)
    {
        return $this->update($id_consulta, ['estado' => $estado]);
    }

    // Contar mensajes sin leer
    public function contarSinLeer()
    {
        return $this->where('estado', 'Sin Leer')->countAllResults();
    }
}