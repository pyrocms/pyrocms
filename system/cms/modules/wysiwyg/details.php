<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Widgets Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Widgets
 */
class Module_WYSIWYG extends Module
{

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'WYSIWYG',
                                'se' => 'HTML-redigerare'
			),
			'description' => array(
				'en' => 'Provides the WYSIWYG editor for PyroCMS powered by CKEditor.',
				'el' => 'Παρέχει τον επεξεργαστή WYSIWYG για το PyroCMS, χρησιμοποιεί το CKEDitor.',
                                'se' => 'Redigeringsmodul för HTML, CKEditor.'
			),
			'frontend' => false,
			'backend' => false,
		);
	}

	public function install()
	{
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