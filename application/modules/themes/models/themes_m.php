<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Themes_m extends Model {

	function getThemes()
	{
		$themes = array();
		foreach(glob(APPPATH.'themes/*', GLOB_ONLYDIR) as $name)
		{
			$theme = new stdClass;
			$theme->name = basename($name);
			$theme->slug = urlencode($theme->name);
			
			$themes[] = $theme;
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