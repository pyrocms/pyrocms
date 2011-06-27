<?php

$lang['user_register_header'] 			= 'Registratie';
$lang['user_register_step1'] 			= '<strong>Stap 1:</strong> Registreren';
$lang['user_register_step2'] 			= '<strong>Stap 2:</strong> Activeren';

$lang['user_login_header'] 				= 'Login';

// titles
$lang['user_add_title'] 				= 'Voeg gebruiker toe';
$lang['user_list_title'] 				= 'List users'; #translate
$lang['user_inactive_title'] 			= 'Inactieve gebruikers';
$lang['user_active_title'] 				= 'Actieve gebruikers';
$lang['user_registred_title'] 			= 'Geregistreerde gebruikers';

// labels
$lang['user_edit_title'] 				= 'Wijzig user "%s"';
$lang['user_details_label'] 			= 'Details';
$lang['user_first_name_label'] 			= 'Voornaam';
$lang['user_last_name_label'] 			= 'Achternaam';
$lang['user_email_label'] 				= 'Email';
$lang['user_role_label'] 				= 'Rol';
$lang['user_activate_label'] 			= 'Activeer';
$lang['user_password_label'] 			= 'Wachtwoord';
$lang['user_password_confirm_label'] 	= 'Bevestig Wachtwoord';
$lang['user_name_label'] 				= 'Naam';
$lang['user_joined_label'] 				= 'Lid sinds';
$lang['user_last_visit_label'] 			= 'Laatste bezoek';
$lang['user_actions_label'] 			= 'Acties';
$lang['user_never_label'] 				= 'Nooit';
$lang['user_delete_label'] 				= 'Verwijder';
$lang['user_edit_label'] 				= 'Wijzig';
$lang['user_view_label'] 				= 'Bekijk';

$lang['user_no_inactives'] 				= 'Er zijn geen inactieve gebruikers';
$lang['user_no_registred'] 				= 'Er zijn geen geregistreerde gebruikers';

$lang['account_changes_saved'] 			= 'De wijzigingen op uw account zijn opgeslagen.';

$lang['indicates_required'] 			= 'Geeft verplichte velden aan';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_register_title'] 			= 'Registreren';
$lang['user_activate_account_title'] 	= 'Activeer Account';
$lang['user_activate_label'] 			= 'Activeer';
$lang['user_activated_account_title'] 	= 'Geactiveerd Account';
$lang['user_reset_password_title'] 		= 'Reset Wachtwoord';
$lang['user_password_reset_title'] 		= 'Wachtwoord Resetten';  


$lang['user_error_username'] 			= 'De gebruikersnaam die u ingevoerd heeft is reeds in gebruik'; // #TRANSLATE #TODO: Translate this into French, German, Polish and Spanish
$lang['user_error_email'] 				= 'Het emailadres dat u ingevoerd heeft is reeds in gebruik'; // #TRANSLATE #TODO: Translate this into French, German, Polish and Spanish

$lang['user_full_name'] 				= 'Volledige naam';
$lang['user_first_name'] 				= 'Voornaam';
$lang['user_last_name'] 				= 'Achternaam';
$lang['user_username'] 					= 'Gebruikersnaam'; // #TRANSLATE #TODO: Translate this into French, German, Polish and Spanish
$lang['user_display_name']				= 'Schermnaam'; // #TRANSLATE #TODO: Translate this into French, German, Polish and Spanish
$lang['user_email_use'] 				= 'om in te loggen'; #translate
$lang['user_email'] 					= 'E-mail';
$lang['user_confirm_email'] 			= 'Bevestig E-mail';
$lang['user_password'] 					= 'Wachtwoord';
$lang['user_remember'] 					= 'Onthoud mij'; // #TRANSLATE #TODO: Translate this into French, German, Polish and Spanish
$lang['user_confirm_password'] 			= 'Bevestig Wachtwoord';
$lang['user_group_id_label']			= 'Groep ID'; // #TRANSLATE #TODO: Translate this into French, German, Polish and Spanish

