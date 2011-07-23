<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Finnish translation.
 * 
 * @author Mikael Kundert <mikael@kundert.fi>
 * @date 07.02.2011
 * @version 1.0.3
 */

$lang['user_register_header']                  = 'Rekisteröityminen';
$lang['user_register_step1']                   = '<strong>Vaihe 1:</strong> Rekisteröityminen';
$lang['user_register_step2']                   = '<strong>Vaihe 2:</strong> Aktivointi';

$lang['user_login_header']                     = 'Kirjaudu';

// titles
$lang['user_add_title']                        = 'Lisää käyttäjä';
$lang['user_list_title']					   = 'Listaa käyttäjät';
$lang['user_inactive_title']                   = 'Ei-aktiiviset käyttäjät';
$lang['user_active_title']                     = 'Aktiiviset käyttäjät';
$lang['user_registred_title']                  = 'Rekisteröityneet käyttäjät';

// labels
$lang['user_edit_title']                       = 'Muokkaa käyttäjää "%s"';
$lang['user_details_label']                    = 'Tiedot';
$lang['user_first_name_label']                 = 'Etunimi';
$lang['user_last_name_label']                  = 'Sukunimi';
$lang['user_email_label']                      = 'Sähköposti';
$lang['user_group_label']                      = 'Ryhmä';
$lang['user_activate_label']                   = 'Aktivoi';
$lang['user_password_label']                   = 'Salasana';
$lang['user_password_confirm_label']           = 'Vahvista salasana';
$lang['user_name_label']                       = 'Nimi';
$lang['user_joined_label']                     = 'Liittynyt';
$lang['user_last_visit_label']                 = 'Viimeksi paikalla';
$lang['user_actions_label']                    = 'Toiminnot';
$lang['user_never_label']                      = 'Ei koskaan';
$lang['user_delete_label']                     = 'Poista';
$lang['user_edit_label']                       = 'Muokkaa';
$lang['user_view_label']                       = 'Katso';

$lang['user_no_inactives']                     = 'Ei-aktiivisia käyttäjiä ei löytynyt.';
$lang['user_no_registred']                     = 'Rekisteröityneitä käyttäjiä ei löytynyt.';

$lang['account_changes_saved']                 = 'Tilin muutokset tallennettiin.';

$lang['indicates_required']                    = 'Merkitsee pakolliset kentät';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_register_title']                   = 'Rekisteöityminen';
$lang['user_activate_account_title']           = 'Aktivoi tili';
$lang['user_activate_label']                   = 'Aktivoi';
$lang['user_activated_account_title']          = 'Tili aktivointiin';
$lang['user_reset_password_title']             = 'Nollaa salasana';
$lang['user_password_reset_title']             = 'Salasanan nollaaminen';  


$lang['user_error_username']                   = 'Käyttäjänimi, jonka syötit on jo käytössä';
$lang['user_error_email']                      = 'Sähköpostiosoite, jonka syötit on jo käytössä';

$lang['user_full_name']                        = 'Koko nimi';
$lang['user_first_name']                       = 'Etunimi';
$lang['user_last_name']                        = 'Sukunimi';
$lang['user_username']                         = 'Käyttäjätunnus';
$lang['user_display_name']                     = 'Näyttönimi';
$lang['user_email_use'] 					   = 'used to login'; #translate
$lang['user_email']                            = 'Sähköposti';
$lang['user_confirm_email']                    = 'Vahvista sähköposti';
$lang['user_password']                         = 'Salasana';
$lang['user_remember']                         = 'Muista minut';
$lang['user_confirm_password']                 = 'Vahvista salasana';
$lang['user_group_id_label']                   = 'Ryhmän ID';

$lang['user_level']                            = 'Käyttäjärooli';
$lang['user_active']                           = 'Aktiivinen';
$lang['user_lang']                             = 'Kieli';

$lang['user_activation_code']                  = 'Aktivointi koodi';

$lang['user_reset_password_link']              = 'Unohditko salasanan?';

$lang['user_activation_code_sent_notice']      = 'Aktivointi koodi lähetettiin sähköpostiisi.';
$lang['user_activation_by_admin_notice']       = 'Rekisteröityminen vaatii ylläpidon hyväksymisen.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section']                  = 'Nimi';
$lang['user_password_section']                 = 'Vaihda salasana';
$lang['user_other_settings_section']           = 'Muut asetukset';

$lang['user_settings_saved_success']           = 'Käyttäjätilin asetukset tallennettiin.';
$lang['user_settings_saved_error']             = 'Tapahtui virhe.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']                     = 'Rekisteröidy';
$lang['user_activate_btn']                     = 'Aktivoi';
$lang['user_reset_pass_btn']                   = 'Nollaa salasana';
$lang['user_login_btn']                        = 'Kirjaudu';
$lang['user_settings_btn']                     = 'Tallenna asetukset';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success']      = 'Uusi käyttäjä luotiin ja aktivoitiin.';
$lang['user_added_not_activated_success']      = 'Uusi käyttäjä luotiin, mutta se tarvitsee aktivoinnin.';

// Edit
$lang['user_edit_user_not_found_error']        = 'Käyttäjää ei löytynyt.';
$lang['user_edit_success']                     = 'Käyttäjää muokattiin onnistuneesti.';
$lang['user_edit_error']                       = 'Käyttäjää muokattaessa tapahtui virhe.';

// Activate
$lang['user_activate_success']                 = '%s käyttäjää %s käyttäjästä aktivoitiin onnistuneesti.';
$lang['user_activate_error']                   = 'Sinun tulee valita käyttäjät ensin.';

