<?php
/**
 * CodeIgniter Verifier Class
 *
 * This class enables you to verify system requirements for PHP, CodeIgniter,
 * specific databases and other items.
 *
 * @author		Jacob "Pygon" Sparks 
 * @version		0.3
 */

class Verifier 
{
	var $_loaded_extensions = array();
	var $_dependants = array(
			"captcha_pi" => array(
				"checks" => array(
					"extension"=>"gd"
				)
			),

			"ftp" => array(
				"checks" => array(
					"function"=>"ftp_connect"
				)
			),

			"image_lib" => array(
				"checks" => array(
					"imagelib"=>TRUE,
				),
			),

			"xmlrpc" => array(
				"checks" => array(
					"function"=>"xml_parser_create"
				),
			),

			"xmlrpcs" => array(
				"checks" => array(
					"function"=>"xml_parser_create"
				),
			),

			"zip" => array(
				"checks" => array(
					"function"=>"gzencode"
				),
			),

			"output" => array(
				"checks" => array(
					"function"=>"gzencode",
					"ini"=>array(
							"option"=>"zlib.output_compression",
							"value"=> FALSE
					)
				)
			)
		);
	
	/**
	 * Verifier Constructor
	 * The constructor runs the initialization function.
	 * 
	 * @return void 
	 */
	function Verifier() 
	{
		$this->_initialize();
	}
	
	/**
	 * Create an array of loaded extensions and versions.
	 * 
	 * @return void
	 * @access private
	 */
	function _initialize()
	{
		$tmp_ext = get_loaded_extensions();
		
		// Fix case sensitivity for more accurate user checks and pre-fetch versions
		foreach ($tmp_ext as $value)
		{
			$this->_loaded_extensions[strtolower($value)] = phpversion($value);
		}
	}

	/**
	 * Check permissions to write to file/directory.
	 * 
	 * @param string $file file name
	 * @return bool
	 * @access public
	 */
	function check_writable($file)
	{
		return is_really_writable($file);
	}	
	
	/**
	 * Alias to function is_writable
	 * 
	 * @param string $file file name
	 * @return bool
	 * @access public
	 */
	function check_writeable($file)
	{
		return $this->check_writable($file);
	}
	
	/**
	 * Get or compare PHP version. 
	 * NOTE: Current version is left of operator.
	 * 
	 * @param string $arg[0] optional minimum version
	 * @param string $arg[1] optional comparison operator 
	 * @return mixed bool on compare,version
	 * @access public
	 */
	function check_php_version()
	{
		$args = func_get_args();
		return $this->_check_version("php", $args);
	}

	/**
	 * Get or compare an extension version. 
	 * NOTE: Current version is left of operator.
	 * 
	 * @param string $extension extension name
	 * @param optional minimum version
	 * @param optional comparison operator 
	 * @return mixed bool on compare, version
	 * @access public
	 */
	function check_extension_version($extension)
	{
		$extension = strtolower($extension);
		if(array_key_exists($extension,$this->_loaded_extensions))
		{
			$args = array();
			
			if(func_num_args() > 1)
			{
				$args = func_get_args();
				array_shift($args);	
			}
			
			return $this->_check_version($extension, $args);
		}
		return FALSE;
	}
	
	/**
	 * Private function that handles comparison of extention versions.
	 * 
	 * @param string $item "php" or extension name
	 * @param string $arg[1] optional minimum version
	 * @param string $arg[2] optional comparison operator 
	 * @return mixed bool on compare, version
	 * @access private
	 */
	function _check_version($item, $args)
	{
		$check_php = ($item == "php") ? TRUE : FALSE;
		if(!empty($args))
		{
			$min_version = $args[0];
			$operator = isset($args[1]) ? $args[1] : ">=";
			
			return version_compare( (($check_php) ? PHP_VERSION : $this->_loaded_extensions[$item]), $min_version, $operator);
		}
		
		if($check_php)
		{
			return PHP_VERSION;	
		}
		
		if( $this->_loaded_extensions[$item] === FALSE ) 
		{
			return "Unknown";
		}
		else
		{
			return $this->_loaded_extensions[$item];
		}
	}
	
