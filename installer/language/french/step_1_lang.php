<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Étape 1: Configurer la base de données et le serveur';
$lang['intro_text']		=	'Avant de vérifier la base de données, nous devons connaître sa version et les paramètres de connexion.';

$lang['db_settings']	=	'Paramètres de la base de données';
$lang['db_text']		=	'Nous devons vérifier votre version du serveur MySQL, vous devez saisir le nom d\'hôte, le nom d\'utilisateur et le mot de passe dans le formulaire ci-dessous. Ces paramètres seront également utilisés lors de l\'installation de la base de données.';

$lang['server']			=	'Nom d\'hôte';
$lang['username']		=	'Nom d\'utilisateur';
$lang['password']		=	'Mot de passe';
$lang['portnr']			=	'Port';
$lang['server_settings']=	'Paramètres serveur';
$lang['httpserver']		=	'Serveur HTTP';
$lang['httpserver_text']=	'PyroCMS nécessite une serveur HTTP pour générer le contenu dynamique de votre site. C\'est visiblement le cas si vous êtes en mesure de voir cette page, cependant connaître la version exacte du serveur permettra de mieux configurer PyroCMS. Si vous ne comprenez pas ce que tout cela veut dire, passez simplement à l\'etape suivante.'; 
$lang['rewrite_fail']	=	'Vous avez choisi "(Apache with mod_rewrite)" mais nous n\'avons pas pu vérifier que mod_rewrite est activé sur votre serveur. Contactez votre hébergeur pour activer mod_rewrite ou faites le à vos propres risques.';
$lang['mod_rewrite']	=	'Vous avez choisi "(Apache with mod_rewrite)" mais mod_rewrite n\'est pas activé sur votre serveur. Contactez votre hébergeur pour activer mod_rewrite ou instalez PyroCMS en choisissant "Apache (without mod_rewrite)".';
$lang['step2']			=	'Étape 2';

// messages
$lang['db_success']		=	'Les paramètres de la base de données ont été testés et fonctionnent correctement';
$lang['db_failure']		=	'Problème de connexion à la base de données : ';


