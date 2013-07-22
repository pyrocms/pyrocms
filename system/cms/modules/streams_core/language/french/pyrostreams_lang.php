<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] = "Problème rencontré lors de la sauvegarde de votre champ.";
$lang['streams:field_add_success'] = "champ ajouté avec succès.";
$lang['streams:field_update_error'] = "Un problème a été rencontré lors de la mise à jour de votre champ.";
$lang['streams:field_update_success'] = "champ mis à jour avec succès.";
$lang['streams:field_delete_error'] = "Un problème a été rencontré lors de la suppression de ce champ.";
$lang['streams:field_delete_success'] = "champ supprimé avec succès.";
$lang['streams:view_options_update_error'] = "Un problème a été rencontré lors de la mise à jour des options d'affichage.";
$lang['streams:view_options_update_success'] = "Les options d'affichage ont été mises à jour avec succès.";
$lang['streams:remove_field_error'] = "Il y a eu un problème lors de la suppression de ce champ.";
$lang['streams:remove_field_success'] = "champ supprimé avec succès.";
$lang['streams:create_stream_error'] = "Un problème a été rencontré lors de la création de votre flux.";
$lang['streams:create_stream_success'] = "Flux créé avec succès.";
$lang['streams:stream_update_error'] = "Un problème a été rencontré lors de la mise à jour de ce flux.";
$lang['streams:stream_update_success'] = "Flux mis à jour avec succès.";
$lang['streams:stream_delete_error'] = "Un problème a été rencontré lors de la suppression de ce flux.";
$lang['streams:stream_delete_success'] = "Flux supprimé avec succès.";
$lang['streams:stream_field_ass_add_error'] = "Un problème a été rencontré lors de l'ajout de ce champ au flux.";
$lang['streams:stream_field_ass_add_success'] = "champ ajouté au flux avec succès.";
$lang['streams:stream_field_ass_upd_error'] = "Un problème a été rencontré lors de la mise à jour de l'affectation du champ.";
$lang['streams:stream_field_ass_upd_success'] = "Affectation du champ mis à jour avec succès.";
$lang['streams:delete_entry_error'] = "Un problème a été rencontré lors de la suppression de cette entrée.";
$lang['streams:delete_entry_success'] = "Entrée supprimée avec succès.";
$lang['streams:new_entry_error'] = "Un problème a été rencontré lors de l'ajout de cette entrée.";
$lang['streams:new_entry_success'] = "Entrée ajoutée avec succès.";
$lang['streams:edit_entry_error'] = "Un problème a été rencontré lors de la mise à jour de cette entrée.";
$lang['streams:edit_entry_success'] = "Entrée mise à jour avec succès.";
$lang['streams:delete_summary'] = "Êtes-vous sûr(e) de vouloir supprimer le flux <strong>%s</strong>&nbsp;? Ceci <strong>supprimera %s %s</strong> de façon permanente.";

/* Misc Errors */

$lang['streams:no_stream_provided'] = "Aucun flux n'a été fourni.";
$lang['streams:invalid_stream'] = "Flux non valide.";
$lang['streams:not_valid_stream'] = "n'\est pas un flux valide.";
$lang['streams:invalid_stream_id'] = "ID de flux non valide.";
$lang['streams:invalid_row'] = "Colonne non valide.";
$lang['streams:invalid_id'] = "ID non valide.";
$lang['streams:cannot_find_assign'] = "Impossible de trouver l'affectation du champ.";
$lang['streams:cannot_find_pyrostreams'] = "Impossible de trouver PyroStreams.";
$lang['streams:table_exists'] = "Une table avec le slug %s existe déjà.";
$lang['streams:no_results'] = "Aucun résultat";
$lang['streams:no_entry'] = "Impossible de trouver une entrée.";
$lang['streams:invalid_search_type'] = "Recherche non valide.";
$lang['streams:search_not_found'] = "Recherche introuvable.";

/* Validation Messages */

$lang['streams:field_slug_not_unique'] = "Ce slug de champ est déjà utilisé.";
$lang['streams:not_mysql_safe_word'] = "Le champ %s est un mot-clé réservé à MySQL.";
$lang['streams:not_mysql_safe_characters'] = "Le champ %s contient des caractères non-autorisés.";
$lang['streams:type_not_valid'] = "Merci de choisir un type de champ valide.";
$lang['streams:stream_slug_not_unique'] = "Ce slug de flux est déjà utilisé.";
$lang['streams:field_unique'] = "Le champ %s doit être unique.";
$lang['streams:field_is_required'] = "Le champ %s est requis.";
$lang['streams:date_out_or_range'] = "La date que vous avez sélectionnée est en dehors de l\intervalle de temps acceptable.";

