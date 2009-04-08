<?php
// ================================================
// SPAW File Manager plugin
// ================================================
// English language file
// ================================================
// Developed: Saulius Okunevicius, saulius@solmetra.com
// Copyright: Solmetra (c)2006 All rights reserved.
// Translator: Stoyan Dimitrov, stoyanster@gmail.com, 04.12.2007
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

$spaw_lang_data = array (
	'spawfm' => array (
		'title' => 'SPAW Файлов Манипулатор',
		'error_reading_dir' => 'Грешка: невъзможно четенето от папката.',
		'error_upload_forbidden' => 'Грешка: Изпращането на файлове към тази папка забранено.',
		'error_upload_file_too_big' => 'Изпращането неуспешно: неприемливо дълъг файл.',
		'error_upload_failed' => 'Изпращането неуспешно.',
		'error_upload_file_incomplete' => 'Изпратеният файл е непълен, пробвайте отново!',
		'error_bad_filetype' => 'Грешка: файлове от този тип са неприемливи.',
		'error_max_filesize' => 'Максималната допустима дължина на файл е ',
		'error_delete_forbidden' => 'Грешка: изтриването на файлове от папката забранено!',
		'confirm_delete' => 'Потвърдете изтриването на файл "[*file*]"!',
		'error_delete_failed' => 'Грешка: файлът не може да бъде изтрит. Вероятно нямате необходимите права.',
		'error_no_directory_available' => '[няма налични папки]',
		'download_file' => '[изтегляне]',
		'error_chmod_uploaded_file' => 'Изпращането на файла бе успешно, но смяната на правата му не.',
		'error_img_width_max' => 'Максималната позволена ширина на изображение е : [*MAXWIDTH*]px',
		'error_img_height_max' => 'Максималната позволена височниа на изображение е [*MAXHEIGHT*]px',
		'rename_text' => 'Въведете ново име за "[*FILE*]":',
		'error_rename_file_missing' => 'Преименуването неуспешно - файлът не бе намерен.',
		'error_rename_directories_forbidden' => 'Грешка: преименуването на папки забранено в тази директория.',
		'error_rename_forbidden' => 'Грешка: преименуването на файлове забранено в тази директория.',
		'error_rename_file_exists' => 'Грешка: "[*FILE*]" вече съществува.',
		'error_rename_failed' => 'Грешка: Преименуването неуспешно. Вероятно нямате необходимите права.',
		'error_rename_extension_changed' => 'Грешка: забранена подмяната на файловото разширение!',
		'newdirectory_text' => 'Въведете име за папката',
		'error_create_directories_forbidden' => 'Грешка: създаването на папки забраненонамате',
		'error_create_directories_name_used' => 'Папка с това име вече съществува.',
		'error_create_directories_failed' => 'Грешка: създаването на папка неуспешно. Вероятно нямате необходимите права.',
		'error_create_directories_name_invalid' => 'Тези знаци не могат да бъдат използвани за име на папка: / \\ : * ? " < > |',
		'confirmdeletedir_text' => 'Потвърдете изтриването на папка "[*DIR*]"!',
		'error_delete_subdirectories_forbidden' => 'Изтриването на папки забранено.',
		'error_delete_subdirectories_failed' => 'Папката не може да бъде изтрита. Вероятно нямате необходимите права.',
		'error_delete_subdirectories_not_empty' => 'Папката не е празна.'
	),
	'buttons' => array (
		'ok' => '   Да   ',
		'cancel' => 'Отказ',
		'view_list' => 'Преглед: списък',
		'view_details' => 'Преглед: подробен',
		'view_thumbs' => 'Преглед: миниатюри',
		'rename' => 'Преименуване',
		'delete' => 'Изтриване',
		'go_up' => 'Нагоре',
		'upload' => 'Изпращане',
		'create_directory' => 'Нова папка'
	),
	'file_details' => array (
		'name' => 'Наименование',
		'type' => 'Тип',
		'size' => 'Дължина',
		'date' => 'Дата',
		'filetype_suffix' => '',
		'img_dimensions' => 'Размери',
		'file_folder' => 'Папка'
	),
	'filetypes' => array (
		'any' => 'Всички (*.*)',
		'images' => 'Изображения ',
		'flash' => 'Flash ',
		'documents' => 'Документи ',
		'audio' => 'Аудио ',
		'video' => 'Видео ',
		'archives' => 'Архиви ',
		'.jpg' => 'JPG изображение',
		'.jpeg' => 'JPG изображение',
		'.gif' => 'GIF изображение',
		'.png' => 'PNG изображение',
		'.swf' => 'Flash',
		'.doc' => 'Microsoft Word документ',
		'.xls' => 'Microsoft Excel документ',
		'.pdf' => 'PDF документ',
		'.rtf' => 'RTF документ',
		'.odt' => 'OpenDocument Text',
		'.ods' => 'OpenDocument Spreadsheet',
		'.sxw' => 'OpenOffice.org 1.0 Текстов документ',
		'.sxc' => 'OpenOffice.org 1.0 Таблица',
		'.wav' => 'WAV аудио',
		'.mp3' => 'MP3 аудио',
		'.ogg' => 'Ogg Vorbis аудио',
		'.wma' => 'Windows аудио',
		'.avi' => 'AVI видео',
		'.mpg' => 'MPEG видео',
		'.mpeg' => 'MPEG видео',
		'.mov' => 'QuickTime видео',
		'.wmv' => 'Windows видео',
		'.zip' => 'ZIP архив',
		'.rar' => 'RAR архив',
		'.gz' => 'gzip архив',
		'.txt' => 'Текстов документ',
		'' => ''
	),
);
