<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        	= 'Benutzerprofil-Feld hinzufügen';
$lang['user:profile_delete_success']           	= 'Das Benutzerprofil-Feld wurde gelöscht';
$lang['user:profile_delete_failure']            = 'Das Benutzerprofil-Feld konnte nicht gelöscht werden';
$lang['profile_user_basic_data_label']  		= 'Basisangaben';
$lang['profile_company']         	  			= 'Firma';
$lang['profile_updated_on']           			= 'Aktualisiert am';
$lang['user:profile_fields_label']	 		 	= 'Profil Felder';

$lang['user:register_header']                   = 'Registrieren';
$lang['user:register_step1']                    = '<strong>1 Schritt:</strong> Registrieren';
$lang['user:register_step2']                    = '<strong>2 Schritt:</strong> Aktivieren';

$lang['user:login_header']                      = 'Anmelden';

// titles
$lang['user:add_title']                         = 'Benutzer anlegen';
$lang['user:list_title']                        = 'Benutzer auflisten';
$lang['user:inactive_title']                    = 'Inaktive Benutzer';
$lang['user:active_title']                      = 'Aktive Benutzer';
$lang['user:registred_title']                   = 'Registrierte Benutzer';

// labels
$lang['user:edit_title']                        = 'Benutzer "%s" bearbeiten';
$lang['user:details_label']                     = 'Details';
$lang['user:first_name_label']                  = 'Vorname';
$lang['user:last_name_label']                   = 'Nachname';
$lang['user:group_label']                       = 'Gruppe';
$lang['user:activate_label']                    = 'Aktivieren';
$lang['user:password_label']                    = 'Passwort';
$lang['user:password_confirm_label']            = 'Passwort best&auml;tigen';
$lang['user:name_label']                        = 'Name';
$lang['user:joined_label']                      = 'Registriert';
$lang['user:last_visit_label']                  = 'Letzer Besuch';
$lang['user:never_label']                       = 'Nie';

$lang['user:no_inactives']                      = 'Keine inaktiven Benutzer.';
$lang['user:no_registred']                      = 'Keine registrierten Benutzer.';

$lang['account_changes_saved']                  = 'Ihre Einstellungen wurden erfolgreich gesichert.';

$lang['indicates_required']                     = 'Kennzeichnet Pflichtfelder';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Aktivierungs-E-Mail';
$lang['user:do_not_activate']                  = 'Inaktiv';
$lang['user:register_title']                    = 'Registrieren';
$lang['user:activate_account_title']            = 'Benutzer aktivieren';
$lang['user:activate_label']                    = 'Aktivieren';
$lang['user:activated_account_title']           = 'Aktivierter Benutzer';
$lang['user:reset_password_title']              = 'Passwort zur&uuml;ckzusetzen';
$lang['user:password_reset_title']              = 'Passwort zur&uuml;ckzusetzen';


$lang['user:error_username']                    = 'Der gew&auml;hlte Benutzername ist bereits in Verwendung.';
$lang['user:error_email']                       = 'Die angegebene E-Mail-Adresse wird bereits verwendet';

$lang['user:full_name']                         = 'Name';
$lang['user:first_name']                        = 'Vorname';
$lang['user:last_name']                         = 'Nachname';
$lang['user:username']                          = 'Benutzername';
$lang['user:display_name']                      = 'Anzeigename';
$lang['user:email_use']                         = 'F&uuml;&uuml;r Login ben&ouml;tigt';
$lang['user:remember']                          = 'Angemeldet bleiben';
$lang['user:group_id_label']                    = 'Gruppen ID';

$lang['user:level']                             = 'Benutzer Rolle';
$lang['user:active']                            = 'Aktiv';
$lang['user:lang']                              = 'Sprache';

$lang['user:activation_code']                   = 'Aktivierungsschl&uuml;ssel';

$lang['user:reset_instructions']                = 'E-Mail oder Benutzername eingeben';
$lang['user:reset_password_link']               = 'Passwort vergessen?';

