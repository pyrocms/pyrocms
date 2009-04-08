<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
// English language file
// ================================================
// Developed: Saulius Okunevicius, saulius@solmetra.com
// Copyright: Solmetra (c)2006 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2006-11-20
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'iso-8859-1';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'spawfm' => array(
    'title' => 'SPAW Manager Souborů',
    'error_reading_dir' => 'Chyba: Nemohu načíst obsah adresáře.',
    'error_upload_forbidden' => 'Chyba: upload souboru není v tomto adresáři povolen.',
    'error_upload_file_too_big' => 'Upload se nezdařil: soubor je příliš velký.',
    'error_upload_failed' => 'Upload souboru se nazdařil.',
    'error_upload_file_incomplete' => 'Uploadovaný soubor není kompletní, zkuste to znovu.',
    'error_bad_filetype' => 'Chyba: soubory tohoto typu nejsou povoleny.',
    'error_max_filesize' => 'Max. přípustná velikost uploudovaného souboru:',
    'error_delete_forbidden' => 'Chyba: mazání souborů v adresáři není povoleno.',
    'confirm_delete' => 'Jste si opravdu jist, že chcete vymazat soubor "[*file*]"?',
    'error_delete_failed' => 'Chyba: soubor nemůže být smazán. Nemáte k této operaci oprávnění.',
    'error_no_directory_available' => 'Nenalezeny žádné adresáře.',
    'download_file' => '[download file]',
    'error_chmod_uploaded_file' => 'Nahrání souboru se zdařilo, ale změna atributů souboru nebyla úspěšná.',
    'error_img_width_max' => 'Maxiální povolená šířka obrázku: [*MAXWIDTH*]px',
    'error_img_height_max' => 'Maxiální povolená výška obrázku: [*MAXHEIGHT*]px',
    'rename_text' => 'Zadejte nové jméno pro soubor "[*FILE*]":',
    'error_rename_file_missing' => 'Přejmenování se nezdařilo - soubor nenalezen.',
    'error_rename_directories_forbidden' => 'Chyba: přejmenování tohoto adresáře není povoleno.',
    'error_rename_forbidden' => 'Chyba: v tomto adresáři není povoleno přejmenovávat soubory.',
    'error_rename_file_exists' => 'Chyba: "[*FILE*]" již existuje.',
    'error_rename_failed' => 'Chyba: přejmenování se nezdařilo. Nemáte potřebná práva.',
    'error_rename_extension_changed' => 'Chyba: není povoleno měnit příponu souborů!',
    'newdirectory_text' => 'Zadejte jméno adresáře:',
    'error_create_directories_forbidden' => 'Chyba: vytváření adresářů je zakázáno',
    'error_create_directories_name_used' => 'Tento název byl již použit, zkuste prosím jiný.',
    'error_create_directories_failed' => 'Chyba: adresář nemohl být vytvořen. Nemáte potřebná práva.',
    'error_create_directories_name_invalid' => 'Tyto znaky nesmí být použity v názvu adresáře: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Jste si jist, že opravdu chcete smazat adresář "[*DIR*]"?',
    'error_delete_subdirectories_forbidden' => 'Smazání adresáře není povoleno.',
    'error_delete_subdirectories_failed' => 'Adresář nemohl být smazán. Nemáte potřebná práva.',
    'error_delete_subdirectories_not_empty' => 'Adresář není prázdný.',
  ),
  'buttons' => array(
    'ok'        => '  OK  ',
    'cancel'    => 'Zrušit',
    'view_list' => 'Zobrazení: seznam',
    'view_details' => 'Zobrazení: detaily',
    'view_thumbs' => 'Zobrazení: náhledy',
    'rename'    => 'Přejmenovat...',
    'delete'    => 'Vymazat',
    'go_up'     => 'O úroveň výš',
    'upload'    =>  'Nahrát',
    'create_directory'  =>  'Vytvořit nový adresář...',
  ),
  'file_details' => array(
    'name'  =>  'Jméno',
    'type'  =>  'Typ',
    'size'  =>  'Velikost',
    'date'  =>  'Datum změny',
    'filetype_suffix'  =>  'soubor',
    'img_dimensions'  =>  'Rozměry',
    'file_folder'  =>  'Složka souborů',
  ),
  'filetypes' => array(
    'any'       => 'Všechny soubory (*.*)',
    'images'    => 'Obrázky',
    'flash'     => 'Flash',
    'documents' => 'Textové soubory',
    'audio'     => 'Zvukové soubory',
    'video'     => 'Video soubory',
    'archives'  => 'Komprimované soubory',
    '.jpg'  =>  'JPG obrázek',
    '.jpeg' =>  'JPG obrázek',
    '.gif'  =>  'GIF obrázek',
    '.png'  =>  'PNG obrázek',
    '.swf'  =>  'Flash',
    '.doc'  =>  'Microsoft Word dokument',
    '.xls'  =>  'Microsoft Excel dokument',
    '.pdf'  =>  'PDF dokument',
    '.rtf'  =>  'RTF dokument',
    '.odt'  =>  'OpenDocument Text',
    '.ods'  =>  'OpenDocument Spreadsheet',
    '.sxw'  =>  'OpenOffice.org 1.0 Text Dokument',
    '.sxc'  =>  'OpenOffice.org 1.0 Spreadsheet',
    '.wav'  =>  'WAV audio',
    '.mp3'  =>  'MP3 audio',
    '.ogg'  =>  'Ogg Vorbis audio',
    '.wma'  =>  'Windows audio',
    '.avi'  =>  'AVI video',
    '.mpg'  =>  'MPEG video',
    '.mpeg' =>  'MPEG video',
    '.mov'  =>  'QuickTime video',
    '.wmv'  =>  'Windows video',
    '.zip'  =>  'ZIP archiv',
    '.rar'  =>  'RAR archiv',
    '.gz'   =>  'gzip archiv',
    '.txt'  =>  'Textový dokument',
    ''  =>  '',
  ),
);
?>
