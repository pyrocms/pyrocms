<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://www.codeigniter.com/user_guide/general/hooks.html
|
*/

// PRE CONTROLLER HOOKS
$hook['pre_controller'][] = array(
	'function' => 'pick_language',
	'filename' => 'pick_language.php',
	'filepath' => 'hooks'
);

# PERFORM-TWEAK: Disable this to make your system slightly quicker
$hook['pre_controller'][] = array(
	'function' => 'check_installed',
	'filename' => 'check_installed.php',
	'filepath' => 'hooks'
);