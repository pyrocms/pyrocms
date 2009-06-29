<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Themes_m extends Model
{
	public $themes_infos = NULL;
	
	public function getThemes()
	{
		$dir = APPPATH.'themes/';

		foreach(glob($dir.'*', GLOB_ONLYDIR) as $theme_path)
		{
			$xml_file = $theme_path . '/theme.xml';
			if (file_exists($xml_file))
			{
				$theme_name = basename($theme_path);
				
				$xml = simplexml_load_file($xml_file);
				$this->themes_infos[$theme_name]['id'] 				= $theme_name;
				$this->themes_infos[$theme_name]['name'] 			= (string) $xml->name;
				$this->themes_infos[$theme_name]['author'] 			= (string) $xml->author;
				$this->themes_infos[$theme_name]['author_website'] 	= (string) $xml->author_website;
				$this->themes_infos[$theme_name]['website'] 		= (string) $xml->website;
				$this->themes_infos[$theme_name]['description'] 	= (string) $xml->description;
				$this->themes_infos[$theme_name]['version'] 		= (string) $xml->version;
				$this->themes_infos[$theme_name]['path'] 			= $theme_path;
			}
		}

		return $this->themes_infos;
	}
	
	function countThemes()
	{
		return $this->theme_infos == NULL ? count($this->getThemes()) : count($this->themes_infos);
	}
	
	function getDefault()
	{
		$this->settings->item('default_theme');
	}
	
	function setDefault($theme)
	{
		return $this->settings->set_item('default_theme', $theme);
	}
}
?>