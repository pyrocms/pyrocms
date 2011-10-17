<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

require APPPATH."libraries/MX/Loader.php";

class MY_Loader extends MX_Loader {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->add_package_path(SHARED_ADDONPATH);
	}

	/**
	 * Since _ci_view_paths is protected we use
	 * this setter to allow things like plugins to
	 * set a view location
	 */
	public function set_view_path($path)
	{
		if (is_array($path))
		{
			// if we're restoring saved paths we'll do them all
			$this->_ci_view_paths = $path;
		}
		else
		{
			// otherwise we'll just add the specified one
			$this->_ci_view_paths = array($path => TRUE);
		}
	}
	
	/**
	 * Since _ci_view_paths is protected we use
	 * this to retrieve them.
	 */
	public function get_view_paths()
	{
		// return the full array of paths
		return $this->_ci_view_paths;
	}
}