<?php

# If you have already installed then delete this
if ( ! file_exists('system/cms/config/database.php')) {
	
	// Make sure we've not already tried this
	if (strpos($_SERVER['REQUEST_URI'], 'installer/')) {
		header('Status: 404');
		exit('PyroCMS is missing system/cms/config/database.php and cannot find the installer folder. Does your server have permission to access these files?');
	}
	
	// Otherwise go to installer
	header('Location: '.rtrim($_SERVER['REQUEST_URI'], '/').'/installer/');
	exit;
}

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     local
 *     staging
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */

define('PYRO_DEVELOPMENT', 'development');
define('PYRO_STAGING', 'staging');
define('PYRO_PRODUCTION', 'production');

define('ENVIRONMENT', getenv('PYRO_ENV') ?: PYRO_DEVELOPMENT);

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * The development environment will show errors by default.
 */

	if (ENVIRONMENT === PYRO_DEVELOPMENT or getenv('PYRO_DEBUG') === 'on') {
		error_reporting(-1);
		ini_set('display_errors', true);
	} else {
		ini_set('display_errors', false);
	}
	
/*
|---------------------------------------------------------------
| DEFAULT INI SETTINGS
|---------------------------------------------------------------
|
| Hosts have a habbit of setting stupid settings for various
| things. These settings should help provide maximum compatibility
| for PyroCMS
|
*/

	// Let's hold Windows' hand and set a include_path in case it forgot
	set_include_path(dirname(__FILE__));

	// Some hosts (was it GoDaddy? complained without this
	@ini_set('cgi.fix_pathinfo', 0);
	
	// PHP 5.3 will BITCH without this
	if (ini_get('date.timezone') == '') {
		date_default_timezone_set('UTC');
	}

/*
|---------------------------------------------------------------
| SYSTEM FOLDER NAME
|---------------------------------------------------------------
|
| This variable must contain the name of your "system" folder.
| Include the path if the folder is not in the same  directory
| as this file.
|
| NO TRAILING SLASH!
|
*/
	$system_path = 'system/codeigniter';

/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server.  If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 *
 */
	$application_folder = 'system/cms';

/*
 *---------------------------------------------------------------
 * ADDON FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server.  If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 *
 */
	$addon_folder = 'addons';

/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config 
 * items or override any default config values found in the config.php file.  
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different 
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 *
 */
	// $assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------




/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */
	if (function_exists('realpath') AND @realpath($system_path) !== FALSE)
	{
		$system_path = realpath($system_path).'/';
	}
	
	// ensure there's a trailing slash
	$system_path = rtrim($system_path, '/').'/';

	// Is the sytsem path correct?
	if ( ! is_dir($system_path))
	{
		exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
	}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */		
	// The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

 	// Path to the system folder
	define('BASEPATH', str_replace("\\", "/", $system_path));
	
	// The site slug: (example.com)
	define('SITE_DOMAIN', $_SERVER['HTTP_HOST']);

 	// This only allows you to change the name. ADDONPATH should still be used in the app
	define('ADDON_FOLDER', $addon_folder.'/');
	
	// Path to the addon folder that is shared between sites
	define('SHARED_ADDONPATH', 'addons/shared_addons/');
	
	// Path to the front controller (this file)
	define('FCPATH', str_replace(SELF, '', __FILE__));
	
	// Name of the "system folder"
	$parts = explode('/', trim(BASEPATH, '/'));
	define('SYSDIR', end($parts));
	unset($parts);

	// The path to the "application" folder
	define('APPPATH', $application_folder.'/');
	
	// Path to the views folder
	define ('VIEWPATH', APPPATH.'views/' );
	
/*
 *---------------------------------------------------------------
 * DEMO
 *---------------------------------------------------------------
 *
 * Should PyroCMS run as a demo, meaning no destructive actions
 * can be taken such as removing admins or changing passwords?
 *
 */

    define('PYRO_DEMO', (file_exists(FCPATH.'DEMO')));

/*
 * --------------------------------------------------------------------
 * LOAD THE COMPOSER AUTOLOADER
 * --------------------------------------------------------------------
 *
 * ...and it will take care of our classes
 *
 */
require_once FCPATH.'system/vendor/autoload.php';

/*
 * --------------------------------------------------------------------------
 * SETUP PATCHWORK UTF-8 HANDLING
 * --------------------------------------------------------------------------
 *
 * The Patchwork library provides solid handling of UTF-8 strings as well
 * as provides replacements for all mb_* and iconv type functions that
 * are not available by default in PHP. We'll setup this stuff here.
 *
*/

Patchwork\Utf8\Bootup::initAll();

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 *
 */
require_once BASEPATH.'core/CodeIgniter.php';

/* End of file index.php */
