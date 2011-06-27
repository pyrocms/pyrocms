<?php

$lang['user_register_header'] 	= 'Enregistrement';
$lang['user_register_step1'] 	= '<strong>Etape 1:</strong> Enregistrez-vous';
$lang['user_register_step2'] 	= '<strong>Etape 2:</strong> Activation';

$lang['user_login_header'] 		= 'Login';

// titles
$lang['user_add_title'] = 'Créer un utilisateur';
$lang['user_list_title'] 				= 'Lister les utilisateurs';
$lang['user_inactive_title'] = 'Utilisateurs inactifs';
$lang['user_active_title'] = 'Utilisateurs actifs';
$lang['user_registred_title'] = 'Utilisateurs enregistrés';

// labels
$lang['user_edit_title'] = 'Modifier l\'utilisateur "%s"';
$lang['user_details_label'] = 'Détails';
$lang['user_first_name_label'] = 'Prénom';
$lang['user_last_name_label'] = 'Nom';
$lang['user_email_label'] = 'E-mail';
$lang['user_group_label'] = 'Rôle';
$lang['user_activate_label'] = 'Activé';
$lang['user_password_label'] = 'Mot de passe';
$lang['user_password_confirm_label'] = 'Confirmez mot de passe';
$lang['user_name_label'] = 'Surnom';
$lang['user_joined_label'] = 'Inscrit';
$lang['user_last_visit_label'] = 'Dernière visite';
$lang['user_actions_label'] = 'Actions';
$lang['user_never_label'] = 'Jamais';
$lang['user_delete_label'] = 'Supprimer';
$lang['user_edit_label'] = 'Modifier';
$lang['user_view_label'] = 'Visualiser';

$lang['user_no_inactives'] = 'Il n\'y a aucun utilisateurs actifs.';
$lang['user_no_registred'] = 'Il n\'y a aucun utilisateurs enregistrés.';

$lang['account_changes_saved'] = 'Les modifications apportées à votre compte ont été sauvegardées avec succès.';

$lang['indicates_required'] = 'Désignez les champs obligatoires';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_register_title'] = 'Enregistrez-vous';
$lang['user_activate_account_title'] = 'Activez le compte';
$lang['user_activate_label'] = 'Activez';
$lang['user_activated_account_title'] = 'Compte activé';
$lang['user_reset_password_title'] = 'Réinitialisez le mot de passe';
$lang['user_password_reset_title'] = 'Mot de passe réinitialisé';

$lang['user_full_name'] 	= 'Nom Complet';
$lang['user_first_name'] 	= 'Prénom';
$lang['user_last_name'] 	= 'Nom';
$lang['user_email_use'] 					   = 'used to login'; #translate
$lang['user_email'] 		= 'E-mail';
$lang['user_confirm_email'] = 'Confirmez E-mail';
$lang['user_password'] 		= 'Mot de passe';
$lang['user_confirm_password'] = 'Confirmez Mot de passe';

$lang['user_level']			= 'Rôle utilisateur';
$lang['user_active']		= 'Activez';
$lang['user_lang']			= 'Langue';

$lang['user_activation_code'] = 'Code d\'activation';

$lang['user_reset_password_link'] = 'Mot de passe oublié ?';

$lang['user_activation_code_sent_notice'] = 'Un e-mail vous a été envoyé avec votre code d\'activation.';
$lang['user_activation_by_admin_notice'] = 'Votre enregistrement est en attente d\'approbation par l\'administrateur.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section'] = 'Nom';
$lang['user_password_section'] = 'Changer de mot de passe';
$lang['user_other_settings_section'] = 'Autres paramètres';

$lang['user_settings_saved_success'] 	= 'Les paramètres de votre compte utilisateur ont été enregistrées.';
$lang['user_settings_saved_error'] 		= 'Une erreur est survenue.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']		= 'Enregistrement';
$lang['user_activate_btn']		= 'Activation';
$lang['user_reset_pass_btn'] 	= 'Réinit Mot de passe';
$lang['user_login_btn'] 		= 'Connexion';
$lang['user_settings_btn'] 		= 'Sauvegarder les paramètres';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success'] 		= 'Un nouvel utilisateur a été créé et activé.';
$lang['user_added_not_activated_success'] 		= 'Un nouvel utilisateur a été créé, le compte a besoin d\'être activé.';

// Edit
$lang['user_edit_user_not_found_error'] 			= 'Utilisateur non trouvé.';
$lang['user_edit_success'] 										= 'Utilisateur mis à jour avec succès.';
$lang['user_edit_error'] 											= 'Une erreur est survenue en cours de mise à jour de l\'utilisateur.';

// Activate
$lang['user_activate_success'] 								= '%s utilisateurs sur %s activés avec succès.';
$lang['user_activate_error'] 									= 'Vous devez d\'abord seclectionner un utilisateur.';

// Delete
$lang['user_delete_self_error'] 							= 'Vous ne pouvez pas vous supprimer !';
$lang['user_mass_delete_success'] 						= '%s utilisateurs sur %s supprimés avec succès.';
$lang['user_mass_delete_error'] 							= 'Vous devez d\'abord seclectionner des utilisateurs.';

