<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Themes_m extends Model
{
	public $_theme = NULL;
	public $_themes = NULL;

	public function __construct()
	{
		parent::Model();
		$this->_theme = $this->settings->item('default_theme');
	}

	public function get_all()
	{
		foreach($this->template->theme_locations() as $location => $offset)
		{
			foreach(glob($location.'*', GLOB_ONLYDIR) as $theme_path)
			{
				$this->_get_details($theme_path);
			}
		}

		return $this->_themes;
	}
	
	public function get($name = '')
	{
		if(!$name)
		{
			$name = $this->_theme;
		}

		foreach($this->template->theme_locations() as $location => $offset)
		{
			$theme = $this->_get_details($location.$name);

			if($theme !== FALSE)
			{
				return $theme;
			}
		}

		return FALSE;
	}


	private function _get_details($theme_path)
	{
		$theme_name = basename($theme_path);
		$location = dirname($theme_path);

		// If it exists already, use it
		if(!empty($this->_themes[$theme_name]))
		{
			return $this->_themes[$theme_name];
		}
		
		$xml_file = $theme_path . '/theme.xml';
		if (file_exists($xml_file))
		{
			// Core theme or tird party?
			$is_core = strpos($location, 'third_party') === FALSE;
			$web_path = $is_core ? APPPATH_URI : BASE_URL.'third_party';

			$xml = simplexml_load_file($xml_file);
			$this->_themes[$theme_name]->slug				= $theme_name;
			$this->_themes[$theme_name]->name 			= (string) $xml->name;
			$this->_themes[$theme_name]->author 			= (string) $xml->author;
			$this->_themes[$theme_name]->author_website 	= (string) $xml->author_website;
			$this->_themes[$theme_name]->website 		= (string) $xml->website;
			$this->_themes[$theme_name]->description 	= (string) $xml->description;
			$this->_themes[$theme_name]->version 		= (string) $xml->version;
			$this->_themes[$theme_name]->path 			= $theme_path;
			$this->_themes[$theme_name]->web_path 			= $web_path;
			$this->_themes[$theme_name]->screenshot 	=  $web_path . '/themes/' . $theme_name . '/screenshot.png';

			return $this->_themes[$theme_name];
		}

		return FALSE;
	}
	
	function count()
	{
		return $this->theme_infos == NULL ? count($this->get_all()) : count($this->_themes);
	}
	
	function get_default()
	{
		$this->_theme;
	}
	
	function set_default($theme)
	{
		return $this->settings->set_item('default_theme', $theme);
	}
}
?>