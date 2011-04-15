﻿<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user_register_header']                  = 'Registration';
$lang['user_register_step1']                   = '<strong>Žingsnis 1:</strong> Registracija';
$lang['user_register_step2']                   = '<strong>Žingsnis 2:</strong> Aktyvacija';

$lang['user_login_header']                     = 'Prisijungimas';

// titles
$lang['user_add_title']                        = 'Prideti vartotoją';
$lang['user_list_title'] 				= 'Vartotojų sąrašas';
$lang['user_inactive_title']                   = 'Neaktyvuoti vartotojai';
$lang['user_active_title']                     = 'Aktyvuoti vartotojai';
$lang['user_registred_title']                  = 'Registruoti vartotojai';

// labels
$lang['user_edit_title']                       = 'Redaguoti vartotoją "%s"';
$lang['user_details_label']                    = 'Informacija';
$lang['user_first_name_label']                 = 'Vardas';
$lang['user_last_name_label']                  = 'Pavardė';
$lang['user_email_label']                      = 'E-paštas';
$lang['user_group_label']                      = 'Grupė';
$lang['user_activate_label']                   = 'Aktyvinti';
$lang['user_password_label']                   = 'Slaptažodis';
$lang['user_password_confirm_label']           = 'Patvortinti spaltažodį';
$lang['user_name_label']                       = 'Vardas';
$lang['user_joined_label']                     = 'Prisijungę';
$lang['user_last_visit_label']                 = 'Paskutinis vizitas';
$lang['user_actions_label']                    = 'Veiksmai';
$lang['user_never_label']                      = 'Nė karto';
$lang['user_delete_label']                     = 'Ištrinti';
$lang['user_edit_label']                       = 'Redaguoti';
$lang['user_view_label']                       = 'Peržiūrėti';

$lang['user_no_inactives']                     = 'Nėra neaktyvių vartotojų.';
$lang['user_no_registred']                     = 'Nėra registruotų vartotojų.';

$lang['account_changes_saved']                 = 'Paskyros pakeitimai sėkmingai išsaugoti.';

$lang['indicates_required']                    = 'Rodomi privalomi laukai';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_register_title']                   = 'Registruotis';
$lang['user_activate_account_title']           = 'Aktyvios paskyros';
$lang['user_activate_label']                   = 'Aktyvinti';
$lang['user_activated_account_title']          = 'Aktyvuotos paskyros';
$lang['user_reset_password_title']             = 'Atstatyti slaptažodį';
$lang['user_password_reset_title']             = 'Slaptažodis atstatytas';  


$lang['user_error_username']                   = 'Vartotojo vardas, kurį jūs pasirinkote jau naudojamas';
$lang['user_error_email']                      = 'Pašto adresą, kurį įvedėte, jau naudojamas';

$lang['user_full_name']                        = 'Pilnas Vardas';
$lang['user_first_name']                       = 'Vardas';
$lang['user_last_name']                        = 'Pavardė';
$lang['user_username']                         = 'Vartotojo vardas';
$lang['user_display_name']                     = 'Rodomas vardas';
$lang['user_email']                            = 'E-paštas';
$lang['user_confirm_email']                    = 'Patvirtinti E-paštą';
$lang['user_password']                         = 'Slaptažodis';
$lang['user_remember']                         = 'Prisiminti mane';
$lang['user_confirm_password']                 = 'Patvirtinti slaptažodį';
$lang['user_group_id_label']                   = 'Grupės ID'; // #TRANSLATE #TODO: Translate this into Spanish

$lang['user_level']                            = 'Vartotojo vaidmuo';
$lang['user_active']                           = 'Aktyvus';
$lang['user_lang']                             = 'Kalba';

$lang['user_activation_code']                  = 'Aktyvacijos kodas';

$lang['user_reset_password_link']              = 'Pamiršote slaptažodį?';

$lang['user_activation_code_sent_notice']      = 'Laiškas buvo išsiųsta su jūsų aktyvacijos kodu.';
$lang['user_activation_by_admin_notice']       = 'Jūsų registracija laukia patvirtinimo administratoriaus.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section']                  = 'Vardas';
$lang['user_password_section']                 = 'Pakeisti slaptažodį';
$lang['user_other_settings_section']           = 'Kiti nustatymai';

