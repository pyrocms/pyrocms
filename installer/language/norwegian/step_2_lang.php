<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Steg 1: Krav';
$lang['intro_text']		= 	'Det andre steget i installasjonen er å sjekke om din tjener støtter PyroCMS. De fleste servere skal kunne kjøre det uten noen problemer.';
$lang['mandatory']		= 	'Obligatorisk';
$lang['recommended']	= 	'Anbefalt';

$lang['server_settings']= 	'HTTP Tjenerinnstillinger';
$lang['server_version']	=	'Din tjener programvare:';
$lang['server_fail']	=	'Din tjeneren støttes ikke, derfor kan det hende at PyroCMS kanskje eller kanskje ikke fungerer. Så lenge PHP og MySQL installasjoner er oppdatert, skal PyroCMS fungere riktig, bare uten pene nettadresser.';

$lang['php_settings']	=	'PHP Innstillinger';
$lang['php_required']	=	'PyroCMS krever PHP versjon %s eller høyere.';
$lang['php_version']	=	'Tjeneren din kjører for øyeblikket versjon';
$lang['php_fail']		=	'Din PHP-versjon er ikke støttet. PyroCMS krever PHP versjon %s eller høyere for å kjøre skikkelig.';

$lang['mysql_settings']	=	'MySQL Innstillinger';
$lang['mysql_required']	=	'PyroCMS krever tilgang til en MySQL database som kjører versjon 5.0 eller høyere.';
$lang['mysql_version1']	=	'Tjeneren din kjører for øyeblikket';
$lang['mysql_version2']	=	'Din klient kjører for øyeblikket';
$lang['mysql_fail']		=	'Din MySQL versjon er ikke støttet. PyroCMS krever MySQL versjon 5.0 eller høyere for å kjøre skikkelig.';

$lang['gd_settings']	=	'GD Innstillinger';
$lang['gd_required']	= 	'PyroCMS krever GD bibliotek 1.0 eller høyere for å manipulere bilder.';
$lang['gd_version']		= 	'Tjeneren din kjører for øyeblikket versjon';
$lang['gd_fail']		=	'Vi kan ikke fastslå hvilken versjon av GD biblioteket tjeneren kjører. Dette betyr vanligvis at GD biblioteket ikke er installert. PyroCMS vil fortsatt kjøre på riktig måte, men noen av bildefunksjonene vil kanskje ikke fungere. Det er sterkt anbefalt å aktivere GD biblioteket.';

$lang['summary']		=	'Oppsummering';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS krever Zlib for å pakke ut og installere temaer.';
$lang['zlib_fail']		=	'Zlib ble ikke funnet. Dette betyr vanligvis at Zlib ikke er installert. PyroCMS vil fortsatt kjøre på riktig måte, men installasjon av temaene vil ikke fungere. Det er sterkt anbefalt å installere Zlib.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS krever Curl for å lage forbindelser til andre nettsteder.';
$lang['curl_fail']		=	'Curl ble ikke funnet. Dette betyr vanligvis at Curl ikke er installert. PyroCMS vil fortsatt kjøre på riktig måte, men noen av funksjonene vil ikke fungere. Det er sterkt anbefalt å aktivere Curl biblioteket.';

$lang['summary_success']	=	'Tjeneren din oppfyller alle kravene for PyroCMS å kjøre riktig måte, gå til neste trinn ved å klikke på knappen nedenfor.';
$lang['summary_partial']	=	'Tjeneren din møter de<em>meste</em> av kravene til PyroCMS. Dette betyr at PyroCMS skal kunne kjøre skikkelig, men det er en sjanse for at du vil oppleve problemer med ting som for eksempel endring av bildestørrelse og opprette miniatyrbilder.';
$lang['summary_failure']	=	'Det virker som din server ikke klarte å oppfylle kravene til å kjøre PyroCMS. Ta kontakt med serveradministratoren eller din leverandør for web hosting for å få dette løst.';
$lang['next_step']		=	'Fortsett til neste trinn';
$lang['step3']			=	'Steg 3';
$lang['retry']			=	'Prøv igjen';

// messages
$lang['step1_failure']	=	'Vennligst skriv inn de nødvendige databasen innstillingene i skjemaet nedenfor.';

/* End of file step_2_lang.php */