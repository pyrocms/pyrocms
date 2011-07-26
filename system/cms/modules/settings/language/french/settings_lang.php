<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['settings_save_success'] 					= 'Vos paramètres ont été enregistrés !';
$lang['settings_edit_title'] 					= 'Modifier les paramètres';

#section settings
$lang['settings_site_name'] 					= 'Nom du site';
$lang['settings_site_name_desc'] 				= 'Le nom du site. Ce nom sera utilisé dans le titre des pages ainsi que dans d\'autres emplacements';

$lang['settings_site_slogan'] 					= 'Slogan du site';
$lang['settings_site_slogan_desc'] 				= 'Le slogan du site. Ce nom sera utilisé dans le titre des pages ainsi que dans d\'autres emplacements.';

$lang['settings_site_lang']						= 'Langue du site';
$lang['settings_site_lang_desc']				= 'The native language of the website, used to choose templates of e-mail internal notifications and receiving visitors contact and other features that should not bend the language of a user.'; #translate

$lang['settings_contact_email'] 				= 'E-mail de contact';
$lang['settings_contact_email_desc'] 			= 'Tous les emails provenant des utilisateurs, des invités et du site seront adressés à cette adresse.';

$lang['settings_server_email'] 					= 'E-mail du serveur';
$lang['settings_server_email_desc'] 			= 'Tous les emails seront envoyés depuis le site auront pour expéditeur cette adresse email.';

$lang['settings_meta_topic']					= 'Balise Meta';
$lang['settings_meta_topic_desc']				= 'Deux ou trois mots décrivant le type de société / site web.';

$lang['settings_currency'] 						= 'Devise';
$lang['settings_currency_desc'] 				= 'Le symbole de la monnaie pour une utilisation sur les produits, services, etc.';

$lang['settings_dashboard_rss'] 				= 'Flux RSS du tableau de bord';
$lang['settings_dashboard_rss_desc'] 			= 'Lien vers un flux RSS qui sera affiché sur le tableau de bord.';

$lang['settings_dashboard_rss_count'] 			= 'Nombre d\'entrées RSS à afficher sur le tableau de bord';
$lang['settings_dashboard_rss_count_desc'] 		= 'Combien d\entrées RSS afficher sur le tableau de bord ?';

$lang['settings_date_format'] 					= 'Format de date';
$lang['settings_date_format_desc']				= 'Comment les dates doivent être affichées dans le site et panel d\'administration ?' .
													'Utilser le<a href="http://php.net/manual/en/function.date.php" target="_black">format de date</a> de PHP - OU - ' .
													'Utiliser le format de <a href="http://php.net/manual/en/function.strftime.php" target="_black">chaine formaté en tant que date</a> de PHP.';

$lang['settings_frontend_enabled'] 				= 'Statut du site';
$lang['settings_frontend_enabled_desc'] 		= 'Utilisez cette option pour mettre en ligne ou hors ligne le site. Utile lorsque vous voulez mettre le site en maintenance.';

$lang['settings_mail_protocol'] 				= 'Protocole email'; 
$lang['settings_mail_protocol_desc'] 			= 'Sélectionnez le protocole souhaité.';

$lang['settings_mail_sendmail_path'] 			= 'Chemin du serveur Sendmail'; 
$lang['settings_mail_sendmail_path_desc']		= 'Chemin vers l\'exécutable du serveur Sendmail';

$lang['settings_mail_smtp_host'] 				= 'Hôte SMTP Host';
$lang['settings_mail_smtp_host_desc'] 			= 'Le nom d\'hôte du serveur SMTP'; 

$lang['settings_mail_smtp_pass'] 				= 'Mot de passe SMTP';
$lang['settings_mail_smtp_pass_desc'] 			= 'Le mot de passe SMTP.';

$lang['settings_mail_smtp_port'] 				= 'Port SMTP'; 
$lang['settings_mail_smtp_port_desc'] 			= 'Le numéro du port SMTP.';

$lang['settings_mail_smtp_user'] 				= 'Nom d\'utilisateur SMTP';
$lang['settings_mail_smtp_user_desc'] 			= 'Le nom d\'utilisateur SMTP.';

$lang['settings_unavailable_message']			= 'Message non disponible';
$lang['settings_unavailable_message_desc'] 		= 'Lorsque le site est en mode "hors ligne" ou s\'il ya un problème majeur, ce message sera indiqué aux utilisateurs.';

$lang['settings_default_theme'] 				= 'Thème par défaut';
$lang['settings_default_theme_desc'] 			= 'Sélectionnez le thème que vous souhaitez que les utilisateurs voie par défaut.';

