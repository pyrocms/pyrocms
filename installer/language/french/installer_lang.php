<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$lang['intro']	=	'Introduction';
$lang['step1']	=	'Étape #1';
$lang['step2']	=	'Étape #2';
$lang['step3']	=	'Étape #3';
$lang['step4']	=	'Étape #4';
$lang['final']	=	'Dernière étape';

$lang['installer.passwords_match']		= 'Les mots de passe correspondent.';
$lang['installer.passwords_dont_match']	= 'Les mots de passe ne correspondent pas.';

// labels
$lang['step1_header']			=	'Étape 1&nbsp;: Configurer la base de données et le serveur';
$lang['step1_intro_text']		=	'PyroCMS est très simple à installer, ceci ne prends que quelques minutes. Cependant certaines question peuvent être déroutantes si vous n\'avez pas suffisament de connaissances techniques. Si vous rencontrez des difficultés contacter votre hébergeur ou <a href="http://www.pyrocms.com/contact" target="_blank">contactez nous</a>.';

$lang['db_driver']		=	 'Choisissez votre base de données';
$lang['mysql_about']    =    'MySQL est la base de données open-source la plus utilisée dans le monde. Elle est rapide, populaire et installé sur la majorité des serveurs web.';
$lang['use_mysql']		= 	 'Utilisez MySQL';
$lang['pgsql_about'] 	=    'PostgreSQL est une alternative à MySQL. Il est souvent un peu plus rapide, mais moins souvent installé par défaut par les hébergeurs.';
$lang['use_pgsql']		= 	 'Utilisez PostgreSQL';
$lang['sqlite_about']   =    'SQLite est un moteur SQL basé sur un fichier léger. Souvent installé par défaut sur les serveurs, PHP l\'intègre d\'ailleurs à partir de la version 5.3.';
$lang['use_sqlite']		= 	 'Utilisez SQLite';

$lang['not_available']		= 	 'Not Available';

$lang['db_settings']	=	'Paramètres de la base de données';
$lang['db_server']			=	'Nom d\'hôte';
$lang['db_location']		=	'Chemin du fichier de votre base de données';
$lang['db_username']		=	'Nom d\'utilisateur';
$lang['db_password']		=	'Mot de passe';
$lang['db_portnr']			=	'Port';
$lang['db_database']		=	'Base de données';
$lang['db_create']			=	'Créer la base de données';
$lang['db_notice']			=	'Vous devez peut être effectuer cette action vous même via la panneau de configuration de votre hébergement';

$lang['server_settings']=	'Paramètres serveur';
$lang['httpserver']		=	'Serveur HTTP';

$lang['httpserver_text']=	'PyroCMS requiert un serveur HTTP pour afficher dynamiquement du contenu quand un utilisateur viens sur votre site web. Il semble que vous disposez déjà d\'un serveur vu que vous affichez cette page, si vous connaissez précisemment le type de serveur alors PyroCMS peut effectuer une configuration automatique. Si vous ne connaissez pas le type de serveur utilisé alors ignorez cette partie et continuez l\'installation.';
$lang['rewrite_fail']	=	'Vous avez sélectionné "(Apache with mod_rewrite)" mais nous ne pouvons confirmer que mod_rewrite est activé sur votre serveur. Demandez à votre hébergeur si mod_rewrite est bien activé ou continuez l\'installation à vos propres risques.';
$lang['mod_rewrite']	=	'Vous avez sélectionné "(Apache with mod_rewrite)" mais votre serveur ne possède pas le module rewrite activé. Demandez à votre hébergeur de l\'activer ou installez PyroCMS en utilisant l\'option "(Apache without mod_rewrite)"';
$lang['step2']			=	'Étape 2';

// messages
$lang['db_success']		=	'Les paramètres de la base de données ont été testés et fonctionnent correctement';
$lang['db_failure']		=	'Problème de connexion à la base de données&nbsp;: ';