// Delete
$lang['user_delete_self_error']                = 'Et voi poistaa itseäsi!';
$lang['user_mass_delete_success']              = '%s käyttäjää %s käyttäjästä poistettiin onnistuneesti.';
$lang['user_mass_delete_error']                = 'Sinun tulee valita käyttäjät ensin.';

// Register
$lang['user_email_pass_missing']               = 'Sähköposti tai salasaa puuttuvat.';
$lang['user_email_exists']                     = 'Kirjoittamasi sähköpostiosoite on jo käytössä.';
$lang['user_register_reasons']                 = 'Rekisteröidy, niin voit päästä sivuille johon et normaalisti pääse.';


// Activation
$lang['user_activation_incorrect']             = 'Aktivoiminen epäonnistui. Ole hyvä ja tarkista tiedot ja varmista ettei CAPS LOCK ole päällä.';
$lang['user_activated_message']                = 'Tili aktivoitiin onnistuneesti. Voit nyt kirjautua sisään.';


// Login
$lang['user_logged_in']                        = 'Kirjauduit sisään onnistuneesti.';
$lang['user_already_logged_in']                = 'Olet jo kirjautunut sisään. Kirjaudu ensin ulos ja yritä uudelleen.';
$lang['user_login_incorrect']                  = 'Sähköposti tai salasana on väärä. Tarkista tiedot ja varmista ettei CAPS LOCK ole päällä.';
$lang['user_inactive']                         = 'Tili, jolla yiritit kirjautu sisään ei ole käytössä.<br />Lue sähköpostista lisäohjeet - <em>viesti saattaa löytyä roskapostista</em>.';


// Logged Out
$lang['user_logged_out']                       = 'Kirjauduit ulos.';

// Forgot Pass
$lang['user_forgot_incorrect']                 = "Antamallasi tiedoilla ei löytynyt yhtään käyttäjää.";

$lang['user_password_reset_message']           = "Salasanasi on nollattu. Sinulle pitäisi tulla sähköpostia kahden tunnin sisällä. Jos et ole vastaanottanut sähköpostia vielä, tarkista roskapostista.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject']         = 'Aktivointia vaaditaan';
$lang['user_activation_email_body']            = 'Kiitos %s tilin aktivoimisesta. Kirjautuessasi käytä seuraavia tietoja:';


$lang['user_activated_email_subject']          = 'Aktivointi suoritettu';
$lang['user_activated_email_content_line1']    = 'Kiitos rekisteröitymisestä %s sivustoon. Ennen kuin aktivoimme tilisi, ole hyvä ja klikkaa linkkiä:';
$lang['user_activated_email_content_line2']    = 'Jos sähköposti ohjelmasi ei tunnistanut ylläolevaa linkiksi, ole hyvä ja kirjoita aktivointi koodi menemällä tähän osoitteeseen:';

// Reset Pass
$lang['user_reset_pass_email_subject']         = 'Salasanan nollaaminen';
$lang['user_reset_pass_email_body']            = 'Salasanasi sivustolla %s on nollattu. Jos et ole nollannut salasanaa, pyydämme Teitä ottamaan yhteyttä %s.';

// Profile
$lang['profile_of_title']             = 'Käyttäjän %s profiili';

$lang['profile_user_details_label']   = 'Käyttäjän tiedot';
$lang['profile_role_label']           = 'Rooli';
$lang['profile_registred_on_label']   = 'Rekisteröitynyt';
$lang['profile_last_login_label']     = 'Viimeksi kijautunut sisään';
$lang['profile_male_label']           = 'Mies';
$lang['profile_female_label']         = 'Nainen';

$lang['profile_not_set_up']           = 'Tällä käyttäjällä ei ole profiilia.';

$lang['profile_edit']                 = 'Muokkaa profiilia';

$lang['profile_personal_section']     = 'Henkilökohtaiset tiedot';

$lang['profile_display_name']         = 'Näyttönimi';  
$lang['profile_dob']                  = 'Syntymäpäivä';
$lang['profile_dob_day']              = 'Päivä';
$lang['profile_dob_month']            = 'Kuukausi';
$lang['profile_dob_year']             = 'Vuosi';
$lang['profile_gender']               = 'Sukupuoli';
$lang['profile_gender_nt']            = 'Not Telling'; #translate
$lang['profile_gender_male']          = 'Male'; #translate
$lang['profile_gender_female']        = 'Female'; #translate
$lang['profile_bio']                  = 'Minä';

$lang['profile_contact_section']      = 'Yhteydenotto';

$lang['profile_phone']                = 'Puhelin';
$lang['profile_mobile']               = 'Matkapuhelin';
$lang['profile_address']              = 'Osoite';
$lang['profile_address_line1']        = 'Osoite rivi #1';
$lang['profile_address_line2']        = 'Osoite rivi #2';
$lang['profile_address_line3']        = 'Osoite rivi #3';
$lang['profile_address_postcode']     = 'Postinumero';
$lang['profile_website']              = 'Kotisivut';

$lang['profile_messenger_section']    = 'Pikaviestintä';

$lang['profile_msn_handle']           = 'MSN';
$lang['profile_aim_handle']           = 'AIM';
$lang['profile_yim_handle']           = 'Yahoo! messenger';
$lang['profile_gtalk_handle']         = 'GTalk';

$lang['profile_avatar_section']       = 'Avatar'; // @todo Where we use these?
$lang['profile_social_section']       = 'Social'; // ^

$lang['profile_gravatar']             = 'Gravatar';
$lang['profile_twitter']              = 'Twitter';

$lang['profile_edit_success']         = 'Profiilisi on tallennettu.';
$lang['profile_edit_error']           = 'Tapahtui virhe.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn']             = 'Tallenna profiili';

/* End of file user_lang.php */
/* Location: ./system/cms/modules/users/language/finnish/user_lang.php */
