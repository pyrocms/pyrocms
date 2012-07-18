<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

/**
 * Jquery Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Loader
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/javascript.html
 */

class CI_Jquery extends CI_Javascript {

	protected $_javascript_folder = 'js';
	public $jquery_code_for_load = array();
	public $jquery_code_for_compile = array();
	public $jquery_corner_active = FALSE;
	public $jquery_table_sorter_active = FALSE;
	public $jquery_table_sorter_pager_active = FALSE;
	public $jquery_ajax_img = '';

	public function __construct($params)
	{
		$this->CI =& get_instance();
		extract($params);

		if ($autoload === TRUE)
		{
			$this->script();
		}

		log_message('debug', 'Jquery Class Initialized');
	}

	// --------------------------------------------------------------------
	// Event Code
	// --------------------------------------------------------------------

	/**
	 * Blur
	 *
	 * Outputs a jQuery blur event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _blur($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'blur');
	}

	// --------------------------------------------------------------------

	/**
	 * Change
	 *
	 * Outputs a jQuery change event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _change($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'change');
	}

	// --------------------------------------------------------------------

	/**
	 * Click
	 *
	 * Outputs a jQuery click event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @param	boolean	whether or not to return false
	 * @return	string
	 */
	protected function _click($element = 'this', $js = '', $ret_false = TRUE)
	{
		if ( ! is_array($js))
		{
			$js = array($js);
		}

		if ($ret_false)
		{
			$js[] = 'return false;';
		}

		return $this->_add_event($element, $js, 'click');
	}

	// --------------------------------------------------------------------

	/**
	 * Double Click
	 *
	 * Outputs a jQuery dblclick event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _dblclick($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'dblclick');
	}

	// --------------------------------------------------------------------

	/**
	 * Error
	 *
	 * Outputs a jQuery error event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _error($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'error');
	}

	// --------------------------------------------------------------------

	/**
	 * Focus
	 *
	 * Outputs a jQuery focus event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _focus($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'focus');
	}

	// --------------------------------------------------------------------

	/**
	 * Hover
	 *
	 * Outputs a jQuery hover event
	 *
	 * @param	string	- element
	 * @param	string	- Javascript code for mouse over
	 * @param	string	- Javascript code for mouse out
	 * @return	string
	 */
	protected function _hover($element = 'this', $over, $out)
	{
		$event = "\n\t$(".$this->_prep_element($element).").hover(\n\t\tfunction()\n\t\t{\n\t\t\t{$over}\n\t\t}, \n\t\tfunction()\n\t\t{\n\t\t\t{$out}\n\t\t});\n";

		$this->jquery_code_for_compile[] = $event;

		return $event;
	}

	// --------------------------------------------------------------------

	/**
	 * Keydown
	 *
	 * Outputs a jQuery keydown event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _keydown($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'keydown');
	}

	// --------------------------------------------------------------------

	/**
	 * Keyup
	 *
	 * Outputs a jQuery keydown event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _keyup($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'keyup');
	}

	// --------------------------------------------------------------------

	/**
	 * Load
	 *
	 * Outputs a jQuery load event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _load($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'load');
	}

	// --------------------------------------------------------------------

	/**
	 * Mousedown
	 *
	 * Outputs a jQuery mousedown event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _mousedown($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'mousedown');
	}

	// --------------------------------------------------------------------

	/**
	 * Mouse Out
	 *
	 * Outputs a jQuery mouseout event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _mouseout($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'mouseout');
	}

	// --------------------------------------------------------------------

	/**
	 * Mouse Over
	 *
	 * Outputs a jQuery mouseover event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _mouseover($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'mouseover');
	}

	// --------------------------------------------------------------------

	/**
	 * Mouseup
	 *
	 * Outputs a jQuery mouseup event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _mouseup($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'mouseup');
	}

	// --------------------------------------------------------------------

	/**
	 * Output
	 *
	 * Outputs script directly
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _output($array_js = '')
	{
		if ( ! is_array($array_js))
		{
			$array_js = array($array_js);
		}

		foreach ($array_js as $js)
		{
			$this->jquery_code_for_compile[] = "\t".$js."\n";
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Resize
	 *
	 * Outputs a jQuery resize event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _resize($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'resize');
	}

	// --------------------------------------------------------------------

	/**
	 * Scroll
	 *
	 * Outputs a jQuery scroll event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _scroll($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'scroll');
	}

	// --------------------------------------------------------------------

	/**
	 * Unload
	 *
	 * Outputs a jQuery unload event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	protected function _unload($element = 'this', $js = '')
	{
		return $this->_add_event($element, $js, 'unload');
	}

	// --------------------------------------------------------------------
	// Effects
	// --------------------------------------------------------------------

	/**
	 * Add Class
	 *
	 * Outputs a jQuery addClass event
	 *
	 * @param	string	- element
	 * @return	string
	 */
	protected function _addClass($element = 'this', $class='')
	{
		$element = $this->_prep_element($element);
		return '$('.$element.').addClass("'.$class.'");';
	}

