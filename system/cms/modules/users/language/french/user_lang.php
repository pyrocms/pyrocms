<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                = 'Ajouter un champ de profil utilisateur';
$lang['user:profile_delete_success']   = 'Champ de profil utilisateur supprimé avec succès';
$lang['user:profile_delete_failure']   = 'Il y a eu un problème lors de la suppresion du champ de profil utilisateur';
$lang['profile_user_basic_data_label'] = 'Données basiques';
$lang['profile_company']               = 'Entreprise';
$lang['profile_updated_on']            = 'Mis à jour le';
$lang['user:profile_fields_label']     = 'Champ de profil';

$lang['user:register_header'] = 'Enregistrement';
$lang['user:register_step1']  = '<strong>Etape 1&nbsp;:</strong> Enregistrez-vous';
$lang['user:register_step2']  = '<strong>Etape 2&nbsp;:</strong> Activation';

$lang['user:login_header'] = 'Login';

// titles
$lang['user:add_title']       = 'Créer un utilisateur';
$lang['user:list_title']      = 'Lister les utilisateurs';
$lang['user:inactive_title']  = 'Utilisateurs inactifs';
$lang['user:active_title']    = 'Utilisateurs actifs';
$lang['user:registred_title'] = 'Utilisateurs enregistrés';

// labels
$lang['user:edit_title']             = 'Modifier l\'utilisateur "%s"';
$lang['user:details_label']          = 'Détails';
$lang['user:first_name_label']       = 'Prénom';
$lang['user:last_name_label']        = 'Nom';
$lang['user:group_label']            = 'Rôle';
$lang['user:activate_label']         = 'Activé';
$lang['user:password_label']         = 'Mot de passe';
$lang['user:password_confirm_label'] = 'Confirmez mot de passe';
$lang['user:name_label']             = 'Surnom';
$lang['user:joined_label']           = 'Inscrit';
$lang['user:last_visit_label']       = 'Dernière visite';
$lang['user:never_label']            = 'Jamais';

$lang['user:no_inactives'] = 'Il n\'y a aucun utilisateurs actifs.';
$lang['user:no_registred'] = 'Il n\'y a aucun utilisateurs enregistrés.';

$lang['account_changes_saved'] = 'Les modifications apportées à votre compte ont été sauvegardées avec succès.';

$lang['indicates_required'] = 'Désignez les champs obligatoires';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Envoyer un Email d\'activation';
$lang['user:do_not_activate']                  = 'Inactif';
$lang['user:register_title']          = 'Enregistrez-vous';
$lang['user:activate_account_title']  = 'Activez le compte';
$lang['user:activate_label']          = 'Activez';
$lang['user:activated_account_title'] = 'Compte activé';
$lang['user:reset_password_title']    = 'Réinitialisez le mot de passe';
$lang['user:password_reset_title']    = 'Mot de passe réinitialisé';


$lang['user:error_username'] = 'Le nom d\'utilisateur que vous avez entré est déjà utilisé';
$lang['user:error_email']    = 'L\'adresse email que vous avez entré est déjà utilisée';

$lang['user:full_name']      = 'Nom Complet';
$lang['user:first_name']     = 'Prénom';
$lang['user:last_name']      = 'Nom';
$lang['user:username']       = 'Nom Utilisateur';
$lang['user:display_name']   = 'Pseudonyme';
$lang['user:email_use']      = 'utilisé pour se connecter';
$lang['user:remember']       = 'Rester connecté';
$lang['user:group_id_label'] = 'ID Groupe';

$lang['user:level']  = 'Rôle utilisateur';
$lang['user:active'] = 'Activez';
$lang['user:lang']   = 'Langue';

$lang['user:activation_code'] = 'Code d\'activation';

$lang['user:reset_instructions']  = 'Entre votre email ou votre Nom Utilisateur';
$lang['user:reset_password_link'] = 'Mot de passe oublié ?';

$lang['user:activation_code_sent_notice'] = 'Un e-mail vous a été envoyé avec votre code d\'activation.';
$lang['user:activation_by_admin_notice']  = 'Votre enregistrement est en attente d\'approbation par l\'administrateur.';
$lang['user:registration_disabled']       = 'Désolé, l\'inscription de nouveaux utilisateurs est désactivée.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section']        = 'Nom';
$lang['user:password_section']       = 'Changer de mot de passe';
$lang['user:other_settings_section'] = 'Autres paramètres';

$lang['user:settings_saved_success'] = 'Les paramètres de votre compte utilisateur ont été enregistrées.';
$lang['user:settings_saved_error']   = 'Une erreur est survenue.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']   = 'Enregistrement';
$lang['user:activate_btn']   = 'Activation';
$lang['user:reset_pass_btn'] = 'Réinitialiser le Mot de passe';
$lang['user:login_btn']      = 'Connexion';
$lang['user:settings_btn']   = 'Sauvegarder les paramètres';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success'] = 'Un nouvel utilisateur a été créé et activé.';
$lang['user:added_not_activated_success'] = 'Un nouvel utilisateur a été créé, le compte a besoin d\'être activé.';

// Edit
$lang['user:edit_user_not_found_error'] = 'Utilisateur non trouvé.';
$lang['user:edit_success']              = 'Utilisateur mis à jour avec succès.';
$lang['user:edit_error']                = 'Une erreur est survenue en cours de mise à jour de l\'utilisateur.';

// Activate
$lang['user:activate_success'] = '%s utilisateurs sur %s activés avec succès.';
$lang['user:activate_error']   = 'Vous devez d\'abord seclectionner un utilisateur.';

