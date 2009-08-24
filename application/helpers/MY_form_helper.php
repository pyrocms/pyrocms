<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Form Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/form_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Form Declaration
 *
 * Creates the opening portion of the form.
 *
 * @access	public
 * @param	string	the URI segments of the form destination
 * @param	array	a key/value pair of attributes
 * @param	array	a key/value pair hidden data
 * @return	string
 */	
if ( ! function_exists('form_open'))
{
	function form_open($action = '', $attributes = '', $hidden = array())
	{
		$CI =& get_instance();
		
		$charset = strtolower($CI->config->item('charset'));
		
		if ($attributes == '')
		{
			$attributes = 'method="post" accept-charset="'.$charset.'"';
		}
		
		else
		{
			if ( is_string($attributes) )
			{
				if(strpos('accept-charset=') === FALSE)
				{
					$attributes .= ' accept-charset="'.$charset.'"';
				}
			}
			
			elseif ( is_object($attributes) or is_array($attributes) )
			{
				$attributes = (array) $attributes;
				
				if(!in_array('accept-charset', $attributes))
				{
					$attributes['accept-charset'] = $charset;
				}
			}
		}
		
		$action = ( strpos($action, '://') === FALSE) ? $CI->config->site_url($action) : $action;

		$form = '<form action="'.$action.'"';
	
		$form .= _attributes_to_string($attributes, TRUE);
	
		$form .= '>';

		if (is_array($hidden) AND count($hidden) > 0)
		{
			$form .= form_hidden($hidden);
		}

		return $form;
	}
}

/* End of file form_helper.php */
/* Location: ./system/helpers/form_helper.php */