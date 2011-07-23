<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cache Class
 *
 * Partial Caching library for CodeIgniter
 *
 * @category	Libraries
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/codeigniter-cache
 * @license		MIT
 * @version		2.1
 */

class Pyrocache
{
	private $_ci;
	private $_path;
	private $_contents;
	private $_filename;
	private $_expires;
	private $_default_expires;
	private $_created;
	private $_dependencies;

	/**
	 * Constructor - Initializes and references CI
	 */
	function __construct()
	{
		log_message('debug', "Cache Class Initialized.");

		$this->_ci =& get_instance();
		$this->_reset();

		$this->_ci->load->config('pyrocache');

		$this->_path = $this->_ci->config->item('cache_dir');
		$this->_default_expires = $this->_ci->config->item('cache_default_expires');
		if ( ! is_dir($this->_path))
		{
			if ( ! mkdir($this->_path, 0777, TRUE) )
			{			
				show_error('Cache Path was not found and could not be created: ' . $this->_path);
			}
		}
	}

	/**
	 * Initialize Cache object to empty
	 *
	 * @access	private
	 * @return	void
	 */
	private function _reset()
	{
		$this->_contents = NULL;
		$this->_filename = NULL;
		$this->_expires = NULL;
		$this->_created = NULL;
		$this->_dependencies = array();
	}

	/**
	 * Call a library's cached result or create new cache
	 *
	 * @access	public
	 * @param	string
	 * @return	array
	 */
	public function library($library, $method, $arguments = array(), $expires = NULL)
	{
		if(!in_array(ucfirst($library), $this->_ci->load->_ci_classes))
		{
			$this->_ci->load->library($library);
		}

		return $this->_call($library, $method, $arguments, $expires);
	}

	/**
	 * Call a model's cached result or create new cache
	 *
	 * @access	public
	 * @return	array
	 */
	public function model($model, $method, $arguments = array(), $expires = NULL)
	{
		if(!in_array(ucfirst($model), $this->_ci->load->_ci_classes))
		{
			$this->_ci->load->model($model);
		}

		return $this->_call($model, $method, $arguments, $expires);
	}

	// Depreciated, use model() or library()
	private function _call($property, $method, $arguments = array(), $expires = NULL)
	{
		$this->_ci->load->helper('security');

		if(!is_array($arguments))
		{
			$arguments = (array) $arguments;
		}

		// Clean given arguments to a 0-index array
		$arguments = array_values($arguments);

		$cache_file = $property.DIRECTORY_SEPARATOR.do_hash($method.serialize($arguments), 'sha1');

		// See if we have this cached or delete if $expires is negative
		if($expires >= 0)
		{
			$cached_response = $this->get($cache_file);
		}
		else
		{
			$this->delete($cache_file);
			return;
		}

		// Not FALSE? Return it
		if($cached_response !== FALSE && $cached_response !== NULL)
		{
			return $cached_response;
		}

		else
		{
			// Call the model or library with the method provided and the same arguments
			$new_response = call_user_func_array(array($this->_ci->$property, $method), $arguments);
			$this->write($new_response, $cache_file, $expires);

			return $new_response;
		}
	}

	/**
	 * Helper functions for the dependencies property
	 */
	function set_dependencies($dependencies)
	{
		if (is_array($dependencies))
			$this->_dependencies = $dependencies;
		else
			$this->_dependencies = array($dependencies);

		// Return $this to support chaining
		return $this;
	}

	function add_dependencies($dependencies)
	{
		if (is_array($dependencies))
			$this->_dependencies = array_merge($this->_dependencies, $dependencies);
		else
			$this->_dependencies[] = $dependencies;

		// Return $this to support chaining
		return $this;
	}

	function get_dependencies() { return $this->_dependencies; }

	/**
	 * Helper function to get the cache creation date
	 */
	function get_created($created) { return $this->_created; }


	/**
	 * Retrieve Cache File
	 *
	 * @access	public
	 * @param	string
	 * @param	boolean
	 * @return	mixed
	 */
	function get($filename = NULL, $use_expires = true)
	{
		// Check if cache was requested with the function or uses this object
		if ($filename !== NULL)
		{
			$this->_reset();
			$this->_filename = $filename;
		}

		// Check directory permissions
		if ( ! is_dir($this->_path) OR ! is_really_writable($this->_path))
		{
			return FALSE;
		}

		// Build the file path.
		$filepath = $this->_path.$this->_filename.'.cache';

		// Check if the cache exists, if not return FALSE
		if ( ! @file_exists($filepath))
		{
			return FALSE;
		}

		// Check if the cache can be opened, if not return FALSE
		if ( ! $fp = @fopen($filepath, FOPEN_READ))
		{
			return FALSE;
		}

		// Lock the cache
		flock($fp, LOCK_SH);

		// If the file contains data return it, otherwise return NULL
		if (filesize($filepath) > 0)
		{
			$this->_contents = unserialize(fread($fp, filesize($filepath)));
		}
		else
		{
			$this->_contents = NULL;
		}

		// Unlock the cache and close the file
		flock($fp, LOCK_UN);
		fclose($fp);

		// Check cache expiration, delete and return FALSE when expired
		if ($use_expires && ! empty($this->_contents['__cache_expires']) && $this->_contents['__cache_expires'] < time())
		{
			$this->delete($filename);
			return FALSE;
		}

		// Check Cache dependencies
		if(isset($this->_contents['__cache_dependencies']))
		{
			foreach ($this->_contents['__cache_dependencies'] as $dep)
			{
				$cache_created = filemtime($this->_path.$this->_filename.'.cache');

				// If dependency doesn't exist or is newer than this cache, delete and return FALSE
				if (! file_exists($this->_path.$dep.'.cache') or filemtime($this->_path.$dep.'.cache') > $cache_created)
				{
					$this->delete($filename);
					return FALSE;
				}
			}
		}

		// Instantiate the object variables
		$this->_expires		= isset($this->_contents['__cache_expires']) ? $this->_contents['__cache_expires'] : NULL;
		$this->_dependencies = isset($this->_contents['__cache_dependencies']) ? $this->_contents['__cache_dependencies'] : NULL;
		$this->_created		= isset($this->_contents['__cache_created']) ? $this->_contents['__cache_created'] : NULL;

		// Cleanup the meta variables from the contents
		$this->_contents = @$this->_contents['__cache_contents'];

		// Return the cache
		log_message('debug', "Cache retrieved: ".$filename);
		return $this->_contents;
	}

