<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        	= 'Pridėti lauką prie vartotojo profilio';
$lang['user:profile_delete_success']           	= 'Vartotojo profilio laukas sėkmingai ištrintas';
$lang['user:profile_delete_failure']            = 'Buvo kalida trinant vartotojo profilio lauką';
$lang['profile_user_basic_data_label']  		= 'Pagrindinė informacija';
$lang['profile_company']         	  			= 'Įmonė';
$lang['profile_updated_on']           			= 'Atnaujinta';
$lang['user:profile_fields_label']	 		 	= 'Profilio laukai';

$lang['user:register_header']                  = 'Registracija';
$lang['user:register_step1']                   = '<strong>Žingsnis 1:</strong> Registracija';
$lang['user:register_step2']                   = '<strong>Žingsnis 2:</strong> Aktyvacija';

$lang['user:login_header']                     = 'Prisijungimas';

// titles
$lang['user:add_title']                        = 'Prideti vartotoją';
$lang['user:list_title'] 				       = 'Vartotojų sąrašas';
$lang['user:inactive_title']                   = 'Neaktyvuoti vartotojai';
$lang['user:active_title']                     = 'Aktyvuoti vartotojai';
$lang['user:registred_title']                  = 'Registruoti vartotojai';

// labels
$lang['user:edit_title']                       = 'Redaguoti vartotoją "%s"';
$lang['user:details_label']                    = 'Informacija';
$lang['user:first_name_label']                 = 'Vardas';
$lang['user:last_name_label']                  = 'Pavardė';
$lang['user:group_label']                      = 'Grupė';
$lang['user:activate_label']                   = 'Aktyvinti';
$lang['user:password_label']                   = 'Slaptažodis';
$lang['user:password_confirm_label']           = 'Patvortinti spaltažodį';
$lang['user:name_label']                       = 'Vardas';
$lang['user:joined_label']                     = 'Prisijungę';
$lang['user:last_visit_label']                 = 'Paskutinis vizitas';
$lang['user:never_label']                      = 'Nė karto';

$lang['user:no_inactives']                     = 'Nėra neaktyvių vartotojų.';
$lang['user:no_registred']                     = 'Nėra registruotų vartotojų.';

$lang['account_changes_saved']                 = 'Paskyros pakeitimai sėkmingai išsaugoti.';

$lang['indicates_required']                    = 'Rodomi privalomi laukai';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Išsiųsti aktyvavimo e.laišką';
$lang['user:do_not_activate']                  = 'Neaktyvuotas';
$lang['user:register_title']                   = 'Registruotis';
$lang['user:activate_account_title']           = 'Aktyvios paskyros';
$lang['user:activate_label']                   = 'Aktyvinti';
$lang['user:activated_account_title']          = 'Aktyvuotos paskyros';
$lang['user:reset_password_title']             = 'Atstatyti slaptažodį';
$lang['user:password_reset_title']             = 'Slaptažodis atstatytas';


$lang['user:error_username']                   = 'Vartotojo vardas, kurį jūs pasirinkote jau naudojamas';
$lang['user:error_email']                      = 'Pašto adresą, kurį įvedėte, jau naudojamas';

$lang['user:full_name']                        = 'Pilnas Vardas';
$lang['user:first_name']                       = 'Vardas';
$lang['user:last_name']                        = 'Pavardė';
$lang['user:username']                         = 'Vartotojo vardas';
$lang['user:display_name']                     = 'Rodomas vardas';
$lang['user:email_use'] 					   = 'buvo prisijungęs';
$lang['user:remember']                         = 'Prisiminti mane';
$lang['user:group_id_label']                   = 'Grupės ID';

$lang['user:level']                            = 'Vartotojo vaidmuo';
$lang['user:active']                           = 'Aktyvus';
$lang['user:lang']                             = 'Kalba';

$lang['user:activation_code']                  = 'Aktyvacijos kodas';

