<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');


// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}


/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
/* Usuarios */
$routes->match(['get', 'post'], '/', 'Usuario::login', 		['as' => 'login', 'filter' => 'noauth']);
$routes->get('logout', 				'Usuario::logout',		['as' => 'logout']);
$routes->get('usuario', 			'Usuario::index', 		['filter' => 'auth']);
$routes->post('usuario/lista', 		'Usuario::obtenerData', ['filter' => 'auth']);
$routes->post('usuario/agregar', 	'Usuario::agregar', 	['filter' => 'super']);
$routes->post('usuario/editar', 	'Usuario::editar', 		['filter' => 'auth']);
$routes->put('usuario/update', 		'Usuario::update', 		['filter' => 'auth']);
$routes->post('usuario/borrar', 	'Usuario::borrar', 		['filter' => 'super']);
$routes->delete('usuario/delete',	'Usuario::delete', 		['filter' => 'super']);
/* Home */
$routes->get('home', 		'Home::index', 		['as' => 'home', 'filter' => 'auth']);
$routes->post('datosHome', 	'Home::datosHome', 	['as' => 'home', 'filter' => 'auth']);
