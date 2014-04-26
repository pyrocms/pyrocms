<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error']                = 'Hiba történt a mező mentése közben.';
$lang['streams:field_add_success']               = 'Mező sikeresen hozzáadva.';
$lang['streams:field_update_error']              = 'Hiba történt a mező frissítése közben.';
$lang['streams:field_update_success']            = 'Mező sikeresen frissítve.';
$lang['streams:field_delete_error']              = 'Hiba történt a mező törlése közben.';
$lang['streams:field_delete_success']            = 'Mező sikeresen törölve.';
$lang['streams:view_options_update_error']       = 'Hiba történt a nézet beállítások frissítése közben.';
$lang['streams:view_options_update_success']     = 'Nézet beállítások sikeresen frissítve.';
$lang['streams:remove_field_error']              = 'Hiba történt a mező eltávolítása közben.';
$lang['streams:remove_field_success']            = 'Mező sikeresen eltávolítva.';
$lang['streams:create_stream_error']             = 'Hiba történt az adatfolyam létrehozása közben.';
$lang['streams:create_stream_success']           = 'Adatfolyam sikeresen létrehozva.';
$lang['streams:stream_update_error']             = 'Hiba történt  az adatfolyam frissítése közben.';
$lang['streams:stream_update_success']           = 'Adatfolyam sikeresen frissítve.';
$lang['streams:stream_delete_error']             = 'Hiba történt  az adatfolyam törlése közben.';
$lang['streams:stream_delete_success']           = 'Adatfolyam sikeresen törölve.';
$lang['streams:stream_field_ass_add_error']      = 'Hiba történt a mező adatfolyamhoz adása közben.';
$lang['streams:stream_field_ass_add_success']    = 'Mező sikeresen hozzáadva  az adatfolyamhoz.';
$lang['streams:stream_field_ass_upd_error']      = 'Hiba történt a mező hozzárendelés frissítése közben.';
$lang['streams:stream_field_ass_upd_success']    = 'Mező hozzárendelés sikeresen frissítve.';
$lang['streams:delete_entry_error']              = 'Hiba történt a bejegyzés törlése közben.';
$lang['streams:delete_entry_success']            = 'Bejegyzés sikeresen törölve.';
$lang['streams:new_entry_error']                 = 'Hiba történt a bejegyzés hozzáadása közben.';
$lang['streams:new_entry_success']               = 'Bejegyzés sikeresen hozzáadva.';
$lang['streams:edit_entry_error']                = 'Hiba történt a bejegyzés frissítése közben.';
$lang['streams:edit_entry_success']              = 'Bejegyzés sikeresen frissítve.';
$lang['streams:delete_summary']                  = 'Biztos vagy benne hogy törölni akarod a <strong>%s</strong> adatfolyamot? Ez <strong>törölni fogja %s %s-t</strong> véglegesen.';

/* Misc Errors */

$lang['streams:no_stream_provided']              = 'Nem adtál meg adatfolyamot.';
$lang['streams:invalid_stream']                  = 'Érvénytelen adatfolyam.';
$lang['streams:not_valid_stream']                = 'nem érvényes adatfolyam.';
$lang['streams:invalid_stream_id']               = 'Érvénytelen adatfolyam azonosító (ID).';
$lang['streams:invalid_row']                     = 'Érvénytelen sor.';
$lang['streams:invalid_id']                      = 'Érvénytelen azonosító.';
$lang['streams:cannot_find_assign']              = 'Nem található mező hozzárendelés.';
$lang['streams:cannot_find_pyrostreams']         = 'Nem található a PyroStreams.';
$lang['streams:table_exists']                    = 'Már létezik adatbázis tábla "%s" keresőbarát URL-el.';
$lang['streams:no_results']                      = 'Nincs eredmény';
$lang['streams:no_entry']                        = 'Nem található bejegyzés.';
$lang['streams:invalid_search_type']             = 'nem érvényes keresési típus.';
$lang['streams:search_not_found']                = 'Keresés eredménytelen.';

/* Validation Messages */

$lang['streams:field_slug_not_unique']           = 'A mezőhöz megadott keresőbarát URL már létezik.';
$lang['streams:not_mysql_safe_word']             = 'A %s mező egy MySQL foglalt szó.';
$lang['streams:not_mysql_safe_characters']       = 'A %s mező nem megengedett karaktereket tartalmaz.';
$lang['streams:type_not_valid']                  = 'Kérlek válassz egy érvényes mezőtípust.';
$lang['streams:stream_slug_not_unique']          = 'Az adatfolyamhoz megadott keresőbarát URL már létezik.';
$lang['streams:field_unique']                    = 'A %s mezőnek egyedinek kell lennie.';
$lang['streams:field_is_required']               = 'A %s mező kötelező.';
$lang['streams:date_out_or_range']               = 'A dátum amit %s-hoz adtál meg, kívül esik az elfogadható intervallumon.';

