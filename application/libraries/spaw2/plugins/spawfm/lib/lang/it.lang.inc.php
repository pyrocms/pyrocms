<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
// Italian language file
// ================================================
// Developed: Saulius Okunevicius, saulius@solmetra.com
// Copyright: Solmetra (c)2006 All rights reserved.
// Italian translation: Ivano Raffeca
// ivoraf@libero.it
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
    'title' => 'SPAW File Manager',
    'error_reading_dir' => 'Errore: non riesco a leggere il contenuto della directory.',
    'error_upload_forbidden' => 'Errore: non &egrave; permesso l\'upload in questa directory.',
    'error_upload_file_too_big' => 'Upload fallito: il file &egrave; troppo grosso.',
    'error_upload_failed' => 'Upload del file fallito.',
    'error_upload_file_incomplete' => 'Upload del file parziale, prova di nuovo.',
    'error_bad_filetype' => 'Errore: il tipo di file/estensione non &egrave; permessa.',
    'error_max_filesize' => 'Massima grandezza del file permessa:',
    'error_delete_forbidden' => 'Errore: la cancellazione del file non &egrave; permessa in questa directory.',
    'confirm_delete' => 'Sei sicuro di voler cancellare il file: "[*file*]"? &Egrave; irreversibile!',
    'error_delete_failed' => 'Errore: il file non pu&ograve; essere cancellato. Non hai il permesso giusto.',
    'error_no_directory_available' => 'Nessuna directory disponibile.',
    'download_file' => '[download file]',
    'error_chmod_uploaded_file' => 'Upload del file eseguita con successo, ma il chmod del file &egrave; fallito.',
    'error_img_width_max' => 'Massima larghezza dell\'immagine permessa: [*MAXWIDTH*]px',
    'error_img_height_max' => 'Massima altezza dell\'immagine permessa: [*MAXHEIGHT*]px',
    'rename_text' => 'Digita il nuovo nome per: "[*FILE*]":',
    'error_rename_file_missing' => 'Rinomina fallito - il file non esiste.',
    'error_rename_directories_forbidden' => 'Errore: rinomina della directory non &egrave; permesso in questa directory.',
    'error_rename_forbidden' => 'Errore: rinomina file non &egrave; permesso in questa directory.',
    'error_rename_file_exists' => 'Errore: il file "[*FILE*]" esiste.',
    'error_rename_failed' => 'Errore: rinomina fallito. Non hai il permesso giusto.',
    'error_rename_extension_changed' => 'Errore: non puoi cambiare l\'estensione del file!',
    'newdirectory_text' => 'Digita il nome della directory:',
    'error_create_directories_forbidden' => 'Errore: creare directory non &egrave; permesso.',
    'error_create_directories_name_used' => 'Il nome &egrave; gi&agrave; usato, prova con un altro.',
    'error_create_directories_failed' => 'Errore: la directory non pu&ograve; essere creata. Non hai il permesso giusto.',
    'error_create_directories_name_invalid' => 'Questi caratteri non possono essere usati nel nome della directory: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Sei sicuro di voler cancellare questa directory "[*DIR*]"? &Egrave; irreversibile!',
    'error_delete_subdirectories_forbidden' => 'Cancellare la directory &egrave; proibito.',
    'error_delete_subdirectories_failed' => 'la directory non pu&ograve; essere cancellata. Non hai il permesso giusto.',
    'error_delete_subdirectories_not_empty' => 'La directory non &egrave; vuota.',
  ),
  'buttons' => array(
    'ok'        => '  OK  ',
    'cancel'    => 'Cancella',
    'view_list' => 'Vista: lista',
    'view_details' => 'Vista: dettaglio',
    'view_thumbs' => 'Vista: anteprima',
    'rename'    => 'Rinomina...',
    'delete'    => 'Cancella',
    'go_up'     => 'Su',
    'upload'    =>  'Upload',
    'create_directory'  =>  'Nuova directory...',
  ),
  'file_details' => array(
    'name'  =>  'Nome',
    'type'  =>  'Tipo',
    'size'  =>  'Grandezza',
    'date'  =>  'Data modificata',
    'filetype_suffix'  =>  'file',
    'img_dimensions'  =>  'Dimensioni',
    'file_folder'  =>  'Cartella file',
  ),
  'filetypes' => array(
    'any'       => 'Tutti i file (*.*)',
    'images'    => 'File immagine',
    'flash'     => 'Filmati Flash',
    'documents' => 'Documenti',
    'audio'     => 'File Audio',
    'video'     => 'File Video',
    'archives'  => 'File Archivio',
    '.jpg'  =>  'Immagine JPG',
    '.jpeg'  =>  'Immagine JPG',
    '.gif'  =>  'Immagine GIF',
    '.png'  =>  'Immagine PNG',
    '.swf'  =>  'Filmato Flash',
    '.doc'  =>  'Documenti Microsoft Word',
    '.xls'  =>  'Documenti Microsoft Excel',
    '.pdf'  =>  'Documenti Acrobat PDF',
    '.rtf'  =>  'Documenti RTF',
    '.odt'  =>  'Documenti OpenDocument Testo',
    '.ods'  =>  'Documenti OpenDocument Foglio di Calcolo',
    '.sxw'  =>  'Documenti OpenOffice.org 1.0 Testo',
    '.sxc'  =>  'Documenti OpenOffice.org 1.0 Foglio di Calcolo',
    '.wav'  =>  'Documenti WAV file audio',
    '.mp3'  =>  'Documenti MP3 file audio',
    '.ogg'  =>  'Documenti Ogg Vorbis file audio',
    '.wma'  =>  'Documenti Windows file audio',
    '.avi'  =>  'Documenti AVI file video',
    '.mpg'  =>  'Documenti MPEG file video',
    '.mpeg'  =>  'Documenti MPEG file video',
    '.mov'  =>  'Documenti QuickTime file video',
    '.wmv'  =>  'Documenti Windows file video',
    '.zip'  =>  'Documenti archivio ZIP',
    '.rar'  =>  'Documenti archivio RAR',
    '.gz'  =>  'Documenti archivio gzip',
    '.txt'  =>  'Documenti di Testo TXT',
    ''  =>  '',
  ),
);
?>