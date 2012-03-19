<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Redirects module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Redirects
 */
class Module_Redirects extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Redirects',
				'ar' => 'التوجيهات',
				'br' => 'Redirecionamentos',
				'cs' => 'Přesměrování',
				'da' => 'Omadressering',
				'el' => 'Ανακατευθύνσεις',
				'es' => 'Redirecciones',
				'fi' => 'Uudelleenohjaukset',
				'fr' => 'Redirections',
				'he' => 'הפניות',
				'id' => 'Redirect',
				'it' => 'Reindirizzi',
				'lt' => 'Peradresavimai',
				'nl' => 'Verwijzingen',
				'ru' => 'Перенаправления',
				'sl' => 'Preusmeritve',
				'zh' => '轉址',
				'hu' => 'Átirányítások',
                                'se' => 'Omdirigeringar'
			),
			'description' => array(
				'en' => 'Redirect from one URL to another.',
				'ar' => 'التوجيه من رابط URL إلى آخر.',
				'br' => 'Redirecionamento de uma URL para outra.',
				'cs' => 'Přesměrujte z jedné adresy URL na jinou.',
				'da' => 'Omadresser fra en URL til en anden.',
				'el' => 'Ανακατευθείνετε μια διεύθυνση URL σε μια άλλη',
				'es' => 'Redireccionar desde una URL a otra',
				'fi' => 'Uudelleenohjaa käyttäjän paikasta toiseen.',
				'fr' => 'Redirection d\'une URL à un autre.',
				'he' => 'הפניות מכתובת אחת לאחרת',
				'id' => 'Redirect dari satu URL ke URL yang lain.',
				'it' => 'Reindirizza da una URL ad un altra.',
				'lt' => 'Peradresuokite puslapį iš vieno adreso (URL) į kitą.',
				'nl' => 'Verwijs vanaf een URL naar een andere.',
				'ru' => 'Перенаправления с одного адреса на другой.',
				'sl' => 'Preusmeritev iz enega URL naslova na drugega',
				'zh' => '將網址轉址、重新定向。',
				'hu' => 'Egy URL átirányítása egy másikra.',
                                'se' => 'Omdirigera från en URL till en annan.'
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

	public function install()
	{
		$this->dbforge->drop_table('redirects');

		$tables = array(
			'redirects' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'from' => array('type' => 'VARCHAR', 'constraint' => 250, 'key' => 'request'),
				'to' => array('type' => 'VARCHAR', 'constraint' => 250,),
			),
		);

		if ( ! $this->install_tables($tables))
		{
			return false;
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