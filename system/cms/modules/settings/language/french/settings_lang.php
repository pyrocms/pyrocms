<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name'] 					= 'Nom du site';
$lang['settings:site_name_desc'] 				= 'Le nom du site. Ce nom sera utilisé dans le titre des pages ainsi que dans d\'autres emplacements';

$lang['settings:site_slogan'] 					= 'Slogan du site';
$lang['settings:site_slogan_desc'] 				= 'Le slogan du site. Ce nom sera utilisé dans le titre des pages ainsi que dans d\'autres emplacements.';

$lang['settings:site_lang']						= 'Langue du site';
$lang['settings:site_lang_desc']				= 'La langue native du site web, permet de choisir les modèles de notifications par emails.';

$lang['settings:contact_email'] 				= 'E-mail de contact';
$lang['settings:contact_email_desc'] 			= 'Tous les emails provenant des utilisateurs, des invités et du site seront adressés à cette adresse.';

$lang['settings:server_email'] 					= 'E-mail du serveur';
$lang['settings:server_email_desc'] 			= 'Tous les emails seront envoyés depuis le site auront pour expéditeur cette adresse email.';

$lang['settings:meta_topic']					= 'Balise Meta';
$lang['settings:meta_topic_desc']				= 'Deux ou trois mots décrivant le type de société / site web.';

$lang['settings:currency'] 						= 'Devise';
$lang['settings:currency_desc'] 				= 'Le symbole de la monnaie pour une utilisation sur les produits, services, etc.';

$lang['settings:dashboard_rss'] 				= 'Flux RSS du tableau de bord';
$lang['settings:dashboard_rss_desc'] 			= 'Lien vers un flux RSS qui sera affiché sur le tableau de bord.';

$lang['settings:dashboard_rss_count'] 			= 'Nombre d\'entrées RSS à afficher sur le tableau de bord';
$lang['settings:dashboard_rss_count_desc'] 		= 'Combien d\entrées RSS afficher sur le tableau de bord&nbsp;?';

$lang['settings:date_format'] 					= 'Format de date';
$lang['settings:date_format_desc']				= 'Comment les dates doivent être affichées dans le site et panel d\'administration&nbsp;? Utiliser le <a href="http://php.net/manual/en/function.date.php" target="_black">format de date</a> de PHP - OU - Utiliser le format de <a href="http://php.net/manual/en/function.strftime.php" target="_black">chaine formaté en tant que date</a> de PHP.';

$lang['settings:frontend_enabled'] 				= 'Statut du site';
$lang['settings:frontend_enabled_desc'] 		= 'Utilisez cette option pour mettre en ligne ou hors ligne le site. Utile lorsque vous voulez mettre le site en maintenance.';

$lang['settings:mail_protocol'] 				= 'Protocole email';
$lang['settings:mail_protocol_desc'] 			= 'Sélectionnez le protocole souhaité.';

$lang['settings:mail_sendmail_path'] 			= 'Chemin du serveur Sendmail';
$lang['settings:mail_sendmail_path_desc']		= 'Chemin vers l\'exécutable du serveur Sendmail';

$lang['settings:mail_smtp_host'] 				= 'Hôte SMTP Host';
$lang['settings:mail_smtp_host_desc'] 			= 'Le nom d\'hôte du serveur SMTP';

$lang['settings:mail_smtp_pass'] 				= 'Mot de passe SMTP';
$lang['settings:mail_smtp_pass_desc'] 			= 'Le mot de passe SMTP.';

$lang['settings:mail_smtp_port'] 				= 'Port SMTP';
$lang['settings:mail_smtp_port_desc'] 			= 'Le numéro du port SMTP.';

$lang['settings:mail_smtp_user'] 				= 'Nom d\'utilisateur SMTP';
$lang['settings:mail_smtp_user_desc'] 			= 'Le nom d\'utilisateur SMTP.';

$lang['settings:unavailable_message']			= 'Message non disponible';
$lang['settings:unavailable_message_desc'] 		= 'Lorsque le site est en mode "hors ligne" ou s\'il ya un problème majeur, ce message sera indiqué aux utilisateurs.';

$lang['settings:default_theme'] 				= 'Thème par défaut';
$lang['settings:default_theme_desc'] 			= 'Sélectionnez le thème que vous souhaitez que les utilisateurs voie par défaut.';

$lang['settings:activation_email'] 				= 'E-mail d\'activation';
$lang['settings:activation_email_desc'] 		= 'Envoyer un e-mail quand un utilisateur s\'inscrit avec un lien d\'activation. Désactiver cette option pour laisser les admins activer les comptes.';

$lang['settings:records_per_page'] 				= 'Entrées par page';
$lang['settings:records_per_page_desc'] 		= 'Combien d\'entrées devons nous montrer par page ? (valable dans la partie publique du site et dans l\'interface d\'administration) Ex. : articles du blog, utilisateurs etc.';

$lang['settings:rss_feed_items'] 				= 'Nombre de flux RSS';
$lang['settings:rss_feed_items_desc'] 			= 'Nombre d\'entrée à afficher dans les flux blog et RSS ?';

$lang['settings:enable_profiles'] 				= 'Activer les profils';
$lang['settings:enable_profiles_desc'] 			= 'Permettre aux utilisateurs d\'ajouter et de modifier leurs profils.';

$lang['settings:ga_email'] 						= 'Google Analytic email';
$lang['settings:ga_email_desc']					= 'Adresse email utilisée pour Google Analytics. Cette information est requise pour afficher le graphique sur le tableau de bord.';

$lang['settings:ga_password'] 					= 'Mot de passe Google Analytics';
$lang['settings:ga_password_desc']				= 'Le mot de passe Google Analytics. Cette information est requise pour afficher le graphique sur le tableau de bord.';

