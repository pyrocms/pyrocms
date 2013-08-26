<?php

use Pyro\Module\Addons\AbstractModule;

/**
 * Variables Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Variables
 */
class Module_Variables extends AbstractModule
{
	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Variables',
				'ar' => 'المتغيّرات',
				'br' => 'Variáveis',
				'pt' => 'Variáveis',
				'cs' => 'Proměnné',
				'da' => 'Variable',
				'de' => 'Variablen',
				'el' => 'Μεταβλητές',
				'es' => 'Variables',
                'fa' => 'متغییرها',
				'fi' => 'Muuttujat',
				'fr' => 'Variables',
				'he' => 'משתנים',
				'id' => 'Variabel',
				'it' => 'Variabili',
				'lt' => 'Kintamieji',
				'nl' => 'Variabelen',
				'pl' => 'Zmienne',
				'ru' => 'Переменные',
				'sl' => 'Spremenljivke',
				'tw' => '系統變數',
				'cn' => '系统变数',
				'th' => 'ตัวแปร',
				'se' => 'Variabler',
				'hu' => 'Változók',
			),
			'description' => array(
				'en' => 'Manage global variables that can be accessed from anywhere. ',
				'ar' => 'إدارة المُتغيّرات العامة لاستخدامها في أرجاء الموقع.',
				'br' => 'Gerencia as variáveis globais acessíveis de qualquer lugar.',
				'pt' => 'Gerir as variáveis globais acessíveis de qualquer lugar.',
				'cs' => 'Spravujte globální proměnné přístupné odkudkoliv.',
				'da' => 'Håndtér globale variable som kan tilgås overalt.',
				'de' => 'Verwaltet globale Variablen, auf die von überall zugegriffen werden kann.',
				'el' => 'Διαχείριση μεταβλητών που είναι προσβάσιμες από παντού στον ιστότοπο.',
				'es' => 'Manage global variables to access from everywhere.',
                            'fa' => 'مدیریت متغییر های جامع که می توانند در هر جای سایت مورد استفاده قرار بگیرند',
				'fi' => 'Hallitse globaali muuttujia, joihin pääsee käsiksi mistä vain.',
				'fr' => 'Gérer des variables globales pour pouvoir y accéder depuis n\'importe quel endroit du site.',
				'he' => 'ניהול משתנים גלובליים אשר ניתנים להמרה בכל חלקי האתר',
				'id' => 'Mengatur variabel global yang dapat diakses dari mana saja.',
				'it' => 'Gestisci le variabili globali per accedervi da ogni parte.',
				'lt' => 'Globalių kintamujų tvarkymas kurie yra pasiekiami iš bet kur.',
				'nl' => 'Beheer globale variabelen die overal beschikbaar zijn.',
				'pl' => 'Zarządzaj globalnymi zmiennymi do których masz dostęp z każdego miejsca aplikacji.',
				'ru' => 'Управление глобальными переменными, которые доступны в любом месте сайта.',
				'sl' =>	'Urejanje globalnih spremenljivk za dostop od kjerkoli',
				'th' => 'จัดการตัวแปรทั่วไปโดยที่สามารถเข้าถึงได้จากทุกที่.',
				'tw' => '管理此網站內可存取的全局變數。',
				'cn' => '管理此网站内可存取的全局变数。',
				'hu' => 'Globális változók kezelése a hozzáféréshez, bárhonnan.',
				'se' => 'Hantera globala variabler som kan avändas över hela webbplatsen.',

			),
			'frontend'	=> false,
			'backend'	=> true,
			'menu'		=> 'data',

			'sections' => array(
				'variables' => array(
					'name' => 'variables:name',
					'uri' => 'admin/variables',
					'shortcuts' => array(
						array(
							'name' => 'global:add',
							'uri' => 'admin/variables/create',
							'class' => 'add',
						),
					),
				),
				'fields' => array(
					'name' => 'streams:fields',
					'uri' => 'admin/variables/fields',
					'shortcuts' => array(
						array(
							'name' => 'streams:add_field',
							'uri' => 'admin/variables/fields/create',
							'class' => 'add',
						),
					),
				),
			),

		);
	}

	public function install($pdb, $schema)
	{
		ci()->load->driver('Streams');

		ci()->streams->utilities->remove_namespace('variables');

		ci()->lang->load('variables/variables');

		if ( ! ci()->type->load_single_type('field'))
		{
			ci()->session->set_flashdata('notice', lang('variables:field_field_type_required'));
			
			return false;
		}

		ci()->streams->streams->add_stream('lang:variables:name', 'variables', 'variables');

        // Create the Variables folder. For the image field
        $folder_id = $pdb->table('file_folders')->insertGetId(array(
            'parent_id' => 0,
            'slug' => 'variables',
            'name' => 'lang:variables:variables',
            'location' => 'local',
            'remote_container' => '',
            'date_added' => time(),
            'sort' => time(),
            'hidden' => 1,
        ));

		$fields = array(
			// Fields assigned to Variables
			array(
				'name'			=> 'lang:variables:name_label',
				'slug'			=> 'name',
				'type'			=> 'slug',
				'title_column'	=> true,
				'required'		=> true,
				'unique'		=> true,
				'namespace'		=> 'variables',
				'assign'		=> 'variables',
				'extra'			=> array('max_length' => 100),
			),
			array(
				'name'			=> 'lang:variables:data_label',
				'slug'			=> 'data',
				'type'			=> 'field',
				'required'		=> true,
				'namespace'		=> 'variables',
				'assign'		=> 'variables',
				'extra'			=> array('max_length' => 100, 'namespace' => 'variables', 'field_slug' => 'data'),
			),
			array(
				'name'			=> 'lang:variables:syntax_label',
				'slug'			=> 'syntax',
				'type'			=> 'merge_tags',
				'namespace'		=> 'variables',
				'assign'		=> 'variables',
				'extra'			=> 
					array('pattern' => '<span class="syntax">&#123;&#123; variables:{{ name }} &#125;&#125;</span>'),
			),
		    // A default set of selectable fields
			array('namespace' => 'variables','name' => 'lang:streams:country.name','slug' => 'country','type' => 'country'),
			array('namespace' => 'variables','name' => 'lang:streams:datetime.name','slug' => 'datetime','type' => 'datetime', 'extra' => array('use_time' => 'no', 'storage' => 'datetime', 'input_type' => 'dropdown')),
			array('namespace' => 'variables','name' => 'lang:streams:email.name','slug' => 'email','type' => 'email'),
			array('namespace' => 'variables','name' => 'lang:streams:encrypt.name','slug' => 'encrypt','type' => 'encrypt', 'extra' => array('hide_typing' => 'yes')),
			array('namespace' => 'variables','name' => 'lang:streams:image.name','slug' => 'image','type' => 'image', 'extra' => array('folder' => $folder_id)),
			array('namespace' => 'variables','name' => 'lang:streams:integer.name','slug' => 'number','type' => 'integer'),
			array('namespace' => 'variables','name' => 'lang:streams:keywords.name','slug' => 'keywords','type' => 'keywords'),
			array('namespace' => 'variables','name' => 'lang:streams:pyro_lang.name','slug' => 'pyro_lang','type' => 'pyro_lang'),
			array('namespace' => 'variables','name' => 'lang:streams:state.name','slug' => 'state','type' => 'state'),
			array('namespace' => 'variables','name' => 'lang:streams:text.name','slug' => 'text','type' => 'text'),
			array('namespace' => 'variables','name' => 'lang:streams:textarea.name','slug' => 'textarea','type' => 'textarea', 'extra' => array('allow_tags' => 'yes', 'content_type' => 'md')),
			array('namespace' => 'variables','name' => 'lang:streams:url.name','slug' => 'url','type' => 'url'),
			array('namespace' => 'variables','name' => 'lang:streams:user.name','slug' => 'user','type' => 'user'),
			array('namespace' => 'variables','name' => 'lang:streams:wysiwyg.name','slug' => 'wysiwyg','type' => 'wysiwyg', 'extra' => array('editor_type' => 'advanced', 'allow_tags' => 'y')),
		);

		ci()->streams->fields->add_fields($fields);
		
		$update_data = array(
		    'view_options'  => array('name', 'data', 'syntax')
		);

		ci()->streams->streams->update_stream('variables', 'variables', $update_data);

		return true;
	}

    public function uninstall($pdb, $schema)
    {
        // This is a core module, lets keep it around.
        return false;
    }

    public function upgrade($old_version)
    {
        return true;
    }
}