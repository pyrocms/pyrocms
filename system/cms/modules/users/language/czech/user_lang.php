<?php

$lang['user:add_field']                        	= 'Add User Profile Field'; #translate
$lang['user:profile_delete_success']           	= 'User profile field deleted successfully'; #translate
$lang['user:profile_delete_failure']            = 'There was a problem with deleting your user profile field'; #translate
$lang['profile_user_basic_data_label']  		= 'Basic Data'; #translate
$lang['profile_company']         	  			= 'Company'; #translate
$lang['profile_updated_on']           			= 'Updated On'; #translate
$lang['user:profile_fields_label']	 		 	= 'Profile Fields'; #translate`

$lang['user:register_header'] 			= 'Registrace';
$lang['user:register_step1'] 			= '<strong>Krok 1:</strong> Registrace';
$lang['user:register_step2'] 			= '<strong>Krok 2:</strong> Aktivace';

$lang['user:login_header'] 				= 'Přihlášení';

// titles
$lang['user:add_title'] 				= 'Přidat uživatele';
$lang['user:list_title'] 				= 'Seznam uživatelů';
$lang['user:inactive_title'] 			= 'Neaktivní uživatelé';
$lang['user:active_title'] 				= 'Aktivní uživatelé';
$lang['user:registred_title'] 			= 'Registrovaní uživatelé';

// labels
$lang['user:edit_title'] 				= 'Upravit uživatele "%s"';
$lang['user:details_label'] 			= 'Detaily';
$lang['user:first_name_label'] 			= 'Křestní jméno';
$lang['user:last_name_label'] 			= 'Příjmení';
$lang['user:group_label'] 				= 'Skupina';
$lang['user:activate_label'] 			= 'Aktivace';
$lang['user:password_label'] 			= 'Heslo';
$lang['user:password_confirm_label'] 	= 'Potvrdit heslo';
$lang['user:name_label'] 				= 'Jméno';
$lang['user:joined_label'] 				= 'Uživatelem od';
$lang['user:last_visit_label'] 			= 'Poslední návštěva';
$lang['user:never_label'] 				= 'Nikdy';

$lang['user:no_inactives'] 				= 'Nejsou zde žádní neaktivní uživatelé.';
$lang['user:no_registred'] 				= 'Nejsou zde žádní registrovaní uživatelé.';

$lang['account_changes_saved'] 			= 'Změny byly uloženy.';

$lang['indicates_required'] 			= 'Značí povinná pole.';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title'] 			= 'Registrovat';
$lang['user:activate_account_title'] 	= 'Aktivovat účet';
$lang['user:activate_label'] 			= 'Aktivovat';
$lang['user:activated_account_title'] 	= 'Aktivovaný účet';
$lang['user:reset_password_title'] 		= 'Obnovit heslo';
$lang['user:password_reset_title'] 		= 'Obnovení hesla';


$lang['user:error_username'] 			= 'Zvolené uživatelské jméno je již použito';
$lang['user:error_email'] 				= 'Zvolený e-mail je již použit';

$lang['user:full_name'] 				= 'Celé jméno';
$lang['user:first_name'] 				= 'Křestní jméno';
$lang['user:last_name'] 				= 'Příjmení';
$lang['user:username'] 					= 'Uživatelské jméno';
$lang['user:display_name']				= 'Zobrazované jméno';
$lang['user:email_use'] 				= 'used to login'; #translate
$lang['user:remember'] 					= 'Zapamatovat';
$lang['user:group_id_label']			= 'ID skupiny';

$lang['user:level']						= 'Uživatelská role';
$lang['user:active']					= 'Aktivní';
$lang['user:lang']						= 'Jazyk';

$lang['user:activation_code'] 			= 'Aktivační kód';

$lang['user:reset_instructions']			   = 'Enter your email address or username'; #translate
$lang['user:reset_password_link'] 		= 'Zapomněl/a jste heslo?';

$lang['user:activation_code_sent_notice']	= 'E-mail s odkazem na obnovení hesla byl odeslán';
$lang['user:activation_by_admin_notice'] 	= 'Vaše registrace čeká na schválení administrátorem.';
$lang['user:registration_disabled']            = 'Sorry, but the user registration is disabled.'; #translate

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section'] 			= 'Jméno';
$lang['user:password_section'] 			= 'Změnit heslo';
$lang['user:other_settings_section'] 	= 'Další nastavení';

$lang['user:settings_saved_success'] 	= 'Nastavení bylo uloženo.';
$lang['user:settings_saved_error'] 		= 'Objevila se chyba.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']				= 'Registrovat';
$lang['user:activate_btn']				= 'Aktivovat';
$lang['user:reset_pass_btn'] 			= 'Obnovit heslo';
$lang['user:login_btn'] 				= 'Přihlásit se';
$lang['user:settings_btn'] 				= 'Uložit nastavení';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success'] 		= 'Nový uživatel byl vytvořen a aktivován.';
$lang['user:added_not_activated_success'] 		= 'Nový uživatel byl vytvořen, účet musí být aktivován';

// Edit
$lang['user:edit_user_not_found_error'] 		= 'Uživatel nebyl nalezen.';
$lang['user:edit_success'] 						= 'Uživatel byl upraven.';
$lang['user:edit_error'] 						= 'Objevila se chyba při úpravě uživatele.';

// Activate
$lang['user:activate_success'] 					= '%s uživatelů u %s bylo aktivováno.';
$lang['user:activate_error'] 					= 'Je třeba nejprve vybrat uživatele.';

// Delete
$lang['user:delete_self_error'] 				= 'Nemůžete vymazat sebe.';
$lang['user:mass_delete_success'] 				= '%s uživatelů z %s bylo vymazáno.';
$lang['user:mass_delete_error'] 				= 'Je třeba nejprve vybrat uživatele.';

