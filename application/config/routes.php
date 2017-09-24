<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "inicio";
$route['404_override'] = '';


/* RUTAS */

$route['login']                                 = 'inicio/login';
$route['logout']                                = 'inicio/logout';

$route['tipo-curso/editar/(:num)']              = 'tipo_curso/editar/$1';
$route['tipo-curso/editar']                     = 'tipo_curso/editar';
$route['tipo-curso/agregar']                    = 'tipo_curso/agregar';
$route['tipo-curso']                            = 'tipo_curso';

$route['tipo-manual/editar/(:num)']             = 'tipo_manual/editar/$1';
$route['tipo-manual/editar']                    = 'tipo_manual/editar';
$route['tipo-manual/agregar']                   = 'tipo_manual/agregar';
$route['tipo-manual']                           = 'tipo_manual';

$route['estudio-factibilidad/editar/(:num)']    = 'estudio_factibilidad/editar/$1';
$route['estudio-factibilidad/editar']           = 'estudio_factibilidad/editar';
$route['estudio-factibilidad/agregar']          = 'estudio_factibilidad/agregar';
$route['estudio-factibilidad/cronograma']       = 'estudio_factibilidad/cronograma';
$route['estudio-factibilidad/curso']            = 'estudio_factibilidad/curso';
$route['estudio-factibilidad/estados']          = 'estudio_factibilidad/estados';
$route['estudio-factibilidad/agregar-hora']     = 'estudio_factibilidad/agregar_hora';
$route['estudio-factibilidad/libro-clase']      = 'estudio_factibilidad/libro_clase';
$route['estudio-factibilidad']                  = 'estudio_factibilidad';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
