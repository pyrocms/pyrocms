<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
// Lithuanian language file
// ================================================
// Developed: Saulius Okunevicius, saulius@solmetra.com
// Translated: Saulius Okunevicius, saulius@solmetra.com
// Copyright: Solmetra (c)2006 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2007-01-29
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'spawfm' => array(
    'title' => 'SPAW Failų tvarkyklė',
    'error_reading_dir' => 'Klaida: nepavyko nuskaityti katalogo.',
    'error_upload_forbidden' => 'Klaida: failų atsiuntimas šiame kataloge uždraustas.',
    'error_upload_file_too_big' => 'Atsiuntimas nutrauktas: failas per didelis.',
    'error_upload_failed' => 'Failo atsiuntimas nepavyko.',
    'error_upload_file_incomplete' => 'Atsiųstas failas yra nepilnas, mėginkite dar kartą.',
    'error_bad_filetype' => 'Klaida: šio tipo failai neleidžiami.',
    'error_max_filesize' => 'Maksimalus priimamų failų dydis:',
    'error_delete_forbidden' => 'Klaida: šiame kataloge trinti failų neleidžiama.',
    'confirm_delete' => 'Ar tikrai norite ištrinti failą "[*file*]"?',
    'error_delete_failed' => 'Klaida: failo ištrinti nepavyko. Galite neturėti teisių tai atlikti.',
    'error_no_directory_available' => 'Naršytinų katalogų nėra.',
    'download_file' => '[atsisiųsti failą]',
    'error_chmod_uploaded_file' => 'Failo atsiuntimas sėkmingas, tačiau jo teisių pakeisti nepavyko.',
    'error_img_width_max' => 'Maksimalus leidžiamas paveiksliuko plotis: [*MAXWIDTH*]px',
    'error_img_height_max' => 'Maksimalus leidžiamas paveiksliuko aukštis: [*MAXHEIGHT*]px',
    'rename_text' => 'Nurodykite naują "[*FILE*]" pavadinimą:',
    'error_rename_file_missing' => 'Pervadinti nepavyko - toks failas nerastas.',
    'error_rename_directories_forbidden' => 'Klaida: šiame kataloge pakatalogių pervadinimas uždraustas.',
    'error_rename_forbidden' => 'Klaida: šiame kataloge failų pervadinimas uždraustas.',
    'error_rename_file_exists' => 'Klaida: "[*FILE*]" jau yra.',
    'error_rename_failed' => 'Klaida: pervadinti nepavyko. Galite neturėti teisių tai atlikti.',
    'error_rename_extension_changed' => 'Klaida: failo išplėtimo keisti neleidžiama!',
    'newdirectory_text' => 'Įveskite katalogo pavadinimą:',
    'error_create_directories_forbidden' => 'Klaida: kurti katalogus neleidžiama',
    'error_create_directories_name_used' => 'Toks pavadinimas jau naudojamas, pasirinkite kitą.',
    'error_create_directories_failed' => 'Klaida: nepavyko sukurti katalogo. Galite neturėti teisių tai atlikti.',
    'error_create_directories_name_invalid' => 'Šie simboliai negali būti naudojami pavadinime: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Ar tikrai norite ištrinti katalogą "[*DIR*]"?',
    'error_delete_subdirectories_forbidden' => 'Trinti katalogus neleidžiama.',
    'error_delete_subdirectories_failed' => 'Katalogo ištrinti nepavyko, galite neturėti teisių tai atlikti.',
    'error_delete_subdirectories_not_empty' => 'Katalogas netuščias.',
  ),
  'buttons' => array(
    'ok'        => ' Tinka ',
    'cancel'    => 'Atšaukti',
    'view_list' => 'Rodyti kaip sąrašą',
    'view_details' => 'Rodyti kaip detalų sąrašą',
    'view_thumbs' => 'Rodyti paveiksliukus',
    'rename'    => 'Pervadinti...',
    'delete'    => 'Ištrinti',
    'go_up'     => 'Peršokti aukštyn',
    'upload'    =>  'Atsiųsti',
    'create_directory'  =>  'Naujas katalogas...',
  ),
  'file_details' => array(
    'name'  =>  'Pavadinimas',
    'type'  =>  'Tipas',
    'size'  =>  'Dydis',
    'date'  =>  'Pakeitimo data',
    'filetype_suffix'  =>  'failas',
    'img_dimensions'  =>  'Išmatavimai',
    'file_folder'  =>  'Katalogas',
  ),
  'filetypes' => array(
    'any'       => 'Visi failai (*.*)',
    'images'    => 'Paveiksliukai',
    'flash'     => 'Flash filmukai',
    'documents' => 'Dokumentai',
    'audio'     => 'Garso įrašai',
    'video'     => 'Vaizdo įrašai',
    'archives'  => 'Archyvai',
    '.jpg'  =>  'JPG paveiksliukas',
    '.jpeg'  =>  'JPG paveiksliukas',
    '.gif'  =>  'GIF paveiksliukas',
    '.png'  =>  'PNG paveiksliukas',
    '.swf'  =>  'Flash filmukas',
    '.doc'  =>  'Microsoft Word dokumentas',
    '.xls'  =>  'Microsoft Excel dokumentas',
    '.pdf'  =>  'PDF dokumentas',
    '.rtf'  =>  'RTF dokumentas',
    '.odt'  =>  'OpenDocument tekstas',
    '.ods'  =>  'OpenDocument skaičiuoklė',
    '.sxw'  =>  'OpenOffice.org 1.0 tekstas',
    '.sxc'  =>  'OpenOffice.org 1.0 skaičiuoklė',
    '.wav'  =>  'WAV garso įrašas',
    '.mp3'  =>  'MP3 garso įrašas',
    '.ogg'  =>  'Ogg Vorbis garso įrašas',
    '.wma'  =>  'Windows garso įrašas',
    '.avi'  =>  'AVI vaizdo įrašas',
    '.mpg'  =>  'MPEG vaizdo įrašas',
    '.mpeg'  =>  'MPEG vaizdo įrašas',
    '.mov'  =>  'QuickTime vaizdo įrašas',
    '.wmv'  =>  'Windows vaizdo įrašas',
    '.zip'  =>  'ZIP archyvas',
    '.rar'  =>  'RAR archyvas',
    '.gz'  =>  'gzip archyvas',
    '.txt'  =>  'Tekstinis dokumentas',
    ''  =>  '',
  ),
);
?>