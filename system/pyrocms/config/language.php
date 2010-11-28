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
	'en'=> array('name' => 'English', 'folder' => 'english', 'direction' => 'ltr'),
	'es'=> array('name' => 'Espa&ntilde;ol', 'folder' => 'spanish', 'direction' => 'ltr'),
	'fr'=> array('name' => 'Français', 'folder' => 'french', 'direction' => 'ltr'),
	'de'=> array('name' => 'Deutsch', 'folder' => 'german', 'direction' => 'ltr'),
	'it'=> array('name' => 'Italiano', 'folder' => 'italian', 'direction' => 'ltr'),
	'nl'=> array('name' => 'Nederlands', 'folder' => 'dutch', 'direction' => 'ltr'),
	'pl'=> array('name' => 'Polski', 'folder' => 'polish', 'direction' => 'ltr'),
	'br'=> array('name' => 'Portugu&ecirc;s do Brasil', 'folder' => 'brazilian', 'direction' => 'ltr'),
	'ru'=> array('name' => 'Русский', 'folder' => 'russian', 'direction' => 'ltr'),
	'ar'=> array('name' => 'العربية', 'folder' => 'arabic', 'direction' => 'rtl'),
	'zh'=> array('name' => '繁體中文', 'folder' => 'chinese_traditional', 'direction' => 'ltr')
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
