<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "Kilo problema išsaugant jūsų lauką.";
$lang['streams:field_add_success']						= "Laukas pridėtas sėkmingai.";
$lang['streams:field_update_error']						= "Kilo problema atnaujinant jūsų lauką.";
$lang['streams:field_update_success']					= "Laukas atnaujintas sėkmingai.";
$lang['streams:field_delete_error']						= "Kilo problema ištrinant šį lauką.";
$lang['streams:field_delete_success']					= "Laukas ištrintas sėkmingai.";
$lang['streams:view_options_update_error']				= "Kilo kliučių naujinant view parametrus.";
$lang['streams:view_options_update_success']			= "View parametrai sėkmingai atnaujinti.";
$lang['streams:remove_field_error']						= "Kilo problema pašalinant šį lauką.";
$lang['streams:remove_field_success']					= "Laukas sėkmingai pašalintas.";
$lang['streams:create_stream_error']					= "Kilo kliučių kuriant jūsų stram.";
$lang['streams:create_stream_success']					= "Srautas sukurtas sėkmingai.";
$lang['streams:stream_update_error']					= "Kilo kliučių naujinat srautą.";
$lang['streams:stream_update_success']					= "Srautas atnaujintas sėkmingai.";
$lang['streams:stream_delete_error']					= "Kilo kliučių pašalinat srautą.";
$lang['streams:stream_delete_success']					= "Srautas ištrintas sėkmingai.";
$lang['streams:stream_field_ass_add_error']				= "Kilo kliučių pridedant šį lauką į srautą.";
$lang['streams:stream_field_ass_add_success']			= "Laukas pridėtas sėkmingai į srautą.";
$lang['streams:stream_field_ass_upd_error']				= "Kilo kliučių naujinant lauko assignment.";
$lang['streams:stream_field_ass_upd_success']			= "Lauko assignment atnaujintas sėkmingai.";
$lang['streams:delete_entry_error']						= "Kilo kliučių ištrinant šį įrašą.";
$lang['streams:delete_entry_success']					= "Įrašas ištrintas sėkmingai.";
$lang['streams:new_entry_error']						= "Kilo kliučių pridedant įrašą.";
$lang['streams:new_entry_success']						= "Įrašas pridėtas sėkmingai.";
$lang['streams:edit_entry_error']						= "Kilo kliučių naujinant įrašą.";
$lang['streams:edit_entry_success']						= "Įrašas sėkmingai atnaujintas.";
$lang['streams:delete_summary']							= "Ar jūs esate tikri, kad norite pašalinti <strong>%s</strong> srautą? Bus <strong>ištrinta %s %s</strong> negrįžtamai.";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "Nepaduotas joks srautas.";
$lang['streams:invalid_stream']							= "Netinkamas srautas.";
$lang['streams:not_valid_stream']						= "nėra galimas srautas.";
$lang['streams:invalid_stream_id']						= "Neteisingas srauto ID.";
$lang['streams:invalid_row']							= "Netinkama eilė.";
$lang['streams:invalid_id']								= "Netinkamas ID.";
$lang['streams:cannot_find_assign']						= "Nerastas lauko priskyrimas.";
$lang['streams:cannot_find_pyrostreams']				= "Nerastas PyroStreams.";
$lang['streams:table_exists']							= "Lentelė su šūkiu %s jau egzistuoja.";
$lang['streams:no_results']								= "Nėra rezultatų";
$lang['streams:no_entry']								= "Įrašas nerastas.";
$lang['streams:invalid_search_type']					= "netinkamas paieškos tipas.";
$lang['streams:search_not_found']						= "Nerasta paieškoje.";

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "Šio lauko šūkis jau naudojamas.";
$lang['streams:not_mysql_safe_word']					= "Laukas %s yra MySQL rezervuotas žodis.";
$lang['streams:not_mysql_safe_characters']				= "Lauke %s yra netinkamų simbolių.";
$lang['streams:type_not_valid']							= "Pasirinkite tinkamą lauko tipą.";
$lang['streams:stream_slug_not_unique']					= "Toks srauto šūkis jau užimtas.";
$lang['streams:field_unique']							= "Laukas %s turi būti unikalus.";
$lang['streams:field_is_required']						= "Laukas %s yra privalomas.";
$lang['streams:date_out_or_range']						= "Pasirinkta data yra neleistina.";

/* Field Labels */

