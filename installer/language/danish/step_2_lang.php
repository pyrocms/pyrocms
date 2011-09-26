<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Trin 2: Tjek Krav';
$lang['intro_text']		= 	'Andet trin i installationsprocessen er at tjekke om din server understøtter PyroCMS. De fleste servere kan køre det uden problemer.';
$lang['mandatory']		= 	'Obligatorisk';
$lang['recommended']	= 	'Abefalet';

$lang['server_settings']= 	'HTTP Server Indstillinger';
$lang['server_version']	=	'Din server software:';
$lang['server_fail']	=	'Din server software understøttes ikke, derfor fungerer PyroCMS måske ikke. Så længe din PHP og MySQL installation er opdateret burde PyroCMS skunne fungere, blot uden "rene" URL\'er.';

$lang['php_settings']	=	'PHP Indstillinger';
$lang['php_required']	=	'PyroCMS kræver PHP version %s eller højere.';
$lang['php_version']	=	'Din server kører version';
$lang['php_fail']		=	'Din PHP version understøttes ikke. PyroCMS kræver PHP version %s eller højere for at fungere ordentligt.';

$lang['mysql_settings']	=	'MySQL Indstillinger';
$lang['mysql_required']	=	'PyroCMS kræver adgang til en MySQL database som kører version 5.0 eller højere.';
$lang['mysql_version1']	=	'Din server kører';
$lang['mysql_version2']	=	'Din klient kører';
$lang['mysql_fail']		=	'Din MySQL version understøttes ikke. PyroCMS kræver MySQL version 5.0 eller højere for at fungere ordentligt.';

$lang['gd_settings']	=	'GD Indstillinger';
$lang['gd_required']	= 	'PyroCMS kræver GD library 1.0 eller højere for at manipulere billeder.';
$lang['gd_version']		= 	'Din server kører version';
$lang['gd_fail']		=	'Vi kan ikke afgøre GD bibliotekets version. Dette betyder som regel at GD biblioteket ikke er installeret. PyroCMS vil stadig køre, men noget af billedfunktionaliteten kan være dysfunktionel. Det anbefales kraftigt at aktivere GD biblioteket.';

$lang['summary']		=	'Opsummering';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS kræver Zlib for at kunne udpakke og installere temaer.';
$lang['zlib_fail']		=	'Zlib kan ikke findes. Dette betyder som regel at Zlib ikke er installeret. PyroCMS vil stadig køre, men installation af temaer vil ikke fungere . Det anbefales kraftigt at installere Zlib.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS kræver Curl in order to make connections to other sites.';
$lang['curl_fail']		=	'Curl kan ikke findes. Dette betyder som regel at Curl ikke er installeret. PyroCMS vil stadig køre, men noget af funktionaliteten kan være dysfunktionelle. Det anbefales kraftigt at aktivere the Curl biblioteket.';

$lang['summary_success']	=	'Din server opfylder alle krav for at PyroCMS kan køre, gå til næste trin ved at klikke på knappen nedenunder.';
$lang['summary_partial']	=	'Din server opfylder <em>de fleste</em> af kravene til PyroCMS. Dette betyder at PyroCMS burde kunne køre, men der er risiko for at du vil opleve problemer med ting som billedredigering og oprettelse af thumbnails.';
$lang['summary_failure']	=	'Det lader ikke til at din server kan leve op til krav for at køre PyroCMS. Kontakt venligst din serveradministrator eller hostingselskab for at løse problemet.';
$lang['next_step']		=	'Fortsæt til næste trin';
$lang['step3']			=	'Trin 3';
$lang['retry']			=	'Prøv igen';

// messages
$lang['step1_failure']	=	'Udfyld venligst de påkrævede databaseindstillinger i formularen nedenfor..';

/* End of file step_2_lang.php */