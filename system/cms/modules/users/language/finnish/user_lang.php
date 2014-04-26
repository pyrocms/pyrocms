<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Finnish translation.
 *
 * @author Mikael Kundert
 */

$lang['user:add_field']                        	= 'Lisää Käyttäjäprofiilikenttä';
$lang['user:profile_delete_success']           	= 'Käyttäjäprofiilikenttä poistettiin onnistuneesti';
$lang['user:profile_delete_failure']            = 'Ongelma käyttäjäprofiilikentän poistamisessa';
$lang['profile_user_basic_data_label']  		= 'Perustiedot';
$lang['profile_company']         	  			= 'Yritys';
$lang['profile_updated_on']           			= 'Päivitetty';
$lang['user:profile_fields_label']	 		 	= 'Profiilikentät';

$lang['user:register_header']                  = 'Rekisteröityminen';
$lang['user:register_step1']                   = '<strong>Vaihe 1:</strong> Rekisteröityminen';
$lang['user:register_step2']                   = '<strong>Vaihe 2:</strong> Aktivointi';

$lang['user:login_header']                     = 'Kirjaudu';

// titles
$lang['user:add_title']                        = 'Lisää käyttäjä';
$lang['user:list_title']					   = 'Listaa käyttäjät';
$lang['user:inactive_title']                   = 'Ei-aktiiviset käyttäjät';
$lang['user:active_title']                     = 'Aktiiviset käyttäjät';
$lang['user:registred_title']                  = 'Rekisteröityneet käyttäjät';

// labels
$lang['user:edit_title']                       = 'Muokkaa käyttäjää "%s"';
$lang['user:details_label']                    = 'Tiedot';
$lang['user:first_name_label']                 = 'Etunimi';
$lang['user:last_name_label']                  = 'Sukunimi';
$lang['user:group_label']                      = 'Ryhmä';
$lang['user:activate_label']                   = 'Aktivoi';
$lang['user:password_label']                   = 'Salasana';
$lang['user:password_confirm_label']           = 'Vahvista salasana';
$lang['user:name_label']                       = 'Nimi';
$lang['user:joined_label']                     = 'Liittynyt';
$lang['user:last_visit_label']                 = 'Viimeksi paikalla';
$lang['user:never_label']                      = 'Ei koskaan';

$lang['user:no_inactives']                     = 'Ei-aktiivisia käyttäjiä ei löytynyt.';
$lang['user:no_registred']                     = 'Rekisteröityneitä käyttäjiä ei löytynyt.';

$lang['account_changes_saved']                 = 'Tilin muutokset tallennettiin.';

$lang['indicates_required']                    = 'Merkitsee pakolliset kentät';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Lähetä aktivointi sähköposti';
$lang['user:do_not_activate']                  = 'Älä aktivoi';
$lang['user:register_title']                   = 'Rekisteröityminen';
$lang['user:activate_account_title']           = 'Aktivoi tili';
$lang['user:activate_label']                   = 'Aktivoi';
$lang['user:activated_account_title']          = 'Tili aktivointiin';
$lang['user:reset_password_title']             = 'Nollaa salasana';
$lang['user:password_reset_title']             = 'Salasanan nollaaminen';


$lang['user:error_username']                   = 'Käyttäjänimi, jonka syötit on jo käytössä';
$lang['user:error_email']                      = 'Sähköpostiosoite, jonka syötit on jo käytössä';

$lang['user:full_name']                        = 'Koko nimi';
$lang['user:first_name']                       = 'Etunimi';
$lang['user:last_name']                        = 'Sukunimi';
$lang['user:username']                         = 'Käyttäjätunnus';
$lang['user:display_name']                     = 'Näyttönimi';
$lang['user:email_use'] 					   = 'used to login'; #translate
$lang['user:remember']                         = 'Muista minut';
$lang['user:group_id_label']                   = 'Ryhmän ID';

$lang['user:level']                            = 'Käyttäjärooli';
$lang['user:active']                           = 'Aktiivinen';
$lang['user:lang']                             = 'Kieli';

$lang['user:activation_code']                  = 'Aktivointi koodi';

$lang['user:reset_instructions']			   = 'Kirjoita sähköpostiosoitteesi tai käyttäjätunnuksesi';
$lang['user:reset_password_link']              = 'Unohditko salasanan?';

$lang['user:activation_code_sent_notice']      = 'Aktivointi koodi lähetettiin sähköpostiisi.';
$lang['user:activation_by_admin_notice']       = 'Rekisteröityminen vaatii ylläpidon hyväksymisen.';
$lang['user:registration_disabled']            = 'Valitettavasti rekisteröityminen ei ole nyt käytössä.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section']                  = 'Nimi';
$lang['user:password_section']                 = 'Vaihda salasana';
$lang['user:other_settings_section']           = 'Muut asetukset';

