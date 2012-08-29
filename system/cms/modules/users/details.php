<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Users Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Users
 */
class Module_Users extends Module {

	public $version = '0.9';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Users',
				'ar' => 'المستخدمون',
				'br' => 'Usuários',
				'pt' => 'Utilizadores',
				'cs' => 'Uživatelé',
				'da' => 'Brugere',
				'de' => 'Benutzer',
				'el' => 'Χρήστες',
				'es' => 'Usuarios',
				'fi' => 'Käyttäjät',
				'fr' => 'Utilisateurs',
				'he' => 'משתמשים',
				'id' => 'Pengguna',
				'it' => 'Utenti',
				'lt' => 'Vartotojai',
				'nl' => 'Gebruikers',
				'pl' => 'Użytkownicy',
				'ru' => 'Пользователи',
				'sl' => 'Uporabniki',
				'zh' => '用戶',
				'hu' => 'Felhasználók',
				'th' => 'ผู้ใช้งาน',
                                'se' => 'Användare'
			),
			'description' => array(
				'en' => 'Let users register and log in to the site, and manage them via the control panel.',
				'ar' => 'تمكين المستخدمين من التسجيل والدخول إلى الموقع، وإدارتهم من لوحة التحكم.',
				'br' => 'Permite com que usuários se registrem e entrem no site e também que eles sejam gerenciáveis apartir do painel de controle.',
				'pt' => 'Permite com que os utilizadores se registem e entrem no site e também que eles sejam geriveis apartir do painel de controlo.',
				'cs' => 'Umožňuje uživatelům se registrovat a přihlašovat a zároveň jejich správu v Kontrolním panelu.',
				'da' => 'Lader brugere registrere sig og logge ind på sitet, og håndtér dem via kontrolpanelet.',
				'de' => 'Erlaube Benutzern das Registrieren und Einloggen auf der Seite und verwalte sie über die Admin-Oberfläche.',
				'el' => 'Παρέχει λειτουργίες εγγραφής και σύνδεσης στους επισκέπτες. Επίσης από εδώ γίνεται η διαχείριση των λογαριασμών.',
				'es' => 'Permite el registro de nuevos usuarios quienes podrán loguearse en el sitio. Estos podrán controlarse desde el panel de administración.',
				'fi' => 'Antaa käyttäjien rekisteröityä ja kirjautua sisään sivustolle sekä mahdollistaa niiden muokkaamisen hallintapaneelista.',
				'fr' => 'Permet aux utilisateurs de s\'enregistrer et de se connecter au site et de les gérer via le panneau de contrôle',
				'he' => 'ניהול משתמשים: רישום, הפעלה ומחיקה',
				'id' => 'Memungkinkan pengguna untuk mendaftar dan masuk ke dalam situs, dan mengaturnya melalui control panel.',
				'it' => 'Fai iscrivere de entrare nel sito gli utenti, e gestiscili attraverso il pannello di controllo.',
				'lt' => 'Leidžia vartotojams registruotis ir prisijungti prie puslapio, ir valdyti juos per administravimo panele.',
				'nl' => 'Laat gebruikers registreren en inloggen op de site, en beheer ze via het controlepaneel.',
				'pl' => 'Pozwól użytkownikom na logowanie się na stronie i zarządzaj nimi za pomocą panelu.',
				'ru' => 'Управление зарегистрированными пользователями, активирование новых пользователей.',
				'sl' => 'Dovoli uporabnikom za registracijo in prijavo na strani, urejanje le teh preko nadzorne plošče',
				'zh' => '讓用戶可以註冊並登入網站，並且管理者可在控制台內進行管理。',
				'th' => 'ให้ผู้ใช้ลงทะเบียนและเข้าสู่เว็บไซต์และจัดการกับพวกเขาผ่านทางแผงควบคุม',
                                'hu' => 'Hogy a felhasználók tudjanak az oldalra regisztrálni és belépni, valamint lehessen őket kezelni a vezérlőpulton.',
                                'se' => 'Låt dina besökare registrera sig och logga in på webbplatsen. Hantera sedan användarna via kontrollpanelen.'
			),
			'frontend' 	=> false,
			'backend'  	=> true,
			'menu'	  	=> false,
			'roles'		=> array('admin_profile_fields')
			);

		if (function_exists('group_has_role'))
		{
			if(group_has_role('users', 'admin_profile_fields'))
			{
				$info['sections'] = array(
					'users' => array(
							'name' 	=> 'user_list_title',
							'uri' 	=> 'admin/users',
								'shortcuts' => array(
									'create' => array(
										'name' 	=> 'user_add_title',
										'uri' 	=> 'admin/users/create',
										'class' => 'add'
										)
									)
								),
					'fields' => array(
							'name' 	=> 'user_profile_fields_label',
							'uri' 	=> 'admin/users/fields',
								'shortcuts' => array(
									'create' => array(
										'name' 	=> 'user_add_field',
										'uri' 	=> 'admin/users/fields/create',
										'class' => 'add'
										)
									)
								)
						);
			}
		}

		return $info;
	}

	/**
	 * Installation logic
	 *
	 * This is handled by the installer only so that a default user can be created.
	 *
	 * @return boolean
	 */
	public function install()
	{
    	// Load up the streams driver and convert the profiles table
    	// into a stream.
    	$this->load->driver('Streams');

    	if ( ! $this->streams->utilities->convert_table_to_stream('profiles', 'users', null, 'lang:user_profile_fields_label', 'Profiles for users module', 'display_name', array('display_name')))
    	{
    		return false;
    	}

    	// Go ahead and convert our standard user fields:
    	$columns = array(
			'first_name' => array(
    			'field_name' => 'lang:user_first_name',
    			'field_type' => 'text',
    			'extra'		 => array('max_length' => 50),
    			'assign'	 => array('required' => true)
    		),
			'last_name' => array(
    			'field_name' => 'lang:user_last_name',
    			'field_type' => 'text',
    			'extra'		 => array('max_length' => 50),
				'assign'	 => array('required' => true)
    		),
    		'company' => array(
    			'field_name' => 'lang:profile_company',
    			'field_slug' => 'company',
    			'field_type' => 'text',
    			'extra'		 => array('max_length' => 100)
    		),
    		'language' => array(
    			'field_name' => 'lang:user_lang',
    			'field_slug' => 'pyro_lang',
    			'extra'		 => array('filter_theme' => 'yes')
    		),
 			'bio' => array(
    			'field_name' => 'lang:profile_bio',
    			'field_type' => 'textarea'
    		),
            'lang' => array(
                'field_name' => 'lang:user_lang',
                'field_type' => 'pyro_lang',
                'extra'      => array('filter_theme' => 'yes')
            ),
			'dob' => array(
    			'field_name' => 'lang:profile_dob',
    			'field_type' => 'datetime',
    			'extra'		 => array(
    								'use_time' 		=> 'no',
    								'storage' 		=> 'unix',
    								'input_type'	=> 'dropdown',
    								'start_date'	=> '-100Y'
    							)
    		),
    		'gender' => array(
    			'field_name' => 'lang:profile_gender',
    			'field_type' => 'choice',
    			'extra'		 => array('choice_type' => 'dropdown', 'choice_data' => " : Not Telling\nm : Male\nf : Female")
    		),
     		'phone' => array(
    			'field_name' => 'lang:profile_phone',
    			'field_type' => 'text',
    			'extra'		 => array('max_length' => 20)
    		),
     		'mobile' => array(
    			'field_name' => 'lang:profile_mobile',
    			'field_type' => 'text',
    			'extra'		 => array('max_length' => 20)
    		),
      		'address_line1' => array(
    			'field_name' => 'lang:profile_address_line1',
    			'field_type' => 'text'
    		),
      		'address_line2' => array(
    			'field_name' => 'lang:profile_address_line2',
    			'field_type' => 'text'
    		),
    		'address_line3' => array(
    			'field_name' => 'lang:profile_address_line3',
    			'field_type' => 'text'
    		),
    		'postcode' => array(
    			'field_name' => 'lang:profile_address_postcode',
    			'field_type' => 'text',
    			'extra'		 => array('max_length' => 20)
    		),
     		'website' => array(
    			'field_name' => 'lang:profile_website',
    			'field_type' => 'url'
    		)
        );

		// Run through each column and add the field
		// metadata to it.
    	foreach($columns as $field_slug => $column)
    	{
    		// We only want fields that actually exist in the
    		// DB. The user could have deleted some of them.
    		if ($this->db->field_exists($field_slug, 'profiles'))
    		{
	    		$extra = array();
	    		$assign = array();

	    		if (isset($column['extra']))
	    		{
	    			$extra = $column['extra'];
	    		}

	    		if (isset($column['assign']))
	    		{
	    			$assign = $column['assign'];
	    		}

	    		$this->streams->utilities->convert_column_to_field('profiles', 'users', $column['field_name'], $field_slug, $column['field_type'], $extra, $assign);

	    		unset($extra);
	    		unset($assign);
    		}
    	}

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