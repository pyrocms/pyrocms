<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Session Plugin
 *
 * Read and write session data
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_Session extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Session',
	);
	public $description = array(
		'en' => 'Access and set session variables.',
		'el' => 'Ανάκτηση και απόθεση τιμών και μεταβλητών του session.',
            'fa' => 'دسترسی و ست کردن متغییر های سشن',
		'fr' => 'Accéder aux variables de session. ',
		'it' => 'Accedi e imposta le variabili di sessione'
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'data' => array(
				'description' => array(
					'en' => 'Get and set session variables which will be available on future page requests. Omitting the value attribute results in a Get operation.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'name' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'value' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
				),
			),// end first method
			'flash' => array(
				'description' => array(
					'en' => 'Get and set flash variables which will be available on only the next page load. Omitting the value attribute results in a Get operation.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'name' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'value' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
				),
			),// end second method
			'messages' => array(
				'description' => array(
					'en' => 'Displays messages set with {{ session:flash }}. The attributes allow you to set the CSS class of the message.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'success' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'success',
						'required' => false,
					),
					'notice' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'notice',
						'required' => false,
					),
					'error' => array(
						'type' => 'text',
						'flags' => '',
						'default' => 'error',
						'required' => false,
					),
				),
			),// end third method
		);
	
		return $info;
	}

	/**
	 * Data
	 *
	 * Sets and retrieves flash data
	 *
	 * Usage:
	 *
	 *     {{ session:data name="foo"[ value="bar"] }}
	 *
	 * @return void|string The value of $name from the session user data.
	 */
	public function data()
	{
		$name  = $this->attribute('name');
		$value = $this->attribute('value');

		// value provided! We are setting to the name
		if ($value !== null)
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
	 *
	 *     {{ session:flash name="(success|notice|error)"[ value="bar"] }}
	 *
	 * @return void|string The value of $name from the session flash user data.
	 */
	public function flash()
	{
		$name  = $this->attribute('name');
		$value = $this->attribute('value');

		// value provided! We are setting to the name
		if ($value !== null)
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
	 *
	 *     {{ session:data name="foo" }}
	 *
	 * @return string The HTML of the notices.
	 */
	public function messages()
	{
		$success_class = $this->attribute('success', 'success');
		$notice_class  = $this->attribute('notice', 'notice');
		$error_class   = $this->attribute('error', 'error');

		$output = '';

		if ($this->session->flashdata('success'))
		{
			foreach ((array) $this->session->flashdata('success') as $message)
			{
				$output .= '<div class="' . $success_class . '">' . $message . '</div>';
			}
		}

		if ($this->session->flashdata('notice'))
		{
			foreach ((array) $this->session->flashdata('notice') as $message)
			{
				$output .= '<div class="' . $notice_class . '">' . $message . '</div>';
			}
		}

		if ($this->session->flashdata('error'))
		{
			foreach ((array) $this->session->flashdata('error') as $message)
			{
				$output .= '<div class="' . $error_class . '">' . $message . '</div>';
			}
		}

		return $output;
	}

}