	// --------------------------------------------------------------------

	/**
	 * Animate
	 *
	 * Outputs a jQuery animate event
	 *
	 * @param	string	- element
	 * @param	string	- One of 'slow', 'normal', 'fast', or time in milliseconds
	 * @param	string	- Javascript callback function
	 * @return	string
	 */
	protected function _animate($element = 'this', $params = array(), $speed = '', $extra = '')
	{
		$element = $this->_prep_element($element);
		$speed = $this->_validate_speed($speed);

		$animations = "\t\t\t";

		foreach ($params as $param => $value)
		{
			$animations .= $param.": '".$value."', ";
		}

		$animations = substr($animations, 0, -2); // remove the last ", "

		if ($speed !== '')
		{
			$speed = ', '.$speed;
		}

		if ($extra !== '')
		{
			$extra = ', '.$extra;
		}

		return "$({$element}).animate({\n$animations\n\t\t}".$speed.$extra.');';
	}

	// --------------------------------------------------------------------

	/**
	 * Fade In
	 *
	 * Outputs a jQuery hide event
	 *
	 * @param	string	- element
	 * @param	string	- One of 'slow', 'normal', 'fast', or time in milliseconds
	 * @param	string	- Javascript callback function
	 * @return	string
	 */
	protected function _fadeIn($element = 'this', $speed = '', $callback = '')
	{
		$element = $this->_prep_element($element);
		$speed = $this->_validate_speed($speed);

		if ($callback !== '')
		{
			$callback = ", function(){\n{$callback}\n}";
		}

		return "$({$element}).fadeIn({$speed}{$callback});";
	}

	// --------------------------------------------------------------------

	/**
	 * Fade Out
	 *
	 * Outputs a jQuery hide event
	 *
	 * @param	string	- element
	 * @param	string	- One of 'slow', 'normal', 'fast', or time in milliseconds
	 * @param	string	- Javascript callback function
	 * @return	string
	 */
	protected function _fadeOut($element = 'this', $speed = '', $callback = '')
	{
		$element = $this->_prep_element($element);
		$speed = $this->_validate_speed($speed);

		if ($callback !== '')
		{
			$callback = ", function(){\n{$callback}\n}";
		}

		return '$('.$element.').fadeOut('.$speed.$callback.');';
	}

	// --------------------------------------------------------------------

	/**
	 * Hide
	 *
	 * Outputs a jQuery hide action
	 *
	 * @param	string	- element
	 * @param	string	- One of 'slow', 'normal', 'fast', or time in milliseconds
	 * @param	string	- Javascript callback function
	 * @return	string
	 */
	protected function _hide($element = 'this', $speed = '', $callback = '')
	{
		$element = $this->_prep_element($element);
		$speed = $this->_validate_speed($speed);

		if ($callback !== '')
		{
			$callback = ", function(){\n{$callback}\n}";
		}

		return "$({$element}).hide({$speed}{$callback});";
	}

