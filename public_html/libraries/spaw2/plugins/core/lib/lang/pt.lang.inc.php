<?php 
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Portuguese language file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Brazilian Translation: Fernando José Karl, 
//                        fernandokarl@superig.com.br
// European Portuguese version: Ricardo Vidal
//                              rick@vidric.com
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2003-04-29
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
    'title' => 'Colar'
  ),
  'undo' => array(
    'title' => 'Desfazer'
  ),
  'redo' => array(
    'title' => 'Refazer'
  ),
  'hyperlink' => array(
    'title' => 'Hiperligação'
  ),
  'image_insert' => array(
    'title' => 'Inserir imagem',
    'select' => 'Seleccionar',
    'cancel' => 'Cancelar',
    'library' => 'Biblioteca',
    'preview' => 'Pré-visualização',
    'images' => 'Imagens',
    'upload' => 'Enviar imagem',
    'upload_button' => 'Upload',
    'error' => 'Erro',
    'error_no_image' => 'Por favor, seleccione uma imagem',
    'error_uploading' => 'Ocorreu um erro no envio do arquivo. Por favor, tente novamente',
    'error_wrong_type' => 'Tipo de arquivo de imagem inválido',
    'error_no_dir' => 'A bilbioteca não existe fisicamente',
  ),
  'image_prop' => array(
    'title' => 'Propriedades da imagem',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'source' => 'Fonte',
    'alt' => 'Texto alternativo',
    'align' => 'Alinhamento',
    'justifyleft' => 'esquerda',
    'justifyright' => 'direita',
    'top' => 'superior',
    'middle' => 'meio',
    'bottom' => 'inferior',
    'absmiddle' => 'Meio absoluto',
    'texttop' => 'Topo do texto',
    'baseline' => 'Base',
    'width' => 'Comprimento',
    'height' => 'Altura',
    'border' => 'Borda',
    'hspace' => 'Espaço hor.',
    'vspace' => 'Espaço vert.',
    'error' => 'Erro',
    'error_width_nan' => 'Comprimento não é um número',
    'error_height_nan' => 'Altura não é um número',
    'error_border_nan' => 'Borda não é um número',
    'error_hspace_nan' => 'Espaço horizontal não é um número',
    'error_vspace_nan' => 'Espaço vertical não é um número',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Linha horizontal'
  ),
  'table_create' => array(
    'title' => 'Criar tabela'
  ),
  'table_prop' => array(
    'title' => 'Propriedades da tabela',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'rows' => 'Linhas',
    'columns' => 'Colunas',
    'width' => 'Comprimento',
    'height' => 'Altura',
    'border' => 'Borda',
    'pixels' => 'pixeis',
    'cellpadding' => 'Espaço dentro das células',
    'cellspacing' => 'Espaço entre células',
    'bg_color' => 'Cor de Fundo',
    'error' => 'Erro',
    'error_rows_nan' => 'Linhas não é um número',
    'error_columns_nan' => 'Colunas não é um número',
    'error_width_nan' => 'Comprimento não é um número',
    'error_height_nan' => 'Altura não é um número',
    'error_border_nan' => 'Borda não é um número',
    'error_cellpadding_nan' => 'Espaço dentro das células não é um número',
    'error_cellspacing_nan' => 'Espaço entre células não é um número',
  ),
  'table_cell_prop' => array(
    'title' => 'Propriedades da célula',
    'horizontal_align' => 'Alinh. horizontal',
    'vertical_align' => 'Alinh. vertical',
    'width' => 'Comprimento',
    'height' => 'Altura',
    'css_class' => 'Classe CSS',
    'no_wrap' => 'Sem quebras',
    'bg_color' => 'Cor de fundo',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'justifyleft' => 'Esquerda',
    'justifycenter' => 'Centrado',
    'justifyright' => 'Direita',
    'top' => 'Superior',
    'middle' => 'Meio',
    'bottom' => 'Inferior',
    'baseline' => 'Base',
    'error' => 'Erro',
    'error_width_nan' => 'Comprimento não é um número',
    'error_height_nan' => 'Altura não é um número',
    
  ),
  'table_row_insert' => array(
    'title' => 'Inserir linha'
  ),
  'table_column_insert' => array(
    'title' => 'Inserir coluna'
  ),
  'table_row_delete' => array(
    'title' => 'Apagar linha'
  ),
  'table_column_delete' => array(
    'title' => 'Apagar coluna'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Unir direita'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Unir abaixo'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Dividir células horizontalmente'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Dividir células verticalmente'
  ),
  'style' => array(
    'title' => 'Estilo'
  ),
  'fontname' => array(
    'title' => 'Fonte'
  ),
  'fontsize' => array(
    'title' => 'Tamanho'
  ),
  'formatBlock' => array(
    'title' => 'Parágrafo'
  ),
  'bold' => array(
    'title' => 'Negrito'
  ),
  'italic' => array(
    'title' => 'Itálico'
  ),
  'underline' => array(
    'title' => 'Sublinhado'
  ),
  'insertorderedlist' => array(
    'title' => 'Numeração'
  ),
  'insertunorderedlist' => array(
    'title' => 'Marcadores'
  ),
  'indent' => array(
    'title' => 'Aumentar Recuo'
  ),
  'outdent' => array(
    'title' => 'Diminuir Recuo'
  ),
  'justifyleft' => array(
    'title' => 'Esquerda'
  ),
  'justifycenter' => array(
    'title' => 'Centralizado'
  ),
  'justifyright' => array(
    'title' => 'Direita'
  ),
  'fore_color' => array(
    'title' => 'Realçar'
  ),
  'bg_color' => array(
    'title' => 'Cor de fundo'
  ),
  'design' => array(
    'title' => 'Mudar para modo WYSIWYG (design)'
  ),
  'html' => array(
    'title' => 'Mudar para modo HTML (código)'
  ),
  'colorpicker' => array(
    'title' => 'Selector de cores',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  // <<<<<<<<<< NEW >>>>>>>>>>>>>>>
  'cleanup' => array(
    'title' => 'Limpeza HTML (remover estilos)',
    'confirm' => 'Ao realizar esta acção vai remover todos estilos, fontes e tags inúteis do conteúdo. Alguma ou toda a formatação poderá ser perdida.',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'toggle_borders' => array(
    'title' => 'Accionar borda',
  ),
  'hyperlink' => array(
    'title' => 'Hiperligação',
    'url' => 'URL',
    'name' => 'Nome',
    'target' => 'Alvo',
    'title_attr' => 'Título',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'table_row_prop' => array(
    'title' => 'Propriedades da linha',
    'horizontal_align' => 'Alinhamento horizontal',
    'vertical_align' => 'Alinhamento vertical',
    'css_class' => 'Classe CSS',
    'no_wrap' => 'Sem quebras',
    'bg_color' => 'Cor de Fundo',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'justifyleft' => 'Esquerda',
    'justifycenter' => 'Center',
    'justifyright' => 'Direita',
    'top' => 'Topo',
    'middle' => 'Meio',
    'bottom' => 'Inferior',
    'baseline' => 'Base',
  ),
  'symbols' => array(
    'title' => 'Caracteres especiais',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'templates' => array(
    'title' => 'Modelos',
  ),
  'page_prop' => array(
    'title' => 'Propriedades da página',
    'title_tag' => 'Título',
    'charset' => 'Conjunto Caracteres',
    'background' => 'Imagem de Fundo',
    'bgcolor' => 'Cor de Fundo',
    'text' => 'Cor texto',
    'link' => 'Cor link',
    'vlink' => 'Cor link visitados',
    'alink' => 'Cor link activo',
    'leftmargin' => 'Margem esquerda',
    'topmargin' => 'Margem topo',
    'css_class' => 'Classe CSS',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'preview' => array(
    'title' => 'Pré-visualização',
  ),
  'image_popup' => array(
    'title' => 'Imagem popup',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
);
?>