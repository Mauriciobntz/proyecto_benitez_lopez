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

    protected $beforeInsert = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password_hash'])) {
            return $data;
        }

        $data['data']['password_hash'] = password_hash($data['data']['password_hash'], PASSWORD_DEFAULT);
        return $data;
    }

    // Validación para registro
    public function getRegistrationRules()
    {
        return [
            'username' => [
                'rules' => 'required|min_length[3]|max_length[50]|is_unique[usuarios.username]',
                'errors' => [
                    'required' => 'El nombre de usuario es obligatorio',
                    'min_length' => 'El nombre de usuario debe tener al menos 3 caracteres',
                    'max_length' => 'El nombre de usuario no puede exceder los 50 caracteres',
                    'is_unique' => 'Este nombre de usuario ya está en uso'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[usuarios.email]',
                'errors' => [
                    'required' => 'El correo electrónico es obligatorio',
                    'valid_email' => 'Por favor ingresa un correo electrónico válido',
                    'is_unique' => 'Este correo electrónico ya está registrado'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'La contraseña es obligatoria',
                    'min_length' => 'La contraseña debe tener al menos 8 caracteres'
                ]
            ],
            'password_confirm' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Por favor confirma tu contraseña',
                    'matches' => 'Las contraseñas no coinciden'
                ]
            ]
        ];
    }

    // Buscar usuario por email
    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    // Buscar usuario por username
    public function findByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}