	// --------------------------------------------------------------------

	/**
	 * Remove Class
	 *
	 * Outputs a jQuery remove class event
	 *
	 * @param	string	- element
	 * @return	string
	 */
	protected function _removeClass($element = 'this', $class='')
	{
		$element = $this->_prep_element($element);
		return '$('.$element.').removeClass("'.$class.'");';
	}

	// --------------------------------------------------------------------

	/**
	 * Slide Up
	 *
	 * Outputs a jQuery slideUp event
	 *
	 * @param	string	- element
	 * @param	string	- One of 'slow', 'normal', 'fast', or time in milliseconds
	 * @param	string	- Javascript callback function
	 * @return	string
	 */
	protected function _slideUp($element = 'this', $speed = '', $callback = '')
	{
		$element = $this->_prep_element($element);
		$speed = $this->_validate_speed($speed);

		if ($callback !== '')
		{
			$callback = ", function(){\n{$callback}\n}";
		}

		return '$('.$element.').slideUp('.$speed.$callback.');';
	}

	// --------------------------------------------------------------------

	/**
	 * Slide Down
	 *
	 * Outputs a jQuery slideDown event
	 *
	 * @param	string	- element
	 * @param	string	- One of 'slow', 'normal', 'fast', or time in milliseconds
	 * @param	string	- Javascript callback function
	 * @return	string
	 */
	protected function _slideDown($element = 'this', $speed = '', $callback = '')
	{
		$element = $this->_prep_element($element);
		$speed = $this->_validate_speed($speed);

		if ($callback !== '')
		{
			$callback = ", function(){\n{$callback}\n}";
		}

		return '$('.$element.').slideDown('.$speed.$callback.');';
	}

	// --------------------------------------------------------------------

	/**
	 * Slide Toggle
	 *
	 * Outputs a jQuery slideToggle event
	 *
	 * @param	string	- element
	 * @param	string	- One of 'slow', 'normal', 'fast', or time in milliseconds
	 * @param	string	- Javascript callback function
	 * @return	string
	 */
	protected function _slideToggle($element = 'this', $speed = '', $callback = '')
	{
		$element = $this->_prep_element($element);
		$speed = $this->_validate_speed($speed);

		if ($callback !== '')
		{
			$callback = ", function(){\n{$callback}\n}";
		}

		return '$('.$element.').slideToggle('.$speed.$callback.');';
	}

	// --------------------------------------------------------------------

	/**
	 * Toggle
	 *
	 * Outputs a jQuery toggle event
	 *
	 * @param	string	- element
	 * @return	string
	 */
	protected function _toggle($element = 'this')
	{
		$element = $this->_prep_element($element);
		return '$('.$element.').toggle();';
	}

	// --------------------------------------------------------------------

	/**
	 * Toggle Class
	 *
	 * Outputs a jQuery toggle class event
	 *
	 * @param	string	- element
	 * @return	string
	 */
	protected function _toggleClass($element = 'this', $class='')
	{
		$element = $this->_prep_element($element);
		return '$('.$element.').toggleClass("'.$class.'");';
	}

	// --------------------------------------------------------------------

	/**
	 * Show
	 *
	 * Outputs a jQuery show event
	 *
	 * @param	string	- element
	 * @param	string	- One of 'slow', 'normal', 'fast', or time in milliseconds
	 * @param	string	- Javascript callback function
	 * @return	string
	 */
	protected function _show($element = 'this', $speed = '', $callback = '')
	{
		$element = $this->_prep_element($element);
		$speed = $this->_validate_speed($speed);

		if ($callback !== '')
		{
			$callback = ", function(){\n{$callback}\n}";
		}

		return '$('.$element.').show('.$speed.$callback.');';
	}

	// --------------------------------------------------------------------

	/**
	 * Updater
	 *
	 * An Ajax call that populates the designated DOM node with
	 * returned content
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	the controller to run the call against
	 * @param	string	optional parameters
	 * @return	string
	 */

