<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Keywords extends Module {

	public $version = '1.0';

	/**
	 * The modules tables.
	 *
	 * @var array
	 */
	public $tables = array(
		'keywords' => array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
			'name' => array('type' => 'VARCHAR', 'constraint' => 50,),
		),
		'keywords_applied' => array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
			'hash' => array('type' => 'CHAR', 'constraint' => 32, 'default' => '',),
			'keyword_id' => array('type' => 'INT', 'constraint' => 11,),
		),
	);
	
	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Keywords',
				'el' => 'Λέξεις Κλειδιά',
				'fr' => 'Mots-Clés',
				'nl' => 'Sleutelwoorden',
				'ar' => 'Keywords',
				'br' => 'Palavras-chave',
				'ar' => 'كلمات البحث',
				'da' => 'Nøgleord',
				'zh' => '鍵詞',
				'id' => 'Kata Kunci'
			),
			'description' => array(
				'en' => 'Maintain a central list of keywords to label and organize your content.',
				'el' => 'Συντηρεί μια κεντρική λίστα από λέξεις κλειδιά για να οργανώνετε μέσω ετικετών το περιεχόμενό σας.',
				'fr' => 'Maintenir une liste centralisée de Mots-Clés pour libeller et organiser vos contenus.',
				'nl' => 'Beheer een centrale lijst van sleutelwoorden om uw content te categoriseren en organiseren.',
				'ar' => 'Maintain a central list of keywords to label and organize your content.',
				'br' => 'Mantém uma lista central de palavras-chave para rotular e organizar o seu conteúdo.',
				'ar' => 'أنشئ مجموعة من كلمات البحث التي تستطيع من خلالها وسم وتنظيم المحتوى.',
				'da' => 'Vedligehold en central liste af nøgleord for at organisere dit indhold.',
				'zh' => '集中管理可用於標題與內容的鍵詞(keywords)列表。',
				'id' => 'Memantau daftar kata kunci untuk melabeli dan mengorganisasikan konten.'
			),
			'frontend' => FALSE,
			'backend'  => TRUE,
			'menu'     => 'content',
			
			'shortcuts' => array(
				array(
			 	   'name' => 'keywords:add_title',
				   'uri' => 'admin/keywords/add',
				   'class' => 'add'
				),
			),
		);
	}

	public function uninstall()
	{
		//it's a core module, lets keep it around
		return false;
	}

	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return true;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return true;
	}
}