<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* define the modules base path */
define('MODBASE', APPPATH.'modules/');

/* define the offset from application/controllers */
define('MODOFFSET', '../modules/');

/**
 * Modular Extensions - PHP5
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
 * @copyright 	Copyright (c) Wiredesignz 2009-08-22
 * @version 	5.2.14
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
		
		/* locate the module controller */
		return $this->locate($segments);
	}
	
	/** Locate the controller **/
	public function locate($segments) {		
		
		$this->module = '';
		$this->directory = '';
		
		/* pad the segment array */
		$segments += array($segments, NULL, NULL);
		list($module, $directory, $controller) = $segments;

		/* module exists? */
		if ($module AND is_dir($source = MODBASE.$module.'/controllers/')) {
			
			$this->module = $module;
			$this->directory = MODOFFSET.$module.'/controllers/';
					
			/* module sub-controller exists? */
			if($directory AND is_file($source.$directory.EXT)) {
				return array_slice($segments, 1);
			}
				
			/* module sub-directory exists? */
			if($directory AND is_dir($module_subdir = $source.$directory)) {
						
				$this->directory .= $directory.'/';
			
				/* module sub-directory sub-controller exists? */
				if($controller AND is_file($module_subdir.'/'.$controller.EXT))	{
					return array_slice($segments, 2);
				}

				/* module sub-directory controller exists? */
				if(is_file($module_subdir.'/'.$directory.EXT)) {
					return array_slice($segments, 1);
				}
			}
		
			/* module controller exists? */			
			if(is_file($source.$module.EXT)) {
				return $segments;
			}
		}

		/* not a module controller */
		return parent::_validate_request($segments);
	}
}