<?php defined('BASEPATH') OR exit('No direct script access allowed');
$route['blog/rss/all.rss']='blog/rss/index';
$route['default_controller'] = 'blog';
$route['search']					= 'blog/search';
$route['tagged/(:any)?']			= 'blog/tagged/$1';
$route['rss/all.rss']			= 'blog/rss/index';
$route['(:num)?']				= 'blog/index/$1';
$route['rss/(:any).rss']		    = 'blog/rss/category/$1';
$route['blog/admin/categories(/:any)?']		= 'admin_categories$1';
/* End of file routes.php */