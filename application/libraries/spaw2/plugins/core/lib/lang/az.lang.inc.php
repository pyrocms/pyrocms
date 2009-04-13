<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Azerbaijani language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Translated: Shamil Mehdiyev, supervisor@box.az 
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2003-03-20
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Kəs'
  ),
  'copy' => array(
    'title' => 'Kopyala'
  ),
  'paste' => array(
    'title' => 'Yapışdır'
  ),
  'undo' => array(
    'title' => 'Geri al'
  ),
  'redo' => array(
    'title' => 'Təkrarla'
  ),
  'image_insert' => array(
    'title' => 'Şəkil əlavə et',
    'select' => 'Seç',
	'delete' => 'Sil', // new 1.0.5
    'cancel' => 'Ləğv et',
    'library' => 'Kitabxana',
    'preview' => 'Görünüş',
    'images' => 'Şəkillər',
    'upload' => 'Şəkil yüklə',
    'upload_button' => 'Yüklə',
    'error' => 'Xəta',
    'error_no_image' => 'Şəkil seçin',
    'error_uploading' => 'Faylın yüklənməsi zamanı xəta baş verdi. Zəhmət olmasa bir az sonra təkrar yoxlayın',
    'error_wrong_type' => 'Düzgun olmayan şəkil formatı',
    'error_no_dir' => 'Kitabxana fiziki olaraq mövcud deyil',
	'error_cant_delete' => 'Silmə müvəffəqiyyətsiz oldu', // new 1.0.5
  ),
  'image_prop' => array(
    'title' => 'Şəkil xüsusiyyətləri',
    'ok' => '   OK   ',
    'cancel' => 'Ləğv et',
    'source' => 'Mənbə',
    'alt' => 'Alternativ mətn',
    'align' => 'Yerləşmə',
    'justifyleft' => 'sol',
    'justifyright' => 'sağ',
    'top' => 'üst',
    'middle' => 'orta',
    'bottom' => 'alt',
    'absmiddle' => 'tən orta',
    'texttop' => 'mətn yuxarıda',
    'baseline' => 'altxətt',
    'width' => 'Uzunluq',
    'height' => 'Hündürlük',
    'border' => 'Sərhəd',
    'hspace' => 'Hor. boşluq',
    'vspace' => 'Şaq. boşluq',
    'error' => 'Xəta',
    'error_width_nan' => 'Uzunluq rəqəm deyil',
    'error_height_nan' => 'Hündürlük rəqəm deyil',
    'error_border_nan' => 'Sərhəd rəqəm deyil',
    'error_hspace_nan' => 'Horizontal boşluq rəqəm deyil',
    'error_vspace_nan' => 'Şaquli boşluq rəqəm deyil',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Horizontal xətt'
  ),
  'table_create' => array(
    'title' => 'Cədvəl düzəlt'
  ),
  'table_prop' => array(
    'title' => 'Cədvəl xüsusiyyətləri',
    'ok' => '   OK   ',
    'cancel' => 'Ləğv et',
    'rows' => 'Sətir',
    'columns' => 'Sütun',
    'css_class' => 'CSS sinifi', // <=== new 1.0.6
    'width' => 'Uzunluq',
    'height' => 'Hündürlük',
    'border' => 'Sərhəd',
    'pixels' => 'piksel',
    'cellpadding' => 'Hüceyrədən uzaqlıq',
    'cellspacing' => 'Hüceyrə uzaqlığı',
    'bg_color' => 'Arxa fon rəngi',
    'background' => 'Arxa fon şəkli', // <=== new 1.0.6
    'error' => 'Xəta',
    'error_rows_nan' => 'Sətir rəqəm deyil',
    'error_columns_nan' => 'Sütun rəqəm deyil',
    'error_width_nan' => 'Uzunluq rəqəm deyil',
    'error_height_nan' => 'Hündürlük rəqəm deyil',
    'error_border_nan' => 'Sərhəd rəqəm deyil',
    'error_cellpadding_nan' => 'Hüceyrədən uzaqlıq rəqəm deyil',
    'error_cellspacing_nan' => 'Hüceyrə uzaqlığı rəqəm deyil',
  ),
  'table_cell_prop' => array(
    'title' => 'Hüceyrə xüsusiyyətləri',
    'horizontal_align' => 'Horizontal yerləşmə',
    'vertical_align' => 'Şaquli yerləşmə',
    'width' => 'Uzunluq',
    'height' => 'Hündürlük',
    'css_class' => 'CSS sinifi',
    'no_wrap' => 'Yığılma olmasın',
    'bg_color' => 'Arxa fon rəngi',
    'background' => 'Arxa fon şəkli', // <=== new 1.0.6
    'ok' => '   OK   ',
    'cancel' => 'Ləğv et',
    'justifyleft' => 'Sol',
    'justifycenter' => 'Mərkəz',
    'justifyright' => 'Sağ',
    'top' => 'Üst',
    'middle' => 'Orta',
    'bottom' => 'Alt',
    'baseline' => 'Altxətt',
    'error' => 'Xəta',
    'error_width_nan' => 'Uzunluq rəqəm deyil',
    'error_height_nan' => 'Hündürlük rəqəm deyil',
  ),
  'table_row_insert' => array(
    'title' => 'Sətir əlavə et'
  ),
  'table_column_insert' => array(
    'title' => 'Sütun əlavə et'
  ),
  'table_row_delete' => array(
    'title' => 'Sətir sil'
  ),
  'table_column_delete' => array(
    'title' => 'Sütun sil'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Sağla birləşmə'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Aşağıyla birləşmə'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Hüceyrəni horizontal böl'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Hüceyrəni şaquli böl'
  ),
  'style' => array(
    'title' => 'Stil'
  ),
  'codesnippet' => array(
    'title' => 'Şablon'
  ),
  'fontname' => array(
    'title' => 'Font'
  ),
  'fontsize' => array(
    'title' => 'Ölçü'
  ),
  'formatBlock' => array(
    'title' => 'Paraqraf'
  ),
  'bold' => array(
    'title' => 'Qalın'
  ),
  'italic' => array(
    'title' => 'Əyri'
  ),
  'underline' => array(
    'title' => 'Altxətli'
  ),
  'insertorderedlist' => array(
    'title' => 'Nömrəli siyahı'
  ),
  'insertunorderedlist' => array(
    'title' => 'Muncuqlu siyahı'
  ),
  'indent' => array(
    'title' => 'Abzas əlavə et'
  ),
  'outdent' => array(
    'title' => 'Abzas sil'
  ),
  'justifyleft' => array(
    'title' => 'Sol'
  ),
  'justifycenter' => array(
    'title' => 'Mərkəz'
  ),
  'justifyright' => array(
    'title' => 'Sağ'
  ),
  'fore_color' => array(
    'title' => 'Yazı rəngi'
  ),
  'bg_color' => array(
    'title' => 'Arxa plan rəngi'
  ),
  'design' => array(
    'title' => 'WYSIWYG (dizayn) moduna keçin'
  ),
  'html' => array(
    'title' => 'HTML (kod) moduna keçin'
  ),
  'colorpicker' => array(
    'title' => 'Rəng seçən',
    'ok' => '   OK   ',
    'cancel' => 'Ləğv et',
  ),
  'cleanup' => array(
    'title' => 'HTML təmizləməsi (stilləri sil)',
    'confirm' => 'Bu əməliyyat icra edilərsə cari məzmundakı bütün stillər, fontlar və tag-lər silinəcəkdir. Formatlaşdırmanızın bir qismi və ya hamısı silinə bilər.',
    'ok' => '   OK   ',
    'cancel' => 'Ləğv et',
  ),
  'toggle_borders' => array(
    'title' => 'Sərhədləri dəyiş',
  ),
  'hyperlink' => array(
    'title' => 'Hiperlink',
    'url' => 'URL',
    'name' => 'Ad',
    'target' => 'Hədəf',
    'title_attr' => 'Başlıq',
	'a_type' => 'Tip', // <=== new 1.0.6
	'type_link' => 'Link', // <=== new 1.0.6
	'type_anchor' => 'Lövbər', // <=== new 1.0.6
	'type_link2anchor' => 'Lövbərə link', // <=== new 1.0.6
	'anchors' => 'Lövbərlər', // <=== new 1.0.6
    'ok' => '   OK   ',
    'cancel' => 'Ləğv et',
  ),
  'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => 'eyni çərçivə (_self)',
	'_blank' => 'yeni boş pəncərə (_blank)',
	'_top' => 'yuxarı çərçivə(_top)',
	'_parent' => 'valideyn çərçivə (_parent)'
  ),
  'table_row_prop' => array(
    'title' => 'Sətir xüsusiyyətləri',
    'horizontal_align' => 'Horizontal yerləşmə',
    'vertical_align' => 'Şaquli yerləşmə',
    'css_class' => 'CSS sinifi',
    'no_wrap' => 'Yığılma olasın',
    'bg_color' => 'Arxa fon rəngi',
    'ok' => '   OK   ',
    'cancel' => 'Ləğv et',
    'justifyleft' => 'Sol',
    'justifycenter' => 'Mərkəz',
    'justifyright' => 'Sağ',
    'top' => 'Üst',
    'middle' => 'Orta',
    'bottom' => 'Alt',
    'baseline' => 'Altxətt',
  ),
  'symbols' => array(
    'title' => 'Xüsusi simvollar',
    'ok' => '   OK   ',
    'cancel' => 'Ləğv et',
  ),
  'templates' => array(
    'title' => 'Şablonlar',
  ),
  'page_prop' => array(
    'title' => 'Səhifə xüsusiyyətləri',
    'title_tag' => 'Başlıq',
    'charset' => 'Charset',
    'background' => 'Arxa fon şəkli',
    'bgcolor' => 'Arxa fon rəngi',
    'text' => 'Məzmun rəngi',
    'link' => 'Link rəngi',
    'vlink' => 'Açılmış linkin rəngi',
    'alink' => 'Aktiv linkin rəngi',
    'leftmargin' => 'Sol boşluq',
    'topmargin' => 'Yuxarı boşluq',
    'css_class' => 'CSS sinifi',
    'ok' => '   OK   ',
    'cancel' => 'Ləğv et',
  ),
  'preview' => array(
    'title' => 'Görünüş',
  ),
  'image_popup' => array(
    'title' => 'Şəkil (popup)',
  ),
  'zoom' => array(
    'title' => 'Böyüt',
  ),
  'subscript' => array( // <=== new 1.0.7
    'title' => 'Altyazı',
  ),
  'superscript' => array( // <=== new 1.0.7
    'title' => 'Üstyazı',
  ),
);
?>