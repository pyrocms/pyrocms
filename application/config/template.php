<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Theme
|--------------------------------------------------------------------------
|
| Which theme to use by default?
| This can be overriden with $this->template->set_theme('foo');
|
|	some_theme
|
|   Default: ''
|
*/

$config['theme'] = 'default';

/*
|--------------------------------------------------------------------------
| Theme
|--------------------------------------------------------------------------
|
| Where should we expect to see themes?
|
|	Default: array(APPPATH.'themes/' => '../themes/')
|
*/

$config['theme_locations'] = array(
	APPPATH.'themes/' => '../themes/',
	'third_party/themes/' => '../../third_party/themes/'
);

?>