// labels
$lang['step2_header']			=	'Étape 2&nbsp;: Vérification des exigences';
$lang['step2_intro_text']		= 	'La première étape de l\'installation va vérifier si votre serveur supporte PyroCMS. La plupart des serveurs peuvent lancer cette procédure sans aucun problème.';
$lang['mandatory']		= 	'Obligatoire';
$lang['recommended']	= 	'Recommandé';

$lang['server_settings']= 	'Paramètres serveur HTTP';
$lang['server_version']	=	'Les logiciels de votre serveur&nbsp;:';
$lang['server_fail']	=	'Les logiciels de votre serveur ne sont pas supportés, PyroCMS peut ou ne peut pas fonctionner. Tant que votre PHP et votre MySQL n\'est pas mis à jour. PyroCMS devrait être en mesure de fonctionner correctement, il suffit de nettoyer les URL.';

$lang['php_settings']	=	'Paramètres PHP';
$lang['php_required']	=	'PyroCMS nécessite la version PHP %s ou supérieure.';
$lang['php_version']	=	'Votre serveur a la bonne version';
$lang['php_fail']		=	'Votre version de PHP n\'est pas supportée. PyroCMS nécessite la version PHP %s ou supérieure pour fonctionner correctement.';

$lang['mysql_settings']	=	'Paramètres MySQL';
$lang['mysql_required']	=	'PyroCMS nécessite un accès à une base de données MySQL en version 5.0 ou supérieure.';
$lang['mysql_version1']	=	'Votre serveur a la bonne version';
$lang['mysql_version2']	=	'Votre client a la bonne version';
$lang['mysql_fail']		=	'Votre version de MySQL n\'est pas supportée. PyroCMS nécéssite MySQL version 5.0 ou supérieure pour fonctionner correctement.';

$lang['gd_settings']	=	'Paramètres GD';
$lang['gd_required']	= 	'PyroCMS nécessite la librairie GD 1.0 ou supérieur pour manipuler les images.';
$lang['gd_version']		= 	'Votre serveur a la bonne version';
$lang['gd_fail']		=	'Nous ne pouvons pas déterminer la version de la librairie GD. Cela signifie que GD n\'est pas installé. PyroCMS peut tourner correctement sur votre serveur, mais certaines actions sur les images ne seront pas possibles. Il est vivement recommandé d\'activer la librairie GD.';

$lang['summary']		=	'Résumé';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS nécessite Zlib afin de désarchiver et installer les thèmes.';
$lang['zlib_fail']		=	'Zlib n\'as pas été trouvé. Cela indique habituellement que Zlib n\'est pas installé. PyroCMS fonctionnera correctement, cependant l\'installation des thèmes ne fonctionnera pas. Il est vivement recommandé d\'installer Zlib.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS requiert Curl afin de se connecter à d\'autres sites.';
$lang['curl_fail']		=	'Curl n\'as pas été trouvé. Cela indique habituellement que Curl n\'est pas installé. PyroCMS fonctionnera correctement, cependant certaines fonctions ne fonctionneront pas. Il est vivement recommandé d\'activé la librairie Curl.';

$lang['summary_success']	=	'Votre serveur est prêt pour l\'installation de PyroCMS, cliquez sur le bouton ci-dessous pour passer à la prochaine étape.';
$lang['summary_partial']	=	'Votre serveur contient quasiment tous les logiciels nécessaires à l\'installation de PyroCMS. Cela signifie vous pouvez lancer l\'installation, mais vous pourriez rencontrer des problèmes lors de la redimension d\'image et la création de vignette.';
$lang['summary_failure']	=	'Il semblerait que votre serveur ne puisse pas installé PyroCMS. Merci de contacter votre administrateur serveur ou votre hébergeur pour résoudre ce problème..';
$lang['next_step']		=	'Passer à la prochaine étape';
$lang['step3']			=	'Étape 3';
$lang['retry']			=	'Essayez encore';

