<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Session Plugin
 *
 * Read and write session data
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Plugins
 */
class Plugin_Session extends Plugin
{

	/**
	 * Data
	 *
	 * Sets and retrieves flash data
	 *
	 * Usage:
	 *   {{ session:data name="foo"[ value="bar"] }}
	 * 
	 * @return void|string The value of $name from the session user data.
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
	 *   {{ session:flash name="(success|notice|error)"[ value="bar"] }}
	 * 
	 * @return void|string The value of $name from the session flash user data.
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
	 *   {{ session:data name="foo" }}
	 *
	 * @return string The HTML of the notices.
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