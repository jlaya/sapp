<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'ControllersUser';
$route['dashboard'] = "ControllersUser/dashboard";
$route['accion/([0-9]+)'] = "reportes/generacion/ControllersReportes/pdf_accion_centralizada/$1";
$route['proyecto/([0-9]+)'] = "reportes/generacion/ControllersReportes/pdf_proyecto/$1";
$route['tomo/([0-9]+)/([a-z 0-9 -]+)'] = "reportes/generacion/ControllersReportes/ley_presupuestaria_tomo_I/$1/$2";
$route['poa/([0-9]+)/([a-z 0-9 -]+)'] = "reportes/generacion/ControllersReportes/plan_operativo_anual/$1/$2";
$route['poam/([0-9]+)/([a-z 0-9 -]+)'] = "reportes/generacion/ControllersReportes/plan_operativo_anual_mod/$1/$2";
$route['control_general/([0-9]+)/([a-z 0-9 -]+)'] = "reportes/generacion/ControllersReportes/control_general/$1/$2";
$route['bitacora/([0-9]+)/([0-9]+)/([0-9]+)/([a-z 0-9 -]+)/([a-z 0-9 -]+)'] = "reportes/generacion/ControllersReportes/bitacora/$1/$2/$3/$4/$5";
// Contro Modulo de gestion
$route['gestion/panel'] = "gestion/GestionControllers/panel";
$route['gestion/acc/([0-9]+)'] = "gestion/GestionControllers/home/$1";
$route['gestion/proy/([0-9]+)'] = "gestion/GestionControllers/proy/$1";
$route['gestion/update_accion'] = "gestion/GestionControllers/updateAction";
$route['gestion/ejecucion_fin_original'] = "gestion/GestionControllers/ejecucion_fin_original";
$route['gestion/send_proy'] = "gestion/GestionControllers/send_proy";
/*$route['gestion/search'] = $route['gestion']."/search";
$route['gestion/estructura'] = $route['gestion']."/list_estructura";
$route['gestion/activity'] = $route['gestion']."/search_activity";
$route['gestion/update_activity'] = $route['gestion']."/updateAction";
$route['gestion/update_financiero'] = $route['gestion']."/updateActionFAcc";
$route['gestion/delete_financiero'] = $route['gestion']."/deleteActionFAcc";
$route['gestion/send_email'] = $route['gestion']."/send_email";
*/
// Reporte Modulo Control de Gestion
$route['pdf/([0-9]+)'] = "gestion/GestionControllers/pdf_accion/$1";
$route['accion_pdf/([0-9]+)/([0-9]+)/([0-9]+)'] = "gestion/GestionControllers/accion_pdf/$1/$2/$3";
$route['proyecto_pdf/([0-9]+)/([0-9]+)/([0-9]+)'] = "gestion/GestionControllers/proyecto_pdf/$1/$2/$3";
$route['accion_gestion/([0-9]+)'] = "reportes/generacion/ControllersReportes/pdf_accion_centralizada/$1";
$route['proyecto_gestion/([0-9]+)'] = "reportes/generacion/ControllersReportes/pdf_proyecto/$1";
$route['send_email/([0-9]+)'] = $route['default_controller']."/send_email/$1";
$route['404_override'] = "ControllersUser/error_404";
$route['translate_uri_dashes'] = FALSE;
