<?php  defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        	= 'Aggiungi un campo per il profilo Utente';
$lang['user:profile_delete_success']           	= 'Campo per il profilo utente eliminato con successo';
$lang['user:profile_delete_failure']            = 'Si è verificato un problema nel cancellare il campo per il profilo utente';
$lang['profile_user_basic_data_label']  		= 'Dati di base';
$lang['profile_company']         	  			= 'Società'; 
$lang['profile_updated_on']           			= 'Aggiornato il';
$lang['user:profile_fields_label']	 		 	= 'Campo del profilo';

$lang['user:register_header'] 			= 'Registrazione';
$lang['user:register_step1'] 			= '<strong>Passo 1:</strong> Registrazione';
$lang['user:register_step2'] 			= '<strong>Passo 2:</strong> Attivazione';

$lang['user:login_header'] 				= 'Entra';

// titles
$lang['user:add_title'] 				= 'Aggiungi utente';
$lang['user:list_title'] 				= 'Elenco utenti';
$lang['user:inactive_title'] 			= 'Utenti disattivati';
$lang['user:active_title'] 				= 'Utenti attivati';
$lang['user:registred_title'] 			= 'Utenti registrati';

// labels
$lang['user:edit_title'] 				= 'Modifica l\'utente "%s"';
$lang['user:details_label'] 			= 'Dettagli';
$lang['user:first_name_label'] 			= 'Nome';
$lang['user:last_name_label'] 			= 'Cognome';
$lang['user:group_label'] 				= 'Gruppo';
$lang['user:activate_label'] 			= 'Attiva';
$lang['user:password_label'] 			= 'Password';
$lang['user:password_confirm_label'] 	= 'Conferma Password';
$lang['user:name_label'] 				= 'Nome';
$lang['user:joined_label'] 				= 'Aggiunto';
$lang['user:last_visit_label'] 			= 'Ultima visita';
$lang['user:never_label'] 				= 'Mai';

$lang['user:no_inactives'] 				= 'Non ci sono utenti disattivati.';
$lang['user:no_registred'] 				= 'Non ci sono utenti registrati.';

$lang['account_changes_saved'] 			= 'Le modifiche al tuo profilo sono state salvate con successo.';

$lang['indicates_required'] 			= 'Indicano i campi richiesti';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Invia Email di attivazione';
$lang['user:do_not_activate']                  = 'Inattivo'; 
$lang['user:register_title'] 			= 'Registrati';
$lang['user:activate_account_title'] 	= 'Attiva il profilo';
$lang['user:activate_label'] 			= 'Attivazione';
$lang['user:activated_account_title'] 	= 'Profilo attivato';
$lang['user:reset_password_title'] 		= 'Reset Password';
$lang['user:password_reset_title'] 		= 'Password Reset';


$lang['user:error_username'] 			= 'La username scelto è già in uso'; 
$lang['user:error_email'] 				= 'L\'indirizzo email fornito è già in uso'; 

$lang['user:full_name'] 				= 'Nome completo';
$lang['user:first_name'] 				= 'Nome';
$lang['user:last_name'] 				= 'Cognome';
$lang['user:username'] 					= 'Username';
$lang['user:display_name']				= 'Nome visualizzato';
$lang['user:email_use'] 				= 'usato per il login';
$lang['user:remember'] 					= 'Ricordami';
$lang['user:group_id_label']			= 'ID del Gruppo'; 

$lang['user:level']						= 'Ruolo utente';
$lang['user:active']					= 'Attiva';
$lang['user:lang']						= 'Lingua';

$lang['user:activation_code'] 			= 'Codice di attivazione';

$lang['user:reset_instructions']			   = 'Inserisci il nome utente o l\'indirizzo email';
$lang['user:reset_password_link'] 		= 'Password dimenticata?';

$lang['user:activation_code_sent_notice']	= 'Ti è stata inviata una email con il tuo codice di attivazione.';
$lang['user:activation_by_admin_notice'] 	= 'La tua registrazione è in attesa di essere approvata da un amministratore.';
$lang['user:registration_disabled']            = 'Spiacenti ma la registrazione è disabilitata.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section'] 			= 'Nome';
$lang['user:password_section'] 			= 'Modifica password';
$lang['user:other_settings_section'] 	= 'Altre impostazioni';

$lang['user:settings_saved_success'] 	= 'Le impostazioni del tuo profilo sono state salvate.';
$lang['user:settings_saved_error'] 		= 'Si è verificato un errore.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']				= 'Registrati';
$lang['user:activate_btn']				= 'Attiva';
$lang['user:reset_pass_btn'] 			= 'Reset Password';
$lang['user:login_btn'] 				= 'Entra';
$lang['user:settings_btn'] 				= 'Salva Impostazioni';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success'] 		= 'Il nuovo utente è stato creato ed attivato.';
$lang['user:added_not_activated_success'] 		= 'Il nuovo utente è stato creato, necessita di essere attivato.';

// Edit
$lang['user:edit_user_not_found_error'] 		= 'Utente non trovato.';
$lang['user:edit_success'] 						= 'Utente aggiornato con successo.';
$lang['user:edit_error'] 						= 'Errore durante il tentativo di aggiornare l\'utente.';

// Activate
$lang['user:activate_success'] 					= '%s utenti su %s attivati con successo.';
$lang['user:activate_error'] 					= 'Devi prima selezionare gli utenti.';

// Delete
$lang['user:delete_self_error'] 				= 'Non puoi eliminare te stesso!';
$lang['user:mass_delete_success'] 				= '%s utenti su %s eliminati con successo.';
$lang['user:mass_delete_error'] 				= 'Devi prima selezionare gli utenti.';

