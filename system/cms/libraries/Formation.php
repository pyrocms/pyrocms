<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Formation
 *
 * A CodeIgniter library that creates forms via a config file.  It
 * also contains functions to allow for creation of forms on the fly.
 *
 * @package		Formation
 * @author		Dan Horrigan <http://dhorrigan.com>
 * @license		Apache License v2.0
 * @copyright	2010 Dan Horrigan
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Core Formation Class
 *
 * @subpackage	Formation
 */
class Formation
{
	/**
	 * Used to store the global CI instance
	 */
	private static $_ci;

	/**
	 * Used to store the configuration
	 */
	private static $_config = array();

	/**
	 * Used to store the forms
	 */
	private static $_forms = array();

	/**
	 * Used to store the form_validation info
	 */
	private static $_validation = array();

	/**
	 * Valid types for input tags (including HTML5)
	 */
	private static $_valid_inputs = array(
		'button','checkbox','color','date','datetime',
		'datetime-local','email','file','hidden','image',
		'month','number','password','radio','range',
		'reset','search','submit','tel','text','time',
		'url','week'
	);

	// --------------------------------------------------------------------

	/**
	 * Construct
	 *
	 * Imports the global config and custom config (if given).  We have this
	 * to support CI's loader which calls the construct.
	 *
	 * @access	public
	 * @param	array	$custom_config
	 */
	public function __construct($custom_config = array())
	{
		self::init($custom_config);
	}

	// --------------------------------------------------------------------

