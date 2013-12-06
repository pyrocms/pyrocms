<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Input Plugin
 *
 * @package		PyroCMS
 * @author		AI Web Systems, Inc.
 * @copyright	Copyright (c) 2008 - 2011, AI Web Systems, Inc.
 *
 */
class Plugin_Input extends Plugin
{
	/**
	 * Get
	 *
	 * Get a $_GET value
	 *
	 * Usage:
	 *
	 * {{ input:get key="foo" }}
	 *
	 * @param	string
	 * @return	mixed
	 */
	public function get()
	{
		return $this->input->get($this->getAttribute('key'));
	}

	/**
	 * Post
	 *
	 * Get a $_POST value
	 *
	 * Usage:
	 *
	 * {{ input:post key="foo" }}
	 *
	 * @param	string
	 * @return	mixed
	 */
	public function post()
	{
		return $this->input->post($this->getAttribute('key'));
	}
}

/* End of file input.php */