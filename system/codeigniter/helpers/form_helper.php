<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 */

/**
 * CodeIgniter Form Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/form_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('form_open'))
{
	/**
	 * Form Declaration
	 *
	 * Creates the opening portion of the form.
	 *
	 * @param	string	the URI segments of the form destination
	 * @param	array	a key/value pair of attributes
	 * @param	array	a key/value pair hidden data
	 * @return	string
	 */
	function form_open($action = '', $attributes = '', $hidden = array())
	{
		$CI =& get_instance();

		if ($attributes === '')
		{
			$attributes = 'method="post"';
		}

		// If an action is not a full URL then turn it into one
		if ($action && strpos($action, '://') === FALSE)
		{
			$action = $CI->config->site_url($action);
		}
		elseif ( ! $action)
		{
			// If no action is provided then set to the current url
			$action = $CI->config->site_url($CI->uri->uri_string());
		}

		$form = '<form action="'.$action.'"'._attributes_to_string($attributes, TRUE).">\n";

		// Add CSRF field if enabled, but leave it out for GET requests and requests to external websites
		if ($CI->config->item('csrf_protection') === TRUE && ! (strpos($action, $CI->config->base_url()) === FALSE OR strpos($form, 'method="get"')))
		{
			$hidden[$CI->security->get_csrf_token_name()] = $CI->security->get_csrf_hash();
		}

		if (is_array($hidden) && count($hidden) > 0)
		{
			$form .= '<div style="display:none;">'.form_hidden($hidden).'</div>';
		}

		return $form;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_open_multipart'))
{
	/**
	 * Form Declaration - Multipart type
	 *
	 * Creates the opening portion of the form, but with "multipart/form-data".
	 *
	 * @param	string	the URI segments of the form destination
	 * @param	array	a key/value pair of attributes
	 * @param	array	a key/value pair hidden data
	 * @return	string
	 */
	function form_open_multipart($action = '', $attributes = array(), $hidden = array())
	{
		if (is_string($attributes))
		{
			$attributes .= ' enctype="multipart/form-data"';
		}
		else
		{
			$attributes['enctype'] = 'multipart/form-data';
		}

		return form_open($action, $attributes, $hidden);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_hidden'))
{
	/**
	 * Hidden Input Field
	 *
	 * Generates hidden fields. You can pass a simple key/value string or
	 * an associative array with multiple values.
	 *
	 * @param	mixed
	 * @param	string
	 * @param	bool
	 * @return	string
	 */
	function form_hidden($name, $value = '', $recursing = FALSE)
	{
		static $form;

		if ($recursing === FALSE)
		{
			$form = "\n";
		}

		if (is_array($name))
		{
			foreach ($name as $key => $val)
			{
				form_hidden($key, $val, TRUE);
			}
			return $form;
		}

		if ( ! is_array($value))
		{
			$form .= '<input type="hidden" name="'.$name.'" value="'.form_prep($value, $name)."\" />\n";
		}
		else
		{
			foreach ($value as $k => $v)
			{
				$k = is_int($k) ? '' : $k;
				form_hidden($name.'['.$k.']', $v, TRUE);
			}
		}

		return $form;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_input'))
{
	/**
	 * Text Input Field
	 *
	 * @param	mixed
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function form_input($data = '', $value = '', $extra = '')
	{
		$defaults = array('type' => 'text', 'name' => ( ! is_array($data) ? $data : ''), 'value' => $value);

		return '<input '._parse_form_attributes($data, $defaults).$extra." />\n";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_password'))
{
	/**
	 * Password Field
	 *
	 * Identical to the input function but adds the "password" type
	 *
	 * @param	mixed
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function form_password($data = '', $value = '', $extra = '')
	{
		if ( ! is_array($data))
		{
			$data = array('name' => $data);
		}

		$data['type'] = 'password';
		return form_input($data, $value, $extra);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_upload'))
{
	/**
	 * Upload Field
	 *
	 * Identical to the input function but adds the "file" type
	 *
	 * @param	mixed
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function form_upload($data = '', $value = '', $extra = '')
	{
		if ( ! is_array($data))
		{
			$data = array('name' => $data);
		}

		$data['type'] = 'file';
		return form_input($data, $value, $extra);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_textarea'))
{
	/**
	 * Textarea field
	 *
	 * @param	mixed
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function form_textarea($data = '', $value = '', $extra = '')
	{
		$defaults = array('name' => ( ! is_array($data) ? $data : ''), 'cols' => '40', 'rows' => '10');

		if ( ! is_array($data) OR ! isset($data['value']))
		{
			$val = $value;
		}
		else
		{
			$val = $data['value'];
			unset($data['value']); // textareas don't use the value attribute
		}

		$name = is_array($data) ? $data['name'] : $data;
		return '<textarea '._parse_form_attributes($data, $defaults).$extra.'>'.form_prep($val, $name)."</textarea>\n";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_multiselect'))
{
	/**
	 * Multi-select menu
	 *
	 * @param	string
	 * @param	array
	 * @param	mixed
	 * @param	string
	 * @return	string
	 */
	function form_multiselect($name = '', $options = array(), $selected = array(), $extra = '')
	{
		if ( ! strpos($extra, 'multiple'))
		{
			$extra .= ' multiple="multiple"';
		}

		return form_dropdown($name, $options, $selected, $extra);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('form_dropdown'))
{
	/**
	 * Drop-down Menu
	 *
	 * @param	string
	 * @param	array
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function form_dropdown($name = '', $options = array(), $selected = array(), $extra = '')
	{
		// If name is really an array then we'll call the function again using the array
		if (is_array($name) && isset($name['name']))
		{
			isset($name['options']) OR $name['options'] = array();
			isset($name['selected']) OR $name['selected'] = array();
			isset($name['extra']) OR $name['extra'] = array();

			return form_dropdown($name['name'], $name['options'], $name['selected'], $name['extra']);
		}

		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0 && isset($_POST[$name]))
		{
			$selected = array($_POST[$name]);
		}

		if ($extra != '')
		{
			$extra = ' '.$extra;
		}

		$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";

		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val))
			{
				if (empty($val))
				{
					continue;
				}

				$form .= '<optgroup label="'.$key."\">\n";

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = in_array($optgroup_key, $selected) ? ' selected="selected"' : '';
					$form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$form .= "</optgroup>\n";
			}
			else
			{
				$form .= '<option value="'.$key.'"'.(in_array($key, $selected) ? ' selected="selected"' : '').'>'.(string) $val."</option>\n";
			}
		}

		return $form."</select>\n";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_checkbox'))
{
	/**
	 * Checkbox Field
	 *
	 * @param	mixed
	 * @param	string
	 * @param	bool
	 * @param	string
	 * @return	string
	 */
	function form_checkbox($data = '', $value = '', $checked = FALSE, $extra = '')
	{
		$defaults = array('type' => 'checkbox', 'name' => ( ! is_array($data) ? $data : ''), 'value' => $value);

		if (is_array($data) && array_key_exists('checked', $data))
		{
			$checked = $data['checked'];

			if ($checked == FALSE)
			{
				unset($data['checked']);
			}
			else
			{
				$data['checked'] = 'checked';
			}
		}

		if ($checked == TRUE)
		{
			$defaults['checked'] = 'checked';
		}
		else
		{
			unset($defaults['checked']);
		}

		return '<input '._parse_form_attributes($data, $defaults).$extra." />\n";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_radio'))
{
	/**
	 * Radio Button
	 *
	 * @param	mixed
	 * @param	string
	 * @param	bool
	 * @param	string
	 * @return	string
	 */
	function form_radio($data = '', $value = '', $checked = FALSE, $extra = '')
	{
		if ( ! is_array($data))
		{
			$data = array('name' => $data);
		}

		$data['type'] = 'radio';
		return form_checkbox($data, $value, $checked, $extra);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_submit'))
{
	/**
	 * Submit Button
	 *
	 * @param	mixed
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function form_submit($data = '', $value = '', $extra = '')
	{
		$defaults = array('type' => 'submit', 'name' => ( ! is_array($data) ? $data : ''), 'value' => $value);
		return '<input '._parse_form_attributes($data, $defaults).$extra." />\n";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_reset'))
{
	/**
	 * Reset Button
	 *
	 * @param	mixed
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function form_reset($data = '', $value = '', $extra = '')
	{
		$defaults = array('type' => 'reset', 'name' => ( ! is_array($data) ? $data : ''), 'value' => $value);
		return '<input '._parse_form_attributes($data, $defaults).$extra." />\n";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_button'))
{
	/**
	 * Form Button
	 *
	 * @param	mixed
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function form_button($data = '', $content = '', $extra = '')
	{
		$defaults = array('name' => ( ! is_array($data) ? $data : ''), 'type' => 'button');
		if (is_array($data) && isset($data['content']))
		{
			$content = $data['content'];
			unset($data['content']); // content is not an attribute
		}

		return '<button '._parse_form_attributes($data, $defaults).$extra.'>'.$content."</button>\n";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_label'))
{
	/**
	 * Form Label Tag
	 *
	 * @param	string	The text to appear onscreen
	 * @param	string	The id the label applies to
	 * @param	string	Additional attributes
	 * @return	string
	 */
	function form_label($label_text = '', $id = '', $attributes = array())
	{

		$label = '<label';

		if ($id !== '')
		{
			$label .= ' for="'.$id.'"';
		}

		if (is_array($attributes) && count($attributes) > 0)
		{
			foreach ($attributes as $key => $val)
			{
				$label .= ' '.$key.'="'.$val.'"';
			}
		}

		return $label.'>'.$label_text.'</label>';
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_fieldset'))
{
	/**
	 * Fieldset Tag
	 *
	 * Used to produce <fieldset><legend>text</legend>.  To close fieldset
	 * use form_fieldset_close()
	 *
	 * @param	string	The legend text
	 * @param	string	Additional attributes
	 * @return	string
	 */
	function form_fieldset($legend_text = '', $attributes = array())
	{
		$fieldset = '<fieldset'._attributes_to_string($attributes, FALSE).">\n";
		if ($legend_text !== '')
		{
			return $fieldset.'<legend>'.$legend_text."</legend>\n";
		}

		return $fieldset;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_fieldset_close'))
{
	/**
	 * Fieldset Close Tag
	 *
	 * @param	string
	 * @return	string
	 */
	function form_fieldset_close($extra = '')
	{
		return '</fieldset>'.$extra;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_close'))
{
	/**
	 * Form Close Tag
	 *
	 * @param	string
	 * @return	string
	 */
	function form_close($extra = '')
	{
		return '</form>'.$extra;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_prep'))
{
	/**
	 * Form Prep
	 *
	 * Formats text so that it can be safely placed in a form field in the event it has HTML tags.
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function form_prep($str = '', $field_name = '')
	{
		static $prepped_fields = array();

		// if the field name is an array we do this recursively
		if (is_array($str))
		{
			foreach ($str as $key => $val)
			{
				$str[$key] = form_prep($val);
			}

			return $str;
		}

		if ($str === '')
		{
			return '';
		}

		// we've already prepped a field with this name
		// @todo need to figure out a way to namespace this so
		// that we know the *exact* field and not just one with
		// the same name
		if (isset($prepped_fields[$field_name]))
		{
			return $str;
		}

		if ($field_name !== '')
		{
			$prepped_fields[$field_name] = $field_name;
		}

		return html_escape($str);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_value'))
{
	/**
	 * Form Value
	 *
	 * Grabs a value from the POST array for the specified field so you can
	 * re-populate an input field or textarea. If Form Validation
	 * is active it retrieves the info from the validation class
	 *
	 * @param	string
	 * @param	string
	 * @return	mixed
	 */
	function set_value($field = '', $default = '')
	{
		if (FALSE === ($OBJ =& _get_validation_object()))
		{
			if ( ! isset($_POST[$field]))
			{
				return $default;
			}

			return form_prep($_POST[$field], $field);
		}

		return form_prep($OBJ->set_value($field, $default), $field);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_select'))
{
	/**
	 * Set Select
	 *
	 * Let's you set the selected value of a <select> menu via data in the POST array.
	 * If Form Validation is active it retrieves the info from the validation class
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	string
	 */
	function set_select($field = '', $value = '', $default = FALSE)
	{
		$OBJ =& _get_validation_object();

		if ($OBJ === FALSE)
		{
			if ( ! isset($_POST[$field]))
			{
				if (count($_POST) === 0 && $default === TRUE)
				{
					return ' selected="selected"';
				}
				return '';
			}

			$field = $_POST[$field];

			if (is_array($field))
			{
				if ( ! in_array($value, $field))
				{
					return '';
				}
			}
			elseif (($field == '' OR $value == '') OR $field !== $value)
			{
				return '';
			}

			return ' selected="selected"';
		}

		return $OBJ->set_select($field, $value, $default);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_checkbox'))
{
	/**
	 * Set Checkbox
	 *
	 * Let's you set the selected value of a checkbox via the value in the POST array.
	 * If Form Validation is active it retrieves the info from the validation class
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	string
	 */
	function set_checkbox($field = '', $value = '', $default = FALSE)
	{
		$OBJ =& _get_validation_object();

		if ($OBJ === FALSE)
		{
			if ( ! isset($_POST[$field]))
			{
				if (count($_POST) === 0 && $default === TRUE)
				{
					return ' checked="checked"';
				}
				return '';
			}

			$field = $_POST[$field];

			if (is_array($field))
			{
				if ( ! in_array($value, $field))
				{
					return '';
				}
			}
			elseif (($field == '' OR $value == '') OR $field !== $value)
			{
				return '';
			}

			return ' checked="checked"';
		}

		return $OBJ->set_checkbox($field, $value, $default);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_radio'))
{
	/**
	 * Set Radio
	 *
	 * Let's you set the selected value of a radio field via info in the POST array.
	 * If Form Validation is active it retrieves the info from the validation class
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	string
	 */
	function set_radio($field = '', $value = '', $default = FALSE)
	{
		$OBJ =& _get_validation_object();

		if ($OBJ === FALSE)
		{
			if ( ! isset($_POST[$field]))
			{
				if (count($_POST) === 0 && $default === TRUE)
				{
					return ' checked="checked"';
				}
				return '';
			}

			$field = $_POST[$field];

			if (is_array($field))
			{
				if ( ! in_array($value, $field))
				{
					return '';
				}
			}
			else
			{
				if (($field == '' OR $value == '') OR $field !== $value)
				{
					return '';
				}
			}

			return ' checked="checked"';
		}

		return $OBJ->set_radio($field, $value, $default);
	}
}

// ------------------------------------------------------------------------


if ( ! function_exists('form_error'))
{
	/**
	 * Form Error
	 *
	 * Returns the error for a specific form field. This is a helper for the
	 * form validation class.
	 *
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function form_error($field = '', $prefix = '', $suffix = '')
	{
		if (FALSE === ($OBJ =& _get_validation_object()))
		{
			return '';
		}

		return $OBJ->error($field, $prefix, $suffix);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('validation_errors'))
{
	/**
	 * Validation Error String
	 *
	 * Returns all the errors associated with a form submission. This is a helper
	 * function for the form validation class.
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function validation_errors($prefix = '', $suffix = '')
	{
		if (FALSE === ($OBJ =& _get_validation_object()))
		{
			return '';
		}

		return $OBJ->error_string($prefix, $suffix);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_parse_form_attributes'))
{
	/**
	 * Parse the form attributes
	 *
	 * Helper function used by some of the form helpers
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	function _parse_form_attributes($attributes, $default)
	{
		if (is_array($attributes))
		{
			foreach ($default as $key => $val)
			{
				if (isset($attributes[$key]))
				{
					$default[$key] = $attributes[$key];
					unset($attributes[$key]);
				}
			}

			if (count($attributes) > 0)
			{
				$default = array_merge($default, $attributes);
			}
		}

		$att = '';

		foreach ($default as $key => $val)
		{
			if ($key === 'value')
			{
				$val = form_prep($val, $default['name']);
			}

			$att .= $key.'="'.$val.'" ';
		}

		return $att;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_attributes_to_string'))
{
	/**
	 * Attributes To String
	 *
	 * Helper function used by some of the form helpers
	 *
	 * @param	mixed
	 * @param	bool
	 * @return	string
	 */
	function _attributes_to_string($attributes, $formtag = FALSE)
	{
		if (is_string($attributes) && strlen($attributes) > 0)
		{
			if ($formtag === TRUE && strpos($attributes, 'method=') === FALSE)
			{
				$attributes .= ' method="post"';
			}

			if ($formtag === TRUE && strpos($attributes, 'accept-charset=') === FALSE)
			{
				$attributes .= ' accept-charset="'.strtolower(config_item('charset')).'"';
			}

			return ' '.$attributes;
		}

		if (is_object($attributes) && count($attributes) > 0)
		{
			$attributes = (array) $attributes;
		}

		if (is_array($attributes) && ($formtag === TRUE OR count($attributes) > 0))
		{
			$atts = '';

			if ( ! isset($attributes['method']) && $formtag === TRUE)
			{
				$atts .= ' method="post"';
			}

			if ( ! isset($attributes['accept-charset']) && $formtag === TRUE)
			{
				$atts .= ' accept-charset="'.strtolower(config_item('charset')).'"';
			}

			foreach ($attributes as $key => $val)
			{
				$atts .= ' '.$key.'="'.$val.'"';
			}

			return $atts;
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_get_validation_object'))
{
	/**
	 * Validation Object
	 *
	 * Determines what the form validation class was instantiated as, fetches
	 * the object and returns it.
	 *
	 * @return	mixed
	 */
	function &_get_validation_object()
	{
		$CI =& get_instance();

		// We set this as a variable since we're returning by reference.
		$return = FALSE;

		if (FALSE !== ($object = $CI->load->is_loaded('form_validation')))
		{
			if ( ! isset($CI->$object) OR ! is_object($CI->$object))
			{
				return $return;
			}

			return $CI->$object;
		}

		return $return;
	}
}

/* End of file form_helper.php */
/* Location: ./system/helpers/form_helper.php */