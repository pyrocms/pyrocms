<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']             = 'Schritt 2: Pr&uuml;fung der Anforderungen';
$lang['intro_text']         = 'Beim erste Schritt bei der Installation ist zu &uuml;berpr&uuml;fen, ob PyroCMS auf Diesem Server lauff&auml;hig ist. Die meisten Server sollten allerdings in der Lage sein, das PyroCMS vollst&auml;ndig zu unterst&uuml;tzen.';
$lang['mandatory']          = 'Obligatorisch';
$lang['recommended']        = 'Empfohlen';
$lang['server_settings']    = 'HTTP Server Einstellungen';
$lang['server_version']     = 'Ihre Server Software:';


$lang['server_fail']        = 'Ihre HTTP-Software wird nicht unterst&uuml;tzt. Daher wird PyroCMS nicht ordnungsgem&auml;&szlig; funktionieren. Solange Ihre PHP- und MySQL-Installation nicht auf dem neuesten Stand ist wird PyroCMS nicht in der Lage sein richtig laufen zu k&ouml;nnen ohne die Anzeige und Verarbeitung von sauberen URL\'s.';


$lang['php_settings']       = 'PHP-Einstellungen';
$lang['php_required']       = 'PyroCMS ben&ouml;tigt PHP version %s oder h&ouml;her.';
$lang['php_version']        = 'Auf diesem Serer l&auml;uft aktuell die Version';
$lang['php_fail']           = 'Ihre PHP-Version wird nicht unterst&uuml;tzt. PyroCMS ben&ouml;tigt PHP-Version %s oder h&ouml;her.';

$lang['mysql_settings']     = 'MySQL-Einstellungen';
$lang['mysql_required']     = 'PyroCMS ben&ouml;tigt Zugriff zu einer MySQL-Datenbank in der Version 5.0 oder h&ouml;her.';
$lang['mysql_version1']     = 'Auf Diesem Server l&auml;uft aktuell die Version';
$lang['mysql_version2']     = 'Der Client l&auml;uft aktuell mit der Version';
$lang['mysql_fail']         = 'Ihre MySQL version wird nicht unterst&uuml;tzt. PyroCMS ben&ouml;tigt MySQL version 5.0 oder h&ouml;her.';

$lang['gd_settings']        = 'GD Einstellungen';
$lang['gd_required']        = 'PyroCMS ben&ouml;tigt die GD-Library 1.0 oder h&ouml;her um Bilder zu bearbeiten.';
$lang['gd_version']         = 'Auf diesem Server l&auml;uft aktuell die Version';


$lang['gd_fail']            = 'Die Version der GD-Libary kann nicht erkannt werden. Das k&ouml;nnte bedeuten das die GD-Libary nicht installiert ist. PyroCMS wird ordnungsgem&auml;&szlig; funktionieren. Dennoch werden einige Funktionen zur Bildverarbeitung nicht einwandfrei vom System angewendet werden k&ouml;nnen. Es wird ausdr&uuml;cklich empfohlen die GD-Bibliothek zu installieren.';

$lang['summary']            = 'Ergebnis';

$lang['zlib']               = 'Zlib';
$lang['zlib_required']      = 'PyroCMS ben&ouml;tigt Zlib um Themes zu entpacken und zu installieren.';


$lang['zlib_fail']          = 'Die Zlib-Bibliothek kann nicht gefunden werden. Das bedeutet normalerweilse das Zlib nicht installiert ist. PyroCMS wird ordnungsgem&auml;&szlig; funktionieren. Nur wird die Installation von neuen Themes &uuml;ber die Upload-Funktion des CMS nicht m&ouml;glich sein. Es wird ausdr&uuml;cklich empfohlen Zlib-Bibliothek zu installieren.';

$lang['summary_success']    = 'Ihr Server hat alle Tests bestanden und kann das PyroCMS ohne Einschr&auml;nkungen betreiben. Bitte fahren Sie mit dem n&auml;chsten Schritt fort. Klicken Sie dazu auf folgenden Button';

$lang['summary_partial']    = 'Dein Server stimmt mit den <em>meisten</em> Voraussetzungen des PyroCMS &uuml;berein. Das bedeutet das PyroCMS problemlos funktionieren sollte. Erfahrungshalber kann es vorkommen das du Probleme mit der automatischen Bildgr&ouml;ßenver&auml;nderung und/oder der Thumbnail-Erstellung haben wirst.';
$lang['summary_failure']    = 'Es scheint als erf&uuml;llt dein Server nicht die minimalen Anforderungen die vom PyroCMS ben&ouml;tigt werden um ohne Einschr&auml;nkungen laufen zu k&ouml;nnen. Bitte kontaktieren Sie Ihren Anbieter und/oder Server-Administrator oder die zust&auml;ndige Firma um das Problem zu beheben.';
$lang['next_step']          = 'Weiter zu Schritt 3';
$lang['step3']              = 'Schritt 3';
$lang['retry']              = 'Nochmals pr&uuml;fen';

// messages
$lang['step1_failure']      = 'Bitte f&uuml;llen Sie die ben&ouml;tigten Datenbank-Informationen in das untere Formular..';
