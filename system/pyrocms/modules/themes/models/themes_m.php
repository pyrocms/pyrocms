<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Themes model
 *
 * @author                 PyroCMS Development Team
 * @package             PyroCMS
 * @subpackage      Modules
 * @category            Modules
 */
class Themes_m extends CI_Model
{
    /**
     * Default Theme
     */
    public $_theme = NULL;

    /**
     * Available Themes
     */
    public $_themes = NULL;

    /**
     * Constructor - Sets the current default theme
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_theme = $this->settings->default_theme;
    }

    /**
     * Get all available themes
     *
     * @access public
     * @return <array>
     */
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

    /**
     * Get a specific theme
     *
     * @param <string> $slug
     * @return <mixed array, bool>
     */
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

    /**
     * Get details about a theme
     *
     * @access private
     * @param <string> $location
     * @param <string> $slug
     * @return <mixed array, bool>
     */
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
            $is_core = $location === APPPATH.'themes';

            //path to theme
            $web_path = $location . '/' . $slug;

            $theme->slug			= $slug;
            $theme->is_core               = $is_core;
            $theme->path			= $path;
            $theme->web_path 		= $web_path;
            $theme->screenshot		= $web_path . '/screenshot.png';

            //lets make some assumptions first just in case there is a typo in details class
            $theme->name 			= $slug;
            $theme->author 			= '????';
            $theme->author_website 	= NULL;
            $theme->website 		= NULL;
            $theme->description 	= '';
            $theme->version 		= '??';

            //load the theme details.php file
            $details = $this->_spawn_class($slug, $is_core);

            //assign values
            if($details)
            {
                foreach(get_object_vars($details) as $key => $val)
                {
                    $theme->$key = $val;
                }
            }

            // Save for later
            $this->_themes[$slug] = $theme;

            return $theme;
        }

        return FALSE;
    }

    /**
     * Count the number of available themes
     *
     * @access public
     * @return <int>
     */
    public function count()
    {
        return $this->theme_infos == NULL ? count($this->get_all()) : count($this->_themes);
    }

    /**
     * Get the default theme
     *
     * @access public
     * @return <string>
     */
    public function get_default()
    {
        return $this->_theme;
    }

    /**
     * Set a new default theme
     *
     * @access public
     * @param <string> $theme
     * @return <string>
     */
    public function set_default($theme)
    {
        return $this->settings->set_item('default_theme', $theme);
    }

    /**
     * Spawn Class
     *
     * Checks to see if a details.php exists and returns a class
     *
     * @param	string	$slug	The folder name of the theme
     * @access	private
     * @return	array
     */
    private function _spawn_class($slug, $is_core = FALSE)
    {
        $path = $is_core ? APPPATH : ADDONPATH;

        // Before we can install anything we need to know some details about the module
        $details_file = $path . 'themes/' . $slug . '/theme'.EXT;

        // Check the details file exists
        if ( ! is_file($details_file))
        {
            return FALSE;
        }

        // Sweet, include the file
        include_once $details_file;

        // Now call the details class
        $class = 'Theme_'.ucfirst($slug);

        // Now we need to talk to it
        return class_exists($class) ? new $class : FALSE;
    }
}
/* End of file models/themes_m.php */