<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Žingsnis 1: sukonfiguruokite duomenų bazę bei serverį';
$lang['intro_text']		=	'Prieš patikrinant duomenų bazę, privalome žinoti kur ji yra bei prisijungimo duomenys.';

$lang['db_settings']	=	'Duomenų bazės nustatymai';
$lang['db_text']		=	'Kad instaliavimo vedlys galetu patikrinti MySQL serverio versija, privalote irašyti adresą, vartotoją bei slaptažodi. Šie duomenys taip pat bus naudojami irašant duomenų bazę.';
$lang['db_missing']		=	'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.'; #translate

$lang['server']			=	'Serveris';
$lang['username']		=	'Vartotojas';
$lang['password']		=	'Slaptažodis';
$lang['portnr']			=	'Portas';
$lang['server_settings']=	'Serverio nustatymai';
$lang['httpserver']		=	'HTTP Serveris';
$lang['httpserver_text']=	'PyroCMS requires a HTTP Server to display dynamic content when a user goes to your website. It looks like you already have one by the fact that you can see this page, but if know exactly which type then PyroCMS can configure itself even better. If you do not know what any of this means just ignore it and carry on with the installation.'; #translate
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']			=	'Žingsnis 2';

// messages
$lang['db_success']		=	'Duomenų bazės nustatymai buvo sėkmingai patikrinti.';
$lang['db_failure']		=	'Problema susijungiant su duomenu baze:: ';

/* End of file step_1_lang.php */
