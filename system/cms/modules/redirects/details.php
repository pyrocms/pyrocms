<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Redirects module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Redirects
 */
class Module_Redirects extends Module
{
	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Redirects',
				'ar' => 'التوجيهات',
				'br' => 'Redirecionamentos',
				'pt' => 'Redirecionamentos',
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
				'tw' => '轉址',
				'cn' => '转址',
				'hu' => 'Átirányítások',
				'pl' => 'Przekierowania',
				'th' => 'เปลี่ยนเส้นทาง',
				'se' => 'Omdirigeringar',
			),
			'description' => array(
				'en' => 'Redirect from one URL to another.',
				'ar' => 'التوجيه من رابط URL إلى آخر.',
				'br' => 'Redirecionamento de uma URL para outra.',
				'pt' => 'Redirecionamentos de uma URL para outra.',
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
				'tw' => '將網址轉址、重新定向。',
				'cn' => '将网址转址、重新定向。',
				'hu' => 'Egy URL átirányítása egy másikra.',
				'pl' => 'Przekierowanie z jednego adresu URL na inny.',
				'th' => 'เปลี่ยนเส้นทางจากที่หนึ่งไปยังอีกที่หนึ่ง',
				'se' => 'Omdirigera från en URL till en annan.',
			),
			'frontend' => false,
			'backend'  => true,
			'menu'	  => 'structure',

			'shortcuts' => array(
				array(
				    'name' => 'redirects:add_title',
				    'uri' => 'admin/redirects/add',
				    'class' => 'add',
				),
		    ),
		);
	}

	public function install()
	{
		$schema = $this->pdb->getSchemaBuilder();
        $schema->dropIfExists('redirects');

        $schema->create('redirects', function($table) {
            $table->increments('id');
			$table->string('from', 250);
			$table->string('to', 250);
			$table->integer('type')->default(302);

			$table->index('from', 'request');
		});

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
