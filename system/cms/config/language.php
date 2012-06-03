<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Supported Languages
|--------------------------------------------------------------------------
|
| Contains all languages your site will store data in. Other languages can
| still be displayed via language files, thats totally different.
|
| Check for HTML equivilents for characters such as � with the URL below:
|    http://htmlhelp.com/reference/html40/entities/latin1.html
|
|
|    array('en'=> 'English', 'fr'=> 'French', 'de'=> 'German')
|
*/
$config['supported_languages'] = array(
    'en' => array(
        'name'        => 'English',
        'folder'    => 'english',
        'direction'    => 'ltr',
        'codes'        => array('en', 'english', 'en_US'),
        'ckeditor'    => NULL
    ),
    'de' => array(
        'name'        => 'Deutsch',
        'folder'    => 'german',
        'direction'    => 'ltr',
        'codes'        => array('de', 'german', 'de_DE'),
        'ckeditor'    => NULL
    ),
    'ar' => array(
        'name'        => 'العربية',
        'folder'    => 'arabic',
        'direction'    => 'rtl',
        'codes'        => array('ar', 'arabic', 'ar_SA'),
        'ckeditor'    => NULL
    ),
    'cs' => array(
        'name'        => 'Česky',
        'folder'    => 'czech',
        'direction'    => 'ltr',
        'codes'        => array('csy', 'czech', 'cs_CZ'),
        'ckeditor'    => NULL
    ),
    'el' => array(
        'name'        => 'Ελληνικά',
        'folder'    => 'greek',
        'direction'    => 'ltr',
        'codes'        => array('ell', 'greek', 'el_GR'),
        'ckeditor'    => NULL
    ),
    'es' => array(
        'name'        => 'Espa&ntilde;ol',
        'folder'    => 'spanish',
        'direction'    => 'ltr',
        'codes'        => array('esp', 'spanish', 'es_ES'),
        'ckeditor'    => NULL
    ),
    'fr' => array(
        'name'        => 'Français',
        'folder'    => 'french',
        'direction'    => 'ltr',
        'codes'        => array('fra', 'french', 'fr_FR'),
        'ckeditor'    => NULL
    ),
    'it' => array(
        'name'        => 'Italiano',
        'folder'    => 'italian',
        'direction'    => 'ltr',
        'codes'        => array('ita', 'italian', 'it_IT'),
        'ckeditor'    => NULL
    ),
    'nl' => array(
        'name'        => 'Nederlands',
        'folder'    => 'dutch',
        'direction'    => 'ltr',
        'codes'        => array('dutch', 'nld', 'nl-NL'),
        'ckeditor'    => NULL
    ),
    'se' => array(
        'name'        => 'Svenska',
        'folder'    => 'swedish',
        'direction'    => 'ltr',
        'codes'        => array('se', 'swedish', 'se_SE'),
        'ckeditor'    => NULL
    ),
    'sl' => array(
        'name'        => 'Slovensko',
        'folder'    => 'slovenian',
        'direction'    => 'ltr',
        'codes'        => array('sl', 'slovenian', 'sl_SI'),
        'ckeditor'    => NULL
    ),
    'pl' => array(
        'name'        => 'Polski',
        'folder'    => 'polish',
        'direction'    => 'ltr',
        'codes'        => array('plk', 'polish', 'pl_PL'),
        'ckeditor'    => NULL
    ),
	'pt' => array(
		'name'		=> 'Portugu&ecirc;s de Portugal',
		'folder'	=> 'portuguese',
		'direction'	=> 'ltr',
		'codes'		=> array('ptb', 'portuguese-portugal', 'pt_PT'),
		'ckeditor'	=> 'pt-pt'
	),
    'br' => array(
        'name'        => 'Portugu&ecirc;s do Brasil',
        'folder'    => 'brazilian',
        'direction'    => 'ltr',
        'codes'        => array('ptb', 'portuguese-brazil', 'pt_BR'),
        'ckeditor'    => 'pt-br'
    ),
    'ru' => array(
        'name'        => 'Русский',
        'folder'    => 'russian',
        'direction'    => 'ltr',
        'codes'        => array('rus', 'russian', 'ru_RU'),
        'ckeditor'    => NULL
    ),
    'zh' => array(
        'name'        => '繁體中文',
        'folder'    => 'chinese_traditional',
        'direction'    => 'ltr',
        'codes'        => array('cht', 'chinese-traditional', 'zh_HK'),
        'ckeditor'    => NULL
    ),
    'he' => array(
        'name'        => 'עברית',
        'folder'    => 'hebrew',
        'direction'    => 'rtl',
        'codes'        => array('he', 'hebrew', 'he_IL'),
        'ckeditor'    => NULL
    ),
    'lt' => array(
        'name'        => 'Lietuvių',
        'folder'    => 'lithuanian',
        'direction'    => 'ltr',
        'codes'        => array('lt', 'lithuanian', 'lt_LT'),
        'ckeditor'    => NULL
    ),
    'fi' => array(
        'name'        => 'Suomi',
        'folder'    => 'finnish',
        'direction'    => 'ltr',
        'codes'        => array('fi', 'finnish', 'fi_FI'),
        'ckeditor'    => NULL
    ),
    'da' => array(
        'name'        => 'Dansk',
        'folder'    => 'danish',
        'direction'    => 'ltr',
        'codes'        => array('da', 'danish', 'da_DK'),
        'ckeditor'    => NULL
    ),
    'id' => array(
        'name'        => 'Bahasa Indonesia',
        'folder'    => 'indonesian',
        'direction'    => 'ltr',
        'codes'        => array('id', 'indonesian' ,'id_ID'),
        'ckeditor'    => NULL
    ),
    'hu' => array(
        'name'          => 'Magyar',
        'folder'        => 'hungarian',
        'direction'     => 'ltr',
        'codes'         => array('hu', 'hu_HU'),
        'ckeditor'      => NULL
    ),
    'th' => array(
        'name'        => 'ไทย',
        'folder'    => 'thai',
        'direction'    => 'ltr',
        'codes'        => array('th', 'thai', 'th_TH'),
        'ckeditor'    => NULL
    )
);

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| If no language is specified, which one to use? Must be in the array above
|
|    en
|
*/
$config['default_language'] = 'en';
