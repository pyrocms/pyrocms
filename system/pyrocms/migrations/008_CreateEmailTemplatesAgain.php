<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Createemailtemplatesagain extends Migration {
	
	function up() 
	{
		if(!$this->db->table_exists('email_templates'))
		{
			//create table that will hold the email templates
			$email_templates = "
				CREATE TABLE IF NOT EXISTS `email_templates` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`slug` varchar(100) NOT NULL,
				`name` varchar(100) NOT NULL,
				`description` varchar(255) NOT NULL,
				`subject` varchar(255) NOT NULL,
				`body` text NOT NULL,
				`lang` varchar(2),
				`is_default` int(1) NOT NULL DEFAULT '0',
				PRIMARY KEY (`id`),
				UNIQUE KEY slug_lang (`slug`, `lang`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Store dynamic email templates';
			";
			
			$this->db->query($email_templates);
		}//endif
		
		
			//prepare the data array for the comments_create template
			$comments = array('slug' => 'comments',
							'name' => 'Comment Notificiation',
							'description' => 'Email that is sent to admin when someone creates a comment',
							'subject' => 'You have just received a comment from {pyro:name}',
							'body' => '<h3>You have recieved a comment from {pyro:name}</h3>
										<p>
								<strong>IP Address: {pyro:sender_ip}</strong> <strong>Operating System: {pyro:sender_os} <strong>User Agent: {pyro:sender_agent}</strong> </strong></p>
								<div>
								<strong>{pyro:comment}</strong></div>
								<div>
								<strong>View Comment:{pyro:redirect_url}</strong></div>',
							'lang' => 'en',
							'is_default' => 1
							);
			
			//insert the comment template
			if($this->db->from('email_templates')->where('slug', 'comments')->count_all_results() < 1)
			{
				$this->db->insert('email_templates', $comments);
			}
			
			if($this->db->from('email_templates')->where('slug', 'contact')->count_all_results() < 1)
			{
				$contact = array(
						'slug' => 'contact',
						'name' => 'Contact Form Notification',
						'description' => 'Contact form email template',
						'subject' => '{pyro:settings:site_name} :: {pyro:subject}',
						'body' => 'This message was sent via the contact form with the following details:
									<hr />
									IP Address: {pyro:sender_ip} OS: {pyro:sender_os} Agent: {pyro:sender_agent}
									<hr />
									{pyro:message}
									{pyro:contact_name}, {pyro:company_name}
									',
						'lang' => 'en',
						'is_default' => 1
				);
				$this->db->insert('email_templates', $contact);
			}
		
		
	}
		
	

	function down() 
	{
	}
}
