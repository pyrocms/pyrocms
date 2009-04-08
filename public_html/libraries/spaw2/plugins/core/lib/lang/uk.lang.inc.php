<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Russian language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2003-04-10
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Вирізати'
  ),
  'copy' => array(
    'title' => 'Копіювати'
  ),
  'paste' => array(
    'title' => 'Вставити'
  ),
  'undo' => array(
    'title' => 'Відмінити'
  ),
  'redo' => array(
    'title' => 'Повторити'
  ),
  'image_insert' => array(
    'title' => 'Вставити зображення',
    'select' => 'Вставити',
	'delete' => 'Стерти', // new 1.0.5
    'cancel' => 'Відмінити',
    'library' => 'Бібліотека',
    'preview' => 'Перегляд',
    'images' => 'Зображення',
    'upload' => 'Завантажити зображення',
    'upload_button' => 'Завантажити',
    'error' => 'Помилка',
    'error_no_image' => 'Виберіть зображення',
    'error_uploading' => 'Під час завантаження виникла помилка. Спробуйте ще раз.',
    'error_wrong_type' => 'Невірний тип зображення',
    'error_no_dir' => 'Бібліотека не існує',
	'error_cant_delete' => 'Стерти не вдалося', // new 1.0.5
  ),
  'image_prop' => array(
    'title' => 'Параметри зображення',
    'ok' => 'ГОТОВО',
    'cancel' => 'Відмінити',
    'source' => 'Джерело',
    'alt' => 'Короткий опис',
    'align' => 'Вирівнювання',
    'justifyleft' => 'зліва (left)',
    'justifyright' => 'справа (right)',
    'top' => 'зверху (top)',
    'middle' => 'в центрі (middle)',
    'bottom' => 'знизу (bottom)',
    'absmiddle' => 'абс. центр (absmiddle)',
    'texttop' => 'зверху (texttop)',
    'baseline' => 'знизу (baseline)',
    'width' => 'Ширина',
    'height' => 'Висота',
    'border' => 'Рамка',
    'hspace' => 'Гор. поля',
    'vspace' => 'Верт. поля',
    'error' => 'Помилка',
    'error_width_nan' => 'Ширина не є числом',
    'error_height_nan' => 'Висота не є числом',
    'error_border_nan' => 'Рамка не є числом',
    'error_hspace_nan' => 'Горизонтальні поля не є числом',
    'error_vspace_nan' => 'Вертикальні поля не є числом',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Горизонтальна лінія'
  ),
  'table_create' => array(
    'title' => 'Створити таблицю'
  ),
  'table_prop' => array(
    'title' => 'Параметри таблиці',
    'ok' => 'ГОТОВО',
    'cancel' => 'Відмінити',
    'rows' => 'Рядки',
    'columns' => 'Стовпці',
    'css_class' => 'Стиль', // <=== new 1.0.6
    'width' => 'Ширина',
    'height' => 'Висота',
    'border' => 'Рамка',
    'pixels' => 'пікс.',
    'cellpadding' => 'Відступ від рамки',
    'cellspacing' => 'Відстань між комірками',
    'bg_color' => 'Колір фону',
    'background' => 'Фонове зображення', // <=== new 1.0.6
    'error' => 'Помилка',
    'error_rows_nan' => 'Рядки не є числом',
    'error_columns_nan' => 'Стовпці не є числом',
    'error_width_nan' => 'Ширина не є числом',
    'error_height_nan' => 'Висота не є числом',
    'error_border_nan' => 'Рамка не є числом',
    'error_cellpadding_nan' => 'Відступ від рамки не є числом',
    'error_cellspacing_nan' => 'Відстань між комірками не є числом',
  ),
  'table_cell_prop' => array(
    'title' => 'Параметри комірки',
    'horizontal_align' => 'Горизонтальне вирівнювання',
    'vertical_align' => 'Вертикальне вирівнювання',
    'width' => 'Ширина',
    'height' => 'Висота',
    'css_class' => 'Стиль',
    'no_wrap' => 'Без переносу',
    'bg_color' => 'Колір фону',
    'background' => 'Фонове зображення', // <=== new 1.0.6
    'ok' => 'ГОТОВО',
    'cancel' => 'Відмінити',
    'justifyleft' => 'Зліва',
    'justifycenter' => 'В центрі',
    'justifyright' => 'Справа',
    'top' => 'Зверху',
    'middle' => 'В центрі',
    'bottom' => 'Знизу',
    'baseline' => 'Базова лінія тексту',
    'error' => 'Помилка',
    'error_width_nan' => 'Ширина не є числом',
    'error_height_nan' => 'Висота не є числом',
  ),
  'table_row_insert' => array(
    'title' => 'Вставити рядок'
  ),
  'table_column_insert' => array(
    'title' => 'Вставити стовчик'
  ),
  'table_row_delete' => array(
    'title' => 'Вилучити рядок'
  ),
  'table_column_delete' => array(
    'title' => 'Вилучити стовпчик'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Об\'єднати вправо'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Об\'єднати вліво'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Розділити по горизонталі'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Розділити по вертикалі'
  ),
  'style' => array(
    'title' => 'Стиль'
  ),
  'fontname' => array(
    'title' => 'Шрифт'
  ),
  'fontsize' => array(
    'title' => 'Розмір'
  ),
  'formatBlock' => array(
    'title' => 'Абзац'
  ),
  'bold' => array(
    'title' => 'Жирний'
  ),
  'italic' => array(
    'title' => 'Курсив'
  ),
  'underline' => array(
    'title' => 'Підкреслений'
  ),
  'insertorderedlist' => array(
    'title' => 'Впорядкований список'
  ),
  'insertunorderedlist' => array(
    'title' => 'Невпорядкований список'
  ),
  'indent' => array(
    'title' => 'Збільшити відступ'
  ),
  'outdent' => array(
    'title' => 'Зменшити відступ'
  ),
  'justifyleft' => array(
    'title' => 'Вирівнювання зліва'
  ),
  'justifycenter' => array(
    'title' => 'Вирівнювання по центру'
  ),
  'justifyright' => array(
    'title' => 'Вирівнювання справа'
  ),
  'fore_color' => array(
    'title' => 'Колір тексту'
  ),
  'bg_color' => array(
    'title' => 'Колір фону'
  ),
  'design' => array(
    'title' => 'Переключитися в режим макетування (WYSIWYG)'
  ),
  'html' => array(
    'title' => 'Переключитися в режим редагування коду (HTML)'
  ),
  'colorpicker' => array(
    'title' => 'Вибір кольору',
    'ok' => 'ГОТОВО',
    'cancel' => 'Відмінити',
  ),
  'cleanup' => array(
    'title' => 'Чистка HTML',
    'confirm' => 'Ця операція прибере всі стилі, шрифти і непотрібні теги з поточного наповнення редактора. Цілком або частково ваше форматування може бути втрачено.',
    'ok' => 'ГОТОВО',
    'cancel' => 'Відмінити',
  ),
  'toggle_borders' => array(
    'title' => 'Включити рамки',
  ),
  'hyperlink' => array(
    'title' => 'Лінк',
    'url' => 'Адреса',
    'name' => 'Им\'я',
    'target' => 'Відкрити',
    'title_attr' => 'Назва',
	'a_type' => 'Тип', // <=== new 1.0.6
	'type_link' => 'Посилання', // <=== new 1.0.6
	'type_anchor' => 'Якір', // <=== new 1.0.6
	'type_link2anchor' => 'Посилання на якір', // <=== new 1.0.6
	'anchors' => 'Якорі', // <=== new 1.0.6
    'ok' => 'ГОТОВО',
    'cancel' => 'Відмінити',
  ),
  'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => 'в тому ж фреймі (_self)',
	'_blank' => 'в новому вікні(_blank)',
	'_top' => 'на все вікно (_top)',
	'_parent' => 'в батьківському фреймі (_parent)'
  ),
  'table_row_prop' => array(
    'title' => 'Параметри рядка',
    'horizontal_align' => 'Горизонтальне вирівнювання',
    'vertical_align' => 'Вертикальне вирівнювання',
    'css_class' => 'Стиль',
    'no_wrap' => 'Без переносу',
    'bg_color' => 'Колір фону',
    'ok' => 'ГОТОВО',
    'cancel' => 'Відмінити',
    'justifyleft' => 'Злева',
    'justifycenter' => 'В центрі',
    'justifyright' => 'Справа',
    'top' => 'Зверху',
    'middle' => 'В центрі',
    'bottom' => 'Знизу',
    'baseline' => 'Базова лінія тексту',
  ),
  'symbols' => array(
    'title' => 'Спец. символи',
    'ok' => 'ГОТОВО',
    'cancel' => 'Відмінити',
  ),
  'templates' => array(
    'title' => 'Шаблони',
  ),
  'page_prop' => array(
    'title' => 'Параметри сторінки',
    'title_tag' => 'Заголовок',
    'charset' => 'Кодування',
    'background' => 'Фонове зображення',
    'bgcolor' => 'Колір фону',
    'text' => 'Колір тексту',
    'link' => 'Колір лінків',
    'vlink' => 'Колір відвіданих лінків',
    'alink' => 'Колір активних лінків',
    'leftmargin' => 'Відступ злева',
    'topmargin' => 'Відступ зверху',
    'css_class' => 'Стиль',
    'ok' => 'ГОТОВО',
    'cancel' => 'Відмінити',
  ),
  'preview' => array(
    'title' => 'Попередній перегляд',
  ),
  'image_popup' => array(
    'title' => 'Popup зображення',
  ),
  'zoom' => array(
    'title' => 'Збільшення',
  ),
  'subscript' => array( // <=== new 1.0.7
    'title' => 'Нижній індекс',
  ),
  'superscript' => array( // <=== new 1.0.7
    'title' => 'Верхній індекс',
  ),
);
?>