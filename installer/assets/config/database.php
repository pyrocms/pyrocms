<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class
*/

// Development
$db['development'] = array(
	'dbdriver' 	=> 	'pdo',
	'dsn'		=> 	'{driver}:host={hostname};dbname={database};port={port}',
	'username'	=> 	'{username}',
	'password'	=> 	'{password}',
	'pconnect' 	=>	true,
	'db_debug' 	=>	true,
	'cache_on' 	=>	false,
	'char_set' 	=>	'utf8',
	'dbcollat' 	=>	'utf8_unicode_ci',
);

// Staging
/*
$db['staging'] = array(
	'dsn'		=> 	'',
	'dbdriver' 	=> 	'pdo',
	'username'	=> 	'{username}',
	'password'	=> 	'{password}',
	'active_r' 	=>	TRUE,
	'pconnect' 	=>	FALSE,
	'db_debug' 	=>	FALSE,
	'cache_on' 	=>	FALSE,
	'char_set' 	=>	'utf8',
	'dbcollat' 	=>	'utf8_unicode_ci',
);
*/

// Production
$db['production'] = array(
	'dbdriver' 	=> 	'pdo',
	'dsn'		=> 	'{driver}:host={hostname};dbname={database};port={port}',
	'username'	=> 	'{username}',
	'password'	=> 	'{password}',
	'pconnect' 	=>	true,
	'db_debug' 	=>	true,
	'cache_on' 	=>	false,
	'char_set' 	=>	'utf8',
	'dbcollat' 	=>	'utf8_unicode_ci',
);

// Check the configuration group in use exists
if ( ! array_key_exists(ENVIRONMENT, $db)) {
	show_error(sprintf(lang('error_invalid_db_group'), ENVIRONMENT));
}

// Assign the group to be used
$active_group = ENVIRONMENT;
$query_builder = true;

/* End of file database.php */