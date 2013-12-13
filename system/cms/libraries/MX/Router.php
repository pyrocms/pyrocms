<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX core module class */
require dirname(__FILE__).'/Modules.php';

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter router class.
 *
 * Install this file as application/third_party/MX/Router.php
 *
 * @copyright	Copyright (c) 2011 Wiredesignz
 * @version 	5.4
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Router extends CI_Router
{
	private $module;

	protected static $DB = null;

	public function fetch_module()
	{
		return $this->module;
	}

	public function _validate_request($segments)
	{
		if (count($segments) == 0) return $segments;

		/* locate module controller */
		if ($located = $this->locate($segments)) {
			return $located;
		}

		/* Routes module */
		if ($routes_segments = $this->routes($segments))
		{
			if ($located = $this->locate($routes_segments)) return $located;
		}

		/* use a default 404_override controller */
		if (isset($this->routes['404_override']) and $this->routes['404_override']) {
			$segments = explode('/', $this->routes['404_override']);
			if ($located = $this->locate($segments)) return $located;
		}

		/* no controller found */
		show_404();
	}

	/** Locate the controller **/
	public function locate($segments)
	{
		/**
		 * Load the site ref for multi-site support if the "sites" module exists
		 * and the multi-site constants haven't been defined already (hmvc request)
		 */
		if ($path = self::is_multisite() and ! defined('SITE_REF'))
		{
			$site = self::$DB
				->table('core_sites')
				->select('core_sites.name', 'core_sites.ref', 'core_sites.domain', 'core_sites.is_activated', 'core_domains.domain as alias_domain', 'core_domains.type as alias_type')
				->where('core_sites.domain', '=', SITE_DOMAIN)
				->orWhere('core_domains.domain', '=', SITE_DOMAIN)
				->leftJoin('core_domains', 'core_domains.site_id', '=', 'core_sites.id')
				->first();				

			// If the site is disabled we set the message in a constant for MY_Controller to display
			if (isset($site->is_activated) and ! $site->is_activated) {
				$status = $DB->where('slug', 'status_message')
					->get('core_settings')
					->row();

				define('STATUS', $status ? $status->value : 'This site has been disabled by a super-administrator');
			}

			// If this domain is an alias and it is a redirect
			if ($site and $site->alias_domain !== null and $site->alias_type === 'redirect' and str_replace(array('http://', 'https://'), '', trim(strtolower(BASE_URL), '/')) !== $site->domain) {

				$protocol = ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
					? 'https' : 'http';

				// Send them off to the original domain
				header("Location: {$protocol}://{$site->domain}{$_SERVER['REQUEST_URI']}");
				exit;
			}

			$locations = array();

			// Check to see if the site retrieval was successful. If not then
			// we will let MY_Controller handle the errors.
			if (isset($site->ref)) {

				// Set the session config to the correct table using the config name (but removing 'default_')
				$this->config->set_item('sess_table_name', $site->ref.'_'.str_replace('default_', '', config_item('sess_table_name')));

				// The site ref. Used for building site specific paths
				define('SITE_REF', $site->ref);

				// Path to uploaded files for this site
				define('UPLOAD_PATH', 'uploads/'.SITE_REF.'/');

				// Path to the addon folder for this site
				define('ADDONPATH', ADDON_FOLDER.SITE_REF.'/');

				// the path to the MSM module
				define('MSMPATH', str_replace('__SITE_REF__', SITE_REF, $path));
			}
		}

		// we aren't running the Multi-Site Manager so define the defaults
		if ( ! defined('SITE_REF'))
		{
			// The site ref. Used for building site specific paths
			define('SITE_REF', 'default');
							
			// Path to uploaded files for this site
			define('UPLOAD_PATH', 'uploads/'.SITE_REF.'/');
							
			// Path to the addon folder for this site
			define('ADDONPATH', ADDON_FOLDER.SITE_REF.'/');
		}

		// update the config paths with the site specific paths
		self::update_module_locations(SITE_REF);
		
		$this->module = '';
		$this->directory = '';
		$ext = $this->config->item('controller_suffix').'.php';

		/* use module route if available */
		if (isset($segments[0]) and $routes = Modules::parse_routes($segments[0], implode('/', $segments))) {
			$segments = $routes;
		}

		/* get the segments array elements */
		list($module, $directory, $controller) = array_pad($segments, 3, null);

		/* check modules */
		foreach (Modules::$locations as $location => $offset) {

			/* module exists? */
			if (is_dir($source = $location.$module.'/controllers/')) {

				$this->module = $module;
				$this->directory = $offset.$module.'/controllers/';

				/* module sub-controller exists? */
				if ($directory and is_file($source.$directory.$ext)) {
					return array_slice($segments, 1);
				}

				/* module sub-directory exists? */
				if ($directory and is_dir($source.$directory.'/')) {

					$source = $source.$directory.'/';
					$this->directory .= $directory.'/';

					/* module sub-directory controller exists? */
					if (is_file($source.$directory.$ext)) {
						return array_slice($segments, 1);
					}

					/* module sub-directory sub-controller exists? */
					if ($controller and is_file($source.$controller.$ext)) {
						return array_slice($segments, 2);
					}
				}

				/* module controller exists? */
				if (is_file($source.$module.$ext)) {
					return $segments;
				}
			}
		}

		/* application controller exists? */
		if (is_file(APPPATH.'controllers/'.$module.$ext)) {
			return $segments;
		}

		/* application sub-directory controller exists? */
		if ($directory and is_file(APPPATH.'controllers/'.$module.'/'.$directory.$ext)) {
			$this->directory = $module.'/';
			return array_slice($segments, 1);
		}

		/* application sub-directory default controller exists? */
		if (is_file(APPPATH.'controllers/'.$module.'/'.$this->default_controller.$ext)) {
			$this->directory = $module.'/';
			return array($this->default_controller);
		}
	}

	public function set_class($class)
	{
		$this->class = $class.$this->config->item('controller_suffix');
	}

	private function is_multisite()
	{
		foreach (Modules::$locations as $location => $offset)
		{
			if (is_dir($location.'sites'))
			{
				return $location.'sites/';
			}
		}

		// one last check, the default site's folder
		if (is_dir(ADDON_FOLDER.'default/modules/sites'))
		{
			return ADDON_FOLDER.'default/modules/sites/';
		}

		return false;
	}

	private function update_module_locations($site_ref)
	{
		$locations = array();

		foreach (config_item('modules_locations') AS $location => $offset)
		{
			$locations[str_replace('__SITE_REF__', $site_ref, $location)] = str_replace('__SITE_REF__', $site_ref, $offset);
		}

		Modules::$locations = $locations;
	}

	/**
	 * Check if a route from the routes module has been used
	 * @param  array $segments
	 * @return array           [description]
	 */
	public function routes($segments)
	{
		// Connect and save the connection
		self::$DB = self::connect();
		
		//TODO Caching Here
		$routes = self::$DB->table(SITE_REF.'_routes')->select('route_key', 'route_value')->get();
		
		$uri = implode('/', $segments);
		
		foreach ($routes as $route)
		{
			if ($uri == $route->route_key) return explode('/', $route->route_value);

			$key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $route->route_key));

			// Does the RegEx match?
			if (preg_match('#^'.$key.'$#', $uri))
			{
				// Do we have a back-reference?
				if (strpos($route->route_value, '$') !== FALSE AND strpos($key, '(') !== FALSE)
				{
					$val = preg_replace('#^'.$key.'$#', $route->route_value, $uri);
				}

				return explode('/', $route->route_value);
			}
		}
	}

	private function connect() {

		include APPPATH.'config/database.php';

        $db = $db[ENVIRONMENT];


        // Is this a PDO connection?
        if ($db['dbdriver']) {

        	preg_match('/(mysql|pgsql|sqlite)+:.+dbname=(\w+)/', $db['dsn'], $matches);
            $subdriver = $matches[1];
            $database = $matches[2];
            unset($matches);

            $drivers = array(
                'mysql' => '\Illuminate\Database\MySqlConnection',
                'pgsql' => '\Illuminate\Database\PostgresConnection',
                'sqlite' => '\Illuminate\Database\SQLiteConnection',
            );

            $pdo = new PDO($db['dsn'], $db['username'], $db['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            // Make a connection instance with the existing PDO connection
            $conn = new $drivers[$subdriver]($pdo, $database);

            $resolver = new Illuminate\Database\ConnectionResolver;
            $resolver->addConnection('default', $conn);
            $resolver->setDefaultConnection('default');

            Illuminate\Database\Eloquent\Model::setConnectionResolver($resolver);

        // Not using the new PDO driver
        } else {

            $capsule = new Capsule;

            $capsule->addConnection(array(
                'driver' => $dbdb['dbdriver'],
                'host' => $db["hostname"],
                'database' => $db["database"],
                'username' => $db["username"],
                'prefix' => $prefix,
                'password' => $db["password"],
                'charset' => $db["char_set"],
                'collation' => $db["dbcollat"],
            ));

            // Set the fetch mode FETCH_CLASS so we 
            // get objects back by default.
            $capsule->setFetchMode(PDO::FETCH_CLASS);

            // Setup the Eloquent ORM
            $capsule->bootEloquent();

            // Make this Capsule instance available globally via static methods... (optional)
            $capsule->setAsGlobal();

            $conn = $capsule->connection();
        }

        $conn->setFetchMode(PDO::FETCH_OBJ);

        return $conn;
	}
}