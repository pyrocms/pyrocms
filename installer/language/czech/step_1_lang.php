<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Krok 1: Konfigurace databáze a serveru';
$lang['intro_text']		=	'Než budeme moci zkontrolovat databázi, potřebujeme znát kde je umístěna a přihlašovací údaje.';

$lang['db_settings']	=	'Nastavení databáze';
$lang['db_text']		=	'Aby mohl instalátor zkontrolovat váš MySQL server, musíte vložit adresu serveru, uživatelské jméno a heslo. Toto nastavení bude použito i při instalaci databáze.';

$lang['server']			=	'Server';
$lang['username']		=	'Uživatelské jméno';
$lang['password']		=	'Heslo';
$lang['portnr']			=	'Port';
$lang['server_settings']=	'Nestavení serveru';
$lang['httpserver']		=	'HTTP Server';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']			=	'Krok 2';

// messages
$lang['db_success']		=	'Nastavení databáze bylo ověřeno a pracuje správně';
$lang['db_failure']		=	'Problém s připojením k databázi: ';

/* End of file step_1_lang.php */
/* Location: ./installer/language/english/step_1_lang.php */
