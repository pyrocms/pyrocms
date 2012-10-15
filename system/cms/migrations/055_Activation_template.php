<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Activation_template extends CI_Migration {

	public function up()
	{
		$this->db->delete('email_templates', array('slug' => 'activation'));
		$this->db->insert('email_templates', array(
			'slug'				=> 'activation',
			'name'				=> 'Activation Email',
			'description' 		=> 'The email which contains the activation code that is sent to a new user',
			'subject'			=> '{pyro:settings:site_name} - Account Activation',
			'body'				=> '<p>Hello {pyro:user:first_name},</p>
									<p>Thank you for registering at {pyro:settings:site_name}. Before we can activate your account, please complete the registration process by clicking on the following link:</p>
									<p><a href="{pyro:url:site}users/activate/{pyro:user:id}/{pyro:activation_code}">{pyro:url:site}users/activate/{pyro:user:id}/{pyro:activation_code}</a></p>
									<p>&nbsp;</p>
									<p>In case your email program does not recognize the above link as, please direct your browser to the following URL and enter the activation code:</p>
									<p><a href="{pyro:url:site}users/activate">{pyro:url:site}users/activate</a></p>
									<p><strong>Activation Code:</strong> {pyro:activation_code}</p>',
			'lang'				=> 'en',
			'is_default'	=> 1
		));
	}

	public function down()
	{
		$this->db->delete('email_templates', array('slug' => 'activation'));
	}
}