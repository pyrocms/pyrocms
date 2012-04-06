<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Step 1: Configure Database and Server';
$lang['intro_text']		=	'PyroCMS is very easy to install and should only take a few minutes, but there are a few questions that may appear confusing if you do not have a technical background. If at any point you get stuck please ask your web hosting provider or <a href="http://www.pyrocms.com/contact" target="_blank">contact us</a> for support.';

$lang['db_settings']	=	'Database Settings';
$lang['db_text']		=	'PyroCMS requires a database (MySQL) to store all of your content and settings, so the first thing we need to do is check if the database connection details are ok. If you do not understand what you are being asked to enter please ask your web hosting provider or server administrator for the details.';
$lang['db_missing']		=	'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.';

$lang['server']			=	'MySQL Hostname';
$lang['username']		=	'MySQL Username';
$lang['password']		=	'MySQL Password';
$lang['portnr']			=	'MySQL Port';
$lang['server_settings']=	'Server Settings';
$lang['httpserver']		=	'HTTP Server';

$lang['httpserver_text']=	'PyroCMS requires a HTTP Server to display dynamic content when a user goes to your website. It looks like you already have one by the fact that you can see this page, but if we know exactly which type then PyroCMS can configure itself even better. If you do not know what any of this means just ignore it and carry on with the installation.';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']			=	'Step 2';

// messages
$lang['db_success']		=	'The database settings are tested and working fine.';
$lang['db_failure']		=	'Problem connecting to the database: ';

/* End of file step_1_lang.php */
