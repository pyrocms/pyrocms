<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cache Class
 *
 * Partial Caching library for CodeIgniter
 *
 * @category	PyroCMS\Core\Libraries\PyroCache
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/codeigniter-cache
 * @license		MIT
 * @version		2.1
 */

class Pyrocache
{
	/**
	 * @var CI_Controller The Codeigniter instance object.
	 */
	private $_ci;
	/**
	 * .@var string The cache path
	 */
	private $_path;
	/**
	 * @todo Document this.
	 * @var
	 */
	private $_contents;
	/**
	 * @var string The name of the cache file.
	 */
	private $_filename;
	/**
	 * @todo Document this.
	 * @var
	 */
	private $_expires;
	/**
	 * @todo Document this.
	 * @var
	 */
	private $_default_expires;
	/**
	 * @todo Document this.
	 * @var
	 */
	private $_created;
	/**
	 * @todo Document this.
	 * @var array
	 */
	private $_dependencies;

	/**
	 * Constructor
	 *
	 * Initializes and references Codeigniter object.
	 */
	public function __construct()
	{
		log_message('debug', "Cache Class Initialized.");

		$this->_ci =& get_instance();
		$this->_reset();

		$this->_ci->load->config('pyrocache');

		$this->_path = $this->_ci->config->item('cache_dir');
		$this->_default_expires = $this->_ci->config->item('cache_default_expires');
		if ( ! is_dir($this->_path))
		{
			if ( ! mkdir($this->_path, 0777, true))
			{
				show_error('Cache Path was not found and could not be created: '.$this->_path);
			}
		}
	}

	/**
	 * Initialize Cache object to empty
	 */
	private function _reset()
	{
		$this->_contents = null;
		$this->_filename = null;
		$this->_expires = null;
		$this->_created = null;
		$this->_dependencies = array();
	}


	/**
	 * Call a library's cached result or create new cache
	 *
	 * @todo Document this function
	 *
	 * @param string $library
	 * @param string $method
	 * @param array $arguments
	 * @param null $expires
	 * @return mixed
	 */
	public function library($library, $method, $arguments = array(), $expires = null)
	{
		if ( ! $this->_ci->load->is_loaded($library))
		{
			$this->_ci->load->library($library);
		}

		return $this->_call($library, $method, $arguments, $expires);
	}


	/**
	 * Call a model's cached result or create new cache
	 * @todo Document this function's parameters.
	 * @param $model
	 * @param $method
	 * @param array $arguments
	 * @param null $expires
	 * @return mixed
	 */
	public function model($model, $method, $arguments = array(), $expires = null)
	{
		if ( ! $this->_ci->load->is_loaded($model))
		{
			$this->_ci->load->model($model);
		}

		return $this->_call($model, $method, $arguments, $expires);
	}


	/**
	 * Use PyroCache::model() or PyroCache::library() instead of this.
	 *
	 * @see PyroCache::model(), PyroCache::library()
	 * @todo Document this function's parameters.
	 * @param $property
	 * @param $method
	 * @param array $arguments
	 * @param null $expires
	 *
	 * @return mixed
	 */
	private function _call($property, $method, $arguments = array(), $expires = null)
	{
		$this->_ci->load->helper('security');

		if ( ! is_array($arguments))
		{
			$arguments = (array)$arguments;
		}

		// Clean given arguments to a 0-index array
		$arguments = array_values($arguments);

		$cache_file = $property.DIRECTORY_SEPARATOR.do_hash($_SERVER['SERVER_NAME'].$method.serialize($arguments), 'sha1');

		// Delete if expires is negative
		if ($expires < 0)
		{
			$this->delete($cache_file);
			return;
		}

		// See if we have this cached
		$cached_response = $this->get($cache_file);

		// Not false? Return it
		if ($cached_response !== false && $cached_response !== null)
		{
			return $cached_response;
		}

		// Call the model or library with the method provided and the same arguments
		$new_response = call_user_func_array(array($this->_ci->$property, $method), $arguments);
		$this->write($new_response, $cache_file, $expires);
		return $new_response;
	}

	/**
	 * Set the dependencies
	 *
	 * Overwrites existing ones.
	 * @todo Document this function's parameters.
	 * @param $dependencies
	 *
	 * @return Pyrocache
	 */
	public function set_dependencies($dependencies)
	{
		if (is_array($dependencies))
		{
			$this->_dependencies = $dependencies;
		}
		else
		{
			$this->_dependencies = array($dependencies);
		}

		// Return $this to support chaining
		return $this;
	}

	/**
	 * Adds dependencies.
	 * @todo Document this function's parameters.
	 * @param $dependencies
	 *
	 * @return Pyrocache
	 */
	public function add_dependencies($dependencies)
	{
		if (is_array($dependencies))
		{
			$this->_dependencies = array_merge($this->_dependencies, $dependencies);
		}
		else
		{
			$this->_dependencies[] = $dependencies;
		}

		// Return $this to support chaining
		return $this;
	}

	/**
	 * Getter for the dependencies
	 *
	 * @return mixed
	 */
	public function get_dependencies()
	{
		return $this->_dependencies;
	}


