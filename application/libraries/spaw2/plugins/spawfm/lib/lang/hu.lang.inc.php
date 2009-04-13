<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
// English language file
// ================================================
// Developed: Saulius Okunevicius, saulius@solmetra.com
// Translated: Szentgyörgyi János, info@dynamicart.hu
// Copyright: Solmetra (c)2006 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2006-11-20
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'iso-8859-2';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'spawfm' => array(
    'title' => 'SPAW Fájl menedzser',
    'error_reading_dir' => 'Hiba: Nem tudom olvasni a könyvtár tartalmát.',
    'error_upload_forbidden' => 'Hiba: Fájl feltöltés nem engedéjezett ebbe a mappába.',
    'error_upload_file_too_big' => 'Feltöltési hiba: Fájl túl nagy.',
    'error_upload_failed' => 'Fájl feltöltés nem sikerült.',
    'error_upload_file_incomplete' => 'Fájl feltöltés nem fejezõdött be, próbáld újra.',
    'error_bad_filetype' => 'Hiba: Feltöltendõ fájl tipusa nem engedéjezett.',
    'error_max_filesize' => 'A legnagyobb feltöltendõ fájl mérete:',
    'error_delete_forbidden' => 'Hiba: Ebben a mappában nincs engedéjezve a törlés.',
    'confirm_delete' => 'Biztosan akarod törölni ezeket a fájlokat "[*file*]"?',
    'error_delete_failed' => 'Hiba: Fájlt nem tudtam törölni.',
    'error_no_directory_available' => 'Nincs elérhetõ tallózható mappa.',
    'download_file' => '[Fájl letöltés]',
    'error_chmod_uploaded_file' => 'Fájl feltöltés sikeres, de a chmod\'ing nem sikerült.',
    'error_img_width_max' => 'A legnagyobb megengedett képszélesség: [*MAXWIDTH*]px',
    'error_img_height_max' => 'A legnagyobb megengedett képmagasság: [*MAXHEIGHT*]px',
    'rename_text' => 'Kérem az új nevet "[*FILE*]":',
    'error_rename_file_missing' => 'Átnevezés nem sikerült - nem találom a fájlt.',
    'error_rename_directories_forbidden' => 'Hiba: Mappa átnevezés nem engedéjezett ebben a mappában.',
    'error_rename_forbidden' => 'Hiba: Fájl átnevezeés nem megengedett ebben a mappában.',
    'error_rename_file_exists' => 'Hiba: "[*FILE*]" már létezik.',
    'error_rename_failed' => 'Hiba: Átnevezés nem sikerült. Nincs hozzá elegendõ jog.',
    'error_rename_extension_changed' => 'Hiba: A fájl kiterjesztés módosítása nem megengedett!',
    'newdirectory_text' => 'Kérem a mappa nevét:',
    'error_create_directories_forbidden' => 'Hiba: Mappa készítés elutasítva',
    'error_create_directories_name_used' => 'Ezt a nevet már használják, kérlek próbálj másikat.',
    'error_create_directories_failed' => 'Hiba: Mappát nem tudtam mlétrehozni. Nincs elegendõ jogod.',
    'error_create_directories_name_invalid' => 'Ezeket a karaktereket nem használhatod mappanévben: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Biztos törölni akarod a mappát "[*DIR*]"?',
    'error_delete_subdirectories_forbidden' => 'Mappa törlése elutasítva.',
    'error_delete_subdirectories_failed' => 'Mappát nem tudtam törölni. Nincs elegendõ jog.',
    'error_delete_subdirectories_not_empty' => 'Mappa nem üres.',
  ),
  'buttons' => array(
    'ok'        => '  OK  ',
    'cancel'    => 'Mégsem',
    'view_list' => 'Nézet: lista',
    'view_details' => 'Nézet: részletek',
    'view_thumbs' => 'Nézet: kisképek',
    'rename'    => 'Átnevezés',
    'delete'    => 'Törlés',
    'go_up'     => 'Fel',
    'upload'    =>  'Feltöltés',
    ''  =>  '',
  ),
  'file_details' => array(
    'name'  =>  'Név',
    'type'  =>  'Tipus',
    'size'  =>  'Méret',
    'date'  =>  'Dátum',
    'filetype_suffix'  =>  'Fájl',
    'img_dimensions'  =>  'Kép méretei',
    ''  =>  '',
    ''  =>  '',
  ),
  'filetypes' => array(
    'any'       => 'Minden fájl (*.*)',
    'images'    => 'Kép fájlok',
    'flash'     => 'Flash mozik',
    'documents' => 'Dokumentumok',
    'audio'     => 'Zenei fájlok',
    'video'     => 'Videó fájlok',
    'archives'  => 'Arhív fájlok',
    '.jpg'  =>  'JPG kép fájl',
    '.jpeg'  =>  'JPG kép fájl',
    '.gif'  =>  'GIF kép fájl',
    '.png'  =>  'PNG kép fájl',
    '.swf'  =>  'Flash mozi',
    '.doc'  =>  'Microsoft Word dokumentum',
    '.xls'  =>  'Microsoft Excel dokumentum',
    '.pdf'  =>  'PDF dokumentum',
    '.rtf'  =>  'RTF dokumentum',
    '.odt'  =>  'OpenDocument szöveg',
    '.ods'  =>  'OpenDocument táblázat',
    '.sxw'  =>  'OpenOffice.org 1.0 szöveges dokumentum',
    '.sxc'  =>  'OpenOffice.org 1.0 táblázat',
    '.wav'  =>  'WAV hang fájl',
    '.mp3'  =>  'MP3 hang fájl',
    '.ogg'  =>  'Ogg Vorbis hang fájl',
    '.wma'  =>  'Windows hang fájl',
    '.avi'  =>  'AVI videó fájl',
    '.mpg'  =>  'MPEG videó fájl',
    '.mpeg'  =>  'MPEG videó fájl',
    '.mov'  =>  'QuickTime videó fájl',
    '.wmv'  =>  'Windows videó fájl',
    '.zip'  =>  'ZIP tömörítés',
    '.rar'  =>  'RAR tömörítés',
    '.gz'  =>  'gzip tömörítés',
    '.txt'  =>  'Szöveges dokumentum',
    ''  =>  '',
  ),
);
?>
