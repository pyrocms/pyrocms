<?php defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['files:files_title']                       = 'Fájlok';
$lang['files:fetching']                          = 'Adatok beolvasása ...';
$lang['files:fetch_completed']                   = 'Kész';
$lang['files:save_failed']                       = 'Bocsánat. A változásokat nem lehetett elmenteni';
$lang['files:item_created']                      = '"%s" létrehozva';
$lang['files:item_updated']                      = '"%s" frissítve';
$lang['files:item_deleted']                      = '"%s" törölve';
$lang['files:item_not_deleted']                  = '"%s"-t nem lehet törölni';
$lang['files:item_not_found']                    = 'Bocsánat. "%s" nem található';
$lang['files:sort_saved']                        = 'Rendezés mentve';
$lang['files:no_permissions']                    = 'Nincs elegendő jogosultságod';

// Labels
$lang['files:activity']                          = 'Aktivitás';
$lang['files:places']                            = 'Helyek';
$lang['files:back']                              = 'Vissza';
$lang['files:forward']                           = 'Előre';
$lang['files:start']                             = 'Feltöltés kezdése';
$lang['files:details']                           = 'Részletek';
$lang['files:name']                              = 'Név';
$lang['files:slug']                              = 'Keresőbarát URL';
$lang['files:path']                              = 'Útvonal';
$lang['files:added']                             = 'Hozzáadva';
$lang['files:width']                             = 'Szélesség';
$lang['files:height']                            = 'Magasság';
$lang['files:ratio']                             = 'Arány';
$lang['files:alt_attribute']					= 'alt Attribute'; #translate
$lang['files:full_size']                         = 'Teljes méret';
$lang['files:filename']                          = 'Fájlnév';
$lang['files:filesize']                          = 'Fájlméret';
$lang['files:download_count']                    = 'Letöltés számláló';
$lang['files:download']                          = 'Letöltés';
$lang['files:location']                          = 'Hely';
$lang['files:description']                       = 'Leírás';
$lang['files:container']                         = 'Container'; # didn't translate intentionally
$lang['files:bucket']                            = 'Bucket'; # shouldn't translate
$lang['files:check_container']                   = 'Érvényesség ellenőrzése';
$lang['files:search_message']                    = 'Írj valamit és üss Entert';
$lang['files:search']                            = 'Keresés';
$lang['files:synchronize']                       = 'Szinkronizálás';
$lang['files:uploader']                          = 'Húzz ide fájlokat <br />vagy<br />Kattints a fájlok kiválasztásához';
$lang['files:replace_file']						 = 'Replace file'; #translate

// Context Menu
$lang['files:refresh']						= 'Refresh'; #translate
$lang['files:open']                              = 'Megnyitás';
$lang['files:new_folder']                        = 'Új mappa';
$lang['files:upload']                            = 'Feltöltés';
$lang['files:rename']                            = 'Átnevezés';
$lang['files:delete']                            = 'Törlés';
$lang['files:edit']                              = 'Szerkesztés';
$lang['files:details']                           = 'Részletek';

// Folders

$lang['files:no_folders']                        = 'A fájlokat és mappákat ugyanúgy kezelheted, akárcsak a desktopodon. Kattints jobb gombbal az alábbi területre hogy létrehozd az első mappád. Azután kattints jobb gombbal a mappára az átnevezéshez, törléshez, fájlok feltöltéséhez a mappába vagy olyan részletek megváltoztatásához mint egy "cloud" helyhez való linkelés.';
$lang['files:no_folders_places']                 = 'Mappák amiket létrehozol, itt fognak megjelenni egy fában, amit összecsukhatsz és kinyithatsz. Kattints a "Helyek"-re a gyökérmappához.';
$lang['files:no_folders_wysiwyg']                = 'Még nincsenek mappák';
$lang['files:new_folder_name']                   = 'Ismeretlen mappa';
$lang['files:folder']                            = 'Mappa';
$lang['files:folders']                           = 'Mappák';
$lang['files:select_folder']                     = 'Válassz ki egy mappát';
$lang['files:subfolders']                        = 'Almappák';
$lang['files:root']                              = 'Gyökérmappa';
$lang['files:no_subfolders']                     = 'Nincsenek almappák';
$lang['files:folder_not_empty']                  = 'Előbb törölnöd kell a "%s" tartalmát';
$lang['files:mkdir_error']                       = '%s-t nem lehet létrehozni. Manuálisan kell létrehoznod';
$lang['files:chmod_error']                       = 'A feltöltési könyvtár nem írható. A jogosultsága 0777 kell hogy legyen';
$lang['files:location_saved']                    = 'A mappa helye elmentve';
$lang['files:container_exists']                  = '"%s" már létezik. Mentsd el hogy a tartalmát ehhez a mappához linkeljük.';
$lang['files:container_not_exists']              = '"%s" nem létezik az accountodon. Mentsd el és megpróbáljuk létrehozni';
$lang['files:error_container']                   = '"%s" nem lehet létrehozni és nem tudjuk az okát';
$lang['files:container_created']                 = '"%s" létrehozva és most már ehhez a mappához van linkelve';
$lang['files:unwritable']                        = '"%s" nem írható, kérlek állítsd be a jogosultságát 0777 -re';
$lang['files:specify_valid_folder']              = 'Érvényes mappát kell megadnod a fájl feltöltéséhez';
$lang['files:enable_cdn']                        = 'Engedélyezned kell a CDN-t a "%s"-hoz a Rackspace control panelen mielőtt szinkronizálni tudjuk';
$lang['files:synchronization_started']           = 'Szinkronizálás kezdése';
$lang['files:synchronization_complete']          = 'A "%s" szinkronizálása befejezve';
$lang['files:untitled_folder']                   = 'Ismeretlen mappa';

// Files
$lang['files:no_files']                          = 'Nem találhatóak fájlok';
$lang['files:file_uploaded']                     = '"%s" feltöltve';
$lang['files:unsuccessful_fetch']                = '"%s"-t nem lehetett lekérni. Biztos vagy benne hogy ez egy publikus fájl ?';
$lang['files:invalid_container']                 = '"%s" nem tűnik érvényes container-nek.';
$lang['files:no_records_found']                  = 'Nem található feljegyzés';
$lang['files:invalid_extension']                 = '"%s"-nak nem engedélyezett a fájlkiterjesztése';
$lang['files:upload_error']                      = 'A fájlfeltöltés nem sikerült';
$lang['files:description_saved']                 = 'A leírás elmentve';
$lang['files:alt_saved']						= 'The image alt attribute has been saved'; #translate
$lang['files:file_moved']                        = '"%s" sikeresen áthelyezve';
$lang['files:exceeds_server_setting']            = 'A szerver nem tud ekkora méretű fájlt kezelni';
$lang['files:exceeds_allowed']                   = 'A fájl mérete túllépi a maximum engedélyezett méretet';
$lang['files:replace_warning']				= 'Warning: Do not replace a file with a file of a different type (e.g. .jpg with .png)'; #translate
$lang['files:file_type_not_allowed']             = 'Nem engedélyezett fájltípus';
$lang['files:type_a']                            = 'Audió';
$lang['files:type_v']                            = 'Videó';
$lang['files:type_d']                            = 'Dokumentum';
$lang['files:type_i']                            = 'Kép';
$lang['files:type_o']                            = 'Egyéb';

/* End of file files_lang.php */
