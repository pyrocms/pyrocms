<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MP_Cache Class
 *
 * Partial Caching library for CodeIgniter
 *
 * @category	Libraries
 * @author		Jelmer Schreuder
 * @link		http://mpsimple.mijnpraktijk.com/mp_cache.htm
 * @license		MIT
 * @version		2.0b3
 */

class Cache
{
    var $ci;
    var $path;
	var $contents;
	var $filename;
	var $expires;
	var $created;
	var $dependencies;
    
	/**
	 * Constructor - Initializes and references CI
	 */
    function Cache()
    {
        $this->ci =& get_instance();
        
        $this->reset();
        
        $this->path = $this->ci->config->item('mp_cache_dir');
        $this->default_expires = $this->ci->config->item('mp_cache_default_expires'); 
        if ($this->path == '') return false;
    }
    
	/**
	 * Initialize MP_Cache object to empty
	 *
	 * @access	public
	 * @return	void
	 */
    function reset()
    {
    	$this->contents = null;
    	$this->name = null;
    	$this->expires = null;
    	$this->created = null;
    	$this->dependencies = array();
    }
    
    function call($property, $method, $arguments = array(), $expires = null)
    {
    	// Clean given arguments to a 0-index array
		$arguments = array_values($arguments);
		
    	$cache_file = $property.'/' . $method . '-'.md5(serialize($arguments));
		
		// See if we have this cached
		$cached_responce = $this->get($cache_file);

		// Not FALSE? Return it
		if($cached_responce)
        {
        	return $cached_responce;
        }
        
        else
        {
        	// Call the model or library with the method provided and the same arguments
        	$new_responce = call_user_func_array(array($this->ci->$property, $method), $arguments);
        	$this->write($new_responce, $cache_file, $expires);
        	
        	return $new_responce;
        }
    }
	
	/**
	 * Helper functions for the dependencies property
	 */
	function set_dependencies($dependencies)
	{
		if (is_array($dependencies))
			$this->dependencies = $dependencies;
		else
			$this->dependencies = array($dependencies);
		
		// Return $this to support chaining
		return $this;
	}
	function add_dependencies($dependencies)
	{
		if (is_array($dependencies))
			$this->dependencies = array_merge($this->dependencies, $dependencies);
		else
			$this->dependencies[] = $dependencies;
		
		// Return $this to support chaining
		return $this;
	}
	function get_dependencies() { return $this->dependencies; }
	
	/**
	 * Helper function to get the cache creation date
	 */
	function get_created($created) { return $this->created; }
    
    
	/**
	 * Retrieve Cache File
	 *
	 * @access	public
	 * @param	string
	 * @param	boolean
	 * @return	mixed
	 */
    function get($filename = null, $use_expires = true)
    {
        // Check if cache was requested with the function or uses this object
        if ($filename !== null)
        {
        	$this->reset();
        	$this->filename = $filename;
        }
        
        // Check directory permissions
        if ( ! is_dir($this->path) OR ! is_really_writable($this->path))
        {
            return FALSE;
        }
        
        // Build the file path.
        $filepath = $this->path.$this->filename.'.cache';
        
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
            $this->contents = unserialize(fread($fp, filesize($filepath)));
        }
        else
        {
            $this->contents = NULL;
        }
        
        // Unlock the cache and close the file
        flock($fp, LOCK_UN);
        fclose($fp);
        
        // Check cache expiration, delete and return FALSE when expired
        if ($use_expires && ! empty($this->contents['__mp_cache_expires']) && $this->contents['__mp_cache_expires'] < time())
        {
            $this->delete($filename);
            return false;
        }
        
        // Check Cache dependencies
        if(isset($this->contents['__mp_cache_dependencies']))
        {
	        foreach ($this->contents['__mp_cache_dependencies'] as $dep)
	        {
	        	$cache_created = filemtime($this->path.$this->filename.'.cache');
	        	
	        	// If dependency doesn't exist or is newer than this cache, delete and return FALSE
	        	if (! file_exists($this->path.$dep.'.cache') or filemtime($this->path.$dep.'.cache') > $cache_created)
	        	{
		            $this->delete($filename);
		            return false;
	        	}
	        }
        }
        
        // Instantiate the object variables
    	$this->expires      = @$this->contents['__mp_cache_expires'];
    	$this->dependencies = @$this->contents['__mp_cache_dependencies'];
    	$this->created      = @$this->contents['__mp_cache_created'];
        
        // Cleanup the MP_Cache variables from the contents
        $this->contents = @$this->contents['__mp_cache_contents'];
        
        // Return the cache
        log_message('debug', "MP_Cache retrieved: ".$filename);
        return $this->contents;
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
    function write($contents = null, $filename = null, $expires = null, $dependencies = array())
    {
        // Check if cache was passed with the function or uses this object
        if ($contents !== null)
        {
        	$this->reset();
        	$this->contents = $contents;
        	$this->filename = $filename;
        	$this->expires = $expires;
	        $this->dependencies = $dependencies;
        }
        
        // Put the contents in an array so additional MP_Cache variables
        // can be easily removed from the output
        $this->contents = array('__mp_cache_contents' => $this->contents);
        
        // Check directory permissions
        if ( ! is_dir($this->path) OR ! is_really_writable($this->path))
        {
            return;
        }
        
        
        // check if filename contains dirs
        $subdirs = explode('/', $this->filename);
        if (count($subdirs) > 1)
        {
            array_pop($subdirs);
            $test_path = $this->path.implode('/', $subdirs);
            
            // check if specified subdir exists
            if ( ! @file_exists($test_path))
            {
                // create non existing dirs, asumes PHP5
                if ( ! @mkdir($test_path)) return false;
            }
        }
        
        // Set the path to the cachefile which is to be created
        $cache_path = $this->path.$this->filename.'.cache';
		
        // Open the file and log if an error occures
        if ( ! $fp = @fopen($cache_path, FOPEN_WRITE_CREATE_DESTRUCTIVE))
        {
            log_message('error', "Unable to write MP_cache file: ".$cache_path);
            return;
        }
        
        // MP_Cache variables
        $this->contents['__mp_cache_created'] = time();
        $this->contents['__mp_cache_dependencies'] = $this->dependencies;
        
        // Add expires variable if its set...
        if (! empty($this->expires))
        {
            $this->contents['__mp_cache_expires'] = $this->expires;
        }
        // ...or add default expiration if its set
        elseif (! empty($this->default_expiry) && $this->expires !== 0)
		{
			$this->contents['__mp_cache_expires'] = $this->default_expires;
		}
        
        // Lock the file before writing or log an error if it failes
        if (flock($fp, LOCK_EX))
        {
            fwrite($fp, serialize($this->contents));
            flock($fp, LOCK_UN);
        }
        else
        {
            log_message('error', "MP_Cache was unable to secure a file lock for file at: ".$cache_path);
            return;
        }
        fclose($fp);
        @chmod($cache_path, DIR_WRITE_MODE);
		
        // Log success
        log_message('debug', "MP_Cache file written: ".$cache_path);
        
        // Reset values
        $this->reset();
    }
    
	/**
	 * Delete Cache File
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */	
    function delete($filename = null)
    {
    	if ($filename !== null) $this->filename = $filename;
    	
        $file_path = $this->path.$this->filename.'.cache';
        
        if (file_exists($file_path)) unlink($file_path);
        
        // Reset values
        $this->reset();
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
        if (empty($this->path)) return false;

        $this->ci->load->helper('file');
        if (file_exists($this->path.$dirname)) delete_files($this->path.$dirname, TRUE);
        
        // Reset values
        $this->reset();
    }
}