<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
// German language file
// ================================================
// Developed: Saulius Okunevicius, saulius@solmetra.com
// Translated: Alexander Schmutz, webmaster@sinsolutions.de
// Copyright: Solmetra (c)2006 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2006-11-20
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'spawfm' => array(
    'title' => 'SPAW Datei Manager',
    'error_reading_dir' => 'Fehler: Verzeichnis kann nicht gelesen werden.',
    'error_upload_forbidden' => 'Fehler: Das Hochladen von Dateien ist in diesem Verzeichnis nicht erlaubt.',
    'error_upload_file_too_big' => 'Das Hochladen ist fehlgeschlagen. Die Datei ist zu groß.',
    'error_upload_failed' => 'Das Hochladen ist fehlgeschlagen.',
    'error_upload_file_incomplete' => 'Die Datei zum Hochladen ist nicht komplett. Versuchen Sie es nocheinmal.',
    'error_bad_filetype' => 'Fehler: Dieser Dateityp ist nicht erlaubt.',
    'error_max_filesize' => 'Maximal erlaube Dateigröße:',
    'error_delete_forbidden' => 'Fehler: In diesem Verzeichnis dürfen keine Dateien gelöscht werden.',
    'confirm_delete' => 'Sind sie sicher dass Sie die Datei "[*file*]" löschen wollen?',
    'error_delete_failed' => 'Fehler: Datei konnte nicht gelöscht werden. Möglicherweise haben sie nicht die nötigen Rechte.',
    'error_no_directory_available' => 'Kein Verzeichnis vorhanden das durchsucht werden kann.',
    'download_file' => '[Datei herunterladen]',
    'error_chmod_uploaded_file' => 'Das Hochladen der Datei war erfolgreich, aber die Vergabe der Benutzerrechte ist fehlgeschlagen.',
    'error_img_width_max' => 'Maximal erlaubte Bildbreite: [*MAXWIDTH*]px',
    'error_img_height_max' => 'Maximal erlaubte Bildhöhe: [*MAXHEIGHT*]px',
    'rename_text' => 'Geben Sie einen neuen Dateinamen für die Datei "[*FILE*]" ein:',
    'error_rename_file_missing' => 'Umbenennen fehlgeschlagen - Datei wurde nicht gefunden.',
    'error_rename_directories_forbidden' => 'Fehler: Das Umbenennen von Verzeichnisen ist in diesem Verzeichnis nicht erlaubt.',
    'error_rename_forbidden' => 'Fehler: Das Umbenennen der Dateien ist in diesem Verzeichnis nicht erlaubt.',
    'error_rename_file_exists' => 'Fehler: Die Datei "[*FILE*]" existiert bereits.',
    'error_rename_failed' => 'Fehler: Umbenennen fehlgeschlagen. Möglicherweise haben sie nicht die nötigen Rechte.',
    'error_rename_extension_changed' => 'Fehler: Dateinamenerweiterungen dürfen nicht geändert werden!',
    'newdirectory_text' => 'Geben Sie einen Namen für das Verzeichnis ein:',
    'error_create_directories_forbidden' => 'Fehler: Verzeichnisse erstellen ist verboten',
    'error_create_directories_name_used' => 'Name ist bereits vergeben, versuchen Sie einen anderen.',
    'error_create_directories_failed' => 'Fehler: Verzeichnis konnte nicht erstellt werden. Möglicherweise haben sie nicht die nötigen Rechte.',
    'error_create_directories_name_invalid' => 'Diese Zeichen dürfen in Verzeichnisnamen nicht verwendet werden: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Sind Sie sicher, dass Sie das Verzeichnis "[*DIR*]" löschen wollen?',
    'error_delete_subdirectories_forbidden' => 'Das Löschen von Verzeichnissen ist verboten.',
    'error_delete_subdirectories_failed' => 'Verzeichnis konnte nicht gelöscht werden. Möglicherweise haben sie nicht die nötigen Rechte.',
    'error_delete_subdirectories_not_empty' => 'Verzeichnis ist nicht leer.',
  ),
  'buttons' => array(
    'ok'        => '  OK  ',
    'cancel'    => 'Abbrechen',
    'view_list' => 'Modus: Liste',
    'view_details' => 'Modus: Details',
    'view_thumbs' => 'Modus: Vorschau',
    'rename'    => 'Umbenennen...',
    'delete'    => 'Löschen',
    'go_up'     => 'Ebene höher',
    'upload'    =>  'Hochladen',
    'create_directory'  =>  'Neues Verzeichnis...',
  ),
  'file_details' => array(
    'name'  =>  'Name',
    'type'  =>  'Typ',
    'size'  =>  'Größe',
    'date'  =>  'Datum geändert',
    'filetype_suffix'  =>  'Datei',
    'img_dimensions'  =>  'Dimension',
    'file_folder'  =>  'Datei Ordner',
  ),
  'filetypes' => array(
    'any'       => 'Alle Dateien (*.*)',
    'images'    => 'Bild Dateien',
    'flash'     => 'Flash Filme',
    'documents' => 'Dokumente',
    'audio'     => 'Audio Dateien',
    'video'     => 'Video Dateien',
    'archives'  => 'Archiv Dateien',
    '.jpg'  =>  'JPG Bild Datei',
    '.jpeg'  =>  'JPG Bild Datei',
    '.gif'  =>  'GIF Bild Datei',
    '.png'  =>  'PNG Bild Datei',
    '.swf'  =>  'Flash Film',
    '.doc'  =>  'Microsoft Word Dokument',
    '.xls'  =>  'Microsoft Excel Dokument',
    '.pdf'  =>  'PDF Dokument',
    '.rtf'  =>  'RTF Dokument',
    '.odt'  =>  'OpenDocument Text',
    '.ods'  =>  'OpenDocument Spreadsheet',
    '.sxw'  =>  'OpenOffice.org 1.0 Text Dokument',
    '.sxc'  =>  'OpenOffice.org 1.0 Spreadsheet',
    '.wav'  =>  'WAV Audio Datei',
    '.mp3'  =>  'MP3 Audio Datei',
    '.ogg'  =>  'Ogg Vorbis Audio Datei',
    '.wma'  =>  'Windows Audio Datei',
    '.avi'  =>  'AVI Video Datei',
    '.mpg'  =>  'MPEG Video Datei',
    '.mpeg'  =>  'MPEG Video Datei',
    '.mov'  =>  'QuickTime Video Datei',
    '.wmv'  =>  'Windows Video Datei',
    '.zip'  =>  'ZIP Archiv',
    '.rar'  =>  'RAR Archiv',
    '.gz'  =>  'gzip Archiv',
    '.txt'  =>  'Text Dokument',
    ''  =>  '',
  ),
);
?>