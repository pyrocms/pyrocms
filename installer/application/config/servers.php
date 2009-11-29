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
	
	'apache' =>	array(
		'name' => 'Apache (/w mod_rewrite)',
		'rewrite_support' => TRUE
	),
	
	'abyss' => array(
		'name' => 'Abyss',
		'rewrite_support' => FALSE
	),
	
	'cherokee' => array(
		'name' => 'Cherokee',
		'rewrite_support' => FALSE
	),
	
	'zend' => array(
		'name' => 'Zend Server',
		'rewrite_support' => FALSE
	),
	
	'other'	=> array(
		'name' => 'Other',
		'rewrite_support' => FALSE
	)
);
?>