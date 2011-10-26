<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Stap 1: Configureer de Database en de Server';
$lang['intro_text']		= 	'Voordat we de database kunnen gebruiken, moet u eerst de locatie en de inloggegevens opgeven.';

$lang['db_settings']	=	'Database Instellingen';
$lang['db_text']		=	'Om de MySQL versie te controleren is het nodig om de naam, de gebruikersnaam en het password van de server in te vullen in het onderstaande formulier. Deze instellingen zullen ook gebruikt worden voor het installeren van de database.';

$lang['server']			=	'Server naam';
$lang['username']		=	'Gebruikersnaam';
$lang['password']		=	'Wachtwoord';
$lang['portnr']			=	'Poort';
$lang['server_settings']=	'Server Instellingen';
$lang['httpserver']		=	'HTTP Server';
$lang['httpserver_text']=	'PyroCMS requires a HTTP Server to display dynamic content when a user goes to your website. It looks like you already have one by the fact that you can see this page, but if know exactly which type then PyroCMS can configure itself even better. If you do not know what any of this means just ignore it and carry on with the installation.'; #translate
$lang['rewrite_fail']	=	' U heeft Apache (met mod_rewrite) geselecteerd, maar er kan niet gedetecteerd worden of mod_rewrite op uw HTTP-Server is ingeschakeld. Vraag de beheerder of mod_rewrite is ingeschakeld, of installeer dit (op eigen risico).';
$lang['mod_rewrite']	=	'U heeft Apache (met mod_rewrite) geselecteerd, maar uw HTTP-Server heeft mod_rewrite niet inschakeld.Vraag uw beheerder om dit in te schakelen, of installeer PyroCMS met de optie "Apache (zonder mod_rewrite)".';
$lang['step2']			=	'Stap 2';

// messages
$lang['db_success']		=	'De database instellingen zijn getest en werken.';
$lang['db_failure']		=	'Er heeft zich een probleem voorgedaan tijdens het verbinden met de database: ';

/* End of file step_1_lang.php */