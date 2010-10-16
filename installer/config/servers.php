<?php
/*
|--------------------------------------------------------------------------
| Supported servers
|--------------------------------------------------------------------------
|
| An array that contains a list of servers supported by PyroCMS.
|
*/

$config['supported_servers'] = array(

	'apache_wo' => array(
		'name' => 'Apache (without mod_rewrite)',
		'rewrite_support' => FALSE
	),
	
	'apache_w' => array(
		'name' => 'Apache (with mod_rewrite)',
		'rewrite_support' => TRUE
	),
	
	'abyss' => array(
		'name' => 'Abyss Web Server X1/X2',
		'rewrite_support' => FALSE
	),
	
	'cherokee' => array(
		'name' => 'Cherokee Web Server 0.99.x',
		'rewrite_support' => FALSE
	),
	
	'uniform' => array(
		'name' => 'Uniform Server 4.x/5.x',
		'rewrite_support' => FALSE
	),
	
	'zend' => array(
		'name' => 'Zend Server',
		'rewrite_support' => TRUE
	),
	
	'other'	=> array(
		'name' => 'Other',
		'rewrite_support' => FALSE
	)
);