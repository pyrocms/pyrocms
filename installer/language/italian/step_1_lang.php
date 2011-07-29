<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Passo 1: Configura Database e Server';
$lang['intro_text']		=	'Prima di verificare il database, abbiamo bisogno di sapere dov\' è e quali sono i parametri di accesso.';

$lang['db_settings']	=	'Impostazioni del Database';
$lang['db_text']		=	'Per verificare la versione del tuo server MySQL devi inserire hostname, username e password nel modulo sottostante. Questi parametri saranno inoltre usati per installare il database.';

$lang['server']			=	'Server';
$lang['username']		=	'Username';
$lang['password']		=	'Password';
$lang['portnr']			=	'Porta';
$lang['server_settings']=	'Impostazioni Server';
$lang['httpserver']		=	'HTTP Server';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']			=	'Passo 2';

// messages
$lang['db_success']		=	'Le impostazioni del database sono state testate e funzionano correttamente.';
$lang['db_failure']		=	'Problemi di connessione al database: ';