$lang['user:reset_instructions']			   = 'Irašykite jūsų vartotojo vardą arba el. pašto adresą';
$lang['user:reset_password_link']              = 'Pamiršote slaptažodį?';

$lang['user:activation_code_sent_notice']      = 'Laiškas buvo išsiųsta su jūsų aktyvacijos kodu.';
$lang['user:activation_by_admin_notice']       = 'Jūsų registracija laukia patvirtinimo administratoriaus.';
$lang['user:registration_disabled']            = 'Atsiprašome, bet vartotojų registracija yra atjungta.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section']                  = 'Vardas';
$lang['user:password_section']                 = 'Pakeisti slaptažodį';
$lang['user:other_settings_section']           = 'Kiti nustatymai';

$lang['user:settings_saved_success']           = 'Jūsų vartotojo paskyros parametrai buvo išsaugoti.';
$lang['user:settings_saved_error']             = 'Įvyko klaida.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']                     = 'Registruoti';
$lang['user:activate_btn']                     = 'Aktyvuoti';
$lang['user:reset_pass_btn']                   = 'Reset Pass';
$lang['user:login_btn']                        = 'Prisijungti';
$lang['user:settings_btn']                     = 'Išsaugoti nustatymus';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success']      = 'Naujas vartotojas buvo sukurtas ir aktyvuotas.';
$lang['user:added_not_activated_success']      = 'Naujas vartotojas buvo sukurtas, paskyra turi būti aktyvuota.';

// Edit
$lang['user:edit_user_not_found_error']        = 'Vartotojas nerastas.';
$lang['user:edit_success']                     = 'Vartotojas sėkmingai atnaujintas.';
$lang['user:edit_error']                       = 'Įvyko klaida bandant atnaujinti vartotoją.';

// Activate
$lang['user:activate_success']                 = '%s vartotojas iš %s sėkmingai aktyvuotas.';
$lang['user:activate_error']                   = 'Pirmaiu pasirinkite vartotoją.';

// Delete
$lang['user:delete_self_error']                = 'Jūs negalite ištrinti savęs!';
$lang['user:mass_delete_success']              = '%s vartotojas iš %s sėkmingai ištrintas.';
$lang['user:mass_delete_error']                = 'Pirmiau reikia pasirinkti vartotoją.';

// Register
$lang['user:email_pass_missing']               = 'Elektroninio pašto ar slaptažodžio laukai nėra užpildyti.';
$lang['user:email_exists']                     = 'Pašto adresas, kurį pasirinkote jau naudojamas kito vartotojo.';
$lang['user:register_error']				   = 'Mes galvojome kad jus esate spam robotas. Jeigu suklydome - atleiskite.';
$lang['user:register_reasons']                 = 'Prisijunkite tam, kad kauti prieimą prie skilčių, kurios yra neprieinamos paprastiems vartotojams. Daugiau turinio, mažiau reklamos.';


// Activation
$lang['user:activation_incorrect']             = 'Aktyvinimas nepavyko. Prašome patikrinti savo duomenis ir įsitikinkite ar nėra įjungtas CAPS LOCK.';
$lang['user:activated_message']                = 'Jūsų paskyra buvo aktyvuota, dabar galite prisijunkiti. ".';


// Login
$lang['user:logged_in']                        = 'Prisijungėte sėkmingai.';
$lang['user:already_logged_in']                = 'Jūs jau esate prisijungęs. Prašome atsijungti prieš bandant iš naujo.';
$lang['user:login_incorrect']                  = 'E-paštas arba slaptažodis nesutampa. Prašome patikrinti savo prisijungimo vardą ir įsitikinkite ar nėra įjungtas CAPS LOCK.';
$lang['user:inactive']                         = 'Paskyra kurią bandote pasiekti šiuo mety neaktyvi.<br/>Patikrinkite savo el.paštą, kuriame bus instrukcija kaip aktyvuoti paskyrą.<em>Laiškas gali patekti į nepageidaujamų laiškų katalogą</em>.';


// Logged Out
$lang['user:logged_out']                       = 'Jūs buvote atjungtas.';

