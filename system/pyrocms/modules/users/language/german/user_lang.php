<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user_register_header']                   = 'Registrieren';
$lang['user_register_step1']                    = '<strong>1 Schritt:</strong> Registrieren';
$lang['user_register_step2']                    = '<strong>2 Schritt:</strong> Aktivieren';

$lang['user_login_header']                      = 'Anmelden';

// titles
$lang['user_add_title']                         = 'Benutzer anlegen';
$lang['user_list_title'] 				= 'List users'; #translate
$lang['user_inactive_title']                    = 'Inaktive Benutzer';
$lang['user_active_title']                      = 'Aktive Benutzer';
$lang['user_registred_title']                   = 'Registrierte Benutzer';

// labels
$lang['user_edit_title']                        = 'Benutzer "%s" bearbeiten';
$lang['user_details_label']                     = 'Details';
$lang['user_first_name_label']                  = 'Vorname';
$lang['user_last_name_label']                   = 'Nachname';
$lang['user_email_label']                       = 'Email';
$lang['user_group_label']                       = 'Gruppe';
$lang['user_activate_label']                    = 'Aktivieren';
$lang['user_password_label']                    = 'Passwort';
$lang['user_password_confirm_label']            = 'Passwort bestätigen';
$lang['user_name_label']                        = 'Name';
$lang['user_joined_label']                      = 'Registriert';
$lang['user_last_visit_label']                  = 'Letzer Besuch';
$lang['user_actions_label']                     = 'Aktion';
$lang['user_never_label']                       = 'Nie';
$lang['user_delete_label']                      = 'Löschen';
$lang['user_edit_label']                        = 'Bearbeiten';
$lang['user_view_label']                        = 'Anzeigen';

$lang['user_no_inactives']                      = 'Keine inaktiven Benutzer.';
$lang['user_no_registred']                      = 'Keine registrierten Benutzer.';

$lang['account_changes_saved']                  = 'Ihre Einstellungen wurden erfolgreich gesichert.';

$lang['indicates_required']                     = 'Kennzeichnet Pflichtfelder';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_register_title']                    = 'Registrieren';
$lang['user_activate_account_title']            = 'Benutzer aktivieren';
$lang['user_activate_label']                    = 'Aktivieren';
$lang['user_activated_account_title']           = 'Aktivierter Benutzer';
$lang['user_reset_password_title']              = 'Passwort zurückzusetzen';
$lang['user_password_reset_title']              = 'Passwort zurückzusetzen';


$lang['user_error_username']                    = 'Der gewählte Benutzername ist bereits in Verwendung.';
$lang['user_error_email']                       = 'Die angegebene E-Mail-Adresse wird bereits verwendet';

$lang['user_full_name']                         = 'Name';
$lang['user_first_name']                        = 'Vorname';
$lang['user_last_name']                         = 'Nachname';
$lang['user_username']                          = 'Benutzername';
$lang['user_display_name']                      = 'Anzeigename';
$lang['user_email_use'] 					   = 'used to login'; #translate
$lang['user_email']                             = 'Email';
$lang['user_confirm_email']                     = 'Email bestätigen';
$lang['user_password']                          = 'Passwort';
$lang['user_remember']                          = 'Angemeldet bleiben';
$lang['user_confirm_password']                  = 'Passwort bestätigen';
$lang['user_group_id_label']                    = 'Gruppen ID';

$lang['user_level']                             = 'Benutzer Rolle';
$lang['user_active']                            = 'Aktiv';
$lang['user_lang']                              = 'Sprache';

$lang['user_activation_code']                   = 'Aktivierungsschlüssel';

$lang['user_reset_password_link']               = 'Passwort vergessen?';

$lang['user_activation_code_sent_notice']       = 'Sie haben eine Email mit ihren Aktivierungscode erhalten.';
$lang['user_activation_by_admin_notice']        = 'Ihre Registrierung muss noch von einem Administrator bestätigt werden.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section']                  = 'Name';
$lang['user_password_section']                 = 'Passwort ändern';
$lang['user_other_settings_section']           = 'Weitere Einstellungen';

$lang['user_settings_saved_success']           = 'Ihre Einstellungen wurden erfolgreich gesichert.';
$lang['user_settings_saved_error']             = 'Ein Fehler ist aufgetreten.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']                     = 'Registrieren';
$lang['user_activate_btn']                     = 'Aktivieren';
$lang['user_reset_pass_btn']                   = 'Passwort zurückzusetzen';
$lang['user_login_btn']                        = 'Anmelden';
$lang['user_settings_btn']                     = 'Einstellungen sichern';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success']      = 'Der Benutzer wurde angelegt und aktiviert.';
$lang['user_added_not_activated_success']      = 'Der Benutzer wurde angelegt, muss jedoch noch aktiviert werden.';

// Edit
$lang['user_edit_user_not_found_error']        = 'Der Benutzer wurde nicht gefunden.';
$lang['user_edit_success']                     = 'Der Benutzer wurde erfolgreich gesichert.';
$lang['user_edit_error']                       = 'Ein Fehler ist aufgetreten.';

