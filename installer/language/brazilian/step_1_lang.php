<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'1ª Etapa: Configurar o Banco de Dados e o Servidor';
$lang['intro_text']		=	'Antes de verificar o banco de dados, nós precisamos saber onde ele está e quais são os dados de acesso.';

$lang['db_settings']	=	'Configuração do Banco de Dados';
$lang['db_text']		=	'Para que o instalador verifique a versão do seu servidor de MySQL é necessário que você informe o nome do servidor, usuário e senha de acesso no formulário abaixo. Estas configurações também serão utilizadas ao instalar o banco de dados na 4ª etapa.';

$lang['server']			=	'Host do servidor';
$lang['username']		=	'Usuário';
$lang['password']		=	'Senha';
$lang['portnr']			=	'Porta';
$lang['server_settings']=	'Configurações do Servidor';
$lang['httpserver']		=	'Servidor HTTP';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']			=	'2ª Etapa';

// messages
$lang['db_success']		=	'As configurações do banco de dados foram testadas e estão corretas.';
$lang['db_failure']		=	'Problema ao tentar conectar com o banco de dados: ';