	/**
	 * Write Cache File
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @param	int
	 * @param	array
	 * @return	void
	 */
	function write($contents = NULL, $filename = NULL, $expires = NULL, $dependencies = array())
	{
		// Check if cache was passed with the function or uses this object
		if ($contents !== NULL)
		{
			$this->_reset();
			$this->_contents = $contents;
			$this->_filename = $filename;
			$this->_expires = $expires;
			$this->_dependencies = $dependencies;
		}

		// Put the contents in an array so additional meta variables
		// can be easily removed from the output
		$this->_contents = array('__cache_contents' => $this->_contents);

		// Check directory permissions
		if ( ! is_dir($this->_path) OR ! is_really_writable($this->_path))
		{
			return;
		}

		// check if filename contains dirs
		$subdirs = explode(DIRECTORY_SEPARATOR, $this->_filename);
		if (count($subdirs) > 1)
		{
			array_pop($subdirs);
			$test_path = $this->_path.implode(DIRECTORY_SEPARATOR, $subdirs);

			// check if specified subdir exists
			if ( ! @file_exists($test_path))
			{
				// create non existing dirs, asumes PHP5
				if ( ! @mkdir($test_path, DIR_WRITE_MODE, TRUE)) return FALSE;
			}
		}

		// Set the path to the cachefile which is to be created
		$cache_path = $this->_path.$this->_filename.'.cache';

		// Open the file and log if an error occures
		if ( ! $fp = @fopen($cache_path, FOPEN_WRITE_CREATE_DESTRUCTIVE))
		{
			log_message('error', "Unable to write Cache file: ".$cache_path);
			return;
		}

		// Meta variables
		$this->_contents['__cache_created'] = time();
		$this->_contents['__cache_dependencies'] = $this->_dependencies;

		// Add expires variable if its set...
		if (! empty($this->_expires))
		{
			$this->_contents['__cache_expires'] = $this->_expires + time();
		}
		// ...or add default expiration if its set
		elseif (! empty($this->_default_expires) )
		{
			$this->_contents['__cache_expires'] = $this->_default_expires + time();
		}

		// Lock the file before writing or log an error if it failes
		if (flock($fp, LOCK_EX))
		{
			fwrite($fp, serialize($this->_contents));
			flock($fp, LOCK_UN);
		}
		else
		{
			log_message('error', "Cache was unable to secure a file lock for file at: ".$cache_path);
			return;
		}
		fclose($fp);
		@chmod($cache_path, DIR_WRITE_MODE);

		// Log success
		log_message('debug', "Cache file written: ".$cache_path);

		// Reset values
		$this->_reset();
	}

	/**
	 * Delete Cache File
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function delete($filename = NULL)
	{
		if ($filename !== NULL) $this->_filename = $filename;

		$file_path = $this->_path.$this->_filename.'.cache';

		if (file_exists($file_path)) unlink($file_path);

		// Reset values
		$this->_reset();
	}

	/**
	 * Delete a group of cached files
	 *
	 * Allows you to pass a group to delete cache. Example:
	 *
	 * <code>
	 * $this->pyrocache->write($data, 'nav_title');
	 * $this->pyrocache->write($links, 'nav_links');
	 * $this->pyrocache->delete_group('nav_');
	 * </code>
	 *
	 * @param 	string $group
	 * @return 	void
	 */
	public function delete_group($group = null)
	{
		if ($group === null)
		{
			return FALSE;
		}

		$this->_ci->load->helper('directory');
		$map = directory_map($this->_path, TRUE);

		foreach ($map AS $file)
		{
			if (strpos($file, $group)  !== FALSE)
			{
				unlink($this->_path.$file);
			}
		}

		// Reset values
		$this->_reset();
	}

	/**
	 * Delete Full Cache or Cache subdir
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function delete_all($dirname = '')
	{
		if (empty($this->_path))
		{
			return FALSE;
		}

		$this->_ci->load->helper('file');
		if (file_exists($this->_path.$dirname)) delete_files($this->_path.$dirname, TRUE);

		// Reset values
		$this->_reset();
	}
}

/* End of file Pyrocache.php */
/* Location: ./system/cms/libraries/Pyrocache.php */
