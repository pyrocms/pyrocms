<?php defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['files:files_title']					= 'Ficheiros';
$lang['files:fetching']						= 'Recebendo dados...';
$lang['files:fetch_completed']				= 'Completado';
$lang['files:save_failed']					= 'Desculpe. As alterações não poderam ser salvas';
$lang['files:item_created']					= '"%s" foi criado';
$lang['files:item_updated']					= '"%s" foi atualizado';
$lang['files:item_deleted']					= '"%s" foi apagado';
$lang['files:item_not_deleted']				= '"%s" não pôde ser apagado';
$lang['files:item_not_found']				= 'Desculpe. "%s" não foi encontrado';
$lang['files:sort_saved']					= 'A ordem da sequência foi salva';
$lang['files:no_permissions']				= 'Não tem permissões suficientes';

// Labels
$lang['files:activity']						= 'Atividade';
$lang['files:places']						= 'Locais';
$lang['files:back']							= 'Voltar';
$lang['files:forward']						= 'Seguir';
$lang['files:start']						= 'Começar Upload';
$lang['files:details']						= 'Detalhes';
$lang['files:id']							= 'ID'; #translate
$lang['files:name']							= 'Nome';
$lang['files:slug']							= 'Slug';#translate
$lang['files:path']							= 'Caminho';
$lang['files:added']						= 'Adicionado a';
$lang['files:width']						= 'Largura';
$lang['files:height']						= 'Altura';
$lang['files:ratio']						= 'Ratio';#translate
$lang['files:alt_attribute']				= 'alt Attribute'; #translate
$lang['files:full_size']					= 'Tamanho total';
$lang['files:filename']						= 'Nome Ficheiro';
$lang['files:filesize']						= 'Tamanho Ficheiro';
$lang['files:download_count']				= 'Transferências';
$lang['files:download']						= 'Transferir';
$lang['files:location']						= 'Localização';
$lang['files:keywords']						= 'Keywords'; #translate
$lang['files:toggle_data_display']			= 'Toggle Data Display'; #translate
$lang['files:description']					= 'Descrição';
$lang['files:container']					= 'Container';#translate
$lang['files:bucket']						= 'Bucket';#translate
$lang['files:check_container']				= 'Verificar validade';
$lang['files:search_message']				= 'Digite e pressione Enter';
$lang['files:search']						= 'Procurar';
$lang['files:synchronize']					= 'Sincronizar';
$lang['files:uploader']						= 'Arraste ficheiros para aqui <br />ou<br />Clique para selecionar ficheiros';
$lang['files:replace_file']					= 'Replace file'; #translate

// Context Menu
$lang['files:refresh']						= 'Refresh'; #translate
$lang['files:open']							= 'Aberto';
$lang['files:new_folder']					= 'Nova Pasta';
$lang['files:upload']						= 'Upload';
$lang['files:rename']						= 'Renomear';
$lang['files:replace']	  					= 'Replace'; # translate
$lang['files:delete']						= 'Remover';
$lang['files:edit']							= 'Editar';
$lang['files:details']						= 'Detalhes';

// Folders

$lang['files:no_folders']					= 'Os ficheiros e pastas são geridos de maneira muito semelhante como no seu ambiente de trabalho. Botão direito do rato na área abaixo desta mensagem para criar a sua primeira pasta. Em seguida, clique com o botão direito sobre a pasta para renomear, apagar e fazer upload de ficheiros, ou alterar detalhes como vinculá-la a um local numa Nuvem.';
$lang['files:no_folders_places']			= 'As pastas que criar vão aparecer aqui numa árvore que pode ser expandida e reduzida. Clique em "Locais" para exibir a pasta raiz.';
$lang['files:no_folders_wysiwyg']			= 'Nenhuma pasta foi criada ainda';
$lang['files:new_folder_name']				= 'Pasta sem título';
$lang['files:folder']						= 'Pasta';
$lang['files:folders']						= 'Pastas';
$lang['files:select_folder']				= 'Selecione uma Pasta';
$lang['files:subfolders']					= 'Sub-Pastas';
$lang['files:root']							= 'Raiz';
$lang['files:no_subfolders']				= 'Nenhuma Sub-Pasta';
$lang['files:folder_not_empty']				= 'Tem de primeiro excluir o conteudo de "%s" primeiro';
$lang['files:mkdir_error']					= 'Nós somos incapazes de criar a pasta de upload. Deve criá-la manualmente';
$lang['files:chmod_error']					= 'A pasta de upload não tem permissões de escrita. Ela tem de ter permissões 0777';
$lang['files:location_saved']				= 'A localização da pasta foi salva';
$lang['files:container_exists']				= '"%s" existe. Salve para vincular o seu conteúdo a esta pasta';
$lang['files:container_not_exists']			= '"%s" não existe na sua conta. Salve e vamos tentar criá-lo';
$lang['files:error_container']				= '"%s" não pôde ser criado e não conseguimos determinar o motivo';
$lang['files:container_created']			= '"%s" foi criado e está agora vinculado a esta pasta';
$lang['files:unwritable']					= '"%s" está sem escrita, por favor, defina suas permissões para 0777';
$lang['files:specify_valid_folder']			= 'Tem de especificar uma pasta válida para fazer o upload do ficheiro para';
$lang['files:enable_cdn']					= 'Tem de ativar o CDN para "%s" através de seu painel de controlo Rackspace antes de podermos sincronizar';
$lang['files:synchronization_started']		= 'Começando Sincronização';
$lang['files:synchronization_complete']		= 'Sincronização para "%s" foi completada';
$lang['files:untitled_folder']				= 'Pasta sem título';

// Files
$lang['files:no_files']						= 'Nenhum ficheiro encontrado';
$lang['files:file_uploaded']				= '"%s" foi enviado';
$lang['files:unsuccessful_fetch']			= 'Não foi possível buscar "%s". Tem certeza que é um ficheiro público?';
$lang['files:invalid_container']			= '"%s" não parece ser um container válido.';
$lang['files:no_records_found']				= 'Nenhum registro foi encontrado';
$lang['files:invalid_extension']			= '"%s" tem uma extensão de ficheiro que não é permitida';
$lang['files:upload_error']					= 'O envio do ficheiro falhou';
$lang['files:description_saved']			= 'A descrição do ficheiro foi salva';
$lang['files:alt_saved']					= 'The image alt attribute has been saved'; #translate
$lang['files:file_moved']					= '"%s" foi movido com sucesso';
$lang['files:exceeds_server_setting']		= 'O servidor não pode lidar com um ficheiro tão grande';
$lang['files:exceeds_allowed']				= 'O ficheiro excede o tamanho máximo permitido';
$lang['files:file_type_not_allowed']		= 'Este tipo de ficheiro não é permitido';
$lang['files:replace_warning']				= 'Warning: Do not replace a file with a file of a different type (e.g. .jpg with .png)'; #translate
$lang['files:type_a']						= 'Audio';
$lang['files:type_v']						= 'Video';
$lang['files:type_d']						= 'Documento';
$lang['files:type_i']						= 'Imagem';
$lang['files:type_o']						= 'Outro';

/* End of file files_lang.php */