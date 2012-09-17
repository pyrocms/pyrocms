<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 * 
 * Licensed under the Open Software License version 3.0
 * 
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
 
$lang['db_invalid_connection_str'] = 'Não foi possível determinar as configurações da base de dados por meio da string de conexão especificada.';
$lang['db_unable_to_connect'] = 'Não foi possível conectar ao servidor da base de dados utilizando os dados fornecidos.';
$lang['db_unable_to_select'] = 'Não foi possível selecionar a base de dados especificada: %s';
$lang['db_unable_to_create'] = 'Não foi possível criar a base de dados especificada: %s';
$lang['db_invalid_query'] = 'Query inválida.';
$lang['db_must_set_table'] = 'Favor informar a tabela a ser usada na query.';
$lang['db_must_use_set'] = 'Para atualizar um registro, favor utilizar o método "set".';
$lang['db_must_use_index'] = 'Deve especificar um índice para coincidir com as atualizações em lote.';
$lang['db_batch_missing_index'] = 'Uma ou mais linhas apresentadas para atualização em lote está em falta o índice especificado.';
$lang['db_must_use_where'] = 'Não são permitidos updates que não contêm a cláusula "where".';
$lang['db_del_must_use_where'] = 'Não são permitidos deletes que não contêm as cláusulas "where" ou "like".';
$lang['db_field_param_missing'] = 'Para buscar campos, é necessário inserir o nome da tabela como parâmetro.';
$lang['db_unsupported_function'] = 'Este recurso não está disponível para a base de dados que está em uso.';
$lang['db_transaction_failure'] = 'Falha na transação: Rollback executado.';
$lang['db_unable_to_drop'] = 'Não foi possível apagar a base de dados especificada.';
$lang['db_unsuported_feature'] = 'Recurso não suportado pela plataforma da base de dados que está em uso.';
$lang['db_unsuported_compression'] = 'Formato de compressão de ficheiros escolhido não suportado pelo servidor.';
$lang['db_filepath_error'] = 'Não foi possível escrever dados no caminho especificado.';
$lang['db_invalid_cache_path'] = 'O caminho especificado para cache é inválido ou não há permissão de escrita.';
$lang['db_table_name_required'] = 'Para essa operação, é necessário inserir o nome da tabela.';
$lang['db_column_name_required'] = 'Para essa operação, é necessário inserir o nome da coluna.';
$lang['db_column_definition_required'] = 'Para essa operação, é necessário definir a coluna.';
$lang['db_unable_to_set_charset'] = 'Não foi possível definir o conjunto de caracteres da conexão do cliente: %s';
$lang['db_error_heading'] = 'Ocorreu um erro de base de dados';
//$lang['db_must_set_database'] = 'Favor informar o nome da base de dados no seu ficheiro de configuração da base de dados.';

/* End of file db_lang.php */
/* Location: ./system/language/portuguese/db_lang.php */