<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Redirects module
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Redirects 
 */
class Module_Redirects extends Module {

	public $version = '1.0';
	
	/**
	 * The modules tables.
	 *
	 * @var array
	 */
	public $tables = array(
		'redirects' => array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
			'from' => array('type' => 'VARCHAR', 'constraint' => 250, 'key' => 'request'),
			'to' => array('type' => 'VARCHAR', 'constraint' => 250,),
		),
	);

	public function info()
	{
		return array(
			'name' => array(
				'sl' => 'Preusmeritve',
				'nl' => 'Verwijzingen',
				'en' => 'Redirects',
				'es' => 'Redirecciones',
				'fr' => 'Redirections',
				'it' => 'Reindirizzi',
				'ru' => 'Перенаправления',
				'ar' => 'التوجيهات',
				'br' => 'Redirecionamentos',
				'cs' => 'Přesměrování',
				'fi' => 'Uudelleenohjaukset',
				'el' => 'Ανακατευθύνσεις',
				'he' => 'הפניות',
				'lt' => 'Peradresavimai',
				'da' => 'Omadressering',
				'zh' => '轉址',
				'id' => 'Redirect'
			),
			'description' => array(
				'sl' => 'Preusmeritev iz enega URL naslova na drugega',
				'nl' => 'Verwijs vanaf een URL naar een andere.',
				'en' => 'Redirect from one URL to another.',
				'es' => 'Redireccionar desde una URL a otra',
				'fr' => 'Redirection d\'une URL à un autre.',
				'it' => 'Reindirizza da una URL ad un altra.',
				'ru' => 'Перенаправления с одного адреса на другой.',
				'ar' => 'التوجيه من رابط URL إلى آخر.',
				'br' => 'Redirecionamento de uma URL para outra.',
				'cs' => 'Přesměrujte z jedné adresy URL na jinou.',
				'fi' => 'Uudelleenohjaa käyttäjän paikasta toiseen.',
				'el' => 'Ανακατευθείνετε μια διεύθυνση URL σε μια άλλη',
				'he' => 'הפניות מכתובת אחת לאחרת',
				'lt' => 'Peradresuokite puslapį iš vieno adreso (URL) į kitą.',
				'da' => 'Omadresser fra en URL til en anden.',
				'zh' => '將網址轉址、重新定向。',
				'id' => 'Redirect dari satu URL ke URL yang lain.'
			),
			'frontend' => false,
			'backend'  => true,
			'menu'	  => 'utilities',
			
			'shortcuts' => array(
				array(
				    'name' => 'redirects.add_title',
				    'uri' => 'admin/redirects/add',
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