<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
// French language file
// Done by Mehdi Cherifi - Net Studio
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
    'title' => 'SPAW - Gestionnaire des fichiers ',
    'error_reading_dir' => 'Erreur: ne peut pas lire les dossiers contenus.',
    'error_upload_forbidden' => 'Erreur: le chargement de fichiers non permis dans ce dossier.',
    'error_upload_file_too_big' => 'Echec Upload: fichier trop gros.',
    'error_upload_failed' => 'Upload du fichier a &eacute;chou&eacute;.',
    'error_upload_file_incomplete' => 'Upload du fichier incomplet, r&eacute;essayer encore.',
    'error_bad_filetype' => 'Erreur: les fichiers de ce type ne sont pas permis.',
    'error_max_filesize' => 'Tailel maximal de chargement conforme:',
    'error_delete_forbidden' => 'Erreur: supprimer des fichiers non permis dans ce dossier.',
    'confirm_delete' => 'Souhaitez-vous effacer le fichier "[*file*]"?',
    'error_delete_failed' => 'Erreur: suppression fichier impossible. Avez-vous les droits recquis?',
    'error_no_directory_available' => 'Pas de dossiers disponibles pour naviguer.',
    'download_file' => '[t&eacute;l&eacute;charger fichier]',
    'error_chmod_uploaded_file' => 'Upload r&eacute;ussi, mais les droits chmod du fichier ont &eacute;choués.',
    'error_img_width_max' => 'Largeur image maxmimale authoris&eacute;e: [*MAXWIDTH*]px',
    'error_img_height_max' => 'Hauteur image maxmimale authoris&eacute;e: [*MAXHEIGHT*]px',
    'rename_text' => 'Entrer un nouveau nom pour "[*FILE*]":',
    'error_rename_file_missing' => 'Renommage &eacute;echec - fichier introuvable.',
    'error_rename_directories_forbidden' => 'Erreur: renommage des sous-dossiers non permis dans ce dossier.',
    'error_rename_forbidden' => 'Erreur: renommage des fichiers non permis dans ce dossier.',
    'error_rename_file_exists' => 'Erreur: "[*FILE*]" existe d&eacute;ja.',
    'error_rename_failed' => 'Erreur: &eacute;chec renommage. Avez-vous les droits recquis?',
    'error_rename_extension_changed' => 'Erreur: extension de fichier non permise au chargement !',
    'newdirectory_text' => 'Entrer un nom pour le dossier:',
    'error_create_directories_forbidden' => 'Erreur: cr&eacute;ation de dossiers interdite',
    'error_create_directories_name_used' => 'Ce nom est d&eacute;ja utilis&eacute;, veuillez en essayer un autre.',
    'error_create_directories_failed' => 'Erreur: dossier ne peut etre cr&eacute;e. Avez-vous les droits recquis?',
    'error_create_directories_name_invalid' => 'Ces carct&egrave;res ne peuvent etre utilis&eacute;s pour nommer un dossier: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Souhaitez-vous effacer le dossier "[*DIR*]"?',
    'error_delete_subdirectories_forbidden' => 'Suppression des dossiers interdite.',
    'error_delete_subdirectories_failed' => 'Suppression de dossier refus&eacute;e. Avez-vous les droits recquis?',
    'error_delete_subdirectories_not_empty' => 'Ce dossier n\'est pas vide.',
  ),
  'buttons' => array(
    'ok'        => '  OK  ',
    'cancel'    => 'Annuler',
    'view_list' => 'View mode: liste',
    'view_details' => 'View mode: d&eacute;tails',
    'view_thumbs' => 'View mode: thumbnails',
    'rename'    => 'Renommer...',
    'delete'    => 'Supprimer',
    'go_up'     => 'Haut',
    'upload'    =>  'Upload',
    'create_directory'  =>  'Nouveau dossier...',
  ),
  'file_details' => array(
    'name'  =>  'Nom',
    'type'  =>  'Type',
    'size'  =>  'Taille',
    'date'  =>  'Date de modification',
    'filetype_suffix'  =>  'fichier',
    'img_dimensions'  =>  'Dimensions',
    'file_folder'  =>  'Fichier Dossier',
  ),
  'filetypes' => array(
    'any'       => 'Tous les fichiers (*.*)',
    'images'    => 'Images',
    'flash'     => 'Flash',
    'documents' => 'Documents',
    'audio'     => 'Audio',
    'video'     => 'Video',
    'archives'  => 'Archives',
    '.jpg'  =>  'Fichier image JPG',
    '.jpeg'  =>  'Fichier image JPG',
    '.gif'  =>  'Fichier image GIF',
    '.png'  =>  'Fichier image PNG',
    '.swf'  =>  'Flash movie',
    '.doc'  =>  'Document Microsoft Word',
    '.xls'  =>  'Document Microsoft Excel',
	'.ppt'  =>  'Document Microsoft PowerPoint',
    '.pdf'  =>  'Document PDF',
    '.rtf'  =>  'Document RTF',
    '.odt'  =>  'OpenDocument Text',
    '.ods'  =>  'OpenDocument Spreadsheet',
    '.sxw'  =>  'OpenOffice.org 1.0 Text Document',
    '.sxc'  =>  'OpenOffice.org 1.0 Spreadsheet',
    '.wav'  =>  'Fichier audio WAV',
    '.mp3'  =>  'Fichier audio MP3',
    '.ogg'  =>  'Fichier audio Ogg Vorbis',
    '.wma'  =>  'Fichier audio Windows',
    '.avi'  =>  'Fichier video AVI',
    '.mpg'  =>  'Fichier video MPEG',
    '.mpeg'  =>  'Fichier video MPEG',
    '.mov'  =>  'Fichier video QuickTime',
    '.wmv'  =>  'Fichier video Windows',
	'.flv'  =>  'Fichier video FLV',
    '.zip'  =>  'Archive ZIP',
    '.rar'  =>  'Archive RAR',
    '.gz'  =>  'Archive gzip',
    '.txt'  =>  'Document Text',
    ''  =>  '',
  ),
);
?>