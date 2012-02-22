<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Templates Details.php
 *
 * Create and store dynamic email templates in the database
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Templates
 */
class Module_Templates extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Email predloge',
				'en' => 'Email Templates',
				'fr' => 'Modèles d\'emails',
				'nl' => 'Email sjablonen',
				'es' => 'Plantillas de email',
				'ar' => 'قوالب الرسائل الإلكترونية',
				'br' => 'Modelos de e-mail',
				'el' => 'Δυναμικά email',
				'he' => 'תבניות',
				'lt' => 'El. laiškų šablonai',
				'ru' => 'Шаблоны почты',
				'da' => 'Email skabeloner',
				'zh' => '郵件範本',
				'id' => 'Template Email'
			),
			'description' => array(
				'sl' => 'Ustvari, uredi in shrani spremenljive email predloge',
				'en' => 'Create, edit, and save dynamic email templates',
				'fr' => 'Créer, éditer et sauver dynamiquement des modèles d\'emails',
				'nl' => 'Maak, bewerk, en beheer dynamische emailsjablonen',
				'es' => 'Crear, editar y guardar plantillas de email dinámicas',
				'ar' => 'أنشئ، عدّل واحفظ قوالب البريد الإلكترني الديناميكية.',
				'br' => 'Criar, editar e salvar modelos de e-mail dinâmicos',
				'el' => 'Δημιουργήστε, επεξεργαστείτε και αποθηκεύστε δυναμικά email.',
				'he' => 'ניהול של תבניות דואר אלקטרוני',
				'lt' => 'Kurk, tvarkyk ir saugok dinaminius el. laiškų šablonus.',
				'ru' => 'Создавайте, редактируйте и сохраняйте динамические почтовые шаблоны',
				'da' => 'Opret, redigér og gem dynamiske emailskabeloner.',
				'zh' => '新增、編輯與儲存可顯示動態資料的 email 範本',
				'id' => 'Membuat, mengedit, dan menyimpan template email dinamis'
			),
			'frontend' => FALSE,
			'backend' => TRUE,
			'menu' => 'design',
			'author' => 'Stephen Cozart',
			'skip_xss' => TRUE,
			
			'shortcuts' => array(
				array(
				    'name' => 'templates.create_title',
				    'uri' => 'admin/templates/create',
				    'class' => 'add'
				),
		    ),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('email_templates');

		$tables = array(
			'theme_options' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 100,), // @todo rename this to 'title' to keep coherency with the rest of the modules
				'description' => array('type' => 'VARCHAR', 'constraint' => 255,), // @todo change this to TEXT to be coherent with the rest of the modules
				'subject' => array('type' => 'VARCHAR', 'constraint' => 255,),
				'body' => array('type' => 'TEXT'),
				'lang' => array('type' => 'VARCHAR', 'constraint' => 2,),
				'is_default' => array('type' => 'INT', 'constraint' => 1,),
			),
		);

		$this->install_tables($tables);

		// Insert the default email templates
		$this->load->model('templates/email_templates_m');

		// @todo move this to the comments module
		$this->email_templates_m->insert(array(
			'slug' => 'comments',
			'name' => 'Comment Notification',
			'description' => 'Email that is sent to admin when someone creates a comment',
			'subject' => 'You have just received a comment from {{ name }}',
			'body' => '<h3>You have received a comment from {{ name }}</h3>
				<strong>IP Address: {{ sender_ip }}</strong>\n
				<strong>Operating System: {{ sender_os }}\n
				<strong>User Agent: {{ sender_agent }}</strong>\n
				<div>{{ comment }}</div>\n
				<div>View Comment:{{ redirect_url }}</div>',
			'lang' => 'en',
			'is_default' => 1,
		));

		// @todo move this to the contact module
		$this->email_templates_m->insert(array(
			'slug' => 'contact',
			'name' => 'Contact Notification',
			'description' => 'Template for the contact form',
			'subject' => '{{ settings:site_name }} :: {{ subject }}',
			'body' => 'This message was sent via the contact form on with the following details:
				<hr />
				IP Address: {{ sender_ip }}
				OS {{ sender_os }}
				Agent {{ sender_agent }}
				<hr />
				{{ message }}

				{{ name }},
				{{ email }}',
			'lang' => 'en',
			'is_default' => 1,
		));

		// @todo move this to the users module
		$this->email_templates_m->insert(array(
			'slug' => 'registered',
			'name' => 'New User Registered',
			'description' => 'Email sent to the site contact e-mail when a new user registers',
			'subject' => '{{ settings:site_name }} :: You have just received a registration from {{ name }}',
			'body' => '<h3>You have received a registration from {{ name }}</h3>
				<p><strong>IP Address: {{ sender_ip }}</strong><br/>
				<strong>Operating System: {{ sender_os }}</strong><br/>
				<strong>User Agent: {{ sender_agent }}</strong>
				</p>',
			'lang' => 'en',
			'is_default' => 1,
		));

		// @todo move this to the users module
		$this->email_templates_m->insert(array(
			'slug' => 'activation',
			'name' => 'Activation Email',
			'description' => 'The email which contains the activation code that is sent to a new user',
			'subject' => '{{ settings:site_name }} - Account Activation',
			'body' => '<p>Hello {{ user:first_name }},</p>
				<p>Thank you for registering at {{ settings:site_name }}. Before we can activate your account, please complete the registration process by clicking on the following link:</p>
				<p><a href="{{ url:site }}users/activate/{{ user:id }}/{{ activation_code }}">{{ url:site }}users/activate/{{ user:id }}/{{ activation_code }}</a></p>
				<p>&nbsp;</p>
				<p>In case your email program does not recognize the above link as, please direct your browser to the following URL and enter the activation code:</p>
				<p><a href="{{ url:site }}users/activate">{{ url:site }}users/activate</a></p>
				<p><strong>Activation Code:</strong> {{ activation_code }}</p>',
			'lang' => 'en',
			'is_default' => 1,
		));

		// @todo move this to the users module
		$this->email_templates_m->insert(array(
			'slug' => 'forgotten_password',
			'name' => 'Forgotten Password Email',
			'description' => 'The email that is sent containing a password reset code',
			'subject' => '{{ settings:site_name }} - Forgotten Password',
			'body' => '<p>Hello {{ user:first_name }},</p>
				<p>It seems you have requested a password reset. Please click this link to complete the reset: <a href="{{ url:site }}users/reset_pass/{{ user:forgotten_password_code }}">{{ url:site }}users/reset_pass/{{ user:forgotten_password_code }}</a></p>
				<p>If you did not request a password reset please disregard this message. No further action is necessary.</p>',
			'lang' => 'en',
			'is_default' => 1,
		));

		// @todo move this to the users module
		$this->email_templates_m->insert(array(
			'slug' => 'new_password',
			'name' => 'New Password Email',
			'description' => 'After a password is reset this email is sent containing the new password',
			'subject' => '{{ settings:site_name }} - New Password',
			'body' => '<p>Hello {{ user:first_name }},</p>
				<p>Your new password is: {{ new_password }}</p>
				<p>After logging in you may change your password by visiting <a href="{{ url:site }}edit-profile">{{ url:site }}edit-profile</a></p>',
			'lang' => 'en',
			'is_default' => 1,
		));

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