$lang['settings:ga_profile'] 					= 'Profil Google Analytics';
$lang['settings:ga_profile_desc']				= 'ID du profil pour ce site dans Google Analytics.';

$lang['settings:ga_tracking'] 					= 'Code Google Tracking';
$lang['settings:ga_tracking_desc']				= 'Code de tracking Google Analytics pour activer la capture de données de visites. Ex. : UA-19483569-6';

$lang['settings:akismet_api_key'] 				= 'Clé d\'API Akismet';
$lang['settings:akismet_api_key_desc'] 			= 'Askimet est un anti-spam crée par l\'équipe de Wordpress. Il limite les spam sans obliger les utilisateurs à valider une CAPTCHA';

$lang['settings:comment_order'] 				= 'Ordre d\'affichage';
$lang['settings:comment_order_desc']			= 'Ordre dans lequel afficher les commentaires.';

$lang['settings:enable_comments'] 				= 'Activer les commentaires';
$lang['settings:enable_comments_desc']			= 'Autoriser les utilisateurs à poster des commentaires&nbsp;?';

$lang['settings:moderate_comments'] 			= 'Modérer les commentaires';
$lang['settings:moderate_comments_desc']		= 'Exige l\'approbation des commentaires avant leur publication sur le site.';

$lang['settings:comment_markdown']				= 'Autoriser Markdown';
$lang['settings:comment_markdown_desc']			= 'Voulez vous autoriser les internautes à poster des commentaires en utilisant Markdown&nbsp;?';

$lang['settings:version'] 						= 'Version';
$lang['settings:version_desc'] 					= '';

$lang['settings:site_public_lang']				= 'Langues Publiques';
$lang['settings:site_public_lang_desc']			= 'Quelles sont les langues disponibles sur le front-end de votre site web&nbsp;?';

$lang['settings:admin_force_https']				= 'Forcer le protocole HTTPS pour le panneau d\'administration&nbsp;?';
$lang['settings:admin_force_https_desc']		= 'Autoriser uniquement le protocole HTTPS quand vous utiliser le panneau d\'administration&nbsp;?';

$lang['settings:files_cache']					= 'Cache des fichiers';
$lang['settings:files_cache_desc']				= 'Quel est le temps d\expiration du cache pour les images du site&nbsp;?';

$lang['settings:auto_username']					= 'Nom d\'utilisateur automatique';
$lang['settings:auto_username_desc']			= 'Créer le nom d\'utilisateur automatiquement lorsqu\'un compte est créé sur le site.';

$lang['settings:registered_email']				= 'Email de notification d\'inscription';
$lang['settings:registered_email_desc']			= 'Envoi un email de notification à l\'adresse email de contact de l\'utilisateur quand il s\'enregistre.';

$lang['settings:ckeditor_config']               = 'Configuration CKEditor';
$lang['settings:ckeditor_config_desc']          = 'Vous pouvez trouver une liste d\'éléments de configuration dans <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">la documentation de CKEditor.</a>';

$lang['settings:enable_registration']           = 'Activer l\'enregistrement des utilisateurs';
$lang['settings:enable_registration_desc']      = 'Autoriser les utilisateurs à s\'inscrire sur votre siteAllow .';

$lang['settings:profile_visibility']            = 'Visibilité du Profil';
$lang['settings:profile_visibility_desc']       = 'Permet de spécifier qui peut voir les profils utilisateurs sur le site public';

$lang['settings:cdn_domain']                    = 'Domaine CDN';
$lang['settings:cdn_domain_desc']               = 'Domaines CDN autorisant de décharger des contenus statiques sur différents serveurs comme Amazon CloudFront ou MaxCDN';

#section titles
$lang['settings:section_general']				= 'Général';
$lang['settings:section_integration']			= 'Intégration';
$lang['settings:section_comments']				= 'Commentaires';
$lang['settings:section_users']					= 'Utilisateurs';
$lang['settings:section_statistics']			= 'Statistiques';
$lang['settings:section_files']					= 'Fichiers';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'Ouvrir';
$lang['settings:form_option_Closed']			= 'Fermé';
$lang['settings:form_option_Enabled']			= 'Activé';
$lang['settings:form_option_Disabled']			= 'Désactivé';
$lang['settings:form_option_Required']			= 'Requis';
$lang['settings:form_option_Optional']			= 'Optionnel';
$lang['settings:form_option_Oldest First']		= 'Du plus ancien au plus récent';
$lang['settings:form_option_Newest First']		= 'Du plus récent au plus ancien';
$lang['settings:form_option_Text Only']			= 'Texte seulement';
$lang['settings:form_option_Allow Markdown']	= 'Autoriser Markdown';
$lang['settings:form_option_Yes']				= 'Oui';
$lang['settings:form_option_No']				= 'Non';
$lang['settings:form_option_profile_public']	= 'Visible par tout le monde';
$lang['settings:form_option_profile_owner']		= 'Visible uniquement par le propriétaire du profil';
$lang['settings:form_option_profile_hidden']	= 'Jamais visible';
$lang['settings:form_option_profile_member']	= 'Visible par tout les utilisateurs connectés';
$lang['settings:form_option_activate_by_email']          = 'Activer par mail';
$lang['settings:form_option_activate_by_admin']        	= 'Activer par un administrateur';
$lang['settings:form_option_no_activation']         	= 'Pas d\'activation';

// messages
$lang['settings:no_settings']					= 'Il n\'y a aucun paramétrages actuellement.';
$lang['settings:save_success'] 					= 'Vos paramètres ont été enregistrés !';

/* End of file settings_lang.php */