$lang['user_level']						= 'Gebruikersrol';
$lang['user_active']					= 'Actief';
$lang['user_lang']						= 'Taal';

$lang['user_activation_code'] 			= 'Activeringscode';

$lang['user_reset_password_link'] 		= 'Wachtwoord vergeten?';

$lang['user_activation_code_sent_notice']	= 'Er is een email naar u gestuurd met daarin uw activeringscode.';
$lang['user_activation_by_admin_notice'] 	= 'Uw registratie wacht op goedkeuring door een beheerder.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section'] 			= 'Naam';
$lang['user_password_section'] 			= 'Wijzig wachtwoord';
$lang['user_other_settings_section'] 	= 'Andere instellingen';

$lang['user_settings_saved_success'] 	= 'De instellingen van uw gebruikersaccount zijn opgeslagen.';
$lang['user_settings_saved_error'] 		= 'Er is een fout opgetreden.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']				= 'Registreren';
$lang['user_activate_btn']				= 'Activeren';
$lang['user_reset_pass_btn'] 			= 'Reset WW';
$lang['user_login_btn'] 				= 'Login';
$lang['user_settings_btn'] 				= 'Instellingen opslaan';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success'] 		= 'Nieuwe gebruiker is aangemaakt en geactiveerd.';
$lang['user_added_not_activated_success'] 		= 'Nieuwe gebruik is aangemaakt, het account moet nog geactiveerd worden.';

// Edit
$lang['user_edit_user_not_found_error'] 		= 'Gebruiker niet gevonden.';
$lang['user_edit_success'] 						= 'Gebruiker is opgeslagen.';
$lang['user_edit_error'] 						= 'Er is een fout opgetreden bij het opslaan van de gebruiker.';

// Activate
$lang['user_activate_success'] 					= '%s gebruikers van %s zijn geactiveerd.';
$lang['user_activate_error'] 					= 'U moet eerst gebruikers selecteren.';

// Delete
$lang['user_delete_self_error'] 				= 'U kunt uzelf niet verwijderen!';
$lang['user_mass_delete_success'] 				= '%s gebruikers van %s zijn verwijderd.';
$lang['user_mass_delete_error'] 				= 'U moet eerst gebruikers selecteren.';

// Register
$lang['user_email_pass_missing'] 				= 'Email of Wachtwoord zijn niet compleet.';
$lang['user_email_exists'] 						= 'Het emailadres dat u ingevoerd heeft is al in gebruik bij een andere gebruiker.';
$lang['user_register_reasons'] 					= 'Registreer om afgeschermde gebieden te kunnen bezoeken. Ook worden uw instellingen onthouden. En bedenk: meer content, minder advertenties!';


// Activation
$lang['user_activation_incorrect']   			= 'Activatie is mislukt. Verifieer de gegevens en kijk of CAPS LOCK niet aanstaat.';
$lang['user_activated_message']   				= 'Uw account is geactiveerd, u kunt nu op uw account inloggen.';


// Login
$lang['user_logged_in']							= 'You have logged in successfully.'; #translate
$lang['user_already_logged_in'] 				= 'U bent al ingelogd. Log eerst uit voordat u het opnieuw probeert.';
$lang['user_login_incorrect'] 					= 'E-mail en wachtwoord kloppen niet. Verifieer uw logingegevens en kijk of CAPS LOCK niet aanstaat.';
$lang['user_inactive']   						= 'Het account waarop u probeer in te loggen is inactief.<br />Bekijk de e-mail met instructies hoe u uw account kunt activeren - <em>de mail kan ook in uw spamfolder zitten</em>.';


// Logged Out
$lang['user_logged_out']   						= 'U bent uitgelogd.';

// Forgot Pass
$lang['user_forgot_incorrect']   				= "Er is geen account gevonden met deze gegevens.";

