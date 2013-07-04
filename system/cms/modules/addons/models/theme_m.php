<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Theme model
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Themes\Model
 */
class Theme_m extends MY_Model
{
	/**
	 * Default Theme
	 *
	 * @var string
	 */
	public $_theme = null;

	/**
	 * Default Admin Theme
	 *
	 * @var string
	 */
	public $_admin_theme = null;

	/**
	 * Available Themes
	 *
	 * @var array
	 */
	public $_themes = null;

	/**
	 * Sets the current default theme
	 */
    public function __construct()
    {
        parent::__construct();
        $this->_theme = $this->settings->default_theme;
		$this->_admin_theme = $this->settings->admin_theme;
    }

    /**
     * Get all available themes
     *
     * @return <array>
     */
    public function get_all()
    {
        foreach ($this->template->theme_locations() as $location)
        {
			if ( ! $themes = glob($location.'*', GLOB_ONLYDIR))
			{
				continue;
			}

			foreach ($themes as $theme_path)
			{
				$this->_get_details(dirname($theme_path).'/', basename($theme_path));
			}
		}

		ksort($this->_themes);

		return $this->_themes;
	}

	/**
	 * Get a specific theme
	 *
	 * @param string $slug
	 *
	 * @return bool|object
	 */
	public function get($slug = '')
	{
		$slug OR $slug = $this->_theme;

		foreach ($this->template->theme_locations() as $location)
		{
			if (is_dir($location.$slug))
			{
				$theme = $this->_get_details($location, $slug);

				if ($theme !== false)
				{
					return $theme;
				}
			}
		}

		return false;
	}

	/**
	 * Get the admin theme
	 *
	 * @param string $slug
	 *
	 * @return bool|object
	 */
	public function get_admin($slug = '')
	{
		$slug OR $slug = $this->_admin_theme;

		foreach ($this->template->theme_locations() as $location)
		{
			if (is_dir($location.$slug))
			{
				$theme = $this->_get_details($location, $slug);

				if ($theme !== false)
				{
					return $theme;
				}
			}
		}

		return false;
	}

	/**
	 * Get details about a theme
	 *
	 * @param $location
	 * @param $slug
	 *
	 * @return bool|object
	 */
	private function _get_details($location, $slug)
	{
		// If it exists already, use it
		if ( ! empty($this->_themes[$slug]))
		{
			return $this->_themes[$slug];
		}

		if (is_dir($path = $location.$slug) and is_file($path.'/theme.php'))
		{
			// Core theme or third party?
			$is_core = trim($location, '/') === APPPATH.'themes';

			//path to theme
			$web_path = $location.$slug;

			$theme                 = new stdClass();
			$theme->slug           = $slug;
			$theme->is_core        = $is_core;
			$theme->path           = $path;
			$theme->web_path       = $web_path; // TODO Same thing as path?
			$theme->screenshot     = $web_path.'/screenshot.png';

			//lets make some assumptions first just in case there is a typo in details class
			$theme->name           = $slug;
			$theme->author         = '????';
			$theme->author_website = null;
			$theme->website        = null;
			$theme->description    = '';
			$theme->version        = '??';

			//load the theme details.php file
			$details = $this->_spawn_class($location, $slug);

			//assign values
			if ($details)
			{
				foreach (get_object_vars($details) as $key => $val)
				{
					if ($key == 'options' and is_array($val))
					{
						// only save to the database if there are no options saved already
						if ( ! $this->db->where('theme', $slug)->get('theme_options')->result())
						{
							$this->_save_options($slug, $val);
						}
					}
					$theme->{$key} = $val;
				}
			}

			// Save for later
			$this->_themes[$slug] = $theme;

			return $theme;
		}

		return false;
	}

	/**
	 * Index Options
	 *
	 * @param string $theme The theme to save options for
	 * @param array $options The theme options to save to the db
	 *
	 * @return boolean
	 */
	public function _save_options($theme, $options)
	{
		foreach ($options AS $slug => $values)
		{
			// build the db insert array
			$insert = array(
				'slug' => $slug,
				'title' => $values['title'],
				'description' => $values['description'],
				'default' => $values['default'],
				'type' => $values['type'],
				'value' => $values['default'],
				'options' => $values['options'],
				'is_required' => $values['is_required'],
				'theme' => $theme,
			);

			$this->db->insert('theme_options', $insert);
		}

		$this->pyrocache->delete_all('theme_m');

		return true;
	}

	/**
	 * Count the number of available themes
	 *
	 * @return int
	 */
	public function count()
	{
		return $this->theme_infos == null ? count($this->get_all()) : count($this->_themes);
	}

	/**
	 * Get the default theme
	 *
	 * @return string
	 */
	public function get_default()
	{
		return $this->_theme;
	}

	/**
	 * Set a new default theme
	 *
	 * @param string $input
	 *
	 * @return string
	 */
	public function set_default($input)
	{
		if ($input['method'] == 'index')
		{
			return $this->settings->set('default_theme', $input['theme']);
		}
		elseif ($input['method'] == 'admin_themes')
		{
			return $this->settings->set('admin_theme', $input['theme']);
		}
	}

	/**
	 * Spawn Class
	 *
	 * Checks to see if a details.php exists and returns a class
	 *
	 * @param string $slug The folder name of the theme
	 * @param bool $is_core
	 *
	 * @return array
	 */
	private function _spawn_class($location, $slug)
	{
		// Before we can install anything we need to know some details about the module
		$details_file = $location.$slug.'/theme'.EXT;

		// Check the details file exists
		if ( ! is_file($details_file))
		{
			return false;
		}

		// Sweet, include the file
		include_once $details_file;

		// Now call the details class
		$class = 'Theme_'.ucfirst(strtolower($slug));

		// Now we need to talk to it
		return class_exists($class) ? new $class : false;
	}

	/**
	 * Delete Options
	 *
	 * @param string $theme The theme to delete options for
	 *
	 * @return boolean
	 */
	public function delete_options($theme)
	{
		$this->pyrocache->delete_all('theme_m');

		return $this->db
			->where('theme', $theme)
			->delete('theme_options');
	}

	/**
	 * Get option
	 *
	 * @param array|string $params The where conditions to fetch the option by
	 *
	 * @return array
	 */
	public function get_option($params = array())
	{
		return $this->db
			->select('value')
			->where($params)
			->where('theme', $this->_theme)
			->get('theme_options')
			->row();
	}

	/**
	 * Get options by
	 *
	 * @param array|string $params The where conditions to fetch options by
	 *
	 * @return array
	 */
	public function get_options_by($params = array())
	{
		return $this->db
			->where($params)
			->get('theme_options')
			->result();
	}

	/**
	 * Get values by
	 *
	 * @param array|string $params The where conditions to fetch options by
	 *
	 * @return array
	 */
	public function get_values_by($params = array())
	{
		$options = new stdClass;

		$query = $this->db
			->select('slug, value')
			->where($params)
			->get('theme_options');

		foreach ($query->result() as $option)
		{
			$options->{$option->slug} = $option->value;
		}

		return $options;
	}

	/**
	 * Update options
	 *
	 * @param array $input The values to update
	 * @param string $slug The slug of the option to update
	 *
	 * @return boolean
	 */
	public function update_options($slug, $input)
	{
		$this->db
			->where('slug', $slug)
			->update('theme_options', $input);

		$this->pyrocache->delete_all('theme_m');
	}
}
