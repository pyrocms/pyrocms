<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Étape 1: Configurer la base de données et le serveur';
$lang['intro_text']		=	'Avant de vérifier la base de données, nous devons connaître sa version et les informations de connexion.';

$lang['db_settings']	=	'Paramètres de la base de données';
$lang['db_text']		=	'Nous devons vérifier votre version du serveur MySQL, vous devez saisir le nom d\'hôte, le nom d\'utilisateur et le mot de passe dans le formulaire ci-dessous. Ces paramètres seront également utilisés lors de l\'installation de la base de données.';

$lang['server']			=	'Nom d\'hôte';
$lang['username']		=	'Nom d\'utilisateur';
$lang['password']		=	'Mot de passe';
$lang['portnr']			=	'Port';
$lang['server_settings']=	'Paramètres serveur';
$lang['httpserver']		=	'Serveur HTTP';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']			=	'Étape 2';

// messages
$lang['db_success']		=	'Les paramètres de la base de données ont été testés et fonctionnent correctement';
$lang['db_failure']		=	'Problème de connexion à la base de données : ';


