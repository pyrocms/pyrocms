<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Catalan language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Catalan translation: Jordi Catà (jordi.cata@jc-solutions.net)
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
    'title' => 'Tallar'
  ),
  'copy' => array(
    'title' => 'Copiar'
  ),
  'paste' => array(
    'title' => 'Enganxar'
  ),
  'undo' => array(
    'title' => 'Desfer'
  ),
  'redo' => array(
    'title' => 'Refer'
  ),
  'hyperlink' => array(
    'title' => 'Enllaç'
  ),
  'image_insert' => array(
    'title' => 'Afegir imatge',
    'select' => 'Seleccionar',
    'cancel' => 'Cancelar',
    'library' => 'Llibreria',
    'preview' => 'Previsualitzar',
    'images' => 'Imatges',
    'upload' => 'Pujar imatge',
    'upload_button' => 'Pujar',
    'error' => 'Error',
    'error_no_image' => 'Si us plau, selecciona una imatge',
    'error_uploading' => 'Hi ha hagut un error al pujar la imatge, intenta-ho de nou',
    'error_wrong_type' => 'Tipus de imatge incorrecte.',
    'error_no_dir' => 'La llibreria no existeix', 
  ),
  'image_prop' => array(
    'title' => 'Propietats de la imatge',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'source' => 'Codi',
    'alt' => 'text alternatiu',
    'align' => 'Alineació',
    'justifyleft' => 'esquerra',
    'justifyright' => 'dreta',
    'top' => 'superior',
    'middle' => 'mitg',
    'bottom' => 'inferior',
    'absmiddle' => 'mitg absolut',
    'texttop' => 'text superior',
    'baseline' => 'Linea Base',
    'width' => 'ample',
    'height' => 'Alçada',
    'border' => 'Contorn',
    'hspace' => 'Espai hor.',
    'vspace' => 'Espaco vert.',
    'error' => 'Error',
    'error_width_nan' => 'la alçada ha de ser un número',
    'error_height_nan' => 'el ample ha de ser un número',
    'error_border_nan' => 'el contorn ha de ser un número',
    'error_hspace_nan' => 'el espaiat horizontal ha de ser un número',
    'error_vspace_nan' => 'el espaiat vertical ha de ser un número',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Línia horizontal'
  ),
  'table_create' => array(
    'title' => 'Crear taula'
  ),
  'table_prop' => array(
    'title' => 'Propietats de la taula',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'rows' => 'Files',
    'columns' => 'Columnes',
    'width' => 'Ample',
    'height' => 'Alçada',
    'border' => 'Contorn',
    'pixels' => 'pixels', 
    'cellpadding' => 'Contorn de les celes',
    'cellspacing' => 'Espai entre celes',
    'bg_color' => 'Color de fons',
    'error' => 'Error',
    'error_rows_nan' => 'Files ha de ser un número',
    'error_columns_nan' => 'Columnes ha de ser un número',
    'error_width_nan' => 'Ample ha de ser un número',
    'error_height_nan' => 'Alçada ha de ser un número',
    'error_border_nan' => 'Contorn ha de ser un número',
    'error_cellpadding_nan' => 'Relleno ha de ser un número',
    'error_cellspacing_nan' => 'Espaiat ha de ser un número',
  ),
  'table_cell_prop' => array(
    'title' => 'Propietats de la cela',
    'horizontal_align' => 'Alineació horizontal',
    'vertical_align' => 'Alineació vertical',
    'width' => 'Ample',
    'height' => 'Alçada',
    'css_class' => 'Estil CSS',
    'no_wrap' => 'No Dividir Linees',
    'bg_color' => 'Color de fons',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'justifyleft' => 'Esquerra',
    'justifycenter' => 'Centre',
    'justifyright' => 'Dreta',
    'top' => 'Sobre',
    'middle' => 'mitg',
    'bottom' => 'Sota',
    'baseline' => 'Línea Base',
    'error' => 'Error',
    'error_width_nan' => 'Ample ha de ser un número',
    'error_height_nan' => 'Alçada ha de ser un número',
    
  ),
  'table_row_insert' => array(
    'title' => 'Insertar fila'
  ),
  'table_column_insert' => array(
    'title' => 'Insertar columna'
  ),
  'table_row_delete' => array(
    'title' => 'Esborrar fila'
  ),
  'table_column_delete' => array(
    'title' => 'Esborrar columna'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Combinar amb la cela de la dreta'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Combinar amb la cela de asota'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Dividir celes horizontalment'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Dividir celes verticalment'
  ),
  'style' => array(
    'title' => 'Estil'
  ),
  'fontname' => array(
    'title' => 'Font'
  ),
  'fontsize' => array(
    'title' => 'Mida'
  ),
  'formatBlock' => array(
    'title' => 'Paràgraf'
  ),
  'bold' => array(
    'title' => 'Negreta'
  ),
  'italic' => array(
    'title' => 'Cursiva'
  ),
  'underline' => array(
    'title' => 'Subratllat'
  ),
  'insertorderedlist' => array(
    'title' => 'Llista ordenada'
  ),
  'insertunorderedlist' => array(
    'title' => 'Llista amb marca'
  ),
  'indent' => array(
    'title' => 'Sangria'
  ),
  'outdent' => array(
    'title' => 'Anular sangria'
  ),
  'justifyleft' => array(
    'title' => 'Esquerra'
  ),
  'justifycenter' => array(
    'title' => 'Centre'
  ),
  'justifyright' => array(
    'title' => 'Dreta'
  ),
  'fore_color' => array(
    'title' => 'Color de la lletra'
  ),
  'bg_color' => array(
    'title' => 'Color de fons'
  ),
  'design' => array(
    'title' => 'Cambiar a mode WYSIWYG (diseny)'
  ),
  'html' => array(
    'title' => 'Cambiar a mode HTML (codi)'
  ),
  'colorpicker' => array(
    'title' => 'Selecciona color',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  // <<<<<<<<< NEW >>>>>>>>>
  'cleanup' => array(
    'title' => 'Esborrar HTML (esborra els estils)',
    'confirm' => 'Amb aquesta acció s\'esborraran tots els estils, tipus de lletra i tags menys utilizats. Algunes característiques del teu format poden desapareixer.',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'toggle_borders' => array(
    'title' => 'Cambiar Contorn',
  ),
  'hyperlink' => array(
    'title' => 'Enllaç',
    'url' => 'URL',
    'name' => 'Nom',
    'target' => 'Destí',
    'title_attr' => 'Títol',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'table_row_prop' => array(
    'title' => 'Propietats de la fila',
    'horizontal_align' => 'Alineació horizontal',
    'vertical_align' => 'Alineació vertical',
    'css_class' => 'Classe CSS',
    'no_wrap' => 'Sense separació',
    'bg_color' => 'Color de fons',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'justifyleft' => 'Esquerra',
    'justifycenter' => 'Centre',
    'justifyright' => 'Dreta',
    'top' => 'A sobre',
    'middle' => 'Al mitg',
    'bottom' => 'A sota',
    'baseline' => 'Línea de Base',
  ),
  'symbols' => array(
    'title' => 'caràcters especials',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'templates' => array(
    'title' => 'Plantilles',
  ),
  'page_prop' => array(
    'title' => 'Propietats de la pàgina',
    'title_tag' => 'Títol',
    'charset' => 'Joc de caràcters',
    'background' => 'Imatge de fons',
    'bgcolor' => 'Color de fons',
    'text' => 'Color text',
    'link' => 'Color enllaç',
    'vlink' => 'Color enllaç visitat',
    'alink' => 'Color enllaç activat',
    'leftmargin' => 'Marge esquerra',
    'topmargin' => 'Marge superior',
    'css_class' => 'Clase CSS',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'preview' => array(
    'title' => 'Previsualitzar',
  ),
  'image_popup' => array(
    'title' => 'Finestra de imatge',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
);
?>