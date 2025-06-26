<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login')
                ->with('error', 'Por favor inicia sesión primero');
        }

        // Verificar si el usuario no es administrador
        // y redirigir a una página de acceso denegado
        if (session()->get('rol') == 'admin') {
            return redirect()->to('denegado')
                ->with('error', 'Tienes permisos de administrador');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No es necesario hacer nada después
    }
}