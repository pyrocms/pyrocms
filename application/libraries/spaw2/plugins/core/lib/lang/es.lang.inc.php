<?php
// ================================================
// SPAW v.2.0
// ================================================
// Spanish language file <!--%TimeStamp%-->3/17/2007 11:42 PM<!---->
// ================================================
// Author: Alan Mendelevich, UAB Solmetra
// Spanish translation: Martin Perez (martinp@intersys.com.uy)
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
    'title' => 'Cortar'
  ),
  'copy' => array(
    'title' => 'Copiar'
  ),
  'paste' => array(
    'title' => 'Pegar'
  ),
  'undo' => array(
    'title' => 'Deshacer'
  ),
  'redo' => array(
    'title' => 'Rehacer'
  ),
  'image_prop' => array(
    'title' => 'Propiedades de la imagen',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'source' => 'C&oacute;digo',
    'alt' => 'Texto alternative ',
    'align' => 'Alineaci&oacute;n',
    'left' => 'izquierda',
    'right' => 'derecha',
    'top' => 'superior',
    'middle' => 'medio',
    'bottom' => 'inferior',
    'absmiddle' => 'medio absoluto',
    'texttop' => 'Texto superior',
    'baseline' => 'L&iacute;nea base',
    'width' => 'Ancho',
    'height' => 'Alto',
    'border' => 'Borde',
    'hspace' => 'Espacio hor.',
    'vspace' => 'Espacio vert.',
    'dimensions' => 'Dimensiones', // <= new in 2.0.1
    'reset_dimensions' => 'Restablecer dimensiones', // <= new in 2.0.1
    'title_attr' => 'Title', // <= new in 2.0.1
    'constrain_proportions' => 'Reduucir proporciones', // <= new in 2.0.1
    'error' => 'Error',
    'error_width_nan' => 'El ancho debe ser un n&uacute;mero',
    'error_height_nan' => 'La altura debe ser un n&uacute;mero',
    'error_border_nan' => 'El borde debe ser un n&uacute;mero',
    'error_hspace_nan' => 'El espaciado horizontal debe ser un n&uacute;mero',
    'error_vspace_nan' => 'El espaciado vertical debe ser un n&uacute;mero',
  ),
  'flash_prop' => array(                // <= new in 2.0
    'title' => 'Flash',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'source' => 'C&oacute;digo',
    'width' => 'Ancho',
    'height' => 'Alto',
    'error' => 'Error',
    'error_width_nan' => 'El ancho debe ser un n&uacute;mero',
    'error_height_nan' => 'La altura debe ser un n&uacute;mero',
  ),
  'inserthorizontalrule' => array( // <== v.2.0 changed from hr
    'title' => 'L&iacute;nea horizontal'
  ),
  'table_create' => array(
    'title' => 'Crear tabla'
  ),
  'table_prop' => array(
    'title' => 'Propiedades de la tabla',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'rows' => 'Filas',
    'columns' => 'Columnas',
    'css_class' => 'Estilo CSS',
    'width' => 'Ancho',
    'height' => 'Alto',
    'border' => 'Borde',
    'pixels' => 'pixeles',
    'cellpadding' => 'Margen de las celdas',
    'cellspacing' => 'Espacio entre celdas',
    'bg_color' => 'Color de fondo',
    'background' => 'Imagen de fondo',
    'error' => 'Error',
    'error_rows_nan' => 'Filas debe ser un n&uacute;mero',
    'error_columns_nan' => 'Columnas debe ser un n&uacute;mero',
    'error_width_nan' => 'Ancho debe ser un n&uacute;mero',
    'error_height_nan' => 'Alto debe ser un n&uacute;mero',
    'error_border_nan' => 'Borde debe ser un n&uacute;mero',
    'error_cellpadding_nan' => 'Margen de celdas debe ser un n&uacute;mero',
    'error_cellspacing_nan' => 'Espacio entre celdas debe ser un n&uacute;mero',
  ),
  'table_cell_prop' => array(
    'title' => 'Propiedades de la celda',
    'horizontal_align' => 'Alineaci&oacute;n horizontal',
    'vertical_align' => 'Alineaci&oacute;n vertical',
    'width' => 'Ancho',
    'height' => 'Alto',
    'css_class' => 'Estilo CSS',
    'no_wrap' => 'No dividir l&iacute;neas',
    'bg_color' => 'Color de fondo',
    'background' => 'Image de fondo',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'left' => 'Izquierda',
    'center' => 'Centro',
    'right' => 'Derecha',
    'top' => 'Superior',
    'middle' => 'Medio',
    'bottom' => 'Inferior',
    'baseline' => 'L&iacute;nea base',
    'error' => 'Error',
    'error_width_nan' => 'Ancho debe ser un n&uacute;mero',
    'error_height_nan' => 'Alto debe ser un n&uacute;mero',
  ),
  'table_row_insert' => array(
    'title' => 'Insertar fila'
  ),
  'table_column_insert' => array(
    'title' => 'Insertar columna'
  ),
  'table_row_delete' => array(
    'title' => 'Borrar fila'
  ),
  'table_column_delete' => array(
    'title' => 'Borrar columna'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Combinar con la celda de la derecha'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Combinar con la celda de abajo'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Dividir celdas horizontalmente'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Dividir celdas verticalmente'
  ),
  'style' => array(
    'title' => 'Estilo'
  ),
  'fontname' => array( // <== v.2.0 changed from font
    'title' => 'Fuente'
  ),
  'fontsize' => array(
    'title' => 'Tama&ntilde;o'
  ),
  'formatBlock' => array( // <= v.2.0: changed from paragraph
    'title' => 'P&aacute;rrafo'
  ),
  'bold' => array(
    'title' => 'Negrita'
  ),
  'italic' => array(
    'title' => 'Cursiva'
  ),
  'underline' => array(
    'title' => 'Subrayado'
  ),
  'strikethrough' => array(
    'title' => 'Rayado al medio'
  ),
  'insertorderedlist' => array( // <== v.2.0 changed from ordered_list
    'title' => 'Lista ordenada'
  ),
  'insertunorderedlist' => array( // <== v.2.0 changed from bulleted list
    'title' => 'Lista con vi&ntilde;etas'
  ),
  'indent' => array(
    'title' => 'Sangria'
  ),
  'outdent' => array( // <== v.2.0 changed from unindent
    'title' => 'Anular sangria'
  ),
  'justifyleft' => array( // <== v.2.0 changed from left
    'title' => 'Izquierda'
  ),
  'justifycenter' => array( // <== v.2.0 changed from center
    'title' => 'Centro'
  ),
  'justifyright' => array( // <== v.2.0 changed from right
    'title' => 'Derecha'
  ),
  'justifyfull' => array( // <== v.2.0 changed from justify
    'title' => 'Justificado'
  ),
  'fore_color' => array(
    'title' => 'Color de la letra'
  ),
  'bg_color' => array(
    'title' => 'Color de fondo'
  ),
  'design' => array( // <== v.2.0 changed from design_tab
    'title' => 'Cambiar a modo WYSIWYG (dise&ntilde;o)'
  ),
  'html' => array( // <== v.2.0 changed from html_tab
    'title' => 'Cambiar a modo HTML (c&oacute;digo)'
  ),
  'colorpicker' => array(
    'title' => 'Seleccionar color',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'cleanup' => array(
    'title' => 'Limipiador de HTML (borra los estilos)',
    'confirm' => 'Con esta acci&oacute;n se borrar&aacute;n todos los estilos, tipos de letra y tags menos utilizados. Algunas caracter&iacute;sticas de tu formato pueden desaparecer.',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'toggle_borders' => array(
    'title' => 'Cambiar Bordes',
  ),
  'hyperlink' => array(
    'title' => 'Hiperv&iacute;nculo',
    'url' => 'URL',
    'name' => 'Nombre',
    'target' => 'Destino',
    'title_attr' => 'T&iacute;tulo',
  	'a_type' => 'Tipo',
  	'type_link' => 'Enlace',
  	'type_anchor' => 'Marcador',
  	'type_link2anchor' => 'Enlace a marcador',
  	'anchors' => 'Marcadores',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'hyperlink_targets' => array(
  	'_self' => 'Mismo marco (_self)',
  	'_blank' => 'Nueva ventana (_blank)',
  	'_top' => 'Marco superior (_top)',
  	'_parent' => 'Marco pariente (_parent)'
  ),
  'unlink' => array( // <=== new v.2.0
    'title' => 'Quitar Hiperv&iacute;nculo'
  ),
  'table_row_prop' => array(
    'title' => 'Propiedades de la fila',
    'horizontal_align' => 'Alineaci&oacute;n horizontal',
    'vertical_align' => 'Alineaci&oacute;n vertical',
    'css_class' => 'Estilo CSS',
    'no_wrap' => 'No dividir l&iacute;neas',
    'bg_color' => 'Ccolor de fondo',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'left' => 'Izquierda',
    'center' => 'Centro',
    'right' => 'Derecha',
    'top' => 'Superior',
    'middle' => 'Medio',
    'bottom' => 'Inferior',
    'baseline' => 'L&iacute;nea de base',
  ),
  'symbols' => array(
    'title' => 'Caracteres especiales',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'templates' => array(
    'title' => 'Plantillas',
  ),
  'page_prop' => array(
    'title' => 'Propiedades de la p&aacute;gina',
    'title_tag' => 'T&iacute;tulo',
    'charset' => 'Juego de caracteres',
    'background' => 'Imagen de fondo',
    'bgcolor' => 'Color de fondo',
    'text' => 'Color del texto',
    'link' => 'Color de enlaces',
    'vlink' => 'Color de enlace visitado',
    'alink' => 'Color del enlace activo',
    'leftmargin' => 'Margen izquierdo',
    'topmargin' => 'Margen superior',
    'css_class' => 'Estilo CSS',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'preview' => array(
    'title' => 'Previsualizar',
  ),
  'image_popup' => array(
    'title' => 'Ventana de Imagen',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
  'subscript' => array(
    'title' => 'Sub&iacute;ndice',
  ),
  'superscript' => array(
    'title' => 'Super&iacute;ndice',
  ),
);
?>
