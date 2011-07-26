<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

require APPPATH."libraries/MX/Loader.php";

class MY_Loader extends MX_Loader {
	public function __construct()
	{
		parent::__construct();

		// Set the addons folder as a package.
		// If SITE_REF isn't defined then they must be
		// running the multi-site manager
		if (defined('SITE_REF'))
		{
			$this->add_package_path(ADDONPATH);
		}
	}
}