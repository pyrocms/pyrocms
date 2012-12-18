<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        	= 'Add User Profile Field'; #translate
$lang['user:profile_delete_success']           	= 'User profile field deleted successfully'; #translate
$lang['user:profile_delete_failure']            = 'There was a problem with deleting your user profile field'; #translate
$lang['profile_user_basic_data_label']  		= 'Basic Data'; #translate
$lang['profile_company']         	  			= 'Company'; #translate
$lang['profile_updated_on']           			= 'Updated On'; #translate
$lang['user:profile_fields_label']	 		 	= 'Profile Fields'; #translate`

$lang['user:register_header']                  = 'Registrering';
$lang['user:register_step1']                   = '<strong>Step 1:</strong> Registrér';
$lang['user:register_step2']                   = '<strong>Step 2:</strong> Aktivér';

$lang['user:login_header']                     = 'Login';

// titles
$lang['user:add_title']                        = 'Tilføj bruger';
$lang['user:list_title'] 				= 'List brugere';
$lang['user:inactive_title']                   = 'Inaktive brugere';
$lang['user:active_title']                     = 'Aktive brugere';
$lang['user:registred_title']                  = 'Registrerede brugere';

// labels
$lang['user:edit_title']                       = 'Redigér bruger "%s"';
$lang['user:details_label']                    = 'Detaljer';
$lang['user:first_name_label']                 = 'Fornavn og mellemnavn';
$lang['user:last_name_label']                  = 'Efternavn';
$lang['user:group_label']                      = 'Gruppe';
$lang['user:activate_label']                   = 'Aktivér';
$lang['user:password_label']                   = 'Password';
$lang['user:password_confirm_label']           = 'Bekræft password';
$lang['user:name_label']                       = 'Navn';
$lang['user:joined_label']                     = 'Deltog';
$lang['user:last_visit_label']                 = 'Sidste besøg';
$lang['user:never_label']                      = 'Aldrig';

$lang['user:no_inactives']                     = 'Der er ingen inaktive brugere.';
$lang['user:no_registred']                     = 'Der er ingen registrede brugere.';

$lang['account_changes_saved']                 = 'Ændringerne i din konto er gemt.';

$lang['indicates_required']                    = 'Anfører påkrævede felter';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title']                   = 'Registrér';
$lang['user:activate_account_title']           = 'Aktivér konto';
$lang['user:activate_label']                   = 'Aktivér';
$lang['user:activated_account_title']          = 'Aktiveret konto';
$lang['user:reset_password_title']             = 'Nulstil password';
$lang['user:password_reset_title']             = 'Password nulstillet';  


$lang['user:error_username']                   = 'Brugernavnet er allerede i brug';
$lang['user:error_email']                      = 'Email-adressen er allerede i brug';

$lang['user:full_name']                        = 'Fulde navn';
$lang['user:first_name']                       = 'Fornavn og mellemnavn';
$lang['user:last_name']                        = 'Efternavn';
$lang['user:username']                         = 'Brugernavn';
$lang['user:display_name']                     = 'Vist navn';
$lang['user:email_use'] 					   = 'bruges til login';
$lang['user:remember']                         = 'Husk mig';
$lang['user:confirm_password']                 = 'Bekræft password';
$lang['user:group_id_label']                   = 'Gruppe ID';

$lang['user:level']                            = 'Brugerrolle';
$lang['user:active']                           = 'Aktiv';
$lang['user:lang']                             = 'Sprog';

$lang['user:activation_code']                  = 'Aktiveringskode';

$lang['user:reset_instructions']			   = 'Enter your email address or username'; #translate
$lang['user:reset_password_link']              = 'Glemt password?';

$lang['user:activation_code_sent_notice']      = 'Du modtager nu en e-mail med din aktiveringskode.';
$lang['user:activation_by_admin_notice']       = 'Din registering afventer godkendelse af en administrator.';
$lang['user:registration_disabled']            = 'Sorry, but the user registration is disabled.'; #translate

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section']                  = 'Navn';
$lang['user:password_section']                 = 'Skift password';
$lang['user:other_settings_section']           = 'Andre indstillinger';