	/**
	 * Init
	 *
	 * Imports the global config and custom config (if given) and initializes
	 * the global CI instance.
	 *
	 * @access	public
	 * @param	array	$custom_config
	 */
	public static function init($custom_config = array())
	{
		self::$_ci =& get_instance();

		// Include the formation config and ensure it is formatted
		if (file_exists(APPPATH . 'config/formation.php'))
		{
			include(APPPATH . 'config/formation.php');
			if ( ! isset($formation) OR !is_array($formation))
			{
				show_error('Formation config is not formatted correctly.');
			}
			self::add_config($formation);
		}
		else
		{
			show_error('Formation config file is missing.');
		}

		// Merge the custom config into the global config
		if ( ! empty($custom_config))
		{
			self::add_config($custom_config);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Add Config
	 *
	 * Merges a config array into the current config
	 *
	 * @access	public
	 * @param	array	$config
	 * @return	void
	 */
	public static function add_config($config)
	{
		self::$_config = array_merge_recursive(self::$_config, $config);

		// Add the forms from the config array
		if (isset(self::$_config['forms']) AND is_array(self::$_config['forms']))
		{
			foreach (self::$_config['forms'] as $form_name => $attributes)
			{
				$fields = $attributes['fields'];
				unset($attributes['fields']);

				self::add_form($form_name, $attributes, $fields);
			}
			unset(self::$_config['forms']);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Add Form
	 *
	 * Adds a form to the config
	 *
	 * @access	public
	 * @param	string	$form_name
	 * @param	array	$attributes
	 * @param	array	$fields
	 * @return	void
	 */
	public static function add_form($form_name, $attributes = array(), $fields = array())
	{
		if (self::form_exists($form_name))
		{
			show_error(sprintf('Form "%s" already exists.  If you were trying to modify the form, please use Formation::modify_form("%s", $attributes).', $form_name, $form_name));
		}

		self::$_forms[$form_name]['attributes'] = $attributes;
		self::add_fields($form_name, $fields);

		self::parse_validation();
	}

	// --------------------------------------------------------------------

	/**
	 * Get Form Array
	 *
	 * Returns the form with all fields and options as an array
	 *
	 * @access	private
	 * @param	string	$form_name
	 * @return	array
	 */
	private static function get_form_array($form_name)
	{
		if ( ! self::form_exists($form_name))
		{
			show_error(sprintf('Form "%s" does not exist.', $form_name));
		}

		return self::$_forms[$form_name];
	}

	// --------------------------------------------------------------------

	/**
	 * Add Field
	 *
	 * Adds a field to a given form
	 *
	 * @access	public
	 * @param	string	$form_name
	 * @param	string	$field_name
	 * @param	array	$attributes
	 * @return	void
	 */
	public static function add_field($form_name, $field_name, $attributes)
	{
		if ( ! self::form_exists($form_name))
		{
			show_error(sprintf('Form "%s" does not exist.  You must first add the form using Formation::add_form("%s", $attributes).', $form_name, $form_name));
		}
		if (self::field_exists($form_name, $field_name))
		{
			show_error(sprintf('Field "%s" already exists in form "%s".  If you were trying to modify the field, please use Formation::modify_field($form_name, $field_name, $attributes).', $field_name, $form_name));
		}

		self::$_forms[$form_name]['fields'][$field_name] = $attributes;

		if ($attributes['type'] == 'file')
		{
			self::$_forms[$form_name]['attributes']['enctype'] = 'multipart/form-data';
		}

		self::parse_validation();
	}

	// --------------------------------------------------------------------

	/**
	 * Add Fields
	 *
	 * Allows you to add multiple fields at once.
	 *
	 * @access	public
	 * @param	string	$form_name
	 * @param	array	$fields
	 * @return	void
	 */
	public static function add_fields($form_name, $fields)
	{
		foreach ($fields as $field_name => $attributes)
		{
			self::add_field($form_name, $field_name, $attributes);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Modify Field
	 *
	 * Allows you to modify a field.
	 *
	 * @access	public
	 * @param	string	$form_name
	 * @param	string	$field_name
	 * @param	array	$attributes
	 * @return	void
	 */
	public static function modify_field($form_name, $field_name, $attributes)
	{
		if ( ! self::field_exists($form_name, $field_name))
		{
			show_error(sprintf('Field "%s" does not exist in form "%s".', $field_name, $form_name));
		}
		self::$_forms[$form_name]['fields'][$field_name] = array_merge_recursive(self::$_forms[$form_name][$field_name], $attributes);

		self::parse_validation();
	}

	// --------------------------------------------------------------------

	/**
	 * Modify Fields
	 *
	 * Allows you to modify multiple fields at once.
	 *
	 * @access	public
	 * @param	string	$form_name
	 * @param	array	$fields
	 * @return	void
	 */
	public static function modify_fields($form_name, $fields)
	{
		foreach ($fields as $field_name => $attributes)
		{
			self::modfy_field($form_name, $field_name, $attributes);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Form Exists
	 *
	 * Checks if a form exists
	 *
	 * @access	public
	 * @param	string	$form_name
	 * @return	bool
	 */
	public static function form_exists($form_name)
	{
		return isset(self::$_forms[$form_name]);
	}

	// --------------------------------------------------------------------

	/**
	 * Field Exists
	 *
	 * Checks if a field exists.
	 *
	 * @param	string	$form_name
	 * @param	string	$field_name
	 * @return	bool
	 */
	public static function field_exists($form_name, $field_name)
	{
		return isset(self::$_forms[$form_name]['fields'][$field_name]);
	}

	// --------------------------------------------------------------------

	/**
	 * Form
	 *
	 * Builds a form and returns well-formatted, valid XHTML for output.
	 *
	 * @access	public
	 * @param	string	$form_name
	 * @return	string
	 */
	public static function form($form_name)
	{
		$form = self::get_form_array($form_name);

		$return = self::open($form_name) . "\n";
		$return .= self::fields($form_name);
		$return .= self::close() . "\n";

		return $return;
	}

	// --------------------------------------------------------------------

	/**
	 * Field
	 *
	 * Builds a field and returns well-formatted, valid XHTML for output.
	 *
	 * @access	public
	 * @param	string	$name
	 * @param	string	$properties
	 * @param	string	$form_name
	 * @return	string
	 */
	public static function field($name, $properties = array(), $form_name = NULL)
	{
		$return = '';

		if ( ! isset($properties['name']))
		{
			$properties['name'] = $name;
		}
		$required = FALSE;
		if (isset(self::$_validation[$form_name]))
		{
			foreach (self::$_validation[$form_name] as $rule)
			{
				if ($rule['field'] == $properties['name'] AND $rule['rules'] AND strpos('required', $rule['rules']) !== FALSE)
				{
					$required = TRUE;
				}
			}
		}

		$return .= self::_open_field($properties['type'], $required);
		
		switch($properties['type'])
		{
			case 'hidden':
				$return .= "\t\t" . self::input($properties) . "\n";
				break;
			case 'radio': case 'checkbox':
				$return .= "\t\t\t" . sprintf(self::$_config['label_wrapper_open'], $name) . $properties['label'] . self::$_config['label_wrapper_close'] . "\n";
				if (isset($properties['items']))
				{
					$return .= "\t\t\t<span>\n";
					
					if ($properties['type'] == 'checkbox' && count($properties['items']) > 1)
					{
						// More than one item exists, this should probably be an array
						if (substr($properties['name'], -2) != '[]')
						{
							$properties['name'] .= '[]';
						}
					}

					foreach ($properties['items'] as $count => $element)
					{
						if ( ! isset($element['id']))
						{
							$element['id'] = str_replace('[]', '', $name) . '_' . $count;
						}
						
						$element['type'] = $properties['type'];
						$element['name'] = $properties['name'];
						$return .= "\t\t\t\t" . sprintf(self::$_config['label_wrapper_open'], $element['id']) . $element['label'] . self::$_config['label_wrapper_close'] . "\n";
						$return .= "\t\t\t\t" . self::input($element) . "\n";
					}
					$return .= "\t\t\t</span>\n";
				}
				else
				{
					$return .= "\t\t\t" . sprintf(self::$_config['label_wrapper_open'], $name) . $properties['label'] . self::$_config['label_wrapper_close'] . "\n";
					$return .= "\t\t\t" . self::input($properties) . "\n";
				}
				break;
			case 'select':
				$return .= "\t\t\t" . sprintf(self::$_config['label_wrapper_open'], $name) . $properties['label'] . self::$_config['label_wrapper_close'] . "\n";
				$return .= "\t\t\t" . self::select($properties, 3) . "\n";
				break;
			case 'textarea':
				$return .= "\t\t\t" . sprintf(self::$_config['label_wrapper_open'], $name) . $properties['label'] . self::$_config['label_wrapper_close'] . "\n";
				$return .= "\t\t\t" . self::textarea($properties) . "\n";
				break;
			default:
				$return .= "\t\t\t" . sprintf(self::$_config['label_wrapper_open'], $name) . $properties['label'] . self::$_config['label_wrapper_close'] . "\n";
				$return .= "\t\t\t" . self::input($properties) . "\n";
				break;
		}

		$return .= self::_close_field($properties['type'], $required);

		return $return;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Open Field
	 *
	 * Generates the fields opening tags.
	 *
	 * @access	private
	 * @param	string	$type
	 * @param	bool	$required
	 * @return	string
	 */
	private static function _open_field($type, $required = FALSE)
	{
		if($type == 'hidden')
		{
			return '';
		}

		$return = "\t\t" . self::$_config['input_wrapper_open'] . "\n";

		if ($required AND self::$_config['required_location'] == 'before')
		{
			$return .= "\t\t\t" . self::$_config['required_tag'] . "\n";
		}
		
		return $return;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Close Field
	 *
	 * Generates the fields closing tags.
	 *
	 * @access	private
	 * @param	string	$type
	 * @param	bool	$required
	 * @return	string
	 */
	private static function _close_field($type, $required = FALSE)
	{
		if($type == 'hidden')
		{
			return '';
		}
		
		$return = "";

		if ($required AND self::$_config['required_location'] == 'after')
		{
			$return .= "\t\t\t" . self::$_config['required_tag'] . "\n";
		}

		$return .= "\t\t" . self::$_config['input_wrapper_close'] . "\n";
		
		return $return;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Select
	 *
	 * Generates a <select> element based on the given parameters
	 *
	 * @access	public
	 * @param	array	$parameters
	 * @param	int		$indent_amount
	 * @return	string
	 */
	public static function select($parameters, $indent_amount = 0)
	{
		if ( ! isset($parameters['options']) OR !is_array($parameters['options']))
		{
			show_error(sprintf('Select element "%s" is either missing the "options" or "options" is not array.', $parameters['name']));
		}
		// Get the options then unset them from the array
		$options = $parameters['options'];
		unset($parameters['options']);

		// Get the selected options then unset it from the array
		$selected = $parameters['selected'];
		unset($parameters['selected']);

		$input = "<select " . self::attr_to_string($parameters) . ">\n";
		foreach ($options as $key => $val)
		{
			if (is_array($val))
			{
				$input .= str_repeat("\t", $indent_amount + 1) . '<optgroup label="' . $key . '">' . "\n";
				foreach ($val as $opt_key => $opt_val)
				{
					$extra = ($opt_key == $selected) ? ' selected="selected"' : '';
					$input .= str_repeat("\t", $indent_amount + 2);
					$input .= '<option value="' . $opt_key . '"' . $extra . '>' . self::prep_value($opt_val) . "</option>\n";
				}
				$input .= str_repeat("\t", $indent_amount + 1) . "</optgroup>\n";
			}
			else
			{
				$extra = ($key == $selected) ? ' selected="selected"' : '';
				$input .= str_repeat("\t", $indent_amount + 1);
				$input .= '<option value="' . $key . '"' . $extra . '>' . self::prep_value($val) . "</option>\n";
			}
		}
		$input .= str_repeat("\t", $indent_amount) . "</select>";

		return $input;
	}

	// --------------------------------------------------------------------

	/**
	 * Open
	 *
	 * Generates the opening <form> tag
	 *
	 * @access	public
	 * @param	string	$action
	 * @param	array	$options
	 * @return	string
	 */
	public static function open($form_name = NULL, $options = array())
	{
		// The form name does not exist, must be an action as its not set in options either
		if (self::form_exists($form_name))
		{
			$form = self::get_form_array($form_name);

			$options = array_merge($form['attributes'], $options);
		}

		// There is a form name, but no action is set
		elseif ( $form_name && ! isset($options['action']))
		{
			$options['action'] = $form_name;
		}

		// If there is still no action set, self-post
		if (empty($options['action']))
		{
			$options['action'] = self::$_ci->uri->uri_string();
		}

		// If not a full URL, create one with CI
		if ( ! strpos($options['action'], '://'))
		{
			$options['action'] = self::$_ci->config->site_url($options['action']);
		}

		// If method is empty, use POST
		isset($options['method']) OR $options['method'] = 'post';

		$form = '<form ' . self::attr_to_string($options) . '>';

		return $form;
	}

	// --------------------------------------------------------------------

	/**
	 * Fields
	 *
	 * Generates the list of fields without the form open and form close tags
	 *
	 * @access	public
	 * @param	string	$action
	 * @param	array	$options
	 * @return	string
	 */
	public static function fields($form_name)
	{
		$hidden = array();
		$form = self::get_form_array($form_name);

		$return = "\t" . self::$_config['form_wrapper_open'] . "\n";

		foreach ($form['fields'] as $name => $properties)
		{
			if($properties['type'] == 'hidden')
			{
				$hidden[$name] = $properties;
				continue;
			}
			$return .= self::field($name, $properties, $form_name);
		}

		$return .= "\t" . self::$_config['form_wrapper_close'] . "\n";
		
		foreach ($hidden as $name => $properties)
		{
			if ( ! isset($properties['name']))
			{
				$properties['name'] = $name;
			}
			$return .= "\t" . self::input($properties) . "\n";
		}
		
		return $return;
	}

	// --------------------------------------------------------------------

	/**
	 * Close
	 *
	 * Generates the closing </form> tag
	 *
	 * @access	public
	 * @return	string
	 */
	public static function close()
	{
		return '</form>';
	}

	// --------------------------------------------------------------------

	/**
	 * Label
	 *
	 * Generates a label based on given parameters
	 *
	 * @access	public
	 * @param	string	$value
	 * @param	string	$for
	 * @return	string
	 */
	public static function label($value, $for = NULL)
	{
		if ($for === NULL)
		{
			return '<label>' . $value . '</label>';
		}
		else
		{
			return '<label for="' . $for . '">' . $value . '</label>';
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Input
	 *
	 * Generates an <input> tag
	 *
	 * @access	public
	 * @param	array	$options
	 * @return	string
	 */
	public static function input($options)
	{
		if ( ! isset($options['type']))
		{
			show_error('You must specify a type for the input.');
		}
		elseif ( ! in_array($options['type'], self::$_valid_inputs))
		{
			show_error(sprintf('"%s" is not a valid input type.', $options['type']));
		}
		$input = '<input ' . self::attr_to_string($options) . ' />';

		return $input;
	}

	// --------------------------------------------------------------------

	/**
	 * Textarea
	 *
	 * Generates a <textarea> tag
	 *
	 * @access	public
	 * @param	array	$options
	 * @return	string
	 */
	public static function textarea($options)
	{
		$value = '';
		if (isset($options['value']))
		{
			$value = $options['value'];
			unset($options['value']);
		}
		$input = "<textarea " . self::attr_to_string($options) . '>';
		$input .= self::prep_value($value);
		$input .= '</textarea>';

		return $input;
	}


	// --------------------------------------------------------------------

	/**
	 * Attr to String
	 *
	 * Takes an array of attributes and turns it into a string for an input
	 *
	 * @access	private
	 * @param	array	$attr
	 * @return	string
	 */
	private function attr_to_string($attr)
	{
		$attr_str = '';

		if ( ! is_array($attr))
		{
			$attr = (array) $attr;
		}

		foreach ($attr as $property => $value)
		{
			if ($property == 'label')
			{
				continue;
			}
			if ($property == 'value')
			{
				$value = self::prep_value($value);
			}
			$attr_str .= $property . '="' . $value . '" ';
		}

		// We strip off the last space for return
		return substr($attr_str, 0, -1);
	}

	// --------------------------------------------------------------------

	/**
	 * Prep Value
	 *
	 * Prepares the value for display in the form
	 *
	 * @access	public
	 * @param	string	$value
	 * @return	string
	 */
	public static function prep_value($value)
	{
		$value = htmlspecialchars($value);
		$value = str_replace(array("'", '"'), array("&#39;", "&quot;"), $value);

		return $value;
	}

	// --------------------------------------------------------------------

	/**
	 * Parse Validation
	 *
	 * Adds the validation rules in each field to the $_validation array
	 * and removes it from the field attributes
	 *
	 * @access	private
	 * @return	void
	 */
	private static function parse_validation()
	{
		foreach (self::$_forms as $form_name => $form)
		{
			if ( ! isset($form['fields']))
			{
				continue;
			}

			$i = 0;
			foreach ($form['fields'] as $name => $attr)
			{
				if (isset($attr['validation']))
				{
					self::$_validation[$form_name][$i]['field'] = $name;
					self::$_validation[$form_name][$i]['label'] = $attr['label'];
					self::$_validation[$form_name][$i]['rules'] = $attr['validation'];

					unset(self::$_forms[$form_name]['fields'][$name]['validation']);
				}

				++$i;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Validate
	 *
	 * Runs form validation on the given form
	 *
	 * @access	public
	 * @param	string	$form_name
	 * @return	bool
	 */
	public static function validate($form_name)
	{
		if ( ! isset(self::$_validation[$form_name]))
		{
			return TRUE;
		}
		self::load_validation();

		self::$_ci->form_validation->set_rules(self::$_validation[$form_name]);

		return self::$_ci->form_validation->run();
	}

	// --------------------------------------------------------------------

	/**
	 * Error
	 *
	 * Returns a single form validation error
	 *
	 * @access	public
	 * @param	string	$field_name
	 * @param	string	$prefix
	 * @param	string	$suffix
	 * @return	string
	 */
	public static function error($field_name, $prefix = '', $suffix = '')
	{
		self::load_validation();

		return self::$_ci->form_validation->error($field_name, $prefix, $suffix);
	}

	// --------------------------------------------------------------------

	/**
	 * All Errors
	 *
	 * Returns all of the form validation errors
	 *
	 * @access	public
	 * @param	string	$prefix
	 * @param	string	$suffix
	 * @return	string
	 */
	public static function all_errors($prefix = '', $suffix = '')
	{
		self::load_validation();

		return self::$_ci->form_validation->error_string($prefix, $suffix);
	}

	// --------------------------------------------------------------------

	/**
	 * Set Value
	 *
	 * Set's a fields value
	 *
	 * @access	public
	 * @param	string	$form_name
	 * @param	string	$field_name
	 * @param	mixed	$value
	 * @return	void
	 */
	public static function set_value($form_name, $field_name, $default = NULL)
	{
		self::load_validation();

		$post_name = str_replace('[]', '', $field_name);
		$value = isset($_POST[$post_name]) ? $_POST[$post_name] : self::prep_value($default);

		$field =& self::$_forms[$form_name]['fields'][$field_name];

		switch($field['type'])
		{
			case 'radio': case 'checkbox':
				if (isset($field['items']))
				{
					foreach ($field['items'] as &$element)
					{
						if (is_array($value))
						{
							if (in_array($element['value'], $value))
							{
								$element['checked'] = 'checked';
							}
							else
							{
								if (isset($element['checked']))
								{
									unset($element['checked']);
								}
							}
						}
						else
						{
							if ($element['value'] === $value)
							{
								$element['checked'] = 'checked';
							}
							else
							{
								if (isset($element['checked']))
								{
									unset($element['checked']);
								}
							}
						}
					}
				}
				else
				{
					$field['value'] = $value;
				}
				break;
			case 'select':
				$field['selected'] = $value;
				break;
			default:
				$field['value'] = self::prep_value($value);
				break;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Repopulate
	 *
	 * Repopulates the entire form with the submitted data.
	 *
	 * @access	public
	 * @param	string	$form_name
	 * @return	string
	 */
	public static function repopulate($form_name)
	{
		self::load_validation();

		foreach (self::$_forms[$form_name]['fields'] as $field_name => $attr)
		{
			self::set_value($form_name, $field_name, (isset($attr['value']) ? $attr['value'] : NULL));
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Load Validation
	 *
	 * Checks if the form_validation library is loaded.  If it is not it loads it.
	 *
	 * @access	private
	 * @return	void
	 */
	private static function load_validation()
	{
		if ( ! class_exists('CI_Form_validation'))
		{
			self::$_ci->load->library('form_validation');
		}
	}
}

/* End of file Formation.php */