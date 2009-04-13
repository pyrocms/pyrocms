<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
//
//
// Arabic language file
// Traslated: Mohammed Ahmed
// Gaza, Palestine
// http://www.maaking.com
// Email/MSN: m@maaking.com
//
// last update: 18-oct-2007
//
// ================================================
// Developed: Saulius Okunevicius, saulius@solmetra.com
// Copyright: Solmetra (c)2006 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.2.0
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'windows-1256';

// text direction for the language
$spaw_lang_direction = 'rtl';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'spawfm' => array(
    'title' => '≈œ«—… «·„·›« ',
    'error_reading_dir' => 'Œÿ√: ·« Ì„ﬂ‰ ﬁ—«¡… „Õ ÊÌ«  «·„Ã·œ',
    'error_upload_forbidden' => 'Œÿ√:  Õ„Ì· «·„·›«  €Ì— „”„ÊÕ ›Ì Â–« «·„Ã·œ.',
    'error_upload_file_too_big' => '›‘ «· Õ„Ì·: ÕÃ„ «·„·› ﬂ»Ì— Ãœ«..',
    'error_upload_failed' => '›‘  Õ„Ì· «·„·›.',
    'error_upload_file_incomplete' => '›‘ ›Ì  Õ„Ì· «·„·›° «·—Ã«¡ «·„Õ«Ê·… „—Ï √Œ—Ï.',
    'error_bad_filetype' => 'Œÿ√: Â–« «·‰Ê⁄ „‰ «·„·›«  €Ì— „”„ÊÕ »Â.',
    'error_max_filesize' => '«·ÕÃ„ «·„”„ÊÕ »Â: ',
    'error_delete_forbidden' => 'Œÿ√: Õ–› «·„·›«  ›Ì Â–« «·„Ã·œ €Ì— „”„ÊÕ »Â.',
    'confirm_delete' => 'Â·  —Ìœ Õ–› «·„·› "[*file*]"?',
    'error_delete_failed' => 'Œÿ√: —»„« ·« ÌÊÃœ ·ﬂ ’·«ÕÌ«  ·Õ–› Â–« «·„·›.',
    'error_no_directory_available' => '·« ÌÊÃœ „Ã·œ«  · ’›ÕÂ«.',
    'download_file' => '[ Õ„Ì· «·„·›]',
    'error_chmod_uploaded_file' => ' „ —›⁄ «·„·›° ·ﬂ‰ ·„ Ì⁄ÿÏ  ’—ÌÕ CHMOD',
    'error_img_width_max' => '√ﬁ’Ï ⁄—÷ „”„ÊÕ »Â ÂÊ : [*MAXWIDTH*]px',
    'error_img_height_max' => '√ﬁ’Ï ≈— ›«⁄ „”„ÊÕ »Â ÂÊ : [*MAXHEIGHT*]px',
    'rename_text' => '√œŒ· «·≈”„ «·ÃœÌœ ·‹  "[*FILE*]":',
    'error_rename_file_missing' => '›‘·  «⁄«œ… «· ”„Ì…° ·„ Ì „ «·⁄ÀÊ— ⁄·Ï «·„·›.',
    'error_rename_directories_forbidden' => 'Œÿ√: ≈⁄«œ… «· ”„Ì… €Ì— „”„ÊÕ… ·Â–« «·„Ã·œ.',
    'error_rename_forbidden' => 'Œÿ√: ≈⁄«œ… «· ”„Ì… €Ì— „”„ÊÕ… ·Â–« «·„Ã·œ.',
    'error_rename_file_exists' => 'Œÿ√: "[*FILE*]" „ÊÃÊœ „”»ﬁ«.',
    'error_rename_failed' => 'Œÿ√: ›‘·  «⁄«œ… «· ”„Ì…. ',
    'error_rename_extension_changed' => 'Œÿ√: ·« Ì„ﬂ‰  €ÌÌ— «·«„ «œ!',
    'newdirectory_text' => '√ﬂ » ≈”„ «·„Ã·œ:',
    'error_create_directories_forbidden' => 'Œÿ√: ·« Ì„ﬂ‰ «·”„«Õ »«‰‘«¡ „Ã·œ',
    'error_create_directories_name_used' => 'Œÿ√: Â–« «·«”„ „ÊÃÊœ „‰ ﬁ»·.',
    'error_create_directories_failed' => '·«Ì„ﬂ‰ «‰‘«¡ «·„Ã·œ° ·« ÌÊÃœ ’·«ÕÌ« .',
    'error_create_directories_name_invalid' => '·« Ì„ﬂ‰ «” Œœ«„ «·Õ—› «· «·Ì… ›Ì «·«”„: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Â·  —Ìœ Õ–› «·„Ã·œ:  "[*DIR*]"?',
    'error_delete_subdirectories_forbidden' => '·«Ì„ﬂ‰ Õ–› Â–« «·„Ã·œ.',
    'error_delete_subdirectories_failed' => '·« Ì„ﬂ‰ Õ–› «·„Ã·œ. —»„« ·Ì” ·œÌﬂ ’·«ÕÌ«  ·⁄„· –·ﬂ.',
    'error_delete_subdirectories_not_empty' => '«·„Ã·œ €Ì— ›«—€.',
  ),
  'buttons' => array(
    'ok'        => '  „Ê«›ﬁ  ',
    'cancel'    => '≈·€«¡',
    'view_list' => '‰Ÿ«„ «·⁄—÷: ﬁ«∆„…',
    'view_details' => '‰Ÿ«„ «·⁄—÷:  ›«’Ì·',
    'view_thumbs' => '‰Ÿ«„ «·⁄—÷: „’€—« ',
    'rename'    => '≈⁄«œ…  ”„Ì… ... ',
    'delete'    => 'Õ–›',
    'go_up'     => '·√⁄·Ï',
    'upload'    =>  '≈›⁄ «·„·›',
    'create_directory'  =>  '≈‰‘«¡ „Ã·œ',
  ),
  'file_details' => array(
    'name'  =>  '«”„',
    'type'  =>  '‰Ê⁄',
    'size'  =>  'ÕÃ„',
    'date'  =>  ' «—ÌŒ «· ⁄œÌ·',
    'filetype_suffix'  =>  '„·›',
    'img_dimensions'  =>  '«·√»⁄«œ',
    'file_folder'  =>  '„·› „Ã·œ',
  ),
  'filetypes' => array(
    'any'       => 'Ã„Ì⁄ «·„·›«  (*.*)',
    'images'    => '’Ê—',
    'flash'     => '›·«‘',
    'documents' => 'ÊÀ«∆ﬁ',
    'audio'     => '’Ê ',
    'video'     => '›œÌœÊ',
    'archives'  => '√—‘Ì›',
    '.jpg'  =>  '’Ê—… JPG ',
    '.jpeg'  =>  '’Ê—… JPG ',
    '.gif'  =>  '’Ê—… GIF ',
    '.png'  =>  '’Ê—… PNG ',
    '.swf'  =>  '›·„ ›·«‘ Flash movie',
    '.doc'  =>  'ÊÀÌﬁ… Microsoft Word',
    '.xls'  =>  '≈ﬂ”· Microsoft Excel ',
    '.pdf'  =>  '√œÊ»Ì PDF document',
    '.rtf'  =>  'ÊÀÌﬁ… RTF document',
    '.odt'  =>  '‰’Ì OpenDocument Text',
    '.ods'  =>  '‘Ì  OpenDocument Spreadsheet',
    '.sxw'  =>  '‰’Ì 1 OpenOffice.org 1.0 Text Document',
    '.sxc'  =>  '‘Ì 1  OpenOffice.org 1.0 Spreadsheet',
    '.wav'  =>  '’Ê  WAV audio file',
    '.mp3'  =>  '’Ê  MP3 audio file',
    '.ogg'  =>  '’Ê  Ogg Vorbis audio file',
    '.wma'  =>  '’Ê  Windows audio file',
    '.avi'  =>  '›œÌÊ AVI video file',
    '.mpg'  =>  '›œÌÊ MPEG video file',
    '.mpeg'  =>  '›œÌÊ MPEG video file',
    '.mov'  =>  '›œÌÊ QuickTime video file',
    '.wmv'  =>  '›œÌÊ Windows video file',
    '.zip'  =>  '„÷€Êÿ ZIP archive',
    '.rar'  =>  '„÷€Êÿ RAR archive',
    '.gz'  =>  '„÷€Êÿ gzip archive',
    '.txt'  =>  '‰’Ì Text Document',
    ''  =>  '',
  ),
);
?>
