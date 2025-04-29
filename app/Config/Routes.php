<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('principal', 'Home::index');
$routes->get('somos', 'Home::somos');
$routes->get('productos', 'Home::productos');
$routes->get('celulares', 'Home::celulares');
$routes->get('notebooks', 'Home::notebooks');
$routes->get('auriculares', 'Home::auriculares');
$routes->get('perifericos', 'Home::perifericos');
$routes->get('tablets', 'Home::tablets');
$routes->get('contacto', 'Home::contacto');
$routes->get('producto', 'Home::producto');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('consultas', 'Home::consultas');
$routes->get('login', 'Home::login');
$routes->get('sign', 'Home::sign');
$routes->get('terminos', 'Home::terminos');