$lang['user:settings_saved_success']           = 'Indstillingerne for din brugerkonto er gemt.';
$lang['user:settings_saved_error']             = 'Der opstod en fejl.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']                     = 'Registrér';
$lang['user:activate_btn']                     = 'Aktivér';
$lang['user:reset_pass_btn']                   = 'Nulstil password';
$lang['user:login_btn']                        = 'Login';
$lang['user:settings_btn']                     = 'Gem indstillinger';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success']      = 'Ny bruger er oprettet og aktiveret.';
$lang['user:added_not_activated_success']      = 'Ny bruger er oprettet - kontoen skal aktiveres.';

// Edit
$lang['user:edit_user_not_found_error']        = 'Bruger ikke fundet.';
$lang['user:edit_success']                     = 'Bruger opdateret.';
$lang['user:edit_error']                       = 'Bruger kunne ikke opdateres.';

// Activate
$lang['user:activate_success']                 = '%s brugere ud af %s er aktiveret.';
$lang['user:activate_error']                   = 'Du skal først vælge brugere.';

// Delete
$lang['user:delete_self_error']                = 'Du kan ikke slette din egen bruger!';
$lang['user:mass_delete_success']              = '%s brugere ud af %s er slettet.';
$lang['user:mass_delete_error']                = 'Du skal først vælge brugere.';

// Register
$lang['user:email_pass_missing']               = 'Email- eller password-felterne er ikke korrekte.';
$lang['user:email_exists']                     = 'Den valgte email-adresse er allerede i brug.';
$lang['user:register_error']				   = 'We think you are a bot. If we are mistaken please accept our apologies.'; #translate
$lang['user:register_reasons']                 = 'Tilmeld dig for at få adgang til en række fordele. Dette betyder, at dine indstillinger vil blive gemt og mere indhold vil være tilgængeligt.';


// Activation
$lang['user:activation_incorrect']             = 'Aktiveringen mislykkedes. Prøv igen.';
$lang['user:activated_message']                = 'Din konto er aktiveret. Du kan nu logge ind.';


// Login
$lang['user:logged_in']                        = 'Du er nu logget ind.'; # TODO: Translate this in spanish
$lang['user:already_logged_in']                = 'Du er allerede logget ind.';
$lang['user:login_incorrect']                  = 'E-mail eller password er ikke korrekt.';
$lang['user:inactive']                         = 'Kontoen du forsøger at få adgang til, er inaktiv.<br />Tjek din e-mail for instruktioner om aktivering af kontoen - <em>den kan ligge i spam-mappen</em>.';


// Logged Out
$lang['user:logged_out']                       = 'Du er logget ud.';

// Forgot Pass
$lang['user:forgot_incorrect']                 = "Ingen konto blev fundet.";

$lang['user:password_reset_message']           = "Dit password er nulstillet. Du modtager en e-mail inden for de næste 2 timer.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject']         = 'Aktivering er påkrævet';
$lang['user:activation_email_body']            = 'Tak fordi du aktiverede din konto %s. For at logge ind kan du klikke på linket herunder:';


$lang['user:activated_email_subject']          = 'Aktivering gennemført';
$lang['user:activated_email_content_line1']    = 'Tak for din registering af %s. For at vi kan aktivere din konto bedes du klikke på dette link:';
$lang['user:activated_email_content_line2']    = 'Hvis linket ikke virker, bedes du indsætte linket i din browser og indtaste aktiveringskoden:';

// Reset Pass
$lang['user:reset_pass_email_subject']         = 'Password nulstillet';
$lang['user:reset_pass_email_body']            = 'Dit password for %s er nulstillet. Hvis du ikke har bedt om nulstilling, bedes du sende os en e-mail så vi kan løse problemet.';

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
