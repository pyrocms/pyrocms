<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user_add_field']                        	= 'Add User Profile Field'; #translate
$lang['user_profile_delete_success']           	= 'User profile field deleted successfully'; #translate
$lang['user_profile_delete_failure']            = 'There was a problem with deleting your user profile field'; #translate
$lang['profile_user_basic_data_label']  		= 'Basic Data'; #translate
$lang['profile_company']         	  			= 'Company'; #translate
$lang['profile_updated_on']           			= 'Updated On'; #translate
$lang['user_profile_fields_label']	 		 	= 'Profile Fields'; #translate`

$lang['user_register_header']                  = 'Regisztálás';
$lang['user_register_step1']                   = '<strong>Első lépés:</strong> Regisztrálás';
$lang['user_register_step2']                   = '<strong>Második lépés:</strong> Aktiválás';

$lang['user_login_header']                     = 'Bejelentkezés';

// titles
$lang['user_add_title']                        = 'Felhasználó hozzáadása';
$lang['user_list_title'] 		       = 'Felhasználók listája';
$lang['user_inactive_title']                   = 'Inaktív felhasználók';
$lang['user_active_title']                     = 'Aktív felhasználók';
$lang['user_registred_title']                  = 'Regisztrált felhasználók';

// labels
$lang['user_edit_title']                       = 'Felhasználó "%s" módosítása';
$lang['user_details_label']                    = 'Részletek';
$lang['user_first_name_label']                 = 'Keresztnév';
$lang['user_last_name_label']                  = 'Vezetéknév';
$lang['user_email_label']                      = 'E-mail';
$lang['user_group_label']                      = 'Csoport';
$lang['user_password_label']                   = 'Jelszó';
$lang['user_password_confirm_label']           = 'Jelszó megerősítése';
$lang['user_name_label']                       = 'Név';
$lang['user_joined_label']                     = 'Csatlakozott';
$lang['user_last_visit_label']                 = 'Utolsó látogatás';
$lang['user_never_label']                      = 'Soha';

$lang['user_no_inactives']                     = 'Nincsenek inaktív felhasználók.';
$lang['user_no_registred']                     = 'Nincsenek regisztrált felhasználók.';

$lang['account_changes_saved']                 = 'A felhasználói fiók módosításai siekresen el lettek mentve.';

$lang['indicates_required']                    = 'Jelezze a kötelező mezőket';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_send_activation_email']            = 'Send Activation Email'; #translate
$lang['user_do_not_activate']                  = 'Inactive'; #translate
$lang['user_register_title']                   = 'Register';
$lang['user_activate_account_title']           = 'Activate Account';
$lang['user_activate_label']                   = 'Aktiválás';
$lang['user_activated_account_title']          = 'Aktivált';
$lang['user_reset_password_title']             = 'Jelszó törlése';
$lang['user_password_reset_title']             = 'Jelszó törlése';  


$lang['user_error_username']                   = 'A felhasználónév már foglalt';
$lang['user_error_email']                      = 'Az email cím már foglalt';

$lang['user_full_name']                        = 'Tejles név';
$lang['user_first_name']                       = 'Keresztnév';
$lang['user_last_name']                        = 'Vezetéknéve';
$lang['user_username']                         = 'Felhasználónév';
$lang['user_display_name']                     = 'Látható név';
$lang['user_email_use']                        = 'Bejelentkezéshez használt';
$lang['user_email']                            = 'E-mail';
$lang['user_confirm_email']                    = 'E-mail megerősítése';
$lang['user_password']                         = 'Jelszó';
$lang['user_remember']                         = 'Emlékezzen rám';
$lang['user_group_id_label']                   = 'Csoport azonosító';

$lang['user_level']                            = 'Felhasználó beosztása';
$lang['user_active']                           = 'Aktív';
$lang['user_lang']                             = 'Nyelv';

$lang['user_activation_code']                  = 'Aktivációs kód';

$lang['user_reset_instructions']               = 'Add meg az e-mail címed vagy a felhasználóneved';
$lang['user_reset_password_link']              = 'Elfelejtett jelszó';

$lang['user_activation_code_sent_notice']      = 'Az aktivációs linket tartalmazó e-mail el lett küldve.';
$lang['user_activation_by_admin_notice']       = 'A regisztráció adminisztrátori megerősítésre vár.';
$lang['user_registration_disabled']            = 'A regisztráció pillanatnyilag szünetel.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section']                  = 'Név';
$lang['user_password_section']                 = 'Jelszó megváltoztatása';
$lang['user_other_settings_section']           = 'Egyéb beállítások';

$lang['user_settings_saved_success']           = 'A felhasználói fiók beállításai sikeresen elmentve.';
$lang['user_settings_saved_error']             = 'A felhasználói fiók beállításainak mentése sikertelen.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']                     = 'Regisztrál';
$lang['user_activate_btn']                     = 'Aktivál';
$lang['user_reset_pass_btn']                   = 'Jelszó újraküldés';
$lang['user_login_btn']                        = 'Bejelentkezés';
$lang['user_settings_btn']                     = 'Beállítások mentése';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success']      = 'Az új felhasználó sikeresen létrejött és használatra kész.';
$lang['user_added_not_activated_success']      = 'Az új felhasználó sikeresen létrejött és aktiválásra vár.';

// Edit
$lang['user_edit_user_not_found_error']        = 'Nincs ilyen felhasználó.';
$lang['user_edit_success']                     = 'Az adatok sikeresen módosítva.';
$lang['user_edit_error']                       = 'Az adatok módosítása sikertelen.';

