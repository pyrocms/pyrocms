<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// English language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Translation to Norwegian (bokmål): Torkil Johnsen (torkil@torkiljohnsen.com)
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
    'title' => 'Klipp ut'
  ),
  'copy' => array(
    'title' => 'Kopier'
  ),
  'paste' => array(
    'title' => 'Lim inn'
  ),
  'undo' => array(
    'title' => 'Angre'
  ),
  'redo' => array(
    'title' => 'Gjenta'
  ),
  'hyperlink' => array(
    'title' => 'Hyperlenke'
  ),
  'image_insert' => array(
    'title' => 'Sett inn bilde',
    'select' => 'Velg',
    'cancel' => 'Avbryt',
    'library' => 'Bildearkiv',
    'preview' => 'Forhåndsvisning',
    'images' => 'Bilder',
    'upload' => 'Last opp bilde',
    'upload_button' => 'Last opp',
    'error' => 'Feil',
    'error_no_image' => 'Vennligst velg et bilde',
    'error_uploading' => 'En feil oppstod under opplasting av fil. Vennligst prøv igjen senere',
    'error_wrong_type' => 'Bilde har feil filtype',
    'error_no_dir' => 'Bildearkiv eksisterer ikke',
  ),
  'image_prop' => array(
    'title' => 'Bildeegenskaper',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
    'source' => 'Kilde',
    'alt' => 'Alternativ tekst',
    'align' => 'Justering',
    'justifyleft' => 'venstre',
    'justifyright' => 'høyre',
    'top' => 'topp',
    'middle' => 'midt',
    'bottom' => 'bunn',
    'absmiddle' => 'absmiddle',
    'texttop' => 'texttop',
    'baseline' => 'baseline',
    'width' => 'Bredde',
    'height' => 'Høyde',
    'border' => 'Kantlinje',
    'hspace' => 'Hor. mellomrom',
    'vspace' => 'Vert. mellomrom',
    'error' => 'Feil',
    'error_width_nan' => 'Bredde er ikke et tall',
    'error_height_nan' => 'Høyde er ikke et tall',
    'error_border_nan' => 'Kantlinje er ikke et tall',
    'error_hspace_nan' => 'Horisontalt mellomrom er ikke et tall',
    'error_vspace_nan' => 'Vertikalt mellomrom er ikke et tall',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Horisontal linje'
  ),
  'table_create' => array(
    'title' => 'Sett inn tabell'
  ),
  'table_prop' => array(
    'title' => 'Tabellegenskaper',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
    'rows' => 'Rader',
    'columns' => 'Kolonner',
    'width' => 'Bredde',
    'height' => 'Høyde',
    'border' => 'Kantlinje',
    'pixels' => 'pixels',
    'cellpadding' => 'Cellemarg',
    'cellspacing' => 'Celleavstand',
    'bg_color' => 'Bakgrunnsfarge',
    'error' => 'Feil',
    'error_rows_nan' => 'Rader er ikke et tall',
    'error_columns_nan' => 'Kolonner er ikke et tall',
    'error_width_nan' => 'Bredde er ikke et tall',
    'error_height_nan' => 'Høyde er ikke et tall',
    'error_border_nan' => 'Kantlinje er ikke et tall',
    'error_cellpadding_nan' => 'Cellemarg er ikke et tall',
    'error_cellspacing_nan' => 'Celleavstand er ikke et tall',
  ),
  'table_cell_prop' => array(
    'title' => 'Celleegenskaper',
    'horizontal_align' => 'Horisontal justering',
    'vertical_align' => 'Vertikal justering',
    'width' => 'Bredde',
    'height' => 'Høyde',
    'css_class' => 'CSS-klasse',
    'no_wrap' => 'Ingen linjebryting',
    'bg_color' => 'Bakgrunnsfarge',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
    'justifyleft' => 'Venstre',
    'justifycenter' => 'Midt',
    'justifyright' => 'Høyre',
    'top' => 'Topp',
    'middle' => 'Midt',
    'bottom' => 'Bunn',
    'baseline' => 'baseline',
    'error' => 'Feil',
    'error_width_nan' => 'Bredde er ikke et tall',
    'error_height_nan' => 'Høyde er ikke et tall',
  ),
  'table_row_insert' => array(
    'title' => 'Sett inn rad'
  ),
  'table_column_insert' => array(
    'title' => 'Sett inn kolonne'
  ),
  'table_row_delete' => array(
    'title' => 'Slett rad'
  ),
  'table_column_delete' => array(
    'title' => 'Slett kolonne'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Slå sammen mot høyre'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Slå sammen nedover'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Del celle horisontalt'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Del celle vertikalt'
  ),
  'style' => array(
    'title' => 'Stil'
  ),
  'fontname' => array(
    'title' => 'Font'
  ),
  'fontsize' => array(
    'title' => 'Størrelse'
  ),
  'formatBlock' => array(
    'title' => 'Avsnitt'
  ),
  'bold' => array(
    'title' => 'Fet'
  ),
  'italic' => array(
    'title' => 'Kursiv'
  ),
  'underline' => array(
    'title' => 'Understrekning'
  ),
  'insertorderedlist' => array(
    'title' => 'Sortert liste'
  ),
  'insertunorderedlist' => array(
    'title' => 'Usortert liste'
  ),
  'indent' => array(
    'title' => 'Øk innrykk'
  ),
  'outdent' => array(
    'title' => 'Reduser innrykk'
  ),
  'justifyleft' => array(
    'title' => 'Venstre'
  ),
  'justifycenter' => array(
    'title' => 'Midt'
  ),
  'justifyright' => array(
    'title' => 'Høyre'
  ),
  'fore_color' => array(
    'title' => 'Forgrunnsfarge'
  ),
  'bg_color' => array(
    'title' => 'Bakgrunnsfarge'
  ),
  'design' => array(
    'title' => 'Vis design'
  ),
  'html' => array(
    'title' => 'Vis kildekode'
  ),
  'colorpicker' => array(
    'title' => 'Fargevelger',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
  ),
  'cleanup' => array(
    'title' => 'HTML-opprenskning (fjerner stilformatteringer)',
    'confirm' => 'HTML-opprenskning vil fjerne alle stilformatteringer, fonter og overflødige oppmerkinger. Noen av eller alle dine formateringer kan forsvinne.',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
  ),
  'toggle_borders' => array(
    'title' => 'Vis/skjul kantlinjer',
  ),
  'hyperlink' => array(
    'title' => 'Hyperlenke',
    'url' => 'Adresse',
    'name' => 'Navn',
    'target' => 'Ramme',
    'title_attr' => 'Tittel',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
  ),
  'table_row_prop' => array(
    'title' => 'Radegenskaper',
    'horizontal_align' => 'Horisontal justering',
    'vertical_align' => 'Vertikal justering',
    'css_class' => 'CSS-klasse',
    'no_wrap' => 'Ingen linjebryting',
    'bg_color' => 'Bakgrunnsfarge',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
    'justifyleft' => 'Venstre',
    'justifycenter' => 'Midt',
    'justifyright' => 'Høyre',
    'top' => 'Topp',
    'middle' => 'Midt',
    'bottom' => 'Bunn',
    'baseline' => 'Baseline',
  ),
  'symbols' => array(
    'title' => 'Spesielle symboler',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
  ),
  'templates' => array(
    'title' => 'Maler',
  ),
  'page_prop' => array(
    'title' => 'Sideegenskaper',
    'title_tag' => 'Tittel',
    'charset' => 'Tegnsett',
    'background' => 'Bakgrunnsbilde',
    'bgcolor' => 'Bakgrunnsfarge',
    'text' => 'Tekstfarge',
    'link' => 'Farge på lenke',
    'vlink' => 'Farge på besøkt lenke',
    'alink' => 'Farge på aktiv lenke',
    'leftmargin' => 'Venstremarg',
    'topmargin' => 'Toppmarg',
    'css_class' => 'CSS-klasse',
    'ok' => '   OK   ',
    'cancel' => 'Avbryt',
  ),
  'preview' => array(
    'title' => 'Forhåndsvisning',
  ),
  'image_popup' => array(
    'title' => 'Bilde-popup',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
);
?>