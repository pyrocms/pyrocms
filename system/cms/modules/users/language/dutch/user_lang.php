<?php

$lang['user:add_field']                        	= 'Voeg Gebruiker profiel veld toe';
$lang['user:profile_delete_success']           	= 'Gebruiker profiel veld is verwijderd';
$lang['user:profile_delete_failure']            = 'Er was een probleem met het verwijderen van uw gebruiker profiel veld';
$lang['profile_user_basic_data_label']  		= 'Basis gegevens';
$lang['profile_company']         	  			= 'Bedrijf';
$lang['profile_updated_on']           			= 'Gewijzigd op';
$lang['user:profile_fields_label']	 		 	= 'Profiel velden';

$lang['user:register_header'] 			= 'Registratie';
$lang['user:register_step1'] 			= '<b>Stap 1:</b> Registreren';
$lang['user:register_step2'] 			= '<b>Stap 2:</b> Activeren';

$lang['user:login_header'] 				= 'Login';

// titles
$lang['user:add_title'] 				= 'Voeg gebruiker toe';
$lang['user:list_title'] 				= 'Overzicht users';
$lang['user:inactive_title'] 			= 'Inactieve gebruikers';
$lang['user:active_title'] 				= 'Actieve gebruikers';
$lang['user:registred_title'] 			= 'Geregistreerde gebruikers';

// labels
$lang['user:edit_title'] 				= 'Wijzig user "%s"';
$lang['user:details_label'] 			= 'Details';
$lang['user:first_name_label'] 			= 'Voornaam';
$lang['user:last_name_label'] 			= 'Achternaam';
$lang['user:group_label'] 				= 'Groep';
$lang['user:activate_label'] 			= 'Activeer';
$lang['user:password_label'] 			= 'Wachtwoord';
$lang['user:password_confirm_label'] 	= 'Bevestig Wachtwoord';
$lang['user:name_label'] 				= 'Naam';
$lang['user:joined_label'] 				= 'Lid sinds';
$lang['user:last_visit_label'] 			= 'Laatste bezoek';
$lang['user:never_label'] 				= 'Nooit';

$lang['user:no_inactives'] 				= 'Er zijn geen inactieve gebruikers';
$lang['user:no_registred'] 				= 'Er zijn geen geregistreerde gebruikers';

$lang['account_changes_saved'] 			= 'De wijzigingen op uw account zijn opgeslagen.';

$lang['indicates_required'] 			= 'Geeft verplichte velden aan';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title'] 			= 'Registreren';
$lang['user:activate_account_title'] 	= 'Activeer Account';
$lang['user:activate_label'] 			= 'Activeer';
$lang['user:activated_account_title'] 	= 'Geactiveerd Account';
$lang['user:reset_password_title'] 		= 'Reset Wachtwoord';
$lang['user:password_reset_title'] 		= 'Wachtwoord Resetten';


$lang['user:error_username'] 			= 'De gebruikersnaam die u ingevoerd heeft is reeds in gebruik';
$lang['user:error_email'] 				= 'Het emailadres dat u ingevoerd heeft is reeds in gebruik';

$lang['user:full_name'] 				= 'Volledige naam';
$lang['user:first_name'] 				= 'Voornaam';
$lang['user:last_name'] 				= 'Achternaam';
$lang['user:username'] 					= 'Gebruikersnaam';
$lang['user:display_name']				= 'Schermnaam';
$lang['user:email_use'] 				= 'om in te loggen';
$lang['user:remember'] 					= 'Onthoud mij';
$lang['user:group_id_label']			= 'Groep ID';

$lang['user:level']						= 'Gebruikersrol';
$lang['user:active']					= 'Actief';
$lang['user:lang']						= 'Taal';

$lang['user:activation_code'] 			= 'Activeringscode';

$lang['user:reset_instructions']		= 'Vul uw e-mailadres of gebruikersnaam in a.u.b.';
$lang['user:reset_password_link'] 		= 'Wachtwoord vergeten?';

$lang['user:activation_code_sent_notice']	= 'Er is een email naar u gestuurd met daarin uw activeringscode.';
$lang['user:activation_by_admin_notice'] 	= 'Uw registratie wacht op goedkeuring door een beheerder.';
$lang['user:registration_disabled']            = 'Sorry, maar u kunt zich niet registreren.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section'] 			= 'Naam';
$lang['user:password_section'] 			= 'Wijzig wachtwoord';
$lang['user:other_settings_section'] 	= 'Andere instellingen';

