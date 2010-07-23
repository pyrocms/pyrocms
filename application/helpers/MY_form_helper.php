<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Form Open
 *
 * Create the form open tag as well as any hidden inputs. Also implements CSRF.
 *
 * @param	string	The action attribute
 * @param	string	A string of extra attributes
 * @param	array	An array of hidden elements
 * @param	bool	If CSRF should be enabled
 * @return	string	The form element and any hidden inputs
 */
function form_open($action = '', $attributes = '', $hidden = array(), $csrf_enabled = TRUE)
{
	$_ci = & get_instance();
	$_ci->load->library('form_validation');

	if ($attributes == '')
	{
		$attributes = 'method="post"';
	}

	$action = ( strpos($action, '://') === FALSE) ? $_ci->config->site_url($action) : $action;

	$form = '<form action="' . $action . '"';
	$form .= _attributes_to_string($attributes, TRUE);
	$form .= '>';

	if (is_array($hidden) && count($hidden) > 0)
	{
		$form .= form_hidden($hidden);
	}

	if ($csrf_enabled)
	{
		$form .= form_token();
	}
	return $form;
}

/**
 * Form Token
 *
 * Generates and returns the hidden CSRF inputs
 *
 * @access    public
 * @return    string  HTML hidden input elements
 */
function form_token()
{
    $CI =& get_instance();

	// We load this here so that it is not loaded unless needed.
	$CI->load->library('csrf');

	// Get the token from the csrf class
    $tokens = $CI->csrf->get_token();
    if ( ! $tokens)
	{
        // Token is bad. Create a new one
        $tokens = $CI->csrf->create_token();
    }

    // Return token hidden form field strings
    $form_id_input = form_input(array('name'=>'form_id', 'id'=>'form_id', 'value'=>$tokens['form_id'], 'type'=>'hidden'));
    $token_input  = form_input(array('name'=>'token', 'id'=>'token', 'value'=>$tokens['token'], 'type'=>'hidden'));

    return PHP_EOL.$form_id_input.PHP_EOL.$token_input.PHP_EOL;
}
