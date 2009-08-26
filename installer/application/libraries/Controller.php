<?php (defined('BASEPATH')) OR exit('No direct script access allowed');		
/**
 * Modular Extensions - PHP5
 *
 * Adapted from the CodeIgniter Core Classes
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @link		http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/libraries/Controller.php
 *
 * @copyright 	Copyright (c) Wiredesignz 2009-08-22
 * @version		5.2.14
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
class CI extends CI_Base 
{
	public static $APP;
	
	public function __construct() {
		
		parent::__construct();
		
		/* assign CI instance */
		self::$APP = $this;
		
		/* assign the core loader */
		$this->load = load_class('Loader');
		
		/* the core classes */
		$classes = array(
			'config'	=> 'Config',
			'input'		=> 'Input',
			'benchmark'	=> 'Benchmark',
			'uri'		=> 'URI',
			'output'	=> 'Output',
			'lang'		=> 'Language',
			'router'	=> 'Router',
		);
		
		/* assign the core classes */
		foreach ($classes as $key => $class) {
			$this->$key = load_class($class);	
		}
		
		/* autoload application items */
		$this->load->_ci_autoloader();
	}
	
	public static function instance() {
		is_a(self::$APP, __CLASS__) OR new CI;
		return self::$APP;
	}
}

/* create the application object */
CI::instance();

/* load the modules library */
include 'Modules.php';

class MX_Loader extends CI_Loader
{	
	private $_module;
	
	public function __construct() {
		$this->load = $this;
		
		/* this module name */
		$this->_module = CI::$APP->router->fetch_module();
		
		/* ci loader references */
        foreach (get_class_vars('CI_Loader') as $var => $val) {
        	$this->$var =& CI::$APP->load->$var;
        }
	}
	
	/** Load a module config file **/
	public function config($file = '', $use_sections = FALSE) {
		($file == '') AND $file = 'config';

		if (in_array($file, CI::$APP->config->is_loaded, TRUE))
			return CI::$APP->config->item($file);

		list($path, $file) = Modules::find($file, $this->_module, 'config/');
		
		if ($path === FALSE) {
			parent::config($file, $use_sections);					
			return CI::$APP->config->item($file);
		}  
		
		if ($config = Modules::load_file($file, $path, 'config')) {
			
			/* reference to the config array */
			$current_config =& CI::$APP->config->config;

			if ($use_sections === TRUE)	{
				if (isset($current_config[$file])) {
					$current_config[$file] = array_merge($current_config[$file], $config);
				} else {
					$current_config[$file] = $config;
				}
			} else {
				$current_config = array_merge($current_config, $config);
			}
			CI::$APP->config->is_loaded[] = $file;
			unset($config);
			return CI::$APP->config->item($file);
		}
	}

	/** Load the database drivers **/
	public function database($params = '', $return = FALSE, $active_record = FALSE) {
		if (class_exists('CI_DB', FALSE) AND $return == FALSE AND $active_record == FALSE) 
			return;

		require_once BASEPATH.'database/DB'.EXT;

		if ($return === TRUE) 
			return DB($params, $active_record);
			
		CI::$APP->db = DB($params, $active_record);
		$this->_ci_assign_to_models();
		return CI::$APP->db;
	}

	/** Load a module helper **/
	public function helper($helper) {
		if (is_array($helper)) 
			return $this->helpers($helper);
		
		if (isset($this->_ci_helpers[$helper]))	
			return;

		list($path, $_helper) = Modules::find($helper.'_helper', $this->_module, 'helpers/');

		if ($path === FALSE) 
			return parent::helper($helper);

		Modules::load_file($_helper, $path);
		$this->_ci_helpers[$_helper] = TRUE;
	}

	/** Load an array of helpers **/
	public function helpers($helpers) {
		foreach ($helpers as $_helper) $this->helper($_helper);	
	}

	/** Load a module language file **/
	public function language($langfile, $lang = '')	{
		$deft_lang = CI::$APP->config->item('language');
		$idiom = ($lang == '') ? $deft_lang : $lang;
	
		if (in_array($langfile.'_lang'.EXT, CI::$APP->lang->is_loaded, TRUE)) 
			return CI::$APP->lang;
		
		list($path, $_langfile) = Modules::find($langfile.'_lang', $this->_module, 'language/', $idiom);

		if ($path === FALSE) {
			parent::language($langfile, $lang);
		} else {
			if($lang = Modules::load_file($_langfile, $path, 'lang')) {
				CI::$APP->lang->language = array_merge(CI::$APP->lang->language, $lang);
				CI::$APP->lang->is_loaded[] = $langfile.'_lang'.EXT;
				unset($lang);
			}
		}
		return CI::$APP->lang;
	}

	/** Load a module library **/
	public function library($library, $params = NULL, $object_name = NULL) {
		$class = strtolower(end(explode('/', $library)));
		
		if (isset($this->_ci_classes[$class]) AND $_alias = $this->_ci_classes[$class])
			return CI::$APP->$_alias;
			
		($_alias = $object_name) OR $_alias = $class;
		list($path, $_library) = Modules::find($library, $this->_module, 'libraries/');
		
		/* load library config file as params */
		if ($params == NULL) {
			list($path2, $file) = Modules::find($_alias, $this->_module, 'config/');	
			($path2) AND $params = Modules::load_file($file, $path2, 'config');
		}	
		
		if ($path === FALSE) {		
			parent::_ci_load_class($library, $params, $object_name);
			$_alias = $this->_ci_classes[$class];
     	} else {		
			Modules::load_file($_library, $path);
			$library = ucfirst($_library);
			CI::$APP->$_alias = new $library($params);
			$this->_ci_classes[$class] = $_alias;
		}
		
		$this->_ci_assign_to_models();
		return CI::$APP->$_alias;
    }

