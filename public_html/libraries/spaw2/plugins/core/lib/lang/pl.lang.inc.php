<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Polish language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// polish bersion by Slawomir Jasinski slav123@gmail.com
// v.1.0.7, 2004-10-13
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Wytnij'
  ),
  'copy' => array(
    'title' => 'Kopiuj'
  ),
  'paste' => array(
    'title' => 'Wklej'
  ),
  'undo' => array(
    'title' => 'Cofnij'
  ),
  'redo' => array(
    'title' => 'Ponów'
  ),
  'image_insert' => array(
    'title' => 'Wstaw obrazek',
    'select' => 'Wybierz',
	'delete' => 'Usuń', // new 1.0.5
    'cancel' => 'Anuluj',
    'library' => 'Biblioteka',
    'preview' => 'Podgląd',
    'images' => 'Obrazki',
    'upload' => 'Wyślij obrazek',
    'upload_button' => 'Wyślij',
    'error' => 'Błąd',
    'error_no_image' => 'Proszę wybrać obrazek',
    'error_uploading' => 'Przy wysyłaniu obrazka wystąpił błąd. Proszę spróbować później.',
    'error_wrong_type' => 'Niewłaściwy typ pliku obrazka',
    'error_no_dir' => 'Brak biblioteki obrazków',
	'error_cant_delete' => 'Błąd usuwania', // new 1.0.5
  ),
  'image_prop' => array(
    'title' => 'Właściwości obrazka',
    'ok' => '   OK   ',
    'cancel' => 'Anuluj',
    'source' => 'Ścieżka',
    'alt' => 'Tekst alternatywny',
    'align' => 'Wyrównanie',
    'justifyleft' => 'justifyleft',
    'justifyright' => 'justifyright',
    'top' => 'top',
    'middle' => 'middle',
    'bottom' => 'bottom',
    'absmiddle' => 'absmiddle',
    'texttop' => 'texttop',
    'baseline' => 'baseline',
    'width' => 'Szerokość',
    'height' => 'Wysokość',
    'border' => 'Obramowanie',
    'hspace' => 'Odstęp poziomy',
    'vspace' => 'Odstęp pionowy',
    'error' => 'Błąd',
    'error_width_nan' => 'Szerokość nie jest liczbą',
    'error_height_nan' => 'Wysokość nie jest liczbą',
    'error_border_nan' => 'Ramka nie jest liczbą',
    'error_hspace_nan' => 'Odstęp poziomy nie jest liczbą',
    'error_vspace_nan' => 'Odstęp pionowy nie jest liczbą',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Linia pozioma'
  ),
  'table_create' => array(
    'title' => 'Wstaw tabelę'
  ),
  'table_prop' => array(
    'title' => 'Właściwości tabeli',
    'ok' => '   OK   ',
    'cancel' => 'Anuluj',
    'rows' => 'Liczba wierszy',
    'columns' => 'Liczba kolumn',
    'css_class' => 'Styl CSS', // <=== new 1.0.6
    'width' => 'Szerokość',
    'height' => 'Wysokość',
    'border' => 'Obramowanie',
    'pixels' => 'pikseli',
    'cellpadding' => 'Margines komórki',
    'cellspacing' => 'Obramowanie komórki',
    'bg_color' => 'Kolor tła',
    'background' => 'Obrazek tła', // <=== new 1.0.6
    'error' => 'Błąd',
    'error_rows_nan' => 'Liczba wierszy nie jest liczbą',
    'error_columns_nan' => 'Liczba kolumn nie jest liczbą',
    'error_width_nan' => 'Szerokość nie jest liczbą',
    'error_height_nan' => 'Wysokość nie jest liczbą',
    'error_border_nan' => 'Obramowanie nie jest liczbą',
    'error_cellpadding_nan' => 'Margines komórki nie jest liczbą',
    'error_cellspacing_nan' => 'Obramowanie komórki nie jest liczbą',
  ),
  'table_cell_prop' => array(
    'title' => 'Właściwości komórki',
    'horizontal_align' => 'Wyrównanie w poziomie',
    'vertical_align' => 'Wyrównanie w pionie',
    'width' => 'Szerokość',
    'height' => 'Wysokość',
    'css_class' => 'styl CSS',
    'no_wrap' => 'Blokuj dzielenie akapitu',
    'bg_color' => 'Kolor tła',
    'background' => 'Obrazek tła', // <=== new 1.0.6
    'ok' => '   OK   ',
    'cancel' => 'Anuluj',
    'justifyleft' => 'Do lewej',
    'justifycenter' => 'Do środka',
    'justifyright' => 'Do prawej',
    'top' => 'Do góry',
    'middle' => 'Do środka',
    'bottom' => 'Do dołu',
    'baseline' => 'Do linii bazowej',
    'error' => 'Błąd',
    'error_width_nan' => 'Szerokość nie jest liczbą',
    'error_height_nan' => 'Wysokość nie jest liczbą',
  ),
  'table_row_insert' => array(
    'title' => 'Wstaw wiersz'
  ),
  'table_column_insert' => array(
    'title' => 'Wstaw kolumnę'
  ),
  'table_row_delete' => array(
    'title' => 'Usuń wiersz'
  ),
  'table_column_delete' => array(
    'title' => 'Usuń kolumnę'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Połącz z prawą'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Połącz z dolną'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Podziel komórkę w poziomie'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Podziel komórkę w pionie'
  ),
  'style' => array(
    'title' => 'Styl'
  ),
  'fontname' => array(
    'title' => 'Czcionka'
  ),
  'fontsize' => array(
    'title' => 'Rozmiar'
  ),
  'formatBlock' => array(
    'title' => 'Akapit'
  ),
  'bold' => array(
    'title' => 'Pogrubienie'
  ),
  'italic' => array(
    'title' => 'Kursywa'
  ),
  'underline' => array(
    'title' => 'Podkreślenie'
  ),
  'insertorderedlist' => array(
    'title' => 'Numerowanie'
  ),
  'insertunorderedlist' => array(
    'title' => 'Wypunktowanie'
  ),
  'indent' => array(
    'title' => 'Zwiększ wcięcie'
  ),
  'outdent' => array(
    'title' => 'Zmniejsz wcięcie'
  ),
  'justifyleft' => array(
    'title' => 'Wyrównaj do lewej'
  ),
  'justifycenter' => array(
    'title' => 'Wyśrodkuj'
  ),
  'justifyright' => array(
    'title' => 'Wyrównaj do prawej'
  ),
  'fore_color' => array(
    'title' => 'Kolor czcionki'
  ),
  'bg_color' => array(
    'title' => 'Kolor tła'
  ),
  'design' => array(
    'title' => 'Przełącz w tryb podglądu (WYSIWYG)'
  ),
  'html' => array(
    'title' => 'Przełącz w tryb HTML (kod)'
  ),
  'colorpicker' => array(
    'title' => 'Wybór koloru',
    'ok' => '   OK   ',
    'cancel' => 'Anuluj',
  ),
  'cleanup' => array(
    'title' => 'czyszczenie HTML (usuwanie styli)',
    'confirm' => 'Przeprowadzenie tej operacji usunie wszystkie style, określenia czcionek i zbędne znaczniki z bieżącej treści. Część lub całość formatowania może zostać utracona.',
    'ok' => '   OK   ',
    'cancel' => 'Anuluj',
  ),
  'toggle_borders' => array(
    'title' => 'Przełącz obramowania',
  ),
  'hyperlink' => array(
    'title' => 'Odsyłacz',
    'url' => 'Adres URL',
    'name' => 'Nazwa',
    'target' => 'Okno docelowe',
    'title_attr' => 'Tytuł',
	'a_type' => 'Typ', // <=== new 1.0.6
	'type_link' => 'Link', // <=== new 1.0.6
	'type_anchor' => 'Kotwica', // <=== new 1.0.6
	'type_link2anchor' => 'Adres kotwicy', // <=== new 1.0.6
    'anchors' => 'Kotwice', // <=== new 1.0.6
    'ok' => '   OK   ',
    'cancel' => 'Anuluj',
  ),
  'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => 'to samo (_self)',
	'_blank' => 'nowe okno (_blank)',
	'_top' => 'górna ramka (_top)',
	'_parent' => 'nadrzędna ramka (_parent)'
  ),
  'table_row_prop' => array(
    'title' => 'Właściwosci wiersza',
    'horizontal_align' => 'Wyrównanie w poziomie',
    'vertical_align' => 'Wyrównanie w pionie',
    'css_class' => 'styl CSS',
    'no_wrap' => 'Blokuj dzielenie akapitu',
    'bg_color' => 'Kolor tła',
    'ok' => '   OK   ',
    'cancel' => 'Anuluj',
    'justifyleft' => 'Wyrównaj do lewej',
    'justifycenter' => 'Do środka',
    'justifyright' => 'Do prawej',
    'top' => 'Do góry',
    'middle' => 'Do środka',
    'bottom' => 'Do dołu',
    'baseline' => 'Do linii bazowej',
  ),
  'symbols' => array(
    'title' => 'Znaki specjalne',
    'ok' => '   OK   ',
    'cancel' => 'Anuluj',
  ),
  'templates' => array(
    'title' => 'Szablony',
  ),
  'page_prop' => array(
    'title' => 'Właściwości strony',
    'title_tag' => 'Tytył',
    'charset' => 'Strona kodowa',
    'background' => 'Obraz tła',
    'bgcolor' => 'Kolor tła',
    'text' => 'Kolor tekstu',
    'link' => 'Kolor odsyłacza',
    'vlink' => 'Kolor wybranego odsyłacza',
    'alink' => 'Kolor aktywnego odsyłacza',
    'leftmargin' => 'Margines lewy',
    'topmargin' => 'Margines górny',
    'css_class' => 'Styl CSS',
    'ok' => '   OK   ',
    'cancel' => 'Anuluj',
  ),
  'preview' => array(
    'title' => 'Podgląd',
  ),
  'image_popup' => array(
    'title' => 'Image popup',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
  'subscript' => array( // <=== new 1.0.7
    'title' => 'Indeks dolny',
  ),
  'superscript' => array( // <=== new 1.0.7
    'title' => 'Indeks górny',
  ),
);
?>