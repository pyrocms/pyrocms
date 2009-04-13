<?php
// =========================================================
// SPAW PHP WYSIWYG editor control
// =========================================================
// Turkish language file
// =========================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Turkish translation: Zeki Erkmen, zerkmen@erdoweb.com
// Copyright: Solmetra (c)2003 All rights reserved.
// ---------------------------------------------------------
//                                www.solmetra.com
// =========================================================
// 1.0.7, 2004-12-09
// =========================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Kes'
  ),
  'copy' => array(
    'title' => 'Kopyala'
  ),
  'paste' => array(
    'title' => 'Ekle'
  ),
  'undo' => array(
    'title' => 'Geri al'
  ),
  'redo' => array(
    'title' => 'Tekrarla'
  ),
  'hyperlink' => array(
    'title' => 'Link ekle'
  ),
  'image_insert' => array(
    'title' => 'Resim ekle',
    'select' => 'Resmi al',
	'delete' => 'Resmi sil', // new 1.0.5
    'cancel' => 'İptal',
    'library' => 'Kütüphane',
    'preview' => 'Ön izle',
    'images' => 'Resim',
    'upload' => 'Resim yükle',
    'upload_button' => 'Yükle',
    'error' => 'Hata',
    'error_no_image' => 'Lütfen bir resim seçiniz',
    'error_uploading' => 'Resim yükleme işleminde bir hata oluştu. Lütfen biraz sonra tekrar deneyiniz.',
    'error_wrong_type' => 'Resim türü yanlış',
    'error_no_dir' => 'Dizinde kütüphane bulunmuyor',
	'error_cant_delete' => 'Silme işleminde hata oluştu', // new 1.0.5
  ),
  'image_prop' => array(
    'title' => 'Resim ayarları',
    'ok' => '   OK   ',
    'cancel' => 'İptal',
    'source' => 'Kaynak',
    'alt' => 'Alternatif Metin',
    'align' => 'Konum',
    'justifyleft' => 'Sol',
    'justifyright' => 'Sağ',
    'top' => 'Yukarda',
    'middle' => 'Ortada',
    'bottom' => 'Alt kısımda',
    'absmiddle' => 'Merkezde',
    'texttop' => 'Metin üstü',
    'baseline' => 'Çizgi üzeri',
    'width' => 'Genişlik',
    'height' => 'Yükseklik',
    'border' => 'Çerceve',
    'hspace' => 'Yatay boşluk',
    'vspace' => 'Dikey boşluk',
    'error' => 'Hata',
    'error_width_nan' => 'Genişlik sayı değil',
    'error_height_nan' => 'Yükseklik sayı değil',
    'error_border_nan' => 'Çerceve sayı değil',
    'error_hspace_nan' => 'Yatay boşluk sayı değil',
    'error_vspace_nan' => 'Dikey boşluk sayı değil',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Yatay çizgi'
  ),
  'table_create' => array(
    'title' => 'Tabela oluştur'
  ),
  'table_prop' => array(
    'title' => 'Tabela özellikleri',
    'ok' => '   OK   ',
    'cancel' => 'İptal et',
    'rows' => 'Satırlar',
    'columns' => 'Haneler',
	'css_class' => 'CSS class', // <=== new 1.0.6
    'width' => 'Genişlik',
    'height' => 'Yükseklik',
    'border' => 'Çerceve',
    'pixels' => 'Pixel',
    'cellpadding' => 'Hücreyi dolumu',
    'cellspacing' => 'Hücre mesafesi',
    'bg_color' => 'Arka ekran rengi',
	'background' => 'Arka ekran resmi', // <=== new 1.0.6
    'error' => 'Hata',
    'error_rows_nan' => 'Satır rakam değil',
    'error_columns_nan' => 'Hane rakam değil',
    'error_width_nan' => 'Genişlik rakam değil',
    'error_height_nan' => 'Yükseklik rakam değil',
    'error_border_nan' => 'Çerceve rakam değil',
    'error_cellpadding_nan' => 'Hücre dolumu rakam değil',
    'error_cellspacing_nan' => 'Hücre mesafesi rakam değil',
  ),
  'table_cell_prop' => array(
    'title' => 'Hücre özelliği',
    'horizontal_align' => 'Yatay konumu',
    'vertical_align' => 'Dikey konumu',
    'width' => 'Genişlik',
    'height' => 'Yükseklik',
    'css_class' => 'CSS sınıfı',
    'no_wrap' => 'Paketsiz',
    'bg_color' => 'Arka ekran rengi',
	'background' => 'Arka ekran resmi', // <=== new 1.0.6
    'ok' => '   OK   ',
    'cancel' => 'İptal et',
    'justifyleft' => 'Sol',
    'justifycenter' => 'Merkezi',
    'justifyright' => 'Sağ',
    'top' => 'Üst kısım',
    'middle' => 'Orta',
    'bottom' => 'Alt kısım',
    'baseline' => 'Çizgi üstü',
    'error' => 'Hata',
    'error_width_nan' => 'Genişlik rakam değil',
    'error_height_nan' => 'Yükseklik rakam değil',
    
  ),
  'table_row_insert' => array(
    'title' => 'Satır ekle'
  ),
  'table_column_insert' => array(
    'title' => 'Hane ekle'
  ),
  'table_row_delete' => array(
    'title' => 'Satır sil'
  ),
  'table_column_delete' => array(
    'title' => 'Hane sil'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Hücreyi sağ taraf ile birleştir.'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Hücereyi alt taraf ile birleştir.'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Hücreyi yatay olarak böl'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Hücreyi dikey olarak böl'
  ),
  'style' => array(
    'title' => 'Düzenleme'
  ),
  'fontname' => array(
    'title' => 'Yazı'
  ),
  'fontsize' => array(
    'title' => 'Büyüklüğü'
  ),
  'formatBlock' => array(
    'title' => 'Parağraf'
  ),
  'bold' => array(
    'title' => 'Kalın'
  ),
  'italic' => array(
    'title' => 'Yatay ince'
  ),
  'underline' => array(
    'title' => 'Alt çizgili'
  ),
  'insertorderedlist' => array(
    'title' => 'Numarasal'
  ),
  'insertunorderedlist' => array(
    'title' => 'Listesel'
  ),
  'indent' => array(
    'title' => 'Dışa çek'
  ),
  'outdent' => array(
    'title' => 'İçe çek'
  ),
  'justifyleft' => array(
    'title' => 'Sol'
  ),
  'justifycenter' => array(
    'title' => 'Merkez'
  ),
  'justifyright' => array(
    'title' => 'Sağ'
  ),
  'fore_color' => array(
    'title' => 'Yazı rengi'
  ),
  'bg_color' => array(
    'title' => 'Arka ekran rengi'
  ),
  'design' => array(
    'title' => 'Design Modüsüne geç'
  ),
  'html' => array(
    'title' => 'HTML Modüsüne geç'
  ),
  'colorpicker' => array(
    'title' => 'Renk seçimi',
    'ok' => '   OK   ',
    'cancel' => 'İptal et',
  ),
  'cleanup' => array(
    'title' => 'HTML temizleyeçi',
    'confirm' => 'Bu seçenek HTML formatlarını (Style) İçeriğinizden siler. Bu komutu seçmekle ya tüm ya da bazı Style blockları metin içerisinden silinir ',
    'ok' => '   OK   ',
    'cancel' => 'İptal',
  ),
  'toggle_borders' => array(
    'title' => 'Toggle borders',
  ),
  'hyperlink' => array(
    'title' => 'Link ekle',
    'url' => 'URL',
    'name' => 'Adı',
    'target' => 'Hedef',
    'title_attr' => 'Başlık',
	'a_type' => 'Tip', // <=== new 1.0.6
	'type_link' => 'Link', // <=== new 1.0.6
	'type_anchor' => 'Çapa', // <=== new 1.0.6
	'type_link2anchor' => 'Çapaya link', // <=== new 1.0.6
	'anchors' => 'Anchors', // <=== new 1.0.6
    'ok' => '   OK   ',
    'cancel' => 'İptal',
  ),
  'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => 'kendi penceresi (_self)',
	'_blank' => 'boş yeni pencerede (_blank)',
	'_top' => 'bir üst pencerede (_top)',
	'_parent' => 'aynı pencerede (_parent)'
  ),
  'table_row_prop' => array(
    'title' => 'Satır özellikleri',
    'horizontal_align' => 'Yatay konum',
    'vertical_align' => 'Dikey konum',
    'css_class' => 'CSS Klası',
    'no_wrap' => 'Paketsiz',
    'bg_color' => 'Arka ekran rengi',
    'ok' => '   OK   ',
    'cancel' => 'İptal',
    'justifyleft' => 'Sol',
    'justifycenter' => 'Merkez',
    'justifyright' => 'Sağ',
    'top' => 'Üst',
    'middle' => 'Orta',
    'bottom' => 'Alt',
    'baseline' => 'Çizgi üstü',
  ),
  'symbols' => array(
    'title' => 'Özel karekterler',
    'ok' => '   OK   ',
    'cancel' => 'İptal',
  ),
  'templates' => array(
    'title' => 'Kalıplar',
  ),
  'page_prop' => array(
    'title' => 'Sayfa özelliği',
    'title_tag' => 'Başlık',
    'charset' => 'Metin Karekteri',
    'background' => 'Arka plan resmi',
    'bgcolor' => 'Arka plan rengi',
    'text' => 'Yazı rengi',
    'link' => 'Link rengi',
    'vlink' => 'Uğranılmış link rengi',
    'alink' => 'Actif link rengi',
    'leftmargin' => 'Sol kenar',
    'topmargin' => 'Üst kenar',
    'css_class' => 'CSS Klası',
    'ok' => '   OK   ',
    'cancel' => 'İptal',
  ),
  'preview' => array(
    'title' => 'Ön gösterim',
  ),
  'image_popup' => array(
    'title' => 'Resim popup',
  ),
  'zoom' => array(
    'title' => 'Büyülteç',
  ),
  'subscript' => array( // <=== new 1.0.7
    'title' => 'Subscript',
  ),
  'superscript' => array( // <=== new 1.0.7
    'title' => 'Superscript',
  ),
);
?>