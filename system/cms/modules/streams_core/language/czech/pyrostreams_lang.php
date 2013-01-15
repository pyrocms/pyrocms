<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "Nastal problém při ukládání pole.";
$lang['streams:field_add_success']						= "Pole bylo přidáno.";
$lang['streams:field_update_error']						= "Nastal problém při úpravě pole.";
$lang['streams:field_update_success']					= "Pole bylo upraveno.";
$lang['streams:field_delete_error']						= "Nastal problém při odstraňování pole.";
$lang['streams:field_delete_success']					= "Pole bylo odstraněno.";
$lang['streams:view_options_update_error']				= "Nastal problém při úpravě nastavení zobrazení.";
$lang['streams:view_options_update_success']			= "Nastavení zobrazení bylo upraveno.";
$lang['streams:remove_field_error']						= "Nastal problém při odstraňování.";
$lang['streams:remove_field_success']					= "Pole bylo odstraněno.";
$lang['streams:create_stream_error']					= "Nastal problém při vytváření streamu.";
$lang['streams:create_stream_success']					= "Stream byl vytvořen.";
$lang['streams:stream_update_error']					= "Nastal problém při úpravě streamu.";
$lang['streams:stream_update_success']					= "Stream byl upraven.";
$lang['streams:stream_delete_error']					= "Nastal problém při odstraňování streamu.";
$lang['streams:stream_delete_success']					= "Stream byl odstraněn.";
$lang['streams:stream_field_ass_add_error']				= "Nastal problém při přidávání pole do streamu.";
$lang['streams:stream_field_ass_add_success']			= "Pole bylo přidáno do streamu.";
$lang['streams:stream_field_ass_upd_error']				= "Nastal problém při úpravě přiřazení pole.";
$lang['streams:stream_field_ass_upd_success']			= "Přiřazení pole bylo upraveno.";
$lang['streams:delete_entry_error']						= "Nastal problém při odstraňování záznamu.";
$lang['streams:delete_entry_success']					= "Záznam byl odstraněn.";
$lang['streams:new_entry_error']						= "Nastal problém při přidávání záznamu.";
$lang['streams:new_entry_success']						= "Záznam byl přidán.";
$lang['streams:edit_entry_error']						= "Nastal problém při úpravě záznamu.";
$lang['streams:edit_entry_success']					= "Záznam byl upraven.";
$lang['streams:delete_summary']							= "Jste si jistý/á, že chcete odstranit stream <strong>%s</strong>?";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "Nebyl vybrán žádný stream.";
$lang['streams:invalid_stream']							= "Neplatný stream.";
$lang['streams:not_valid_stream']						= "není platný stream.";
$lang['streams:invalid_stream_id']						= "Neplatné ID streamu.";
$lang['streams:invalid_row']							= "Neplatný řádek.";
$lang['streams:invalid_id']								= "Neplatné ID.";
$lang['streams:cannot_find_assign']						= "Nelze najít přiřazení pole.";
$lang['streams:cannot_find_pyrostreams']				= "Nelze najít PyroStreams.";
$lang['streams:table_exists']							= "Tabulka s klíčem %s již existuje.";
$lang['streams:no_results']								= "Žádné výsledky";
$lang['streams:no_entry']								= "Nepodařilo se najít záznam.";
$lang['streams:invalid_search_type']					= "není platný typ hledání.";
$lang['streams:search_not_found']						= "Hledání se nezdařilo.";

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "klíč pole je již používán.";
$lang['streams:not_mysql_safe_word']					= "Pole %s je klíčové slovo MySQL.";
$lang['streams:not_mysql_safe_characters']				= "Pole %s obsahuje nepovolené znaky.";
$lang['streams:type_not_valid']							= "Vyberte prosím platný typ pole.";
$lang['streams:stream_slug_not_unique']					= "Klíč streamu se již používá.";
$lang['streams:field_unique']							= "Pole %s musí být jedinečné.";
$lang['streams:field_is_required']						= "Pole %s je povinné.";
$lang['streams:date_out_or_range']						= "The date you have chosen is out of the acceptable range."; #translate