$lang['user:settings_saved_success']           = 'Käyttäjätilin asetukset tallennettiin.';
$lang['user:settings_saved_error']             = 'Tapahtui virhe.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']                     = 'Rekisteröidy';
$lang['user:activate_btn']                     = 'Aktivoi';
$lang['user:reset_pass_btn']                   = 'Nollaa salasana';
$lang['user:login_btn']                        = 'Kirjaudu';
$lang['user:settings_btn']                     = 'Tallenna asetukset';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success']      = 'Uusi käyttäjä luotiin ja aktivoitiin.';
$lang['user:added_not_activated_success']      = 'Uusi käyttäjä luotiin, mutta se tarvitsee aktivoinnin.';

// Edit
$lang['user:edit_user_not_found_error']        = 'Käyttäjää ei löytynyt.';
$lang['user:edit_success']                     = 'Käyttäjää muokattiin onnistuneesti.';
$lang['user:edit_error']                       = 'Käyttäjää muokattaessa tapahtui virhe.';

// Activate
$lang['user:activate_success']                 = '%s käyttäjää %s käyttäjästä aktivoitiin onnistuneesti.';
$lang['user:activate_error']                   = 'Sinun tulee valita käyttäjät ensin.';

// Delete
$lang['user:delete_self_error']                = 'Et voi poistaa itseäsi!';
$lang['user:mass_delete_success']              = '%s käyttäjää %s käyttäjästä poistettiin onnistuneesti.';
$lang['user:mass_delete_error']                = 'Sinun tulee valita käyttäjät ensin.';

// Register
$lang['user:email_pass_missing']               = 'Sähköposti tai salasaa puuttuvat.';
$lang['user:email_exists']                     = 'Kirjoittamasi sähköpostiosoite on jo käytössä.';
$lang['user:register_error']				   = 'Taidat olla botti. Jos näin ei ole, niin pahoittelemme.';
$lang['user:register_reasons']                 = 'Rekisteröidy, niin voit päästä sivuille johon et normaalisti pääse.';


// Activation
$lang['user:activation_incorrect']             = 'Aktivoiminen epäonnistui. Ole hyvä ja tarkista tiedot ja varmista ettei CAPS LOCK ole päällä.';
$lang['user:activated_message']                = 'Tili aktivoitiin onnistuneesti. Voit nyt kirjautua sisään.';


// Login
$lang['user:logged_in']                        = 'Kirjauduit sisään onnistuneesti.';
$lang['user:already_logged_in']                = 'Olet jo kirjautunut sisään. Kirjaudu ensin ulos ja yritä uudelleen.';
$lang['user:login_incorrect']                  = 'Sähköposti tai salasana on väärä. Tarkista tiedot ja varmista ettei CAPS LOCK ole päällä.';
$lang['user:inactive']                         = 'Tili, jolla yiritit kirjautu sisään ei ole käytössä.<br />Lue sähköpostista lisäohjeet - <em>viesti saattaa löytyä roskapostista</em>.';


// Logged Out
$lang['user:logged_out']                       = 'Kirjauduit ulos.';

// Forgot Pass
$lang['user:forgot_incorrect']                 = "Antamallasi tiedoilla ei löytynyt yhtään käyttäjää.";

$lang['user:password_reset_message']           = "Salasanasi on nollattu. Sinulle pitäisi tulla sähköpostia kahden tunnin sisällä. Jos et ole vastaanottanut sähköpostia vielä, tarkista roskapostista.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject']         = 'Aktivointia vaaditaan';
$lang['user:activation_email_body']            = 'Kiitos %s tilin aktivoimisesta. Kirjautuessasi käytä seuraavia tietoja:';


$lang['user:activated_email_subject']          = 'Aktivointi suoritettu';
$lang['user:activated_email_content_line1']    = 'Kiitos rekisteröitymisestä %s sivustoon. Ennen kuin aktivoimme tilisi, ole hyvä ja klikkaa linkkiä:';
$lang['user:activated_email_content_line2']    = 'Jos sähköposti ohjelmasi ei tunnistanut ylläolevaa linkiksi, ole hyvä ja kirjoita aktivointi koodi menemällä tähän osoitteeseen:';

// Reset Pass
$lang['user:reset_pass_email_subject']         = 'Salasanan nollaaminen';
$lang['user:reset_pass_email_body']            = 'Salasanasi sivustolla %s on nollattu. Jos et ole nollannut salasanaa, pyydämme Teitä ottamaan yhteyttä %s.';

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
$lang['profile_gender_nt']            = 'Ei kerrota';
$lang['profile_gender_male']          = 'Mies';
$lang['profile_gender_female']        = 'Nainen';
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