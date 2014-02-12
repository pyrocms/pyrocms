<?php

require APPPATH . "libraries/MX/Controller.php";

use Cartalyst\Sentry;
use Composer\Autoload\ClassLoader;
use Illuminate\Database\Capsule\Manager as Capsule;
use Pyro\Cache\CacheManager;
use Pyro\Module\Addons\ModuleManager;
use Pyro\Module\Addons\ThemeManager;
use Pyro\Module\Addons\WidgetManager;
use Pyro\Module\Streams\FieldType\FieldTypeManager;

/**
 * Code here is run before ALL controllers
 *
 * @package     PyroCMS\Core\Controllers
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

        // For now, Set up this profiler because we can't pass Illuminate\Database queries to the Codeigniter profiler
        // See https://github.com/loic-sharma/profiler        
        $logger        = new \Profiler\Logger\Logger;
        ci()->profiler = new \Profiler\Profiler($logger);

        if (!defined('AUTO_LANGUAGE')) {
            $this->pickLanguage();
        }

        // No record? Probably DNS'ed but not added to multisite
        if (!defined('SITE_REF')) {
            show_error(
                'This domain is not set up correctly. Please go to ' . anchor('sites') . ' and log in to add this site.'
            );
        }

        // Set up the Illuminate\Database layer
        ci()->pdb = self::setupDatabase();

        // Lets PSR-0 up our modules
        $loader = new ClassLoader;

        // Register module manager for usage everywhere, its handy
        $loader->add('Pyro\\Module\\Settings', realpath(APPPATH) . '/modules/settings/src/');
        $loader->add('Pyro\\Module\\Addons', realpath(APPPATH) . '/modules/addons/src/');
        $loader->add('Pyro\\Module\\Streams', realpath(APPPATH) . '/modules/streams_core/src/');
        $loader->add('Pyro\\Module\\Users', realpath(APPPATH) . '/modules/users/src/');

        // Map the streams model namespace to the site ref
        $siteRef = str_replace(' ', '', ucwords(str_replace(array('-', '_'), ' ', SITE_REF)));

        $loader->add(
            'Pyro\\Module\\Streams\\Model',
            realpath(APPPATH) . '/modules/streams_core/models/' . $siteRef . 'Site/'
        );

        // activate the autoloader
        $loader->register();

        // Add the site specific theme folder
        $this->template->add_theme_location(ADDONPATH . 'themes/');

        // Migration logic helps to make sure PyroCMS is running the latest changes
        $this->load->library('migration');

        if (!($schema_version = $this->migration->current())) {
            show_error($this->migration->error_string());

            // Result of schema version migration
        } elseif (is_numeric($schema_version)) {
            log_message('debug', 'PyroCMS was migrated to version: ' . $schema_version);
        }

        // With that done, load settings
        $this->load->library('settings/settings');

        // And session stuff too
        $this->load->driver('session');

        // Lock front-end language
        if (!($this instanceof Admin_Controller and ($site_lang = AUTO_LANGUAGE))) {
            $site_public_lang = explode(',', Settings::get('site_public_lang'));

            $site_lang = in_array(AUTO_LANGUAGE, $site_public_lang) ? AUTO_LANGUAGE : Settings::get('site_lang');
        }

        // We can't have a blank language. If there happens
        // to be a blank language, let's default to English.
        if (!$site_lang) {
            $site_lang = 'en';
        }

        // What language us being used
        defined('CURRENT_LANGUAGE') or define('CURRENT_LANGUAGE', $site_lang);

        $langs = $this->config->item('supported_languages');

        $pyro['lang']         = $langs[CURRENT_LANGUAGE];
        $pyro['lang']['code'] = CURRENT_LANGUAGE;

        $this->load->vars($pyro);

        // Set php locale time
        if (isset($langs[CURRENT_LANGUAGE]['codes']) and sizeof(
                $locale = (array)$langs[CURRENT_LANGUAGE]['codes']
            ) > 1
        ) {
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

        // Work out module, controller and method and make them accessable throught the CI instance
        ci()->module     = $this->module = $this->router->fetch_module();
        ci()->controller = $this->controller = $this->router->fetch_class();
        ci()->method     = $this->method = $this->router->fetch_method();

        // Is there a logged in user?
        ci()->sentry = $this->sentry = $this->setupSentry();

        // Assign to EVERYTHING
        $user = $this->sentry->getUser();

        $this->template->current_user = ci()->current_user = $this->current_user = $user;

        ci()->moduleManager = $this->moduleManager = new ModuleManager($user);
        ci()->themeManager  = $this->themeManager = new ThemeManager();

        // Let the Theme Manager where our Template library thinks themes
        $this->themeManager->setLocations($this->template->theme_locations());

        ci()->widgetManager = $this->widgetManager = new WidgetManager();

        // activate the autoloader
        $loader->register();

        // now that we have a list of enabled modules
        $this->load->library('events');

        FieldTypeManager::init();
        FieldTypeManager::registerAddonFieldTypes();

        // load all modules (the Events library uses them all) and make their details widely available
        $enabled_modules = $this->moduleManager->getAllEnabled();

        foreach ($enabled_modules as $module) {
            FieldTypeManager::registerFolderFieldTypes($module['path'] . '/field_types/', $module['field_types']);

            // register classes with namespaces
            $loader->add('Pyro\\Module\\' . ucfirst($module['slug']), $module['path'] . '/src/');

            // Also, save this module to... everywhere if its the current one 
            if ($module['slug'] === $this->module) {
                // Set meta data for the module to be accessible system wide
                $this->template->module_details = ci()->module_details = $this->module_details = $module;

                continue;
            }
        }

        if ($this->module) {
            // If this a disabled module then show a 404
            if (empty($this->module_details['enabled'])) {
                show_404();
            }

            if (empty($this->module_details['skip_xss'])) {
                $_POST = $this->security->xss_clean($_POST);
            }

            // Assign "This" module as its own namespace
            if (isset($this->module_details['path'])) {
                Asset::add_path('module', $this->module_details['path'] . '/');
            }
        }

        $this->benchmark->mark('my_controller_end');

        // Enable profiler on local box
        if ($this->current_user and $this->current_user->isSuperUser() and is_array($_GET) and array_key_exists(
                '_debug',
                $_GET
            )
        ) {
            $this->output->enable_profiler(true);
        }
    }

    /**
     * Determines the language to use.
     *
     * This is called from the Codeigniter hook system.
     * The hook is defined in system/cms/config/hooks.php
     */
    private function pickLanguage()
    {
        require APPPATH . '/config/language.php';

        // Re-populate $_GET
        parse_str($_SERVER['QUERY_STRING'], $_GET);

        // If we've been redirected from HTTP to HTTPS on admin, ?session= will be set to maintain language
        if ($_SERVER['SERVER_PORT'] == 443 and !empty($_GET['session'])) {
            session_start($_GET['session']);
        } else {
            if (!isset($_SESSION)) {
                session_start();
            }
        }

        // Lang set in URL via ?lang=something
        if (!empty($_GET['lang'])) {
            // Turn en-gb into en
            $lang = strtolower(substr($_GET['lang'], 0, 2));

            log_message('debug', 'Set language in URL via GET: ' . $lang);

            // Lang has already been set and is stored in a session
        } elseif (!empty($_SESSION['lang_code'])) {
            $lang = $_SESSION['lang_code'];

            log_message('debug', 'Set language in Session: ' . $lang);

            // Lang has is picked by a user.
        } elseif (!empty($_COOKIE['lang_code'])) {
            $lang = strtolower($_COOKIE['lang_code']);

            log_message('debug', 'Set language in Cookie: ' . $lang);
        } // Still no Lang. Lets try some browser detection then
        elseif (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            // explode languages into array
            $accept_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

            $supported_langs = array_keys($config['supported_languages']);

            log_message('debug', 'Checking browser languages: ' . implode(', ', $accept_langs));

            // Check them all, until we find a match
            foreach ($accept_langs as $accept_lang) {
                if (strpos($accept_lang, '-') === 2) {
                    // Turn pt-br into br
                    $lang = strtolower(substr($accept_lang, 3, 2));

                    // Check its in the array. If so, break the loop, we have one!
                    if (in_array($lang, $supported_langs)) {
                        log_message('debug', 'Accept browser language: ' . $accept_lang);

                        break;
                    }
                }

                // Turn en-gb into en
                $lang = strtolower(substr($accept_lang, 0, 2));

                // Check its in the array. If so, break the loop, we have one!
                if (in_array($lang, $supported_langs)) {
                    log_message('debug', 'Accept browser language: ' . $accept_lang);

                    break;
                }
            }
        }

        // If no language has been worked out - or it is not supported - use the default
        if (empty($lang) or !array_key_exists($lang, $config['supported_languages'])) {
            $lang = $config['default_language'];
            log_message('debug', 'Set language default: ' . $lang);
        }

        // Whatever we decided the lang was, save it for next time to avoid working it out again
        $_SESSION['lang_code'] = $lang;

        // Load CI config class
        $CI_config =& load_class('Config');

        // Set the language config. Selects the folder name from its key of 'en'
        $CI_config->set_item('language', $config['supported_languages'][$lang]['folder']);

        // Sets a constant to use throughout ALL of CI.
        if (!defined('AUTO_LANGUAGE')) {
            define('AUTO_LANGUAGE', $lang);
        }

        log_message('debug', 'Defined const AUTO_LANGUAGE: ' . AUTO_LANGUAGE);
    }

    public function setupDatabase()
    {
        // @TODO Get rid of this for 3.0
        if (!class_exists('CI_Model')) {
            load_class('Model', 'core');
        }

        $prefix = SITE_REF . '_';

        // By changing the prefix we are essentially "namespacing" each site
        $this->db->set_dbprefix($prefix);

        // Assign
        $pdo = $this->db->get_connection();

        include APPPATH . 'config/database.php';
        include APPPATH . 'config/cache.php';

        $config = $db[$active_group];

        // Is this a PDO connection?
        if (isset($config['dsn'])) {

            preg_match('/(mysql|pgsql|sqlite)+:host=(\w.+).+dbname=(\w+)/', $config['dsn'], $matches);

            $config['dbdriver'] = $matches[1];
            $config['hostname'] = $matches[2];
            $config['database'] = $matches[3];

            unset($matches);
        }

        $supportedDrivers = array('mysql', 'pgsql', 'sqlite');

        if (!in_array($config['dbdriver'], $supportedDrivers)) {
            $config['dbdriver'] = 'mysql';
        }

        $capsule = new Capsule;

        $capsule->addConnection(
            array(
                'driver'    => $config['dbdriver'],
                'host'      => $config["hostname"],
                'database'  => $config["database"],
                'username'  => $config["username"],
                'prefix'    => $prefix,
                'password'  => $config["password"],
                'charset'   => $config["char_set"],
                'collation' => $config["dbcollat"],
            )
        );

        // Set the fetch mode FETCH_CLASS so we
        // get objects back by default.
        $capsule->setFetchMode(PDO::FETCH_CLASS);

        // Setup the Eloquent ORM
        $capsule->bootEloquent();

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        $container = $capsule->getContainer();

        if ($cache['enable']) {
            if (isset($cache['environment'][ENVIRONMENT])) {
                $cache['enable'] = $cache['environment'][ENVIRONMENT];
            }
        }

        $container->offsetGet('config')->offsetSet('cache.enable', $cache['enable']);
        $container->offsetGet('config')->offsetSet('cache.driver', $cache['driver']);
        $container->offsetGet('config')->offsetSet('cache.prefix', $cache['prefix']);

        // Set driver specific settings
        if ($cache['driver'] == 'file') {

            $container->offsetGet('config')->offsetSet('cache.path', $cache['path']);

        } elseif ($cache['driver'] == 'redis') {

            $container->offsetGet('config')->offsetSet('redis', $cache['redis']);

        }

        ci()->cache = new CacheManager($container);

        $capsule->setCacheManager(ci()->cache);

        $conn = $capsule->connection();

        $conn->setFetchMode(PDO::FETCH_OBJ);

        return $conn;
    }

    public function setupSentry()
    {
        ci()->load->helper('cookie');

        $hasher        = new Sentry\Hashing\NativeHasher;
        $session       = new Sentry\Sessions\CISession(ci()->session, 'pyro_user_session');
        $cookie        = new Sentry\Cookies\CICookie(ci()->input, array( // Array of overridden cookie settings...
        ), 'pyro_user_cookie');
        $groupProvider = new Sentry\Groups\Eloquent\Provider;
        $userClass     = Settings::get('user_class') ? : 'Pyro\Module\Users\Model\User';
        $userProvider  = new Sentry\Users\Eloquent\Provider($hasher, $userClass);
        $throttle      = new Sentry\Throttling\Eloquent\Provider($userProvider);

        $throttle->disable();

        return new Sentry\Sentry(
            $userProvider,
            $groupProvider,
            $throttle,
            $session,
            $cookie
        );
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