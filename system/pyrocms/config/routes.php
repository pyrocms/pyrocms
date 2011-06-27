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
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the 'welcome' class
| would be loaded.
|
*/

$route['default_controller'] = 'pages';
$route['404_override'] = 'pages';

$route['admin/help/([a-zA-Z_-]+)']		= 'admin/help/$1';
$route['admin/([a-zA-Z_-]+)/(:any)']	= '$1/admin/$2';
$route['admin/(login|logout)']			= 'admin/$1';
$route['admin/([a-zA-Z_-]+)']			= '$1/admin/index';

$route['register'] = 'users/register';

$route['user/([\w]+)']	= 'users/view/$1';
$route['my-profile']	= 'users/index';
$route['edit-profile']	= 'users/edit';
$route['edit-settings']	= 'users/edit';

// Just for now, map calls to /news to /blog
$route['news']							= 'blog';
$route['news/(:num)/(:num)/(:any)']		= 'blog/view/$3';
$route['news/page(/:num)?']				= 'blog/index$1';
$route['news/rss/all.rss']				= 'blog/rss/index';
$route['news/rss/(:any).rss']			= 'blog/rss/category/$1';