	protected function _updater($container = 'this', $controller, $options = '')
	{
		$container = $this->_prep_element($container);
		$controller = (strpos('://', $controller) === FALSE) ? $controller : $this->CI->config->site_url($controller);

		// ajaxStart and ajaxStop are better choices here... but this is a stop gap
		if ($this->CI->config->item('javascript_ajax_img') === '')
		{
			$loading_notifier = 'Loading...';
		}
		else
		{
			$loading_notifier = '<img src="'.$this->CI->config->slash_item('base_url').$this->CI->config->item('javascript_ajax_img').'" alt="Loading" />';
		}

		$updater = '$('.$container.").empty();\n" // anything that was in... get it out
			."\t\t$(".$container.').prepend("'.$loading_notifier."\");\n"; // to replace with an image

		$request_options = '';
		if ($options !== '')
		{
			$request_options .= ', {'
					.(is_array($options) ? "'".implode("', '", $options)."'" : "'".str_replace(':', "':'", $options)."'")
					.'}';
		}

		return $updater."\t\t$($container).load('$controller'$request_options);";
	}


	// --------------------------------------------------------------------
	// Pre-written handy stuff
	// --------------------------------------------------------------------

	/**
	 * Zebra tables
	 *
	 * @param	string	table name
	 * @param	string	plugin location
	 * @return	string
	 */
	protected function _zebraTables($class = '', $odd = 'odd', $hover = '')
	{
		$class = ($class !== '') ? '.'.$class : '';
		$zebra  = "\t\$(\"table{$class} tbody tr:nth-child(even)\").addClass(\"{$odd}\");";

		$this->jquery_code_for_compile[] = $zebra;

		if ($hover !== '')
		{
			$hover = $this->hover("table{$class} tbody tr", "$(this).addClass('hover');", "$(this).removeClass('hover');");
		}

		return $zebra;
	}

	// --------------------------------------------------------------------
	// Plugins
	// --------------------------------------------------------------------

	/**
	 * Corner Plugin
	 *
	 * http://www.malsup.com/jquery/corner/
	 *
	 * @param	string	target
	 * @return	string
	 */
	public function corner($element = '', $corner_style = '')
	{
		// may want to make this configurable down the road
		$corner_location = '/plugins/jquery.corner.js';

		if ($corner_style !== '')
		{
			$corner_style = '"'.$corner_style.'"';
		}

		return '$('.$this->_prep_element($element).').corner('.$corner_style.');';
	}

	// --------------------------------------------------------------------

	/**
	 * modal window
	 *
	 * Load a thickbox modal window
	 *
	 * @return	void
	 */
	public function modal($src, $relative = FALSE)
	{
		$this->jquery_code_for_load[] = $this->external($src, $relative);
	}

	// --------------------------------------------------------------------

	/**
	 * Effect
	 *
	 * Load an Effect library
	 *
	 * @return	void
	 */
	public function effect($src, $relative = FALSE)
	{
		$this->jquery_code_for_load[] = $this->external($src, $relative);
	}

	// --------------------------------------------------------------------

	/**
	 * Plugin
	 *
	 * Load a plugin library
	 *
	 * @return	void
	 */
	public function plugin($src, $relative = FALSE)
	{
		$this->jquery_code_for_load[] = $this->external($src, $relative);
	}

	// --------------------------------------------------------------------

	/**
	 * UI
	 *
	 * Load a user interface library
	 *
	 * @return	void
	 */
	public function ui($src, $relative = FALSE)
	{
		$this->jquery_code_for_load[] = $this->external($src, $relative);
	}
	// --------------------------------------------------------------------

	/**
	 * Sortable
	 *
	 * Creates a jQuery sortable
	 *
	 * @return	void
	 */
	public function sortable($element, $options = array())
	{

		if (count($options) > 0)
		{
			$sort_options = array();
			foreach ($options as $k=>$v)
			{
				$sort_options[] = "\n\t\t".$k.': '.$v;
			}
			$sort_options = implode(',', $sort_options);
		}
		else
		{
			$sort_options = '';
		}

		return '$('.$this->_prep_element($element).').sortable({'.$sort_options."\n\t});";
	}

