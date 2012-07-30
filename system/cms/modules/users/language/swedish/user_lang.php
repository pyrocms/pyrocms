<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user_register_header']                  = 'Registrering';
$lang['user_register_step1']                   = '<strong>Steg 1:</strong> Registrera';
$lang['user_register_step2']                   = '<strong>Steg 2:</strong> Aktivera';

$lang['user_login_header']                     = 'Logga in';

// titles
$lang['user_add_title']                        = 'Lägg till användare';
$lang['user_list_title'] 					   = 'Användare';
$lang['user_inactive_title']                   = 'Inaktiva användare';
$lang['user_active_title']                     = 'Aktiva användare';
$lang['user_registred_title']                  = 'Registrerade användare';

// labels
$lang['user_edit_title']                       = 'Redigera användaruppgifter för "%s"';
$lang['user_details_label']                    = 'Användaruppgifter';
$lang['user_first_name_label']                 = 'Förnamn';
$lang['user_last_name_label']                  = 'Efternamn';
$lang['user_email_label']                      = 'E-post';
$lang['user_group_label']                      = 'Grupp';
$lang['user_password_label']                   = 'Lösenord';
$lang['user_password_confirm_label']           = 'Bekräfta lösenord';
$lang['user_name_label']                       = 'Namn';
$lang['user_joined_label']                     = 'Blev medlem';
$lang['user_last_visit_label']                 = 'Senaste besök';
$lang['user_never_label']                      = 'Aldrig';

$lang['user_no_inactives']                     = 'Det finna inga inaktiva användare.';
$lang['user_no_registred']                     = 'Det finns inga registrerade användare.';

$lang['account_changes_saved']                 = 'Dina användaruppgifter är sparade.';

$lang['indicates_required']                    = 'Obligatoriska fält';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_send_activation_email']            = 'Send Activation Email'; #translate
$lang['user_do_not_activate']                  = 'Inactive'; #translate
$lang['user_register_title']                   = 'Registrera';
$lang['user_activate_account_title']           = 'Aktivera användarkonto';
$lang['user_activate_label']                   = 'Aktivera';
$lang['user_activated_account_title']          = 'Aktiverat användarkonto';
$lang['user_reset_password_title']             = 'Återställ lösenord';
$lang['user_password_reset_title']             = 'Återställ lösenord';


$lang['user_error_username']                   = 'Valt användarnamn är upptaget';
$lang['user_error_email']                      = 'Angiven E-post används redan';

$lang['user_full_name']                        = 'För- och efternamn';
$lang['user_first_name']                       = 'Förnamn';
$lang['user_last_name']                        = 'Efternamn';
$lang['user_username']                         = 'Användarnamn';
$lang['user_display_name']                     = 'Namn som visas';
$lang['user_email_use'] 					   = 'används för inloggning';
$lang['user_email']                            = 'E-post';
$lang['user_confirm_email']                    = 'Bekräfta E-post';
$lang['user_password']                         = 'Lösenord';
$lang['user_remember']                         = 'Kom ihåg mig';
$lang['user_group_id_label']                   = 'Grupp ID';

$lang['user_level']                            = 'Användarroll';
$lang['user_active']                           = 'Aktiv';
$lang['user_lang']                             = 'Språk';

$lang['user_activation_code']                  = 'Aktiverings kod';

$lang['user_reset_instructions']			   = 'Ange ditt användarnamn eller E-post';
$lang['user_reset_password_link']              = 'Glömt lösenord?';

$lang['user_activation_code_sent_notice']      = 'Ett E-postmeddelande med din aktiveringskod har skickats till dig.';
$lang['user_activation_by_admin_notice']       = 'Din registrering väntar på att godkännas av en administratör.';
$lang['user_registration_disabled']            = 'Användarregistrering är inte aktiv.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section']                  = 'Namn';
$lang['user_password_section']                 = 'Byt lösenord';
$lang['user_other_settings_section']           = 'Andra inställningar';

$lang['user_settings_saved_success']           = 'Dina användarinställningar är sparade.';
$lang['user_settings_saved_error']             = 'Ett fel inträffade.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']                     = 'Registrera';
$lang['user_activate_btn']                     = 'Aktivera';
$lang['user_reset_pass_btn']                   = 'Återställ lösenord';
$lang['user_login_btn']                        = 'Logga in';
$lang['user_settings_btn']                     = 'Spara inställningar';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success']      = 'Ny användare har skapats och aktiverats.';
$lang['user_added_not_activated_success']      = 'Ny användare har skapats, användarkontot måste aktiveras.';

// Edit
$lang['user_edit_user_not_found_error']        = 'Användaren hittas inte.';
$lang['user_edit_success']                     = 'Användardata uppdaterad.';
$lang['user_edit_error']                       = 'Ett fel inträffade när användardata skulle sparas .';

// Activate
$lang['user_activate_success']                 = '%s användare av %s är aktiverade.';
$lang['user_activate_error']                   = 'Du måste välja användare först.';

