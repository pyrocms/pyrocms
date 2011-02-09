<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load MX core classes */
require_once dirname(__FILE__).'/Lang.php';
require_once dirname(__FILE__).'/Config.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter CI_Base class and creates an application 
 * object allowing use of the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Base.php
 *
 * @copyright	Copyright (c) Wiredesignz 2010-11-12
 * @version 	5.3.5
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
if ( ! (CI_VERSION < 2)) {
	class CI_Base extends CI_Controller	{}
}

class CI extends CI_Base
{
	public static $APP;
	
	public function __construct() {
		
		/* assign the application instance */
		self::$APP = $this;
		
		parent::__construct();
		
		if (CI_VERSION < 2) {
			
			/* assign the core classes */
			$classes = array(
				'config'	=> 'Config',
				'input'		=> 'Input',
				'benchmark'	=> 'Benchmark',
				'uri'		=> 'URI',
				'output'	=> 'Output',
				'lang'		=> 'Language',
				'router'	=> 'Router'
			);
			
			foreach ($classes as $key => $class) {	
				$this->$key = load_class($class);	
			}
		
			/* assign the core loader */
			$this->load = load_class('Loader');
			
			/* autoload application items */
			$this->load->_ci_autoloader();
		}
		
		/* re-assign language and config for modules */
		if ( ! is_a($this->lang, 'MX_Lang')) $this->lang = new MX_Lang;
		if ( ! is_a($this->config, 'MX_Config')) $this->config = new MX_Config;
	}
}

/* create the application object */
new CI;