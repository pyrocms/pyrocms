<?php

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
	 * {{ input:get key="foo" default="bar" }}
	 *
	 * @param	string
	 * @return	mixed
	 */
	public function get()
	{
		if ($this->getAttribute('key')) {
			return $this->input->get($this->getAttribute('key'));
		} else {
			return $this->getAttribute('default');
		}
	}

	/**
	 * Post
	 *
	 * Get a $_POST value
	 *
	 * Usage:
	 *
	 * {{ input:post key="foo" default="bar" }}
	 *
	 * @param	string
	 * @return	mixed
	 */
	public function post()
	{
		if ($this->getAttribute('key')) {
			return $this->input->post($this->getAttribute('key'));
		} else {
			return $this->getAttribute('default');
		}
	}

	/**
	 * Cookie
	 *
	 * Get a $_COOKIE value
	 *
	 * Usage:
	 *
	 * {{ input:cookie key="foo" default="bar" }}
	 *
	 * @param	string
	 * @return	mixed
	 */
	public function cookie()
	{
		if ($this->getAttribute('key')) {
			return $this->input->cookie($this->getAttribute('key'));
		} else {
			return $this->getAttribute('default');
		}
	}

	/**
	 * Server
	 *
	 * Get a $_SERVER value
	 *
	 * Usage:
	 *
	 * {{ input:server key="foo" default="bar" }}
	 *
	 * @param	string
	 * @return	mixed
	 */
	public function server()
	{
		if ($this->getAttribute('key')) {
			return $this->input->server($this->getAttribute('key'));
		} else {
			return $this->getAttribute('default');
		}
	}
}