/* Field Labels */

$lang['streams:label.field'] = "champ";
$lang['streams:label.field_required'] = "champ requis";
$lang['streams:label.field_unique'] = "champ unique";
$lang['streams:label.field_instructions'] = "Instructions du champ";
$lang['streams:label.make_field_title_column'] = "Faire de ce champ le titre de la colonne";
$lang['streams:label.field_name'] = "Nom du champ";
$lang['streams:label.field_slug'] = "Slug du champ";
$lang['streams:label.field_type'] = "Type de champ";
$lang['streams:id'] = "ID";
$lang['streams:created_by'] = "Créé par";
$lang['streams:created_date'] = "Créé le";
$lang['streams:updated_date'] = "Mis à jour le";
$lang['streams:value'] = "Valeur";
$lang['streams:manage'] = "Gérer";
$lang['streams:search'] = "Chercher";
$lang['streams:stream_prefix'] = "Préfixe du flux";

/* Field Instructions */

$lang['streams:instr.field_instructions'] = "Affiché sur le formulaire lors de l'édition ou la mise jour des données.";
$lang['streams:instr.stream_full_name'] = "Nom complet de votre lux.";
$lang['streams:instr.slug'] = "minuscule, uniquement des lettres et des underscores.";

/* Titles */

$lang['streams:assign_field'] = "Assigner un champ à un flux";
$lang['streams:edit_assign'] = "Editer l'Affectation des flux";
$lang['streams:add_field'] = "Créer un champ";
$lang['streams:edit_field'] = "Editer le champ";
$lang['streams:fields'] = "champs";
$lang['streams:streams'] = "Flux";
$lang['streams:list_fields'] = "Champs";
$lang['streams:new_entry'] = "Nouvelle entrée";
$lang['streams:stream_entries'] = "Entrées du flux";
$lang['streams:entries'] = "Entrées";
$lang['streams:stream_admin'] = "Administration des flux";
$lang['streams:list_streams'] = "Flux";
$lang['streams:sure'] = "Êtes-vous sûr(e)&nbsp;?";
$lang['streams:field_assignments'] = "Affectation des champs de flux";
$lang['streams:new_field_assign'] = "Nouvelle affectation de champ";
$lang['streams:stream_name'] = "Nom du flux";
$lang['streams:stream_slug'] = "Slug du flux";
$lang['streams:about'] = "A propos";
$lang['streams:total_entries'] = "Entrées totales";
$lang['streams:add_stream'] = "Nouveau flux";
$lang['streams:edit_stream'] = "Editer le flux";
$lang['streams:about_stream'] = "A propos de ce flux";
$lang['streams:title_column'] = "Titre de colonne";
$lang['streams:sort_method'] = "Méthode de Tri";
$lang['streams:add_entry'] = "Ajouter une entrée";
$lang['streams:edit_entry'] = "Editer une entrée";
$lang['streams:view_options'] = "Options d'affichage";
$lang['streams:stream_view_options'] = "Options d'affichage des flux";
$lang['streams:backup_table'] = "Sauvegarder la table de flux";
$lang['streams:delete_stream'] = "Supprimer le flux";
$lang['streams:entry'] = "Entrée";
$lang['streams:field_types'] = "Types de champ";
$lang['streams:field_type'] = "Type de champ";
$lang['streams:database_table'] = "Table de base de données";
$lang['streams:size'] = "Taille";
$lang['streams:num_of_entries'] = "Nombre d'entrées";
$lang['streams:num_of_fields'] = "Nombre de champs";
$lang['streams:last_updated'] = "Dernière mise à jour";
$lang['streams:export_schema'] = 'Exporter le schéma';

/* Startup */