	/**
	 * Function to check whether an extension is loaded.
	 * 
	 * @param string $item extension name
	 * @return bool
	 * @access public
	 */
	function check_has_extension($item)
	{
		return array_key_exists(strtolower($item),$this->_loaded_extensions);
	}
	
	/**
	 * Function to check an ini setting.
	 * 
	 * @param string $item ini setting
	 * @param mixed $value optional value to compare
	 * @return mixed bool on compare, value
	 * @access public
	 */
	function check_has_ini($item,$value=null)
	{
		$ini_val = ini_get($item);
		
		if($value !== null)
		{
			return ($ini_val == $value)? TRUE : FALSE;
		}
		
		return $ini_val;
	}
	
	/**
	 * Function to check if a function exists
	 * 
	 * @param string $item function name
	 * @return bool
	 * @access public
	 */
	function check_has_function($item)
	{
		return function_exists($item);
	}
	
	/**
	 * Function to check if a constant is defined.
	 * 
	 * @param string $item constant (case sensitive)
	 * @return bool
	 * @access public
	 */
	function check_has_constant($item)
	{
		return defined($item)? TRUE : FALSE; //Fix PHP <4.3.2 return 1 or 0 instead of TRUE/FALSE
	}
	
	/**
	 * Private function to check a dependancy.
	 * 
	 * @param string $name CI class name (with CI_)
	 * @return bool
	 * @access private
	 */
	function _check_dependancy($name)
	{
		if(is_array($this->_dependants[$name]["checks"]))
		{
			$checks =& $this->_dependants[$name]["checks"];
		}
		else
		{
			return TRUE;
		}
		
		foreach($checks as $k=>$v)
		{
			switch($k)
			{

				case "function":
					if($this->check_has_function($v) === FALSE)
					{
						return FALSE;
					}
					break;

				case "extension":
					if($this->check_has_extension($v) === FALSE)
					{
						return FALSE;
					}
					break;

				case "ini":
					if($this->check_has_ini($v["option"],$v["value"]) === FALSE)
					{
						return FALSE;
					}
					break;
				case "constant":
					if($this->check_has_constant($v) === FALSE)
					{
						return FALSE;
					}
					break;
				case "imagelib":
					if($this->check_has_imagelib() === FALSE)
					{
						return FALSE;
					}
					break;
			}
		}
		unset($checks,$k,$v);
		return TRUE;
		
	}
	
	/**
	 * Function to check that the extension selected for Image_lib is valid.
	 *  
	 * @return bool
	 * @access public
	 */
	function check_has_imagelib()
	{
		$imagelib =& load_class('Image_lib');
		$ext_image = $imagelib->image_library;
		unset($imagelib);
		if($ext_image == "gd2") $ext_image = "gd";
		return $this->check_has_extension($ext_image);
	}
	
	/**
	 * Function to check a dependancy.
	 * 
	 * @param string $name CI class name (with CI_)
	 * @return bool
	 * @access public
	 */
	function check_dependancy($name)
	{
		$name = strtolower($name);
		if(!array_key_exists($name, $this->_dependants))
		{
			return TRUE; //No known dependancies
		}
		
		if($this->_check_dependancy($name) === FALSE)
		{
			return FALSE;
		}

		return TRUE;				
	}
	
	/**
	 * Function to check all dependancies.
	 * 
	 * @param string $name CI class name (with CI_)
	 * @return array (string)name => (bool)
	 * @access public
	 */
	function check_all_dependancies()
	{
		$output = array();
		foreach(array_keys($this->_dependants) as $key)
		{
			$output[$key] = $this->_check_dependancy(strtolower($key));
		}
		unset($key);
		return count($output)>=1 ? $output : FALSE;
	}
	
	/**
	 * Function to get a list of loaded extensions.
	 * 
	 * @return array (string)name => (mixed)version
	 * @access public
	 */
	function get_extensions()
	{
		$out_exts = array();
		foreach($this->_loaded_extensions as $k => $v)
		{
			$out_exts[$k] = ($v === FALSE) ? "Unknown" : $v;
		}
		unset($k,$v);
		return $out_exts;
	}
	
}
?>