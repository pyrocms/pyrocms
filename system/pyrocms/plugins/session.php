<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Session Plugin
 *
 * Read and write session data
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2010, PyroCMS
 *
 */
class Plugin_Session extends Plugin
{
	/**
	 * Data
	 *
	 * Loads a theme partial
	 *
	 * Usage:
	 * {pyro:session:data name="foo"}
	 *
	 * @param	array
	 * @return	array
	 */
	function data()
	{
		$name = $this->attribute('name');
		$value = $this->attribute('value');

		// Mo vaue? Just getting
		if ($value !== NULL)
		{
			$this->session->set_userdata($name, $value);
			return;
		}

		return $this->session->userdata($name);
	}

	/**
	 * Data
	 *
	 * Loads a theme partial
	 *
	 * Usage:
	 * {pyro:session:flash name="foo"}
	 *
	 * @param	array
	 * @return	array
	 */
	function flash()
	{
		$name = $this->attribute('name');
		$value = $this->attribute('value');

		// Mo vaue? Just getting
		if ($value !== NULL)
		{
			$this->session->set_flashdata($name, $value);
			return;
		}

		return $this->session->flashdata($name);
	}
}

/* End of file theme.php */