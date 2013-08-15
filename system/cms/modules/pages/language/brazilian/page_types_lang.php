<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types:html_label']                 = 'HTML';
$lang['page_types:css_label']                  = 'CSS';
$lang['page_types:basic_info']                 = 'Informação Básica';

// labels
$lang['page_types:updated_label']              = 'Atualizado';
$lang['page_types:layout']                     = 'Layout'; #translate
$lang['page_types:auto_create_stream']         = 'Criar Novo Stream para este Tipo de Página';
$lang['page_types:select_stream']              = 'Stream de Dados';
$lang['page_types:theme_layout_label']         = 'Tema de layout';
$lang['page_types:save_as_files']              = 'Salvar como Arquivos';
$lang['page_types:content_label']              = 'Rótulo da Aba Conteúdo';
$lang['page_types:title_label']                = 'Rótulo do Título';
$lang['page_types:sync_files']                 = 'Sincronizer Arquivos';

// titles
$lang['page_types:list_title']                 = 'Listar páginas de layout';
$lang['page_types:list_title_sing']            = 'Tipo de Página';
$lang['page_types:create_title']               = 'Adicionar página de layout';
$lang['page_types:edit_title']                 = 'Editar a página de layout "%s"';

// messages
$lang['page_types:no_pages']                   = 'Nenhuma página de layout.';
$lang['page_types:create_success_add_fields']  = 'Você criou um novo tipo de página; Agora adicione os campos que você quer que sua página tenha.';
$lang['page_types:create_success']             = 'A página de layout foi criada.';
$lang['page_types:success_add_tag']            = 'O campo de página foi adicionado. Porém, antes que seus dados sejam exibidos você precisa inserir sua tag no campo de texto do Layout do Tipo de Página';
$lang['page_types:create_error']               = 'A página de layout não foi criada.';
$lang['page_types:page_type.not_found_error']  = 'A página de layout não existe.';
$lang['page_types:edit_success']               = 'A página de layout "%s" foi salva.';
$lang['page_types:delete_home_error']          = 'Você não pode remover a página de layout padrão.';
$lang['page_types:delete_success']             = 'A página de layout #%s foi removida.';
$lang['page_types:mass_delete_success']        = '%s páginas de layout foram removidas.';
$lang['page_types:delete_none_notice']         = 'Nenhuma página de layout removida.';
$lang['page_types:already_exist_error']        = 'Uma tabela com este nome já existe. Por favor, escolha um nome diferente para este tipo de página.';
$lang['page_types:_check_pt_slug_msg']         = 'O Slug do seu tipo de página deve ser único.';

$lang['page_types:variable_introduction']      = 'Esta caixa de texto possui duas variáveis disponíveis';
$lang['page_types:variable_title']             = 'Contém o título da página.';
$lang['page_types:variable_body']              = 'Contém o corpo HTML da página.';
$lang['page_types:sync_notice']                = 'Capaz de sincronizar %s apenas a partir do sistema de arquivos.';
$lang['page_types:sync_success']               = 'Arquivos sincronizados com sucesso.';
$lang['page_types:sync_fail']                  = 'Incapaz de sincronizar seus arquivos.';

// Instructions
$lang['page_types:stream_instructions']        = 'Este stream guardará os campos personalizados de seu tipo de página. Você pode escolher um novo stream, ou um será criado para você.';
$lang['page_types:saf_instructions']           = 'Marcar esta opção fará com que seu arquivo de layout de página, bem como qualquer CSS e JS personalizados, sejam salvos em um arquivo na pasta assets/page_types.';
$lang['page_types:content_label_instructions'] = 'Este será o novo nome da aba que contém os campos de stream de seu tipo de página.';
$lang['page_types:title_label_instructions']   = 'Este será o nome do campo de título da página, ao invés de "Título". Isto é útil se você estiver utilizando "Título" como alguma outra coisa, como "Nome do Produto" ou "Nome do Membro de Equipe".';

// Misc
$lang['page_types:delete_message']             = 'Tem certeza que quer excluir este tipo de página? Isto excluirá <strong>%s</strong> páginas que utilizam este layout, qualquer página-filha destas, e qualquer entrada de stream associada com estas páginas. <strong>Isto não pode ser desfeito.</strong> ';

$lang['page_types:delete_streams_message']     = 'Isto também excluirá o <strong>stream %s</strong> associado com este tipo de página.';