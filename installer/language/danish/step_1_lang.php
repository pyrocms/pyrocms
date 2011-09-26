<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Trin 1: Konfigurer Database og Server';
$lang['intro_text']		=	'Før vi kan tjekke databasen, skal vi vide hvor den er og hvad logininformationerne er.';

$lang['db_settings']	=	'Database Indstillinger';
$lang['db_text']		=	'For at installeren skal kunne tjekke din MySQL server version er det påkrævet at du indtaster hostnavn, brugernavn og kodeord i formularen nedenfor. Disse instillinger vil også blive brugt til installering af databasen.';

$lang['server']			=	'Server';
$lang['username']		=	'Brugernavn';
$lang['password']		=	'Kodeord';
$lang['portnr']			=	'Port';
$lang['server_settings']=	'Server Indstillinger';
$lang['httpserver']		=	'HTTP Server';
$lang['rewrite_fail']	=	'Du har valgt "(Apache with mod_rewrite)", men vi kan ikke se om mod_rewrite er aktiveret. Spørg din host om mod_rewrite er installeret eller installer PyroCMS på egen risiko.';
$lang['mod_rewrite']	=	'Du har valgt "(Apache with mod_rewrite)", men vi kan ikke se om mod_rewrite er aktiveret. Spørg din host om mod_rewrite er installeret eller installer PyroCMS på egen risiko.';
$lang['step2']			=	'Trin 2';

// messages
$lang['db_success']		=	'Databaseindstillingerne er testet, og fungerer.';
$lang['db_failure']		=	'Problem med at forbinde til databasen: ';

/* End of file step_1_lang.php */