// Activate
$lang['user_activate_success']                 = '%s von %s wurden erfolgreich aktiviert.';
$lang['user_activate_error']                   = 'Du musst zuerst einen Benutzer auswählen.';

// Delete
$lang['user_delete_self_error']                = 'Man kann sich nicht selber löschen!';
$lang['user_mass_delete_success']              = '%s von %s wurde(n) erfolgreich gelöscht.';
$lang['user_mass_delete_error']                = 'Du musst zuerst einen Benutzer auswählen.';

// Register
$lang['user_email_pass_missing']               = 'Bitte fülle das Email und das Passwort Feld aus.';
$lang['user_email_exists']                     = 'Diese Email Addresse wird bereits von einem anderen Benutzer genutzt.';
$lang['user_register_reasons']                 = 'Melde dich an um Zugriff auf gesonderte Bereiche zu erhalten. Durch die Registrierung werden deine Einstellungen gesichert und du erhältst schnelleren Zugang zu bestimmten Inhalten.';


// Activation
$lang['user_activation_incorrect']             = 'Aktivierung fehlgeschlagen. Bitte überprüfe deine Angaben und stell sicher, dass du die Feststelltaste nicht gedrückt hast.';
$lang['user_activated_message']                = 'Dein Zugang wurde aktiviert. Du kannst dich nun anmelden.';


// Login
$lang['user_logged_in']                        = 'Du hast dich erfolgreich eingeloggt.';
$lang['user_already_logged_in']                = 'Du bist bereits angemeldet. Bitte melde dich zuvor ab.';
$lang['user_login_incorrect']                  = 'Email oder Passwort stimmen nicht. Bitte überprüfe deine Angaben und stell sicher, dass du die Feststelltaste nicht gedrückt hast.';
$lang['user_inactive']                         = 'Dein Benutzer ist nicht aktiv.<br />Überprüfe bitte deine Emails und folge der Anleitung zur Aktivierung deines Zugangs. - <em>Überprüfe bitte auch das SPAM Verzeichnis</em>.';


// Logged Out
$lang['user_logged_out']                       = 'Du wurdest abgemeldet.';

// Forgot Pass
$lang['user_forgot_incorrect']                 = "Benutzer konnte nicht gefunden werden.";

$lang['user_password_reset_message']           = "Dein Passwort wurde zurückgesetzt. Du wirst in den nächsten 2 Stunden eine Email erhalten. - <em>Überprüfe bitte auch das SPAM Verzeichnis</em>.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject']         = 'Aktivierung';
$lang['user_activation_email_body']            = 'Danke, dass sie Ihren Zugang zu % aktiviert haben. Bitte folge dem Link:';


$lang['user_activated_email_subject']          = 'Aktivierung abgeschlossen';
$lang['user_activated_email_content_line1']    = 'Danke, für Ihre Registrierung bei %s. Um den Zugang zu aktiveren, folge bitte dem Link:';
$lang['user_activated_email_content_line2']    = 'Sollte dein Email-Programm den Link nicht erkennen, öffne bitte die folgende Adresse in deinem Browser und gib den Aktivierungscode ein:';

// Reset Pass
$lang['user_reset_pass_email_subject']         = 'Passwort zurückzusetzen';
$lang['user_reset_pass_email_body']            = 'Dein Passwort bei %s wurde zurückgesetzt. Wenn du dies nicht veranlasst hast, sende bitte umgehend eine Email an %s.';

// Profile
$lang['profile_of_title'] = '%s\'s Profil';

$lang['profile_user_details_label']    = 'Benutzer-Details';
$lang['profile_role_label']            = 'Funktion';
$lang['profile_registred_on_label']    = 'Registriert am';
$lang['profile_last_login_label']      = 'Letzte Anmeldung';
$lang['profile_male_label']            = 'Männlich';
$lang['profile_female_label']          = 'Weiblich';

$lang['profile_not_set_up']            = 'Dieser Benutzer hat kein Profil eingerichtet.';

$lang['profile_edit']                  = 'Dein Profil bearbeiten';

$lang['profile_personal_section']      = 'Persönliches';

$lang['profile_personal_section']      = 'Anzeige-Name';
$lang['profile_dob']                   = 'Geburtssdatum';
$lang['profile_dob_day']               = 'Tag';
$lang['profile_dob_month']             = 'Monat';
$lang['profile_dob_year']              = 'Jahr';
$lang['profile_gender']                = 'Geschlecht';
$lang['profile_gender_nt']            = 'Not Telling'; #translate
$lang['profile_gender_male']          = 'Male'; #translate
$lang['profile_gender_female']        = 'Female'; #translate
$lang['profile_bio']                   = 'Über mich';

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
$lang['profile_yim_handle']            = 'Yahoo! messenger';
$lang['profile_gtalk_handle']          = 'GTalk';

$lang['profile_avatar_section']        = 'Avatar';
$lang['profile_social_section']        = 'Soziales Netzwerk';

$lang['profile_gravatar']              = 'Gravatar';
$lang['profile_twitter']               = 'Twitter';

$lang['profile_edit_success']          = 'Dein Profil wurde gesichert.';
$lang['profile_edit_error']            = 'Ein Fehler ist aufgetreten.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn'] = 'Profil sichern';
