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
|	array('en'=> 'English', 'fr'=> 'French', 'de'=> 'German')
|
*/
$config['supported_languages'] = array(
	'en'=> array('name' => 'English', 'folder' => 'english', 'direction' => 'ltr', 'codes' => array('english', 'en_US')),
	'es'=> array('name' => 'Espa&ntilde;ol', 'folder' => 'spanish', 'direction' => 'ltr', 'codes' => array('esp', 'es_ES')),
	'fr'=> array('name' => 'Français', 'folder' => 'french', 'direction' => 'ltr', 'codes' => array('fra', 'fr_FR')),
	'de'=> array('name' => 'Deutsch', 'folder' => 'german', 'direction' => 'ltr', 'codes' => array('deu', 'de_DE')),
	'it'=> array('name' => 'Italiano', 'folder' => 'italian', 'direction' => 'ltr', 'codes' => array('ita', 'it_IT')),
	'nl'=> array('name' => 'Nederlands', 'folder' => 'dutch', 'direction' => 'ltr', 'codes' => array(/*set it for php locale*/)),
	'pl'=> array('name' => 'Polski', 'folder' => 'polish', 'direction' => 'ltr', 'codes' => array(/*set it for php locale*/)),
	'pt'=> array('name' => 'Portugu&ecirc;s do Brasil', 'folder' => 'brazilian', 'direction' => 'ltr', 'codes' => array('ptb', 'pt_BR')),
	'ru'=> array('name' => 'Русский', 'folder' => 'russian', 'direction' => 'ltr', 'codes' => array(/*set it for php locale*/)),
	'ar'=> array('name' => 'العربية', 'folder' => 'arabic', 'direction' => 'rtl', 'codes' => array(/*set it for php locale*/)),
	'zh'=> array('name' => '繁體中文', 'folder' => 'chinese_traditional', 'direction' => 'ltr', 'codes' => array(/*set it for php locale*/)),
	'cs'=> array('name' => 'Česky', 'folder' => 'czech', 'direction' => 'ltr', 'codes' => array(/*set it for php locale*/))
);

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| If no language is specified, which one to use? Must be in the array above
|
|	en
|
*/
$config['default_language'] = 'en';
