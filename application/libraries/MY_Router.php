<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* PHP5 spl_autoload */
spl_autoload_register('Modules::autoload');

/* define the module locations and offset */
Modules::$locations = array(
	APPPATH.'modules/core/' => '../modules/core/',
	APPPATH.'modules/third_party/' => '../modules/third_party/'
);

/**
 * Modular Separation - PHP5
 *
 * Adapted from the CodeIgniter Core Classes
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @link		http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter router class.
 *
 * Install this file as application/libraries/MY_Router.php
 *
 * @copyright 	Copyright (c) Wiredesignz 2009-11-16
 * @version 	1.9
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
 
class MY_Router extends CI_Router
{
	private $module;
	
	public function fetch_module() {
		return $this->module;
	}
	
	public function _validate_request($segments) {		
		
		/* locate module controller */
		if ($located = $this->locate($segments)) return $located;
		
		/* use a default 404 controller */
		if (isset($this->routes['404']) AND $segments = explode('/', $this->routes['404'])) {
			if ($located = $this->locate($segments)) return $located;
		}
		
		/* no controller found */
		show_404();
	}
	
	/** Locate the controller **/
	public function locate($segments) {		
		
		$this->module = '';
		$this->directory = '';
		
		/* use module route if available */
		if (isset($segments[0]) AND $routes = Modules::parse_routes($segments[0], implode('/', $segments))) {
			$segments = $routes;
		}
	
		/* get the segments array elements */
		list($module, $directory, $controller) = array_pad($segments, 3, NULL);

		foreach (Modules::$locations as $location => $offset) {
		
			/* module exists? */
			if (is_dir($source = $location.$module.'/controllers/')) {
				
				$this->module = $module;
				$this->directory = $offset.$module.'/controllers/';
				
				/* module sub-controller exists? */
				if($directory AND is_file($source.$directory.EXT)) {
					return array_slice($segments, 1);
				}
					
				/* module sub-directory exists? */
				if($directory AND is_dir($module_subdir = $source.$directory.'/')) {
							
					$this->directory .= $directory.'/';
				
					/* module sub-directory controller exists? */
					if(is_file($module_subdir.$directory.EXT)) {
						return array_slice($segments, 1);
					}
					
					/* module sub-directory sub-controller exists? */
					if($controller AND is_file($module_subdir.$controller.EXT))	{
						return array_slice($segments, 2);
					}
				}
			
				/* module controller exists? */			
				if(is_file($source.$module.EXT)) {
					return $segments;
				}
			}
		}
		
		/* application controller exists? */			
		if(is_file(APPPATH.'controllers/'.$module.EXT)) {
			return $segments;
		}
		
		/* application sub-directory controller exists? */
		if(is_file(APPPATH.'controllers/'.$module.'/'.$directory.EXT)) {
			$this->directory = $module.'/';
			return array_slice($segments, 1);
		}
	}
}

class Modules 
{
	public static $routes, $locations;
	
	/** Library base class autoload **/
	public static function autoload($class) {
		
		/* don't autoload CI_ or MY_ prefixed classes */
		if (strstr($class, 'CI_') OR strstr($class, 'MY_')) return;
			
		if(is_file($location = APPPATH.'libraries/'.$class.EXT)) {
			include_once $location;
		}		
	}

	/** Load a module file **/
	public static function load_file($file, $path, $type = 'other', $result = TRUE)	{
		$file = str_replace(EXT, '', $file);		
		$location = $path.$file.EXT;
		
		if ($type === 'other') {		
			
			if (class_exists($file, FALSE))	{
				log_message('debug', "File already loaded: {$location}");				
				return $result;
			}
			
			include_once $location;
		} else { 
		
			/* load config or language array */
			include $location;

			if ( ! isset($$type) OR ! is_array($$type))				
				show_error("{$location} does not contain a valid {$type} array");

			$result = $$type;
		}
		log_message('debug', "File loaded: {$location}");
		return $result;
	}

	/** 
	* Find a file
	* Scans for files located within modules directories.
	* Also scans application directories for models and views.
	* Generates fatal error if file not found.
	**/
	public static function find($file, $module, $base, $lang = '') {

		$segments = explode('/', $file);

		$file = array_pop($segments);
		if ($base == 'libraries/') $file = ucfirst($file);
		$file_ext = strpos($file, '.') ? $file : $file.EXT; 
		
		$lang && $lang .= '/';
		$path = ltrim(implode('/', $segments).'/', '/');
		$module ? $modules[$module] = $path : $modules = array();

		if ( ! empty($segments)) 
			$modules[array_shift($segments)] = ltrim(implode('/', $segments).'/','/');		
	
		foreach (Modules::$locations as $location => $offset) {
					
			foreach($modules as $module => $subpath) {
				$fullpath = $location.$module.'/'.$base.$lang.$subpath;
				if (is_file($fullpath.$file_ext)) return array($fullpath, $file);
			}
		}
		
		/* is the file in an application directory? */
		if ($base == 'views/' OR $base == 'models/') {
			if (is_file(APPPATH.$base.$path.$file_ext)) return array(APPPATH.$base.$path, $file);
			show_error("Unable to locate the file: {$path}{$file_ext}");
		}

		return array(FALSE, $file);	
	}
	
	/** Parse module routes **/
	public static function parse_routes($module, $uri) {
		
		/* load the route file */
		if ( ! isset(self::$routes[$module])) {
			if (list($path) = self::find('routes', $module, 'config/') AND $path)
				self::$routes[$module] = self::load_file('routes', $path, 'route');
		}

		if ( ! isset(self::$routes[$module])) return;
			
		/* parse module routes */
		foreach (self::$routes[$module] as $key => $val) {						
					
			$key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $key));
			
			if (preg_match('#^'.$key.'$#', $uri)) {							
				if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE) {
					$val = preg_replace('#^'.$key.'$#', $val, $uri);
				}

				return explode('/', $module.'/'.$val);
			}
		}
	}
}