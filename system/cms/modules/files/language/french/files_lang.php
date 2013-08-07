<?php defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['files:files_title'] = 'Fichiers';
$lang['files:fetching'] = 'Récupèration des données ...';
$lang['files:fetch_completed'] = 'Terminé';
$lang['files:save_failed'] = 'Désolé. Les modifications n\'ont pas pu être effectuées';
$lang['files:item_created'] = '"%s" a été créé';
$lang['files:item_updated'] = '"%s" a été mis à jour';
$lang['files:item_deleted'] = '"%s" a été supprimé';
$lang['files:item_not_deleted'] = '"%s" n\'a pas pu être supprimé';
$lang['files:item_not_found'] = 'Désolé. "%s" n\'a pas été trouvé';
$lang['files:sort_saved'] = 'Ordonnancement enregistré';
$lang['files:no_permissions'] = 'Vous n\'avez pas les permissions suffisantes';

// Labels
$lang['files:activity'] = 'Activités';
$lang['files:places'] = 'Dossiers';
$lang['files:back'] = 'Arrière';
$lang['files:forward'] = 'Avant';
$lang['files:start'] = 'Commencer le téléchargement';
$lang['files:details'] = 'Détails';
$lang['files:id'] = 'ID';
$lang['files:name'] = 'Nom';
$lang['files:slug'] = 'Slug';
$lang['files:path'] = 'Chemin';
$lang['files:added'] = 'Date d\'ajout';
$lang['files:width'] = 'Largeur';
$lang['files:height'] = 'Hauteur';
$lang['files:ratio'] = 'Ratio';
$lang['files:alt_attribute'] = 'Attribut Alt';
$lang['files:full_size'] = 'Taille originale';
$lang['files:filename'] = 'Nom du fichier';
$lang['files:filesize'] = 'Taille du fichier';
$lang['files:download_count'] = 'Compteur de téléchargement';
$lang['files:download'] = 'Téléchargement';
$lang['files:location'] = 'Emplacement';
$lang['files:keywords'] = 'Mots-clés';
$lang['files:toggle_data_display'] = 'Afficher les données aléatoirement';
$lang['files:description'] = 'Description';
$lang['files:container'] = 'Conteneur';
$lang['files:bucket'] = 'Bucket';
$lang['files:check_container'] = 'Vérifier la validité';
$lang['files:search_message'] = 'Appuyez sur la touche Entrée';
$lang['files:search'] = 'Chercher';
$lang['files:synchronize'] = 'Synchroniser';
$lang['files:uploader'] = 'Déposez les fichiers ici <br />ou<br /> Cliquez ici pour sélectionner les fichiers';
$lang['files:replace_file'] = 'Remplacer le fichier';

// Context Menu
$lang['files:refresh'] = 'Rafraîchir';
$lang['files:open'] = 'Ouvrir';
$lang['files:new_folder'] = 'Créer Dossier';
$lang['files:upload'] = 'Charger';
$lang['files:rename'] = 'Renommer';
$lang['files:delete'] = 'Supprimer';
$lang['files:replace'] = 'Remplacer';
$lang['files:edit'] = 'Editer';
$lang['files:details'] = 'Détails';

// Folders

$lang['files:no_folders'] = 'Les fichiers et dossiers sont gérés ici comme ils le sont sur votre ordinateur. Faites un clic droit dans la zone sous ce message pour créer votre premier dossier. Puis faites un clic droit sur le dossier pour le renommer, le supprimer, charger des fichiers ou modifier les détails le concernant comme par exemple le lier à un dossier sur un espace de stockage à distance.';
$lang['files:no_folders_places'] = 'Les dossiers que vous créez s\'affichent dans une arborescence qui peut être affichée ou masquée. Cliquez sur "Dossiers" pour voir le dossier racine.';
$lang['files:no_folders_wysiwyg'] = 'Aucun dossier n\'a été créé pour le moment';
$lang['files:new_folder_name'] = 'Dossier sans nom';
$lang['files:folder'] = 'Dossier';
$lang['files:folders'] = 'Dossiers';
$lang['files:select_folder'] = 'Choisir un Dossier';
$lang['files:subfolders'] = 'Sous-Dossiers';
$lang['files:root'] = 'Racine';
$lang['files:no_subfolders'] = 'Aucun Sous-Dossier';
$lang['files:folder_not_empty'] = 'Vous devez dans un premier temps supprimer les contenus de "%s"';
$lang['files:mkdir_error'] = 'Impossible de créer le dossier Uploads. Vous devez le créer manuellement';
$lang['files:chmod_error'] = 'Le dossier Uploads est verrouillé en écriture. Il faut lui attribuer les droits 0777';
$lang['files:location_saved'] = 'L\'emplacement du dossier a été enregistré';
$lang['files:container_exists'] = '"%s" existe. Enregistrer pour lier son contenu à ce dossier';
$lang['files:container_not_exists'] = '"%s" n\'existe pas dans votre compte. Sauvegarder et nous essayerons de le créer';
$lang['files:error_container'] = '"%s" n\'a pas pu être créé et nous ne pouvons en déterminer la cause';
$lang['files:container_created'] = '"%s" a été créé et est désormais lié à ce dossier';
$lang['files:unwritable'] = '"%s" n\'est pas accessible en écriture, merci de lui attribuer les permissions 0777';
$lang['files:specify_valid_folder'] = 'Vous devez spécifier un dossier valide pour y télécharger des fichiers';
$lang['files:enable_cdn'] = 'Vous devez activer les CDN pour "%s" par l\'intermédiaire de votre Rackspace avant que nous puissions effectuer la synchronisation';
$lang['files:synchronization_started'] = 'Début de la synchronisation';
$lang['files:synchronization_complete'] = 'La synchronisation "%s" est complète';
$lang['files:untitled_folder'] = 'Dossier sans nom';

// Files
$lang['files:no_files'] = 'Aucun fichier trouvé';
$lang['files:file_uploaded'] = '"%s" a été téléchargé';
$lang['files:unsuccessful_fetch'] = 'Nous n\'avons pas pu récupérer "%s". Etes-vous sûr(e) que ce fichier est public&nbsp;?';
$lang['files:invalid_container'] = '"%s" ne semble pas être un conteneur valide.';
$lang['files:no_records_found'] = 'Aucun enregistrement n\'a été trouvé';
$lang['files:invalid_extension'] = '"%s" a une extension de fichier qui n\'est pas autorisée';
$lang['files:upload_error'] = 'Le téléchargement du fichier à échoué';
$lang['files:description_saved'] = 'La description du fichier a été sauvegardée';
$lang['files:alt_saved'] = 'L\'attribut Alt de l\'image a bien été sauvegardé';
$lang['files:file_moved'] = '"%s" a été déplacé avec succès';
$lang['files:exceeds_server_setting'] = 'Le serveur ne prend pas en compte les fichiers de cette taille';
$lang['files:exceeds_allowed'] = 'Le fichier dépasse la taille maximum autorisée';
$lang['files:file_type_not_allowed'] = 'Ce type de fichier n\'est pas autorisé';
$lang['files:replace_warning'] = 'Avertissement : ne remplacez pas un fichier par un fichier d\'un type différent (par ex. .jpg par .png)';
$lang['files:type_a'] = 'Audio';
$lang['files:type_v'] = 'Vidéo';
$lang['files:type_d'] = 'Document';
$lang['files:type_i'] = 'Image';
$lang['files:type_o'] = 'Autre';

/* End of file files_lang.php */
