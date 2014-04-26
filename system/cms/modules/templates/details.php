<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Templates Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Templates
 */
class Module_Templates extends Module {

	public $version = '1.1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Email Templates',
				'ar' => 'قوالب الرسائل الإلكترونية',
				'br' => 'Modelos de e-mail',
				'pt' => 'Modelos de e-mail',
				'da' => 'Email skabeloner',
				'el' => 'Δυναμικά email',
				'es' => 'Plantillas de email',
                            'fa' => 'قالب های ایمیل',
				'fr' => 'Modèles d\'emails',
				'he' => 'תבניות',
				'id' => 'Template Email',
				'lt' => 'El. laiškų šablonai',
				'nl' => 'Email sjablonen',
				'ru' => 'Шаблоны почты',
				'sl' => 'Email predloge',
				'tw' => '郵件範本',
				'cn' => '邮件范本',
				'hu' => 'E-mail sablonok',
				'fi' => 'Sähköposti viestipohjat',
				'th' => 'แม่แบบอีเมล',
				'se' => 'E-postmallar',
			),
			'description' => array(
				'en' => 'Create, edit, and save dynamic email templates',
				'ar' => 'أنشئ، عدّل واحفظ قوالب البريد الإلكترني الديناميكية.',
				'br' => 'Criar, editar e salvar modelos de e-mail dinâmicos',
				'pt' => 'Criar, editar e salvar modelos de e-mail dinâmicos',
				'da' => 'Opret, redigér og gem dynamiske emailskabeloner.',
				'el' => 'Δημιουργήστε, επεξεργαστείτε και αποθηκεύστε δυναμικά email.',
				'es' => 'Crear, editar y guardar plantillas de email dinámicas',
                            'fa' => 'ایحاد، ویرایش و ذخیره ی قالب های ایمیل به صورت پویا',
				'fr' => 'Créer, éditer et sauver dynamiquement des modèles d\'emails',
				'he' => 'ניהול של תבניות דואר אלקטרוני',
				'id' => 'Membuat, mengedit, dan menyimpan template email dinamis',
				'lt' => 'Kurk, tvarkyk ir saugok dinaminius el. laiškų šablonus.',
				'nl' => 'Maak, bewerk, en beheer dynamische emailsjablonen',
				'ru' => 'Создавайте, редактируйте и сохраняйте динамические почтовые шаблоны',
				'sl' => 'Ustvari, uredi in shrani spremenljive email predloge',
				'tw' => '新增、編輯與儲存可顯示動態資料的 email 範本',
				'cn' => '新增、编辑与储存可显示动态资料的 email 范本',
                'hu' => 'Csináld, szerkeszd és mentsd el a dinamikus e-mail sablonokat',
				'fi' => 'Lisää, muokkaa ja tallenna dynaamisia sähköposti viestipohjia.',
				'th' => 'การสร้างแก้ไขและบันทึกแม่แบบอีเมลแบบไดนามิก',
				'se' => 'Skapa, redigera och spara dynamiska E-postmallar.',
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'structure',
			'skip_xss' => true,
			'shortcuts' => array(
				array(
				    'name' => 'templates:create_title',
				    'uri' => 'admin/templates/create',
				    'class' => 'add',
				),
		    ),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('email_templates');

		$tables = array(
			'email_templates' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'unique' => 'slug_lang',),
				'name' => array('type' => 'VARCHAR', 'constraint' => 100,), // @todo rename this to 'title' to keep coherency with the rest of the modules
				'description' => array('type' => 'VARCHAR', 'constraint' => 255,), // @todo change this to TEXT to be coherent with the rest of the modules
				'subject' => array('type' => 'VARCHAR', 'constraint' => 255,),
				'body' => array('type' => 'TEXT'),
				'lang' => array('type' => 'VARCHAR', 'constraint' => 2, 'null' => true, 'unique' => 'slug_lang',),
				'is_default' => array('type' => 'INT', 'constraint' => 1, 'default' => 0,),
				'module' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => '',),
			),
		);

		if ( !$this->install_tables($tables))
		{
			return false;
		}

		// Insert the default email templates

		// @todo move this to the comments module
		$this->db->insert('email_templates',array(
			'slug' => 'comments',
			'name' => 'Comment Notification',
			'description' => 'Email that is sent to admin when someone creates a comment',
			'subject' => 'You have just received a comment from {{ name }}',
			'body' => "<h3>You have received a comment from {{ name }}</h3>
				<p>
				<strong>IP Address: {{ sender_ip }}</strong><br/>
				<strong>Operating System: {{ sender_os }}<br/>
				<strong>User Agent: {{ sender_agent }}</strong>
				</p>
				<p>{{ comment }}</p>
				<p>View Comment: {{ redirect_url }}</p>",
			'lang' => 'en',
			'is_default' => 1,
			'module' => 'comments'
		));

		// @todo move this to the contact module
		$this->db->insert('email_templates',array(
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
			'module' => 'pages'
		));

		// @todo move this to the users module
		$this->db->insert('email_templates',array(
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
			'module' => 'users'
		));

		// @todo move this to the users module
		$this->db->insert('email_templates',array(
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
			'module' => 'users'
		));

		// @todo move this to the users module
		$this->db->insert('email_templates',array(
			'slug' => 'forgotten_password',
			'name' => 'Forgotten Password Email',
			'description' => 'The email that is sent containing a password reset code',
			'subject' => '{{ settings:site_name }} - Forgotten Password',
			'body' => '<p>Hello {{ user:first_name }},</p>
				<p>It seems you have requested a password reset. Please click this link to complete the reset: <a href="{{ url:site }}users/reset_pass/{{ user:forgotten_password_code }}">{{ url:site }}users/reset_pass/{{ user:forgotten_password_code }}</a></p>
				<p>If you did not request a password reset please disregard this message. No further action is necessary.</p>',
			'lang' => 'en',
			'is_default' => 1,
			'module' => 'users'
		));

		// @todo move this to the users module
		$this->db->insert('email_templates',array(
			'slug' => 'new_password',
			'name' => 'New Password Email',
			'description' => 'After a password is reset this email is sent containing the new password',
			'subject' => '{{ settings:site_name }} - New Password',
			'body' => '<p>Hello {{ user:first_name }},</p>
				<p>Your new password is: {{ new_password }}</p>
				<p>After logging in you may change your password by visiting <a href="{{ url:site }}edit-profile">{{ url:site }}edit-profile</a></p>',
			'lang' => 'en',
			'is_default' => 1,
			'module' => 'users'
		));

		return true;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}

	public function upgrade($old_version)
	{
		return true;
	}

}
