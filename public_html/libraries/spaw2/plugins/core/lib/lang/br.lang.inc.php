<?php
// ================================================
// SPAW v.2.0
// ================================================
// Brazilian Portuguese language file
// ================================================
// Author: Alessandro Gambin da Silva
// ------------------------------------------------
//                   www.php.net - www.solmetra.com
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
    'title' => 'Recortar'
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
  'image' => array(
    'title' => 'Inserir imagem rapidamente'
  ),
  'image_prop' => array(
    'title' => 'Imagem',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'source' => 'Fonte',
    'alt' => 'Texto alternativo',
    'align' => 'Alinhamento',
    'left' => 'esquerda',
    'right' => 'direita',
    'top' => 'superior',
    'middle' => 'meio',
    'bottom' => 'Inferior',
    'absmiddle' => 'meio absoluto',
    'texttop' => 'topo do texto',
    'baseline' => 'linha-base',
    'width' => 'Largura',
    'height' => 'Altura',
    'border' => 'Borda',
    'hspace' => 'Espa&ccedil;o horizontal',
    'vspace' => 'Espa&ccedil;o vertical',
    'dimensions' => 'Dimens&otilde;es', // <= new in 2.0.1
    'reset_dimensions' => 'Restaurar dimens&otilde;es', // <= new in 2.0.1
    'title_attr' => 'T&iacute;tulo', // <= new in 2.0.1
    'constrain_proportions' => 'Restringir propor&ccedil;&otilde;es', // <= new in 2.0.1
    'error' => 'Erro',
    'error_width_nan' => 'Largura n&atilde;o &eacute; um n&uacte;mero',
    'error_height_nan' => 'Altura n&atilde;o &eacute; um n&uacte;mero',
    'error_border_nan' => 'Borda n&atilde;o &eacute; um n&uacte;mero',
    'error_hspace_nan' => 'Espa&ccedil;o horizontal n&atilde;o &eacute; um n&uacte;mero',
    'error_vspace_nan' => 'Espa&ccedil;o vertical n&atilde;o &eacute; um n&uacte;mero',
  ),
  'flash_prop' => array(                // <= new in 2.0
    'title' => 'Flash',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'source' => 'Fonte',
    'width' => 'Largura',
    'height' => 'Altura',
    'error' => 'Erro',
    'error_width_nan' => 'Largura n&atilde;o &eacute; um n&uacte;mero',
    'error_height_nan' => 'Altura n&atilde;o &eacute; um n&uacte;mero',
  ),
  'inserthorizontalrule' => array( // <== v.2.0 changed from hr
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
    'css_class' => 'Classe CSS',
    'width' => 'Largura',
    'height' => 'Altura',
    'border' => 'Borda',
    'pixels' => 'pixels',
    'cellpadding' => 'Recuo da c&eacute;lula',
    'cellspacing' => 'Espa&ccedil;amento de c&eacute;lulas',
    'bg_color' => 'Cor de fundo',
    'background' => 'Imagem de fundo',
    'error' => 'Erro',
    'error_rows_nan' => 'Linhas n&atilde;o &eacute; um n&uacte;mero',
    'error_columns_nan' => 'Colunas n&atilde;o &eacute; um n&uacte;mero',
    'error_width_nan' => 'Largura n&atilde;o &eacute; um n&uacte;mero',
    'error_height_nan' => 'Altura n&atilde;o &eacute; um n&uacte;mero',
    'error_border_nan' => 'Borda n&atilde;o &eacute; um n&uacte;mero',
    'error_cellpadding_nan' => 'Recuo da c&eacute;lula n&atilde;o &eacute; um n&uacte;mero',
    'error_cellspacing_nan' => 'Espa&ccedil;amento de c&eacute;lulas n&atilde;o &eacute; um n&uacte;mero',
  ),
  'table_cell_prop' => array(
    'title' => 'Propriedades da c&eacute;lula',
    'horizontal_align' => 'Alinhamento horizontal',
    'vertical_align' => 'Alinhamento vertical',
    'width' => 'Largura',
    'height' => 'Altura',
    'css_class' => 'Classe CSS',
    'no_wrap' => 'Sem quebras',
    'bg_color' => 'Cor de fundo',
    'background' => 'Imagem de fundo',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'left' => 'Esquerda',
    'center' => 'Centro',
    'right' => 'Direita',
    'top' => 'Superior',
    'middle' => 'Meio',
    'bottom' => 'Inferior',
    'baseline' => 'Linha-base',
    'error' => 'Erro',
    'error_width_nan' => 'Largura n&atilde;o &eacute; um n&uacte;mero',
    'error_height_nan' => 'Altura n&atilde;o &eacute; um n&uacte;mero',
  ),
  'table_row_insert' => array(
    'title' => 'Inserir linha'
  ),
  'table_column_insert' => array(
    'title' => 'Inserir coluna'
  ),
  'table_row_delete' => array(
    'title' => 'Remover linha'
  ),
  'table_column_delete' => array(
    'title' => 'Remover coluna'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Mesclar &agrave; direita'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Mesclar abaixo'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Dividir c&eacute;lula horizontalmente'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Dividir c&eacute;lula verticalmente'
  ),
  'style' => array(
    'title' => 'Estilo'
  ),
  'fontname' => array( // <== v.2.0 changed from font
    'title' => 'Fonte'
  ),
  'fontsize' => array(
    'title' => 'Tamanho'
  ),
  'formatBlock' => array( // <= v.2.0: changed from paragraph
    'title' => 'Par&aacute;grafo'
  ),
  'bold' => array(
    'title' => 'Negrito'
  ),
  'italic' => array(
    'title' => 'It&aacute;lico'
  ),
  'underline' => array(
    'title' => 'Sublinhar'
  ),
  'strikethrough' => array(
    'title' => 'Tachar'
  ),
  'insertorderedlist' => array( // <== v.2.0 changed from ordered_list
    'title' => 'Lista numerada'
  ),
  'insertunorderedlist' => array( // <== v.2.0 changed from bulleted list
    'title' => 'Lista com marcadores'
  ),
  'indent' => array(
    'title' => 'Aumentar tabula&ccedil;&atilde;o'
  ),
  'outdent' => array( // <== v.2.0 changed from unindent
    'title' => 'Diminuir tabula&ccedil;&atilde;o'
  ),
  'justifyleft' => array( // <== v.2.0 changed from left
    'title' => 'Alinhar &agrave; esquerda'
  ),
  'justifycenter' => array( // <== v.2.0 changed from center
    'title' => 'Alinhar ao centro'
  ),
  'justifyright' => array( // <== v.2.0 changed from right
    'title' => 'Alinhar &agrave; direita'
  ),
  'justifyfull' => array( // <== v.2.0 changed from justify
    'title' => 'Justificar'
  ),
  'fore_color' => array(
    'title' => 'Cor do texto'
  ),
  'bg_color' => array(
    'title' => 'Destacar cor'
  ),
  'design' => array( // <== v.2.0 changed from design_tab
    'title' => 'Mudar para o modo WYSIWYG (design)'
  ),
  'html' => array( // <== v.2.0 changed from html_tab
    'title' => 'Mudar para o modo HTML (c&oacute;digo)'
  ),
  'colorpicker' => array(
    'title' => 'Seletor de cor',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'cleanup' => array(
    'title' => 'Limpeza HTML (remover estilos)',
    'confirm' => 'Executar esta a&ccedil;&atilde;o remover&aacute; todos os estilos, fontes e tags in&uatcute;teis do documento atual. Alguma ou toda sua formata&ccedil;&atilde;o podem ser perdidas.',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'toggle_borders' => array(
    'title' => 'Inverter bordas',
  ),
  'hyperlink' => array(
    'title' => 'Link',
    'url' => 'URL',
    'name' => 'Nome',
    'target' => 'Alvo',
    'title_attr' => 'T&iacute;tulo',
  	'a_type' => 'Tipo',
  	'type_link' => 'Link',
  	'type_anchor' => '&Acirc;ncora',
  	'type_link2anchor' => 'Link para &acirc;ncora',
  	'anchors' => '&Acirc;ncoras',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'hyperlink_targets' => array(
  	'_self' => 'mesma janela (_self)',
  	'_blank' => 'nova janela (_blank)',
  	'_top' => 'janela principal (_top)',
  	'_parent' => 'janela pai (_parent)'
  ),
  'unlink' => array( // <=== new v.2.0
    'title' => 'Remover link'
  ),
  'table_row_prop' => array(
    'title' => 'Propriedades da linha',
    'horizontal_align' => 'Alinhamento horizontal',
    'vertical_align' => 'Alinhamento vertical',
    'css_class' => 'Classe CSS',
    'no_wrap' => 'Sem quebras',
    'bg_color' => 'Cor de fundo',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
    'left' => 'Esquerda',
    'center' => 'Centro',
    'right' => 'Direita',
    'top' => 'Superior',
    'middle' => 'Meio',
    'bottom' => 'Inferior',
    'baseline' => 'Linha-base',
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
    'title' => 'Propriedades da p&aacute;gina',
    'title_tag' => 'T&iacute;tulo',
    'charset' => 'Codifica&ccedil;&atilde;o',
    'background' => 'Imagem de fundo',
    'bgcolor' => 'Cor de fundo',
    'text' => 'Cor do texto',
    'link' => 'Cor do link',
    'vlink' => 'Cor do link visitado',
    'alink' => 'Cor do link ativo',
    'leftmargin' => 'Margem esquerda',
    'topmargin' => 'Margem superior',
    'css_class' => 'Classe CSS',
    'ok' => '   OK   ',
    'cancel' => 'Cancelar',
  ),
  'preview' => array(
    'title' => 'Pr&eacute;via',
  ),
  'image_popup' => array(
    'title' => 'Di&aacute;logo de imagem',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
  'subscript' => array(
    'title' => 'Subscrito',
  ),
  'superscript' => array(
    'title' => 'Sobrescrito',
  ),
);
?>