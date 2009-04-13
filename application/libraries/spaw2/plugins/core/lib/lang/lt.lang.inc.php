<?php
// ================================================
// SPAW v.2.0
// ================================================
// Lithuanian language file
// ================================================
// Authors: Alan Mendelevich, Martynas Majeris,
//          Saulius Okunevicius, UAB Solmetra
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.2.0
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Iškirpti'
  ),
  'copy' => array(
    'title' => 'Kopijuoti'
  ),
  'paste' => array(
    'title' => 'Įterpti'
  ),
  'undo' => array(
    'title' => 'Atšaukti'
  ),
  'redo' => array(
    'title' => 'Pakartoti'
  ),
  'image' => array(
    'title' => 'Greitai įterpti iliustraciją'
  ),
  'image_prop' => array(
    'title' => 'Iliustracija',
    'ok' => '   GERAI   ',
    'cancel' => 'Nutraukti',
    'source' => 'Šaltinis',
    'alt' => 'Alternatyvus tekstas',
    'align' => 'Lygiavimas',
    'left' => 'left (kairė)',
    'right' => 'right (dešinė)',
    'top' => 'top (viršus)',
    'middle' => 'middle (vidurys)',
    'bottom' => 'bottom (apačia)',
    'absmiddle' => 'absmiddle (bendras vidurys)',
    'texttop' => 'texttop (teksto viršus)',
    'baseline' => 'baseline (teksto apačia)',
    'width' => 'Plotis',
    'height' => 'Aukštis',
    'border' => 'Rėmelio plotis',
    'hspace' => 'Hor. laukelis',
    'vspace' => 'Vert. laukelis',
    'dimensions' => 'Išmatavimai',
    'reset_dimensions' => 'Atstatyti išmatavimus',
    'title_attr' => 'Antraštė',
    'constrain_proportions' => 'išlaikyti proporcijas',
    'css_class' => 'CSS klasė', 
    'error' => 'Klaida',
    'error_width_nan' => 'Nurodytas plotis nėra skaičius',
    'error_height_nan' => 'Nurodytas aukštis nėra skaičius',
    'error_border_nan' => 'Nurodytas rėmelio plotis nėra skaičius',
    'error_hspace_nan' => 'Nurodytas horizontalaus laukelio plotis nėra skaičius',
    'error_vspace_nan' => 'Nurodytas vertikalaus laukelio plotis nėra skaičius',
  ),
    'flash_prop' => array(
    'title' => 'Flash',
    'ok' => '   GERAI   ',
    'cancel' => 'Nutraukti',
    'source' => 'Šaltinis',
    'width' => 'Plotis',
    'height' => 'Aukštis',
    'error' => 'Klaida',
    'error_width_nan' => 'Nurodytas plotis nėra skaičius',
    'error_height_nan' => 'Nurodytas aukštis nėra skaičius',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Horizontalus skirtukas'
  ),
  'table_create' => array(
    'title' => 'Sukurti lentelę'
  ),
  'table_prop' => array(
    'title' => 'Lentelės parametrai',
    'ok' => '   GERAI   ',
    'cancel' => 'Nutraukti',
    'rows' => 'Eilučių',
    'columns' => 'Stulpelių',
    'css_class' => 'CSS klasė', 
    'width' => 'Plotis',
    'height' => 'Aukštis',
    'border' => 'Rėmelio plotis',
    'pixels' => 'tašk.',
    'cellpadding' => 'Laukelio atitraukimas (padding)',
    'cellspacing' => 'Tarpas tarp laukelių',
    'bg_color' => 'Fono spalva',
    'background' => 'Fono iliustracija',
    'error' => 'Klaida',
    'error_rows_nan' => 'Nurodytas eilučių kiekis nėra skaičius',
    'error_columns_nan' => 'Nurodytas stulpelių kiekis nėra skaičius',
    'error_width_nan' => 'Nurodytas plotis nėra skaičius',
    'error_height_nan' => 'Nurodytas aukštis nėra skaičius',
    'error_border_nan' => 'Nurodytas rėmelio plotis nėra skaičius',
    'error_cellpadding_nan' => 'Nurodytas laukelio atitraukimas nėra skaičius',
    'error_cellspacing_nan' => 'Nurodytas tarpas tarp laukelių nėra skaičius',
  ),
  'table_cell_prop' => array(
    'title' => 'Laukelio parametrai',
    'horizontal_align' => 'Vertikalus lygiavimas',
    'vertical_align' => 'Horizontalus lygiavimas',
    'width' => 'Plotis',
    'height' => 'Aukštis',
    'css_class' => 'CSS klasė',
    'no_wrap' => 'Neperkeliamas',
    'bg_color' => 'Fono spalva',
    'background' => 'Fono iliustracija',
    'ok' => '   GERAI   ',
    'cancel' => 'Nutraukti',
    'left' => 'Kairė',
    'center' => 'Centras',
    'right' => 'Dešinė',
    'top' => 'Viršus',
    'middle' => 'Vidurys',
    'bottom' => 'Apačia',
    'baseline' => 'Teksto apačia',
    'error' => 'Klaida',
    'error_width_nan' => 'Nurodytas plotis nėra skaičius',
    'error_height_nan' => 'Nurodytas aukštis nėra skaičius',
  ),
  'table_row_insert' => array(
    'title' => 'Įterpti eilutę'
  ),
  'table_column_insert' => array(
    'title' => 'Įterpti stulpelį'
  ),
  'table_row_delete' => array(
    'title' => 'Pašalinti eilutę'
  ),
  'table_column_delete' => array(
    'title' => 'Pašalinti stulpelį'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Sujungti laukelius į dešinę'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Sujungti laukelius apačion'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Padalinti laukelį horizontaliai'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Padalinti laukelį vertikaliai'
  ),
  'style' => array(
    'title' => 'Stilius'
  ),
  'fontname' => array(
    'title' => 'Šriftas'
  ),
  'fontsize' => array(
    'title' => 'Dydis'
  ),
  'formatBlock' => array(
    'title' => 'Paragrafas'
  ),
  'bold' => array(
    'title' => 'Stambus šriftas (Bold)'
  ),
  'italic' => array(
    'title' => 'Kursyvas (Italic)'
  ),
  'underline' => array(
    'title' => 'Pabrauktas (Underline)'
  ),
  'strikethrough' => array(
    'title' => 'Perbrauktas (Strikethrough)'
  ),
  'insertorderedlist' => array(
    'title' => 'Numeruotas sąrašas'
  ),
  'insertunorderedlist' => array(
    'title' => 'Sąrašas'
  ),
  'indent' => array(
    'title' => 'Stumti į dešinę'
  ),
  'outdent' => array(
    'title' => 'Stumti į kairę'
  ),
  'justifyleft' => array(
    'title' => 'Kairė'
  ),
  'justifycenter' => array(
    'title' => 'Centras'
  ),
  'justifyright' => array(
    'title' => 'Dešinė'
  ),
  'justifyfull' => array(
    'title' => 'Plotis'
  ),
  'fore_color' => array(
    'title' => 'Teksto spalva'
  ),
  'bg_color' => array(
    'title' => 'Fono spalva'
  ),
  'design' => array(
    'title' => 'Perjungti į grafinio redagavimo režimą'
  ),
  'html' => array(
    'title' => 'Perjungti į HTML kodo redagavimo režimą'
  ),
  'colorpicker' => array(
    'title' => 'Spalvos pasirinkimas',
    'ok' => '   GERAI   ',
    'cancel' => 'Nutraukti'
  ),
  'cleanup' => array(
    'title' => 'HTML valymas (panaikinti stilius)',
    'confirm' => 'Atlikus šį veiksmą bus panaikinti visi tekste naudojami stiliai, šriftai ir nenaudojamos žymos. Dalis ar visas formatavimas gali būti prarastas.',
    'ok' => '   GERAI   ',
    'cancel' => 'Nutraukti',
  ),
  'toggle_borders' => array(
    'title' => 'Įjungti/išjungti rėmelius',
  ),
  'hyperlink' => array(
    'title' => 'Nuoroda',
    'url' => 'Adresas',
    'name' => 'Vardas',
    'target' => 'Kur atidaryti',
    'title_attr' => 'Pavadinimas',
  	'a_type' => 'Tipas',
  	'type_link' => 'Nuoroda',
  	'type_anchor' => 'Inkaras',
  	'type_link2anchor' => 'Nuoroda į inkarą',
  	'anchors' => 'Inkarai',
  	'quick_links' => "Greitos nuorodos", // <=== new in 2.0.6
    'ok' => '   GERAI   ',
    'cancel' => 'Nutraukti',
  ),
  'hyperlink_targets' => array(
  	'_self' => 'tame pačiame lange (_self)',
	'_blank' => 'naujame tuščiame lange (_blank)',
	'_top' => 'pagrindiniame lange (_top)',
	'_parent' => 'tėviniame lange (_parent)'
  ),
  'unlink' => array( 
    'title' => 'Pašalinti nuorodą'
  ),
  'table_row_prop' => array(
    'title' => 'Eilutės parametrai',
    'horizontal_align' => 'Horizontalus lygiavimas',
    'vertical_align' => 'Vertikalus lygiavimas',
    'css_class' => 'CSS klasė',
    'no_wrap' => 'Neperkeliamas',
    'bg_color' => 'Fono spalva',
    'ok' => '   GERAI   ',
    'cancel' => 'Nutraukti',
    'left' => 'Kairė',
    'center' => 'Centras',
    'right' => 'Dešinė',
    'top' => 'Viršus',
    'middle' => 'Vidurys',
    'bottom' => 'Apačia',
    'baseline' => 'Teksto apačia',
  ),
  'symbols' => array(
    'title' => 'Specialūs simboliai',
    'ok' => '   GERAI   ',
    'cancel' => 'Atšaukti',
  ),
  'templates' => array(
    'title' => 'Šablonai',
  ),
  'page_prop' => array(
    'title' => 'Puslapio parametrai',
    'title_tag' => 'Pavadinimas',
    'charset' => 'Simbolių rinkinys (Charset)',
    'background' => 'Fono paveiksliukas',
    'bgcolor' => 'Fono spalva',
    'text' => 'Teksto spalva',
    'link' => 'Nuorodos spalva',
    'vlink' => 'Aplankytos nuorodos spalva',
    'alink' => 'Aktyvios nuorodos spalva',
    'leftmargin' => 'Paraštė kairėje',
    'topmargin' => 'Paraštė viršuje',
    'css_class' => 'CSS klasė',
    'ok' => '   GERAI   ',
    'cancel' => 'Nutraukti',
  ),
  'preview' => array(
    'title' => 'Peržiūra',
  ),
  'image_popup' => array(
    'title' => 'Iššokantis paveiksliukas',
  ),
  'zoom' => array(
    'title' => 'Mastelis',
  ),
  'subscript' => array(
    'title' => 'Nuleistas tekstas',
  ),
  'superscript' => array(
    'title' => 'Pakeltas tekstas',
  ),
);
?>