<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Field\AbstractField;

/**
 * PyroCMS Language Field Type
 *
 * Shows a drop down of languages to choose from. You
 * can filter them by available languages for the
 * current thtme.
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		PyroCMS
 * @copyright	Copyright (c) 2011 - 2012, PyroCMS
 */
class Field_pyro_lang extends AbstractField
{
	public $field_type_slug			= 'pyro_lang';

	public $db_col_type				= 'string';

	public $version					= '1.0.0';

	public $author					= array('name' => 'PyroCMS', 'url' => 'http://www.pyrocms.com');

	public $custom_parameters		= array('filter_theme');

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output()
	{
	    $languages = array();

	    if ($this->field->field_data['filter_theme'] == 'yes') {
	  		// get the languages offered on the front-end
		    $site_public_lang = explode(',', Settings::get('site_public_lang'));

		    foreach (ci()->config->item('supported_languages') as $lang_code => $lang)
		    {
		       // if the supported language is offered on the front-end
		       if (in_array($lang_code, $site_public_lang)) {
	          		// add it to the dropdown list
	        	   $languages[$lang_code] = $lang['name'];
		       }
		    }
	    } else {
	    	foreach (ci()->config->item('supported_languages') as $lang_code => $lang)
	    	{
				// add it to the dropdown list
				$languages[$lang_code] = $lang['name'];
			}
		}

		return form_dropdown($this->field->field_slug, $languages, $this->value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Should we filter by the current theme
	 * and what languages they support?
	 *
	 * @param	string
	 * @return	string
	 */
	public function param_filter_theme($value = null)
	{
		if ($value == 'no') {
			$no_select 		= true;
			$yes_select 	= false;
		} else {
			$no_select 		= false;
			$yes_select 	= true;
		}

		$form  = '<ul><li><label>'.form_radio('filter_theme', 'yes', $yes_select).' Yes</label></li>';

		$form .= '<li><label>'.form_radio('filter_theme', 'no', $no_select).' No</label></li></ul>';

		return $form;
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre-Ouput
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function pre_output()
	{
		$langs = ci()->config->item('supported_languages');

		if ( ! empty($langs) and isset($langs[$this->value])) {
			return $langs[$this->value]['name'];
		}
	}

}
