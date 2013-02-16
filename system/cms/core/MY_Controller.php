<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/MX/Controller.php";

/**
 * Code here is run before ALL controllers
 * 
 * @package 	PyroCMS\Core\Controllers
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */
class MY_Controller extends MX_Controller
{
	/**
	 * The name of the module that this controller instance actually belongs to.
	 *
	 * @var string 
	 */
	public $module;

	/**
	 * The name of the controller class for the current class instance.
	 *
	 * @var string
	 */
	public $controller;

	/**
	 * The name of the method for the current request.
	 *
	 * @var string 
	 */
	public $method;

	/**
	 * Load and set data for some common used libraries.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->benchmark->mark('my_controller_start');

        $this->pick_language();
		
		// No record? Probably DNS'ed but not added to multisite
		if ( ! defined('SITE_REF'))
		{
			show_error('This domain is not set up correctly. Please go to '.anchor('sites').' and log in to add this site.');
		}

		// Set up the Illuminate\Database layer
		ci()->pdb = self::setupDatabase();

		// the Quick\Cache package is instantiated to $this->cache in the config file
		$this->load->config('cache');

		// Add the site specific theme folder
		$this->template->add_theme_location(ADDONPATH.'themes/');

		// Migration logic helps to make sure PyroCMS is running the latest changes
		$this->load->library('migration');
		
		if ( ! ($schema_version = $this->migration->current())) {
			show_error($this->migration->error_string());
		}

		// Result of schema version migration
		elseif (is_numeric($schema_version)) {
			log_message('debug', 'PyroCMS was migrated to version: ' . $schema_version);
		}

		// With that done, load settings
		$this->load->library('settings/settings');

		// And session stuff too
		$this->load->driver('session');

		// Lock front-end language
		if ( ! ($this instanceof Admin_Controller and ($site_lang = AUTO_LANGUAGE))) {
			$site_public_lang = explode(',', Settings::get('site_public_lang'));

			$site_lang = in_array(AUTO_LANGUAGE, $site_public_lang) ? AUTO_LANGUAGE : Settings::get('site_lang');
		}

		// What language us being used
		defined('CURRENT_LANGUAGE') or define('CURRENT_LANGUAGE', $site_lang);

		$langs = $this->config->item('supported_languages');

		$pyro['lang'] = $langs[CURRENT_LANGUAGE];
		$pyro['lang']['code'] = CURRENT_LANGUAGE;

		$this->load->vars($pyro);

		// Set php locale time
		if (isset($langs[CURRENT_LANGUAGE]['codes']) and sizeof($locale = (array) $langs[CURRENT_LANGUAGE]['codes']) > 1) {
			array_unshift($locale, LC_TIME);
			call_user_func_array('setlocale', $locale);
			unset($locale);
		}

		// Reload languages
		if (AUTO_LANGUAGE !== CURRENT_LANGUAGE) {
			$this->config->set_item('language', $langs[CURRENT_LANGUAGE]['folder']);
			$this->lang->is_loaded = array();
			$this->lang->load(array('errors', 'global', 'users/user', 'settings/settings', 'files/files'));
		
        } else {
			$this->lang->load(array('global', 'users/user', 'files/files'));
		}

		$this->load->library('users/ion_auth');

		// Get user data
		$this->template->current_user = ci()->current_user = $this->current_user = $this->ion_auth->get_user();

		// Work out module, controller and method and make them accessable throught the CI instance
		ci()->module = $this->module = $this->router->fetch_module();
		ci()->controller = $this->controller = $this->router->fetch_class();
		ci()->method = $this->method = $this->router->fetch_method();

		// Loaded after $this->current_user is set so that data can be used everywhere
		$this->load->model(array(
			'permissions/permission_m',
			'addons/module_m',
			'addons/theme_m',
		));

		// List available module permissions for this user
		ci()->permissions = $this->permissions = $this->current_user ? $this->permission_m->get_group($this->current_user->group_id) : array();

		// load all modules (the Events library uses them all) and make their details widely available
		ci()->enabled_modules = $this->module_m->get_all();

		// now that we have a list of enabled modules
		$this->load->library('events');

		// set defaults
		$this->template->module_details = ci()->module_details = $this->module_details = false;

        // Lets PSR-0 up our modules
        $loader = new \Composer\Autoload\ClassLoader;
		foreach (ci()->enabled_modules as $module) {

            // register classes with namespaces
            $loader->add('Pyro\\Module\\'.ucfirst($module['slug']), $module['path'].'/src/');

            // Also, save this module to... everywhere if its the current one 
			if ($module['slug'] === $this->module) {
				// Set meta data for the module to be accessible system wide
				$this->template->module_details = ci()->module_details = $this->module_details = $module;

				continue;
			}
		}

        // activate the autoloader
        $loader->register();

		// certain places (such as the Dashboard) we aren't running a module, provide defaults
		if ( ! $this->module)
		{
			$this->module_details = array(
				'name' => null,
				'slug' => null,
				'version' => null,
				'description' => null,
				'skip_xss' => null,
				'is_frontend' => null,
				'is_backend' => null,
				'menu' => false,
				'enabled' => 1,
				'sections' => array(),
				'shortcuts' => array(),
				'is_core' => null,
				'is_current' => null,
				'current_version' => null,
				'updated_on' => null
			);
		}

		// If the module is disabled then show a 404.
		empty($this->module_details['enabled']) and show_404();

		if ( ! $this->module_details['skip_xss'])
		{
			$_POST = $this->security->xss_clean($_POST);
		}

		// Assign "This" module as its own namespace
		if ($this->module and isset($this->module_details['path']))
		{
			Asset::add_path('module', $this->module_details['path'].'/');
		}

		$this->load->vars($pyro);
		
		$this->benchmark->mark('my_controller_end');
		
		// Enable profiler on local box
	    if ((isset($this->current_user->group) and $this->current_user->group === 'admin') and is_array($_GET) and array_key_exists('_debug', $_GET))
	    {
			unset($_GET['_debug']);
	    	$this->output->enable_profiler(true);
	    }
	}

	public function setupDatabase()
    {
        // @TODO Get rid of this for 3.0
        if ( ! class_exists('CI_Model'))
        {
            load_class('Model', 'core');
        }

        $prefix = SITE_REF.'_';

        // By changing the prefix we are essentially "namespacing" each site
        $this->db->set_dbprefix($prefix);

        // Assign 
        $pdo = $this->db->get_connection();

        include APPPATH.'config/database.php';

        $config = $db[ENVIRONMENT];
        $subdriver = current(explode(':', $config['dsn']));

        // Is this a PDO connection?
        if ($pdo instanceof PDO) {

            preg_match('/dbname=(\w+)/', $config['dsn'], $matches);
            $database = $matches[1];
            unset($matches);

            $drivers = array(
                'mysql' => '\Illuminate\Database\MySqlConnection',
                'pgsql' => '\Illuminate\Database\PostgresConnection',
                'sqlite' => '\Illuminate\Database\SQLiteConnection',
            );

            // Make a connection instance with the existing PDO connection
            $conn = new $drivers[$subdriver]($pdo, $database, $prefix);

            $resolver = Capsule\Database\Connection::getResolver();
            $resolver->addConnection('default', $conn);
            $resolver->setDefaultConnection('default');

            \Illuminate\Database\Eloquent\Model::setConnectionResolver($resolver);

        // Not using the new PDO driver
        } else {

            $conn = Capsule\Database\Connection::make('default', array(
                'driver' => $subdriver,
                'dsn' => $config["dsn"],
                'username' => $config["username"],
                'password' => $config["password"],
                'charset' => $config["char_set"],
                'collation' => $config["dbcollat"],
            ), true);
        }

        $conn->setFetchMode(PDO::FETCH_OBJ);

        return $conn;
    }

    /**
     * Determines the language to use.
     *
     * This is called from the Codeigniter hook system.
     * The hook is defined in system/cms/config/hooks.php
     */
    private function pick_language()
    {
        require APPPATH.'/config/language.php';

        // Re-populate $_GET
        parse_str($_SERVER['QUERY_STRING'], $_GET);

        // If we've been redirected from HTTP to HTTPS on admin, ?session= will be set to maintain language
        if ($_SERVER['SERVER_PORT'] == 443 and ! empty($_GET['session'])) {
            session_start($_GET['session']);
        } else {
            session_start();
        }

        // Lang set in URL via ?lang=something
        if ( ! empty($_GET['lang'])) {
            // Turn en-gb into en
            $lang = strtolower(substr($_GET['lang'], 0, 2));

            log_message('debug', 'Set language in URL via GET: '.$lang);
        }

        // Lang has already been set and is stored in a session
        elseif ( ! empty($_SESSION['lang_code'])) {
            $lang = $_SESSION['lang_code'];

            log_message('debug', 'Set language in Session: '.$lang);
        }

        // Lang has is picked by a user.
        elseif ( ! empty($_COOKIE['lang_code'])) {
            $lang = strtolower($_COOKIE['lang_code']);

            log_message('debug', 'Set language in Cookie: '.$lang);
        }

        // Still no Lang. Lets try some browser detection then
        elseif ( ! empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            // explode languages into array
            $accept_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

            $supported_langs = array_keys($config['supported_languages']);

            log_message('debug', 'Checking browser languages: '.implode(', ', $accept_langs));

            // Check them all, until we find a match
            foreach ($accept_langs as $accept_lang) {
                if (strpos($accept_lang, '-') === 2) {
                    // Turn pt-br into br
                    $lang = strtolower(substr($accept_lang, 3, 2));

                    // Check its in the array. If so, break the loop, we have one!
                    if (in_array($lang, $supported_langs)) {
                        log_message('debug', 'Accept browser language: '.$accept_lang);

                        break;
                    }
                }

                // Turn en-gb into en
                $lang = strtolower(substr($accept_lang, 0, 2));

                // Check its in the array. If so, break the loop, we have one!
                if (in_array($lang, $supported_langs)) {
                    log_message('debug', 'Accept browser language: '.$accept_lang);

                    break;
                }
            }
        }

        // If no language has been worked out - or it is not supported - use the default
        if (empty($lang) or ! array_key_exists($lang, $config['supported_languages'])) {
            $lang = $config['default_language'];
            log_message('debug', 'Set language default: '.$lang);
        }

        // Whatever we decided the lang was, save it for next time to avoid working it out again
        $_SESSION['lang_code'] = $lang;

        // Load CI config class
        $CI_config =& load_class('Config');

        // Set the language config. Selects the folder name from its key of 'en'
        $CI_config->set_item('language', $config['supported_languages'][$lang]['folder']);

        // Sets a constant to use throughout ALL of CI.
        define('AUTO_LANGUAGE', $lang);

        log_message('debug', 'Defined const AUTO_LANGUAGE: '.AUTO_LANGUAGE);
    }
}

/**
 * Returns the CodeIgniter object.
 *
 * Example: ci()->db->get('table');
 *
 * @return \CI_Controller
 */
function ci()
{
	return get_instance();
}
