<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams.save_field_error'] 						= "Houve um problema ao salvar seu campo.";
$lang['streams.field_add_success']						= "Campo adicionado com sucesso.";
$lang['streams.field_update_error']						= "Houve um problema ao atualizar seu campo.";
$lang['streams.field_update_success']					= "Campo atualizado com sucesso.";
$lang['streams.field_delete_error']						= "Houve um problema ao excluir este campo";
$lang['streams.field_delete_success']					= "Campo excluído com sucesso.";
$lang['streams.view_options_update_error']				= "Houve um problema ao atualizar as opções de visualização.";
$lang['streams.view_options_update_success']			= "Opções de visualização atualizadas com sucesso.";
$lang['streams.remove_field_error']						= "Houve um problema ao remover esse campo.";
$lang['streams.remove_field_success']					= "Campo removido com sucesso.";
$lang['streams.create_stream_error']					= "Houve um problema ao criar seu fluxo.";
$lang['streams.create_stream_success']					= "Fluxo criado com sucesso.";
$lang['streams.stream_update_error']					= "Houve um problema ao atualizando este fluxo.";
$lang['streams.stream_update_success']					= "Fluxo atualizado com sucesso.";
$lang['streams.stream_delete_error']					= "Houve um problema com a exclusão deste fluxo.";
$lang['streams.stream_delete_success']					= "Fluxo excluído com sucesso.";
$lang['streams.stream_field_ass_add_error']				= "Houve um problema ao adicionar este campo para esse fluxo.";
$lang['streams.stream_field_ass_add_success']			= "Campo adicionado para o fluxo com sucesso.";
$lang['streams.stream_field_ass_upd_error']				= "Houve um problema ao atualizar este campo de atribuição.";
$lang['streams.stream_field_ass_upd_success']			= "Atribuição de campo atualizada com sucesso.";
$lang['streams.delete_entry_error']						= "Houve um problema ao excluir esta entrada.";
$lang['streams.delete_entry_success']					= "Entrada excluída com sucesso.";
$lang['streams.new_entry_error']						= "Houve um problema ao adicionar esta entrada.";
$lang['streams.new_entry_success']						= "Entrada adicionada com sucesso.";
$lang['streams.edit_entry_error']						= "Houve um problema ao atualizar esta entrada.";
$lang['streams.edit_entry_success']					= "Entrada atualizada com sucesso.";
$lang['streams.delete_summary']							= "Tem certeza de que deseja excluír o fluxo <strong>%s</strong>? Será <strong>excluído %s %s</strong> permanentemente.";

/* Misc Errors */

$lang['streams.no_stream_provided']						= "Nenhum fluxo foi fornecido.";
$lang['streams.invalid_stream']							= "Fluxo Inválido.";
$lang['streams.not_valid_stream']						= "não é um fluxo válido."; 
$lang['streams.invalid_stream_id']						= "Id de fluxo inválido.";
$lang['streams.invalid_row']							= "Linha inválida.";
$lang['streams.invalid_id']								= "ID inválido.";
$lang['streams.cannot_find_assign']						= "Não é possível encontrar um atribuição de campo.";
$lang['streams.cannot_find_pyrostreams']				= "Não é possível encontrar o PyroStreams."; 
$lang['streams.table_exists']							= "Uma tabela com o slug %s já existe.";
$lang['streams.no_results']								= "Nenhum resultado"; 
$lang['streams.no_entry']								= "Incapaz de encontrar entrada."; 
$lang['streams.invalid_search_type']					= "não é um tipo de pesquisa válido.";
$lang['streams.search_not_found']						= "Pesquisa não encontrada.";

/* Validation Messages */

$lang['streams.field_slug_not_unique']					= "Este slug de campo já está em uso.";
$lang['streams.not_mysql_safe_word']					= "O campo %s é uma palavra reservada do MySQL.";
$lang['streams.not_mysql_safe_characters']				= "O campo %s contém caracteres não permitidos.";
$lang['streams.type_not_valid']							= "Por favor selecione um tipo de campo válido.";
$lang['streams.stream_slug_not_unique']					= "Este slug de fluxo já está em uso.";
$lang['streams.field_unique']							= "O campo %s deve ser único."; 
$lang['streams.field_is_required']						= "O campo %s é requirido."; 
$lang['streams.date_out_or_range']						= "A data escolhida está fora da faixa aceitável."; 

