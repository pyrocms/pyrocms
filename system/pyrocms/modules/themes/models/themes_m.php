<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Themes_m extends CI_Model
{
	public $_theme = NULL;
	public $_themes = NULL;

	public function __construct()
	{
		parent::CI_Model();
		$this->_theme = $this->settings->default_theme;
	}

	public function get_all()
	{
		foreach($this->template->theme_locations() as $location)
		{
		    foreach(glob($location.'*', GLOB_ONLYDIR) as $theme_path)
			{
				$this->_get_details(dirname($theme_path), basename($theme_path));
			}
		}

		ksort($this->_themes);

		return $this->_themes;
	}

	public function get($slug = '')
	{
		$slug OR $slug = $this->_theme;

		foreach($this->template->theme_locations() as $location)
		{
			if(is_dir($location.$slug))
			{
				$theme = $this->_get_details($location, $slug);

				if($theme !== FALSE)
				{
					return $theme;
				}
			}
		}

		return FALSE;
	}


	private function _get_details($location, $slug)
	{
		// If it exists already, use it
		if(!empty($this->_themes[$slug]))
		{
			return $this->_themes[$slug];
		}

		if (is_dir($path = $location.'/'.$slug))
		{
			// Core theme or tird party?
			$is_core = $location === ADDONPATH.'themes/';
			$web_path = $location . $slug;

			$theme->slug			= $slug;
			$theme->is_core			= $is_core;
			$theme->path			= $path;
			$theme->web_path 		= $web_path;
			$theme->screenshot		= $web_path . '/screenshot.png';

			$xml_file = $location .'/'. $slug . '/theme.xml';
			if(file_exists($xml_file))
			{
				// Grab details from the theme.xml file
				$xml = simplexml_load_file($xml_file);
				
				$theme->name 			= (string) $xml->name;
				$theme->author 			= (string) $xml->author;
				$theme->author_website 	= (string) $xml->author_website;
				$theme->website 		= (string) $xml->website;
				$theme->description 	= (string) $xml->description;
				$theme->version 		= (string) $xml->version;
			}

			else
			{
				// Guess and set defaults
				$theme->name 			= $slug;
				$theme->author 			= '????';
				$theme->author_website 	= NULL;
				$theme->website 		= NULL;
				$theme->description 	= '';
				$theme->version 		= '??';
			}

			// Save for later
			$this->_themes[$slug] = $theme;

			return $theme;
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