<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Stap 2: Controleer requirements';
$lang['intro_text']		= 	'De eerste stap in het installatie proces is het controleren of PyroCMS word ondersteund door de server. De meeste servers ondersteunen PyroCMS.';

$lang['server_settings']= 	'HTTP Server Settings';
$lang['server_version']	=	'De server software:';
$lang['server_fail']	=	'De server software word niet ondersteund. PyroCMS werkt mogelijk alsnog zolang de PHP en de MySQL installatie up to date zijn, echter zonder clean URL\'s.';

$lang['php_settings']	=	'PHP Settings';
$lang['php_required']	=	'PyroCMS vereist PHP versie 5.0 of hoger.';
$lang['php_version']	=	'Uw server draait momenteel verie';
$lang['php_fail']		=	'Uw PHP versie word niet ondersteund. PyroCMS vereist PHP versie 5.0 of hoger om probleemloos te functioneren.';

$lang['mysql_settings']	=	'MySQL Settings';
$lang['mysql_required']	=	'PyroCMS vereist toegang tot een MySQL database die versie 5.0 of hoger draait.';
$lang['mysql_version1']	=	'Uw server draait momenteel versie';
$lang['mysql_version2']	=	'Uw client draait momenteel versie';
$lang['mysql_fail']		=	'Uw MySQL versie word niet ondersteund. PyroCMS vereist MySQL versie 5.0 of hoger om probleemloos te funcitoneren.';

$lang['gd_settings']	=	'GD Settings';
$lang['gd_required']	= 	'PyroCMS vereist GD library 1.0 of hoger om afbeeldingen te bewerken.';
$lang['gd_version']		= 	'Uw server draait momenteel versie';
$lang['gd_fail']		=	'We kunnen niet vaststellen welke versie van de GD Library is geinstalleerd. Dit betekend meestal dat de GD Library niet is geinstalleerd. PyroCMS zal nog steeds functioneren echter sommige functionaliteit werkt waarschijnlijk niet. Het word sterk aangeraden om de GD Library te activeren.';

$lang['summary_green']	=	'Uw server voldoet aan alle requirements voor PyroCMS. Ga naar de volgende stap door op de knop hieronder te clicken.';
$lang['summary_orange']	=	'Uw server voldoet aan de <em>meeste</em> requirements voor PyroCMS. Dit betekent dat PyroCMS nog steeds zal functioneren, echter er bestaat een kans dat U problemen tegenkomt met afbeeldingen resizen of het maken van thumbnails.';
$lang['summary_red']	=	'Uw server voldoet niet aan de requirements voor PyroCMS. Neem a.u.b. contact op met uw server beheerder of uw hosting partij om dit op te lossen.';
$lang['next_step']		=	'Ga naar de volgende stap';
$lang['step3']			=	'Stap 3';
$lang['retry']			=	'Probeer opnieuw';

// messages
$lang['step1_failure']	=	'U moet de benodigde database settings in het formulier hieronder invullen.';
