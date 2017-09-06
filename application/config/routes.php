<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "inicio";
$route['404_override'] = '';


/* RUTAS */

$route['login']                     = 'inicio/login';
$route['logout']                    = 'inicio/logout';

$route['tipo-curso/editar/(:num)']  = 'tipo_curso/editar/$1';
$route['tipo-curso/editar']         = 'tipo_curso/editar';
$route['tipo-curso/agregar']        = 'tipo_curso/agregar';
$route['tipo-curso']                = 'tipo_curso';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
