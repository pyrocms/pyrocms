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
    'title' => 'SPAW File Manager',
    'error_reading_dir' => 'Error: cannot read directory contents.',
    'error_upload_forbidden' => 'Error: file upload is not allowed in this directory.',
    'error_upload_file_too_big' => 'Upload failed: file too big.',
    'error_upload_failed' => 'File upload failed.',
    'error_upload_file_incomplete' => 'Uploaded file is incomplete, try again.',
    'error_bad_filetype' => 'Error: files of this type are not allowed.',
    'error_max_filesize' => 'Max upload file size accepted:',
    'error_delete_forbidden' => 'Error: deleting files is not allowed in this directory.',
    'confirm_delete' => 'Are you sure you want to delete file "[*file*]"?',
    'error_delete_failed' => 'Error: file could not be deleted. You may not have permissions required.',
    'error_no_directory_available' => 'No directories available for browsing.',
    'download_file' => '[download file]',
    'error_chmod_uploaded_file' => 'File upload successful, but chmod\'ing the file failed.',
    'error_img_width_max' => 'Maximum image width allowed: [*MAXWIDTH*]px',
    'error_img_height_max' => 'Maximum image height allowed: [*MAXHEIGHT*]px',
    'rename_text' => 'Enter the new name for "[*FILE*]":',
    'error_rename_file_missing' => 'Rename failed - file could not be found.',
    'error_rename_directories_forbidden' => 'Error: renaming directories is not allowed in this directory.',
    'error_rename_forbidden' => 'Error: renaming files is not allowed in this directory.',
    'error_rename_file_exists' => 'Error: "[*FILE*]" already exists.',
    'error_rename_failed' => 'Error: rename failed. You may not have permissions required.',
    'error_rename_extension_changed' => 'Error: file extension is not allowed to be changed!',
    'newdirectory_text' => 'Enter the name for the directory:',
    'error_create_directories_forbidden' => 'Error: creating directories is forbidden',
    'error_create_directories_name_used' => 'This name is already used, please try another.',
    'error_create_directories_failed' => 'Error: directory could not be created. You may not have permissions required.',
    'error_create_directories_name_invalid' => 'These characters cannot be used in a directory name: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Are you sure you want to delete directory "[*DIR*]"?',
    'error_delete_subdirectories_forbidden' => 'Deleting directories is forbidden.',
    'error_delete_subdirectories_failed' => 'Directory could not be deleted. You may not have permissions required.',
    'error_delete_subdirectories_not_empty' => 'Directory is not empty.',
  ),
  'buttons' => array(
    'ok'        => '  OK  ',
    'cancel'    => 'Cancel',
    'view_list' => 'View mode: list',
    'view_details' => 'View mode: details',
    'view_thumbs' => 'View mode: thumbnails',
    'rename'    => 'Rename...',
    'delete'    => 'Delete',
    'go_up'     => 'Up',
    'upload'    =>  'Upload',
    'create_directory'  =>  'New directory...',
  ),
  'file_details' => array(
    'name'  =>  'Name',
    'type'  =>  'Type',
    'size'  =>  'Size',
    'date'  =>  'Date Modified',
    'filetype_suffix'  =>  'file',
    'img_dimensions'  =>  'Dimensions',
    'file_folder'  =>  'File Folder',
  ),
  'filetypes' => array(
    'any'       => 'All files (*.*)',
    'images'    => 'Image files',
    'flash'     => 'Flash movies',
    'documents' => 'Documents',
    'audio'     => 'Audio files',
    'video'     => 'Video files',
    'archives'  => 'Archive files',
    '.jpg'  =>  'JPG image file',
    '.jpeg'  =>  'JPG image file',
    '.gif'  =>  'GIF image file',
    '.png'  =>  'PNG image file',
    '.swf'  =>  'Flash movie',
    '.doc'  =>  'Microsoft Word document',
    '.xls'  =>  'Microsoft Excel document',
    '.pdf'  =>  'PDF document',
    '.rtf'  =>  'RTF document',
    '.odt'  =>  'OpenDocument Text',
    '.ods'  =>  'OpenDocument Spreadsheet',
    '.sxw'  =>  'OpenOffice.org 1.0 Text Document',
    '.sxc'  =>  'OpenOffice.org 1.0 Spreadsheet',
    '.wav'  =>  'WAV audio file',
    '.mp3'  =>  'MP3 audio file',
    '.ogg'  =>  'Ogg Vorbis audio file',
    '.wma'  =>  'Windows audio file',
    '.avi'  =>  'AVI video file',
    '.mpg'  =>  'MPEG video file',
    '.mpeg'  =>  'MPEG video file',
    '.mov'  =>  'QuickTime video file',
    '.wmv'  =>  'Windows video file',
    '.zip'  =>  'ZIP archive',
    '.rar'  =>  'RAR archive',
    '.gz'  =>  'gzip archive',
    '.txt'  =>  'Text Document',
    ''  =>  '',
  ),
);
?>