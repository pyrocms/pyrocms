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
$lang['httpserver_text']=	'PyroCMS requires a HTTP Server to display dynamic content when a user goes to your website. It looks like you already have one by the fact that you can see this page, but if know exactly which type then PyroCMS can configure itself even better. If you do not know what any of this means just ignore it and carry on with the installation.'; #translate
$lang['rewrite_fail']	=	'Izbrali ste "(Apache z mod_rewrite)" ampak ne moremo določiti če je mod_rewrite omogočen na vašem strežniku. Vprašajte vašega gostitelja če mod_rewrite deluje ali pa preposto namesite na vašo lastno odgovornost.';
$lang['mod_rewrite']	=	'Izbrali ste "(Apache z mod_rewrite)" vendar pa ga vaš strežnik nima omogočenega.Vprašajte vašega gostitelja če ga lahko omogoči ali pa namesite PyroCMS z uporabo "Apache (brez mod_rewrite)" opcije.';
$lang['step2']			=	'Korak 2';

// messages
$lang['db_success']		=	'Podatki za povezavo s podatkovo bazo so bili preverjeni in vse pravilno deluje.';
$lang['db_failure']		=	'Na podatkovno bazo se ni mogoče povezati: ';

/* End of file step_1_lang.php */
