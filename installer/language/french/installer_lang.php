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
$lang['step1_header']			=	'Step 1: Configure Database and Server';
$lang['step1_intro_text']		=	'PyroCMS is very easy to install and should only take a few minutes, but there are a few questions that may appear confusing if you do not have a technical background. If at any point you get stuck please ask your web hosting provider or <a href="http://www.pyrocms.com/contact" target="_blank">contact us</a> for support.';

$lang['db_driver']		=	 'Database Driver';
$lang['mysql_about']    =    'MySQL is the world\'s most used open-source database. It is fast, popular and installed on the majority of web servers.';
$lang['use_mysql']		= 	 'Use MySQL';
$lang['pgsql_about'] 	=    'PostgreSQL is a popular alternative to MySQL. It is often slightly quicker but is installed on less servers by default.';
$lang['use_pgsql']		= 	 'Use PostgreSQL';
$lang['sqlite_about']   =    'SQLite is a lightweight file-based SQL engine, which installed on many servers and part of PHP as of PHP 5.3.';
$lang['use_sqlite']		= 	 'Use SQLite';

$lang['not_available']		= 	 'Not Available';

$lang['db_settings']		=	'Settings';
$lang['db_server']			=	'Hostname';
$lang['db_location']		=	'Location';
$lang['db_username']		=	'Username';
$lang['db_password']		=	'Password';
$lang['db_portnr']			=	'Port';
$lang['db_database']		=	'Database Name';
$lang['db_create']			=	'Create Database';
$lang['db_notice']			=	'You might need to do this yourself';

$lang['server_settings']	=	'Server Settings';
$lang['httpserver']			=	'HTTP Server';

$lang['httpserver_text']	=	'PyroCMS requires a HTTP Server to display dynamic content when a user goes to your website. It looks like you already have one by the fact that you can see this page, but if we know exactly which type then PyroCMS can configure itself even better. If you do not know what any of this means just ignore it and carry on with the installation.';
$lang['rewrite_fail']		=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']		=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install PyroCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']				=	'Step 2';

// messages
$lang['db_success']			=	'The database settings are tested and working fine.';
$lang['db_failure']			=	'Problem connecting to the database: ';

// labels
$lang['step2_header']			=	'Step 2: Check Requirements';
$lang['step2_intro_text']		= 	'The second step in the installation process is to check whether your server supports PyroCMS. Most servers should be able to run it without any trouble.';
$lang['mandatory']		= 	'Mandatory';
$lang['recommended']	= 	'Recommended';

$lang['server_settings']= 	'HTTP Server Settings';
$lang['server_version']	=	'Your server software:';
$lang['server_fail']	=	'Your server software is not supported, therefore PyroCMS may or may not work. As long as your PHP and MySQL installations are up to date PyroCMS should be able to run properly, just without clean URL\'s.';

$lang['php_settings']	=	'PHP Settings';
$lang['php_required']	=	'PyroCMS requires PHP version %s or higher.';
$lang['php_version']	=	'Your server is currently running version';
$lang['php_fail']		=	'Your PHP version is not supported. PyroCMS requires PHP version %s or higher to run properly.';

$lang['mysql_settings']	=	'MySQL Settings';
$lang['mysql_required']	=	'PyroCMS requires access to a MySQL database running version 5.0 or higher.';
$lang['mysql_version1']	=	'Your server is currently running';
$lang['mysql_version2']	=	'Your client is currently running';
$lang['mysql_fail']		=	'Your MySQL version is not supported. PyroCMS requires MySQL version 5.0 or higher to run properly.';

$lang['gd_settings']	=	'GD Settings';
$lang['gd_required']	= 	'PyroCMS requires GD library 1.0 or higher to manipulate images.';
$lang['gd_version']		= 	'Your server is currently running version';
$lang['gd_fail']		=	'We cannot determine the version of the GD library. This usually means that the GD library is not installed. PyroCMS will still run properly but some of the image functions might not work. It is highly recommended to enable the GD library.';

$lang['summary']		=	'Summary';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS requires Zlib in order to unzip and install themes.';
$lang['zlib_fail']		=	'Zlib can not be found. This usually means that Zlib is not installed. PyroCMS will still run properly but installation of themes will not work. It is highly recommended to install Zlib.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS requires Curl in order to make connections to other sites.';
$lang['curl_fail']		=	'Curl can not be found. This usually means that Curl is not installed. PyroCMS will still run properly but some of the functions might not work. It is highly recommended to enable the Curl library.';

$lang['summary_success']	=	'Your server meets all the requirements for PyroCMS to run properly, go to the next step by clicking the button below.';
$lang['summary_partial']	=	'Your server meets <em>most</em> of the requirements for PyroCMS. This means that PyroCMS should be able to run properly but there is a chance that you will experience problems with things such as image resizing and thumbnail creating.';
$lang['summary_failure']	=	'It seems that your server failed to meet the requirements to run PyroCMS. Please contact your server administrator or hosting company to get this resolved.';
$lang['next_step']		=	'Proceed to the next step';
$lang['step3']			=	'Step 3';
$lang['retry']			=	'Try again';

// messages
$lang['step1_failure']	=	'Please fill in the required database settings in the form below..';

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
