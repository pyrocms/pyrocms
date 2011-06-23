<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user_register_header']                  = 'Registracija';
$lang['user_register_step1']                   = '<strong>Korak 1:</strong> Registracija';
$lang['user_register_step2']                   = '<strong>Korak 2:</strong> Aktivacija';

$lang['user_login_header']                     = 'Prijava';

// titles
$lang['user_add_title']                        = 'Dodaj uporabnika';
$lang['user_list_title'] 				= 'Seznam uporabnikov';
$lang['user_inactive_title']                   = 'Neaktivni uporabniki';
$lang['user_active_title']                     = 'Aktivni uporabniki';
$lang['user_registred_title']                  = 'Registrirani uporabniki';

// labels
$lang['user_edit_title']                       = 'Uredi uporabnika "%s"';
$lang['user_details_label']                    = 'Podrobnosti';
$lang['user_first_name_label']                 = 'Ime';
$lang['user_last_name_label']                  = 'Priimek';
$lang['user_email_label']                      = 'E-mail';
$lang['user_group_label']                      = 'Skupina';
$lang['user_activate_label']                   = 'Akiviraj';
$lang['user_password_label']                   = 'Geslo';
$lang['user_password_confirm_label']           = 'Potrdi geslo';
$lang['user_name_label']                       = 'Uporabniško Ime';
$lang['user_joined_label']                     = 'Prijavljen';
$lang['user_last_visit_label']                 = 'Zadnja prijava';
$lang['user_actions_label']                    = 'Akcije';
$lang['user_never_label']                      = 'Nikoli';
$lang['user_delete_label']                     = 'Izbriši';
$lang['user_edit_label']                       = 'Uredi';
$lang['user_view_label']                       = 'Ogled';

$lang['user_no_inactives']                     = 'Ni neaktivnih uporabnikov';
$lang['user_no_registred']                     = 'Ni registriranih uporabnikov.';

$lang['account_changes_saved']                 = 'Spremembe vašega računa so bile uspešno shranjene.';

$lang['indicates_required']                    = 'Označuje obvezno polje';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_register_title']                   = 'Registracija';
$lang['user_activate_account_title']           = 'Aktiviraj račun';
$lang['user_activate_label']                   = 'Aktiviran';
$lang['user_activated_account_title']          = 'Aktiviran račun';
$lang['user_reset_password_title']             = 'Ponastavi geslo';
$lang['user_password_reset_title']             = 'Ponastavitev gesla';  


$lang['user_error_username']                   = 'Uporabniško ime katerega ste vnesli je že v uporabi';
$lang['user_error_email']                      = 'Email naslov katerega ste vnesli je že v uporabi';

$lang['user_full_name']                        = 'Polno ime';
$lang['user_first_name']                       = 'Ime';
$lang['user_last_name']                        = 'Priimek';
$lang['user_username']                         = 'Uporabniško ime';
$lang['user_display_name']                     = 'Prikazno ime';
$lang['user_email_use'] 					   = 'used to login'; #translate
$lang['user_email']                            = 'E-mail';
$lang['user_confirm_email']                    = 'Potrdi E-mail';
$lang['user_password']                         = 'Geslo';
$lang['user_remember']                         = 'Zapomni si me';
$lang['user_confirm_password']                 = 'Potrdi geslo';
$lang['user_group_id_label']                   = 'ID skupine';

$lang['user_level']                            = 'Vloga uporabnika';
$lang['user_active']                           = 'Aktiven';
$lang['user_lang']                             = 'Jezik';

$lang['user_activation_code']                  = 'Koda aktivacije';

$lang['user_reset_password_link']              = 'Pozabili geslo?';

$lang['user_activation_code_sent_notice']      = 'Email je bil poslan na naveden naslov s aktivacijsko kodo.';
$lang['user_activation_by_admin_notice']       = 'Vaša registracija čaka na potrditev s strani administratorja.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section']                  = 'Ime';
$lang['user_password_section']                 = 'Spremeni geslo';
$lang['user_other_settings_section']           = 'Ostale nastavitve';

