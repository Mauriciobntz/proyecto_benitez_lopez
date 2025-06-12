<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\ProductoController;
use App\Controllers\Home;
use App\Controllers\UsuarioController;
use App\Controllers\CategoriaController;
use App\Controllers\VentaController;
use App\Controllers\ConsultaController;
use App\Controllers\ResenaController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rutas públicas
$routes->get('principal', 'Home::index');
$routes->get('somos', 'Home::somos');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('terminos', 'Home::terminos');
//borrar
$routes->get('panel', 'Home::panel');
$routes->get('denegado', 'Home::denegado');



// Rutas de autenticación
$routes->get('login', 'UsuarioController::formularioLogin');
$routes->post('login', 'UsuarioController::procesarLogin');
$routes->get('logout', 'UsuarioController::cerrarSesion');

// Rutas de registro
$routes->get('sign', 'UsuarioController::formularioRegistro');
$routes->post('sign', 'UsuarioController::procesarRegistro');

//######################## Rutas Productos ########################

// Rutas públicas (accesibles sin autenticación)
$routes->get('productos', [ProductoController::class, 'productos']);
$routes->get('productos/destacados', [ProductoController::class, 'listarDestacados']);
$routes->get('productos/categoria/(:num)', [ProductoController::class, 'productosPorCategoria']);
$routes->get('productos/buscar', [ProductoController::class, 'buscar']);
$routes->get('productos/(:num)', [ProductoController::class, 'detalle']);
// revisar
$routes->get('contacto', 'ConsultaController::formularioContacto');
$routes->post('contacto/procesar', 'ConsultaController::procesarConsulta');

// Rutas protegidas (requieren autenticación)
$routes->post('productos/(:num)/resena', [ProductoController::class, 'agregarResena'], ['filter' => 'auth']);



// Rutas de administrador (requieren rol admin)
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('productos/listar', [ProductoController::class, 'listar']);
    $routes->get('productos/crear', [ProductoController::class, 'agregarProducto']);
    $routes->post('productos/guardar', [ProductoController::class, 'guardarProducto']);
    $routes->get('productos/editar/(:num)', [ProductoController::class, 'editarProducto']);
    $routes->post('productos/actualizar/(:num)', [ProductoController::class, 'actualizarProducto']);
    $routes->post('productos/verificar-ventas/(:num)', [ProductoController::class, 'verificarVentas']);
    $routes->post('productos/desactivar/(:num)', [ProductoController::class, 'desactivar']);
    $routes->post('productos/eliminar/(:num)', [ProductoController::class, 'eliminar']);

    // Rutas para categorías
    $routes->get('categorias/listar', [CategoriaController::class, 'listar']);
    $routes->get('categorias/crear', [CategoriaController::class, 'agregar']);
    $routes->post('categorias/guardar', [CategoriaController::class, 'guardar']);
    $routes->get('categorias/editar/(:num)', [CategoriaController::class, 'editar']);
    $routes->post('categorias/actualizar/(:num)', [CategoriaController::class, 'actualizar']);
    $routes->get('categorias/eliminar/(:num)', [CategoriaController::class, 'eliminar']);

    // Rutas para ventas
    $routes->get('ventas/listar', [VentaController::class, 'listar']);
    $routes->get('ventas/detalle/(:num)', [VentaController::class, 'detalle']);
    $routes->post('ventas/actualizar-estado/(:num)', [VentaController::class, 'actualizarEstado']);
    $routes->get('ventas/factura/(:num)', [VentaController::class, 'generarFactura']);

    // Usuarios
    $routes->get('usuarios/listar', [UsuarioController::class, 'listarUsuarios']);
    $routes->get('usuarios/editar/(:num)', [UsuarioController::class, 'editarUsuario']);
    $routes->post('usuarios/actualizar/(:num)', [UsuarioController::class, 'actualizarUsuario']);
    $routes->get('usuarios/agregar', [UsuarioController::class, 'agregarUsuario']);
    $routes->post('usuarios/guardar', [UsuarioController::class, 'guardarUsuario']);
    $routes->get('usuarios/perfil/(:num)', [UsuarioController::class, 'perfilUsuario']);
    


    // Consultas
    $routes->get('consultas/listar', [ConsultaController::class, 'listarConsultas']);
    $routes->get('consultas/detalle/(:num)', [ConsultaController::class, 'detalleConsulta']);
    $routes->post('consultas/actualizar-estado/(:num)', [ConsultaController::class, 'actualizarEstado']);

    // Reseñas
    $routes->get('resenas/listar', [ResenaController::class, 'listar']);
    $routes->get('resenas/editar/(:num)', [ResenaController::class, 'editar']);
    $routes->post('resenas/actualizar/(:num)', [ResenaController::class, 'actualizar']);
    $routes->get('resenas/eliminar/(:num)', [ResenaController::class, 'eliminar']);
});




$routes->group('usuario', ['filter' => 'auth'], function($routes) {
    $routes->get('mi-perfil', [UsuarioController::class, 'miPerfil']);
    $routes->post('actualizar-perfil', [UsuarioController::class, 'actualizarPerfil']);
    $routes->post('productos/(:num)/resena', [ProductoController::class, 'agregarResena']);
    $routes->get('mis-resenas', [ProductoController::class, 'misResenas']);
});

