<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "Kentän tallentamisessa tapahtui virhe.";
$lang['streams:field_add_success']						= "Kenttä lisätty onnistuneesti.";
$lang['streams:field_update_error']						= "Kentän päivittämisessä tapahtui virhe.";
$lang['streams:field_update_success']					= "Kenttä päivitetty onnistuneesti.";
$lang['streams:field_delete_error']						= "Kentän poistamisessa tapahtui virhe.";
$lang['streams:field_delete_success']					= "Kenttä poistettiin onnistuneesti.";
$lang['streams:view_options_update_error']				= "Näkyvyyden valintojen päivittämisessä tapahtui virhe.";
$lang['streams:view_options_update_success']			= "Näkyvyyksien valinnat päivitettiin onnistuneesti.";
$lang['streams:remove_field_error']						= "Kentän poistamisessa tapahtui virhe.";
$lang['streams:remove_field_success']					= "Kenttä poistettu onnistuneesti.";
$lang['streams:create_stream_error']					= "Striimin luomisessa tapahtui virhe.";
$lang['streams:create_stream_success']					= "Striimi luotiin onnistuneesti.";
$lang['streams:stream_update_error']					= "Striimin päivittämisessä tapahtui virhe.";
$lang['streams:stream_update_success']					= "Striimi päivitettiin onnistuneesti.";
$lang['streams:stream_delete_error']					= "Striimin poistamisessa tapahtui virhe.";
$lang['streams:stream_delete_success']					= "Striimi poistettiin onnistuneesti.";
$lang['streams:stream_field_ass_add_error']				= "Kentän lisäämisessä tapahtui virhe.";
$lang['streams:stream_field_ass_add_success']			= "Kenttä lisättiin onnistuneesti.";
$lang['streams:stream_field_ass_upd_error']				= "Kentän liittämisessä tapahtui virhe.";
$lang['streams:stream_field_ass_upd_success']			= "Kentän liittäminen onnistui.";
$lang['streams:delete_entry_error']						= "Tämän merkinnän poistamisessa tapahtui virhe.";
$lang['streams:delete_entry_success']					= "Merkintä poistettiin onnistuneesti.";
$lang['streams:new_entry_error']						= "Merkinnän lisäämisessä tapahtui virhe.";
$lang['streams:new_entry_success']						= "Merkintä lisättiin onnistuneesti.";
$lang['streams:edit_entry_error']						= "Tämän merkinnän muokkaamisessa tapahtui virhe.";
$lang['streams:edit_entry_success']						= "Merkinnän muokkaaminen onnistui.";
$lang['streams:delete_summary']							= "Oletko varma, että haluat poistaa <strong>%s</strong> striimin? Tämä <strong>poistaa %s %s</strong> pysyvästi.";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "Striimiä ei toimitettu.";
$lang['streams:invalid_stream']							= "Striimi ei kelpaa.";
$lang['streams:not_valid_stream']						= "striimi ei kelpaa.";
$lang['streams:invalid_stream_id']						= "Virheellinen striimin ID.";
$lang['streams:invalid_row']							= "Virheellinen rivi.";
$lang['streams:invalid_id']								= "Virheellinen ID.";
$lang['streams:cannot_find_assign']						= "Ei löytynyt kentän liitoksia.";
$lang['streams:cannot_find_pyrostreams']				= "PyroStreams ei löytynyt.";
$lang['streams:table_exists']							= "Taulu nimipolulla %s on jo olemassa.";
$lang['streams:no_results']								= "Ei tuloksia";
$lang['streams:no_entry']								= "Ei voitu löytää merkintää.";
$lang['streams:invalid_search_type']					= "hakutyyppi ei kelpaa.";
$lang['streams:search_not_found']						= "Search not found."; #translate

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "Tämän kentän polkutunnus on jo käytössä.";
$lang['streams:not_mysql_safe_word']					= "%s kenttä on MySQL varattu sana.";
$lang['streams:not_mysql_safe_characters']				= "%s kenttä sisältää ei-sallittuja merkkejä.";
$lang['streams:type_not_valid']							= "Valitse oikean tyyppinen kenttä.";
$lang['streams:stream_slug_not_unique']					= "Tämän striimin polkutunnus on jo käytössä.";
$lang['streams:field_unique']							= "%s kentän tulee olla yksilöllinen.";
$lang['streams:field_is_required']						= "%s kenttä on pakollinen.";
$lang['streams:date_out_or_range']						= "Valittu päiväys ei täsmää sallitun aikajanan kanssa.";