$lang['streams:label.field']							= "Laukas";
$lang['streams:label.field_required']					= "Laukas yra privalomas";
$lang['streams:label.field_unique']						= "Laukas yra unikalus";
$lang['streams:label.field_instructions']				= "Laukas instrukcijos";
$lang['streams:label.make_field_title_column']			= "Padaryti lauką stulpelio pavadinimu";
$lang['streams:label.field_name']						= "Lauko pavadinimas";
$lang['streams:label.field_slug']						= "Lauko šūkis";
$lang['streams:label.field_type']						= "Lauko tipas";
$lang['streams:id']										= "ID";
$lang['streams:created_by']								= "Kūrėjas";
$lang['streams:created_date']							= "Sukūrimo data";
$lang['streams:updated_date']							= "Atnaujinimo data";
$lang['streams:value']									= "Reikšmė";
$lang['streams:manage']									= "Administruoti";
$lang['streams:search']									= "Paieška";
$lang['streams:stream_prefix']							= "Srauto priešdėlis";

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "Rodoma formoje, kai įvedami arba redaguojami duomenys.";
$lang['streams:instr.stream_full_name']					= "Pilnas pavadinimas jūsų srautui.";
$lang['streams:instr.slug']								= "Mažos raidės, tik raidės ir apatinis brūkšnys.";

/* Titles */

$lang['streams:assign_field']							= "Priskirti lauką į srautą";
$lang['streams:edit_assign']							= "Redaguoti srauto priskyrimą";
$lang['streams:add_field']								= "Sukurti lauką";
$lang['streams:edit_field']								= "Redaguoti laukus";
$lang['streams:fields']									= "Laukai";
$lang['streams:streams']								= "Srautai";
$lang['streams:list_fields']							= "Parodyti laukus";
$lang['streams:new_entry']								= "Naujas įrašas";
$lang['streams:stream_entries']							= "Srauto įrašai";
$lang['streams:entries']								= "Įrašai";
$lang['streams:stream_admin']							= "Srauto administravimas";
$lang['streams:list_streams']							= "Parodyti srautus";
$lang['streams:sure']									= "Reikia patvirtinimo";
$lang['streams:field_assignments'] 						= "Srauto laukų priskyrimas";
$lang['streams:new_field_assign']						= "Naujo lauko priskyrimas";
$lang['streams:stream_name']							= "Srauto pavadinimas";
$lang['streams:stream_slug']							= "Srauto šūkis";
$lang['streams:about']									= "Apie";
$lang['streams:total_entries']							= "Viso įrašų";
$lang['streams:add_stream']								= "Naujas srautas";
$lang['streams:edit_stream']							= "Redaguoti srautą";
$lang['streams:about_stream']							= "Trumpas aprašas";
$lang['streams:title_column']							= "Pavadinimo stulpelis";
$lang['streams:sort_method']							= "Rūšiavimo metodas";
$lang['streams:add_entry']								= "Pridėti įrašą";
$lang['streams:edit_entry']								= "Redaguoti įrašą";
$lang['streams:view_options']							= "Peržiūros nustatymai";
$lang['streams:stream_view_options']					= "Srauto vaizdo nustatymai";
$lang['streams:backup_table']							= "Atsarginė srauto lentelė";
$lang['streams:delete_stream']							= "Ištrinti srautą";
$lang['streams:entry']									= "Įrašas";
$lang['streams:field_types']							= "Laukų tipai";
$lang['streams:field_type']								= "Lauko tipas";
$lang['streams:database_table']							= "Duombazės lentelė";
$lang['streams:size']									= "Dydis";
$lang['streams:num_of_entries']							= "Įrašų skaičius";
$lang['streams:num_of_fields']							= "Laukų skaičius";
$lang['streams:last_updated']							= "Atnaujinimo laikas";
$lang['streams:export_schema']							= "Eksportuoti schemą";

/* Startup */