	// --------------------------------------------------------------------

	/**
	 * Table Sorter Plugin
	 *
	 * @param	string	table name
	 * @param	string	plugin location
	 * @return	string
	 */
	public function tablesorter($table = '', $options = '')
	{
		$this->jquery_code_for_compile[] = "\t$(".$this->_prep_element($table).').tablesorter('.$options.");\n";
	}

	// --------------------------------------------------------------------
	// Class functions
	// --------------------------------------------------------------------

	/**
	 * Add Event
	 *
	 * Constructs the syntax for an event, and adds to into the array for compilation
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @param	string	The event to pass
	 * @return	string
	 */
	protected function _add_event($element, $js, $event)
	{
		if (is_array($js))
		{
			$js = implode("\n\t\t", $js);

		}

		$event = "\n\t$(".$this->_prep_element($element).').'.$event."(function(){\n\t\t{$js}\n\t});\n";
		$this->jquery_code_for_compile[] = $event;
		return $event;
	}

	// --------------------------------------------------------------------

	/**
	 * Compile
	 *
	 * As events are specified, they are stored in an array
	 * This funciton compiles them all for output on a page
	 *
	 * @return	string
	 */
	protected function _compile($view_var = 'script_foot', $script_tags = TRUE)
	{
		// External references
		$external_scripts = implode('', $this->jquery_code_for_load);
		$this->CI->load->vars(array('library_src' => $external_scripts));

		if (count($this->jquery_code_for_compile) === 0)
		{
			// no inline references, let's just return
			return;
		}

		// Inline references
		$script = '$(document).ready(function() {'."\n"
			.implode('', $this->jquery_code_for_compile)
			.'});';

		$output = ($script_tags === FALSE) ? $script : $this->inline($script);

		$this->CI->load->vars(array($view_var => $output));

	}

	// --------------------------------------------------------------------

	/**
	 * Clear Compile
	 *
	 * Clears the array of script events collected for output
	 *
	 * @return	void
	 */
	protected function _clear_compile()
	{
		$this->jquery_code_for_compile = array();
	}

	// --------------------------------------------------------------------

	/**
	 * Document Ready
	 *
	 * A wrapper for writing document.ready()
	 *
	 * @return	string
	 */
	protected function _document_ready($js)
	{
		if ( ! is_array($js))
		{
			$js = array($js);
		}

		foreach ($js as $script)
		{
			$this->jquery_code_for_compile[] = $script;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Script Tag
	 *
	 * Outputs the script tag that loads the jquery.js file into an HTML document
	 *
	 * @param	string
	 * @return	string
	 */
	public function script($library_src = '', $relative = FALSE)
	{
		$library_src = $this->external($library_src, $relative);
		$this->jquery_code_for_load[] = $library_src;
		return $library_src;
	}

	// --------------------------------------------------------------------

	/**
	 * Prep Element
	 *
	 * Puts HTML element in quotes for use in jQuery code
	 * unless the supplied element is the Javascript 'this'
	 * object, in which case no quotes are added
	 *
	 * @param	string
	 * @return	string
	 */
	protected function _prep_element($element)
	{
		if ($element !== 'this')
		{
			$element = '"'.$element.'"';
		}

		return $element;
	}

	// --------------------------------------------------------------------

	/**
	 * Validate Speed
	 *
	 * Ensures the speed parameter is valid for jQuery
	 *
	 * @param	string
	 * @return	string
	 */
	protected function _validate_speed($speed)
	{
		if (in_array($speed, array('slow', 'normal', 'fast')))
		{
			return '"'.$speed.'"';
		}
		elseif (preg_match('/[^0-9]/', $speed))
		{
			return '';
		}

		return $speed;
	}

}

/* End of file Jquery.php */
/* Location: ./system/libraries/Jquery.php */