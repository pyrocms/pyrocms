<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Latvian language file
// ================================================
// Developed: Jānis Grāvitās, sun@sveiks.lv
// Copyright: Solmetra (c)2003 All rights reserved.
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Izgriezt'
  ),
  'copy' => array(
    'title' => 'Kopēt'
  ),
  'paste' => array(
    'title' => 'Ielikt'
  ),
  'undo' => array(
    'title' => 'Atcelt'
  ),
  'redo' => array(
    'title' => 'Atkārtot'
  ),
  'image_insert' => array(
    'title' => 'Ielikt attēlošanu',
    'select' => 'Ielikt',
	'delete' => 'Nodzēst', // new 1.0.5
    'cancel' => 'Atcelt',
    'library' => 'Bibliotēka',
    'preview' => 'Caurskatīšana',
    'images' => 'Attēlošanas',
    'upload' => 'Piekraut attēlošanu',
    'upload_button' => 'Piekraut',
    'error' => 'Kļūda',
    'error_no_image' => 'Izvēlaties attēlošanu',
    'error_uploading' => 'Ielādes laikā notika kļūda. Iemēģiniet vēlreiz.',
    'error_wrong_type' => 'Nekārtna attēlošanas tips',
    'error_no_dir' => 'Bibliotēka neeksistē',
	'error_cant_delete' => 'Nodzēst neizdevās', // new 1.0.5
  ),
  'image_prop' => array(
    'title' => 'Attēlošanas parametri',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
    'source' => 'Avots',
    'alt' => 'Īss apraksts',
    'align' => 'Izlīdzināšana',
    'justifyleft' => 'pa kreisi (left)',
    'justifyright' => 'pa labi (right)',
    'top' => 'no augšas (top)',
    'middle' => 'centrā (middle)',
    'bottom' => 'no lejas (bottom)',
    'absmiddle' => 'absolūts centrs (absmiddle)',
    'texttop' => 'no augšas (texttop)',
    'baseline' => 'no lejas (baseline)',
    'width' => 'Platums',
    'height' => 'Augstums',
    'border' => 'Rāmītis',
    'hspace' => 'Hor. lauki',
    'vspace' => 'Vert. lauki',
    'error' => 'Kļūda',
    'error_width_nan' => 'Platums nav skaitlis',
    'error_height_nan' => 'Augstums nav skaitlis',
    'error_border_nan' => 'Rāmītis nav skaitlis',
    'error_hspace_nan' => 'Horizontāli lauki nav skaitlis',
    'error_vspace_nan' => 'Vertikāli lauki nav skaitlis',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Horizontāla līnija'
  ),
  'table_create' => array(
    'title' => 'Radīt tabulu'
  ),
  'table_prop' => array(
    'title' => 'Tabulas parametri',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
    'rows' => 'Rindas',
    'columns' => 'Slejas',
    'css_class' => 'Stils', // <=== new 1.0.6
    'width' => 'Platums',
    'height' => 'Augstums',
    'border' => 'Rāmītis',
    'pixels' => 'piks.',
    'cellpadding' => 'Atkāpe no rāmīša',
    'cellspacing' => 'Attālums starp šūnām',
    'bg_color' => 'Fona krāsa',
    'background' => 'Fonu attēlošana', // <=== new 1.0.6
    'error' => 'Kļūda',
    'error_rows_nan' => 'Rindas nav skaitlis',
    'error_columns_nan' => 'Slejas nav skaitlis',
    'error_width_nan' => 'Platums nav skaitlis',
    'error_height_nan' => 'Augstums nav skaitlis',
    'error_border_nan' => 'Rāmītis nav skaitlis',
    'error_cellpadding_nan' => 'Atkāpe no rāmīša nav skaitlis',
    'error_cellspacing_nan' => 'Attālums starp šūnām nav skaitlis',
  ),
  'table_cell_prop' => array(
    'title' => 'Šūnas parametri',
    'horizontal_align' => 'Horizontāla izlīdzināšana',
    'vertical_align' => 'Vertikāla izlīdzināšana',
    'width' => 'Platums',
    'height' => 'Augstums',
    'css_class' => 'Stils',
    'no_wrap' => 'Bez pārnesuma',
    'bg_color' => 'Fona krāsa',
    'background' => 'Fonu attēlošana', // <=== new 1.0.6
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
    'justifyleft' => 'Pa kreisi',
    'justifycenter' => 'Centrā',
    'justifyright' => 'Pa labi',
    'top' => 'No augšas',
    'bottom' => 'No lejas',
    'baseline' => 'Bāziska teksta līnija',
    'error' => 'Kļūda',
    'error_width_nan' => 'Platums nav skaitlis',
    'error_height_nan' => 'Augstums nav skaitlis',
    
  ),
  'table_row_insert' => array(
    'title' => 'Ielikt rindu'
  ),
  'table_column_insert' => array(
    'title' => 'Ielikt sleju'
  ),
  'table_row_delete' => array(
    'title' => 'Aizdabūt rindu'
  ),
  'table_column_delete' => array(
    'title' => 'Aizdabūt sleju'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Apvienot pa labi'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Apvienot pa kreisi'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Sadalīt pa horizontāli'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Sadalīt pa vertikāli'
  ),
  'style' => array(
    'title' => 'Stils'
  ),
  'fontname' => array(
    'title' => 'Šrifts'
  ),
  'fontsize' => array(
    'title' => 'Izmērs'
  ),
  'formatBlock' => array(
    'title' => 'Rindkopa'
  ),
  'bold' => array(
    'title' => 'Taukains'
  ),
  'italic' => array(
    'title' => 'Kursīvs'
  ),
  'underline' => array(
    'title' => 'Uzsvērts'
  ),
  'insertorderedlist' => array(
    'title' => 'Nokārtots saraksts'
  ),
  'insertunorderedlist' => array(
    'title' => 'Nenokārtots saraksts'
  ),
  'indent' => array(
    'title' => 'Palielināt atkāpi'
  ),
  'outdent' => array(
    'title' => 'Samazināt atkāpi'
  ),
  'justifyleft' => array(
    'title' => 'Izlīdzināšana pa kreisi'
  ),
  'justifycenter' => array(
    'title' => 'Izlīdzināšana pa centru'
  ),
  'justifyright' => array(
    'title' => 'Izlīdzināšana pa labi'
  ),
  'fore_color' => array(
    'title' => 'Teksta krāsa'
  ),
  'bg_color' => array(
    'title' => 'Fona krāsa'
  ),
  'design' => array(
    'title' => 'Pārslēgties maketēšanas režīmā (WYSIWYG)'
  ),
  'html' => array(
    'title' => 'Pārslēgties koda redakcijas režīmā (HTML)'
  ),
  'colorpicker' => array(
    'title' => 'Krāsas izvēle',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'cleanup' => array(
    'title' => 'HTML tīrīšana',
    'confirm' => 'Šī operācija aizvāks visus stilus, šriftus un nevajadzīgi tegi no redaktora tekošā satura. Daļa vai viss jūsu formatēšana var būt nozaudēts.',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'toggle_borders' => array(
    'title' => 'Iekļaut rāmīšus',
  ),
  'hyperlink' => array(
    'title' => 'Links',
    'url' => 'Adrese',
    'name' => 'Vārds',
    'target' => 'Atvērt',
    'title_attr' => 'Nosaukums',
	'a_type' => 'Tips', // <=== new 1.0.6
	'type_link' => 'Atsauce', // <=== new 1.0.6
	'type_anchor' => 'Enkurs', // <=== new 1.0.6
	'type_link2anchor' => 'links uz enkuru', // <=== new 1.0.6
	'anchors' => 'Enkuri', // <=== new 1.0.6
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => 'tas pats frejms (_self)',
	'_blank' => 'jaunā logā (_blank)',
	'_top' => 'uz visu logu (_top)',
	'_parent' => 'vecāku frejms (_parent)'
  ),
  'table_row_prop' => array(
    'title' => 'Rindas parametri',
    'horizontal_align' => 'Horizontāla izlīdzināšana',
    'vertical_align' => 'Vertikāla izlīdzināšana',
    'css_class' => 'Stils',
    'no_wrap' => 'Bez pārnesuma',
    'bg_color' => 'Fona krāsa',
    'ok' => '??????',
    'cancel' => 'Atcelt',
    'justifyleft' => 'Pa kreisi',
    'justifycenter' => 'Centrā',
    'justifyright' => 'Pa labi',
    'top' => 'No augšas',
    'middle' => 'Centrā',
    'bottom' => 'No lejas',
    'baseline' => 'Bāziska teksta līnija',
  ),
  'symbols' => array(
    'title' => 'Speciāli simboli',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'templates' => array(
    'title' => 'Šabloni',
  ),
  'page_prop' => array(
    'title' => 'Lapaspuses parametri',
    'title_tag' => 'Virsraksts',
    'charset' => 'Simbolu salikums',
    'background' => 'Fonu attēlošana',
    'bgcolor' => 'Fona krāsa',
    'text' => 'Teksta krāsa',
    'link' => 'Atsauču krāsa',
    'vlink' => 'Apmeklēto atsauču krāsa',
    'alink' => 'Aktīvu atsauču krāsa',
    'leftmargin' => 'Atkāpe pa kreisi',
    'topmargin' => 'Atkāpe no augšas',
    'css_class' => 'Stils',
    'ok' => 'GATAVS',
    'cancel' => 'Atcelt',
  ),
  'preview' => array(
    'title' => 'Iepriekšēja caurskatīšana',
  ),
  'image_popup' => array(
    'title' => 'Popup attēlošanas',
  ),
  'zoom' => array(
    'title' => 'Palielināšana',
  ),
  'subscript' => array( // <=== new 1.0.7
    'title' => 'Apakšējs indekss',
  ),
  'superscript' => array( // <=== new 1.0.7
    'title' => 'Augšējs indekss',
  ),
);
?>