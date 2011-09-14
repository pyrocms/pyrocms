<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Step 1: Configure Database and Server';
$lang['intro_text']		=	'Before we can check the database, we need to know where it is and what the login details are.';

$lang['db_settings']	=	'Database Settings';
$lang['db_text']		=	'In order for the installer to check your MySQL server version it requires you to enter the hostname, username and password in the form below. These settings will also be used when installing the database.';

$lang['server']			=	'Server';
$lang['username']		=	'Username';
$lang['password']		=	'Password';
$lang['portnr']			=	'Port';
$lang['server_settings']=	'Server Settings';
$lang['httpserver']		=	'HTTP Server';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']			=	'Step 2';

// messages
$lang['db_success']		=	'The database settings are tested and working fine.';
$lang['db_failure']		=	'Problem connecting to the database: ';

/* End of file step_1_lang.php */
/* Location: ./installer/language/english/step_1_lang.php */
