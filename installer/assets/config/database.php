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

// Development
$db[PYRO_DEVELOPMENT] = array(
	'hostname'		=> 	'__HOSTNAME__',
	'username'		=> 	'__USERNAME__',
	'password'		=> 	'__PASSWORD__',
	'database'		=> 	'__DATABASE__',
	'dbdriver' 		=> 	'__DRIVER__',
	'dbprefix' 		=>	'',
	'pconnect' 		=>	FALSE,
	'db_debug' 		=>	TRUE,
	'cache_on' 		=>	FALSE,
	'char_set' 		=>	'utf8',
	'dbcollat' 		=>	'utf8_unicode_ci',
	'port' 	 		=>	'__PORT__',

	// 'Tough love': Forces strict mode to test your app for best compatibility
	'stricton' 		=> TRUE,
);

// Staging
/*
$db[PYRO_STAGING] = array(
	'hostname'		=> 	'',
	'username'		=> 	'',
	'password'		=> 	'',
	'database'		=> 	'pyrocms',
	'dbdriver' 		=> 	'mysql',
	'active_r' 		=>	TRUE,
	'pconnect' 		=>	FALSE,
	'db_debug' 		=>	FALSE,
	'cache_on' 		=>	FALSE,
	'char_set' 		=>	'utf8',
	'dbcollat' 		=>	'utf8_unicode_ci',
	'port' 	 		=>	3306,
);
*/

// Production
$db[PYRO_PRODUCTION] = array(
	'hostname'		=> 	'__HOSTNAME__',
	'username'		=> 	'__USERNAME__',
	'password'		=> 	'__PASSWORD__',
	'database'		=> 	'__DATABASE__',
	'dbdriver' 		=> 	'__DRIVER__',
	'pconnect' 		=>	FALSE,
	'db_debug' 		=>	FALSE,
	'cache_on' 		=>	FALSE,
	'char_set' 		=>	'utf8',
	'dbcollat' 		=>	'utf8_unicode_ci',
	'port' 	 		=>	'__PORT__',
);


// Check the configuration group in use exists
if ( ! array_key_exists(ENVIRONMENT, $db))
{
	show_error(sprintf(lang('error_invalid_db_group'), ENVIRONMENT));
}

// Assign the group to be used
$active_group = ENVIRONMENT;
$query_builder = TRUE;

/* End of file database.php */