$lang['user:activation_code_sent_notice']       = 'Sie haben eine Email mit ihren Aktivierungscode erhalten.';
$lang['user:activation_by_admin_notice']        = 'Ihre Registrierung muss noch von einem Administrator bestätigt werden.';
$lang['user:registration_disabled']            = 'Die Registrierung für Benutzer wurde deaktiviert.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section']                  = 'Name';
$lang['user:password_section']                 = 'Passwort &auml;ndern';
$lang['user:other_settings_section']           = 'Weitere Einstellungen';

$lang['user:settings_saved_success']           = 'Ihre Einstellungen wurden erfolgreich gesichert.';
$lang['user:settings_saved_error']             = 'Ein Fehler ist aufgetreten.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']                     = 'Registrieren';
$lang['user:activate_btn']                     = 'Aktivieren';
$lang['user:reset_pass_btn']                   = 'Passwort zur&uuml;ckzusetzen';
$lang['user:login_btn']                        = 'Anmelden';
$lang['user:settings_btn']                     = 'Einstellungen sichern';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success']      = 'Der Benutzer wurde angelegt und aktiviert.';
$lang['user:added_not_activated_success']      = 'Der Benutzer wurde angelegt, muss jedoch noch aktiviert werden.';

// Edit
$lang['user:edit_user_not_found_error']        = 'Der Benutzer wurde nicht gefunden.';
$lang['user:edit_success']                     = 'Der Benutzer wurde erfolgreich gesichert.';
$lang['user:edit_error']                       = 'Ein Fehler ist aufgetreten.';

// Activate
$lang['user:activate_success']                 = '%s von %s wurden erfolgreich aktiviert.';
$lang['user:activate_error']                   = 'Du musst zuerst einen Benutzer ausw&auml;hlen.';

// Delete
$lang['user:delete_self_error']                = 'Man kann sich nicht selber l&ouml;schen!';
$lang['user:mass_delete_success']              = '%s von %s wurde(n) erfolgreich gel&ouml;scht.';
$lang['user:mass_delete_error']                = 'Du musst zuerst einen Benutzer ausw&auml;hlen.';

// Register
$lang['user:email_pass_missing']               = 'Bitte f&uuml;lle das Email und das Passwort Feld aus.';
$lang['user:email_exists']                     = 'Diese Email Addresse wird bereits von einem anderen Benutzer genutzt.';
$lang['user:register_error']                   = 'Wir denken Sie sind ein Bot. Wenn es sich um einen Fehler handelt bitten wir um Entschuldigung. Bitte wenden Sie sich in diesem Falle an den Administrator.';
$lang['user:register_reasons']                 = 'Melde dich an um Zugriff auf gesonderte Bereiche zu erhalten. Durch die Registrierung werden deine Einstellungen gesichert und du erh&auml;ltst schnelleren Zugang zu bestimmten Inhalten.';


// Activation
$lang['user:activation_incorrect']             = 'Aktivierung fehlgeschlagen. Bitte &uuml;berpr&uuml;fe deine Angaben und stell sicher, dass du die Feststelltaste nicht gedr&uuml;ckt hast.';
$lang['user:activated_message']                = 'Dein Zugang wurde aktiviert. Du kannst dich nun anmelden.';


// Login
$lang['user:logged_in']                        = 'Du hast dich erfolgreich eingeloggt.';
$lang['user:already_logged_in']                = 'Du bist bereits angemeldet. Bitte melde dich zuvor ab.';
$lang['user:login_incorrect']                  = 'Email oder Passwort stimmen nicht. Bitte &uuml;berpr&uuml;fe deine Angaben und stell sicher, dass du die Feststelltaste nicht gedr&uuml;ckt hast.';
$lang['user:inactive']                         = 'Dein Benutzer ist nicht aktiv.<br />&Uuml;berpr&uuml;fe bitte deine Emails und folge der Anleitung zur Aktivierung deines Zugangs. - <em>&Uuml;berpr&uuml;fe bitte auch das SPAM Verzeichnis</em>.';


// Logged Out
$lang['user:logged_out']                       = 'Du wurdest abgemeldet.';

