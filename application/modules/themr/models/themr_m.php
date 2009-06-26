<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Themr_m extends Model
{
	static $themes_infos = array();
	
	public static function getThemes()
	{
		$dir = APPPATH.'themes/';

		if ($handle = opendir($dir))
		{
			while (false !== ($theme_id = readdir($handle)))
			{
				if ( is_dir($dir.$theme_id) && strpos($theme_id, '.') !== 0)
				{
					$xml_file = $dir . $theme_id . '/theme.xml';
					if (file_exists($xml_file)) {
						$xml = simplexml_load_file($xml_file);
						self::$themes_infos[$theme_id]['id'] 			= (string) $theme_id;
						self::$themes_infos[$theme_id]['name'] 			= (string) $xml->name;
						self::$themes_infos[$theme_id]['author'] 		= (string) $xml->author;
						self::$themes_infos[$theme_id]['author_website'] = (string) $xml->author_website;
						self::$themes_infos[$theme_id]['website'] 		= (string) $xml->website;
						self::$themes_infos[$theme_id]['description'] 	= (string) $xml->description;
						self::$themes_infos[$theme_id]['version'] 		= (string) $xml->version;
						self::$themes_infos[$theme_id]['path'] 			= (string) $dir . $theme_id;
					}
				}
			}
			closedir($handle);
		}

		ksort(self::$themes_infos);
		return self::$themes_infos;
	}
	
	function countThemes()
	{
		return count($this->themes_infos);
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