/* Field Labels */

$lang['streams:label.field']							= "Kenttä";
$lang['streams:label.field_required']					= "Pakollinen kenttä";
$lang['streams:label.field_unique']						= "Yksilöllinen kenttä";
$lang['streams:label.field_instructions']				= "Kentän ohjeistus";
$lang['streams:label.make_field_title_column']			= "Tee kentästä otsikko sarake";
$lang['streams:label.field_name']						= "Kentän nimi";
$lang['streams:label.field_slug']						= "Kentän polkutunnus";
$lang['streams:label.field_type']						= "Kentän tyyppi";
$lang['streams:id']										= "ID";
$lang['streams:created_by']								= "Luonut";
$lang['streams:created_date']							= "Luotu";
$lang['streams:updated_date']							= "Päivitetty";
$lang['streams:value']									= "Arvo";
$lang['streams:manage']									= "Hallinnoi";
$lang['streams:search']									= "Hae";
$lang['streams:stream_prefix']							= "Striimin etuliite";

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "Näytetään lomakkeella kun käyttäjä täyttää tietoja.";
$lang['streams:instr.stream_full_name']					= "Striimin koko nimi.";
$lang['streams:instr.slug']								= "Pienillä kirjaimilla, vain kirjaimia ja alaviivoja.";

/* Titles */

$lang['streams:assign_field']							= "Liitä kenttä striimiin";
$lang['streams:edit_assign']							= "Muokkaa striimin liitoksia";
$lang['streams:add_field']								= "Luo kenttä";
$lang['streams:edit_field']								= "Muokkaa kenttää";
$lang['streams:fields']									= "Kentät";
$lang['streams:streams']								= "Striimit";
$lang['streams:list_fields']							= "Listaa kentät";
$lang['streams:new_entry']								= "Uusi merkintä";
$lang['streams:stream_entries']							= "Striimin merkinnät";
$lang['streams:entries']								= "Merkinnät";
$lang['streams:stream_admin']							= "Striimin ylläpitäjä";
$lang['streams:list_streams']							= "Listaa striimit";
$lang['streams:sure']									= "Oletko varma?";
$lang['streams:field_assignments'] 						= "Striimi kentän liitokset";
$lang['streams:new_field_assign']						= "Uusi kenttäliitos";
$lang['streams:stream_name']							= "Striimin nimi";
$lang['streams:stream_slug']							= "Striimin polkutunnus";
$lang['streams:about']									= "Lisätietoja";
$lang['streams:total_entries']							= "Merkintöjä yhteensä";
$lang['streams:add_stream']								= "Uusi striimi";
$lang['streams:edit_stream']							= "Muokkaa striimiä";
$lang['streams:about_stream']							= "Lisätietoja tästä striimistä";
$lang['streams:title_column']							= "Otsikko sarake";
$lang['streams:sort_method']							= "Järjestä";
$lang['streams:add_entry']								= "Lisää merkintä";
$lang['streams:edit_entry']								= "Muokkaa merkintää";
$lang['streams:view_options']							= "Näkvyys valinnat";
$lang['streams:stream_view_options']					= "Striimin näkyvyys valinnat";
$lang['streams:backup_table']							= "Varmuuskopioi striimin taulu";
$lang['streams:delete_stream']							= "Poista striimi";
$lang['streams:entry']									= "Merkintä";
$lang['streams:field_types']							= "Kenttätyypit";
$lang['streams:field_type']								= "Kentän tyyppi";
$lang['streams:database_table']							= "Tietokanta taulu";
$lang['streams:size']									= "Koko";
$lang['streams:num_of_entries']							= "Merkintöjen määrä";
$lang['streams:num_of_fields']							= "Kenttien määrä";
$lang['streams:last_updated']							= "Päivitetty";
$lang['streams:export_schema']							= "Vie schema";

/* Startup */

