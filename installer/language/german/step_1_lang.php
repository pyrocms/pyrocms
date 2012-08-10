<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']             = 'Schritt 1: Server- und Datenbank-Konfiguration';
$lang['intro_text']         = 'Bevor die Verbindung zur Datenbank getestet werden kann, werden einige genauere Details ben&ouml;tigt.';

$lang['db_settings']        = 'Einstellung der Datenbank';
$lang['db_text']            = 'Um die Version der mySQL-Datenbank zu &uuml;berpr&uuml;ffen, geben Sie bitte im nachfolgenden Formular den Hostnamen, den Benutzernamen und das Passwort des MySQL-Servers an. Diese Einstellungen werden ebenfalls zur Installation vom PyroCMS ben&ouml;tigt.';
$lang['db_missing']         = 'Der mySQL-Datenbanktreiber wurde nicht gefunden, die Installation kann nicht fortgeführt werden. Beauftragen Sie bitte Ihren Anbieter oder Server-Administrator, den mySQL-Datenbanktreiber zu installieren.';

$lang['server']             = 'Host';
$lang['username']           = 'Benutzername';
$lang['password']           = 'Passwort';
$lang['portnr']             = 'Server Port';
$lang['server_settings']    = 'Server Einstellungen';
$lang['httpserver']         = 'HTTP Server';
$lang['httpserver_text']    = 'Das PyroCMS ben&ouml;tigt einen funktionsf&auml;higen HTTP-Server, um die Daten dynamisch auf Ihrer Webseite darstellen zu k&ouml;nnen. Da du diese Seite hier sehen kannst, scheint es, als w&uuml;rde bereits ein funktionierender HTTP-Server auf laufen. Wenn Sie jedoch wissen welchen HTTP-Server Sie nutzen, geben Sie diesen bitte an. PyroCMS kann sich so besser konfigurieren. Wenn Sie sich nicht sicher sind, ignorieren sie diese Angabe und f&uuml;hren Sie die Installation fort.';
$lang['rewrite_fail']       = 'Du hast "(Apache mit mod_rewrite)" als HTTP-Server ausgew&auml;hlt. Jedoch kann die Installation nicht ausfindig machen, ob mod_rewrite auf dem Server installiert ist oder nicht. Wenden Sie sich an Ihren Anbieter und/oder Server-Administrator oder fahren Sie auf eigene Risiken fort.';
$lang['mod_rewrite']        = 'Du hast "(Apache with mod_rewrite)" als HTTP-Server ausgew&auml;hlt. Jedoch ist auf deinem Server kein mod_rewrite aktiviert. Wenden Sie sich an Ihren Anbieter und/oder Server-Administrator oder w&auml;hlen Sie "Apache (without mod_rewrite)" als Option.';
$lang['step2']              = 'Schritt 2';

// messages
$lang['db_success']         = 'Ihre Einstellungen der Datenbank wurden erfolgreich getestet.';
$lang['db_failure']         = 'Etwas stimmt mit Ihrer Konfiguration der Datenbank nicht: ';
