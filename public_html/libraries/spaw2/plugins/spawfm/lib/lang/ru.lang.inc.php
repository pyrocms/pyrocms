<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
// Russian language file
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
    'title' => 'SPAW Мэнеджер файлов',
    'error_reading_dir' => 'Ошибка при считывании каталога.',
    'error_upload_forbidden' => 'Ошибка: в этом каталоге загрузка файлов запрещена.',
    'error_upload_file_too_big' => 'Загрузка прекращена: файл слишком большой.',
    'error_upload_failed' => 'Ошибка при загрузке.',
    'error_upload_file_incomplete' => 'Загружен неполный файл, повторите.',
    'error_bad_filetype' => 'Ошибка: файлы этого типа не принимаются.',
    'error_max_filesize' => 'Максимальный размер файлов:',
    'error_delete_forbidden' => 'Ошибка: в этом каталоге удалять файлы запрещено.',
    'confirm_delete' => 'Вы уверенны, что хотите удалить файл "[*file*]"?',
    'error_delete_failed' => 'Ошибка: удалить файл не удалось, возможно на это не хватает прав.',
    'error_no_directory_available' => 'Нет каталогов для просмотра.',
    'download_file' => '[скачать файл]',
    'error_chmod_uploaded_file' => 'Загрузка файла успешна, но не удалось поменять его права.',
    'error_img_width_max' => 'Максимальная допустимая ширина изображения: [*MAXWIDTH*]px',
    'error_img_height_max' => 'Максимальная допустимая высота изображения: [*MAXHEIGHT*]px',
    'rename_text' => 'Введите новое имя для "[*FILE*]":',
    'error_rename_file_missing' => 'Переименовать не удалось - файл не найден.',
    'error_rename_directories_forbidden' => 'Ошибка: в этом каталоге переименовывать каталоги запрещено.',
    'error_rename_forbidden' => 'Ошибка: в этом каталоге переименовывать файлы запрещено.',
    'error_rename_file_exists' => 'Ошибка: "[*FILE*]" уже существует.',
    'error_rename_failed' => 'Ошибка: переименовать не удалось, возможно на это не хватает прав.',
    'error_rename_extension_changed' => 'Ошибка: менять расширение запрещено!',
    'newdirectory_text' => 'Введите имя каталога:',
    'error_create_directories_forbidden' => 'Ошибка: создавать каталоги запрещено',
    'error_create_directories_name_used' => 'Это имя уже есть, выберите другое.',
    'error_create_directories_failed' => 'Ошибка: создать каталог не удалось, возможно на это не хватает прав.',
    'error_create_directories_name_invalid' => 'Эти символы использовать в названии нельзя: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Вы уверены, что хотите удалить каталог "[*DIR*]"?',
    'error_delete_subdirectories_forbidden' => 'Ошибка: удалять каталоги запрещено.',
    'error_delete_subdirectories_failed' => 'Ошибка при удалении каталога, возможно на это не хватает прав.',
    'error_delete_subdirectories_not_empty' => 'Каталог не пустой.',
  ),
  'buttons' => array(
    'ok'        => 'ГОТОВО',
    'cancel'    => 'Отменить',
    'view_list' => 'Показывать список',
    'view_details' => 'Показывать детальный список',
    'view_thumbs' => 'Показывать иконы',
    'rename'    => 'Переименовать...',
    'delete'    => 'Удалить',
    'go_up'     => 'Вверх',
    'upload'    =>  'Загрузить',
    'create_directory'  =>  'Создать каталог...',
  ),
  'file_details' => array(
    'name'  =>  'Название',
    'type'  =>  'Тип',
    'size'  =>  'Величина',
    'date'  =>  'Дата обновления',
    'filetype_suffix'  =>  'файл',
    'img_dimensions'  =>  'Размеры',
    'file_folder'  =>  'Каталог',
  ),
  'filetypes' => array(
    'any'       => 'Все файлы (*.*)',
    'images'    => 'Илюстрации',
    'flash'     => 'Flash файлы',
    'documents' => 'Документы',
    'audio'     => 'Аудио файлы',
    'video'     => 'Видео файлы',
    'archives'  => 'Архивные файлы',
    '.jpg'  =>  'JPG файл',
    '.jpeg' =>  'JPG файл',
    '.gif'  =>  'GIF файл',
    '.png'  =>  'PNG файл',
    '.swf'  =>  'Flash файл',
    '.doc'  =>  'Документ Microsoft Word',
    '.xls'  =>  'Документ Microsoft Excel',
    '.pdf'  =>  'PDF документ',
    '.rtf'  =>  'RTF документ',
    '.odt'  =>  'Документ OpenDocument Text',
    '.ods'  =>  'Документ OpenDocument Spreadsheet',
    '.sxw'  =>  'Документ OpenOffice.org 1.0 Text',
    '.sxc'  =>  'Документ OpenOffice.org 1.0 Spreadsheet',
    '.wav'  =>  'WAV аудио файл',
    '.mp3'  =>  'MP3 аудио файл',
    '.ogg'  =>  'Ogg Vorbis аудио файл',
    '.wma'  =>  'Windows аудио файл',
    '.avi'  =>  'AVI видео файл',
    '.mpg'  =>  'MPEG видео файл',
    '.mpeg' =>  'MPEG видео файл',
    '.mov'  =>  'QuickTime видео файл',
    '.wmv'  =>  'Windows видео файл',
    '.zip'  =>  'ZIP архив',
    '.rar'  =>  'RAR архив',
    '.gz'   =>  'gzip архив',
    '.txt'  =>  'Текстовый документ',
  ),
);
?>