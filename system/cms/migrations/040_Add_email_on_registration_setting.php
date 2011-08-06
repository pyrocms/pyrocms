<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_email_on_registration_setting extends Migration {

	function up()
	{
		$this->migrations->verbose AND print "Added setting - email on registration.";

		/* insert settings */
		$this->db->insert('settings', array(
			'slug'				=> 'registered_email',
			'title'				=> 'User Registered Email',
			'description'	=> 'Send an email to the contact e-mail when someone registers',
			'type'				=> 'radio',
			'default'			=> '0',
			'value'				=> '0',
			'options'			=> '1=Enabled|0=Disabled',
			'module'			=> 'users',
			'is_required'	=> 0,
			'is_gui'			=> 1,
			'order'				=> 0
		));
		
		/* insert default email template */
		$this->db->insert('default_email_templates',array(
			'slug'				=> 'registered',
			'name'				=> 'User Registered',
			'description' => 'Email Sent to contact e-mail when a user registers',
			'subject'			=> 'You have just received a registration from {pyro:name}',
			'body'				=> '<h3>You have received a registration from {pyro:name}</h3><strong>IP Address: {pyro:sender_ip}</strong>
<strong>Operating System: {pyro:sender_os}
<strong>User Agent: {pyro:sender_agent}</strong>',
			'lang'				=> 'en',
			'is_default'	=> 1
		));
	}

	function down()
	{
		$this->db->delete('settings', array('slug' => 'registered_email'));
		$this->db->delete('default_email_templates', array('slug' => 'registered'));
	}
}