/* Field Labels */

$lang['streams.label.field']							= "Campo";
$lang['streams.label.field_required']					= "Campo é obrigatório";
$lang['streams.label.field_unique']						= "Campo é único";
$lang['streams.label.field_instructions']				= "Campo de instruções";
$lang['streams.label.make_field_title_column']			= "Fazer do campo o título da coluna";
$lang['streams.label.field_name']						= "Nome do campo";
$lang['streams.label.field_slug']						= "Slug do campo";
$lang['streams.label.field_type']						= "Tipo do campo";
$lang['streams.id']										= "ID";
$lang['streams.created_by']								= "Criado por";
$lang['streams.created_date']							= "Data de criação";
$lang['streams.updated_date']							= "Data de atualização";
$lang['streams.value']									= "Valor";
$lang['streams.manage']									= "Administrar";
$lang['streams.search']									= "Pesquisa";
$lang['streams:stream_prefix']							= "Prefixo do fluxo";

/* Field Instructions */

$lang['streams.instr.field_instructions']				= "Exibido no formuláro quando adicionar ou editar dados.";
$lang['streams.instr.stream_full_name']					= "Nome completo para o fluxo.";
$lang['streams.instr.slug']								= "Minúsculas, apenas letras e sublinhados.";

/* Titles */

$lang['streams.assign_field']							= "Atribuir Campo para o Fluxo";
$lang['streams.edit_assign']							= "Editar Atribuição de Fluxo";
$lang['streams.add_field']								= "Criar Campo";
$lang['streams.edit_field']								= "Editar Campo";
$lang['streams.fields']									= "Campos";
$lang['streams.streams']								= "Fluxos";
$lang['streams.list_fields']							= "Lista de Campos";
$lang['streams.new_entry']								= "Nova Entrada";
$lang['streams.stream_entries']							= "Entradas de Fluxo";
$lang['streams.entries']								= "Entradas";
$lang['streams.stream_admin']							= "Administrar Fluxos";
$lang['streams.list_streams']							= "Lista de Fluxos";
$lang['streams.sure']									= "Você tem certeza?";
$lang['streams.field_assignments'] 						= "Fluxo Atribuições de Campo";
$lang['streams.new_field_assign']						= "Nova Atribuição de Campo";
$lang['streams.stream_name']							= "Nome do Fluxo";
$lang['streams.stream_slug']							= "Slug do Fluxo";
$lang['streams.about']									= "Sobre";
$lang['streams.total_entries']							= "Total de Entradas";
$lang['streams.add_stream']								= "Novo Fluxo";
$lang['streams.edit_stream']							= "Editar Fluxo";
$lang['streams.about_stream']							= "Sobre Este Fluxo";
$lang['streams.title_column']							= "Titlo da Coluna";
$lang['streams.sort_method']							= "Método de Ordenação";
$lang['streams.add_entry']								= "Adicionar Entrada";
$lang['streams.edit_entry']								= "Editar Entrada";
$lang['streams.view_options']							= "Opções de Visualização";
$lang['streams.stream_view_options']					= "Opções de visualização de Fluxo";
$lang['streams.backup_table']							= "Backup Tabela de Fluxo";
$lang['streams.delete_stream']							= "Excluir Fluxo";
$lang['streams.entry']									= "Entrada";
$lang['streams.field_types']							= "Tipos de Campo"; 
$lang['streams.field_type']								= "Tipo de Campo"; 
$lang['streams.database_table']							= "Tabela do Banco de Dados";
$lang['streams.size']									= "Tamanho";
$lang['streams.num_of_entries']							= "Número de Entradas";
$lang['streams.num_of_fields']							= "Número de Campos";
$lang['streams.last_updated']							= "Última Atualização";
$lang['streams.export_schema']							= "Exportar Schema";

/* Startup */

