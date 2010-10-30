<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Parser cache directory
|--------------------------------------------------------------------------
|
| Path to where the parser should put its cache files
|
|	default: APPPATH.'cache/dwoo/'
|
*/

$config['parser_cache_dir'] = APPPATH.'cache/dwoo/';


/*
|--------------------------------------------------------------------------
| Parser cache directory
|--------------------------------------------------------------------------
|
| Path to where the parser should put its compiled files
|
|	default: APPPATH.'cache/dwoo/compiled'
|
*/

$config['parser_compile_dir'] = APPPATH.'cache/dwoo/compiled/';


/*
|--------------------------------------------------------------------------
| Parser cache time
|--------------------------------------------------------------------------
|
| This tells Dwoo whether or not to cache the output of the templates to the $cache_dir
|
|	0 = off
|
*/

$config['parser_cache_time'] = 0;


/*
|--------------------------------------------------------------------------
| Allow php tags
|--------------------------------------------------------------------------
|
| Set what parser should do with PHP tags. Enode them, remove or allow.
|
|	1 - Encode tags
|	2 - Remove tags
|	3 - Allow tags
|
*/

$config['parser_allow_php_tags'] = 2;


/*
|--------------------------------------------------------------------------
| Allow php tags
|--------------------------------------------------------------------------
|
| Which functions should be accessable through Parser
|
| These functions are enabled regardless what you put in the array:
|
| 	'str_repeat', 'number_format', 'htmlentities', 'htmlspecialchars',
	'long2ip', 'strlen', 'list', 'empty', 'count', 'sizeof', 'in_array', 'is_array'

*/

$config['parser_allowed_php_functions'] = array(
	'strip_tags'
);


/*
|--------------------------------------------------------------------------
| CodeIgniter library/model names
|--------------------------------------------------------------------------
|
| Pick selective parts of the CI super-global to use in Dwoo
|
|	array('asset', 'load', 'security', 'session', 'uri', 'input', 'user_agent');
|
*/

$config['parser_assign_refs'] = array('asset', 'load', 'security', 'session', 'settings', 'uri', 'input', 'user_agent');