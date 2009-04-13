<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Czech language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Czech translation: BrM (BrM@bridlicna.cz)
// Updated by Radek Uhlíř (ruhlir@gmail.com)
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.1, 2007-09-04
// ================================================
 
 // charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Vyjmout'
  ),
  'copy' => array(
    'title' => 'Kopírovat'
  ),
  'paste' => array(
    'title' => 'Vložit'
  ),
  'undo' => array(
    'title' => 'Zpět'
  ),
  'redo' => array(
    'title' => 'Znovu'
  ),
  'image' => array(
    'title' => 'Vložit obrázek'
  ),
  'image_prop' => array(
    'title' => 'Obrázek',
    'ok' => '   OK   ',
    'cancel' => 'Storno',
    'source' => 'Source',
    'alt' => 'Alternativní text',
    'align' => 'Zarovnání',
    'left' => 'vlevo',
    'right' => 'vpravo',
    'top' => 'nahoru',
    'middle' => 'na střed',
    'bottom' => 'dolů',
    'absmiddle' => 'Absolutní střed',
    'texttop' => 'Text nahoru',
    'baseline' => 'Základní linka',
    'width' => 'Šířka',
    'height' => 'Výška',
    'border' => 'Okraje',
    'hspace' => 'Vod. okraj',
    'vspace' => 'Svisl. okraj',
    'dimensions' => 'Rozměry', // <= new in 2.0.1
    'reset_dimensions' => 'Původní rozměry', // <= new in 2.0.1
    'title_attr' => 'Titulek', // <= new in 2.0.1
    'constrain_proportions' => 'Zachovat proporce', // <= new in 2.0.1
    'error' => 'Chyba',
    'error_width_nan' => 'Šířka není číslo',
    'error_height_nan' => 'Výška není číslo',
    'error_border_nan' => 'Okraj není číslo',
    'error_hspace_nan' => 'Horizontální rozteč není číslo',
    'error_vspace_nan' => 'Vertikální rozteč není číslo',
  ),
  'flash_prop' => array(                // <= new in 2.0
    'title' => 'Flash',
    'ok' => '   OK   ',
    'cancel' => 'Storno',
    'source' => 'Zdroj',
    'width' => 'Šířka',
    'height' => 'Výška',
    'error' => 'Chyba',
    'error_width_nan' => 'Šířka není číslo.',
    'error_height_nan' => 'Výška není číslo.',
  ),
  'inserthorizontalrule' => array( // <== v.2.0 changed from hr
    'title' => 'Horizontální čára'
  ),
  'table_create' => array(
    'title' => 'Vytvoř tabulku'
  ),
  'table_prop' => array(
    'title' => 'Vlastnosti tabulky',
    'ok' => '   OK   ',
    'cancel' => 'Storno',
    'rows' => 'Řádků',
    'columns' => 'Sloupců',
    'css_class' => 'Třída CSS', // <=== new 1.0.6
	'width' => 'Šířka',
    'height' => 'Výška',
    'border' => 'Okraje',
    'pixels' => 'pixelů',
    'cellpadding' => 'Odsazení v buňce',
    'cellspacing' => 'Vzdálenost buněk',
    'bg_color' => 'Barva pozadí',
    'background' => 'Obrázek pozadí', // <=== new 1.0.6
	'error' => 'Chyba',
    'error_rows_nan' => 'Řádky nejsou číslo',
    'error_columns_nan' => 'Sloupce nejsou číslo',
    'error_width_nan' => 'Šířka není číslo',
    'error_height_nan' => 'Výška není číslo',
    'error_border_nan' => 'Okraje nejsou číslo',
    'error_cellpadding_nan' => 'Odsazení v buňce není číslo',
    'error_cellspacing_nan' => 'Vzdálenost buňek není číslo',
  ),
  'table_cell_prop' => array(
    'title' => 'Vlastnosti buňky',
    'horizontal_align' => 'Horizontální zarovnání',
    'vertical_align' => 'Vertikální zarovnání',
    'width' => 'Šířka',
    'height' => 'Výška',
    'css_class' => 'Třída CSS',
    'no_wrap' => 'Nezalamovat',
    'bg_color' => 'Barva pozadí',
    'background' => 'Obrázek pozadí', // <=== new 1.0.6
    'ok' => '   OK   ',
    'cancel' => 'Zrušit',
    'left' => 'Vlevo',
    'center' => 'Na střed',
    'right' => 'Vpravo',
    'top' => 'Nahoru',
    'middle' => 'Doprostřed',
    'bottom' => 'Dolů',
    'baseline' => 'Základní linka',
    'error' => 'Chyba',
    'error_width_nan' => 'Šířka není číslo',
    'error_height_nan' => 'Výška není číslo',  
  ),
  'table_row_insert' => array(
    'title' => 'Vložit řádek'
  ),  
  'table_column_insert' => array(
    'title' => 'Vložit sloupec'
  ),
  'table_row_delete' => array(
    'title' => 'Vymaž řádek'
  ),
  'table_column_delete' => array(
    'title' => 'Vymaž sloupec'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Sloučit vpravo'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Sloučit dolů'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Rozdělit buňku horizontálně'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Rozdělit buňku vertikálně'
  ),
 'style' => array(
    'title' => 'Styl'
  ),
  'fontname' => array(
    'title' => 'Font'
  ),
  'fontsize' => array(
    'title' => 'Velikost'
  ),
  'formatBlock' => array(
    'title' => 'Odstavec'
  ),
  'bold' => array(
    'title' => 'Tučné'
  ),
  'italic' => array(
    'title' => 'Kurzíva'
  ),
  'underline' => array(
    'title' => 'Podtržení'
  ),
  'strikethrough' => array(
    'title' => 'Přeškrtnuté'
  ),
  'insertorderedlist' => array(
    'title' => 'Číslování'
  ),
  'insertunorderedlist' => array(
    'title' => 'Odrážky'
  ),
  'indent' => array(
    'title' => 'Zvětšit odsazení'
  ),
  'outdent' => array(
    'title' => 'Zmenšit odsazení'
  ),
  'justifyleft' => array(
    'title' => 'Vlevo'
  ),
  'justifycenter' => array(
    'title' => 'Na střed'
  ),
  'justifyright' => array(
    'title' => 'Vpravo'
  ),
  'justifyfull' => array( // <== v.2.0 changed from justify
    'title' => 'Do bloku'
  ),
  'fore_color' => array(
    'title' => 'Barva popředí'
  ),
  'bg_color' => array(
    'title' => 'Barva pozadí'
  ),
  'design' => array(
    'title' => 'Přepnout do WYSIWYG režimu'
  ),
  'html' => array(
    'title' => 'Přepnout do HTML režimu'
  ),
  'colorpicker' => array(
    'title' => 'Paleta barev',
    'ok' => '   OK   ',
    'cancel' => 'Storno',
  ),
  'cleanup' => array(
    'title' => 'Vyčištění HTML (odstranit styly)',
    'confirm' => 'Provedením akce odstraníte všechny styly, fonty a zbytečné tagy z aktuálního obsahu. Vaše formátování bude částečně či úplně odstraněno.',
    'ok' => '   OK   ',
    'cancel' => 'Storno',
  ),
  'toggle_borders' => array(
    'title' => 'Přepnout okraje',
  ),
  'hyperlink' => array(
    'title' => 'Odkaz',
    'url' => 'URL',
    'name' => 'Jméno',
    'target' => 'Cíl',
    'title_attr' => 'Popisek',
	'a_type' => 'Typ', // <=== new 1.0.6
	'type_link' => 'Odkaz', // <=== new 1.0.6
	'type_anchor' => 'Kotva', // <=== new 1.0.6
	'type_link2anchor' => 'Odkaz na kotvu', // <=== new 1.0.6
	'anchors' => 'Kotvy', // <=== new 1.0.6
    'ok' => '   OK   ',
    'cancel' => 'Storno',
  ),
  'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => 'Stejný rámec (_self)',
	'_blank' => 'Nové okno (_blank)',
	'_top' => 'Vrchní rámec (_top)',
	'_parent' => 'Nadřazený rámec (_parent)'
  ),
  'unlink' => array( // <=== new v.2.0
    'title' => 'Odstranit odkaz'
  ),
  'table_row_prop' => array(
    'title' => 'Vlastnosti řádku',
    'horizontal_align' => 'Horizontální zarovnání',
    'vertical_align' => 'Vertikální zarovnání',
    'css_class' => 'Třída CSS',
    'no_wrap' => 'Nezalamovat',
    'bg_color' => 'Barva pozadí',
    'ok' => '   OK   ',
    'cancel' => 'Storno',
    'left' => 'Vlevo',
    'center' => 'Na střed',
    'right' => 'Vpravo',
    'top' => 'Nahoru',
    'middle' => 'Doprostřed',
    'bottom' => 'Dolů',
    'baseline' => 'Základní linka',
  ),
  'symbols' => array(
    'title' => 'Speciální znaky',
    'ok' => '   OK   ',
    'cancel' => 'Storno',
  ),
  'templates' => array(
    'title' => 'Šablony',
  ),
  'page_prop' => array(
    'title' => 'Vlastnosti stránky',
    'title_tag' => 'Název',
    'charset' => 'Znaková sada',
    'background' => 'Obrázek pozadí',
    'bgcolor' => 'Barva pozadí',
    'text' => 'Barva textu',
    'link' => 'Barva odkazu',
    'vlink' => 'Barva navštíveného odkazu',
    'alink' => 'Barva aktivního odkazu',
    'leftmargin' => 'Levý okraj',
    'topmargin' => 'Horní okraj',
    'css_class' => 'Třída CSS',
    'ok' => '   OK   ',
    'cancel' => 'Storno',
  ),
  'preview' => array(
    'title' => 'Náhled',
  ),
  'image_popup' => array(
    'title' => 'Odkaz na obrázek v novém okně',
  ),
  'zoom' => array(
    'title' => 'Přiblížení',
  ),
  'subscript' => array(
    'title' => 'Dolní index',
  ),
  'superscript' => array(
    'title' => 'Horní index',
  ),
);
?>
