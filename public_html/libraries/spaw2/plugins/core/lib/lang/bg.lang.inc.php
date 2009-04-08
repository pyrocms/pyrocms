<?php
// ================================================
// SPAW v.2.0
// ================================================
// Bulgarian language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Translated: Atanas Tchobanov, atanas@webdressy.com
// Updated: Stoyan Dimitrov, stoyanster@gmail.com, 04.12.2007
// ------------------------------------------------
//                                 www.solmetra.com
// ================================================
// v.2.0
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array (
	'cut' => array (
		'title' => 'Отрязване'
	),
	'copy' => array (
		'title' => 'Копиране'
	),
	'paste' => array (
		'title' => 'Вмъкване'
	),
	'undo' => array (
		'title' => 'Отмяна'
	),
	'redo' => array (
		'title' => 'Повтаряне'
	),
	'image' => array (
		'title' => 'Изображение'
	),
	'image_prop' => array (
		'title' => 'Параметри изображение',
		'ok' => '   Да   ',
		'cancel' => 'Отказ',
		'source' => 'източник',
		'alt' => 'алт. текст',
		'align' => 'подравняване',
		'left' => 'отляво (left)',
		'right' => 'отдясно (right)',
		'top' => 'горе (top)',
		'middle' => 'центрирано (middle)',
		'bottom' => 'долу (bottom)',
		'absmiddle' => 'абс. център (absmiddle)',
		'texttop' => 'отгоре (texttop)',
		'baseline' => 'отдолу (baseline)',
		'width' => 'ширина',
		'height' => 'височина',
		'border' => 'рамка',
		'hspace' => 'хор. отстъп',
		'vspace' => 'верт. отстъп',
		'dimensions' => 'размери',
		'reset_dimensions' => 'Оригинален размер',
		'title_attr' => 'заглавие',
		'constrain_proportions' => 'пропорционални',
		'error' => 'Грешка',
		'error_width_nan' => 'Ширината трябва да бъде числена стойност',
		'error_height_nan' => 'Височината трябва да бъде числена стойност',
		'error_border_nan' => 'Рамката трябва да бъде числена стойност',
		'error_hspace_nan' => 'Хоризонталният отстъп трябва да бъде числена стойност',
		'error_vspace_nan' => 'Вертикалният отстъп трябва да бъде числена стойност',
	),
	'flash_prop' => array (
		'title' => 'Flash',
		'ok' => '   Да   ',
		'cancel' => 'Отказ',
		'source' => 'източник',
		'width' => 'ширина',
		'height' => 'височина',
		'error' => 'Грешка',
		'error_width_nan' => 'Ширината трябва да бъде числена стойност',
		'error_height_nan' => 'Височината трябва да бъде числена стойност',
	),
	'inserthorizontalrule' => array (
		'title' => 'Хоризонтална линия'
	),
	'table_create' => array (
		'title' => 'Таблица'
	),
	'table_prop' => array (
		'title' => 'Параметри таблица',
		'ok' => '   Да   ',
		'cancel' => 'Отказ',
		'rows' => 'редове',
		'columns' => 'колони',
		'css_class' => 'CSS клас',
		'width' => 'ширина',
		'height' => 'височина',
		'border' => 'рамка',
		'pixels' => 'пикс.',
		'cellpadding' => 'отстъп от рамката',
		'cellspacing' => 'разстояние между клетките',
		'bg_color' => 'цвят фон',
		'background' => 'фоново изображение',
		'error' => 'Грешка',
		'error_rows_nan' => 'Редовете трябва да бъдат числена стойност',
		'error_columns_nan' => 'Колоните трябва да бъдат числена стойност',
		'error_width_nan' => 'Ширината трябва да бъде числена стойност',
		'error_height_nan' => 'Височината трябва да бъде числена стойност',
		'error_border_nan' => 'Рамката трябва да бъде числена стойност',
		'error_cellpadding_nan' => 'Отстъпът от рамката трябва да бъде числена стойност',
		'error_cellspacing_nan' => 'Разстоянието между клетките трябва да бъде числена стойност',
	),
	'table_cell_prop' => array (
		'title' => 'Параметри клетка',
		'horizontal_align' => 'хоризонтално подравняване',
		'vertical_align' => 'вертикално подравняване',
		'width' => 'ширина',
		'height' => 'височина',
		'css_class' => 'CSS клас',
		'no_wrap' => 'без преноси',
		'bg_color' => 'цвят фон',
		'background' => 'фоново изображение',
		'ok' => '   Да   ',
		'cancel' => 'Отказ',
		'left' => 'отляво (left)',
		'center' => 'центрирано (center)',
		'right' =>'отдясно (right)',
		'top' => 'горе (top)',
		'middle' => 'центрирано (middle)',
		'bottom' => 'отдолу (bottom)',
		'baseline' => 'отдолу (baseline)',
		'error' => 'Грешка',
		'error_width_nan' => 'Ширината трябва да бъде числена стойност',
		'error_height_nan' => 'Височината трябва да бъде числена стойност',

	),
	'table_row_insert' => array (
		'title' => 'Вмъкване ред'
	),
	'table_column_insert' => array (
		'title' => 'Вмъкване колона'
	),
	'table_row_delete' => array (
		'title' => 'Премахване ред'
	),
	'table_column_delete' => array (
		'title' => 'Премахване колона'
	),
	'table_cell_merge_right' => array (
		'title' => 'Обединяване надясно'
	),
	'table_cell_merge_down' => array (
		'title' => 'Обединяване надолу'
	),
	'table_cell_split_horizontal' => array (
		'title' => 'Разделяне хоризонтално'
	),
	'table_cell_split_vertical' => array (
		'title' => 'Разделяне вертикално'
	),
	'style' => array (
		'title' => '[стил]'
	),
	'fontname' => array (
		'title' => '[шрифт]'
	),
	'fontsize' => array (
		'title' => '[размер]'
	),
	'formatBlock' => array (
		'title' => '[параграф]'
	),
	'bold' => array (
		'title' => 'Получер текст'
	),
	'italic' => array (
		'title' => 'Курсивен текст'
	),
	'underline' => array (
		'title' => 'Подчертан текст'
	),
	'strikethrough' => array (
		'title' => 'Зачертан текст'
	),
	'insertorderedlist' => array (
		'title' => 'Номериран списък'
	),
	'insertunorderedlist' => array (
		'title' => 'Неподреден списък'
	),
	'indent' => array (
		'title' => 'Увеличаване отстъп'
	),
	'outdent' => array (
		'title' => 'Намаляване отстъп'
	),
	'justifyleft' => array (
		'title' => 'Ляво подравнен'
	),
	'justifycenter' => array (
		'title' => 'Центриран'
	),
	'justifyright' => array (
		'title' => 'Дясно подравнен'
	),
	'justifyfull' => array (
		'title' => 'Подрвнен'
	),
	'fore_color' => array (
		'title' => 'Цвят текст'
	),
	'bg_color' => array (
		'title' => 'Цвят фон'
	),
	'design' => array (
		'title' => 'Превключване в режим на макетиране (WYSIWYG)'
	),
	'html' => array (
		'title' => 'Превключване в режим на редактиране на кода (HTML)'
	),
	'colorpicker' => array (
		'title' => 'Избор цвят',
		'ok' => '   Да   ',
		'cancel' => 'Отказ'
	),
	'cleanup' => array (
		'title' => 'Почистване HTML',
		'confirm' => 'Тази операция премахва всички стилове, шрифтове и ненужни тагове от съдържанието в редактора. Частично или изцяло може да бъде загубено форматирането.',
		'ok' => '   Да   ',
		'cancel' => 'Отказ'
	),
	'toggle_borders' => array (
		'title' => 'Превключване рамки'
	),
	'hyperlink' => array (
		'title' => 'Връзка',
		'url' => 'URL',
		'name' => 'име',
		'target' => 'цел',
		'title_attr' => 'заглавие',
		'a_type' => 'тип',
		'type_link' => 'връзка',
		'type_anchor' => 'котва',
		'type_link2anchor' => 'връзка към котва',
		'anchors' => 'котви',
		'ok' => '   Да   ',
		'cancel' => 'Отказ'
	),
	'hyperlink_targets' => array (
		'_self' => '_self',
		'_blank' => '_blank',
		'_top' => '_top',
		'_parent' => '_parent'
	),
	'unlink' => array (
		'title' => 'Премахване връзка'
	),
	'table_row_prop' => array (
		'title' => 'Параметри ред',
		'horizontal_align' => 'хоризонтално подравняване',
		'vertical_align' => 'вертикално подравняване',
		'css_class' => 'CSS клас',
		'no_wrap' => 'без преноси',
		'bg_color' => 'цвят фон',
		'ok' => '   Да   ',
		'cancel' => 'Отказ',
		'left' => 'отляво (left)',
		'center' => 'центрирано (center)',
		'right' =>'отдясно (right)',
		'top' => 'горе (top)',
		'middle' => 'центрирано (middle)',
		'bottom' => 'отдолу (bottom)',
		'baseline' => 'отдолу (baseline)',
	),
	'symbols' => array (
		'title' => 'Символи',
		'ok' => '   Да   ',
		'cancel' => 'Отказ'
	),
	'templates' => array (
		'title' => 'Графични модели'
	),
	'page_prop' => array (
		'title' => 'Параметри страница',
		'title_tag' => 'заглавие',
		'charset' => 'кодова таблица',
		'background' => 'фоново изображение',
		'bgcolor' => 'цвят фон',
		'text' => 'цвят текст',
		'link' => 'цвят връзка',
		'vlink' => 'цвят посетени връзки',
		'alink' => 'цвят активни връзки',
		'leftmargin' => 'отстъп отляво',
		'topmargin' => 'отстъп отгоре',
		'css_class' => 'CSS клас',
		'ok' => '   Да   ',
		'cancel' => 'Отказ'
	),
	'preview' => array (
		'title' => 'Предварителен преглед'
	),
	'image_popup' => array (
		'title' => 'Popup картинка'
	),
	'zoom' => array (
		'title' => 'Увеличаване'
	),
	'subscript' => array (
		'title' => 'Долен индекс'
	),
	'superscript' => array (
		'title' => 'Горен индекс'
	)
);
