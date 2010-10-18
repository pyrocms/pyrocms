<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']		 = 'Schritt 2: Pr&uuml;ffe Anforderungen';
$lang['intro_text']	 = 'Der erste Schritt bei der Installation ist zu &Uuml;berpr&uuml;fen, ob PyroCMS auf Diesem Server Lauff&auml;hig ist. Die meisten Server sollten allerdings in der Lage, PyroCMS Vollst&auml;ndig zu unterst&uuml;tzen.';
$lang['mandatory']	 = 'Obligatorisch';
$lang['recommended']	 = 'Empfohlen';
$lang['server_settings'] = 'HTTP Server Einstellungen';
$lang['server_version']	 = 'Ihre Server Software:';


$lang['server_fail']	= 'Ihre Server-Software wird nicht unterst&uuml;tzt, daher PyroCMS kann oder auch nicht. Solange Ihr PHP und MySQL-Installationen auf dem neuesten Stand sind PyroCMS Lage sein sollten, richtig laufen, nur ohne saubere URL\'s.';


$lang['php_settings']	 = 'PHP Einstellungen';
$lang['php_required']	 = 'PyroCMS ben&ouml;tigt PHP version 5.0 oder h&ouml;her.';
$lang['php_version']	 = 'Auf Diesem Serer l&auml;uft aktuell version';
$lang['php_fail']	 = 'Ihre PHP version wird nicht unterst&uuml;tzt. PyroCMS ben&ouml;tigt PHP version 5.0 oder h&ouml;her.';

$lang['mysql_settings']	 = 'MySQL Einstellungen';
$lang['mysql_required']	 = 'PyroCMS ben&ouml;tigt zugriff zu einer MySQL datenbank in der version 5.0 oder h&ouml;her.';
$lang['mysql_version1']	 = 'Auf Diesem Serer l&auml;uft aktuell version';
$lang['mysql_version2']	 = 'Der Client l&auml;uft aktuell in der version';
$lang['mysql_fail']	 = 'Ihre MySQL version wird nicht unterst&uuml;tzt. PyroCMS ben&ouml;tigt MySQL version 5.0 oder h&ouml;her.';

$lang['gd_settings']	= 'GD Einstellungen';
$lang['gd_required']	= 'PyroCMS ben&ouml;tigt die GD library 1.0 oder h&ouml;her um bilder zu bearbeiten.';
$lang['gd_version']	= 'Auf Diesem Serer l&auml;uft aktuell version';


$lang['gd_fail']	 = 'We cannot determine the version of the GD library. This usually means that the GD library is not installed. PyroCMS will still run properly but some of the image functions might not work. It is highly recommended to enable the GD library.';

$lang['summary']	 = 'Ergebnis';

$lang['zlib']		 = 'Zlib';
$lang['zlib_required']	 = 'PyroCMS ben&ouml;tigt Zlib um themes zu unzipen und zu installierenin.';


$lang['zlib_fail']	 = 'Zlib can not be found. This usually means that Zlib is not installed. PyroCMS will still run properly but installation of themes will not work. It is highly recommended to install Zlib.';

$lang['summary_success'] = 'Ihr Server hat alle tests bestanden um PyroCMS Problemlos zu betreiben, gehen Sie zum n&auml;chsten Schritt. Klicken Sie einfach auf folgenden Button';

$lang['summary_partial']	=	'Your server meets <em>most</em> of the requirements for PyroCMS. This means that PyroCMS should be able to run properly but there is a chance that you will experience problems with things such as image resizing and thumbnail creating.';
$lang['summary_failure']	=	'It seems that your server failed to meet the requirements to run PyroCMS. Please contact your server administrator or hosting company to get this resolved.';
$lang['next_step']		=	'Weiter zu Schritt 3';
$lang['step3']			=	'Schritt 3';
$lang['retry']			=	'Nochmals prüffen';

// messages
$lang['step1_failure']	=	'Please fill in the required database settings in the form below..';
