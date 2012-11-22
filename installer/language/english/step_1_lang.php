<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Step 1: Configure Database and Server';
$lang['intro_text']		=	'PyroCMS is very easy to install and should only take a few minutes, but there are a few questions that may appear confusing if you do not have a technical background. If at any point you get stuck please ask your web hosting provider or <a href="http://www.pyrocms.com/contact" target="_blank">contact us</a> for support.';

$lang['db_engine']		=	 'Database Engine';
$lang['mysql_about']    =    'MySQL is the world\'s most used open-source database. It is fast, popular and installed on the majority of web servers.';
$lang['use_mysql']		= 	 'Use MySQL';
$lang['pgsql_about'] 	=    'PostgreSQL is a popular alternative to MySQL. It is often slightly quicker but is installed on less servers by default.';
$lang['use_pqsql']		= 	 'Use PostgreSQL';
$lang['sqlite_about']   =    'SQLite is a lightweight file-based SQL engine, which installed on many servers and part of PHP as of PHP 5.3.';
$lang['use_sqlite']		= 	 'Use SQLite';

$lang['not_available']		= 	 'Not Available';

$lang['db_settings']		=	'Settings';
$lang['db_server']			=	'Hostname';
$lang['db_location']		=	'Location';
$lang['db_username']		=	'Username';
$lang['db_password']		=	'Password';
$lang['db_portnr']			=	'Port';
$lang['db_database']		=	'Database Name';
$lang['db_create']			=	'Create Database';
$lang['db_notice']			=	'You might need to do this yourself';

$lang['server_settings']	=	'Server Settings';
$lang['httpserver']			=	'HTTP Server';

$lang['httpserver_text']	=	'PyroCMS requires a HTTP Server to display dynamic content when a user goes to your website. It looks like you already have one by the fact that you can see this page, but if we know exactly which type then PyroCMS can configure itself even better. If you do not know what any of this means just ignore it and carry on with the installation.';
$lang['rewrite_fail']		=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']		=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']				=	'Step 2';

// messages	
$lang['db_success']			=	'The database settings are tested and working fine.';
$lang['db_failure']			=	'Problem connecting to the database: ';

/* End of file step_1_lang.php */