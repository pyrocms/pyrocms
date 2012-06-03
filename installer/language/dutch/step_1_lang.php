<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Stap 1: Configureer de Database en de Server';
$lang['intro_text']		= 	'Voordat we de database kunnen gebruiken, moet u eerst de locatie en de inloggegevens opgeven.';

$lang['db_settings']	=	'Database Instellingen';
$lang['db_text']		=	'Om de MySQL versie te controleren is het nodig om de naam, de gebruikersnaam en het password van de server in te vullen in het onderstaande formulier. Deze instellingen zullen ook gebruikt worden voor het installeren van de database.';
$lang['db_missing']		=	'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.'; #translate

$lang['server']			=	'Server naam';
$lang['username']		=	'Gebruikersnaam';
$lang['password']		=	'Wachtwoord';
$lang['portnr']			=	'Poort';
$lang['server_settings']=	'Server Instellingen';
$lang['httpserver']		=	'HTTP Server';
$lang['httpserver_text']=	'PyroCMS heeft een HTTP Server nodig om dynamische content te weergeven wanneer een bezoeker op uw website komt. Het ziet er naar uit dat u dit al heeft omdat u deze pagina kunt zien. Als u precies weet welk type u heeft kunt u PyroCMS nog beter configureren. Anders kunt u verder gaan met de installatie.';
$lang['rewrite_fail']	=	' U heeft Apache (met mod_rewrite) geselecteerd, maar er kan niet gedetecteerd worden of mod_rewrite op uw HTTP-Server is ingeschakeld. Vraag de beheerder of mod_rewrite is ingeschakeld, of installeer dit (op eigen risico).';
$lang['mod_rewrite']	=	'U heeft Apache (met mod_rewrite) geselecteerd, maar uw HTTP-Server heeft mod_rewrite niet inschakeld.Vraag uw beheerder om dit in te schakelen, of installeer PyroCMS met de optie "Apache (zonder mod_rewrite)".';
$lang['step2']			=	'Stap 2';

// messages
$lang['db_success']		=	'De database instellingen zijn getest en werken.';
$lang['db_failure']		=	'Er heeft zich een probleem voorgedaan tijdens het verbinden met de database: ';

/* End of file step_1_lang.php */
