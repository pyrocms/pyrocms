<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
// Welsh language file
// ================================================
// Developed: Saulius Okunevicius, saulius@solmetra.com
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
// translation: Alan Davies: alandavies@tiscali.co.uk
$spaw_lang_data = array(
  'spawfm' => array(
    'title' => 'Rheolwr Ffeiliau SPAW',
    'error_reading_dir' => 'Gwall: methu darllen cynnwys ffolder.',
    'error_upload_forbidden' => 'Gwall: nid oes hawl llwytho ffeiliau i\'r ffolder hwn.',
    'error_upload_file_too_big' => 'Methu llwytho: ffeil yn rhy fawr.',
    'error_upload_failed' => 'Methu llwytho\'r ffeil.',
    'error_upload_file_incomplete' => 'Ffeil a lwythwyd yn anghyflawn, ceisiwch eto.',
    'error_bad_filetype' => 'Gwall: dim ond lluniau!',
    'error_max_filesize' => 'Maint ffeil mwyaf wedi\'i dderbyn:',
    'error_delete_forbidden' => 'Gwall: nid oes hawl dileu ffeiliau yn y ffolder hwn.',
    'confirm_delete' => 'Ydych chi\'n sicr rydych am ddileu\'r ffeil "[*file*]"?',
    'error_delete_failed' => 'Gwall: methu dileu\'r ffeil. Efallai nid oes gennych yr hawliau priodol.',
    'error_no_directory_available' => 'Dim ffolderi ar gael i\'w pori.',
    'download_file' => '[lawrlwytho\'r ffeil]',
    'error_chmod_uploaded_file' => 'Llwytho\'r ffeil yn llwyddiannus, ond methodd broses chmod ar y ffeil.',
    'error_img_width_max' => 'Lled mwyaf y ddelwedd a ganiateir: [*MAXWIDTH*]px',
    'error_img_height_max' => 'Uchder mwyaf y ddelwedd a ganiateir: [*MAXHEIGHT*]px',
    'rename_text' => 'Rhowch yr enw newydd am "[*FILE*]":',
    'error_rename_file_missing' => 'Ailenwi wedi methu - methu darganfod y ffeil.',
    'error_rename_directories_forbidden' => 'Gwall: nid oes hawl newid enwau\'r ffolderi yn y ffolder hwn.',
    'error_rename_forbidden' => 'Gwall: nid oes hawl newid enwau\'r ffeiliau yn y ffolder hwn..',
    'error_rename_file_exists' => 'Gwall: "[*FILE*]" yn bodoli eisoes.',
    'error_rename_failed' => 'Gwall: methodd yr ailenwi. Mae\'n bosib nid oes hawliau gennych i\'w newid.',
    'error_rename_extension_changed' => 'Gwall: nid oes hawl newid estyniad ffeiliau!',
    'newdirectory_text' => 'Rhowch yr enw am y ffolder:',
    'error_create_directories_forbidden' => 'Gwall: nid oes hawl creu ffolderi.',
    'error_create_directories_name_used' => 'Mae\'r enw yn cael ei ddefnyddio eisoes, dewiswch un arall.',
    'error_create_directories_failed' => 'Gwall: methu creu\'r ffolder. Mae\'n bosib nid oes hawliau gennych i\'w newid.',
    'error_create_directories_name_invalid' => 'Nid oes modd defnyddio\'r cymeriadau canlynol ar gyfer enw ffolder: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Ydych chi\'n sicr rydych am ddileu\'r ffolder "[*DIR*]"?',
    'error_delete_subdirectories_forbidden' => 'Nid oes hawl dileu ffolderi.',
    'error_delete_subdirectories_failed' => 'Nid oes modd dileu\'r ffolder. Mae\'n bosib nid oes hawliau gennych i\'w newid.',
    'error_delete_subdirectories_not_empty' => 'Nid yw\'r ffolder yn wag.',
  ),
  'buttons' => array(
    'ok'        => ' Iawn ',
    'cancel'    => 'Canslo',
    'view_list' => 'Golwg: rhestr',
    'view_details' => 'Golwg: manylion',
    'view_thumbs' => 'Golwg: bawdluniau',
    'rename'    => 'Ail-enwi...',
    'delete'    => 'Dileu',
    'go_up'     => 'I fyny',
    'upload'    =>  'Llwytho',
    'create_directory'  =>  'Ffolder newydd...',
  ),
  'file_details' => array(
    'name'  =>  'Enw',
    'type'  =>  'Teip',
    'size'  =>  'Maint',
    'date'  =>  'Dyddiad a newidwyd',
    'filetype_suffix'  =>  'ffeil',
    'img_dimensions'  =>  'Dimensiynau',
    'file_folder'  =>  'Ffolder Ffeiliau',
  ),
  'filetypes' => array(
    'any'       => 'Pob ffeil (*.*)',
    'images'    => 'Lluniau ',
    'flash'     => 'Ffeiliau Flash',
    'documents' => 'Dogfennau',
    'audio'     => 'Ffeiliau sain',
    'video'     => 'Ffeiliau fideo',
    'archives'  => 'Ffeiliau arcif',
    '.jpg'  =>  'ffeil delwedd JPG',
    '.jpeg'  =>  'ffeil delwedd JPG',
    '.gif'  =>  'ffeil delwedd GIF',
    '.png'  =>  'ffeil delwedd PNG',
    '.swf'  =>  'Ffeil Flash',
    '.doc'  =>  'Dogfen Microsoft Word',
    '.xls'  =>  'Dogfen Microsoft Excel',
    '.pdf'  =>  'Dogfen PDF',
    '.rtf'  =>  'Dogfen RTF',
    '.odt'  =>  'Ffeil Testun OpenDocument',
    '.ods'  =>  'Taenlen OpenDocument',
    '.sxw'  =>  'Dogfen Testun OpenOffice.org 1.0',
    '.sxc'  =>  'Taenlen OpenOffice.org 1.0',
    '.wav'  =>  'Ffeil sain WAV',
    '.mp3'  =>  'Ffeil sain MP3',
    '.ogg'  =>  'Ffeil sain Ogg Vorbis',
    '.wma'  =>  'Ffeil sain Windows',
    '.avi'  =>  'Ffeil fideo AVI',
    '.mpg'  =>  'Ffeil fideo MPEG',
    '.mpeg'  =>  'Ffeil fideo MPEG',
    '.mov'  =>  'Ffeil fideo QuickTime',
    '.wmv'  =>  'Ffeil fideo Windows',
    '.zip'  =>  'Arcif ZIP',
    '.rar'  =>  'Arcif RAR',
    '.gz'  =>  'Arcif gzip',
    '.txt'  =>  'Dogfen Testun',
    ''  =>  '',
  ),
);
?>