<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['active_r'] TRUE/FALSE - Whether to load the active record class
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
*/

// Local
$db['local']['hostname'] = '__HOSTNAME__';
$db['local']['username'] = '__USERNAME__';
$db['local']['password'] = '__PASSWORD__';
$db['local']['database'] = '__DATABASE__';
$db['local']['dbdriver'] = 'mysql';
$db['local']['dbprefix'] = '';
$db['local']['stricton'] = TRUE;
$db['local']['active_r'] = TRUE;
$db['local']['pconnect'] = TRUE;
$db['local']['db_debug'] = TRUE;
$db['local']['cache_on'] = FALSE;
$db['local']['cachedir'] = '';
$db['local']['char_set'] = 'utf8';
$db['local']['dbcollat'] = 'utf8_unicode_ci';
$db['local']['port'] 	 = __PORT__;

// 'Tough love': Forces strict mode to test your app for best compatibility
$db['local']['stricton'] = TRUE;

// Dev
//$db['dev']['hostname'] = 'localhost';
// ...etc

// QA
//$db['qa']['hostname'] = 'localhost';
// ...etc

// Live
$db['live']['hostname'] = '__HOSTNAME__';
$db['live']['username'] = '__USERNAME__';
$db['live']['password'] = '__PASSWORD__';
$db['live']['database'] = '__DATABASE__';
$db['live']['dbdriver'] = 'mysql';
$db['live']['dbprefix'] = '';
$db['live']['stricton'] = TRUE;
$db['live']['active_r'] = TRUE;
$db['live']['pconnect'] = TRUE;
$db['live']['db_debug'] = TRUE;
$db['live']['cache_on'] = FALSE;
$db['live']['cachedir'] = '';
$db['live']['char_set'] = 'utf8';
$db['live']['dbcollat'] = 'utf8_unicode_ci';
$db['live']['port'] 	= __PORT__;

// Check the configuration group in use exists
if(!array_key_exists(ENVIRONMENT, $db))
{
	show_error(sprintf(lang('error_invalid_db_group'), ENVIRONMENT));
}

// Assign the group to be used
$active_group = ENVIRONMENT;