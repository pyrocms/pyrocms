<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Étape 2: vérification des pré requis';
$lang['intro_text']		= 	'La première étape de l\'installation va vérifir si votre serveur supporte PyroCMS. La plupart des serveurs peuvent lancer cette procédure sans aucun problème.';
$lang['mandatory']		= 	'Obligatoire';
$lang['recommended']	= 	'Recommendé';

$lang['server_settings']= 	'Paramètres serveur HTTP';
$lang['server_version']	=	'Les logiciels de votre serveur :';
$lang['server_fail']	=	'Les logiciels de votre serveur ne sont pas supportés, PyroCMS peut ou ne peut pas fonctionner. Tant que votre PHP et votre MySQL n\'est pas mis à jour. PyroCMS devrait être en mesure de fonctionner correctement, il suffit de nettoyer les URL.';

$lang['php_settings']	=	'Paramètres PHP';
$lang['php_required']	=	'PyroCMS nécessite la version PHP 5.0 ou supérieure.';
$lang['php_version']	=	'Votre serveur a la bonne version';
$lang['php_fail']		=	'Votre version de PHP n\'est pas supportée. PyroCMS nécessite la version PHP 5.0 ou supérieure pour fonctionner correctement.';

$lang['mysql_settings']	=	'Paramètres MySQL';
$lang['mysql_required']	=	'PyroCMS nécessite un accès à une base de données MySQL en version 5.0 ou supérieure.';
$lang['mysql_version1']	=	'Votre serveur a la bonne version';
$lang['mysql_version2']	=	'Votre client a la bonne version';
$lang['mysql_fail']		=	'Votre version de MySQL n\'est pas supportée. PyroCMS nécéssite MySQL version 5.0 ou supérieure pour fonctionner correctement.';

$lang['gd_settings']	=	'Paramètres GD';
$lang['gd_required']	= 	'PyroCMS nécessite GD library 1.0 ou supérieur pour manipuler les images.';
$lang['gd_version']		= 	'Votre serveur a la bonne version';
$lang['gd_fail']		=	'Nous ne pouvons pas déterminer la version de GD library. Cela signifie que GD n\'est pas installé. PyroCMS peut tourner correctement sur votre serveur, mais certaines actions sur les images seront pas possibles. Il est vivement recommandé d\'activer GD library.';

$lang['summary']		=	'Résumé';

$lang['zlib']			=	'Zlib'; 
$lang['zlib_required']	= 	'PyroCMS requiert Zlib pour dézipper et installer les thèmes.';
$lang['zlib_fail']		=	'Zlib n\a pa été trouvé. Le plus souvent cela signifie que Zlib n\est pas instéllé. PyroCMS fonctionnera normalement mais il ne sera pas possible d\'installer des thèmes. Il est fortement recommendé d\'installer la librairie.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS requiert Curl pour se connecter vers d\'autres sites.';
$lang['curl_fail']		=	'Curl n\a pas été trouvé. Le plus souvent cela signifie que  Curl n\est pas installé. PyroCMS fonctionnera normalement mais certaines fonctions ne seront pas disponibles. Il est fortement recommendé d\'installer la librairie Curl.';

$lang['summary_success']	=	'Votre serveur est prêt pour l\'installation de PyroCMS, cliquez sur le bouton ci-dessous pour passer à la prochaine étape.';
$lang['summary_partial']	=	'Votre serveur contient quasiment tous les logiciels nécessaires à l\'installation de PyroCMS. Cela signifie vous pouvez lancer l\'installation, mais vous pourriez rencontrer des problèmes lors de la redimension d\'image et la création de vignette.';
$lang['summary_failure']	=	'Il semblerait que votre serveur ne puisse pas installé PyroCMS. Merci de contacter votre administrateur serveur ou votre hébergeur pour résoudre ce problème..';
$lang['next_step']		=	'Passer à la prochaine étape';
$lang['step3']			=	'Étape 3';
$lang['retry']			=	'Essayez encore';

// messages
$lang['step1_failure']	=	'Merci de remplir les champs obligatoires pour les paramètres de la base de données dans le formulaire ci-dessous...';

/* End of file step_2_lang.php */
/* Location: ./installer/language/french/step_2_lang.php */