$lang['user_settings_saved_success']           = 'Jūsų vartotojo paskyros parametrai buvo išsaugoti.';
$lang['user_settings_saved_error']             = 'Įvyko klaida.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']                     = 'Registruoti';
$lang['user_activate_btn']                     = 'Aktyvuoti';
$lang['user_reset_pass_btn']                   = 'Reset Pass';
$lang['user_login_btn']                        = 'Prisijungti';
$lang['user_settings_btn']                     = 'Išsaugoti nustatymus';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success']      = 'Naujas vartotojas buvo sukurtas ir aktyvuotas.';
$lang['user_added_not_activated_success']      = 'Naujas vartotojas buvo sukurtas, paskyra turi būti aktyvuota.';

// Edit
$lang['user_edit_user_not_found_error']        = 'Vartotojas nerastas.';
$lang['user_edit_success']                     = 'Vartotojas sėkmingai atnaujintas.';
$lang['user_edit_error']                       = 'Įvyko klaida bandant atnaujinti vartotoją.';

// Activate
$lang['user_activate_success']                 = '%s vartotojas iš %s sėkmingai aktyvuotas.';
$lang['user_activate_error']                   = 'Pirmaiu pasirinkite vartotoją.';

// Delete
$lang['user_delete_self_error']                = 'Jūs negalite ištrinti savęs!';
$lang['user_mass_delete_success']              = '%s vartotojas iš %s sėkmingai ištrintas.';
$lang['user_mass_delete_error']                = 'Pirmiau reikia pasirinkti vartotoją.';

// Register
$lang['user_email_pass_missing']               = 'Elektroninio pašto ar slaptažodžio laukai nėra užpildyti.';
$lang['user_email_exists']                     = 'Pašto adresas, kurį pasirinkote jau naudojamas kito vartotojo.';
$lang['user_register_reasons']                 = 'Join up to access special areas normally restricted. This means your settings will be remembered, more content and less ads.';


// Activation
$lang['user_activation_incorrect']             = 'Aktyvinimas nepavyko. Prašome patikrinti savo duomenis ir įsitikinkite ar nėra įjungtas CAPS LOCK.';
$lang['user_activated_message']                = 'Jūsų paskyra buvo aktyvuota, dabar galite prisijunkiti. ".';


// Login
$lang['user_logged_in']                        = 'Prisijungėte sėkmingai.'; # TODO: Translate this in spanish
$lang['user_already_logged_in']                = 'Jūs jau esate prisijungęs. Prašome atsijungti prieš bandant iš naujo.';
$lang['user_login_incorrect']                  = 'E-paštas arba slaptažodis nesutampa. Prašome patikrinti savo prisijungimo vardą ir įsitikinkite ar nėra įjungtas CAPS LOCK.';
$lang['user_inactive']                         = 'Paskyra kurią bandote pasiekti šiuo mety neaktyvi.<br/>Patikrinkite savo el.paštą, kuriame bus instrukcija kaip aktyvuoti paskyrą.<em>Laiškas gali patekti į nepageidaujamų laiškų katalogą</em>.';


// Logged Out
$lang['user_logged_out']                       = 'Jūs buvote atjungtas.';

// Forgot Pass
$lang['user_forgot_incorrect']                 = "Su šia informacija paskyros nerasta.";

$lang['user_password_reset_message']           = "Jūsų slaptažodis pakeistas. Turėtumėte gauti laišką per ateinančias 2 valandas. Jei nerasite, būtinai paieškokite nepageidaujamų laiškų kataloge.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject']         = 'Aktyvacija patvirtinta';
$lang['user_activation_email_body']            = 'Ačiū, kad aktyvavote savo paskyrą. Norėdami prisijungti prie svetainės, spauskite nuorodą esančia toliau.';


$lang['user_activated_email_subject']          = 'Aktyvacija užbaigta';
$lang['user_activated_email_content_line1']    = 'Ačiū už registraciją %s. Prieš mums patvirtinant aktyvaciją prašome užbaigti registraciją paspaudus nuorodą:';
$lang['user_activated_email_content_line2']    = 'Jei jūsų pašto programa neatpažįsta aukščiau esančios nuorodos, tuomet prašome tiesiogiai naršyklėje įvesti šį adresą:';

// Reset Pass
$lang['user_reset_pass_email_subject']         = 'Slaptažodžio keitimas';
$lang['user_reset_pass_email_body']            = 'Jūsų slaptažodis %s buvo anuliuotas. Jei neprašė šio pakeitimo, rašykite mums adresu %s ir mes išspręsti situaciją.';

/* End of file user_lang.php */
/* Location: ./system/pyrocms/modules/users/language/english/user_lang.php */