// Register
$lang['user_email_pass_missing'] = 'l\'e-mail ou le mot de passe ne sont pas renseignés.';
$lang['user_email_exists'] = 'L\'adresse e-mail choisie est déjà affectée à un autre utilisateur.';
$lang['user_register_reasons'] = 'Abonnez-vous pour accéder aux espaces réservés. Vos paramètres seront enregistrés, plus de contenu et moins de publicité.';


// Activation
$lang['user_activation_incorrect']   = 'L\'activation s\'est mal déroulée. S\'il vous plaît revoyer vos détails et assurez vous que les MAJUSCULES (CAPS LOCK) ne sont pas actives.';
$lang['user_activated_message']   = 'Votre compte a été activé, vous pouvez maintenant vous y connecter.';


// Login
$lang['user_logged_in']							= 'Vous êtes connecté.';
$lang['user_already_logged_in'] = 'Vous êtes déjà connecté. S\'il vous plaît déconnectez-vous avant de ré-essayer.';
$lang['user_login_incorrect'] = 'L\'email ou le mot de passe sont erronés. S\'il vous plaît vérifiez votre login et assurez vous que les MAJUSCULES (CAPS LOCK) ne sont pas actives.';
$lang['user_inactive']   = 'Le compte que vous tentez d\'accéder est inactif.<br />Vérifiez vos mails concernant l\'activation de votre compte - <em>il est peut être dans les spams</em>.';


// Logged Out
$lang['user_logged_out']   = 'Vous avez été déconnecté.';


// Forgot Pass
$lang['user_forgot_incorrect']   = "Aucun compte correspondant à ces données n\'a été trouvé.";

$lang['user_password_reset_message']   = "Votre mot de passe a été ré-initialisé. Vous devriez recevoir un e-mail dans les 2 heures suivantes. Sinon, il est peut être dans les spams par accident.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject'] = 'Activation requise';
$lang['user_activation_email_body'] = 'Merci d\'avoir activé votre compte chez %s. Pour vous connecter au site, veuillez cliquer le lien ci-dessous:';


$lang['user_activated_email_subject'] = 'Activation Réussie';
$lang['user_activated_email_content_line1'] = 'Merci de vous être enregistré à %s. Avant de pouvoir activer votre compte, veuillez suivre entièrement le processus d\'enregistrement en cliquant sur le lien suivant :';
$lang['user_activated_email_content_line2'] = 'Si votre programme mail ne reconnaît pas le lien ci-dessus, entrez l\'URL suivante dans votre navigateur et saisissez le code d\'activation :';

// Reset Pass
$lang['user_reset_pass_email_subject'] = 'Mot de passe ré-initialisé';
$lang['user_reset_pass_email_body'] = 'Votre mot de passe à %s a été ré-initialisé. Si vous n\'avez pas demandé ce changement, veuillez nous envoyer un e-mail à %s et nous résoudrons la situation.';

// Profile
$lang['profile_of_title'] = 'Profil de %s';

$lang['profile_user_details_label'] = 'Détails utilisateur';
$lang['profile_role_label'] = 'Rôle';
$lang['profile_registred_on_label'] = 'Enregistré sur';
$lang['profile_last_login_label'] = 'Dernière connexion';
$lang['profile_male_label'] = 'Homme';
$lang['profile_female_label'] = 'Femme';

$lang['profile_not_set_up'] = 'Cet utilisateur n\'a pas de profil configuré.';

$lang['profile_edit'] = 'Modifier votre profil';

$lang['profile_personal_section'] = 'Privé';

$lang['profile_dob']		= 'Date de naissance';
$lang['profile_dob_day']	= 'Jour';
$lang['profile_dob_month']	= 'Mois';
$lang['profile_dob_year']	= 'Année';
$lang['profile_gender']		= 'Civilité';
$lang['profile_gender_nt']            = 'Not Telling'; #translate
$lang['profile_gender_male']          = 'Male'; #translate
$lang['profile_gender_female']        = 'Female'; #translate
$lang['profile_bio']		= 'A mon sujet';

$lang['profile_contact_section'] = 'Contact';

$lang['profile_phone']		= 'Téléphone';
$lang['profile_mobile']		= 'Mobile';
$lang['profile_address']	= 'Adresse';
$lang['profile_address_line1'] = 'Ligne 1';
$lang['profile_address_line2'] = 'Ligne 2';
$lang['profile_address_line3'] = 'Ligne 3';
$lang['profile_address_postcode'] = 'Code Postal';

$lang['profile_messenger_section'] = 'Messageries instantanées';

$lang['profile_msn_handle'] = 'MSN';
$lang['profile_aim_handle'] = 'AIM';
$lang['profile_yim_handle'] = 'Yahoo! messenger';
$lang['profile_gtalk_handle'] = 'GTalk';

$lang['profile_avatar_section'] = 'Avatar';

$lang['profile_gravatar'] = 'Gravatar';

$lang['profile_edit_success'] = 'Votre profil a été enregistré.';
$lang['profile_edit_error'] = 'Une erreur est survenue.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn'] = 'Enregistrer votre profil';
