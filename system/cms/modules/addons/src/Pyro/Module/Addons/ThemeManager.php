<?php namespace Pyro\Module\Addons;

/**
 * Theme Manager
 *
 * @package     PyroCMS\Core\Addons
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @link        http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Addons.ThemeManager.html
 */
class ThemeManager
{
	/**
	 * Available Themes
	 *
	 * @var array
	 */
	public $exists = array();

	/**
	 * Constructor
	 */
    public function __construct()
    {
        $this->themes = new ThemeModel;
    }

	/**
	 * Get Module
	 *
	 * @return Pyro\Module\Addons\ThemeModel
	 */
	public function getModel()
	{
		return $this->themes;
	}

	/**
	 * Locate
	 *
	 * @param string $slug
	 *
	 * @return bool|object
	 */
	public function locate($slug)
	{
		foreach (ci()->template->theme_locations() as $location) {
			if (is_dir($location.$slug)) {
				$theme = $this->readDetails($location, $slug);

				if ($theme !== false) {
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
	 * @return array
	 */
	protected function readDetails($location, $slug)
	{
		// If it exists already, use it
		if ( ! empty($this->exists[$slug])) {
			return $this->exists[$slug];
		}

		if ( ! (is_dir($path = $location.$slug) and is_file($path.'/theme.php'))) {
			return false;
		}
		// Core theme or third party?
		$is_core = trim($location, '/') === APPPATH.'themes';

		//path to theme
		$web_path = $location.$slug;

		//load the theme details.php file
		$details = $this->spawnClass($slug, $is_core);

		if (( ! $theme = $this->themes->findBySlug($slug))) {
			throw new \Exception("Theme '{$slug}' does not exist!");
		}

		// Add some extra bits, that aren't in the DB
		$theme->path       = $path;
		$theme->web_path   = $web_path;
		$theme->screenshot = $web_path.'/screenshot.png';

		return $theme;
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
		foreach ($options AS $slug => $values) {
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

		$this->cache->clear('theme_m');

		return true;
	}

	/**
	 * Count the number of available themes
	 *
	 * @return int
	 */
	public function count()
	{
		return $this->theme_infos == null ? count($this->get_all()) : count($this->exists);
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
		if ($input['method'] == 'index') {
			return $this->settings->set('default_theme', $input['theme']);
		} elseif ($input['method'] == 'admin_themes') {
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
	private function spawnClass($slug, $is_core = false)
	{
		$path = $is_core ? APPPATH : ADDONPATH;

		// Before we can install anything we need to know some details about the module
		$details_file = "{$path}themes/{$slug}/theme.php";

		// Check the details file exists
		if ( ! is_file($details_file)) {
			$details_file = SHARED_ADDONPATH.'themes/'.$slug.'/theme.php';

			if ( ! is_file($details_file)) {
				return false;
			}
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
		$this->cache->clear('theme_m');

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

		foreach ($query->result() as $option) {
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

		$this->cache->clear('theme_m');
	}
}