$lang['streams:start.add_one'] = "ajouter un ici";
$lang['streams:start.no_fields'] = "Vous n'avez pas encore créé de champs. Pour commencer, vous pouvez";
$lang['streams:start.no_assign'] = "On dirait qu\'il n\'y a aucun champ pour ce flux. Pour commencer, vous pouvez";
$lang['streams:start.add_field_here'] = "ajouter un champ ici";
$lang['streams:start.create_field_here'] = "créer un champ ici";
$lang['streams:start.no_streams'] = "Il n'y a aucun flux pour le moment, vous pouvez commencer par";
$lang['streams:start.no_streams_yet'] = "Il n'y a encore aucun flux.";
$lang['streams:start.adding_one'] = "ajouter un";
$lang['streams:start.no_fields_to_add'] = "Aucun champ à ajouter";
$lang['streams:start.no_fields_msg'] = "Il n'y a aucun champ à ajouter à ce flux. Dans PyroStreams, les types de champs peuvent être partagés entre les flux mais doivent être créés avant d'être ajoutés à un flux. Vous pouvez commencer par";
$lang['streams:start.adding_a_field_here'] = "ajouter un champ ici";
$lang['streams:start.no_entries'] = "Il n'y a aucune entrée pour <strong>%s</strong>. Pour commencer, vous pouvez";
$lang['streams:add_fields'] = "Assigner les champs";
$lang['streams:no_entries'] = 'Aucune entrée';
$lang['streams:add_an_entry'] = "Ajouter une entrée";
$lang['streams:to_this_stream_or'] = "à ce flux où";
$lang['streams:no_field_assign'] = "Aucun champ assigné";
$lang['streams:no_fields_msg_first'] = "Il n'y a actuellement aucun champ pour ce flux.";
$lang['streams:no_field_assign_msg'] = "Avant d'enregistrer des données vous devez";
$lang['streams:add_some_fields'] = "assigner quelques champs";
$lang['streams:start.before_assign'] = "Avant d'assigner des champs à un flux, vous devez créer des champs. Vous pouvez";
$lang['streams:start.no_fields_to_assign'] = "Il n'y a aucun champ disponible à assigner. Avant d'assigner un champ vous devez ";

/* Buttons */

$lang['streams:yes_delete'] = "Oui, supprimer";
$lang['streams:no_thanks'] = "Non, merci";
$lang['streams:new_field'] = "Nouveau champ";
$lang['streams:edit'] = "Editer";
$lang['streams:delete'] = "Supprimer";
$lang['streams:remove'] = "Retirer";
$lang['streams:reset'] = "Réinitialiser";

/* Misc */

$lang['streams:field_singular'] = "champ";
$lang['streams:field_plural'] = "champs";
$lang['streams:by_title_column'] = "Par titre de colonne";
$lang['streams:manual_order'] = "Ordonnancement manuel";
$lang['streams:stream_data_line'] = "Editer les informations du flux.";
$lang['streams:view_options_line'] = "Choisir les colonnes qui seront visibles sur la page d'affichage des données.";
$lang['streams:backup_line'] = "Sauvegarder et télécharger les flux dans un fichier zip.";
$lang['streams:permanent_delete_line'] = "Supprimer de façon permanente les flux et toutes les données correspondantes.";
$lang['streams:choose_a_field_type'] = "Choisir un type de champ";
$lang['streams:choose_a_field'] = "Choisir un champ";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] = "Librairie reCaptcha initialisée";
$lang['recaptcha_no_private_key'] = "Vous n'avez pas renseigné de clé API pour reCAPTCHA";
$lang['recaptcha_no_remoteip'] = "Pour des raisons de sécurité, merci de renseigner votre adresse IP à reCAPTCHA";
$lang['recaptcha_socket_fail'] = "Impossible d'ouvrir le port";
$lang['recaptcha_incorrect_response'] = "Image de sécurité incorrecte";
$lang['recaptcha_field_name'] = "Image de sécurité";
$lang['recaptcha_html_error'] = "Un problème à eu lieu lors du chargement de l'image de sécurité. Merci de recommencer plus tard";

/* Default Parameter Fields */

$lang['streams:max_length'] = "Longueur max";
$lang['streams:upload_location'] = "Dossier de chargement";
$lang['streams:default_value'] = "Valeur par défaut";

$lang['streams:menu_path'] = 'Chemin du Menu';
$lang['streams:about_instructions'] = 'Une courte description de votre flux.';
$lang['streams:slug_instructions'] = 'Sera utilisé comme nom de table en base de données pour votre flux.';
$lang['streams:prefix_instructions'] = 'Si utilisé, servira de préfixe au nom de vos tables en base de données. Utile pour éviter les conflits de noms.';
$lang['streams:menu_path_instructions'] = 'Permet d\'indiquer le chemin d\'affichage de votre flux dans le menu. Séparé par un slash (/). Ex: <strong>Section Principale / Sous-Section</strong>.';

/* End of file pyrostreams_lang.php */
