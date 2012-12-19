<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        = 'Felhasználói profil mező hozzáadása';
$lang['user:profile_delete_success']           = 'Felhasználói profil mező sikeresen törölve';
$lang['user:profile_delete_failure']           = 'Probléma lépett fel a profil mező törlése közben';
$lang['profile_user_basic_data_label']         = 'Alap adatok';
$lang['profile_company']                       = 'Vállalat';
$lang['profile_updated_on']                    = 'Frissítve';
$lang['user:profile_fields_label']             = 'Profil mezők';

$lang['user:register_header']                  = 'Regisztálás';
$lang['user:register_step1']                   = '<strong>Első lépés:</strong> Regisztrálás';
$lang['user:register_step2']                   = '<strong>Második lépés:</strong> Aktiválás';

$lang['user:login_header']                     = 'Bejelentkezés';

// titles
$lang['user:add_title']                        = 'Felhasználó hozzáadása';
$lang['user:list_title']                       = 'Felhasználók listája';
$lang['user:inactive_title']                   = 'Inaktív felhasználók';
$lang['user:active_title']                     = 'Aktív felhasználók';
$lang['user:registred_title']                  = 'Regisztrált felhasználók';

// labels
$lang['user:edit_title']                       = 'Felhasználó "%s" módosítása';
$lang['user:details_label']                    = 'Részletek';
$lang['user:first_name_label']                 = 'Keresztnév';
$lang['user:last_name_label']                  = 'Vezetéknév';
$lang['user:group_label']                      = 'Csoport';
$lang['user:activate_label']                   = 'Aktivál';
$lang['user:password_label']                   = 'Jelszó';
$lang['user:password_confirm_label']           = 'Jelszó megerősítése';
$lang['user:name_label']                       = 'Név';
$lang['user:joined_label']                     = 'Csatlakozott';
$lang['user:last_visit_label']                 = 'Utolsó látogatás';
$lang['user:never_label']                      = 'Soha';

$lang['user:no_inactives']                     = 'Nincsenek inaktív felhasználók.';
$lang['user:no_registred']                     = 'Nincsenek regisztrált felhasználók.';

$lang['account_changes_saved']                 = 'A felhasználói fiók módosításai sikeresen el lettek mentve.';

$lang['indicates_required']                    = 'Jelezze a kötelező mezőket';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title']                   = 'Regisztráció';
$lang['user:activate_account_title']           = 'Fiók aktiválása';
$lang['user:activate_label']                   = 'Aktiválás';
$lang['user:activated_account_title']          = 'Aktivált';
$lang['user:reset_password_title']             = 'Jelszó törlése';
$lang['user:password_reset_title']             = 'Jelszó törlése';  


$lang['user:error_username']                   = 'A felhasználónév már foglalt';
$lang['user:error_email']                      = 'Az email cím már foglalt';

$lang['user:full_name']                        = 'Tejles név';
$lang['user:first_name']                       = 'Keresztnév';
$lang['user:last_name']                        = 'Vezetéknéve';
$lang['user:username']                         = 'Felhasználónév';
$lang['user:display_name']                     = 'Látható név';
$lang['user:email_use']                        = 'Bejelentkezéshez használt';
$lang['user:remember']                         = 'Emlékezzen rám';
$lang['user:group_id_label']                   = 'Csoport azonosító';

$lang['user:level']                            = 'Felhasználó beosztása';
$lang['user:active']                           = 'Aktív';
$lang['user:lang']                             = 'Nyelv';

$lang['user:activation_code']                  = 'Aktivációs kód';

$lang['user:reset_instructions']               = 'Add meg az e-mail címed vagy a felhasználóneved';
$lang['user:reset_password_link']              = 'Elfelejtett jelszó';

$lang['user:activation_code_sent_notice']      = 'Az aktivációs linket tartalmazó e-mail el lett küldve.';
$lang['user:activation_by_admin_notice']       = 'A regisztráció adminisztrátori megerősítésre vár.';
$lang['user:registration_disabled']            = 'A regisztráció pillanatnyilag szünetel.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section']                  = 'Név';
$lang['user:password_section']                 = 'Jelszó megváltoztatása';
$lang['user:other_settings_section']           = 'Egyéb beállítások';

$lang['user:settings_saved_success']           = 'A felhasználói fiók beállításai sikeresen elmentve.';
$lang['user:settings_saved_error']             = 'A felhasználói fiók beállításainak mentése sikertelen.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']                     = 'Regisztrál';
$lang['user:activate_btn']                     = 'Aktivál';
$lang['user:reset_pass_btn']                   = 'Jelszó újraküldés';
$lang['user:login_btn']                        = 'Bejelentkezés';
$lang['user:settings_btn']                     = 'Beállítások mentése';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success']      = 'Az új felhasználó sikeresen létrejött és használatra kész.';
$lang['user:added_not_activated_success']      = 'Az új felhasználó sikeresen létrejött és aktiválásra vár.';

// Edit
$lang['user:edit_user_not_found_error']        = 'Nincs ilyen felhasználó.';
$lang['user:edit_success']                     = 'Az adatok sikeresen módosítva.';
$lang['user:edit_error']                       = 'Az adatok módosítása sikertelen.';

// Activate
$lang['user:activate_success']                 = '%s felhasználóból %s sikeresen aktiválva lett.';
$lang['user:activate_error']                   = 'Előbb ki kell választani a felhasználókat.';

