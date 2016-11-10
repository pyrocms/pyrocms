<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Steg 1: Konfigurer Database og Server';
$lang['intro_text']		=	'PyroCMS er veldig enkelt å installere og burde kun ta noen få minutter, men det er noen spørsmål som kan være forvirrende hvis du ikke har en teknisk bakgrunn. Hvis du på noe punkt du står fast kan du spørre din leverandør av web hosting eller <a href="http://www.pyrocms.com/contact" target="_blank">kontakt oss</a> for support.';

$lang['db_settings']	=	'Database Innstillinger';
$lang['db_text']		=	'PyroCMS krever en database (MySQL) for å lagre innehold og innstillinger, så første vi må gjøre er å sjekke om dette er korekt. Hvis du ikke forstår hva du blir bedt om å oppgi spør din leverandør av web hosting for mer informasjon.';
$lang['db_missing']		=	'Database driveren (MySQL) for PHP ble ikke funnet, installasjonen kan ikke fortsette. Spør din leverandør for web hosting eller server administrator for å installere den.';

$lang['server']			=	'MySQL Tjener';
$lang['username']		=	'MySQL Brukernavn';
$lang['password']		=	'MySQL Passord';
$lang['portnr']			=	'MySQL Port';
$lang['server_settings']=	'Tjenerinnstillinger';
$lang['httpserver']		=	'HTTP Tjener';

$lang['httpserver_text']=	'PyroCMS krever en HTTP-server for å vise dynamisk innhold når en bruker besøker ditt nettsted. Det ser ut som du allerede har det ettersom du kan se denne siden, men hvis vi vet nøyaktig hvilken type så kan PyroCMS konfigureres enda bedre. Hvis du ikke vet hva noe av dette betyr bare ignorere det og fortsette med installasjonen.';
$lang['rewrite_fail']	=	'Du har valgt "(Apache with mod_rewrite)", men vi ikke klarer å si om mod_rewrite er aktivert på serveren din. Spør din leverandør om mod_rewrite er aktivert eller forsett på egen risiko.';
$lang['mod_rewrite']	=	'Du har valgt "(Apache with mod_rewrite)", men din tjener har ikke mod_rewrite aktivert. Spør din vert å aktivere den eller installere PyroCMS ved hjelp av "Apache (without mod_rewrite)" alternativet.';
$lang['step2']			=	'Steg 2';

// messages
$lang['db_success']		=	'Databasen innstillinger er testet og fungerer fint.';
$lang['db_failure']		=	'Det oppstod et problem ved tilkobling av databasen: ';

/* End of file step_1_lang.php */
