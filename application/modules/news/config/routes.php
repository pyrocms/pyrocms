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

$route['news/index'] = "news/index";
$route['news/admin'] = "news/admin";

$route['news/(:num)/(:num)/(:any)'] = "news/view/$3";
$route['news/page/(:num)'] = "news/index/$1";

$route['news/rss/index'] = "news/rss";
$route['news/rss/all.rss'] = "news/rss";
$route['news/rss/(:any).rss'] = "news/rss/category/$1";

// Category routes
$route['news/category/(:any)/(:num)'] = "news/category/$1"; // Paginated category routes
$route['news/category/(:any)'] = "news/category/$1"; // Main category page

// Archive routes
$route['news/archive/(:num)/(:num)/(:num)'] = "news/archive/$1/$2"; // Paginated pages
$route['news/archive/(:num)/(:num)'] = "news/archive/$1/$2"; // Main archive pages

$route['news/(:any)'] = "news/view/$1";

?>