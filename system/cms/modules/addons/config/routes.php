<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
| 	www.your-site.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://www.codeigniter.com/user_guide/general/routing.html
*/

$route['addons/admin/index']				= 'admin_modules';
$route['addons/admin/modules(/:any)?']		= 'admin_modules$1';
$route['addons/admin/themes(/:any)?']		= 'admin_themes$1';
$route['addons/admin/widgets(/:any)?']		= 'admin_widgets$1';
$route['addons/admin/plugins?']				= 'admin_plugins';
$route['addons/admin/field-types?']			= 'admin_field_types';