// Register
$lang['user:email_pass_missing'] 				= 'E-mail nebo heslo není vyplněno správně.';
$lang['user:email_exists'] 					= 'Zvolený e-mail je již použit.';
$lang['user:register_error']				   = 'We think you are a bot. If we are mistaken please accept our apologies.'; #translate
$lang['user:register_reasons'] 					= 'Registrujte se a získejte přístup k částem webu, které jsou vám zatím skryty. Budeme si pamatovat vaše nastavení, uvidíte více obsahu a méně reklamy.';


// Activation
$lang['user:activation_incorrect']   			= 'Aktivace selhala. Prosím zkontrolujte zadané údaje a zda nemáte zapnutý CAPS LOCK.';
$lang['user:activated_message']   				= 'Váš účet byl aktivován, můžete se přihlásit';


// Login
$lang['user:logged_in']							= 'Přihlášení proběhlo v pořádku.';
$lang['user:already_logged_in'] 				= 'Jste již přihlášen/a. Prosím nejprve se odhlašte před dalším pokusem o přihlášení.';
$lang['user:login_incorrect'] 					= 'E-mail nebo heslo není vyplněno správně. Prosím zkontrolujte zadané údaje a zda nemáte zapnutý CAPS LOCK.';
$lang['user:inactive']   						= 'Účet, ke kterému se snažíte přihlásit je neaktivovaný.<br />Zkontrolujte svůj e-mail, zda najdete e-mail s instrukcemi k aktivaci - <em>můžete být ve spamovém koši</em>.';


// Logged Out
$lang['user:logged_out']   						= 'Odhlášení proběhlo úspěšně.';

// Forgot Pass
$lang['user:forgot_incorrect']   				= "Účet s těmito údaji nebyl nalezen.";

$lang['user:password_reset_message']   			= "Vaše heslo bylo obnoveno a e-mail s instrukcemi by měl přijít do dvou hodin. Pokud nedorazí, zkontrolujte pro jistotu složku se spamem.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject'] 			= 'Je vyžadována aktivace';
$lang['user:activation_email_body'] 			= 'Děkujeme za aktivaci účtu na %s. Pro přihlášení k účtu, klikněte prosím na níže uvedný odkaz:';


$lang['user:activated_email_subject'] 			= 'Aktivace dokončena';
$lang['user:activated_email_content_line1'] 	= 'Děkujeme za registraci k účtu na %s. Než budeme moci aktivovat váš účet, klikněte prosím na níže uvedený odkaz:';
$lang['user:activated_email_content_line2'] 	= 'V případě, že váš e-mailový klient nerozeznává výše uvedený odkaz, zkopírujte si prosím následující adresu, přejděte na ni v prohlížeči a vložte na dané stránce aktivační kód:';

// Reset Pass
$lang['user:reset_pass_email_subject'] 			= 'Obnovení hesla';
$lang['user:reset_pass_email_body'] 			= 'Vaše heslo na %s bylo obnoveno. Pokud jste si nevyžádal/a tuto změnu, napište nám prosím na %s a my se pokusíme situaci vyřešit.';

// Profile
$lang['profile_of_title'] 				= 'Profil - %s';

$lang['profile_user_details_label'] 	= 'Detaily';
$lang['profile_role_label'] 			= 'Role';
$lang['profile_registred_on_label'] 	= 'Registrace';
$lang['profile_last_login_label'] 		= 'Poslední přihlášení';
$lang['profile_male_label'] 			= 'Muž';
$lang['profile_female_label'] 			= 'Žena';

$lang['profile_not_set_up'] 			= 'Tento uživatel nemá vytvořený profil.';

$lang['profile_edit'] 					= 'Upravit svůj profil';

$lang['profile_personal_section'] 		= 'Osobní';

$lang['profile_display_name']			= 'Zobrazené jméno';
$lang['profile_dob']					= 'Datum narození';
$lang['profile_dob_day']				= 'Den';
$lang['profile_dob_month']				= 'Měsíc';
$lang['profile_dob_year']				= 'Rok';
$lang['profile_gender']					= 'Pohlaví';
$lang['profile_gender_nt']            = 'Not Telling'; #translate
$lang['profile_gender_male']          = 'Male'; #translate
$lang['profile_gender_female']        = 'Female'; #translate
$lang['profile_bio']					= 'O mně';

$lang['profile_contact_section'] 		= 'Kontakt';

$lang['profile_phone']					= 'Telefon';
$lang['profile_mobile']					= 'Mobil';
$lang['profile_address']				= 'Adresa';
$lang['profile_address_line1'] 			= 'Řádka #1';
$lang['profile_address_line2'] 			= 'Řádka #2';
$lang['profile_address_line3'] 			= 'Řádka #3';
$lang['profile_address_postcode'] 		= 'PSČ';
$lang['profile_website']				= 'Web';

$lang['profile_messenger_section'] 		= 'IM';

$lang['profile_msn_handle'] 			= 'MSN';
$lang['profile_aim_handle'] 			= 'AIM';
$lang['profile_yim_handle'] 			= 'Yahoo! messenger';
$lang['profile_gtalk_handle'] 			= 'GTalk';

$lang['profile_avatar_section'] 		= 'Profilový obrázek';
$lang['profile_social_section'] 		= 'Socialní sítě';

$lang['profile_gravatar'] 				= 'Gravatar';
$lang['profile_twitter'] 				= 'Twitter';

$lang['profile_edit_success'] 			= 'Váš profil byl uložen.';
$lang['profile_edit_error'] 			= 'Objevila se chyba.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn'] 				= 'Uložit profil';
