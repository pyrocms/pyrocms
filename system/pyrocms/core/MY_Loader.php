<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

require APPPATH."libraries/MX/Loader.php";

class MY_Loader extends MX_Loader {
	public function __construct()
	{
		parent::__construct();

		// Set the addons folder as a package
		$this->add_package_path(ADDONPATH);
	}
}