/* Field Labels */

$lang['streams:label.field']                     = 'Mező';
$lang['streams:label.field_required']            = 'Kötelező mező';
$lang['streams:label.field_unique']              = 'Egyedi mező';
$lang['streams:label.field_instructions']        = 'Mező útmutatás';
$lang['streams:label.make_field_title_column']   = 'Mező oszlopcímmé tétele';
$lang['streams:label.field_name']                = 'Mezőnév';
$lang['streams:label.field_slug']                = 'Mező keresőbarát URL-je';
$lang['streams:label.field_type']                = 'Mező típus';
$lang['streams:id']                              = 'Azonosító (ID)';
$lang['streams:created_by']                      = 'Létrehozta';
$lang['streams:created_date']                    = 'Létrehozás dátuma';
$lang['streams:updated_date']                    = 'Frissítés dátuma';
$lang['streams:value']                           = 'Érték';
$lang['streams:manage']                          = 'Kezelés';
$lang['streams:search']                          = 'Keresés';
$lang['streams:stream_prefix']                   = 'Adatfolyam előtag';

/* Field Instructions */

$lang['streams:instr.field_instructions']        = 'Megjelenik az űrlapon amikor adatokat adsz meg vagy szerkesztesz.';
$lang['streams:instr.stream_full_name']          = 'Az adatfolyam teljes neve.';
$lang['streams:instr.slug']                      = 'Kisbetűs, csak betűk és aláhúzás.';

/* Titles */

$lang['streams:assign_field']                    = 'Mező hozzárendelése adatfolyamhoz';
$lang['streams:edit_assign']                     = 'Adatfolyam hozzárendelés szerkesztése';
$lang['streams:add_field']                       = 'Mező létrehozása';
$lang['streams:edit_field']                      = 'Mező szerkesztése';
$lang['streams:fields']                          = 'Mezők';
$lang['streams:streams']                         = 'Adatfolyamok';
$lang['streams:list_fields']                     = 'Mezők listázása';
$lang['streams:new_entry']                       = 'Új bejegyzés';
$lang['streams:stream_entries']                  = 'Adatfolyam bejegyzések';
$lang['streams:entries']                         = 'Bejegyzések';
$lang['streams:stream_admin']                    = 'Adatfolyam Admin';
$lang['streams:list_streams']                    = 'Adatfolyamok listázása';
$lang['streams:sure']                            = 'Biztos vagy benne?';
$lang['streams:field_assignments']               = 'Adatfolyam mező hozzárendelések';
$lang['streams:new_field_assign']                = 'Új mező hozzárendelés';
$lang['streams:stream_name']                     = 'Adatfolyam név';
$lang['streams:stream_slug']                     = 'Adatfolyam keresőbarát URL';
$lang['streams:about']                           = 'Leírás';
$lang['streams:total_entries']                   = 'Összes bejegyzés';
$lang['streams:add_stream']                      = 'Új adatfolyam';
$lang['streams:edit_stream']                     = 'Adatfolyam szerkesztése';
$lang['streams:about_stream']                    = 'Az adatfolyamról';
$lang['streams:title_column']                    = 'Oszlop címe';
$lang['streams:sort_method']                     = 'Rendezés módja';
$lang['streams:add_entry']                       = 'Bejegyzés hozzáadása';
$lang['streams:edit_entry']                      = 'Bejegyzés szerkesztése';
$lang['streams:view_options']                    = 'Nézet beállítások';
$lang['streams:stream_view_options']             = 'Adatfolyam nézet beállítások';
$lang['streams:backup_table']                    = 'Adatfolyam tábla biztonsági mentése';
$lang['streams:delete_stream']                   = 'Adatfolyam törlése';
$lang['streams:entry']                           = 'Bejegyzés';
$lang['streams:field_types']                     = 'Mezők typusa';
$lang['streams:field_type']                      = 'Mező típusa';
$lang['streams:database_table']                  = 'Adatbázis tábla';
$lang['streams:size']                            = 'Méret';
$lang['streams:num_of_entries']                  = 'Bejegyzések száma';
$lang['streams:num_of_fields']                   = 'Mezők száma';
$lang['streams:last_updated']                    = 'Utoljára frissítve';
$lang['streams:export_schema']                   = 'Séma exportálása';

/* Startup */