// Activate
$lang['user_activate_success']                 = '%s felhasználóból %s sikeresen aktiválva lett.';
$lang['user_activate_error']                   = 'Előbb ki kell választani a felhasználókat.';

// Delete
$lang['user_delete_self_error']                = 'Nem tudod önmagad kitörölni!';
$lang['user_mass_delete_success']              = '%s felhasználóból %s törlése került.';
$lang['user_mass_delete_error']                = 'Előbb ki kell választani a felhasználókat.';

// Register
$lang['user_email_pass_missing']               = 'E-mail vagy a jelszó mezők nincsenek kitöltve.';
$lang['user_email_exists']                     = 'A megadott e-mail cím már használatban van egy másik felhasználó által.';
$lang['user_register_error']                   = 'Azt gondoljuk, hogy egy bot vagy. Ha tévednénk, fogadd bocsánatkérésünket!';
$lang['user_register_reasons']                 = 'Join up to access special areas normally restricted. This means your settings will be remembered, more content and less ads.'; #translate


// Activation
$lang['user_activation_incorrect']             = 'Aktiváció sikertelen. Ellenőrizd az adatokat még egyszer és bizonyosodj meg arról, hogy a CAPS LOCK ki legyen kapcsolva.';
$lang['user_activated_message']                = 'A felhasználói fiók aktiválva van és kész a használatra';


// Login
$lang['user_logged_in']                        = 'Sikeres bejelentkezés.'; 
$lang['user_already_logged_in']                = 'Már be vagy jelentkezve. Mielőtt újra bejelentkezz, előtte ki kell jelentkezned';
$lang['user_login_incorrect']                  = 'E-mail és jelszó nem egyeznek. Bizonyosodj meg arról hogy helyes adatokat írtál-e be és arról, hogy a CAPS LOCK ki van kapcsolva';
$lang['user_inactive']                         = 'A felhasználói fiók, amibe be szeretnél jelentkezni, jelenleg inaktív.<br />Ellenőrizze az email-jeit további instrukciókért az aktiválással kapcsolatban - <em>lehet hogy a spam könyvtárba került</em>.';


// Logged Out
$lang['user_logged_out']                       = 'Sikeres kijelentkezés.';

// Forgot Pass
$lang['user_forgot_incorrect']                 = "Nem létezik ilyen felhasználói fiók.";

$lang['user_password_reset_message']           = "A jelszó nullázva lett. Érkezik egy email 2 órán belül a postafiókodba. Amennyiben nem találod, keresd a spam könyvtárban, véletlen ok folytán oda is kerülhet.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject']         = 'Aktiválás szükséges';
$lang['user_activation_email_body']            = 'Köszönjük hogy aktiváltad a felhasználói fiókodat %s. A bejelentkezéshez, kattints az alábbi linkre:';

$lang['user_activated_email_subject']          = 'Sikeres aktiváció';
$lang['user_activated_email_content_line1']    = 'Köszönjük hogy regisztráltál az oldalounkon (%s). Mielőtt aktiválni tudnád a felhasználói fiókodat, be kell fejezni a regisztrációs folyamatot a következő linkre kattintva: ';
$lang['user_activated_email_content_line2']    = 'Abban az esetben ha az email kliensed nem ismeri fel a linket, másold a böngésző címsorába az alábbi URL-t';

// Reset Pass
$lang['user_reset_pass_email_subject']         = 'Új jelszó';
$lang['user_reset_pass_email_body']            = 'A jelszavad a(z) "%s" weboldalon meg lett változtatva. Amennyiben nem te kezdeményezted a változást, kérjük írj egy levelet a %s címre és gondoskodunk a hiba javításáról.';

// Profile
$lang['profile_of_title']             = '%s profilja';

$lang['profile_user_details_label']   = 'Felhasználói adatok';
$lang['profile_role_label']           = 'Beosztás';
$lang['profile_registred_on_label']   = 'Regisztráció dátuma';
$lang['profile_last_login_label']     = 'Utolsó bejelentkezés';
$lang['profile_male_label']           = 'Férfi';
$lang['profile_female_label']         = 'Nő';

$lang['profile_not_set_up']           = 'Ennek a felhaszálónak nincs profilja.';

$lang['profile_edit']                 = 'Profil módosítása';

$lang['profile_personal_section']     = 'Személyes';

$lang['profile_display_name']         = 'Megjelenített név';  
$lang['profile_dob']                  = 'Születési dátum';
$lang['profile_dob_day']              = 'Nap';
$lang['profile_dob_month']            = 'Hónap';
$lang['profile_dob_year']             = 'Év';
$lang['profile_gender']               = 'Nem';
$lang['profile_gender_nt']            = 'Nincs megadva';
$lang['profile_gender_male']          = 'Férfi';
$lang['profile_gender_female']        = 'Nő';
$lang['profile_bio']                  = 'Rólam';

$lang['profile_contact_section']      = 'Elérhetőség';

$lang['profile_phone']                = 'Telefon';
$lang['profile_mobile']               = 'Mobil';
$lang['profile_address']              = 'Cím';
$lang['profile_address_line1']        = 'Cím #1';
$lang['profile_address_line2']        = 'Cím #2';
$lang['profile_address_line3']        = 'Város';
$lang['profile_address_postcode']     = 'Irányítószám';
$lang['profile_website']              = 'Weboldal';

$lang['profile_api_section']          = 'API hozzáférés';

$lang['profile_edit_success']         = 'A felhasználói fiók elmentve.';
$lang['profile_edit_error']           = 'Hiba lépett fel.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn']             = 'Profil mentése';
/* End of file user_lang.php */