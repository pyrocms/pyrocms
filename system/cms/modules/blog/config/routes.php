<?php defined('BASEPATH') OR exit('No direct script access allowed');
$route['blog/rss/all.rss']='blog/rss/index';
$route['blog']	= 'blog';
$route['blog/search']					= 'blog/search';
$route['blog/tagged/(:any)?']			= 'blog/tagged/$1';
$route['blog/rss/all.rss']			= 'blog/rss/index';
$route['blog/(:num)?']				= 'blog/index/$1';
$route['blog/rss/(:any).rss']		    = 'blog/rss/category/$1';
$route['blog/admin/categories(/:any)?']		= 'admin_categories$1';
/* End of file routes.php */