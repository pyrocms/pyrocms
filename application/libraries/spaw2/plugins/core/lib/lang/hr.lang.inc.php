<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Slovenian language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Croatian translation:  
//                         dragan@pfri.hr
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
    'title' => 'Izreži'
  ),
  'copy' => array(
    'title' => 'Kopiraj'
  ),
  'paste' => array(
    'title' => 'Zalijepi'
  ),
  'undo' => array(
    'title' => 'Poništi'
  ),
  'redo' => array(
    'title' => 'Obnovi'
  ),
  'hyperlink' => array(
    'title' => 'Poveznica'
  ),
  'image_insert' => array(
    'title' => 'Unos slike',
    'select' => 'Izbor',
    'cancel' => 'Prekid',
    'library' => 'Knjižnica',
    'preview' => 'Pregled',
    'images' => 'Slike',
    'upload' => 'Unos slike',
    'upload_button' => 'Unos',
    'error' => 'Grješka',
    'error_no_image' => 'Izaberite sliku',
    'error_uploading' => 'Grješka pri unosu slike. Ponovite molim',
    'error_wrong_type' => 'Datoteka ne sadrži sliku',
    'error_no_dir' => 'Knjižnica ne postoji / nije dostupna',
  ),
  'image_prop' => array(
    'title' => 'Naziv slike',
    'ok' => '   OK   ',
    'cancel' => 'Prekid',
    'source' => 'Izvor',
    'alt' => 'Alternativni naziv',
    'align' => 'Poravnaj',
    'justifyleft' => 'lijevo',
    'justifyright' => 'desno',
    'top' => 'gore',
    'middle' => 'u sredinu',
    'bottom' => 'dolje',
    'absmiddle' => 'apsolutna sredina',
    'texttop' => 'na vrh teksta',
    'baseline' => 'na osnovni red',
    'width' => 'Širina',
    'height' => 'Visina',
    'border' => 'Obrub',
    'hspace' => 'Vodoravni. razmak',
    'vspace' => 'Okomiti razmak',
    'error' => 'Grješka',
    'error_width_nan' => 'Širina mora biti  brojčana vrijednost',
    'error_height_nan' => 'Visina mora biti  brojčana vrijednost',
    'error_border_nan' => 'Obrub mora biti  brojčana vrijednost',
    'error_hspace_nan' => 'Vodoravni razmak  brojčana vrijednost',
    'error_vspace_nan' => 'Okomiti razmik mora brojčana vrijednost',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Vodoravna crta'
  ),
  'table_create' => array(
    'title' => 'Tablica'
  ),
  'table_prop' => array(
    'title' => 'Naziv tablice',
    'ok' => '   OK   ',
    'cancel' => 'Prekid',
    'rows' => 'red',
    'columns' => 'stubac',
    'width' => 'Širina',
    'height' => 'Visina',
    'border' => 'Debljina obruba',
    'pixels' => 'pixela',
    'cellpadding' => 'Debljina obloge ćelije',
    'cellspacing' => 'Razmak među ćelijama',
    'bg_color' => 'Boja pozadine',
    'error' => 'Grješka',
    'error_rows_nan' => 'Broj redova  mora biti  brojčana vrijednost',
    'error_columns_nan' => 'Broj stubaca  mora biti  brojčana vrijednost',
    'error_width_nan' => 'Širina mora biti  brojčana vrijednost',
    'error_height_nan' => 'Visina mora biti  brojčana vrijednost',
    'error_border_nan' => 'Debljina obrube mora biti  brojčana vrijednost',
    'error_cellpadding_nan' => 'Debljina obloge ćelije mora biti  brojčana vrijednost',
    'error_cellspacing_nan' => 'Razmak među ćelijama mora biti  brojčana vrijednost',
  ),
  'table_cell_prop' => array(
    'title' => 'Svojstva ćelije',
    'horizontal_align' => 'vodoravno poravnanje',
    'vertical_align' => 'horizontalno  poravnanje',
    'width' => 'Širina',
    'height' => 'Visina',
    'css_class' => 'CSS razred',
    'no_wrap' => 'Brez prijeloma (wrap)',
    'bg_color' => 'Boja pozadine',
    'ok' => '   OK   ',
    'cancel' => 'Prekin',
    'justifyleft' => 'Lijevo',
    'justifycenter' => 'Centar',
    'justifyright' => 'Desno',
    'top' => 'Gore',
    'middle' => 'Sredina',
    'bottom' => 'Dolje',
    'baseline' => 'Osnovna linija',
    'error' => 'Grješka',
    'error_width_nan' => 'Širina  mora biti  brojčana vrijednost',
    'error_height_nan' => 'Visina mora biti  brojčana vrijednost',
  ),
  'table_row_insert' => array(
    'title' => 'Unos reda'
  ),
  'table_column_insert' => array(
    'title' => 'Unos stupca'
  ),
  'table_row_delete' => array(
    'title' => 'Brisanje reda'
  ),
  'table_column_delete' => array(
    'title' => 'Brišanje stupca'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Unos na desno'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Unos ispod'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Vodoravno podijeli ćeliju'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Okomito podijeli ćeliju'
  ),
  'style' => array(
    'title' => 'Stil'
  ),
  'fontname' => array(
    'title' => 'Font'
  ),
  'fontsize' => array(
    'title' => 'Veličina'
  ),
  'formatBlock' => array(
    'title' => 'Odlomak'
  ),
  'bold' => array(
    'title' => 'Podebljano'
  ),
  'italic' => array(
    'title' => 'Kurziv'
  ),
  'underline' => array(
    'title' => 'Podcrtano'
  ),
  'insertorderedlist' => array(
    'title' => 'Numeriranje'
  ),
  'insertunorderedlist' => array(
    'title' => 'Grafičke oznake'
  ),
  'indent' => array(
    'title' => 'Povećaj uvlaku'
  ),
  'outdent' => array(
    'title' => 'Smanji uvlaku'
  ),
  'justifyleft' => array(
    'title' => 'Lijevo'
  ),
  'justifycenter' => array(
    'title' => 'Center'
  ),
  'justifyright' => array(
    'title' => 'Desno'
  ),
  'fore_color' => array(
    'title' => 'Boja prednjice'
  ),
  'bg_color' => array(
    'title' => 'Boja pozadine'
  ),
  'design' => array(
    'title' => 'Pregled izgleda '
  ),
  'html' => array(
    'title' => 'Pregled  HTML koda'
  ),
  'colorpicker' => array(
    'title' => 'Boje',
    'ok' => '   OK   ',
    'cancel' => 'Prekid',
  ),
  'cleanup' => array(
    'title' => 'Čiščenje HTML (odstranjivanje stilova)',
    'confirm' => 'Brisanje stilova iz HTML koda. Stilovi su djelomice ili potpuno izbrisani.',
    'ok' => '   OK   ',
    'cancel' => 'Prekid',
  ),
  'toggle_borders' => array(
    'title' => 'Preklop obruba',
  ),
  'hyperlink' => array(
    'title' => 'Poveznica',
    'url' => 'URL ( poveznica )',
    'name' => 'Naziv',
    'target' => 'Odredišni okvir',
    'title_attr' => 'Tekst za prikaz',
    'ok' => '   OK   ',
    'cancel' => 'Prekid',
  ),
  'table_row_prop' => array(
    'title' => 'Svojstva redova',
    'horizontal_align' => 'Vodoravno poravnanje',
    'vertical_align' => 'Okomito poravnanje',
    'css_class' => 'CSS razred',
    'no_wrap' => 'Brez prijeloma (wrap)',
    'bg_color' => 'Boja pozadine',
    'ok' => '   OK   ',
    'cancel' => 'Prekid',
    'justifyleft' => 'Lijevo',
    'justifycenter' => 'Centar',
    'justifyright' => 'Desno',
    'top' => 'Gore',
    'middle' => 'Sredina',
    'bottom' => 'Dolje',
    'baseline' => 'Osnovna linija',
  ),
  'symbols' => array(
    'title' => 'Posebni znaci',
    'ok' => '   OK   ',
    'cancel' => 'Prekid',
  ),
  'templates' => array(
    'title' => 'Podloge',
  ),
  'page_prop' => array(
    'title' => 'Svojstva  stranice',
    'title_tag' => 'Naslov',
    'charset' => 'Prikaz slova ( charset)',
    'background' => 'Slika u pozadini',
    'bgcolor' => 'Boja ppozadine',
    'text' => 'Boja slova teksta',
    'link' => 'Boja poveznica',
    'vlink' => 'Boja posjećene poveznice',
    'alink' => 'Boja aktivne poveznice',
    'leftmargin' => 'Margina lijevo',
    'topmargin' => 'Margina gore',
    'css_class' => 'CSS razred',
    'ok' => '   OK   ',
    'cancel' => 'Prekid',
  ),
  'preview' => array(
    'title' => 'Pregled',
  ),
  'image_popup' => array(
    'title' => 'Popup sa slikom',
  ),
  'zoom' => array(
    'title' => 'Povećaj ( Zoom )',
  ),
);
?>