$lang['streams.start.add_one']							= "adicionar um aqui";
$lang['streams.start.no_fields']						= "Você ainda não criou nenhum campo. Para começar, crie um campo";
$lang['streams.start.no_assign'] 						= "Ainda não há campos atribuídos para esse fluxo. Para começar, você atribuir um";
$lang['streams.start.add_field_here']					= "adicionar um campo aqui";
$lang['streams.start.create_field_here']				= "criar um campo aqui";
$lang['streams.start.no_streams']						= "Ainda não há fluxos, mas pode começar";
$lang['streams.start.no_streams_yet']					= "Não existem fluxos ainda.";
$lang['streams.start.adding_one']						= "adicionando um";
$lang['streams.start.no_fields_to_add']					= "Sem campos para adicionar";		
$lang['streams.start.no_fields_msg']					= "Não existem campos para adicionar a este fluxo. Em PyroStreams, tipos de campos podem ser compartilhados entre fluxos e deve ser criado antes de ser adicionado a um fluxo. Você pode começar por";
$lang['streams.start.adding_a_field_here']				= "adicionando um campo aqui";
$lang['streams.start.no_entries']						= "Ainda não há entradas para <strong>%s</strong>. Você pode, começar";
$lang['streams.add_fields']								= "atribuir campos";
$lang['streams.add_an_entry']							= "adicionar entrada";
$lang['streams.to_this_stream_or']						= "para este fluxo ou";
$lang['streams.no_field_assign']						= "Não há Atribuições de Campo";
$lang['streams.no_fields_msg_first']					= "Parece que não há campos ainda para este fluxo.";
$lang['streams.no_field_assign_msg']					= "Ainda não há campos para esse fluxo. Antes de começar a inserir dados, você precisa";
$lang['streams.add_some_fields']						= "atribuir alguns campos";
$lang['streams.start.before_assign']					= "Antes de atribuir campos para um fluxo, você precisa criar um campo. Você pode";
$lang['streams.start.no_fields_to_assign']				= "Não há campos disponíveis para serem atribuídos. Antes de poder atribuir um campo você deve ";

/* Buttons */

$lang['streams.yes_delete']								= "Sim, Excluir";
$lang['streams.no_thanks']								= "Não, Obrigado";
$lang['streams.new_field']								= "Novo Campo";
$lang['streams.edit']									= "Editar";
$lang['streams.delete']									= "Excluir";
$lang['streams.remove']									= "Remover";
$lang['streams.reset']									= "Resetar";

/* Misc */

$lang['streams.field_singular']							= "campo";
$lang['streams.field_plural']							= "campos";
$lang['streams.by_title_column']						= "Por Título da Coluna";
$lang['streams.manual_order']							= "Ordem Manual";
$lang['streams.stream_data_line']						= "Editar dados do fluxo básico.";
$lang['streams.view_options_line'] 						= "Escolher quais colunas devem ser visíveis na página de listar dados.";
$lang['streams.backup_line']							= "Backup e download da tabela de fluxo em um arquivo GZip.";
$lang['streams.permanent_delete_line']					= "Excluir permanentemente um fluxo e todos os dados desse fluxo.";
$lang['streams.choose_a_field_type']					= "Escolha um tipo de campo";
$lang['streams.choose_a_field']							= "Escolha um campo";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "Biblioteca reCaptcha Inicializada";
$lang['recaptcha_no_private_key']						= "Você não forneceu uma chave de API para Recaptcha";
$lang['recaptcha_no_remoteip'] 							= "Por razões de segurança, você deve passar o ip remoto para reCAPTCHA";
$lang['recaptcha_socket_fail'] 							= "Não foi possível abrir o soquete";
$lang['recaptcha_incorrect_response'] 					= "Resposta Imagem de Segurança Incorreta";
$lang['recaptcha_field_name'] 							= "Imagem de Segurança";
$lang['recaptcha_html_error'] 							= "Erro ao carregar imagem de segurança. Por favor, tente novamente mais tarde";

/* Default Parameter Fields */

$lang['streams.max_length'] 							= "Comprimento Maxímo";
$lang['streams.upload_location'] 						= "Local de upload";
$lang['streams.default_value'] 							= "Valor padrão";

/* End of file pyrostreams_lang.php */