$lang['settings_activation_email'] 				= 'E-mail d\'activation';
$lang['settings_activation_email_desc'] 		= 'Envoyer un e-mail quand un utilisateur s\'inscrit avec un lien d\'activation. Désactiver cette option pour laisser les admins activer les comptes.';

$lang['settings_records_per_page'] 				= 'Enregistrements par page';
$lang['settings_records_per_page_desc'] 		= 'Combien d\'enregistrements devons nous montrer par page dans la section admin?';

$lang['settings_rss_feed_items'] 				= 'Nombre de flux RSS';
$lang['settings_rss_feed_items_desc'] 			= 'Nombre d\'entrée à afficher dans les flux blog et RSS ?';

$lang['settings_require_lastname'] 				= 'Nom requis ?';
$lang['settings_require_lastname_desc'] 		= 'Dans certains cas le nom est obligatoire. Forcer l\'utilisateur à saisir un nom ?';

$lang['settings_enable_profiles'] 				= 'Activer les profils';
$lang['settings_enable_profiles_desc'] 			= 'Permettre aux utilisateurs d\'ajouter et de modifier leurs profils.';

$lang['settings_ga_email'] 						= 'Google Analytic email';
$lang['settings_ga_email_desc']					= 'Adresse email utilisée pour Google Analytics. Cette information est requise pour afficher le graphique sur le tableau de bord.'; 

$lang['settings_ga_password'] 					= 'Mot de passe Google Analytics';
$lang['settings_ga_password_desc']				= 'Le mot de passe Google Analytics. Cette information est requise pour afficher le graphique sur le tableau de bord.'; 

$lang['settings_ga_profile'] 					= 'Profil Google Analytics'; 
$lang['settings_ga_profile_desc']				= 'ID du profil pour ce site dans Google Analytics.'; 

$lang['settings_ga_tracking'] 					= 'Code Google Tracking'; 
$lang['settings_ga_tracking_desc']				= 'Code de tracking Google Analytics pour activer la capture de données de visites. Ex. : UA-19483569-6'; 

$lang['settings_twitter_username'] 				= 'Nom d\'utilisateur';
$lang['settings_twitter_username_desc'] 		= 'Nom d\'utilisateur Twitter.';

$lang['settings_twitter_consumer_key'] 			= 'Clé du compte';
$lang['settings_twitter_consumer_key_desc'] 	= 'Clé du compte Twitter.';

$lang['settings_twitter_consumer_key_secret'] 	= 'Clé secrète du compte';
$lang['settings_twitter_consumer_key_secret_desc'] = 'Clé secrète du compte Twitter.';

$lang['settings_twitter_blog']					= 'Intégrations de Twitter &amp; des blogs.';
$lang['settings_twitter_blog_desc'] 			= 'Poster les liens des articles sur Twitter';

$lang['settings_twitter_feed_count'] 			= 'Nombre de tweets';
$lang['settings_twitter_feed_count_desc'] 		= 'Combien de tweet doivent être affiché dans le block Twitter ?';

$lang['settings_twitter_cache'] 				= 'Durée de vie du cache';
$lang['settings_twitter_cache_desc'] 			= 'Combien de temps conserver les tweets dans le cache';

$lang['settings_akismet_api_key'] 				= 'Clé d\'API Akismet';
$lang['settings_akismet_api_key_desc'] 			= 'Askimet est un anti-spam crée par l\'équipe de Wordpress. Il limite les spam sans obliger les utilisateurs à valider une CAPTCHA';

$lang['settings_comment_order'] 				= 'Ordre d\'affichage'; 
$lang['settings_comment_order_desc']			= 'Ordre dans lequel afficher les commentaires.'; 

$lang['settings_moderate_comments'] 			= 'Modérer les commentaires';
$lang['settings_moderate_comments_desc']		= 'Exige l\'approbation des commentaires avant leur publication sur le site.';

$lang['settings_version'] 						= 'Version';
$lang['settings_version_desc'] 					= '';

#section titles
$lang['settings_section_general']				= 'Général';
$lang['settings_section_integration']			= 'Intégration';
$lang['settings_section_comments']				= 'Commentaires'; 
$lang['settings_section_users']					= 'Utilisateurs';
$lang['settings_section_statistics']			= 'Statistiques';
$lang['settings_section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Ouvrir';
$lang['settings_form_option_Closed']			= 'Fermé';
$lang['settings_form_option_Enabled']			= 'Activé';
$lang['settings_form_option_Disabled']			= 'Désactivé';
$lang['settings_form_option_Required']			= 'Requis';
$lang['settings_form_option_Optional']			= 'Optionnel';
$lang['settings_form_option_Oldest First']		= 'Du plus ancien au plus récent'; 
$lang['settings_form_option_Newest First']		= 'Du plus récent au plus ancien'; 

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/french/settings_lang.php */
