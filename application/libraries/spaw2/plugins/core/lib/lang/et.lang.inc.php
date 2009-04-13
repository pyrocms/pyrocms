<?php
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// English language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Estonian translation: Maku, maktak@phpnuke-est.net
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
    'title' => 'Lõike'
  ),
  'copy' => array(
    'title' => 'Kopeeri'
  ),
  'paste' => array(
    'title' => 'Kleebi'
  ),
  'undo' => array(
    'title' => 'Samm Tagasi'
  ),
  'redo' => array(
    'title' => 'Samm Edasi'
  ),
  'hyperlink' => array(
    'title' => 'Hüperlink'
  ),
  'image_insert' => array(
    'title' => 'Lisa Pilt',
    'select' => 'Vali',
    'cancel' => 'Loobu',
    'library' => 'Teek',
    'preview' => 'Eelvaade',
    'images' => 'Pildid',
    'upload' => 'Pildi üleslaadimine',
    'upload_button' => 'Üleslaadimine',
    'error' => 'Viga',
    'error_no_image' => 'Palun valige pilt',
    'error_uploading' => 'Viga faili üleslaadimisega. Proovige hiljem uuesti',
    'error_wrong_type' => 'Valge pildi failitüüp',
    'error_no_dir' => 'Teek ei eksisteeri füüsiliselt',
  ),
  'image_prop' => array(
    'title' => 'Pildi Seaded',
    'ok' => '   OK   ',
    'cancel' => 'Loobu',
    'source' => 'Lähe',
    'alt' => 'Alternatiivne Tekst',
    'align' => 'Joondamine',
    'justifyleft' => 'vasak',
    'justifyright' => 'parem',
    'top' => 'ülal',
    'middle' => 'keskel',
    'bottom' => 'põhjas',
    'absmiddle' => 'absmiddle',
    'texttop' => 'texttop',
    'baseline' => 'äärejoon',
    'width' => 'Laius',
    'height' => 'Kõrgus',
    'border' => 'Serv',
    'hspace' => 'Hor. vahe',
    'vspace' => 'Vert. vahe',
    'error' => 'Viga',
    'error_width_nan' => 'Laius ei ole number',
    'error_height_nan' => 'Kõrgus ei ole number',
    'error_border_nan' => 'Serv ei ole number',
    'error_hspace_nan' => 'Horisontaalide vahe ei ole number',
    'error_vspace_nan' => 'Vertikaalide vahe ei ole number',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Horisontaalide Reegel'
  ),
  'table_create' => array(
    'title' => 'Loo tabel'
  ),
  'table_prop' => array(
    'title' => 'Tabeli seaded',
    'ok' => '   OK   ',
    'cancel' => 'Loobu',
    'rows' => 'Ridu',
    'columns' => 'Tulpi',
    'width' => 'Laius',
    'height' => 'Kõrgus',
    'border' => 'Serv',
    'pixels' => 'pikselit',
    'cellpadding' => 'Elemendi polsterdus',
    'cellspacing' => 'Elementide vahe',
    'bg_color' => 'Taustavärv',
    'error' => 'Viga',
    'error_rows_nan' => 'Ridade arv ei ole number',
    'error_columns_nan' => 'Tulpade arv ei ole number',
    'error_width_nan' => 'Laius ei ole number',
    'error_height_nan' => 'Kõrgus ei ole number',
    'error_border_nan' => 'Serv ei ole number',
    'error_cellpadding_nan' => 'Elemendi polsterdus ei ole number',
    'error_cellspacing_nan' => 'Elementide vahe ei ole number',
  ),
  'table_cell_prop' => array(
    'title' => 'Elemendi seaded',
    'horizontal_align' => 'Horisontaalne joondamine',
    'vertical_align' => 'Vertikaalne joondamine',
    'width' => 'Laius',
    'height' => 'Kõrgus',
    'css_class' => 'CSS klass',
    'no_wrap' => 'Mähkimine väljas',
    'bg_color' => 'Tausta värv',
    'ok' => '   OK   ',
    'cancel' => 'Loobu',
    'justifyleft' => 'Vasakul',
    'justifycenter' => 'Keskel',
    'justifyright' => 'Paremal',
    'top' => 'Ülal',
    'middle' => 'Keskel',
    'bottom' => 'Põhjas',
    'baseline' => 'Äärejoon',
    'error' => 'Viga',
    'error_width_nan' => 'Laius ei ole number',
    'error_height_nan' => 'Kõrgus ei ole number',
  ),
  'table_row_insert' => array(
    'title' => 'Lisa rida'
  ),
  'table_column_insert' => array(
    'title' => 'Lisa tulp'
  ),
  'table_row_delete' => array(
    'title' => 'Kustuta rida'
  ),
  'table_column_delete' => array(
    'title' => 'Kustuta tulp'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Sulandu/Ühine paremale'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Sulandu/Ühine alla'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Poolita element horisontaalselt'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Poolita element vertikaalselt'
  ),
  'style' => array(
    'title' => 'Stiil'
  ),
  'fontname' => array(
    'title' => 'Kirjastiil'
  ),
  'fontsize' => array(
    'title' => 'Suurus'
  ),
  'formatBlock' => array(
    'title' => 'Paragrahv'
  ),
  'bold' => array(
    'title' => 'Rasvane'
  ),
  'italic' => array(
    'title' => 'Kaldkiri'
  ),
  'underline' => array(
    'title' => 'Allajoonitud'
  ),
  'insertorderedlist' => array(
    'title' => 'Korrapärane Nimekiri'
  ),
  'insertunorderedlist' => array(
    'title' => 'Täppidega Nimekiri'
  ),
  'indent' => array(
    'title' => 'Süvendatud'
  ),
  'outdent' => array(
    'title' => 'Süvendamata'
  ),
  'justifyleft' => array(
    'title' => 'Vasakul'
  ),
  'justifycenter' => array(
    'title' => 'Keskel'
  ),
  'justifyright' => array(
    'title' => 'Paremal'
  ),
  'fore_color' => array(
    'title' => 'Pealmine värv'
  ),
  'bg_color' => array(
    'title' => 'Tausta värv'
  ),
  'design' => array(
    'title' => 'Lülitu WYSIWYG (kujundus) moodi'
  ),
  'html' => array(
    'title' => 'Lülitu HTML (kood) moodi'
  ),
  'colorpicker' => array(
    'title' => 'Värvivalija',
    'ok' => '   OK   ',
    'cancel' => 'Loobu',
  ),
  'cleanup' => array(
    'title' => 'HTML puhastamine (eemaldab stiilid)',
    'confirm' => 'Selle tegemine eemaldab stiilid, kirjastiilid ja ebavajalikud tag-id, mõned või kõik vormindused võivad kaotsi minna.',
    'ok' => '   OK   ',
    'cancel' => 'Loobu',
  ),
  'toggle_borders' => array(
    'title' => 'Servad',
  ),
  'hyperlink' => array(
    'title' => 'Hüperlink',
    'url' => 'URL',
    'name' => 'Nimi',
    'target' => 'Sihtmärk',
    'title_attr' => 'Tiitel',
    'ok' => '   OK   ',
    'cancel' => 'Loobu',
  ),
  'table_row_prop' => array(
    'title' => 'Rea seaded',
    'horizontal_align' => 'Horisontaalne joondamine',
    'vertical_align' => 'Vertikaalne joondamine',
    'css_class' => 'CSS klass',
    'no_wrap' => 'Mähkimine väljas',
    'bg_color' => 'Tausta värv',
    'ok' => '   OK   ',
    'cancel' => 'Loobu',
    'justifyleft' => 'Vasakul',
    'justifycenter' => 'Keskel',
    'justifyright' => 'Paremal',
    'top' => 'Ülal',
    'middle' => 'Keskel',
    'bottom' => 'Põhjas',
    'baseline' => 'Äärejoon',
  ),
  'symbols' => array(
    'title' => 'Spetsiaalsed tähemärgid',
    'ok' => '   OK   ',
    'cancel' => 'Loobu',
  ),
  'templates' => array(
    'title' => 'Mallid',
  ),
  'page_prop' => array(
    'title' => 'Lehe seaded',
    'title_tag' => 'Tiitel',
    'charset' => 'Märgistik',
    'background' => 'Taustapilt',
    'bgcolor' => 'Taustavärv',
    'text' => 'Teksti värv',
    'link' => 'Lingi värv',
    'vlink' => 'Külastatud lingi värv',
    'alink' => 'Aktiivse lingi värv',
    'leftmargin' => 'Piiraja Vasemal',
    'topmargin' => 'Piiraja Ülal',
    'css_class' => 'CSS klass',
    'ok' => '   OK   ',
    'cancel' => 'Loobu',
  ),
  'preview' => array(
    'title' => 'Eelvaade',
  ),
  'image_popup' => array(
    'title' => 'Pildi popup',
  ),
  'zoom' => array(
    'title' => 'Suurendus',
  ),
);
?>