$lang['user_settings_saved_success']           = 'Nastavitve za vaš uporabniški račun so upešno shranjene.';
$lang['user_settings_saved_error']             = 'Prišlo je do napake.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']                     = 'Registracija';
$lang['user_activate_btn']                     = 'Aktiviraj';
$lang['user_reset_pass_btn']                   = 'Ponastavi geslo';
$lang['user_login_btn']                        = 'Prijava';
$lang['user_settings_btn']                     = 'Shrani nastavitve';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success']      = 'Nov uporabnik je bil ustvarjen in aktiviran.';
$lang['user_added_not_activated_success']      = 'Nov uporabnik je bil ustvarjen in čaka na aktivacijo';

// Edit
$lang['user_edit_user_not_found_error']        = 'Uporabnik ne obstaja.';
$lang['user_edit_success']                     = 'Uporabnik uspešno posodobljen.';
$lang['user_edit_error']                       = 'Pri posodobitvi uporabnika je prišlo do napake.';

// Activate
$lang['user_activate_success']                 = '%s uporabnikov od %s uspešno aktivirani.';
$lang['user_activate_error']                   = 'Najprej morate izbrati uporabnike.';

// Delete
$lang['user_delete_self_error']                = 'Ne morete izbrisati samega sebe!';
$lang['user_mass_delete_success']              = '%s uporabnikov od %s uspešno odstranjeni.';
$lang['user_mass_delete_error']                = 'Najprej morate izbrati uporabnike.';

// Register
$lang['user_email_pass_missing']               = 'Email ali geslo polje nista izpolnjena.';
$lang['user_email_exists']                     = 'Email naslov katerega ste vnesli je že v uporabi pri drugem uporabniku.';
$lang['user_register_reasons']                 = 'Pridružite se za dostop do zaklenjenih predelov strani. To pomeni da bodo vaše nastavitve shranjene več vsebine manj oglasov.';


// Activation
$lang['user_activation_incorrect']             = 'Aktivacija ni uspela. Prosimo preverite vaše podrobnosti in prepričajte se da nimate vključenega CAPS LOCK-a.';
$lang['user_activated_message']                = 'Vaš račun je bil aktiviran. Sedaj se lahko prijavite v vaš uporabniški račun.';


// Login
$lang['user_logged_in']                        = 'Uspešno se se prijavili.'; 
$lang['user_already_logged_in']                = 'Ste že prijavljeni.Prosimo odjavite se predno ponovno poizkusite.';
$lang['user_login_incorrect']                  = 'E-mail ali geslo se ne ujemata. Prosimo preverite vaše prijavne podatke ter da nimate vključenega CAPS LOCK-a.';
$lang['user_inactive']                         = 'Račun do katerega želite dostopati je trenutno onemogočen.<br />Preverite vaš e-mail za navodila za aktivaicijo računa - <em>lahko da je v SPAM/JUNK mapi</em>.';


// Logged Out
$lang['user_logged_out']                       = 'Uspešno ste se odjavili.';

// Forgot Pass
$lang['user_forgot_incorrect']                 = "Račun s to prijavo ne obstaja.";

$lang['user_password_reset_message']           = "Vaše geslo je bilo ponastavljeno. Prejeli boste email v naslednjih 2 urah. Če ga ne prjemete se pripričajte še da ni morda v SPAM/JUNK mapi.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject']         = 'Zahtevana je aktivacija';
$lang['user_activation_email_body']            = 'Zahvaljujemo se vam za aktivacjo računa pri %s. Za prijavo na stran kliknite na spodaj navedeno povezavo:';


$lang['user_activated_email_subject']          = 'Aktivacija računa zaključena';
$lang['user_activated_email_content_line1']    = 'Zahvaljujemo se vam za registracijo pri %s. Predno lahko aktiviramo vaš račun, prosimo dokončajte registracijski postopek s klikom na spodnjo povezavo:';
$lang['user_activated_email_content_line2']    = 'V primeru da vaš email program ne podpira oz. ne prepozna spodnje povezave, prosimo skopirajte in prilepite povezavo v vaš brskalnik in vnesite aktivacijsko kodo:';

// Reset Pass
$lang['user_reset_pass_email_subject']         = 'Ponastavitev gesla';
$lang['user_reset_pass_email_body']            = 'Vaše geslo pri %s has je bilo ponastavljeno. Če niste zahtevali vi te spremembe prosimo sporočite nam to na email %s da uredimo situacijo.';

/* End of file user_lang.php */
/* Location: ./system/pyrocms/modules/users/language/slovenian/user_lang.php */