// Forgot Pass
$lang['user:forgot_incorrect']                 = "Benutzer konnte nicht gefunden werden.";

$lang['user:password_reset_message']           = "Dein Passwort wurde zur&uuml;ckgesetzt. Du wirst in den n&auml;chsten 2 Stunden eine Email erhalten. - <em>&Uuml;berpr&uuml;fe bitte auch das SPAM Verzeichnis</em>.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject']         = 'Aktivierung';
$lang['user:activation_email_body']            = 'Danke, dass sie Ihren Zugang zu % aktiviert haben. Bitte folge dem Link:';


$lang['user:activated_email_subject']          = 'Aktivierung abgeschlossen';
$lang['user:activated_email_content_line1']    = 'Danke, f&uuml;r Ihre Registrierung bei %s. Um den Zugang zu aktiveren, folge bitte dem Link:';
$lang['user:activated_email_content_line2']    = 'Sollte dein Email-Programm den Link nicht erkennen, &ouml;ffne bitte die folgende Adresse in deinem Browser und gib den Aktivierungscode ein:';

// Reset Pass
$lang['user:reset_pass_email_subject']         = 'Passwort zur&uuml;ckzusetzen';
$lang['user:reset_pass_email_body']            = 'Dein Passwort bei %s wurde zur&uuml;ckgesetzt. Wenn du dies nicht veranlasst hast, sende bitte umgehend eine Email an %s.';

// Profile
$lang['profile_of_title'] = '%s\'s Profil';

$lang['profile_user_details_label']    = 'Benutzer-Details';
$lang['profile_role_label']            = 'Funktion';
$lang['profile_registred_on_label']    = 'Registriert am';
$lang['profile_last_login_label']      = 'Letzte Anmeldung';
$lang['profile_male_label']            = 'M&auml;nnlich';
$lang['profile_female_label']          = 'Weiblich';

$lang['profile_not_set_up']            = 'Dieser Benutzer hat kein Profil eingerichtet.';

$lang['profile_edit']                  = 'Dein Profil bearbeiten';

$lang['profile_personal_section']      = 'Pers&ouml;nliches';

$lang['profile_personal_section']      = 'Anzeige-Name';
$lang['profile_dob']                   = 'Geburtssdatum';
$lang['profile_dob_day']               = 'Tag';
$lang['profile_dob_month']             = 'Monat';
$lang['profile_dob_year']              = 'Jahr';
$lang['profile_gender']                = 'Geschlecht';
$lang['profile_gender_nt']             = 'Nicht anzeigen';
$lang['profile_gender_male']          = 'M&auml;nnlich';
$lang['profile_gender_female']        = 'Weiblich';
$lang['profile_bio']                   = '&Uuml;ber mich';

$lang['profile_contact_section']       = 'Kontakt';

$lang['profile_phone']                 = 'Telefon';
$lang['profile_mobile']                = 'Handy';
$lang['profile_address']               = 'Adresse';
$lang['profile_address_line1']         = 'Zeile #1';
$lang['profile_address_line2']         = 'Zeile #2';
$lang['profile_address_line3']         = 'Zeile #3';
$lang['profile_address_postcode']      = 'Postleitzahl';
$lang['profile_website']               = 'Homepage';

$lang['profile_messenger_section']     = 'Instant Messenger';

$lang['profile_msn_handle']            = 'MSN';
$lang['profile_aim_handle']            = 'AIM';
$lang['profile_yim_handle']            = 'Yahoo! Messenger';
$lang['profile_gtalk_handle']          = 'GoogleTalk';

$lang['profile_avatar_section']        = 'Avatar';
$lang['profile_social_section']        = 'Soziales Netzwerk';

$lang['profile_gravatar']              = 'Gravatar';
$lang['profile_twitter']               = 'Twitter';

$lang['profile_edit_success']          = 'Dein Profil wurde gesichert.';
$lang['profile_edit_error']            = 'Ein Fehler ist aufgetreten.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn'] = 'Profil sichern';