// messages
$lang['step1_failure']	=	'Merci de remplir les champs obligatoires pour les paramètres de la base de données dans le formulaire ci-dessous...';

// labels
$lang['step3_header']			=	'Étape 3&nbsp;: Définir les permissions';
$lang['step3_intro_text']		= 	'Avant de procéder à l\'installation de PyroCMS, assurez-vous que les fichiers et les répertoires sont inscriptibles. Vous trouverez la liste de ces derniers ci-dessous. Les sous-repertoires doivent aussi hériter des permissions !';

$lang['folder_perm']	= 	'Permissions des répertoires';
$lang['folder_text']	=	'La valeur CHMOD des répertoires suivants doit être changée en 777 (dans certains cas la valeur 775 marche aussi).';

$lang['file_perm']		=	'Permissions des fichiers';
$lang['file_text']		=	'La valeur CHMOD des fichiers suivants doit être changée en 666. Ce changement est important <em>avant</em> de procéder à l\'installation de PyroCMS.';

$lang['writable']		=	'Inscriptible';
$lang['not_writable']	=	'Non Inscriptible';

$lang['show_commands']		= 'Afficher les commandes';
$lang['hide_commands']		= 'Cacher les commandes';

$lang['next_step']		=	'Passer à la prochaine étape';
$lang['step4']			=	'Étape 4';
$lang['retry']			=	'Essayez encore';


// labels
$lang['step4_header']			=	'Étape 4&nbsp;: Création de la base de données';
$lang['step4_intro_text']		=	'Compléter le formulaire ci-dessous et cliquer sur le bouton Installer pour finaliser l\'installation de PyroCMS. Assurez vous d\'installer PyroCMS dans la bonne base de données sinon tout les changements existants seront perdus!';

$lang['default_user']	=	'Utilisateur par défaut';
$lang['site_settings']	= 	'Réglages du site';
$lang['site_ref']		=	'Réference du site';
$lang['username']		= 	'Nom d\'utilisateur';
$lang['firstname']		= 	'Prénom';
$lang['lastname']		=	'Nom';
$lang['email']			=	'Email';
$lang['password']		= 	'Mot de passe';
$lang['conf_password']	=	'Confirmer le mot de passe';
$lang['finish']			=	'Installer';

$lang['invalid_db_name'] = 'Le nom de la base de données que vous avez renseigné n\'esst pas valide. Merci d\'utiliser uniquement des caractères alpha-numériques et des underscores.';
$lang['error_101']		=	'La base de données est introuvable. Si vous demandez à l\'installation de créer la base de données, elle doit en avoir la permissions.';
$lang['error_102']		=	'L\'installation ne peut pas ajouter de table à la base de données.<br/><br/>';
$lang['error_103']		=	'L\'installation ne peut pas insérer de données dans la base de données.<br/><br/>';
$lang['error_104']		=	'L\'installation ne peut pas créer un utilisateur par défaut.<br/><br/>';
$lang['error_105']		=	'Le fichier configuration de base de données ne peut être écris, avez vous sauté l\'étape 3 de l\'installation ?';
$lang['error_106']		=	'Le fichier de configuration ne peut pas être écrit, avez-vous les permissions nécessaires à cette écriture ?';
$lang['success']		=	'PyroCMS a été installé avec succès.';


// labels
$lang['congrats']	=	'Félicitations';
$lang['intro_text']	=	'PyroCMS est maintenant installé et prêt à être utilisé ! Connectez-vous au panel d\'administration avec les détails suivants.';
$lang['email']		=	'E-mail';
$lang['password']	=	'Mot de passe';
$lang['show_password']		= 'Voir le Mot de passe';
$lang['outro_text']	=	'Pour finir, <strong>effacer le répertoire /installer de votre serveur</strong> afin d\'éviter qu\'il soit utilisé pour pirater votre site.';

$lang['go_website']			= 'Allez au site';
$lang['go_control_panel']	= 'Allez au panel d\'administration';


/* End of file global_lang.php */
