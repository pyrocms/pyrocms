<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Korak 1: Vnesite dostopne podatke za podatkovno bazo in strežnik';
$lang['intro_text']		=	'Pred preveritivjo podatkovne baze, potrebujemo podatke za prijavo za podatkovno bazo';

$lang['db_settings']	=	'Namestitev podatkovne baze (MYSQL DB)';
$lang['db_text']		=	'Da bo lahko Installer preveril verzijo MYSQL strežnika je potrebno, da vnesete pot do MYSQL strežnika (ponavadi: localhost) MYSQL uporabnika ter geslo uporabnika. Ti podatki bodo uporabljeni tudi pri namestitvi podatkov v podatkovno bazo.';

$lang['server']			=	'Strežnik';
$lang['username']		=	'DB Uporabnik';
$lang['password']		=	'Geslo';
$lang['portnr']			=	'Port';
$lang['server_settings']=	'Podatki strežnika';
$lang['httpserver']		=	'HTTP Strežnik';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']			=	'Korak 2';

// messages
$lang['db_success']		=	'Podatki za povezavo s podatkovo bazo so bili preverjeni in vse pravilno deluje.';
$lang['db_failure']		=	'Na podatkovno bazo se ni mogoče povezati: ';

/* End of file step_1_lang.php */
/* Location: ./installer/language/slovenian/step_1_lang.php */
