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
    'title' => 'SPAW Bestandsbeheer',
    'error_reading_dir' => 'Fout: kan map niet lezen.',
    'error_upload_forbidden' => 'Fout: het is niet toegestaan in deze map bestanden te uploaden.',
    'error_upload_file_too_big' => 'Upload mislukt: bestand te groot.',
    'error_upload_failed' => 'Uploaden van bestand mislukt.',
    'error_upload_file_incomplete' => 'De upload was niet volledig, probeer het opnieuw.',
    'error_bad_filetype' => 'Fout: dit bestandstype is niet toegestaan.',
    'error_max_filesize' => 'Maximale bestandsgrootte:',
    'error_delete_forbidden' => 'Fout: het verwijderen van bestanden is niet toegestaan in deze map.',
    'confirm_delete' => 'Weet u zeker dat u het bestand "[*file*]" wilt verwijderen?',
    'error_delete_failed' => 'Fout: bestand kon niet worden verwijderd. Mogelijk heeft u hiertoe geen rechten.',
    'error_no_directory_available' => 'No directories available for browsing.',
    'download_file' => '[Bestand downloaden]',
    'error_chmod_uploaded_file' => 'Upload gelukt, fout opgetreden bij het toekennen van rechten.',
    'error_img_width_max' => 'Maximale toegestane breedte: [*MAXWIDTH*]px',
    'error_img_height_max' => 'Maximale toegestane hoogte: [*MAXHEIGHT*]px',
    'rename_text' => 'Voer een nieuwe naam in voor het bestand "[*FILE*]":',
    'error_rename_file_missing' => 'Hernoemen mislukt - het bestand kon niet worden gevonden.',
    'error_rename_directories_forbidden' => 'Fout: het hernoemen van bestanden is niet toegestaan in deze map.',
    'error_rename_forbidden' => 'Fout: het hernoemen van bestanden is niet toegestaan in deze map.',
    'error_rename_file_exists' => 'Fout: "[*FILE*]" bestaat al.',
    'error_rename_failed' => 'Fout: hernoemen mislukt. Mogelijk heeft u hiertoe geen rechten.',
    'error_rename_extension_changed' => 'Fout: het is niet toegestaan het bestandstype te wijzigen!',
    'newdirectory_text' => 'Voer een nieuwe naam in voor deze map:',
    'error_create_directories_forbidden' => 'Fout: het is niet toegestaan nieuwe mappen aan te maken',
    'error_create_directories_name_used' => 'Deze naam is al in gebruik, voer een nieuwe naam in.',
    'error_create_directories_failed' => 'Fout: map kon niet worden aangemaakt. Mogelijk heeft u hiertoe geen rechten.',
    'error_create_directories_name_invalid' => 'De volgende tekens zijn niet toegestaan in een mapnaam: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Weet u zeker dat u de map "[*DIR*]" wilt verwijderen?',
    'error_delete_subdirectories_forbidden' => 'Het is niet toegestaan mappen te verwijderen.',
    'error_delete_subdirectories_failed' => 'Map kon niet worden verwijderd. Mogelijk heeft u hiertoe geen rechten.',
    'error_delete_subdirectories_not_empty' => 'De map is niet leeg.',
  ),
  'buttons' => array(
    'ok'        => '  OK  ',
    'cancel'    => 'Annuleren',
    'view_list' => 'Overzicht: lijst',
    'view_details' => 'Overzicht: details',
    'view_thumbs' => 'Overzicht: thumbnails',
    'rename'    => 'Hernoemen...',
    'delete'    => 'Verwijderen',
    'go_up'     => 'Omhoog',
    'upload'    =>  'Uploaden',
    'create_directory'  =>  'Nieuwe map...',
  ),
  'file_details' => array(
    'name'  =>  'Naam',
    'type'  =>  'Type',
    'size'  =>  'Grootte',
    'date'  =>  'Datum aangepast',
    'filetype_suffix'  =>  'bestand',
    'img_dimensions'  =>  'Afmetingen',
    'file_folder'  =>  'Bestandsmap',
  ),
  'filetypes' => array(
    'any'       => 'Alle bestanden (*.*)',
    'images'    => 'Afbeeldingen',
    'flash'     => 'Flash bestanden',
    'documents' => 'Documenten',
    'audio'     => 'Audio bestanden',
    'video'     => 'Video bestanden',
    'archives'  => 'Archief bestanden',
    '.jpg'  =>  'JPG afbeelding',
    '.jpeg'  =>  'JPG afbeelding',
    '.gif'  =>  'GIF afbeelding',
    '.png'  =>  'PNG afbeelding',
    '.swf'  =>  'Flash bestand',
    '.doc'  =>  'Microsoft Word document',
    '.xls'  =>  'Microsoft Excel document',
    '.pdf'  =>  'PDF document',
    '.rtf'  =>  'RTF document',
    '.odt'  =>  'OpenDocument Text',
    '.ods'  =>  'OpenDocument Spreadsheet',
    '.sxw'  =>  'OpenOffice.org 1.0 Text Document',
    '.sxc'  =>  'OpenOffice.org 1.0 Spreadsheet',
    '.wav'  =>  'WAV audio bestand',
    '.mp3'  =>  'MP3 audio bestand',
    '.ogg'  =>  'Ogg Vorbis audio bestand',
    '.wma'  =>  'Windows audio bestand',
    '.avi'  =>  'AVI video bestand',
    '.mpg'  =>  'MPEG video bestand',
    '.mpeg'  =>  'MPEG video bestand',
    '.mov'  =>  'QuickTime video bestand',
    '.wmv'  =>  'Windows video bestand',
    '.zip'  =>  'ZIP archief',
    '.rar'  =>  'RAR archief',
    '.gz'  =>  'gzip archief',
    '.txt'  =>  'Text document',
    ''  =>  '',
  ),
);
?>