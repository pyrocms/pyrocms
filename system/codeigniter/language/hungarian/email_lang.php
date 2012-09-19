<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * NOTICE OF LICENSE
 * 
 * Licensed under the Open Software License version 3.0
 * 
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

$lang['email_must_be_array'] 		= "Az e-mail érvényesítő függvénynek tömböt kell átadni.";
$lang['email_invalid_address'] 		= "Érvénytelen e-mail cím: %s";
$lang['email_attachment_missing'] 	= "Nem találhatóak a következő e-mail csatolmányok: %s";
$lang['email_attachment_unreadable'] 	= "Ezt a csatolmányt nem sikerült megnyitni: %s";
$lang['email_no_recipients'] 		= "Címzetteket meg kell adni: To, Cc, or Bcc";
$lang['email_send_failure_phpmail']	= "Nem sikerült e-mailt küldeni a PHP mail() függvénnyel. Lehetséges, hogy a szervere nincs ennek a módszernek a használatára beállítva.";
$lang['email_send_failure_sendmail'] 	= "Nem sikerült e-mailt küldeni a PHP Sendmail használatával. Lehetséges, hogy a szervere nincs ennek a módszernek a használatára beállítva.";
$lang['email_send_failure_smtp'] 	= "Nem sikerült e-mailt küldeni a PHP SMTP használatával. Lehetséges, hogy a szervere nincs ennek a módszernek a használatára beállítva.";
$lang['email_sent'] 			= "Az Ön üzenete sikeresen küldésre került a következő protocol használatával: %s";
$lang['email_no_socket'] 		= "Nem sikerült kapcsolatot [socketet] nyitni a Sendmailhez. Kérjük ellenőrizze a beállításokat!";
$lang['email_no_hostname'] 		= "Nem adott meg SMTP kiszolgálónevet.";
$lang['email_smtp_error'] 		= "A következő SMTP hiba következett be: %s";
$lang['email_no_smtp_unpw'] 		= "Hiba: Az SMTP felhasználóinév és jelszó megadása kötelező.";
$lang['email_failed_smtp_login'] 	= "Nem sikerült az AUTH LOGIN parancs küldése. Hibaüzenet: %s";
$lang['email_smtp_auth_un'] 		= "A felhasználóinév hitelesítése sikertelen. Hibaüzenet: %s";
$lang['email_smtp_auth_pw'] 		= "A jelszó hitelesítése sikertelen. Hibaüzenet: %s";
$lang['email_smtp_data_failure'] 	= "Az adatküldés sikertelen: %s";
$lang['email_exit_status'] 		= "Kilépési kód: %s";


/* End of file email_lang.php */
/* Location: ./system/language/hungarian/email_lang.php */