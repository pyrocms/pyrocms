<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "Houve um problema ao salvar o seu campo.";
$lang['streams:field_add_success']						= "Campo adicionado com sucesso.";
$lang['streams:field_update_error']						= "Houve um problema ao actualizar o seu campo.";
$lang['streams:field_update_success']					= "Campo actualizado com sucesso.";
$lang['streams:field_delete_error']						= "Houve um problema ao excluir este campo";
$lang['streams:field_delete_success']					= "Campo excluído com sucesso.";
$lang['streams:view_options_update_error']				= "Houve um problema ao actualizar as opções de visualização.";
$lang['streams:view_options_update_success']			= "Opções de visualização actualizadas com sucesso.";
$lang['streams:remove_field_error']						= "Houve um problema ao remover este campo.";
$lang['streams:remove_field_success']					= "Campo removido com sucesso.";
$lang['streams:create_stream_error']					= "Houve um problema ao criar o seu fluxo.";
$lang['streams:create_stream_success']					= "Fluxo criado com sucesso.";
$lang['streams:stream_update_error']					= "Houve um problema ao actualizar este fluxo.";
$lang['streams:stream_update_success']					= "Fluxo actualizado com sucesso.";
$lang['streams:stream_delete_error']					= "Houve um problema com a exclusão deste fluxo.";
$lang['streams:stream_delete_success']					= "Fluxo excluído com sucesso.";
$lang['streams:stream_field_ass_add_error']				= "Houve um problema ao adicionar este campo para esse fluxo.";
$lang['streams:stream_field_ass_add_success']			= "Campo adicionado ao fluxo com sucesso.";
$lang['streams:stream_field_ass_upd_error']				= "Houve um problema ao actualizar este campo de atribuição.";
$lang['streams:stream_field_ass_upd_success']			= "Atribuição de campo actualizada com sucesso.";
$lang['streams:delete_entry_error']						= "Houve um problema ao excluir esta entrada.";
$lang['streams:delete_entry_success']					= "Entrada excluída com sucesso.";
$lang['streams:new_entry_error']						= "Houve um problema ao adicionar esta entrada.";
$lang['streams:new_entry_success']						= "Entrada adicionada com sucesso.";
$lang['streams:edit_entry_error']						= "Houve um problema ao actualizar esta entrada.";
$lang['streams:edit_entry_success']						= "Entrada actualizada com sucesso.";
$lang['streams:delete_summary']							= "Tem certeza de que deseja excluír o fluxo <strong>%s</strong>? Será <strong>excluído %s %s</strong> permanentemente.";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "Nenhum fluxo foi fornecido.";
$lang['streams:invalid_stream']							= "Fluxo inválido.";
$lang['streams:not_valid_stream']						= "não é um fluxo válido.";
$lang['streams:invalid_stream_id']						= "ID do fluxo inválido.";
$lang['streams:invalid_row']							= "Linha inválida.";
$lang['streams:invalid_id']								= "ID inválido.";
$lang['streams:cannot_find_assign']						= "Não é possível localizar atribuição de campo.";
$lang['streams:cannot_find_pyrostreams']				= "Não é possível localizar o PyroStreams.";
$lang['streams:table_exists']							= "A tabela com o apelido %s já existe.";
$lang['streams:no_results']								= "Nenhum resultado";
$lang['streams:no_entry']								= "Não foi possível encontrar a entrada.";
$lang['streams:invalid_search_type']					= "não é um tipo de pesquisa válido.";
$lang['streams:search_not_found']						= "Procura não encontrada.";

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "Este apelido do campo já está em uso.";
$lang['streams:not_mysql_safe_word']					= "O campo %s é uma palavra reservada do MySQL.";
$lang['streams:not_mysql_safe_characters']				= "O campo %s contém caracteres não permitidos.";
$lang['streams:type_not_valid']							= "Por favor selecione um tipo de campo válido.";
$lang['streams:stream_slug_not_unique']					= "Este apelido do fluxo já está em uso.";
$lang['streams:field_unique']							= "O campo %s tem que ser único.";
$lang['streams:field_is_required']						= "O campo %s é obrigatório";
$lang['streams:date_out_or_range']						= "The date you have chosen is out of the acceptable range."; #translate

