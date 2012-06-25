<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Trin 1: Konfigurer Database og Server';
$lang['intro_text']		=	'Før vi kan tjekke databasen, skal vi vide hvor den er og hvad logininformationerne er.';

$lang['db_settings']	=	'Database Indstillinger';
$lang['db_text']		=	'For at installeren skal kunne tjekke din MySQL server version er det påkrævet at du indtaster hostnavn, brugernavn og kodeord i formularen nedenfor. Disse instillinger vil også blive brugt til installering af databasen.';
$lang['db_missing']		=	'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.'; #translate

$lang['server']			=	'Server';
$lang['username']		=	'Brugernavn';
$lang['password']		=	'Kodeord';
$lang['portnr']			=	'Port';
$lang['server_settings']=	'Server Indstillinger';
$lang['httpserver']		=	'HTTP Server';
$lang['httpserver_text']=	'PyroCMS requires a HTTP Server to display dynamic content when a user goes to your website. It looks like you already have one by the fact that you can see this page, but if know exactly which type then PyroCMS can configure itself even better. If you do not know what any of this means just ignore it and carry on with the installation.'; #translate
$lang['rewrite_fail']	=	'Du har valgt "(Apache with mod_rewrite)", men vi kan ikke se om mod_rewrite er aktiveret. Spørg din host om mod_rewrite er installeret eller installer PyroCMS på egen risiko.';
$lang['mod_rewrite']	=	'Du har valgt "(Apache with mod_rewrite)", men vi kan ikke se om mod_rewrite er aktiveret. Spørg din host om mod_rewrite er installeret eller installer PyroCMS på egen risiko.';
$lang['step2']			=	'Trin 2';

// messages
$lang['db_success']		=	'Databaseindstillingerne er testet, og fungerer.';
$lang['db_failure']		=	'Problem med at forbinde til databasen: ';

/* End of file step_1_lang.php */
