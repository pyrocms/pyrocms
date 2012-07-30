<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user_add_field']                        	= 'Add User Profile Field'; #translate
$lang['user_profile_delete_success']           	= 'User profile field deleted successfully'; #translate
$lang['user_profile_delete_failure']            = 'There was a problem with deleting your user profile field'; #translate
$lang['profile_user_basic_data_label']  		= 'Basic Data'; #translate
$lang['profile_company']         	  			= 'Company'; #translate
$lang['profile_updated_on']           			= 'Updated On'; #translate
$lang['user_profile_fields_label']	 		 	= 'Profile Fields'; #translate`

$lang['user_register_header']                  = 'Registrering';
$lang['user_register_step1']                   = '<strong>Step 1:</strong> Registrér';
$lang['user_register_step2']                   = '<strong>Step 2:</strong> Aktivér';

$lang['user_login_header']                     = 'Login';

// titles
$lang['user_add_title']                        = 'Tilføj bruger';
$lang['user_list_title'] 				= 'List brugere';
$lang['user_inactive_title']                   = 'Inaktive brugere';
$lang['user_active_title']                     = 'Aktive brugere';
$lang['user_registred_title']                  = 'Registrerede brugere';

// labels
$lang['user_edit_title']                       = 'Redigér bruger "%s"';
$lang['user_details_label']                    = 'Detaljer';
$lang['user_first_name_label']                 = 'Fornavn og mellemnavn';
$lang['user_last_name_label']                  = 'Efternavn';
$lang['user_email_label']                      = 'E-mail';
$lang['user_group_label']                      = 'Gruppe';
$lang['user_password_label']                   = 'Password';
$lang['user_password_confirm_label']           = 'Bekræft password';
$lang['user_name_label']                       = 'Navn';
$lang['user_joined_label']                     = 'Deltog';
$lang['user_last_visit_label']                 = 'Sidste besøg';
$lang['user_never_label']                      = 'Aldrig';

$lang['user_no_inactives']                     = 'Der er ingen inaktive brugere.';
$lang['user_no_registred']                     = 'Der er ingen registrede brugere.';

$lang['account_changes_saved']                 = 'Ændringerne i din konto er gemt.';

$lang['indicates_required']                    = 'Anfører påkrævede felter';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_send_activation_email']            = 'Send Activation Email'; #translate
$lang['user_do_not_activate']                  = 'Inactive'; #translate
$lang['user_register_title']                   = 'Registrér';
$lang['user_activate_account_title']           = 'Aktivér konto';
$lang['user_activate_label']                   = 'Aktivér';
$lang['user_activated_account_title']          = 'Aktiveret konto';
$lang['user_reset_password_title']             = 'Nulstil password';
$lang['user_password_reset_title']             = 'Password nulstillet';  


$lang['user_error_username']                   = 'Brugernavnet er allerede i brug';
$lang['user_error_email']                      = 'Email-adressen er allerede i brug';

$lang['user_full_name']                        = 'Fulde navn';
$lang['user_first_name']                       = 'Fornavn og mellemnavn';
$lang['user_last_name']                        = 'Efternavn';
$lang['user_username']                         = 'Brugernavn';
$lang['user_display_name']                     = 'Vist navn';
$lang['user_email_use'] 					   = 'bruges til login';
$lang['user_email']                            = 'E-mail';
$lang['user_confirm_email']                    = 'Bekræft E-mail';
$lang['user_password']                         = 'Password';
$lang['user_remember']                         = 'Husk mig';
$lang['user_confirm_password']                 = 'Bekræft password';
$lang['user_group_id_label']                   = 'Gruppe ID';

$lang['user_level']                            = 'Brugerrolle';
$lang['user_active']                           = 'Aktiv';
$lang['user_lang']                             = 'Sprog';

$lang['user_activation_code']                  = 'Aktiveringskode';

$lang['user_reset_instructions']			   = 'Enter your email address or username'; #translate
$lang['user_reset_password_link']              = 'Glemt password?';

$lang['user_activation_code_sent_notice']      = 'Du modtager nu en e-mail med din aktiveringskode.';
$lang['user_activation_by_admin_notice']       = 'Din registering afventer godkendelse af en administrator.';
$lang['user_registration_disabled']            = 'Sorry, but the user registration is disabled.'; #translate

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section']                  = 'Navn';
$lang['user_password_section']                 = 'Skift password';
$lang['user_other_settings_section']           = 'Andre indstillinger';

$lang['user_settings_saved_success']           = 'Indstillingerne for din brugerkonto er gemt.';
$lang['user_settings_saved_error']             = 'Der opstod en fejl.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']                     = 'Registrér';
$lang['user_activate_btn']                     = 'Aktivér';
$lang['user_reset_pass_btn']                   = 'Nulstil password';
$lang['user_login_btn']                        = 'Login';
$lang['user_settings_btn']                     = 'Gem indstillinger';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success']      = 'Ny bruger er oprettet og aktiveret.';
$lang['user_added_not_activated_success']      = 'Ny bruger er oprettet - kontoen skal aktiveres.';

// Edit
$lang['user_edit_user_not_found_error']        = 'Bruger ikke fundet.';
$lang['user_edit_success']                     = 'Bruger opdateret.';
$lang['user_edit_error']                       = 'Bruger kunne ikke opdateres.';

