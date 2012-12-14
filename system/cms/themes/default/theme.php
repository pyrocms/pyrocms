<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Default extends Theme {

    public $name			= 'PyroCMS Theme';
    public $author			= 'iKreativ';
    public $author_website	= 'http://ikreativ.com/';
    public $website			= 'http://pyrocms.com/';
    public $description		= 'Default PyroCMS v1.0 Theme - 2 Column, Fixed width, Horizontal navigation, CSS3 styling.';
    public $version			= '1.0.0';
	public $options 		= array('show_breadcrumbs' => 	array('title' 		=> 'Show Breadcrumbs',
																'description'   => 'Would you like to display breadcrumbs?',
																'default'       => 'yes',
																'type'          => 'radio',
																'options'       => 'yes=Yes|no=No',
																'is_required'   => true),
									'layout' => 			array('title' => 'Layout',
																'description'   => 'Which type of layout shall we use?',
																'default'       => '2 column',
																'type'          => 'select',
																'options'       => '2 column=Two Column|full-width=Full Width|full-width-home=Full Width Home Page',
																'is_required'   => true),
									'cufon_enabled' => 		array('title'		=> 'Use Cufon',
																'description' 	=> 'Would you like to use Cufon for titles?',
																'default'       => 'yes',
																'type'          => 'radio',
																'options'       => 'yes=Yes|no=No',
																'is_required'   => true),
								   );

	public function __construct()
	{
		$supported_lang	= config_item('supported_languages');

		$cufon_enabled	= $supported_lang[CURRENT_LANGUAGE]['direction'] !== 'rtl';
		$cufon_font		= 'qk.font.js';

		// Translators, only if the default font is incompatible with the chars of your
		// language generate a new font (link: <http://cufon.shoqolate.com/generate/>) and add
		// your case in switch bellow. Important: use a licensed font and harmonic with design

		switch (CURRENT_LANGUAGE)
		{
			case 'zh':
				$cufon_enabled	= false;
				break;
			case 'ar':
				$cufon_enabled = false;
				break;
			case 'he':
				$cufon_enabled	= true;
			case 'ru':
				$cufon_font		= 'times.font.js';
				break;
		}

		Settings::temp('theme_default', compact('cufon_enabled', 'cufon_font'));
	}
}

/* End of file theme.php */
