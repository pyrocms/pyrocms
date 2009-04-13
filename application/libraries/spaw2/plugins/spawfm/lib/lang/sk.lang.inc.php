<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
// Slovak language file
// ================================================
// Developed: Saulius Okunevicius, saulius@solmetra.com
// Copyright: Solmetra (c)2006 All rights reserved.
// Slovak translation: Martin Švec
//                     shuter@vadium.sk
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.2.0, 2008-02-26
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'spawfm' => array(
    'title' => 'SPAW Manažér súborov',
    'error_reading_dir' => 'Chyba: nemôžem prečítať obsah adresára.',
    'error_upload_forbidden' => 'Chyba: upload súboru nieje v tomto adresári povolený.',
    'error_upload_file_too_big' => 'Upload sa nepodaril: súbor je príliš veľký.',
    'error_upload_failed' => 'Upload súboru sa nepodaril.',
    'error_upload_file_incomplete' => 'Uploadovaný súbor nieje kompletný, skúste to znova.',
    'error_bad_filetype' => 'Chyba: súbory tohoto typu nie sú povolené.',
    'error_max_filesize' => 'Max. prípustná veľkosť uploadovaného súboru:',
    'error_delete_forbidden' => 'Chyba: mazanie súborov v adresári nieje povolené.',
    'confirm_delete' => 'Naozaj chcete vymazať súbor "[*file*]"?',
    'error_delete_failed' => 'Chyba: súbor nemôže byť zmazaný. Nemáte oprávnenie k tejto operácii.',
    'error_no_directory_available' => 'Neboli nájdené žiadne adresáre.',
    'download_file' => '[download file]',
    'error_chmod_uploaded_file' => 'Upload súboru sa podaril, ale zmena atribútov súboru nebola úspešná.',
    'error_img_width_max' => 'Maximálna povolená šírka obrázka: [*MAXWIDTH*]px',
    'error_img_height_max' => 'Maximálna povolená výška obrázka: [*MAXHEIGHT*]px',
    'rename_text' => 'Zadajte nové meno pre súbor "[*FILE*]":',
    'error_rename_file_missing' => 'Premenovanie sa nepodarilo - súbor nebol nájdený.',
    'error_rename_directories_forbidden' => 'Chyba: premenovanie tohoto adresára nieje povolené.',
    'error_rename_forbidden' => 'Chyba: v tomto adresári nieje povolené premenovávať súbory.',
    'error_rename_file_exists' => 'Chyba: "[*FILE*]" už existuje.',
    'error_rename_failed' => 'Chyba: premenovanie sa nepodarilo. Nemáte potrebné práva.',
    'error_rename_extension_changed' => 'Chyba: nieje povolené meniť príponu súborov!',
    'newdirectory_text' => 'Zadajte meno adresára:',
    'error_create_directories_forbidden' => 'Chyba: vytváranie adresárov je zakázané',
    'error_create_directories_name_used' => 'Tento názov bol už použitý, skúste prosím použiť iný.',
    'error_create_directories_failed' => 'Chyba: adresár nemohol byť vytvorený. Nemáte potrebné práva.',
    'error_create_directories_name_invalid' => 'Tieto znaky nesmú byť použité v názve adresára: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Naozaj chcete odstrániť adresár "[*DIR*]"?',
    'error_delete_subdirectories_forbidden' => 'Odstránenie adresára nieje povolené.',
    'error_delete_subdirectories_failed' => 'Adresár nemohol byť odstránený. Nemáte potrebné práva.',
    'error_delete_subdirectories_not_empty' => 'Adresár nieje prázdny.',
  ),
  'buttons' => array(
    'ok'        => '  OK  ',
    'cancel'    => 'Zrušiť',
    'view_list' => 'Zobrazenie: zoznam',
    'view_details' => 'Zobrazenie: detaily',
    'view_thumbs' => 'Zobrazenie: náhľady',
    'rename'    => 'Premenovať...',
    'delete'    => 'Vymazať',
    'go_up'     => 'O úroveň vyššie',
    'upload'    =>  'Upload',
    'create_directory'  =>  'Vytvoriť nový adresár...',
  ),
  'file_details' => array(
    'name'  =>  'meno',
    'type'  =>  'Typ',
    'size'  =>  'Veľkosť',
    'date'  =>  'Dátum zmeny',
    'filetype_suffix'  =>  'súbor',
    'img_dimensions'  =>  'Rozmery',
    'file_folder'  =>  'Priečinok súborov',
  ),
  'filetypes' => array(
    'any'       => 'Všetky súbory (*.*)',
    'images'    => 'Obrázky',
    'flash'     => 'Flash',
    'documents' => 'Textové súbory',
    'audio'     => 'Zvukové súbory',
    'video'     => 'Video súbory',
    'archíves'  => 'Komprimované súbory',
    '.jpg'  =>  'JPG obrázok',
    '.jpeg' =>  'JPG obrázok',
    '.gif'  =>  'GIF obrázok',
    '.png'  =>  'PNG obrázok',
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
    '.zip'  =>  'ZIP archív',
    '.rar'  =>  'RAR archív',
    '.gz'   =>  'gzip archív',
    '.txt'  =>  'Textový dokument',
    ''  =>  '',
  ),
);
?>
