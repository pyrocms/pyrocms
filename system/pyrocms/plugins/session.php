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
	public function data()
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
	public function flash()
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

	/**
	 * Notices
	 *
	 * Include the session notices
	 *
	 * Usage:
	 * {pyro:session:data name="foo"}
	 *
	 * @param	array
	 * @return	array
	 */
	public function messages()
	{
		$success_class = $this->attribute('success', 'success');
		$notice_class = $this->attribute('notice', 'notice');
		$error_class = $this->attribute('error', 'error');

		$output = '';

		if ($this->session->flashdata('success'))
		{
			$output .= '<div class="'.$success_class.'">'.$this->session->flashdata('success').'</div>';
		}

		if ($this->session->flashdata('notice'))
		{
			$output .= '<div class="'.$notice_class.'">'.$this->session->flashdata('notice').'</div>';
		}

		if ($this->session->flashdata('error'))
		{
			$output .= '<div class="'.$error_class.'">'.$this->session->flashdata('error').'</div>';
		}

		return $output;
	}
}

/* End of file theme.php */