	/** Load a module model **/
	public function model($model, $object_name = NULL, $connect = FALSE) {
		if (is_array($model)) 
			return $this->models($model);

		($_alias = $object_name) OR $_alias = strtolower(end(explode('/', $model)));

		if (in_array($_alias, $this->_ci_models, TRUE)) 
			return CI::$APP->$_alias;
		
		list($path, $model) = Modules::find($model, $this->_module, 'models/');
		(class_exists('Model', FALSE)) OR load_class('Model', FALSE);

		if ($connect !== FALSE) {
			if ($connect === TRUE) $connect = '';
			$this->database($connect, FALSE, TRUE);
		}

		Modules::load_file($model, $path);
		$model = ucfirst($model);
		CI::$APP->$_alias = new $model();
		$this->_ci_models[] = $_alias;
		
		CI::$APP->$_alias->_assign_libraries();
		return CI::$APP->$_alias;
	}

	/** Load an array of models **/
	function models($models) {
		foreach ($models as $_model) $this->model($_model);	
	}

	/** Load a module controller **/
	public function module($module, $params = NULL)	{
		if (is_array($module)) 
			return $this->modules($module);

		$_alias = strtolower(end(explode('/', $module)));
		CI::$APP->$_alias = Modules::load(array($module => $params));
		return CI::$APP->$_alias;
	}

	/** Load an array of controllers **/
	public function modules($modules) {
		foreach ($modules as $_module) $this->module($_module);	
	}

	/** Load a module plugin **/
	public function plugin($plugin)	{
		if (isset($this->_ci_plugins[$plugin]))	
			return;

		list($path, $_plugin) = Modules::find($plugin.'_pi', $this->_module, 'plugins/');	
		
		if ($path === FALSE) 
			return parent::plugin($plugin);

		Modules::load_file($_plugin, $path);
		$this->_ci_plugins[$plugin] = TRUE;
	}

	/** Load a module view **/
	public function view($view, $vars = array(), $return = FALSE) {
		list($path, $view) = Modules::find($view, $this->_module, 'views/');
		$this->_ci_view_path = $path;
		return parent::_ci_load(array('_ci_view' => $view, '_ci_vars' => parent::_ci_object_to_array($vars), '_ci_return' => $return));
	}

	/** Assign libraries to models **/
	public function _ci_assign_to_models() {
		foreach ($this->_ci_models as $model) {
			CI::$APP->$model->_assign_libraries();
		}
	}

	public function _ci_is_instance() {}
	
	protected function __get($var) {
		return CI::$APP->$var;
	}	

	/** Autload items **/
	public function _ci_autoloader($autoload = array(), $path = FALSE) {		
		
		if ($this->_module)
			list($path, $file) = Modules::find('autoload', $this->_module, 'config/');
	
		/* module autoload file */
		if ($path != FALSE)
			$autoload = array_merge(Modules::load_file($file, $path, 'autoload'), $autoload);
	
		/* nothing to do */
		if (count($autoload) == 0) return;
				
		/* autoload config */
		if (isset($autoload['config'])){
			foreach ($autoload['config'] as $key => $val){
				$this->config($val);
			}
		}

		/* autoload helpers, plugins, languages */
		foreach (array('helper', 'plugin', 'language') as $type){
			if (isset($autoload[$type])){
				foreach ($autoload[$type] as $item){
					$this->$type($item);
				}
			}
		}	
			
		/* autoload database & libraries */
		if (isset($autoload['libraries'])){
			if (in_array('database', $autoload['libraries'])){
				/* autoload database */
				if ( ! $db = CI::$APP->config->item('database')){
					$db['params'] = 'default';
					$db['active_record'] = TRUE;
				}
				$this->database($db['params'], FALSE, $db['active_record']);
				$autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
			}

			/* autoload libraries */
			foreach ($autoload['libraries'] as $library){
				$this->library($library);
			}
		}
		
		/* autoload models */
		if (isset($autoload['model'])){
			foreach ($autoload['model'] as $model => $alias){
				(is_numeric($model)) ? $this->model($alias) : $this->model($model, $alias);
			}
		}
		
		/* autoload module controllers */
		if (isset($autoload['modules'])){
			foreach ($autoload['modules'] as $controller) {
				($controller != $this->_module) AND $this->module($controller);
			}
		}
	}
}

class Controller
{			
	/** PHP4 compatibility **/
	public function Controller() {
		
		/* set the loader */
		$this->load = new MX_Loader;
		
		$class = strtolower(get_class($this));
		log_message('debug', ucfirst($class)." Controller Initialized");
		
		/* register this controller */
		Modules::$registry[$class] = $this;		
		
		/* autoload module items */
		$autoload = isset($this->autoload) ? $this->autoload : array();
		$this->load->_ci_autoloader($autoload);
	}
	
	protected function __get($var) {
		return CI::$APP->$var;
	}
}

/* autoload MX_Controller base classes if available */
if (is_file($location = APPPATH.'libraries/MX_Controller'.EXT)) {
	include_once $location;
}