// Delete
$lang['user_delete_self_error']                = 'Du kan inte radera ditt användarkonto!';
$lang['user_mass_delete_success']              = '%s användare av %s är raderade.';
$lang['user_mass_delete_error']                = 'Du måste välja användare först.';

// Register
$lang['user_email_pass_missing']               = 'E-post eller lösenord är inte korrekt ifyllda.';
$lang['user_email_exists']                     = 'E-postadressen används redan av en annan användare.';
$lang['user_register_error']				   = 'Vi misstänker add du är en bot. I fall vi har fel ber vi om ursäkt.';
$lang['user_register_reasons']                 = 'Registrera dig för att få tillgång till mer av webbplatsens information och funktionalitet.';


// Activation
$lang['user_activation_incorrect']             = 'Aktivering misslyckades. Kontrollera dina användardata och att CAPS LOCK inte är aktiverad.';
$lang['user_activated_message']                = 'Ditt användarkonto är nu aktiverat, du kan nu logga in.';


// Login
$lang['user_logged_in']                        = 'Du är nu inloggad'; 
$lang['user_already_logged_in']                = 'du är redan inloggad. Logga ut innan du försöker igen.';
$lang['user_login_incorrect']                  = 'E-post eller lösenord är felaktigt. Kontrollera dina inloggningsuppgifter och att CAPS LOCK inte är aktiverad.';
$lang['user_inactive']                         = 'Användarkontot är inaktiverat.<br />Se instruktioner i det E-postmeddelandet som skickats till dig - <em>Kontrollera att E-postmeddelandet inte fastnat i ev spamfilter </em>.';


// Logged Out
$lang['user_logged_out']                       = 'Du har blivit utloggad.';

// Forgot Pass
$lang['user_forgot_incorrect']                 = "Inget användarkonto finns med dessa uppgifter finns registrerat.";

$lang['user_password_reset_message']           = "Ditt lösenord har återställts. Du kommer att erhålla E-post inom 2h. I annat fall,kontrollera att E-postmeddelandet inte fastnat i ev spamfilter.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject']         = 'Aktivering av användarkonto';
$lang['user_activation_email_body']            = 'Tack för att du aktiverade ditt konto med %s. För att logga in på webbplatsen, använd länken nedan:';


$lang['user_activated_email_subject']          = 'Aktivering av konto genomförd';
$lang['user_activated_email_content_line1']    = 'Tack för din registrering på %s. Innan vi kan aktivera ditt användarkonto, färdigställ registreringsprocessen genom att använda följande länk:';
$lang['user_activated_email_content_line2']    = 'Om din mailklient inte kan visa denna länk, ange denna URL i din webbläsare och skriv in aktiveringskoden som visas nedan:';

// Reset Pass
$lang['user_reset_pass_email_subject']         = 'Ditt lösenord är nu återställt';
$lang['user_reset_pass_email_body']            = 'Ditt lösenord till %s är nu återställt. Om du inte själv begärt detta, skicka E-post till %s för support.';

// Profile
$lang['profile_of_title']             = '%s användarprofil';

$lang['profile_user_details_label']   = 'Användardata';
$lang['profile_role_label']           = 'Roll';
$lang['profile_registred_on_label']   = 'Registrerad';
$lang['profile_last_login_label']     = 'Inloggad senast';
$lang['profile_male_label']           = 'Man';
$lang['profile_female_label']         = 'Kvinna';

$lang['profile_not_set_up']           = 'Denna användare har inte registrerat någon användardata.';

$lang['profile_edit']                 = 'Redigera din användarprofil';

$lang['profile_personal_section']     = 'Personligt';

$lang['profile_display_name']         = 'Visningsnamn';
$lang['profile_dob']                  = 'Födelsedag';
$lang['profile_dob_day']              = 'Dag';
$lang['profile_dob_month']            = 'Månad';
$lang['profile_dob_year']             = 'År';
$lang['profile_gender']               = 'Kön';
$lang['profile_gender_nt']            = 'Berättar inte';
$lang['profile_gender_male']          = 'Man';
$lang['profile_gender_female']        = 'Kvinna';
$lang['profile_bio']                  = 'Om mig';

$lang['profile_contact_section']      = 'Kontakt';

$lang['profile_phone']                = 'Telefon';
$lang['profile_mobile']               = 'Mobil';
$lang['profile_address']              = 'Adress';
$lang['profile_address_line1']        = 'Rad #1';
$lang['profile_address_line2']        = 'Rad #2';
$lang['profile_address_line3']        = 'Postort';
$lang['profile_address_postcode']     = 'Postnummer';
$lang['profile_website']              = 'Webbplats';

$lang['profile_api_section']     	  = 'API tillgång';

$lang['profile_edit_success']         = 'Din anvvändarprofil är sparad.';
$lang['profile_edit_error']           = 'Ett fel inträffade.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn']             = 'Spara användarprofil';
/* End of file user_lang.php */