$lang['streams:start.add_one']                   = 'add one here'; #translate
$lang['streams:start.no_fields']                 = 'You have not created any fields yet. To start, you can'; #translate
$lang['streams:start.no_assign']                 = 'Looks like there are no fields yet for this stream. To start, you can'; #translate
$lang['streams:start.add_field_here']            = 'add a field here'; #translate
$lang['streams:start.create_field_here']         = 'create a field here'; #translate
$lang['streams:start.no_streams']                = 'There are no streams yet, but you can start by'; #translate
$lang['streams:start.no_streams_yet']            = 'There are no streams yet.'; #translate
$lang['streams:start.adding_one']                = 'adding one'; #translate
$lang['streams:start.no_fields_to_add']          = 'No Fields to Add';            #translate
$lang['streams:start.no_fields_msg']             = 'There are no fields to add to this stream. In PyroStreams, field types can be shared between streams and must be created before being added to a stream. You can start by'; #translate
$lang['streams:start.adding_a_field_here']       = 'adding a field here'; #translate
$lang['streams:start.no_entries']                = 'There are no entries yet for <strong>%s</strong>. To start, you can'; #translate
$lang['streams:add_fields']                      = 'assign fields'; #translate
$lang['streams:no_entries']								= 'No entries'; #translate
$lang['streams:add_an_entry']                    = 'add an entry'; #translate
$lang['streams:to_this_stream_or']               = 'to this stream or'; #translate
$lang['streams:no_field_assign']                 = 'No Field Assignments'; #translate
$lang['streams:no_fields_msg_first']             = 'Looks like there are no fields yet for this stream.'; #translate
$lang['streams:no_field_assign_msg']             = 'Before you start entering data, you need to'; #translate
$lang['streams:add_some_fields']                 = 'assign some fields'; #translate
$lang['streams:start.before_assign']             = 'Before assigning fields to a stream, you need to create a field. You can'; #translate
$lang['streams:start.no_fields_to_assign']       = 'Looks like there are no fields available to be assigned. Before you can assign a field you must '; #translate

/* Buttons */

$lang['streams:yes_delete']                      = 'Igen, töröld';
$lang['streams:no_thanks']                       = 'Nem, köszönöm';
$lang['streams:new_field']                       = 'Új mező';
$lang['streams:edit']                            = 'Szerkesztés';
$lang['streams:delete']                          = 'Törlés';
$lang['streams:remove']                          = 'Eltávolítás';
$lang['streams:reset']                           = 'Reset';

/* Misc */

$lang['streams:field_singular']                  = 'mező';
$lang['streams:field_plural']                    = 'mezők';
$lang['streams:by_title_column']                 = 'Cím oszlopa szerint';
$lang['streams:manual_order']                    = 'Manuális rendezés';
$lang['streams:stream_data_line']                = 'Az adatfolyam alapadatainak szerkesztése.';
$lang['streams:view_options_line']               = 'Válaszd ki melyik oszlopok látszódjanak az adatok listázása oldalon!';
$lang['streams:backup_line']                     = 'Az adatfolyam táblájának biztonsági mentése és letöltése egy zip fájlba.';
$lang['streams:permanent_delete_line']           = 'Adatfolyam és a hozzá tartozó adatok végleges törlése.';
$lang['streams:choose_a_field_type']             = 'Válassz mező típust';
$lang['streams:choose_a_field']                  = 'Válassz mezőt';

/* reCAPTCHA */

$lang['recaptcha_class_initialized']             = 'reCaptcha Library előkészítve';
$lang['recaptcha_no_private_key']                = 'Nem adtál meg API kulcsot a Recaptcha-hoz';
$lang['recaptcha_no_remoteip']                   = 'Biztonsági okokból át kell adnod a távoli IP-t a reCAPTCHA-nak';
$lang['recaptcha_socket_fail']                   = 'Nem lehetett megnyitni a socket-et';
$lang['recaptcha_incorrect_response']            = 'Ércénytelen biztonsági kép válasz';
$lang['recaptcha_field_name']                    = 'Biztonsági kép';
$lang['recaptcha_html_error']                    = 'Hiba történt a biztonsági kép betöltése közben. Kérlek próbáld meg később';

/* Default Parameter Fields */

$lang['streams:max_length']                      = 'Max hossz';
$lang['streams:upload_location']                 = 'Feltöltés helye';
$lang['streams:default_value']                   = 'Alapértelmezett érték';

$lang['streams:menu_path']								= 'Menu Path'; #translate
$lang['streams:about_instructions']						= 'A short description of your stream.'; #translate
$lang['streams:slug_instructions']						= 'This will also be the database table name for your stream.'; #translate
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.'; #translate
$lang['streams:menu_path_instructions']					= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.'; #translate

/* End of file pyrostreams_lang.php */
