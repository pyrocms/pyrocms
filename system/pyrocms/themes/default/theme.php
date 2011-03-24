<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Default extends Theme {

    public $name			= 'PyroCMS Theme';
    public $author			= 'iKreativ';
    public $author_website	= 'http://ikreativ.com/';
    public $website			= 'http://pyrocms.com/';
    public $description		= 'Default PyroCMS v1.0 Theme - 2 Column, Fixed width, Horizontal navigation, CSS3 styling.';
    public $version			= '1.0';

	public function __construct()
	{
		// Translators, only if the default font is incompatible with the chars of your 
		// language generate a new font (link: <http://cufon.shoqolate.com/generate/>) and add
		// your case in switch bellow. Important: use a licensed font and harmonic with design

		switch (CURRENT_LANGUAGE)
		{
			/*case 'xx':
				$font_script = 'xx.font.js';
				break;*/
			default:
				$font_script = 'qk.font.js';
				break;
		}

		Settings::set('theme_default', array(
			'cufon_font' => $font_script
		));
	}

}

/* End of file theme.php */