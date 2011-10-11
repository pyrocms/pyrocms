<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'1ª Etapa: Banco de Dados e Servidor';
$lang['intro_text']		=	'Antes de criar um banco de dados, nós precisamos saber onde ele está e quais são os dados de acesso.';

$lang['db_settings']	=	'Banco de Dados';
$lang['db_text']		=	'Em seguida vamos verificar a versão do seu MySQL e antes disso é necessário que você informe o nome do servidor, usuário e senha de acesso no formulário abaixo. Estas configurações também serão utilizadas para criar e instalar um novo banco de dados na 4ª etapa.';

$lang['server']			=	'Host';
$lang['username']		=	'Usuário';
$lang['password']		=	'Senha';
$lang['portnr']			=	'Porta';
$lang['server_settings']=	'Servidor';
$lang['httpserver']		=	'Servidor HTTP';
$lang['rewrite_fail']	=	'Você selecionou "(Apache with mod_rewrite)", mas nós não conseguimos confirmar se o "mod_rewrite" está habilitado no seu servidor. Pergunte ao responsável de sua hospedagem se o "mod_rewrite" está habilitado ou simplesmente instale por conta própria.';
$lang['mod_rewrite']	=	'Vcoê selecionou "(Apache with mod_rewrite)", mas seu servidor não possui o módulo de reescrita "mod_rewrite" habilitado. Peça ao responsável de sua hospedagem para habilitar isso ou instale o PyroCMS usando a opção "Apache (without mod_rewrite)".';
$lang['step2']			=	'2ª Etapa';

// messages
$lang['db_success']		=	'As configurações do banco de dados foram testadas e estão corretas.';
$lang['db_failure']		=	'Houve um problema ao tentar conectar com o banco de dados: ';
