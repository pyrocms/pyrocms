<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'1ª Etapa: Banse de Dados e Servidor';
$lang['intro_text']		=	'Antes de criar uma base de dados, nós precisamos saber onde ela está e quais são os dados de acesso.';

$lang['db_settings']	=	'Base de Dados';
$lang['db_text']		=	'Em seguida vamos verificar a versão do seu MySQL mas antes disso é necessário que informe o nome do servidor, utilizador e a password de acesso no formulário abaixo. Estas configurações também serão utilizadas para criar e instalar uma nova base de dados na 4ª etapa.';
$lang['db_missing']		=	'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.'; #translate

$lang['server']			=	'Host';
$lang['username']		=	'Utilizador';
$lang['password']		=	'Password';
$lang['portnr']			=	'Porta';
$lang['server_settings']=	'Servidor';
$lang['httpserver']		=	'Servidor HTTP';

$lang['httpserver_text']=	'O PyroCMS requer um servidor HTTP para exibir conteúdo dinâmico quando um utilizador visita o seu site. Parece que já tem um pelo fato de que você está a ver esta página, mas se sabe exatamente o tipo, então o PyroCMS pode configurar-se ainda melhor. Se não sabe o que nada disto significa simplesmente pode ignorar e continuar com a instalação.';
$lang['rewrite_fail']	=	'Selecionou "(Apache with mod_rewrite)", mas nós não conseguimos confirmar se o "mod_rewrite" está habilitado no seu servidor. Pergunte ao responsável do seu serviço de hosting se o "mod_rewrite" está habilitado ou simplesmente instale por conta própria.';
$lang['mod_rewrite']	=	'Selecionou "(Apache with mod_rewrite)", mas o seu servidor não possui o módulo de reescrita "mod_rewrite" habilitado. Peça ao responsável  do seu serviço de hosting para habilitar isso ou instale o PyroCMS usando a opção "Apache (without mod_rewrite)".';
$lang['step2']			=	'2ª Etapa';

// messages
$lang['db_success']		=	'As configurações da base de dados foram testadas e estão corretas.';
$lang['db_failure']		=	'Houve um problema ao tentar conectar-se com a base de dados: ';

/* End of file step_1_lang.php */
