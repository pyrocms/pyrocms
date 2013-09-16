<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        	= 'Dodaj Polje Uporabnikovemu Profilu';
$lang['user:profile_delete_success']           	= 'Polje uporabnikovega profila uspešno izbrisan';
$lang['user:profile_delete_failure']            = 'Pri odstranjevanju polja iz uporabnikovega profila je prišlo do napake';
$lang['user:profile_user_basic_data_label']  	= 'Osnovni Podatki';
$lang['user:profile_company']         	  		= 'Podjetje';
$lang['user:profile_updated_on']           		= 'Posodobljeno';
$lang['user:profile_fields_label']	 		 	= 'Polja profila';

$lang['user:register_header']                  = 'Registracija';
$lang['user:register_step1']                   = '<strong>Korak 1:</strong> Registracija';
$lang['user:register_step2']                   = '<strong>Korak 2:</strong> Aktivacija';

$lang['user:login_header']                     = 'Prijava';

// titles
$lang['user:add_title']                        = 'Dodaj uporabnika';
$lang['user:list_title'] 					   = 'Seznam uporabnikov';
$lang['user:inactive_title']                   = 'Neaktivni uporabniki';
$lang['user:active_title']                     = 'Aktivni uporabniki';
$lang['user:registred_title']                  = 'Registrirani uporabniki';

// labels
$lang['user:edit_title']                       = 'Uredi uporabnika "%s"';
$lang['user:details_label']                    = 'Podrobnosti';
$lang['user:first_name_label']                 = 'Ime';
$lang['user:last_name_label']                  = 'Priimek';
$lang['user:group_label']                      = 'Skupina';
$lang['user:activate_label']                   = 'Akiviraj';
$lang['user:password_label']                   = 'Geslo';
$lang['user:password_confirm_label']           = 'Potrdi geslo';
$lang['user:name_label']                       = 'Uporabniško Ime';
$lang['user:joined_label']                     = 'Prijavljen';
$lang['user:last_visit_label']                 = 'Zadnja prijava';
$lang['user:never_label']                      = 'Nikoli';

$lang['user:no_inactives']                     = 'Ni neaktivnih uporabnikov';
$lang['user:no_registred']                     = 'Ni registriranih uporabnikov.';

$lang['account_changes_saved']                 = 'Spremembe vašega računa so bile uspešno shranjene.';

$lang['indicates_required']                    = 'Označuje obvezno polje';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title']                   = 'Registracija';
$lang['user:activate_account_title']           = 'Aktiviraj račun';
$lang['user:activate_label']                   = 'Aktiviran';
$lang['user:activated_account_title']          = 'Aktiviran račun';
$lang['user:reset_password_title']             = 'Ponastavi geslo';
$lang['user:password_reset_title']             = 'Ponastavitev gesla';

$lang['user:error_username']                   = 'Uporabniško ime katerega ste vnesli je že v uporabi';
$lang['user:error_email']                      = 'Email naslov katerega ste vnesli je že v uporabi';

$lang['user:full_name']                        = 'Polno ime';
$lang['user:first_name']                       = 'Ime';
$lang['user:last_name']                        = 'Priimek';
$lang['user:username']                         = 'Uporabniško ime';
$lang['user:display_name']                     = 'Prikazno ime';
$lang['user:email_use'] 					   = 'uporabljeno pri prijavi';
$lang['user:remember']                         = 'Zapomni si me';
$lang['user:group_id_label']                   = 'ID skupine';

$lang['user:level']                            = 'Vloga uporabnika';
$lang['user:active']                           = 'Aktiven';
$lang['user:lang']                             = 'Jezik';

$lang['user:activation_code']                  = 'Koda aktivacije';

$lang['user:reset_instructions']			   = 'Vnesite vaše uporabniško ime ali email naslov';
$lang['user:reset_password_link']              = 'Pozabili geslo?';