/* Field Labels */

$lang['streams:label.field']							= "Campo";
$lang['streams:label.field_required']					= "Campo é obrigatório";
$lang['streams:label.field_unique']						= "Campo é único";
$lang['streams:label.field_instructions']				= "Campo de instruções";
$lang['streams:label.make_field_title_column']			= "Fazer do campo o título da coluna";
$lang['streams:label.field_name']						= "Nome do campo";
$lang['streams:label.field_slug']						= "Apelido do campo";
$lang['streams:label.field_type']						= "Tipo do campo";
$lang['streams:id']										= "ID";
$lang['streams:created_by']								= "Criado por";
$lang['streams:created_date']							= "Data de criação";
$lang['streams:updated_date']							= "Data de atualização";
$lang['streams:value']									= "Valor";
$lang['streams:manage']									= "Gerir";
$lang['streams:search']									= "Procurar";
$lang['streams:stream_prefix']							= "Prefixo Fluxo";

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "Exibido no formuláro quando adicionar ou editar dados.";
$lang['streams:instr.stream_full_name']					= "Nome completo para o fluxo.";
$lang['streams:instr.slug']								= "Minúsculas, apenas letras e underscores (_).";

/* Titles */

$lang['streams:assign_field']							= "Atribuir Campo para ao Fluxo";
$lang['streams:edit_assign']							= "Editar Atribuição de Fluxo";
$lang['streams:add_field']								= "Criar Campo";
$lang['streams:edit_field']								= "Editar Campo";
$lang['streams:fields']									= "Campos";
$lang['streams:streams']								= "Fluxos";
$lang['streams:list_fields']							= "Lista de Campos";
$lang['streams:new_entry']								= "Nova Entrada";
$lang['streams:stream_entries']							= "Entradas do Fluxo";
$lang['streams:entries']								= "Entradas";
$lang['streams:stream_admin']							= "Gerir Fluxos";
$lang['streams:list_streams']							= "Lista de Fluxos";
$lang['streams:sure']									= "Tem a certeza?";
$lang['streams:field_assignments'] 						= "Fluxo Atribuições de Campo";
$lang['streams:new_field_assign']						= "Nova Atribuição de Campo";
$lang['streams:stream_name']							= "Nome do Fluxo";
$lang['streams:stream_slug']							= "Apelido do Fluxo";
$lang['streams:about']									= "Sobre";
$lang['streams:total_entries']							= "Total de Entradas";
$lang['streams:add_stream']								= "Novo Fluxo";
$lang['streams:edit_stream']							= "Editar Fluxo";
$lang['streams:about_stream']							= "Sobre Este Fluxo";
$lang['streams:title_column']							= "Titlo da Coluna";
$lang['streams:sort_method']							= "Método de Ordenação";
$lang['streams:add_entry']								= "Adicionar Entrada";
$lang['streams:edit_entry']								= "Editar Entrada";
$lang['streams:view_options']							= "Opções de Visualização";
$lang['streams:stream_view_options']					= "Opções de visualização do Fluxo";
$lang['streams:backup_table']							= "Backup da Tabela do Fluxo";
$lang['streams:delete_stream']							= "Excluir Fluxo";
$lang['streams:entry']									= "Entrada";
$lang['streams:field_types']							= "Tipos de Campos";
$lang['streams:field_type']								= "Tipos de Campo";
$lang['streams:database_table']							= "Tabela B.D.";
$lang['streams:size']									= "Tamanho";
$lang['streams:num_of_entries']							= "Numero de entradas";
$lang['streams:num_of_fields']							= "Numero de campos";
$lang['streams:last_updated']							= "Atualizado a";
$lang['streams:export_schema']							= "Esquema de exportação";

/* Startup */

