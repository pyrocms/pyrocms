<?php

$lang['email_must_be_array'] = 'Az e-mail érvényesítő függvénynek tömböt kell átadni.';
$lang['email_invalid_address'] = 'Érvénytelen e-mail cím: %s';
$lang['email_attachment_missing'] = 'Nem találhatóak a következő e-mail csatolmányok: %s';
$lang['email_attachment_unreadable'] = 'Ezt a csatolmányt nem sikerült megnyitni: %s';
$lang['email_no_recipients'] = 'Címzetteket meg kell adni: To, Cc, vagy Bcc';
$lang['email_send_failure_phpmail'] = 'Nem sikerült e-mailt küldeni a PHP mail() függvénnyel. Lehetséges, hogy a szervere nincs ennek a módszernek a használatára beállítva.';
$lang['email_send_failure_sendmail'] = 'Nem sikerült e-mailt küldeni a PHP Sendmail használatával. Lehetséges, hogy a szervere nincs ennek a módszernek a használatára beállítva.';
$lang['email_send_failure_smtp'] = 'Nem sikerült e-mailt küldeni a PHP SMTP használatával. Lehetséges, hogy a szervere nincs ennek a módszernek a használatára beállítva.';
$lang['email_sent'] = 'Az Ön üzenete sikeresen küldésre került a következő protokoll használatával: %s';
$lang['email_no_socket'] = 'Nem sikerült kapcsolatot [socketet] nyitni a Sendmailhez. Kérjük ellenőrizze a beállításokat!';
$lang['email_no_hostname'] = 'Nem adott meg SMTP kiszolgálónevet.';
$lang['email_smtp_error'] = 'A következő SMTP hiba következett be: %s';
$lang['email_no_smtp_unpw'] = 'Hiba: Az SMTP felhasználónév és jelszó megadása kötelező.';
$lang['email_failed_smtp_login'] = 'Nem sikerült az AUTH LOGIN parancs küldése. Hibaüzenet: %s';
$lang['email_smtp_auth_un'] = 'A felhasználónév hitelesítése sikertelen. Hibaüzenet: %s';
$lang['email_smtp_auth_pw'] = 'A jelszó hitelesítése sikertelen. Hibaüzenet: %s';
$lang['email_smtp_data_failure'] = 'Az adatküldés sikertelen: %s';
$lang['email_exit_status'] = 'Kilépési kód: %s';
?>