$lang['streams:start.add_one']							= "lisää tästä";
$lang['streams:start.no_fields']						= "Et ole vielä luonut kenttiä. Aloittaaksesi, voit";
$lang['streams:start.no_assign'] 						= "Näyttää siltä, että tähän striimiin ei ole määritetty kenttiä. Aloittaaksesi, voit";
$lang['streams:start.add_field_here']					= "lisää kentän tästä";
$lang['streams:start.create_field_here']				= "luoda kentän täältä";
$lang['streams:start.no_streams']						= "Striimejä ei ole vielä, mutta voit aloittaa";
$lang['streams:start.no_streams_yet']					= "Striimejä ei ole vielä.";
$lang['streams:start.adding_one']						= "lisäämällä yhden";
$lang['streams:start.no_fields_to_add']					= "Lisättäviä kenttiä ei ole";
$lang['streams:start.no_fields_msg']					= "Kenttiä ei ole saatavilla tähän striimiin. PyroStreamsissä, kentän tyypit voidaan jakaa eri striimien kesken ja niiden tulee luoda ensin, jotta ne voidaan liittää striimeihin. Voit aloittaa";
$lang['streams:start.adding_a_field_here']				= "luomalla kentän täältä";
$lang['streams:start.no_entries']						= "<strong>%s</strong>:lle ei ole vielä merkintöjä. Aloittaaksesi, voit";
$lang['streams:add_fields']								= "liittää kenttiä";
$lang['streams:no_entries']								= 'Ei merkintöjä';
$lang['streams:add_an_entry']							= "lisää merkintä";
$lang['streams:to_this_stream_or']						= "tähän striimiin tai";
$lang['streams:no_field_assign']						= "Ei liitettyjä kenttiä";
$lang['streams:no_fields_msg_first']					= "Näyttää siltä, että kenttiä ei ole liitetty tähän striimiin.";
$lang['streams:no_field_assign_msg']					= "Ennen kuin aloitat tietojen syöttämisen, sinun tulee";
$lang['streams:add_some_fields']						= "liittää kenttiä";
$lang['streams:start.before_assign']					= "Ennen kentän liittämistä striimiin, sinun tulee luoda kenttiä. Voit";
$lang['streams:start.no_fields_to_assign']				= "Näyttää siltä, että kenttiä ei ole saatavilla liitettäväksi. Ennen kun voit liittää kenttiä, sinun tulee ";

/* Buttons */

$lang['streams:yes_delete']								= "Kyllä, poista";
$lang['streams:no_thanks']								= "Ei kiitos";
$lang['streams:new_field']								= "Uusi kenttä";
$lang['streams:edit']									= "Muokkaa";
$lang['streams:delete']									= "Poista";
$lang['streams:remove']									= "Poista";
$lang['streams:reset']									= "Nollaa";

/* Misc */

$lang['streams:field_singular']							= "kenttä";
$lang['streams:field_plural']							= "kentät";
$lang['streams:by_title_column']						= "Otsikon mukaan";
$lang['streams:manual_order']							= "Manuaalinen järjestys";
$lang['streams:stream_data_line']						= "Muokkaa perus striimin dataa.";
$lang['streams:view_options_line'] 						= "Valitse, mitkä sarakkeet tulisi näkyä sisältö listauksissa.";
$lang['streams:backup_line']							= "Varmuuskopioi ja lataa striimin taulun zip paketissa.";
$lang['streams:permanent_delete_line']					= "Poista striimi ja sen sisältö pysyvästi.";
$lang['streams:choose_a_field_type']					= "Valitse kentän tyyppi";
$lang['streams:choose_a_field']							= "Valitse kenttä";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "reCaptcha kirjasto käynnistetty";
$lang['recaptcha_no_private_key']						= "Et toimittanut API avainta Recaptchaa varten";
$lang['recaptcha_no_remoteip'] 							= "For security reasons, you must pass the remote ip to reCAPTCHA"; #translate
$lang['recaptcha_socket_fail'] 							= "Could not open socket"; #translate
$lang['recaptcha_incorrect_response'] 					= "Incorrect Security Image Response"; #translate
$lang['recaptcha_field_name'] 							= "Turvallisuus kuva";
$lang['recaptcha_html_error'] 							= "Truvallisuus kuvan latauksessa tapahtui virhe. Yritä myöhemmin uudelleen";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "Enimmäispituus";
$lang['streams:upload_location'] 						= "Latauskansio";
$lang['streams:default_value'] 							= "Oletusarvo";

$lang['streams:menu_path']								= 'Valikkopolku';
$lang['streams:about_instructions']						= 'Lyhyt kuvaus striimistäsi.';
$lang['streams:slug_instructions']						= 'Tämä tulee olemaan myös tietokanta taulu striimillesi.';
$lang['streams:prefix_instructions']					= 'Jos käytössä, niin tämä asettaa etuliitteen taululle tietokannassa. Kätevä tapa välttää nimi konfliktit.';
$lang['streams:menu_path_instructions']					= 'Missä osiossa ja alaosiossa tämän striimin tulisi olla. Erottele "/" merkillä. Esimerkki: <strong>Pääosio / Alaosio</strong>.';

/* End of file pyrostreams_lang.php */