$lang['streams:start.add_one']							= "adicione um aqui";
$lang['streams:start.no_fields']						= "Ainda não criou nenhum campo. Para começar, crie um campo";
$lang['streams:start.no_assign'] 						= "Ainda não há campos atribuídos para este fluxo. Para começar, atribua um";
$lang['streams:start.add_field_here']					= "adicionar um campo aqui";
$lang['streams:start.create_field_here']				= "criar um campo aqui";
$lang['streams:start.no_streams']						= "Ainda não há fluxos, mas pode começar";
$lang['streams:start.no_streams_yet']					= "Ainda não há fluxos.";
$lang['streams:start.adding_one']						= "adicionar um";
$lang['streams:start.no_fields_to_add']					= "Sem campos para adicionar";
$lang['streams:start.no_fields_msg']					= "Não existem campos para adicionar a este fluxo. Em PyroStreams, tipos de campos podem ser compartilhados entre fluxos e deve ser criado antes de ser adicionado a um fluxo. Pode começar por";
$lang['streams:start.adding_a_field_here']				= "adicionar um campo aqui";
$lang['streams:start.no_entries']						= "Ainda não há entradas para <strong>%s</strong>. Pode, começar";
$lang['streams:add_fields']								= "atribuir campos";
$lang['streams:no_entries']								= 'No entries'; #translate
$lang['streams:add_an_entry']							= "adicionar entrada";
$lang['streams:to_this_stream_or']						= "para este fluxo ou";
$lang['streams:no_field_assign']						= "Não há Atribuições de Campo";
$lang['streams:no_fields_msg_first']					= "Parece que ainda não há campos para este fluxo.";
$lang['streams:no_field_assign_msg']					= "Ainda não há campos para este fluxo. Antes de começar a inserir dados, precisa";
$lang['streams:add_some_fields']						= "atribuir alguns campos";
$lang['streams:start.before_assign']					= "Antes de atribuir campos para um fluxo, precisa de criar um campo. Pode";
$lang['streams:start.no_fields_to_assign']				= "Não há campos disponíveis para serem atribuídos. Antes de poder atribuir um campo deve ";

/* Buttons */

$lang['streams:yes_delete']								= "Sim, Excluir";
$lang['streams:no_thanks']								= "Não, Obrigado";
$lang['streams:new_field']								= "Novo Campo";
$lang['streams:edit']									= "Editar";
$lang['streams:delete']									= "Excluir";
$lang['streams:remove']									= "Remover";
$lang['streams:reset']									= "Reiniciar";

/* Misc */

$lang['streams:field_singular']							= "campo";
$lang['streams:field_plural']							= "campos";
$lang['streams:by_title_column']						= "Por Título da Coluna";
$lang['streams:manual_order']							= "Ordem Manual";
$lang['streams:stream_data_line']						= "Editar dados do fluxo básico.";
$lang['streams:view_options_line'] 						= "Escolher quais as colunas devem ser visíveis na página de listar dados.";
$lang['streams:backup_line']							= "Backup e download da tabela do fluxo num ficheiro GZip.";
$lang['streams:permanent_delete_line']					= "Excluir permanentemente um fluxo e todos os dados desse fluxo.";
$lang['streams:choose_a_field_type']					= "Escolha um tipo de campo";
$lang['streams:choose_a_field']							= "Escolha um campo";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "Biblioteca reCaptcha Inicializada";
$lang['recaptcha_no_private_key']						= "Não forneceu uma chave de API para Recaptcha";
$lang['recaptcha_no_remoteip'] 							= "Por razões de segurança, deve passar o ip remoto para reCAPTCHA";
$lang['recaptcha_socket_fail'] 							= "Não foi possível abrir o soquete";
$lang['recaptcha_incorrect_response'] 					= "Resposta Imagem de Segurança Incorreta";
$lang['recaptcha_field_name'] 							= "Imagem de Segurança";
$lang['recaptcha_html_error'] 							= "Erro ao carregar imagem de segurança. Por favor, tente novamente mais tarde";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "Comprimento Maxímo";
$lang['streams:upload_location'] 						= "Local do upload";
$lang['streams:default_value'] 							= "Valor padrão";

$lang['streams:menu_path']								= 'Menu Path'; #translate
$lang['streams:about_instructions']						= 'A short description of your stream.'; #translate
$lang['streams:slug_instructions']						= 'This will also be the database table name for your stream.'; #translate
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.'; #translate
$lang['streams:menu_path_instructions']					= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.'; #translate

/* End of file pyrostreams_lang.php */