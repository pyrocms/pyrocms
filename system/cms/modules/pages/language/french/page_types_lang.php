<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types:html_label']                 = 'HTML';
$lang['page_types:css_label']                  = 'CSS';
$lang['page_types:basic_info']                 = 'Informations basiques';

// labels
$lang['page_types:updated_label']              = 'Mis à jour';
$lang['page_types:layout']                     = 'Gabarit (Layout)';
$lang['page_types:auto_create_stream']         = 'Créer un nouveau Stream pour ce Type de page';
$lang['page_types:select_stream']              = 'flux Stream';
$lang['page_types:theme_layout_label']         = 'Gabarit du thème';
$lang['page_types:save_as_files']              = 'Sauvegarder comme fichiers';
$lang['page_types:content_label']              = 'Label Onglet de contenu';
$lang['page_types:title_label']                = 'Titre du label';
$lang['page_types:sync_files']                 = 'Synchroniser les fichiers';

// titles
$lang['page_types:list_title']                 = 'Lister les gabarits';
$lang['page_types:list_title_sing']            = 'Type de page';
$lang['page_types:create_title']               = 'Ajouter un gabarit';
$lang['page_types:edit_title']                 = 'Editer le gabarit "%s"';

// messages
$lang['page_types:no_pages']                   = 'Il n\'y a pas de modèle.';
$lang['page_types:create_success_add_fields']  = 'Vous avez créé un nouveau type de page; vous pouvez ajouter les champs que vous souhaitez retrouver sur votre page.';
$lang['page_types:create_success']             = 'Le modèle a été créé';
$lang['page_types:success_add_tag']            = 'Le champ de page a été ajouté. Afin que ce champ soit affiché vous devez insérer le tag du champ dans votre gabarit.';
$lang['page_types:create_error']               = 'Le modèle n\'a pas été créé.';
$lang['page_types:page_type.not_found_error']  = 'Ce modèle n\'existe pas.';
$lang['page_types:edit_success']               = 'Le modèle "%s" a été enregistré.';
$lang['page_types:delete_home_error']          = 'Vous ne pouvez pas supprimer le modèle par défaut.';
$lang['page_types:delete_success']             = 'Le modèle #%s a été supprimé.';
$lang['page_types:mass_delete_success']        = '%s modèles ont été supprimés.';
$lang['page_types:delete_none_notice']         = 'Aucun modèle n\'a été supprimé.';
$lang['page_types:already_exist_error']        = 'Une table avec ce nom existe déjà. Merci de choisir un nom différent pour ce type de page.';
$lang['page_types:_check_pt_slug_msg']         = 'Le slug de votre type de page doit être unique.';

$lang['page_types:variable_introduction']      = 'Deux variables sont disponibles pour ce champ';
$lang['page_types:variable_title']             = 'Contient le titre de la page.';
$lang['page_types:variable_body']              = 'Contient le code HTML de la balise body.';
$lang['page_types:sync_notice']                = 'Possibilité uniquement de synchroniser %s du système de fichiers.';
$lang['page_types:sync_success']               = 'Fichiers synchronisés avec succès.';
$lang['page_types:sync_fail']                  = 'Synchronisation de vos fichiers impossible.';

// Instructions
$lang['page_types:stream_instructions']        = 'Ce flux Stream conservera les champs personnalisés pour votre Type de page. Vous pouvez sélectionner un nouveau flux Stream ou un nouveau flux sera créé pour vous.';
$lang['page_types:saf_instructions']           = 'Lorsque vous activez cette option, votre gabarit de page et vos JS et CSS personnalisés seront ajoutés dans un fichier disponible dans le dossier assets/page_types.';
$lang['page_types:content_label_instructions'] = 'Utilisé comme label pour l\'onglet qui contient les champs personnalisés de votre type de page.';
$lang['page_types:title_label_instructions']   = 'Permet de renommer le label de titre de page (par défaut "Titre"). Ceci est utilise si vous souhaitez afficher par exemple "Nom de produit" ou "Nom d\'équipe".';

// Misc
$lang['page_types:delete_message']             = 'Êtes-vous sur de vouloir supprimer ce type de page&nbsp;? Cette action supprimera <strong>%s</strong> utilisant ce gabarit, ainsi que les pages enfants de ces pages et les entrées de flux associées à ces pages. <strong>Vous ne pouvez pas annuler cette action une fois effectuée.</strong> ';

$lang['page_types:delete_streams_message']     = 'Cette action supprimera également le <strong>flux Stream %s</strong> associé avec ce type de page.';