// Delete
$lang['user:delete_self_error']                = 'Nem tudod önmagad kitörölni!';
$lang['user:mass_delete_success']              = '%s felhasználóból %s törlése került.';
$lang['user:mass_delete_error']                = 'Előbb ki kell választani a felhasználókat.';

// Register
$lang['user:email_pass_missing']               = 'E-mail vagy a jelszó mezők nincsenek kitöltve.';
$lang['user:email_exists']                     = 'A megadott e-mail cím már használatban van egy másik felhasználó által.';
$lang['user:register_error']                   = 'Azt gondoljuk, hogy egy bot vagy. Ha tévednénk, fogadd bocsánatkérésünket!';
$lang['user:register_reasons']                 = 'Csatlakozz hogy további funkciókat érhess el. Ez azt jelenti hogy a beállításaid el lesznek mentve. Több tartalom, kevesebb reklám.';


// Activation
$lang['user:activation_incorrect']             = 'Aktiváció sikertelen. Ellenőrizd az adatokat még egyszer és bizonyosodj meg arról, hogy a CAPS LOCK ki legyen kapcsolva.';
$lang['user:activated_message']                = 'A felhasználói fiók aktiválva van és kész a használatra';


// Login
$lang['user:logged_in']                        = 'Sikeres bejelentkezés.'; 
$lang['user:already_logged_in']                = 'Már be vagy jelentkezve. Mielőtt újra bejelentkezz, előtte ki kell jelentkezned';
$lang['user:login_incorrect']                  = 'E-mail és jelszó nem egyeznek. Bizonyosodj meg arról hogy helyes adatokat írtál-e be és arról, hogy a CAPS LOCK ki van kapcsolva';
$lang['user:inactive']                         = 'A felhasználói fiók, amibe be szeretnél jelentkezni, jelenleg inaktív.<br />Ellenőrizd az email-jeidet további instrukciókért az aktiválással kapcsolatban - <em>lehet hogy a spam könyvtárba került</em>.';


// Logged Out
$lang['user:logged_out']                       = 'Sikeres kijelentkezés.';

// Forgot Pass
$lang['user:forgot_incorrect']                 = "Nem létezik ilyen felhasználói fiók.";

$lang['user:password_reset_message']           = "A jelszó nullázva lett. Érkezik egy email 2 órán belül a postafiókodba. Amennyiben nem találod, keresd a spam könyvtárban, véletlen ok folytán oda is kerülhet.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject']         = 'Aktiválás szükséges';
$lang['user:activation_email_body']            = 'Köszönjük hogy aktiváltad a felhasználói fiókodat %s. A bejelentkezéshez, kattints az alábbi linkre:';

$lang['user:activated_email_subject']          = 'Sikeres aktiváció';
$lang['user:activated_email_content_line1']    = 'Köszönjük hogy regisztráltál az oldalounkon (%s). Mielőtt aktiválni tudnád a felhasználói fiókodat, be kell fejezni a regisztrációs folyamatot a következő linkre kattintva: ';
$lang['user:activated_email_content_line2']    = 'Abban az esetben ha az email kliensed nem ismeri fel a linket, másold a böngésző címsorába az alábbi URL-t';

// Reset Pass
$lang['user:reset_pass_email_subject']         = 'Új jelszó';
$lang['user:reset_pass_email_body']            = 'A jelszavad a(z) "%s" weboldalon meg lett változtatva. Amennyiben nem te kezdeményezted a változást, kérjük írj egy levelet a %s címre és gondoskodunk a hiba javításáról.';

// Profile
$lang['profile_of_title']                      = '%s profilja';

$lang['profile_user_details_label']            = 'Felhasználói adatok';
$lang['profile_role_label']                    = 'Beosztás';
$lang['profile_registred_on_label']            = 'Regisztráció dátuma';
$lang['profile_last_login_label']              = 'Utolsó bejelentkezés';
$lang['profile_male_label']                    = 'Férfi';
$lang['profile_female_label']                  = 'Nő';

$lang['profile_not_set_up']                    = 'Ennek a felhaszálónak nincs profilja.';

$lang['profile_edit']                          = 'Profil módosítása';

$lang['profile_personal_section']              = 'Személyes';

$lang['profile_display_name']                  = 'Megjelenített név';
$lang['profile_dob']                           = 'Születési dátum';
$lang['profile_dob_day']                       = 'Nap';
$lang['profile_dob_month']                     = 'Hónap';
$lang['profile_dob_year']                      = 'Év';
$lang['profile_gender']                        = 'Nem';
$lang['profile_gender_nt']                     = 'Nincs megadva';
$lang['profile_gender_male']                   = 'Férfi';
$lang['profile_gender_female']                 = 'Nő';
$lang['profile_bio']                           = 'Rólam';

$lang['profile_contact_section']               = 'Elérhetőség';

$lang['profile_phone']                         = 'Telefon';
$lang['profile_mobile']                        = 'Mobil';
$lang['profile_address']                       = 'Cím';
$lang['profile_address_line1']                 = 'Cím #1';
$lang['profile_address_line2']                 = 'Cím #2';
$lang['profile_address_line3']                 = 'Város';
$lang['profile_address_postcode']              = 'Irányítószám';
$lang['profile_website']                       = 'Weboldal';

$lang['profile_api_section']                   = 'API hozzáférés';

$lang['profile_edit_success']                  = 'A felhasználói fiók elmentve.';
$lang['profile_edit_error']                    = 'Hiba lépett fel.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn']             = 'Profil mentése';

/* End of file user_lang.php */