$lang['user:activation_code_sent_notice']      = 'Email je bil poslan na naveden naslov s aktivacijsko kodo.';
$lang['user:activation_by_admin_notice']       = 'Vaša registracija čaka na potrditev s strani administratorja.';
$lang['user:registration_disabled']            = 'Sorry, but the user registration is disabled.'; #translate

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section']                  = 'Ime';
$lang['user:password_section']                 = 'Spremeni geslo';
$lang['user:other_settings_section']           = 'Ostale nastavitve';

$lang['user:settings_saved_success']           = 'Nastavitve za vaš uporabniški račun so upešno shranjene.';
$lang['user:settings_saved_error']             = 'Prišlo je do napake.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']                     = 'Registracija';
$lang['user:activate_btn']                     = 'Aktiviraj';
$lang['user:reset_pass_btn']                   = 'Ponastavi geslo';
$lang['user:login_btn']                        = 'Prijava';
$lang['user:settings_btn']                     = 'Shrani nastavitve';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success']      = 'Nov uporabnik je bil ustvarjen in aktiviran.';
$lang['user:added_not_activated_success']      = 'Nov uporabnik je bil ustvarjen in čaka na aktivacijo';

// Edit
$lang['user:edit_user_not_found_error']        = 'Uporabnik ne obstaja.';
$lang['user:edit_success']                     = 'Uporabnik uspešno posodobljen.';
$lang['user:edit_error']                       = 'Pri posodobitvi uporabnika je prišlo do napake.';

// Activate
$lang['user:activate_success']                 = '%s uporabnikov od %s uspešno aktivirani.';
$lang['user:activate_error']                   = 'Najprej morate izbrati uporabnike.';

// Delete
$lang['user:delete_self_error']                = 'Ne morete izbrisati samega sebe!';
$lang['user:mass_delete_success']              = '%s uporabnikov od %s uspešno odstranjeni.';
$lang['user:mass_delete_error']                = 'Najprej morate izbrati uporabnike.';

// Register
$lang['user:email_pass_missing']               = 'Email ali geslo polje nista izpolnjena.';
$lang['user:email_exists']                     = 'Email naslov katerega ste vnesli je že v uporabi pri drugem uporabniku.';
$lang['user:register_error']				   = 'Mislimo da si robot. Če smo se zmotili sprejmite naše opravičilo in nas kontaktirajte.';
$lang['user:register_reasons']                 = 'Pridružite se za dostop do zaklenjenih predelov strani. To pomeni da bodo vaše nastavitve shranjene več vsebine manj oglasov.';

// Activation
$lang['user:activation_incorrect']             = 'Aktivacija ni uspela. Prosimo preverite vaše podrobnosti in prepričajte se da nimate vključenega CAPS LOCK-a.';
$lang['user:activated_message']                = 'Vaš račun je bil aktiviran. Sedaj se lahko prijavite v vaš uporabniški račun.';

// Login
$lang['user:logged_in']                        = 'Uspešno se se prijavili.';
$lang['user:already_logged_in']                = 'Ste že prijavljeni.Prosimo odjavite se predno ponovno poizkusite.';
$lang['user:login_incorrect']                  = 'E-mail ali geslo se ne ujemata. Prosimo preverite vaše prijavne podatke ter da nimate vključenega CAPS LOCK-a.';
$lang['user:inactive']                         = 'Račun do katerega želite dostopati je trenutno onemogočen.<br />Preverite vaš e-mail za navodila za aktivaicijo računa - <em>lahko da je v SPAM/JUNK mapi</em>.';

// Logged Out
$lang['user:logged_out']                       = 'Uspešno ste se odjavili.';

// Forgot Pass
$lang['user:forgot_incorrect']                 = "Račun s to prijavo ne obstaja.";

