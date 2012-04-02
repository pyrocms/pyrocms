<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		Miguel Justo - http://migueljusto.net
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

// Files

// Titles
$lang['files.files_title']					= 'Meus ficheiros';
$lang['files.upload_title']					= 'Envio de ficheiro';
$lang['files.edit_title']					= 'Editar o ficheiro "%s"';

// Labels
$lang['files.download_label']				= 'Download';
$lang['files.upload_label']					= 'Enviar';
$lang['files.description_label']			= 'Descrição';
$lang['files.type_label']					= 'Tipo';
$lang['files.file_label']					= 'Ficheiro';
$lang['files.filename_label']				= 'Nome do ficheiro';
$lang['files.filter_label']					= 'Filtrar';
$lang['files.loading_label']				= 'Carregando...';
$lang['files.name_label']					= 'Nome';

$lang['files.dropdown_select']				= '-- Seleccione a pasta para o upload --'; 
$lang['files.dropdown_no_subfolders']		= '-- Nenhuma --';
$lang['files.dropdown_root']				= '-- Raiz --';

$lang['files.type_a']						= 'Áudio';
$lang['files.type_v']						= 'Vídeo';
$lang['files.type_d']						= 'Documento';
$lang['files.type_i']						= 'Imagem';
$lang['files.type_o']						= 'Outro';

$lang['files.display_grid']					= 'Grelha';
$lang['files.display_list']					= 'Lista';

// Messages
$lang['files.create_success']				= 'O ficheiro foi salvo com sucesso.';
$lang['files.create_error']					= 'Ocorreu um erro ao tentar salvar o ficheiro.';
$lang['files.edit_success']					= 'O ficheiro foi salvo com sucesso.';
$lang['files.edit_error']					= 'Ocorreu um erro ao tentar salvar o ficheiro.';
$lang['files.delete_success']				= 'O ficheiro "%s" foi removido com êxito.';
$lang['files.delete_error']					= 'Ocorreu um erro ao tentar remover o ficheiro "%s".';
$lang['files.mass_delete_success']			= '%d de %d ficheiros foram removidas com êxito, foram eles "%s e %s".';
$lang['files.mass_delete_error']			= 'Ocorreu um erro ao tentar remover %d de %d ficheiros, são eles "%s e %s".';
$lang['files.upload_error']					= 'O ficheiro não foi enviado.';
$lang['files.invalid_extension']			= 'O ficheiro deve ter uma extenção válida.';
$lang['files.not_exists']					= 'Um ficheiro inválido foi selecionada.';
$lang['files.no_files']						= 'Não existem ficheiros actualmente.';
$lang['files.no_permissions']				= 'Não tem permissição para aceder ao módulo ficheiros.';
$lang['files.no_select_error'] 				= 'Precisa  de seleccionar um ficheiro primeiro, sua solicitação foi interrompida..';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Pastas de ficheiros';
$lang['file_folders.manage_title']			= 'Gerir pastas';
$lang['file_folders.create_title']			= 'Nova pasta';
$lang['file_folders.delete_title']			= 'Confirmar remoção';
$lang['file_folders.edit_title']			= 'Editar a pasta "%s"';

// Labels
$lang['file_folders.folders_label']			= 'Pastas';
$lang['file_folders.folder_label']			= 'Pasta';
$lang['file_folders.subfolders_label']		= 'Subpastas';
$lang['file_folders.parent_label']			= 'Pasta pai';
$lang['file_folders.name_label']			= 'Nome';
$lang['file_folders.slug_label']			= 'URI';
$lang['file_folders.created_label']			= 'Criado em';

// Messages
$lang['file_folders.create_success']		= 'A pasta foi salva com sucesso.';
$lang['file_folders.create_error']			= 'Ocorreu um erro ao tentar criar a sua pasta.';
$lang['file_folders.duplicate_error']		= 'Já existe uma pasta com o nome "%s".';
$lang['file_folders.edit_success']			= 'A pasta foi salva com sucesso.';
$lang['file_folders.edit_error']			= 'Ocorreu um erro ao tentar salvar as alterações.';
$lang['file_folders.confirm_delete']		= 'Tem certeza de que deseja remover as pastas abaixo, incluindo todos os ficheiros e subpastas dentro delas?';
$lang['file_folders.delete_mass_success']	= '%d de %d pastas foram removidas com êxito, foram elas "%s e %s".';
$lang['file_folders.delete_mass_error']		= 'Ocorreu um erro ao tentar remover %d de %d pastas, são elas "%s e %s".';
$lang['file_folders.delete_success']		= 'A pasta "%s" foi removida com êxito.';
$lang['file_folders.delete_error']			= 'Ocorreu um erro ao tentar remover a pasta "%s".';
$lang['file_folders.not_exists']			= 'Uma pasta inválida foi selecionada.';
$lang['file_folders.no_subfolders']			= 'Vazio';
$lang['file_folders.no_folders']			= 'Os seus ficheiros são organizados por pastas, actualmente não tem nenhuma pasta criada.';
$lang['file_folders.mkdir_error']			= 'Não foi possível criar a pasta "uploads/files"';
$lang['file_folders.chmod_error']			= 'Não foi possível aplicar chmod á pasta "uploads/files"';
$lang['file_folders.no_select_error'] 		= 'Precisa de seleccionar uma pasta primeiro, sua solicitação foi interrompida..';

/* End of file files_lang.php */