$lang['user:settings_saved_success'] 	= 'De instellingen van uw gebruikersaccount zijn opgeslagen.';
$lang['user:settings_saved_error'] 		= 'Er is een fout opgetreden.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']				= 'Registreren';
$lang['user:activate_btn']				= 'Activeren';
$lang['user:reset_pass_btn'] 			= 'Reset WW';
$lang['user:login_btn'] 				= 'Login';
$lang['user:settings_btn'] 				= 'Instellingen opslaan';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success'] 		= 'Nieuwe gebruiker is aangemaakt en geactiveerd.';
$lang['user:added_not_activated_success'] 		= 'Nieuwe gebruik is aangemaakt, het account moet nog geactiveerd worden.';

// Edit
$lang['user:edit_user_not_found_error'] 		= 'Gebruiker niet gevonden.';
$lang['user:edit_success'] 						= 'Gebruiker is opgeslagen.';
$lang['user:edit_error'] 						= 'Er is een fout opgetreden bij het opslaan van de gebruiker.';

// Activate
$lang['user:activate_success'] 					= '%s gebruikers van %s zijn geactiveerd.';
$lang['user:activate_error'] 					= 'U moet eerst gebruikers selecteren.';

// Delete
$lang['user:delete_self_error'] 				= 'U kunt uzelf niet verwijderen!';
$lang['user:mass_delete_success'] 				= '%s gebruikers van %s zijn verwijderd.';
$lang['user:mass_delete_error'] 				= 'U moet eerst gebruikers selecteren.';

// Register
$lang['user:email_pass_missing'] 				= 'Email of Wachtwoord zijn niet compleet.';
$lang['user:email_exists'] 						= 'Het emailadres dat u ingevoerd heeft is al in gebruik bij een andere gebruiker.';
$lang['user:register_error']				   = 'Wij denken dat u een bot bent. Als wij het mis hebben, sorry.';
$lang['user:register_reasons'] 					= 'Registreer om afgeschermde gebieden te kunnen bezoeken. Ook worden uw instellingen onthouden. En bedenk: meer content, minder advertenties!';


// Activation
$lang['user:activation_incorrect']   			= 'Activatie is mislukt. Verifieer de gegevens en kijk of CAPS LOCK niet aanstaat.';
$lang['user:activated_message']   				= 'Uw account is geactiveerd, u kunt nu op uw account inloggen.';


// Login
$lang['user:logged_in']							= 'U bent ingelogd.';
$lang['user:already_logged_in'] 				= 'U bent al ingelogd. Log eerst uit voordat u het opnieuw probeert.';
$lang['user:login_incorrect'] 					= 'E-mail en wachtwoord kloppen niet. Verifieer uw logingegevens en kijk of CAPS LOCK niet aanstaat.';
$lang['user:inactive']   						= 'Het account waarop u probeer in te loggen is inactief.<br />Bekijk de e-mail met instructies hoe u uw account kunt activeren - <em>de mail kan ook in uw spamfolder zitten</em>.';


// Logged Out
$lang['user:logged_out']   						= 'U bent uitgelogd.';

// Forgot Pass
$lang['user:forgot_incorrect']   				= "Er is geen account gevonden met deze gegevens.";

$lang['user:password_reset_message']   			= "Uw wachtwoord is gereset. U kunt binnen 2 uur een mail verwachten. Mocht dit niet zo zijn, dan kan de mail per ongeluk in uw spamfolder terechtgekomen zijn.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject'] 			= 'Activatie benodigd';
$lang['user:activation_email_body'] 			= 'Hartelijk dank dat u uw account wilt activeren op %s. Om in te loggen op de site, klik op de link hieronder:';


$lang['user:activated_email_subject'] 			= 'Activatie voltooid';
$lang['user:activated_email_content_line1'] 	= 'Hartelijk dank voor uw registratie op %s. Voordat we uw account kunnen activeren, moet u het registratieproces voltooien. Klik hiervoor op de onderstaande link:';
$lang['user:activated_email_content_line2'] 	= 'Mocht uw emailprogramma deze tekst niet als link zien, kopieer dan de tekst in uw browser, en vul de activatiecode in:';

// Reset Pass
$lang['user:reset_pass_email_subject'] 			= 'Wachtwoord Reset';
$lang['user:reset_pass_email_body'] 			= 'Uw wachtwoord voor %s is opnieuw ingesteld . Mocht u hier niet om gevraagd hebben, stuur dan een een email naar %s zodat wij de situtie kunnen oplossen.';

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
$lang['profile_gender_nt']            = 'Niet aangegeven';
$lang['profile_gender_male']          = 'Man';
$lang['profile_gender_female']        = 'Vrouw';
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

$lang['profile_avatar_section'] 		= 'Avatar';

$lang['profile_edit_success'] 			= 'Uw profiel is opgeslagen.';
$lang['profile_edit_error'] 			= 'Er is een fout opgetreden.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn'] 				= 'Profiel Opslaan';
/* End of file user_lang.php */