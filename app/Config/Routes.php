<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\ProductoController;
use App\Controllers\Home;
use App\Controllers\UsuarioController;
use App\Controllers\CategoriaController;
use App\Controllers\VentaController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rutas públicas
$routes->get('principal', 'Home::index');
$routes->get('somos', 'Home::somos');
$routes->get('contacto', 'Home::contacto');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('consultas', 'Home::consultas');
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

// Rutas protegidas (requieren autenticación)
$routes->post('productos/(:num)/resena', [ProductoController::class, 'agregarResena'], ['filter' => 'auth']);



// Rutas de administrador (requieren rol admin)
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('productos/listar', [ProductoController::class, 'listar']);
    $routes->get('productos/crear', [ProductoController::class, 'agregarProducto']);
    $routes->post('productos/guardar', [ProductoController::class, 'guardarProducto']);
    $routes->get('productos/editar/(:num)', [ProductoController::class, 'editarProducto']);
    $routes->post('productos/actualizar/(:num)', [ProductoController::class, 'actualizarProducto']);

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
});