// Activate
$lang['user_activate_success']                 = '%s brugere ud af %s er aktiveret.';
$lang['user_activate_error']                   = 'Du skal først vælge brugere.';

// Delete
$lang['user_delete_self_error']                = 'Du kan ikke slette din egen bruger!';
$lang['user_mass_delete_success']              = '%s brugere ud af %s er slettet.';
$lang['user_mass_delete_error']                = 'Du skal først vælge brugere.';

// Register
$lang['user_email_pass_missing']               = 'Email- eller password-felterne er ikke korrekte.';
$lang['user_email_exists']                     = 'Den valgte email-adresse er allerede i brug.';
$lang['user_register_error']				   = 'We think you are a bot. If we are mistaken please accept our apologies.'; #translate
$lang['user_register_reasons']                 = 'Tilmeld dig for at få adgang til en række fordele. Dette betyder, at dine indstillinger vil blive gemt og mere indhold vil være tilgængeligt.';


// Activation
$lang['user_activation_incorrect']             = 'Aktiveringen mislykkedes. Prøv igen.';
$lang['user_activated_message']                = 'Din konto er aktiveret. Du kan nu logge ind.';


// Login
$lang['user_logged_in']                        = 'Du er nu logget ind.'; # TODO: Translate this in spanish
$lang['user_already_logged_in']                = 'Du er allerede logget ind.';
$lang['user_login_incorrect']                  = 'E-mail eller password er ikke korrekt.';
$lang['user_inactive']                         = 'Kontoen du forsøger at få adgang til, er inaktiv.<br />Tjek din e-mail for instruktioner om aktivering af kontoen - <em>den kan ligge i spam-mappen</em>.';


// Logged Out
$lang['user_logged_out']                       = 'Du er logget ud.';

// Forgot Pass
$lang['user_forgot_incorrect']                 = "Ingen konto blev fundet.";

$lang['user_password_reset_message']           = "Dit password er nulstillet. Du modtager en e-mail inden for de næste 2 timer.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject']         = 'Aktivering er påkrævet';
$lang['user_activation_email_body']            = 'Tak fordi du aktiverede din konto %s. For at logge ind kan du klikke på linket herunder:';


$lang['user_activated_email_subject']          = 'Aktivering gennemført';
$lang['user_activated_email_content_line1']    = 'Tak for din registering af %s. For at vi kan aktivere din konto bedes du klikke på dette link:';
$lang['user_activated_email_content_line2']    = 'Hvis linket ikke virker, bedes du indsætte linket i din browser og indtaste aktiveringskoden:';

// Reset Pass
$lang['user_reset_pass_email_subject']         = 'Password nulstillet';
$lang['user_reset_pass_email_body']            = 'Dit password for %s er nulstillet. Hvis du ikke har bedt om nulstilling, bedes du sende os en e-mail så vi kan løse problemet.';

// Profile
$lang['profile_of_title']             = '%s\'s profil';

$lang['profile_user_details_label']   = 'Brugerdetaljer';
$lang['profile_role_label']           = 'Rolle';
$lang['profile_registred_on_label']   = 'Registreret på';
$lang['profile_last_login_label']     = 'Sidste login';
$lang['profile_male_label']           = 'Mand';
$lang['profile_female_label']         = 'Kvinde';

$lang['profile_not_set_up']           = 'Denne bruger har ingen profilindstillinger.';

$lang['profile_edit']                 = 'Redigér din profil';

$lang['profile_personal_section']     = 'Personlig';

$lang['profile_display_name']         = 'Vist navn';  
$lang['profile_dob']                  = 'Fødselsdato';
$lang['profile_dob_day']              = 'Dag';
$lang['profile_dob_month']            = 'Måned';
$lang['profile_dob_year']             = 'År';
$lang['profile_gender']               = 'Køn';
$lang['profile_gender_nt']            = 'Ikke oplyst';
$lang['profile_gender_male']          = 'Mand';
$lang['profile_gender_female']        = 'Kvinde';
$lang['profile_bio']                  = 'Om mig';

$lang['profile_contact_section']      = 'Kontakt';

$lang['profile_phone']                = 'Telefon';
$lang['profile_mobile']               = 'Mobil';
$lang['profile_address']              = 'Adresse';
$lang['profile_address_line1']        = 'Adresse 1';
$lang['profile_address_line2']        = 'Adresse 2';
$lang['profile_address_line3']        = 'Adresse 3';
$lang['profile_address_postcode']     = 'Postnummer';
$lang['profile_website']              = 'Website';

$lang['profile_messenger_section']    = 'Instant messengers';

$lang['profile_msn_handle']           = 'MSN';
$lang['profile_aim_handle']           = 'AIM';
$lang['profile_yim_handle']           = 'Yahoo! messenger';
$lang['profile_gtalk_handle']         = 'GTalk';

$lang['profile_avatar_section']       = 'Avatar';
$lang['profile_social_section']       = 'Social';

$lang['profile_gravatar']             = 'Gravatar';
$lang['profile_twitter']              = 'Twitter';

$lang['profile_edit_success']         = 'Din profil er gemt.';
$lang['profile_edit_error']           = 'Der opstod et problem.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn']             = 'Gem profil';
/* End of file user_lang.php */
/* Location: ./system/cms/modules/users/language/english/user_lang.php */