/* Field Labels */

$lang['streams:label.field']							= "Pole";
$lang['streams:label.field_required']					= "Pole je povinné";
$lang['streams:label.field_unique']						= "Pole musí být unikátní";
$lang['streams:label.field_instructions']				= "Instrukce k poli";
$lang['streams:label.make_field_title_column']			= "Označit jako titulek";
$lang['streams:label.field_name']						= "Jméno pole";
$lang['streams:label.field_slug']						= "Klíč pole";
$lang['streams:label.field_type']						= "Typ pole";
$lang['streams:id']										= "ID";
$lang['streams:created_by']								= "Autor";
$lang['streams:created_date']							= "Vytvořeno";
$lang['streams:updated_date']							= "Upraveno";
$lang['streams:value']									= "Hodnota";
$lang['streams:manage']									= "Spravovat stream";
$lang['streams:search']									= "Hledat";
$lang['streams:stream_prefix']							= "Stream Prefix"; #translate

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "Zobrazí se u formuláře při přidávání záznamů.";
$lang['streams:instr.stream_full_name']					= "Celé jméno streamu.";
$lang['streams:instr.slug']								= "Jen malá písmena a podtržítka.";

/* Titles */

$lang['streams:assign_field']							= "Přiřadit pole ke streamu";
$lang['streams:edit_assign']							= "Upravit přiřazení ke streamu";
$lang['streams:add_field']								= "Vytvořit pole";
$lang['streams:edit_field']								= "Upravit pole";
$lang['streams:fields']									= "Pole";
$lang['streams:streams']								= "Streamy";
$lang['streams:list_fields']							= "Seznam polí";
$lang['streams:new_entry']								= "Nový záznam";
$lang['streams:stream_entries']							= "Záznamy ve streamu";
$lang['streams:entries']								= "Záznamy";
$lang['streams:stream_admin']							= "Administrace streamu";
$lang['streams:list_streams']							= "Seznam streamů";
$lang['streams:sure']									= "Jste si jistý/á?";
$lang['streams:field_assignments'] 						= "Přiřazení polí ke streamu";
$lang['streams:new_field_assign']						= "Nové přiřazení pole";
$lang['streams:stream_name']							= "Jméno streamu";
$lang['streams:stream_slug']							= "Klíč streamu";
$lang['streams:about']									= "Popis";
$lang['streams:total_entries']							= "Počet záznamů";
$lang['streams:add_stream']								= "Nový stream";
$lang['streams:edit_stream']							= "Upravit stream";
$lang['streams:about_stream']							= "Popis streamu";
$lang['streams:title_column']							= "Sloupec s titulkem";
$lang['streams:sort_method']							= "Řazení záznamů";
$lang['streams:add_entry']								= "Přidat záznam";
$lang['streams:edit_entry']								= "Upravit záznam";
$lang['streams:view_options']							= "Nastavení zobrazení";
$lang['streams:stream_view_options']					= "Nastavení zobrazení streamu";
$lang['streams:backup_table']							= "Zálohovat tabulku streamu";
$lang['streams:delete_stream']							= "Odstranit stream";
$lang['streams:entry']									= "Záznam";
$lang['streams:field_types']							= "Typy polí";
$lang['streams:field_type']								= "Typ pole";
$lang['streams:database_table']							= "Databázová tabulka";
$lang['streams:size']									= "Velikost";
$lang['streams:num_of_entries']							= "Počet záznamů";
$lang['streams:num_of_fields']							= "Počet polí";
$lang['streams:last_updated']							= "Poslední úpravy";

/* Startup */

