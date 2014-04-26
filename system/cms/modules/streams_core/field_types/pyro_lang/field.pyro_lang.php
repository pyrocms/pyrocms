<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroCMS Language Field Type
 *
 * Shows a drop down of languages to choose from. You
 * can filter them by available languages for the
 * current thtme.
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_pyro_lang
{
	public $field_type_slug			= 'pyro_lang';
	
	public $db_col_type				= 'varchar';

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
	public function form_output($data)
	{
	    $languages = array();

	    if ($data['custom']['filter_theme'] = 'yes')
	    {
	  		// get the languages offered on the front-end
		    $site_public_lang = explode(',', Settings::get('site_public_lang'));
		
		    foreach ($this->CI->config->item('supported_languages') as $lang_code => $lang)
		    {
		       // if the supported language is offered on the front-end
		       if (in_array($lang_code, $site_public_lang))
		       {
	          		// add it to the dropdown list
	        	   $languages[$lang_code] = $lang['name'];
		       }
		    }
	    }
	    else
	    {
	    	foreach ($this->CI->config->item('supported_languages') as $lang_code => $lang)
			{
				// add it to the dropdown list
				$languages[$lang_code] = $lang['name'];
			}
		}

		return form_dropdown($data['form_slug'], $languages, $data['value']);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Should we filter by the current theme
	 * and what languages they support?
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function param_filter_theme($value = null)
	{
		if ($value == 'no')
		{
			$no_select 		= true;
			$yes_select 	= false;
		}
		else
		{
			$no_select 		= false;
			$yes_select 	= true;
		}
	
		$form  = '<ul><li><label>'.form_radio('filter_theme', 'yes', $yes_select).' Yes</label></li>';
		
		$form .= '<li><label>'.form_radio('filter_theme', 'no', $no_select).' No</label></li>';
		
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
	public function pre_output($input)
	{
		$langs = $this->CI->config->item('supported_languages');

		if (isset($langs[$input]))
		{
			return $langs[$input]['name'];
		}
	}

}