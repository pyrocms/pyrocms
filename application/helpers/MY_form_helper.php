<?php

/*
 * Helper (helpers/MY_form_helper.php)
 */

function form_open($action = '', $attributes = '', $hidden = array())
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

	if ($_ci->form_validation->has_nonce())
	{
		$value = set_value('nonce');
		if ($value == '')
		{
			$value = $_ci->form_validation->create_nonce();
		}

		$hidden['nonce'] = set_value('nonce', $value);
	}

	if (is_array($hidden) && count($hidden) > 0)
	{
		$form .= form_hidden($hidden);
	}

	return $form;
}