$lang['streams:start.add_one']							= "pridėti vieną čia";
$lang['streams:start.no_fields']						= "Jūs dar nesukūrėte jokių laukų. Galite";
$lang['streams:start.no_assign'] 						= "Atrodo nėra nei vieno lauko šiam srautui. Galite";
$lang['streams:start.add_field_here']					= "pridėti laukus čia";
$lang['streams:start.create_field_here']				= "sukurti lauką čia";
$lang['streams:start.no_streams']						= "Nėra sukurta srautų, galite pradėti";
$lang['streams:start.no_streams_yet']					= "Dar nėra sukurtų srautų.";
$lang['streams:start.adding_one']						= "pridėdami vieną";
$lang['streams:start.no_fields_to_add']					= "Negalima pridėti laukų";
$lang['streams:start.no_fields_msg']					= "Nėra galimų pridėti laukų į šį srautą. PyroStreams modulyje, laukų tipai gali būti panaudojami kitame sraute ir turi būti sukurti prieš pridedant į srautą. Galite pradėti";
$lang['streams:start.adding_a_field_here']				= "pridėdami vieną jų";
$lang['streams:start.no_entries']						= "Nėra yrašų <strong>%s</strong>. Kad pradėti,";
$lang['streams:add_fields']								= "priskirkite laukus";
$lang['streams:no_entries']								= 'Įrašų nėra';
$lang['streams:add_an_entry']							= "pridekite įrašą";
$lang['streams:to_this_stream_or']						= "šiam srautui arba";
$lang['streams:no_field_assign']						= "Nėra lauko priskyrimai";
$lang['streams:no_fields_msg_first']					= "Atrodo, kad dar nėra laukelių priskirtų šiam srautui.";
$lang['streams:no_field_assign_msg']					= "Atrodo nėra laukų šiam srautui. Prieš įvedant duomenis, jums reikia ";
$lang['streams:add_some_fields']						= "priskirti laukų";
$lang['streams:start.before_assign']					= "Prieš priskirdami laukus srautui, jums reikia sukurti lauką. Jūs galite ";
$lang['streams:start.no_fields_to_assign']				= "Nėra galimų laukų priskirti. Prieš priskirdamu lauką, jūs turite ";

/* Buttons */

$lang['streams:yes_delete']								= "Taip, ištrinti";
$lang['streams:no_thanks']								= "Ne, ačiū";
$lang['streams:new_field']								= "Naujas laukas";
$lang['streams:edit']									= "Redaguoti";
$lang['streams:delete']									= "Ištrinti";
$lang['streams:remove']									= "Pašalinti";
$lang['streams:reset']									= "Anuliuoti";

/* Misc */

$lang['streams:field_singular']							= "laukas";
$lang['streams:field_plural']							= "laukai";
$lang['streams:by_title_column']						= "Pagal pavadinimo stulpelį";
$lang['streams:manual_order']							= "Rankinis rūšiavimas";
$lang['streams:stream_data_line']						= "Redaguoti pirminius srauto duomenis";
$lang['streams:view_options_line'] 						= "Pasirinkite, kurie stulepliai bus matomi duomenų sąrašo puslapyje.";
$lang['streams:backup_line']							= "Parsisiųskite atsarginę srautų lentelės kopiją zip faile.";
$lang['streams:permanent_delete_line']					= "Negrįžtamai ištrinti srautą ir jo duomenis.";
$lang['streams:choose_a_field_type']					= "Pasirinkti lauko tipą";
$lang['streams:choose_a_field']							= "Pasirinkti lauką";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "reCaptcha biblioteka inicijuota";
$lang['recaptcha_no_private_key']						= "Neįvedėte API rakto skirto Recaptcha";
$lang['recaptcha_no_remoteip'] 							= "Saugumo sumetimais, į reCAPTCHA įveskite nuotolinį IP";
$lang['recaptcha_socket_fail'] 							= "Negaliu atidaryti socket";
$lang['recaptcha_incorrect_response'] 					= "Neteisingas saugum paveiksliuko atsakymas";
$lang['recaptcha_field_name'] 							= "Saugumo paveiksliukas";
$lang['recaptcha_html_error'] 							= "Klaida, atidarant saugumo paveiksliuką.  Prašome pabandyti vėliau";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "Maksimalus dydis";
$lang['streams:upload_location'] 						= "Failo įkėlimo vieta";
$lang['streams:default_value'] 							= "Numatyta reikšmė";

$lang['streams:menu_path']								= 'Meniu kelias';
$lang['streams:about_instructions']						= 'Trumpas kuriamo srauto aprašymas.';
$lang['streams:slug_instructions']						= 'Tai taip pat bus srauto duomenų bazės vardas.';
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.';
$lang['streams:menu_path_instructions']					= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.'; #translate

/* End of file pyrostreams_lang.php */