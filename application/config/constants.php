<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb');	// truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Environment
|--------------------------------------------------------------------------
*/

// Local: localhost or local.example.com
if(strpos($_SERVER['SERVER_NAME'], 'local') !== FALSE)
{
  define('ENV', 'local');
}

// Development: dev.example.com
elseif(strpos($_SERVER['SERVER_NAME'], 'dev.') === 0)
{
  define('ENV', 'dev');
}

// Quality Assurance: qa.example.com
elseif(strpos($_SERVER['SERVER_NAME'], 'qa.') === 0)
{
  define('ENV', 'qa');
}

// Live: example.com
else
{
  define('ENV', 'live');
}

/*
|--------------------------------------------------------------------------
| Docment root folders
|--------------------------------------------------------------------------
|
| These constants use existing location information to work out web root, etc.
|
*/

$base_uri = parse_url(config_item('base_url'), PHP_URL_PATH);
if(substr($base_uri, 0, 1) != '/') $base_uri = '/'.$base_uri;
if(substr($base_uri, -1, 1) != '/') $base_uri .= '/';

define('BASE_URI', $base_uri);
define('APPPATH_URI', BASE_URI.APPPATH);

unset($base_uri);

/*
|--------------------------------------------------------------------------
| PyroCMS Version
|--------------------------------------------------------------------------
|
| Which version of PyroCMS is currently running?
|
*/

define('CMS_VERSION', '0.9.6');


/* End of file constants.php */
/* Location: ./system/application/config/constants.php */
