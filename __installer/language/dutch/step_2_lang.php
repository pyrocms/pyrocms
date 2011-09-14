<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Stap 2: Controleer benodigdheden';
$lang['intro_text']		= 	'De eerste stap in het installatie proces is het controleren of PyroCMS wordt ondersteund door de server. De meeste servers ondersteunen PyroCMS.';
$lang['mandatory']		= 	'Verplicht';
$lang['recommended']	= 	'Aangeraden';

$lang['server_settings']= 	'HTTP Server Instellingen';
$lang['server_version']	=	'De server software:';
$lang['server_fail']	=	'De server software word niet ondersteund. PyroCMS werkt mogelijk als de PHP en de MySQL installatie up-to-date zijn, echter zonder clean URL\'s.';

$lang['php_settings']	=	'PHP Settings';
$lang['php_required']	=	'PyroCMS vereist PHP versie %s of hoger.';
$lang['php_version']	=	'Uw server draait momenteel verie';
$lang['php_fail']		=	'Uw PHP versie wordt niet ondersteund. PyroCMS vereist PHP versie %s of hoger om probleemloos te functioneren.';

$lang['mysql_settings']	=	'MySQL Settings';
$lang['mysql_required']	=	'PyroCMS vereist toegang tot een MySQL database die versie 5.0 of hoger draait.';
$lang['mysql_version1']	=	'Uw server draait momenteel versie';
$lang['mysql_version2']	=	'Uw client draait momenteel versie';
$lang['mysql_fail']		=	'Uw MySQL versie wordt niet ondersteund. PyroCMS vereist MySQL versie 5.0 of hoger om probleemloos te funcitoneren.';

$lang['gd_settings']	=	'GD Settings';
$lang['gd_required']	= 	'PyroCMS vereist GD library 1.0 of hoger om afbeeldingen te bewerken.';
$lang['gd_version']		= 	'Uw server draait momenteel versie';
$lang['gd_fail']		=	'We kunnen niet vaststellen welke versie van de GD Library is geinstalleerd. Dit betekent meestal dat de GD Library niet is geinstalleerd. PyroCMS zal nog steeds functioneren echter sommige functionaliteit werkt waarschijnlijk niet. Het wordt sterk aangeraden om de GD Library te activeren.';

$lang['summary']		=	'Overzicht';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS heeft Zlib nodig om thema&acute;s te kunnen uitpakken en installeren'; 
$lang['zlib_fail']		=	'Zlib werd niet aangetroffen. Dit betekent meestal dat Zlib niet geinstalleerd is. PyroCMS kan nog steeds uitstekend functioneren, maar installatie van thema&acute;s is niet mogelijk. U wordt dringend aangeraden Zlib te installeren.'; // needs to be translated

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS requires Curl in order to make connections to other sites.';
$lang['curl_fail']		=	'Curl can not be found. This usually means that Curl is not installed. PyroCMS will still run properly but some of the functions might not work. It is highly recommended to enable the Curl library.';

$lang['summary_success']	=	'Uw server heeft alle benodigheden voor PyroCMS. Ga naar de volgende stap door op de knop hieronder te klikken.';
$lang['summary_partial']	=	'Uw server heeft de <em>meeste</em> benodigheden voor PyroCMS. Dit betekent dat PyroCMS nog steeds zal functioneren, maar er bestaat een kans dat u problemen tegenkomt met het bewerken van afbeeldingen of miniaturen.';
$lang['summary_failure']	=	'Uw server heeft niet de benodigheden die PyroCMS nodig heeft. Neem alstublieft contact op met uw serverbeheerder of uw hostingprovider om dit op te lossen.';
$lang['next_step']		=	'Ga naar de volgende stap';
$lang['step3']			=	'Stap 3';
$lang['retry']			=	'Probeer opnieuw';

// messages
$lang['step1_failure']	=	'U moet de benodigde databaseinstellingen in het formulier hieronder invullen.';

/* End of file step_2_lang.php */
/* Location: ./installer/language/dutch/step_2_lang.php */