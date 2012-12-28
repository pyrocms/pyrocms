<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * PyroCMS Settings Library
 *
 * Allows for an easy interface for site settings
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Settings\Libraries
 */
class Settings {

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
	private static $columns = array('slug', 'title', 'description', 'type', 'default', 'value', 'options', 'is_required', 'is_gui', 'module', 'order');

	/**
	 * The Settings Construct
	 */
	public function __construct()
	{
		ci()->load->model('settings/settings_m');

		ci()->lang->load('settings/settings');

		self::get_all();
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
		if (isset(self::$cache[$name]))
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
		if (is_string($name))
		{
			if (is_scalar($value))
			{
				$setting = ci()->settings_m->update($name, array('value' => $value));
			}

			self::$cache[$name] = $value;

			return true;
		}

		return false;
	}

	/**
	 * Temp
	 *
	 * Changes a setting for this request only. Does not modify the database
	 *
	 * @param	string	$name
	 * @param	string	$value
	 * @return	bool
	 */
	public static function temp($name, $value)
	{
		// store the temp value in the cache so that all subsequent calls
		// for this request will use it instead of the database value
		self::$cache[$name] = $value;
	}

	/**
	 * All
	 *
	 * Gets all the settings
	 *
	 * @return	array
	 */
	public static function get_all()
	{
		if (self::$cache)
		{
			return self::$cache;
		}

		$settings = ci()->settings_m->get_many_by(array());

		foreach ($settings as $setting)
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
	public static function add($setting)
	{
		if ( ! self::_check_format($setting))
		{
			return false;
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
	public static function delete($name)
	{
		return ci()->settings_m->delete_by(array('slug' => $name));
	}

	/**
	 * Form Control
	 *
	 * Returns the form control for the setting.
	 *
	 * @todo: Code duplication, see modules/themes/controllers/admin.php @ form_control().
	 *
	 * @param	object	$setting
	 * @return	string
	 */
	public static function form_control(&$setting)
	{
		if ($setting->options)
		{
			// @usage func:function_name | func:helper/function_name | func:module/helper/function_name
			// @todo: document the usage of prefix "func:" to get dynamic options
			// @todo: document how construct functions to get here the expected data
			if (substr($setting->options, 0, 5) == 'func:')
			{
				$func = substr($setting->options, 5);

				if (($pos = strrpos($func, '/')) !== false)
				{
					$helper	= substr($func, 0, $pos);
					$func	= substr($func, $pos + 1);

					if ($helper)
					{
						ci()->load->helper($helper);
					}
				}

				if (is_callable($func))
				{
					// @todo: add support to use values scalar, bool and null correctly typed as params
					$setting->options = call_user_func($func);
				}
				else
				{
					$setting->options = array('=' . lang('global:select-none'));
				}
			}

			// If its an array un-CSV it
			if (is_string($setting->options))
			{
				$setting->options = explode('|', $setting->options);
			}
		}

		switch ($setting->type)
		{
			default:
			case 'text':
				$form_control = form_input(array(
					'id'	=> $setting->slug,
					'name'	=> $setting->slug,
					'value'	=> $setting->value,
					'class'	=> 'text width-20'
				));
				break;

			case 'textarea':
				$form_control = form_textarea(array(
					'id'	=> $setting->slug,
					'name'	=> $setting->slug,
					'value'	=> $setting->value,
					'class'	=> 'width-20'
				));
				break;

			case 'password':
				$form_control = form_password(array(
					'id'	=> $setting->slug,
					'name'	=> $setting->slug,
					'value'	=> 'XXXXXXXXXXXX',
					'class'	=> 'text width-20',
					'autocomplete' => 'off',
				));
				break;

			case 'select':
				$form_control = form_dropdown($setting->slug, self::_format_options($setting->options), $setting->value, 'class="width-20"');
				break;

			case 'select-multiple':
				$options = self::_format_options($setting->options);
				$size = sizeof($options) > 10 ? ' size="10"' : '';
				$form_control = form_multiselect($setting->slug . '[]', $options, explode(',', $setting->value), 'class="width-20"' . $size);
				break;

			case 'checkbox':

				$form_control = '';
				$stored_values = is_string($setting->value) ? explode(',', $setting->value) : $setting->value;

				foreach (self::_format_options($setting->options) as $value => $label)
				{
					if (is_array($stored_values))
					{
						$checked = in_array($value, $stored_values);
					}
					else
					{
						$checked = false;
					}

					$form_control .= '<label>';
					$form_control .= '' . form_checkbox(array(
						'id'		=> $setting->slug . '_' . $value,
						'name'		=> $setting->slug . '[]',
						'checked'	=> $checked,
						'value'		=> $value
					));
					$form_control .= ' ' . $label . '</label>&nbsp;&nbsp;';
				}
				break;

			case 'radio':

				$form_control = '';
				foreach (self::_format_options($setting->options) as $value => $label)
				{
					$form_control .= '<label class="inline">' . form_radio(array(
						'id'		=> $setting->slug,
						'name'		=> $setting->slug,
						'checked'	=> $setting->value == $value,
						'value'		=> $value
					)) . ' ' . $label . '</label> ';
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
	private static function _format_options($options = array())
	{
		$select_array = array();

		foreach ($options as $option)
		{
			list($value, $name) = explode('=', $option);

			if (ci()->lang->line('settings:form_option_' . $name) !== false)
			{
				$name = ci()->lang->line('settings:form_option_' . $name);
			}

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
	private static function _check_format($setting)
	{
		if ( ! isset($setting))
		{
			return false;
		}
		foreach ($setting as $key => $value)
		{
			if ( ! in_array($key, self::$columns))
			{
				return false;
			}
		}

		return true;
	}

}

/* End of file Settings.php */
