<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Korak 1: Vnesite dostopne podatke za podatkovno bazo in strežnik';
$lang['intro_text']		=	'Pred preveritvijo podatkovne baze, potrebujemo podatke za prijavo za podatkovno bazo';

$lang['db_settings']	=	'Namestitev podatkovne baze (MYSQL DB)';
$lang['db_text']		=	'Da bo lahko Installer preveril verzijo MYSQL strežnika je potrebno, da vnesete pot do MYSQL strežnika (ponavadi: localhost) MYSQL uporabnika ter geslo uporabnika. Ti podatki bodo uporabljeni tudi pri namestitvi podatkov v podatkovno bazo.';
$lang['db_missing']		=	'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.'; #translate

$lang['server']			=	'Strežnik';
$lang['username']		=	'DB Uporabnik';
$lang['password']		=	'Geslo';
$lang['portnr']			=	'Port';
$lang['server_settings']=	'Podatki strežnika';
$lang['httpserver']		=	'HTTP Strežnik';
$lang['httpserver_text']=	'PyroCMS potrebuje za prikaz dinamičnih vsebin obiskovalcem vaše spletne strani HTTP strežnik. Glede na to da vidite trenutno stran, imate takšen strežnik že nameščen, če pa veste kakšnega, potem bo PyroCMS znal izbrati strežniku bolj primerne nastavitve. V primeru, da ne veste kaj izbrati v spodnjem obrazcu, lahko izbiro preskočite in nadaljujete na naslednji korak.';
$lang['rewrite_fail']	=	'Izbrali ste "(Apache z mod_rewrite)" ampak ne moremo določiti če je mod_rewrite omogočen na vašem strežniku. Vprašajte vašega gostitelja če mod_rewrite deluje ali pa preposto namesite na vašo lastno odgovornost.';
$lang['mod_rewrite']	=	'Izbrali ste "(Apache z mod_rewrite)" vendar pa ga vaš strežnik nima omogočenega.Vprašajte vašega gostitelja če ga lahko omogoči ali pa namesite PyroCMS z uporabo "Apache (brez mod_rewrite)" opcije.';
$lang['step2']			=	'Korak 2';

// messages
$lang['db_success']		=	'Podatki za povezavo s podatkovo bazo so bili preverjeni in vse pravilno deluje.';
$lang['db_failure']		=	'Na podatkovno bazo se ni mogoče povezati: ';

/* End of file step_1_lang.php */