	/**
	 * Helper function to get the cache creation date
	 *
	 * @param $created @todo Not used.
	 *
	 * @return mixed
	 */
	public function get_created($created)
	{
		return $this->_created;
	}

	/**
	 * Retrieve Cache File
	 *
	 * @todo Document this function's parameters.
	 * @param string|null $filename
	 * @param bool $use_expires
	 *
	 * @return bool
	 */
	public function get($filename = null, $use_expires = true)
	{
		// Check if cache was requested with the function or uses this object
		if ($filename !== null)
		{
			$this->_reset();
			$this->_filename = $filename;
		}

		// Check directory permissions
		if ( ! is_dir($this->_path) or ! is_really_writable($this->_path))
		{
			return false;
		}

		// Build the file path.
		$filepath = $this->_path.$this->_filename.'.cache';

		// Check if the cache exists, if not return false
		if ( ! @file_exists($filepath))
		{
			return false;
		}

		// Check if the cache can be opened, if not return false
		if ( ! $fp = @fopen($filepath, FOPEN_READ))
		{
			return false;
		}

		// Lock the cache
		flock($fp, LOCK_SH);

		// If the file contains data return it, otherwise return null
		if (filesize($filepath) > 0)
		{
			$this->_contents = unserialize(fread($fp, filesize($filepath)));
		}
		else
		{
			$this->_contents = null;
		}

		// Unlock the cache and close the file
		flock($fp, LOCK_UN);
		fclose($fp);

		// Check cache expiration, delete and return false when expired
		if ($use_expires && ! empty($this->_contents['__cache_expires']) && $this->_contents['__cache_expires'] < time())
		{
			$this->delete($filename);
			return false;
		}

		// Check Cache dependencies
		if (isset($this->_contents['__cache_dependencies']))
		{
			foreach ($this->_contents['__cache_dependencies'] as $dep)
			{
				$cache_created = filemtime($this->_path.$this->_filename.'.cache');

				// If dependency doesn't exist or is newer than this cache, delete and return false
				if ( ! file_exists($this->_path.$dep.'.cache') or filemtime($this->_path.$dep.'.cache') > $cache_created)
				{
					$this->delete($filename);
					return false;
				}
			}
		}

		// Instantiate the object variables
		$this->_expires = isset($this->_contents['__cache_expires']) ? $this->_contents['__cache_expires'] : null;
		$this->_dependencies = isset($this->_contents['__cache_dependencies']) ? $this->_contents['__cache_dependencies'] : null;
		$this->_created = isset($this->_contents['__cache_created']) ? $this->_contents['__cache_created'] : null;

		// Cleanup the meta variables from the contents
		$this->_contents = @$this->_contents['__cache_contents'];

		// Return the cache
		log_message('debug', "Cache retrieved: ".$filename);
		return $this->_contents;
	}

	/**
	 * Write Cache File
	 *
	 * @todo Document this function's parameters.
	 *
	 * @param null $contents
	 * @param null $filename
	 * @param null $expires
	 * @param array $dependencies
	 *
	 * @return bool|void
	 */
	public function write($contents = null, $filename = null, $expires = null, $dependencies = array())
	{
		// Check if cache was passed with the function or uses this object
		if ($contents !== null)
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
		if ( ! is_dir($this->_path) or ! is_really_writable($this->_path))
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
				if ( ! @mkdir($test_path, DIR_WRITE_MODE, true)) {
					return false;
				}
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
		if ( ! empty($this->_expires))
		{
			$this->_contents['__cache_expires'] = $this->_expires + time();
		}
		// ...or add default expiration if its set
		elseif ( ! empty($this->_default_expires))
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
	 * Delete Cache File.
	 *
	 * @param string|null $filename The filename to delete.
	 */
	public function delete($filename = null)
	{
		if ($filename !== null) {
			$this->_filename = $filename;
		}

		$file_path = $this->_path.$this->_filename.'.cache';

		if (file_exists($file_path)) {
			unlink($file_path);
		}

		// Reset values
		$this->_reset();
	}


	/**
	 * Delete a group of cached files.
	 *
	 * Allows you to pass a group to delete cache. Example:
	 *
	 * <code>
	 * $this->pyrocache->write($data, 'nav_title');
	 * $this->pyrocache->write($links, 'nav_links');
	 * $this->pyrocache->delete_group('nav_');
	 * </code>
	 *
	 * @param string|null $group The name (or part of it) of the group of cache files to delete.
	 *
	 * @return bool
	 */
	public function delete_group($group = null)
	{
		if ($group === null)
		{
			return false;
		}

		$this->_ci->load->helper('directory');
		$map = directory_map($this->_path, true);

		foreach ($map AS $file)
		{
			if (strpos($file, $group) !== false)
			{
				unlink($this->_path.$file);
			}
		}

		// Reset values
		$this->_reset();
	}


	/**
	 * Delete Full Cache or Cache subdirectory.
	 *
	 * @param string $dirname The directory name.
	 *
	 * @return bool
	 */
	public function delete_all($dirname = '')
	{
		if (empty($this->_path))
		{
			return false;
		}

		$this->_ci->load->helper('file');
		if (file_exists($this->_path.$dirname)) {
			delete_files($this->_path.$dirname, true);
		}

		// Reset values
		$this->_reset();
	}
}