<?php  defined('BASEPATH') or exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

/**
 * PyroCMS Settings Library
 *
 * Allows for an easy interface for site settings
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @package		PyroCMS
 * @subpackage	Settings
 */
class Settings
{

	/**
	 * Settings cache
	 *
	 * @var	array
	 */
	private static $cache = array();

	/**
	 * The settings table columns
	 *
	 * @var	array
	 */
	private $columns = array('slug', 'title', 'description', 'type', 'default', 'value', 'options', 'is_required', 'is_gui', 'module');

	/**
	 * The Settings Construct
	 */
	public function __construct()
	{
		ci()->load->model('settings/settings_m');

		$this->get_all();
	}

	/**
	 * Getter
	 *
	 * Gets the setting value requested
	 *
	 * @param	string	$name
	 */
	public function __get($name)
	{
		return self::get($name);
	}

	/**
	 * Setter
	 *
	 * Sets the setting value requested
	 *
	 * @param	string	$name
	 * @param	string	$value
	 * @return	bool
	 */
	public function __set($name, $value)
	{
		return self::set($name, $value);
	}

	/**
	 * Get
	 *
	 * Gets a setting.
	 *
	 * @param	string	$name
	 * @return	bool
	 */
	public static function get($name)
	{
		if(isset(self::$cache[$name]))
		{
			return self::$cache[$name];
		}

		$setting = ci()->settings_m->get_by(array('slug' => $name));

		// Setting doesn't exist, maybe it's a config option
		$value = $setting ? $setting->value : config_item($name);

		// Store it for later
		self::$cache[$name] = $value;

		return $value;
	}

	/**
	 * Set
	 *
	 * Sets a config item
	 * 
	 * @param	string	$name
	 * @param	string	$value
	 * @return	bool
	 */
	public static function set($name, $value)
	{
		$setting = ci()->settings_m->update($name, array('value' => $value));

		self::$cache[$name] = $value;

		return TRUE;
	}



	/**
	 * Item
	 *
	 * Old way of getting an item.
	 * @deprecated	v1.0	Use either __get or Settings::get() instead
	 * @param	string	$name
	 * @return	bool
	 */
	public function item($name)
	{
		return $this->__get($name);
	}

	/**
	 * Set Item
	 *
	 * Old way of getting an item.
	 * @deprecated	v1.0	Use either __set or Settings::set() instead
	 * @param	string	$name
	 * @param	string	$value
	 * @return	bool
	 */
	public function set_item($name, $value)
	{
		return $this->__set($name, $value);
	}

	/**
	 * All
	 *
	 * Gets all the settings
	 *
	 * @return	array
	 */
	public function get_all()
	{
		$settings = ci()->settings_m->get_all();

		foreach($settings as $setting)
		{
			self::$cache[$setting->slug] = $setting->value;
		}

		return self::$cache;
	}

	/**
	 * Add Setting
	 *
	 * Adds a new setting to the database
	 *
	 * @param	array	$setting
	 * @return	int
	 */
	public function add($setting)
	{
		if(!$this->_check_format($setting))
		{
			return FALSE;
		}

		return ci()->settings_m->insert($setting);
	}

	/**
	 * Delete Setting
	 *
	 * Deletes setting to the database
	 *
	 * @param	string	$name
	 * @return	bool
	 */
	public function delete($name)
	{
		return ci()->settings_m->delete_by(array('slug' => $name));
	}

	/**
	 * Form Control
	 *
	 * Returns the form control for the setting.
	 *
	 * @param	object	$setting
	 * @return	string
	 */
	public function form_control(&$setting)
	{
		switch($setting->type)
		{
			default:
			case 'text':
				$form_control = form_input(array(
						'id'	=>	$setting->slug,
						'name'	=>	$setting->slug,
						'value'	=>	$setting->value,
						'class' => 'text width-20'
				));
				break;

			case 'textarea':
				$form_control = form_textarea(array(
						'id'	=>	$setting->slug,
						'name'	=>	$setting->slug,
						'value'	=>	$setting->value,
						'class'	=>	'width-20'
				));
				break;

			case 'password':
				$form_control = form_password(array(
						'id'	=>	$setting->slug,
						'name'	=>	$setting->slug,
						'value'	=>	$setting->value,
						'class' => 'text width-20'
				));
				break;

			case 'select':
				$form_control = form_dropdown(
						$setting->slug,
						$this->_format_options($setting->options),
						$setting->value,
						'class="width-20"'
				);
				break;

			case 'checkbox':
			case 'radio':

				$func = $setting->type == 'checkbox' ? 'form_checkbox' : 'form_radio';

				$form_control = '';

				foreach($this->_format_options($setting->options) as $value => $label) {
					$form_control .= ' '.form_radio(array(
							'id'		=>	$setting->slug,
							'name'		=>	$setting->slug,
							'checked'	=>	$setting->value == $value,
							'value'		=>	$value
							)) . ' '.$label;
				}
				break;
		}

		return $form_control;
	}

	/**
	 * Format Options
	 *
	 * Formats the options for a setting into an associative array.
	 *
	 * @param	array	$options
	 * @return	array
	 */
	private function _format_options($options = array())
	{
		$select_array = array();

		foreach(explode('|', $options) as $option) {
			list($value, $name) = explode('=', $option);
			$select_array[$value] = $name;
		}

		return $select_array;
	}

	/**
	 * Check Format
	 *
	 * This assures that the setting is in the correct format.
	 * Works with arrays or objects (it is PHP 5.3 safe)
	 *
	 * @param	string	$setting
	 * @return	bool	If the setting is the correct format
	 */
	private function _check_format($setting)
	{
		if(!isset($setting))
		{
			return FALSE;
		}

		foreach($setting as $key)
		{
			if(!array_key_exists($key, $this->columns))
			{
				return FALSE;
			}
		}

		return TRUE;
	}
}

/* End of file Settings.php */