$lang['streams:start.add_one']							= "přidat";
$lang['streams:start.no_fields']						= "Ještě jste nevytvořil žádné pole. Můžete nějaké";
$lang['streams:start.no_assign'] 						= "Stream ještě nemá žádná pole. Můžete";
$lang['streams:start.add_field_here']					= "přidat pole";
$lang['streams:start.create_field_here']				= "vytvořit pole";
$lang['streams:start.no_streams']						= "Nejsou vytvořené žádné streamy, můžete";
$lang['streams:start.no_streams_yet']					= "There are no streams yet."; #translate
$lang['streams:start.adding_one']						= "nějaký vytvořit";
$lang['streams:start.no_fields_to_add']					= "Žádná pole k přidání";
$lang['streams:start.no_fields_msg']					= "Nejsou zde žádná pole k přiřazení ke streamu. Typy polí mohou být sdíleny mezi streamy musí být vytvořeny předtím, než jsou přiřazeny ke streamu. Můžete začít";
$lang['streams:start.adding_a_field_here']				= "přidání pole";
$lang['streams:start.no_entries']						= "Zatím zde nejsou žádné záznamy pro <strong>%s</strong>. Můžete";
$lang['streams:add_fields']								= "přiřadit pole";
$lang['streams:no_entries']								= 'No entries'; #translate
$lang['streams:add_an_entry']							= "přidat záznam";
$lang['streams:to_this_stream_or']						= "k tomuto streamu nebo";
$lang['streams:no_field_assign']						= "Žádná přiřazená pole";
$lang['streams:no_fields_msg_first']					= "Looks like there are no fields yet for this stream."; #translate
$lang['streams:no_field_assign_msg']					= "Stream ještě nemá žádná pole. Před přidáním záznamů musíte";
$lang['streams:add_some_fields']						= "nějaká pole přiřadit";
$lang['streams:start.before_assign']					= "Před přiřazením pole ke streamu musíte pole vytvořit. Tady můžete";
$lang['streams:start.no_fields_to_assign']				= "Nejsou zde žádná pole dostupná k přiřazení. Před přiřezním pole musíte ";

/* Buttons */

$lang['streams:yes_delete']								= "Ano, odstranit";
$lang['streams:no_thanks']								= "Ne, díky";
$lang['streams:new_field']								= "Nové pole";
$lang['streams:edit']									= "Upravit";
$lang['streams:delete']									= "Vymazat";
$lang['streams:remove']									= "Odstranit";
$lang['streams:reset']									= "Reset"; #translate

/* Misc */

$lang['streams:field_singular']							= "pole";
$lang['streams:field_plural']							= "pole";
$lang['streams:by_title_column']						= "Podle titulku";
$lang['streams:manual_order']							= "Ruční řazení";
$lang['streams:stream_data_line']						= "Upravit základní data streamu.";
$lang['streams:view_options_line'] 						= "Vybrat, které sloupce budou vidět v seznamu záznamů.";
$lang['streams:backup_line']							= "Zálohovat a stáhnout tabulku streamu v ZIPu.";
$lang['streams:permanent_delete_line']					= "Trvale odstranit stream a všechny jeho data.";
$lang['streams:choose_a_field_type']					= "Vyberte typ pole";
$lang['streams:choose_a_field']							= "Vyberte pole";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "Knihovna reCaptcha inicializována";
$lang['recaptcha_no_private_key']						= "Nebyl ještě zadán API klíč pro reCaptcha";
$lang['recaptcha_no_remoteip'] 							= "Z bezpečnostních důvodů musíte zadat vzdálenou IP adresu pro reCaptcha";
$lang['recaptcha_socket_fail'] 							= "Nepodařilo se otevřít socket";
$lang['recaptcha_incorrect_response'] 					= "Nesprávná odpověď bezpoečnostní obrázek";
$lang['recaptcha_field_name'] 							= "Bezpečnostní obrázek";
$lang['recaptcha_html_error'] 							= "Nepodařilo se načíst bezpečnostní obrázek. Zkuste to prosím později.";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "Maximální délka";
$lang['streams:upload_location'] 						= "Cíl uploadu";
$lang['streams:default_value'] 							= "Výchozí hodnota";

$lang['streams:menu_path']								= 'Menu Path'; #translate
$lang['streams:about_instructions']						= 'A short description of your stream.'; #translate
$lang['streams:slug_instructions']						= 'This will also be the database table name for your stream.'; #translate
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.'; #translate
$lang['streams:menu_path_instructions']					= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.'; #translate

/* End of file pyrostreams_lang.php */