<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX core module class */
require dirname(__FILE__).'/Modules.php';

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
	
	public function fetch_module() {
		return $this->module;
	}
	
	public function _validate_request($segments) {

		if (count($segments) == 0) return $segments;
		
		/* locate module controller */
		if ($located = $this->locate($segments)) return $located;
		
		/* use a default 404_override controller */
		if (isset($this->routes['404_override']) and $this->routes['404_override']) {
			$segments = explode('/', $this->routes['404_override']);
			if ($located = $this->locate($segments)) return $located;
		}
		
		/* no controller found */
		show_404();
	}
	
	/** Locate the controller **/
	public function locate($segments) {		
		
		/**
		 * Load the site ref for multi-site support if the "sites" module exists
		 * and the multi-site constants haven't been defined already (hmvc request)
		 */
		if ($path = self::is_multisite() and ! defined('SITE_REF'))
		{
			require_once BASEPATH.'database/DB'.EXT;
			
			# deprecated Remove this for 2.3, as this was too early for a migration
			if ( ! DB()->table_exists('core_domains'))
			{
				// Create alias table
				DB()->query('	
					CREATE TABLE `core_domains` (
					  `id` int NOT NULL AUTO_INCREMENT,
					  `domain` varchar(100) NOT NULL,
					  `site_id` int NOT NULL,
					  `type` enum("park", "redirect") NOT NULL DEFAULT "park",
					  PRIMARY KEY (`id`),
					  KEY `domain` (`domain`),
					  UNIQUE `unique` (`domain`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8; ');
			}

			$site = DB()
				->select('site.name, site.ref, site.domain, site.active, alias.domain as alias_domain, alias.type as alias_type')
				->where('site.domain', SITE_DOMAIN)
				->or_where('alias.domain', SITE_DOMAIN)
				->join('core_domains alias', 'alias.site_id = site.id', 'left')
				->get('core_sites site')
				->row();
			
			// If the site is disabled we set the message in a constant for MY_Controller to display
			if (isset($site->active) and ! $site->active)
			{
				$status = DB()->where('slug', 'status_message')
					->get('core_settings')
					->row();

				define('STATUS', $status ? $status->value : 'This site has been disabled by a super-administrator');					
			}

			// If this domain is an alias and it is a redirect
			if ($site and $site->alias_domain !== null and $site->alias_type === 'redirect' and str_replace(array('http://', 'https://'), '', trim(strtolower(BASE_URL), '/')) !== $site->domain)
			{
				$protocol = ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
					? 'https' : 'http';

				// Send them off to the original domain
				header("Location: {$protocol}://{$site->domain}{$_SERVER['REQUEST_URI']}");
				exit;
			}
			
			// Check to see if the site retrieval was successful. If not then
			// we will let MY_Controller handle the errors.
			if (isset($site->ref))
			{
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
		$ext = $this->config->item('controller_suffix').EXT;
		
		/* use module route if available */
		if (isset($segments[0]) and $routes = Modules::parse_routes($segments[0], implode('/', $segments))) 	
		{
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
					if(is_file($source.$directory.$ext)) {
						return array_slice($segments, 1);
					}
				
					/* module sub-directory sub-controller exists? */
					if ($controller and is_file($source.$controller.$ext))	{
						return array_slice($segments, 2);
					}
				}
				
				/* module controller exists? */			
				if(is_file($source.$module.$ext)) {
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

	public function set_class($class) {
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
}
