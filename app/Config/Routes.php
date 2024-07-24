<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'CrudController::index');
$routes->get('crudcontroller/fetchAll', 'CrudController::fetchAll');
$routes->get('crudcontroller/fetchSingle/(:num)', 'CrudController::fetchSingle/$1');
$routes->post('crudcontroller/create', 'CrudController::create');
$routes->put('crudcontroller/update/(:num)', 'CrudController::update/$1');
$routes->delete('crudcontroller/delete/(:num)', 'CrudController::delete/$1');