$lang['user:password_reset_message']           = "Vaše geslo je bilo ponastavljeno. Prejeli boste email v naslednjih 2 urah. Če ga ne prjemete se pripričajte še da ni morda v SPAM/JUNK mapi.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject']         = 'Zahtevana je aktivacija';
$lang['user:activation_email_body']            = 'Zahvaljujemo se vam za aktivacjo računa pri %s. Za prijavo na stran kliknite na spodaj navedeno povezavo:';

$lang['user:activated_email_subject']          = 'Aktivacija računa zaključena';
$lang['user:activated_email_content_line1']    = 'Zahvaljujemo se vam za registracijo pri %s. Predno lahko aktiviramo vaš račun, prosimo dokončajte registracijski postopek s klikom na spodnjo povezavo:';
$lang['user:activated_email_content_line2']    = 'V primeru da vaš email program ne podpira oz. ne prepozna spodnje povezave, prosimo skopirajte in prilepite povezavo v vaš brskalnik in vnesite aktivacijsko kodo:';

// Reset Pass
$lang['user:reset_pass_email_subject']         = 'Ponastavitev gesla';
$lang['user:reset_pass_email_body']            = 'Vaše geslo pri %s has je bilo ponastavljeno. Če niste zahtevali vi te spremembe prosimo sporočite nam to na email %s da uredimo situacijo.';

// Profile
$lang['user:profile_of_title']             = '%s\'ov Profil';

$lang['user:profile_user_details_label']   = 'Podrobnosti uporabnika';
$lang['user:profile_role_label']           = 'Vloga';
$lang['user:profile_registred_on_label']   = 'Registriran';
$lang['user:profile_last_login_label']     = 'Zadnja prijava';
$lang['user:profile_male_label']           = 'Ženska';
$lang['user:profile_female_label']         = 'Moški';

$lang['user:profile_not_set_up']           = 'Ta uporabnik nima nastavljenega profila.';

$lang['user:profile_edit']                 = 'Uredite svoj profil';

$lang['user:profile_personal_section']     = 'Osebno';

$lang['user:profile_display_name']         = 'Prikazno ime';
$lang['user:profile_dob']                  = 'Datum rojstva';
$lang['user:profile_dob_day']              = 'Dan';
$lang['user:profile_dob_month']            = 'Mesec';
$lang['user:profile_dob_year']             = 'Leto';
$lang['user:profile_gender']               = 'Spol';
$lang['user:profile_gender_nt']            = 'Ne povem';
$lang['user:profile_gender_male']          = 'Moški';
$lang['user:profile_gender_female']        = 'Ženska';
$lang['user:profile_bio']                  = 'O meni';

$lang['user:profile_contact_section']      = 'Kontakt';

$lang['user:profile_phone']                = 'Telefon';
$lang['user:profile_mobile']               = 'Mobitel';
$lang['user:profile_address']              = 'Naslov';
$lang['user:profile_address_line1']        = 'Vrstica #1';
$lang['user:profile_address_line2']        = 'Vrstica #2';
$lang['user:profile_address_line3']        = 'Vrstica #3';
$lang['user:profile_address_postcode']     = 'Poštna št.';
$lang['user:profile_website']              = 'Spletna stran';

$lang['user:profile_messenger_section']    = 'Instant sporočilniki';

$lang['user:profile_msn_handle']           = 'MSN';
$lang['user:profile_aim_handle']           = 'AIM';
$lang['user:profile_yim_handle']           = 'Yahoo! messenger';
$lang['user:profile_gtalk_handle']         = 'GTalk';

$lang['user:profile_avatar_section']       = 'Avatar';
$lang['user:profile_social_section']       = 'Social';

$lang['user:profile_gravatar']             = 'Gravatar';
$lang['user:profile_twitter']              = 'Twitter';

$lang['user:profile_edit_success']         = 'Vaš profil je bil shranjen.';
$lang['user:profile_edit_error']           = 'Prišlo je do napake.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['user:profile_save_btn']             = 'Shrani profil';

/* End of file user_lang.php */
