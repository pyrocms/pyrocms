<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']             = 'Schritt 1: Server und Datenbank Konfiguration';
$lang['intro_text']         = 'Bevor wir die Datenbank Verbindung testen k&ouml;nnen, ben&ouml;tigen wir noch ein paar Details dar&uuml;ber.';
$lang['db_settings']        = 'Datenbank Einstellungen';
$lang['db_text']            = 'Um Ihre MySQL-Server-Version zu &uuml;berpr&uuml;ffen, geben Sie bitte im nachfolgenden Formular den Hostnamen, Benutzername und Passwort zum MySQL Server an. Diese Einstellungen werden auch zur Installation vom PyroCMS ben&ouml;tigt.';
$lang['server']             = 'Host';
$lang['username']           = 'Benutzername';
$lang['password']           = 'Passwort';
$lang['portnr']             = 'Server Port';
$lang['server_settings']    = 'Server Einstellungen';
$lang['httpserver']         = 'HTTP Server';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']              = 'Schritt 2';

// messages
$lang['db_success']         = 'Die Datenbank einstellungen wurde Erfolgreich getestet.';
$lang['db_failure']         = 'Es gibt Probleme mit der Datenbank Verbindung: ';