// Forgot Pass
$lang['user:forgot_incorrect']                 = "Su šia informacija paskyros nerasta.";

$lang['user:password_reset_message']           = "Jūsų slaptažodis pakeistas. Turėtumėte gauti laišką per ateinančias 2 valandas. Jei nerasite, būtinai paieškokite nepageidaujamų laiškų kataloge.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject']         = 'Aktyvacija patvirtinta';
$lang['user:activation_email_body']            = 'Ačiū, kad aktyvavote savo paskyrą. Norėdami prisijungti prie svetainės, spauskite nuorodą esančia toliau.';


$lang['user:activated_email_subject']          = 'Aktyvacija užbaigta';
$lang['user:activated_email_content_line1']    = 'Ačiū už registraciją %s. Prieš mums patvirtinant aktyvaciją prašome užbaigti registraciją paspaudus nuorodą:';
$lang['user:activated_email_content_line2']    = 'Jei jūsų pašto programa neatpažįsta aukščiau esančios nuorodos, tuomet prašome tiesiogiai naršyklėje įvesti šį adresą:';

// Reset Pass
$lang['user:reset_pass_email_subject']         = 'Slaptažodžio keitimas';
$lang['user:reset_pass_email_body']            = 'Jūsų slaptažodis %s buvo anuliuotas. Jei neprašė šio pakeitimo, rašykite mums adresu %s ir mes išspręsti situaciją.';

// Profile
$lang['profile_of_title']             = '%s\'s Profilis';

$lang['profile_user_details_label']   = 'Vartotojo informacija';
$lang['profile_role_label']           = 'Vaidmuo';
$lang['profile_registred_on_label']   = 'Prisiregistravo';
$lang['profile_last_login_label']     = 'Paskutinis prisijungimas';
$lang['profile_male_label']           = 'Vyras';
$lang['profile_female_label']         = 'Moteris';

$lang['profile_not_set_up']           = 'Šis vartotojas neturi savo profilio.';

$lang['profile_edit']                 = 'Redaguoti profilį';

$lang['profile_personal_section']     = 'Asmeninis';

$lang['profile_display_name']         = 'Rodomas vardas';
$lang['profile_dob']                  = 'Gimimo data';
$lang['profile_dob_day']              = 'Diena';
$lang['profile_dob_month']            = 'Mėnuo';
$lang['profile_dob_year']             = 'Metai';
$lang['profile_gender']               = 'Lytis';
$lang['profile_gender_nt']            = 'Nesakysiu';
$lang['profile_gender_male']          = 'Vyras';
$lang['profile_gender_female']        = 'Moteris';
$lang['profile_bio']                  = 'Apie mane';

$lang['profile_contact_section']      = 'Kontaktai';

$lang['profile_phone']                = 'Tel.';
$lang['profile_mobile']               = 'Mob. tel.';
$lang['profile_address']              = 'Adresas';
$lang['profile_address_line1']        = 'Eilutė#1';
$lang['profile_address_line2']        = 'Eilutė #2';
$lang['profile_address_line3']        = 'Eilutė #3';
$lang['profile_address_postcode']     = 'Pašto/Zip Kodas';
$lang['profile_website']              = 'Internetinis puslapis';

$lang['profile_messenger_section']    = 'Mesendžeriai';

$lang['profile_msn_handle']           = 'MSN';
$lang['profile_aim_handle']           = 'AIM';
$lang['profile_yim_handle']           = 'Yahoo! messenger';
$lang['profile_gtalk_handle']         = 'GTalk';

$lang['profile_avatar_section']       = 'Avatar';
$lang['profile_social_section']       = 'Social';

$lang['profile_gravatar']             = 'Gravatar';
$lang['profile_twitter']              = 'Twitter';

$lang['profile_edit_success']         = 'Jūsų profilis buvo išsaugotas.';
$lang['profile_edit_error']           = 'Įvyko klaida.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn']             = 'Išsaugoti profilį';

/* End of file user_lang.php */