<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Templates Details.php
 *
 * Create and store dynamic email templates in the database
 *
 * @package		PyroCMS
 * @subpackage	Templates Module
 * @category	Module
 * @author		Stephen Cozart - PyroCMS Dev Team
 */
class Module_Templates extends Module {

	public $version = '0.1';

	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Email predloge',
				'en' => 'Email Templates',
				'es' => 'Plantillas de email',
				'ar' => 'قوالب الرسائل الإلكترونية',
				'pt' => 'Modelos de e-mail',
				'el' => 'Δυναμικά email',
				'he' => 'תבניות',
				'lt' => 'El. laiškų šablonai',
				'ru' => 'Шаблоны почты'
			),
			'description' => array(
				'sl' => 'Ustvari, uredi in shrani spremenljive email predloge',
				'en' => 'Create, edit, and save dynamic email templates',
				'es' => 'Crear, editar y guardar plantillas de email dinámicas',
				'ar' => 'أنشئ، عدّل واحفظ قوالب البريد الإلكترني الديناميكية.',
				'pt' => 'Criar, editar e salvar modelos de e-mail dinâmicos',
				'el' => 'Δημιουργήστε, επεξεργαστείτε και αποθηκεύστε δυναμικά email.',
				'he' => 'ניהול של תבניות דואר אלקטרוני',
				'lt' => 'Kurk, tvarkyk ir saugok dinaminius el. laiškų šablonus.',
				'ru' => 'Создавайте, редактируйте и сохраняйте динамические почтовые шаблоны'
			),
			'frontend' => FALSE,
			'backend' => TRUE,
			'menu' => 'design',
			'author' => 'Stephen Cozart'
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('email_templates');
		
		$email_templates = "
            CREATE TABLE IF NOT EXISTS " . $this->db->dbprefix('email_templates') . " (
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

		$create = $this->db->query($email_templates);

		$comment_body = '<h3>You have received a comment from {pyro:name}</h3>';
		$comment_body .= '<strong>IP Address: {pyro:sender_ip}</strong>\n';
		$comment_body .= '<strong>Operating System: {pyro:sender_os}\n';
		$comment_body .= '<strong>User Agent: {pyro:sender_agent}</strong>\n';
		$comment_body .= '<div>{pyro:comment}</div>\n';
		$comment_body .= '<div>View Comment:{pyro:redirect_url}</div>';
		$comment_subject = 'You have just received a comment from {pyro:name}';

		$comment_template = "
			INSERT INTO " . $this->db->dbprefix('email_templates') . " (`slug`, `name`, `description`, `subject`, `body`, `lang`, `is_default`) VALUES
			('comments', 'Comment Notificiation', 'Email that is sent to admin when someone creates a comment', '".$comment_subject."', '".$comment_body."', 'en', 1);
		";

		$contact_template = "
			INSERT INTO " . $this->db->dbprefix('email_templates') . " (`slug`, `name`, `description`, `subject`, `body`, `lang`, `is_default`) VALUES ('contact', 'Contact Notification', 'Template for the contact form', '{pyro:settings:site_name} :: {pyro:subject}', 'This message was sent via the contact form on with the following details:
				<hr />
				IP Address: {pyro:sender_ip}
				OS {pyro:sender_os}
				Agent {pyro:sender_agent}
				<hr />
				{pyro:message}

				{pyro:contact_name},
				{pyro:contact_company}', 'en', '1');
		";
		
		$registered_template = "
			INSERT INTO " . $this->db->dbprefix('email_templates') . " (`slug`, `name`, `description`, `subject`, `body`, `lang`, `is_default`) VALUES ('registered', 'New User Registered', 'The email sent to the site contact e-mail when a new user registers', '{pyro:settings:site_name} :: You have just received a registration from {pyro:name}', '<h3>You have received a registration from {pyro:name}</h3><strong>IP Address: {pyro:sender_ip}</strong>
				<strong>Operating System: {pyro:sender_os}
				<strong>User Agent: {pyro:sender_agent}</strong>', 'en', '1');
		";

			$this->db->query($comment_template); //sent when a user posts a comment to something
			$this->db->query($contact_template); //sent when a user uses the contact form
			$this->db->query($registered_template); // sent to the site contact email when a new user registers
			//$this->db->insert($activate_template); //activation_required.php - when user registers this is sent
			//$this->db->insert($forgot_password_template); //forgot_password.tpl.php sent when user resets password
			//$this->db->insert($new_password_template); //new_password.tpl.php sent one a password is successfuly sent
			return TRUE;
	}

	public function uninstall()
	{
		//it's a core module, lets keep it around
		return FALSE;
	}

	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br/>Contact the module developer for assistance.";
	}
}
/* End of file details.php */