// Delete
$lang['user:delete_self_error']   = 'Vous ne pouvez pas vous supprimer !';
$lang['user:mass_delete_success'] = '%s utilisateurs sur %s supprimés avec succès.';
$lang['user:mass_delete_error']   = 'Vous devez d\'abord seclectionner des utilisateurs.';

// Register
$lang['user:email_pass_missing'] = 'l\'e-mail ou le mot de passe ne sont pas renseignés.';
$lang['user:email_exists']       = 'L\'adresse e-mail choisie est déjà affectée à un autre utilisateur.';
$lang['user:register_error']     = 'Nous pensons que vous êtes un robot. Si nous faisons erreur, merci d\'daccepter nos excuses.';
$lang['user:register_reasons']   = 'Abonnez-vous pour accéder aux espaces réservés. Vos paramètres seront enregistrés, plus de contenu et moins de publicité.';


// Activation
$lang['user:activation_incorrect'] = 'L\'activation s\'est mal déroulée. S\'il vous plaît revoyer vos détails et assurez vous que les MAJUSCULES (CAPS LOCK) ne sont pas actives.';
$lang['user:activated_message']    = 'Votre compte a été activé, vous pouvez maintenant vous y connecter.';


// Login
$lang['user:logged_in']         = 'Vous êtes connecté.';
$lang['user:already_logged_in'] = 'Vous êtes déjà connecté. S\'il vous plaît déconnectez-vous avant de ré-essayer.';
$lang['user:login_incorrect']   = 'L\'email ou le mot de passe sont erronés. S\'il vous plaît vérifiez votre login et assurez vous que les MAJUSCULES (CAPS LOCK) ne sont pas actives.';
$lang['user:inactive']          = 'Le compte que vous tentez d\'accéder est inactif.<br />Vérifiez vos mails concernant l\'activation de votre compte - <em>il est peut être dans les spams</em>.';


// Logged Out
$lang['user:logged_out'] = 'Vous avez été déconnecté.';

// Forgot Pass
$lang['user:forgot_incorrect'] = 'Aucun compte correspondant à ces données n\'a été trouvé.';

$lang['user:password_reset_message'] = 'Votre mot de passe a été ré-initialisé. Vous devriez recevoir un e-mail dans les 2 heures suivantes. Sinon, il est peut être dans les spams par accident.';


// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject'] = 'Activation requise';
$lang['user:activation_email_body']    = 'Merci d\'avoir activé votre compte chez %s. Pour vous connecter au site, veuillez cliquer le lien ci-dessous:';


$lang['user:activated_email_subject']       = 'Activation Réussie';
$lang['user:activated_email_content_line1'] = 'Merci de vous être enregistré à %s. Avant de pouvoir activer votre compte, veuillez suivre entièrement le processus d\'enregistrement en cliquant sur le lien suivant :';
$lang['user:activated_email_content_line2'] = 'Si votre programme mail ne reconnaît pas le lien ci-dessus, entrez l\'URL suivante dans votre navigateur et saisissez le code d\'activation :';

// Reset Pass
$lang['user:reset_pass_email_subject'] = 'Mot de passe ré-initialisé';
$lang['user:reset_pass_email_body']    = 'Votre mot de passe à %s a été ré-initialisé. Si vous n\'avez pas demandé ce changement, veuillez nous envoyer un e-mail à %s et nous résoudrons la situation.';

// Profile
$lang['profile_of_title'] = 'Profil de %s';

$lang['profile_user_details_label'] = 'Détails utilisateur';
$lang['profile_role_label']         = 'Rôle';
$lang['profile_registred_on_label'] = 'Enregistré sur';
$lang['profile_last_login_label']   = 'Dernière connexion';
$lang['profile_male_label']         = 'Homme';
$lang['profile_female_label']       = 'Femme';
$lang['user:profile_fields_label']  = 'Champs de Profil';

$lang['profile_not_set_up'] = 'Cet utilisateur n\'a pas de profil configuré.';

$lang['profile_edit'] = 'Modifier votre profil';

$lang['profile_personal_section'] = 'Privé';

$lang['profile_display_name']  = 'Nom Affiché';
$lang['profile_dob']           = 'Date de naissance';
$lang['profile_dob_day']       = 'Jour';
$lang['profile_dob_month']     = 'Mois';
$lang['profile_dob_year']      = 'Année';
$lang['profile_gender']        = 'Civilité';
$lang['profile_gender_nt']     = 'Non spécifié';
$lang['profile_gender_male']   = 'Masculin';
$lang['profile_gender_female'] = 'Féminin';
$lang['profile_bio']           = 'A mon sujet';

$lang['profile_contact_section'] = 'Contact';

$lang['profile_phone']            = 'Téléphone';
$lang['profile_mobile']           = 'Mobile';
$lang['profile_address']          = 'Adresse';
$lang['profile_address_line1']    = 'Ligne 1';
$lang['profile_address_line2']    = 'Ligne 2';
$lang['profile_address_line3']    = 'Village/Ville';
$lang['profile_address_postcode'] = 'Code Postal';
$lang['profile_website']          = 'Site Internet';

$lang['profile_api_section'] = 'Accès API';

$lang['profile_edit_success'] = 'Votre profil à bien été sauvegardé.';
$lang['profile_edit_error']   = 'Une erreur à eu lieu.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn'] = 'Enregistrer votre profil';
/* End of file user_lang.php */