$lang['user_password_reset_message']   			= "Uw wachtwoord is gereset. U kunt binnen 2 uur een mail verwachten. Mocht dit niet zo zijn, dan kan de mail per ongeluk in uw spamfolder terechtgekomen zijn.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject'] 			= 'Activatie benodigd';
$lang['user_activation_email_body'] 			= 'Hartelijk dank dat u uw account wilt activeren op %s. Om in te loggen op de site, klik op de link hieronder:';


$lang['user_activated_email_subject'] 			= 'Activatie voltooid';
$lang['user_activated_email_content_line1'] 	= 'Hartelijk dank voor uw registratie op %s. Voordat we uw account kunnen activeren, moet u het registratieproces voltooien. Klik hiervoor op de onderstaande link:';
$lang['user_activated_email_content_line2'] 	= 'Mocht uw emailprogramma deze tekst niet als link zien, kopieer dan de tekst in uw browser, en vul de activatiecode in:';

// Reset Pass
$lang['user_reset_pass_email_subject'] 			= 'Wachtwoord Reset';
$lang['user_reset_pass_email_body'] 			= 'Uw wachtwoord voor %s is opnieuw ingesteld . Mocht u hier niet om gevraagd hebben, stuur dan een een email naar %s zodat wij de situtie kunnen oplossen.';

// Profile
$lang['profile_of_title'] 				= 'Profiel van %s';

$lang['profile_user_details_label'] 	= 'Gebruikersgegevens';
$lang['profile_role_label'] 			= 'Rol';
$lang['profile_registred_on_label'] 	= 'Geregistreerd op';
$lang['profile_last_login_label'] 		= 'Laatste login';
$lang['profile_male_label'] 			= 'Man';
$lang['profile_female_label'] 			= 'Vrouw';

$lang['profile_not_set_up'] 			= 'Deze gebruiker heeft nog geen profiel.';

$lang['profile_edit'] 					= 'Wijzig uw profiel';

$lang['profile_personal_section'] 		= 'Persoonlijk';

$lang['profile_display_name']			= 'Schermnaam';  
$lang['profile_dob']					= 'Geboortedatum';
$lang['profile_dob_day']				= 'Dag';
$lang['profile_dob_month']				= 'Maand';
$lang['profile_dob_year']				= 'Jaar';
$lang['profile_gender']					= 'Geslacht';
$lang['profile_gender_nt']            = 'Not Telling'; #translate
$lang['profile_gender_male']          = 'Male'; #translate
$lang['profile_gender_female']        = 'Female'; #translate
$lang['profile_bio']					= 'Over mij';

$lang['profile_contact_section'] 		= 'Contact';

$lang['profile_phone']					= 'Telefoonnummer';
$lang['profile_mobile']					= 'Mobiele nummer';
$lang['profile_address']				= 'Adres';
$lang['profile_address_line1'] 			= 'Regel #1';
$lang['profile_address_line2'] 			= 'Regel #2';
$lang['profile_address_line3'] 			= 'Regel #3';
$lang['profile_address_postcode'] 		= 'Postcode';
$lang['profile_website']				= 'Website';

$lang['profile_messenger_section'] 		= 'IM-accounts';

$lang['profile_msn_handle'] 			= 'MSN';
$lang['profile_aim_handle'] 			= 'AIM';
$lang['profile_yim_handle'] 			= 'Yahoo! messenger';
$lang['profile_gtalk_handle'] 			= 'GTalk';

$lang['profile_avatar_section'] 		= 'Avatar';
$lang['profile_social_section'] 		= 'Social';

$lang['profile_gravatar'] 				= 'Gravatar';
$lang['profile_twitter'] 				= 'Twitter';

$lang['profile_edit_success'] 			= 'Uw profiel is opgeslagen.';
$lang['profile_edit_error'] 			= 'Er is een fout opgetreden.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn'] 				= 'Profiel Opslaan';
