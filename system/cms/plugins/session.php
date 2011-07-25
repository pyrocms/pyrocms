<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Session Plugin
 *
 * Read and write session data
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Session extends Plugin
{
	/**
	 * Data
	 *
	 * Sets and retrieves flash data
	 *
	 * Usage:
	 * {pyro:session:data name="foo"[ value="bar"]}
	 */
	public function data()
	{
		$name = $this->attribute('name');
		$value = $this->attribute('value');

		// value provided! We are setting to the name
		if ($value !== NULL)
		{
			$this->session->set_userdata($name, $value);
			return;
		}
		// No value? Just getting
		return $this->session->userdata($name);
	}

	/**
	 * Flash
	 *
	 * Sets and retrieves flash data
	 *
	 * Usage:
	 * {pyro:session:flash name="(success|notice|error)"[ value="bar"]}
	 */
	public function flash()
	{
		$name = $this->attribute('name');
		$value = $this->attribute('value');

		// value provided! We are setting to the name
		if ($value !== NULL)
		{
			$this->session->set_flashdata($name, $value);
			return;
		}

		// No value? Just getting
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

/* End of file session.php */