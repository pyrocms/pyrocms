<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Themes_m extends Model {

	function getThemes()
	{
		$themes = array();
		foreach(glob(APPPATH.'themes/*', GLOB_ONLYDIR) as $theme)
		{
			$themes[]->name = basename($theme);
		}
		
		return $themes;
	}

    function countThemes()
    {
		return count($this->getThemes());
    }
    
	function getDefault() {
        $this->settings->item('default_theme');
    }

	function setDefault($theme)
	{
		return $this->settings->set_item('default_theme', $theme);
	}
	
}

?>