// Register
$lang['user:email_pass_missing'] 				= 'I campi email o password sono incompleti';
$lang['user:email_exists'] 						= 'L\'indirizzo email che hai scelto è già in uso da un altro utente.';
$lang['user:register_error']				   = 'Crediamo tu sia un bot. Se ci sbagliamo ti chiediamo di accettare le nostre scuse.';
$lang['user:register_reasons'] 					= 'Unisciti per accedere ad aree speciali normalmente riservate. Questo significa che le tue impostazioni saranno salvate, più contenuti e minore pubblicità.';


// Activation
$lang['user:activation_incorrect']   			= 'Attivazione fallita. Verifica i tuoi dettagli e che non sia attivo il BLOCCO MAIUSCOLE.';
$lang['user:activated_message']   				= 'Il tuo profilo è stato attivato, ora puoi accedere.';


// Login
$lang['user:logged_in']							= 'Il login è avvenuto con successo.';
$lang['user:already_logged_in'] 				= 'Accesso già effettuato. Per favore disconnettiti e rieffettua l\'accesso.';
$lang['user:login_incorrect'] 					= 'Email o password non corrispondono. Verifica i tuoi dati e che non sia attivo il BLOCCO MAIUSCOLE.';
$lang['user:inactive']   						= 'Il profilo a cui stai cercando di accedere è disattivato.<br />Verifica la tua email per le istruzioni su come attivarlo - <em>potrebbero essere finite tra lo spam</em>.';


// Logged Out
$lang['user:logged_out']   						= 'Uscito con successo.';

// Forgot Pass
$lang['user:forgot_incorrect']   				= "Non è stato trovato nessun profilo con questi dettagli.";

$lang['user:password_reset_message']   			= "La tua password è stata resettata. Dovresti ricevere una email nelle prossime 2 ore. Se no la trovi, controlla che non sia finita per sbaglio fra la posta indesiderata.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject'] 			= 'Richiesta di Attivazione';
$lang['user:activation_email_body'] 			= 'Grazie di aver attivato il tuo profilo con %s. Per accedere al sito visita il collegamento qui di seguito:';


$lang['user:activated_email_subject'] 			= 'Attivazione Completata';
$lang['user:activated_email_content_line1'] 	= 'Grazie per esserti registrato con %s. Prima di attivare il tuo profilo, per favore completa la procedura di attivazione cliccando sul collegamento qui di seguito:';
$lang['user:activated_email_content_line2'] 	= 'Nel caso il tuo programma per le email non riconoscesse il collegamento quale tale, per favore vai con il tuo browser al segurnte indirizzo ed inserisci il codice di attivazione:';

// Reset Pass
$lang['user:reset_pass_email_subject'] 			= 'Password Reset';
$lang['user:reset_pass_email_body'] 			= 'La tua password di %s è stata resettata. Se non hai richiesto questa modifica inviaci per favore una email a %s e risolveremo il problema.';

// Profile
$lang['profile_of_title'] 				= 'Profilo di %s';

$lang['profile_user_details_label'] 	= 'Dettagli utente';
$lang['profile_role_label'] 			= 'Ruolo';
$lang['profile_registred_on_label'] 	= 'Registrato il';
$lang['profile_last_login_label'] 		= 'Ultimo accesso';
$lang['profile_male_label'] 			= 'Uomo';
$lang['profile_female_label'] 			= 'Donna';

$lang['profile_not_set_up'] 			= 'Questo utente non ha impostao un profilo.';

$lang['profile_edit'] 					= 'Modifica il tuo profilo';

$lang['profile_personal_section'] 		= 'Personale';

$lang['profile_display_name']			= 'Nome visualizzato';
$lang['profile_dob']					= 'Data di nascita';
$lang['profile_dob_day']				= 'Giorno';
$lang['profile_dob_month']				= 'Mese';
$lang['profile_dob_year']				= 'Anno';
$lang['profile_gender']					= 'Sesso';
$lang['profile_gender_nt']            = 'Non specificato'; 
$lang['profile_gender_male']          = 'Maschio'; 
$lang['profile_gender_female']        = 'Femmina'; 
$lang['profile_bio']					= 'Biografia';

$lang['profile_contact_section'] 		= 'Contatti';

$lang['profile_phone']					= 'Telefono';
$lang['profile_mobile']					= 'Cellulare';
$lang['profile_address']				= 'Indirizzo';
$lang['profile_address_line1'] 			= 'Linea #1';
$lang['profile_address_line2'] 			= 'Linea #2';
$lang['profile_address_line3'] 			= 'Linea #3';
$lang['profile_address_postcode'] 		= 'CAP';
$lang['profile_website']				= 'Sito'; 

$lang['profile_messenger_section'] 		= 'Messagistica istantanea';

$lang['profile_msn_handle'] 			= 'MSN';
$lang['profile_aim_handle'] 			= 'AIM';
$lang['profile_yim_handle'] 			= 'Yahoo! messenger';
$lang['profile_gtalk_handle'] 			= 'GTalk';

$lang['profile_avatar_section'] 		= 'Avatar';
$lang['profile_social_section'] 		= 'Social';

$lang['profile_gravatar'] 				= 'Gravatar';
$lang['profile_twitter'] 				= 'Twitter';

$lang['profile_edit_success'] 			= 'Il tuo profilo è stato salvato.';
$lang['profile_edit_error'] 			= 'Si è verificato un errore.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn'] 				= 'Salva profilo';
