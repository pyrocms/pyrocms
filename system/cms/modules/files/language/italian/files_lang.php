<?php defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['files:files_title']					= 'Files'; 
$lang['files:fetching']						= 'Recupero dati...';
$lang['files:fetch_completed']				= 'Completato';
$lang['files:save_failed']					= 'Spiacenti. I cambiamenti non possono essere salvati';
$lang['files:item_created']					= '"%s" è stato/a creata';
$lang['files:item_updated']					= '"%s" è stato/a aggiornata';
$lang['files:item_deleted']					= '"%s" è stato/a eliminato';
$lang['files:item_not_deleted']				= '"%s" non può essere eliminato/a';
$lang['files:item_not_found']				= 'Spiacenti. "%s" Non è stato/a trovato/a';
$lang['files:sort_saved']					= 'Ordinamento salvato';
$lang['files:no_permissions']				= 'Non hai abbastanza permessi';

// Labels
$lang['files:activity']						= 'Attività';
$lang['files:places']						= 'Cartelle';
$lang['files:back']							= 'Indietro';
$lang['files:forward']						= 'Avanti';
$lang['files:start']						= 'Inizia Upload';
$lang['files:details']						= 'Dettagli';
$lang['files:id']							= 'ID';
$lang['files:name']							= 'Nome';
$lang['files:slug']							= 'Slug';
$lang['files:path']							= 'Path';
$lang['files:added']						= 'Data di aggiunta';
$lang['files:width']						= 'Larghezza';
$lang['files:height']						= 'Altezza';
$lang['files:ratio']						= 'Ratio';
$lang['files:alt_attribute']				= 'Attributo Alt';
$lang['files:full_size']					= 'Dimensione intera';
$lang['files:filename']						= 'Filename';
$lang['files:filesize']						= 'Filesize';
$lang['files:download_count']				= 'Contatore Download';
$lang['files:download']						= 'Download';
$lang['files:location']						= 'Locazione';
$lang['files:keywords']						= 'Keywords'; 
$lang['files:toggle_data_display']			= 'Toggle Data Display'; #translate
$lang['files:description']					= 'Descrizione';
$lang['files:container']					= 'Contenitore';
$lang['files:bucket']						= 'Cestino';
$lang['files:check_container']				= 'Controlla validità';
$lang['files:search_message']				= 'Scrivi e premi Invio';
$lang['files:search']						= 'Cerca';
$lang['files:synchronize']					= 'Sincronizzazione';
$lang['files:uploader']						= 'Trascina qui i file <br />oppure<br />Clicca per selezionare i file';
$lang['files:replace_file']					= 'Sostituisci file'; 

// Context Menu
$lang['files:refresh']						= 'Aggiorna'; 
$lang['files:open']							= 'Apri';
$lang['files:new_folder']					= 'Nuova cartella';
$lang['files:upload']						= 'Carica';
$lang['files:rename']						= 'Rinomina';
$lang['files:replace']	  					= 'Sostituisci'; 
$lang['files:delete']						= 'Cancella';
$lang['files:edit']							= 'Modifica';
$lang['files:details']						= 'Dettagli';

// Folders

$lang['files:no_folders']					= 'File e cartelle sono gestite come faresti sul tuo computer. Clicca con il tasto destro del mouse nell\'area sottostante per creare la prima cartella. Poi sempre con il tasto destro sulla cartella creata potrai rinominarla, cancellarla e caricare file al suo interno o su un servizio cloud.';
$lang['files:no_folders_places']			= 'Le cartelle che creerai saranno mostrate qui sottoforma di albero che puoi espandere e contrarre. Clicca su "Cartelle" per vedere la root principale.';
$lang['files:no_folders_wysiwyg']			= 'Non sono ancora state create cartelle';
$lang['files:new_folder_name']				= 'Cartella senza nome';
$lang['files:folder']						= 'Cartella';
$lang['files:folders']						= 'Cartelle';
$lang['files:select_folder']				= 'Seleziona una cartella';
$lang['files:subfolders']					= 'Sottocartelle';
$lang['files:root']							= 'Root';
$lang['files:no_subfolders']				= 'Non ci sono sottocartelle';
$lang['files:folder_not_empty']				= 'Devi prima cancellare il contenuto di "%s"';
$lang['files:mkdir_error']					= 'Non è stato possibile creare %s. Devi crearla manualmente';
$lang['files:chmod_error']					= 'La cartella di upload non è scrivibile. Deve avere i permessi a 0777';
$lang['files:location_saved']				= 'La locazione della cartella è stata salvata';
$lang['files:container_exists']				= '"%s" esiste di già. Salva per linkare i contenuti a questa cartella';
$lang['files:container_not_exists']			= '"%s" non esiste nel tuo account. Salva per provare a crearla';
$lang['files:error_container']				= '"%s" non puà essere creata e non si riesce a determinarne il motivo';
$lang['files:container_created']			= '"%s" è stata creata e ora è linkata a questa cartella';
$lang['files:unwritable']					= '"%s" non è scrivibile, per favore imposta i suoi permessi a 0777';
$lang['files:specify_valid_folder']			= 'Devi indicare una cartella per caricare i file';
$lang['files:enable_cdn']					= 'Devi abilitare il CDN per "%s" attraverso il tuo pannello di controllo Rackspace prima di poter sincronizzare';
$lang['files:synchronization_started']		= 'Avvio sincronizzazione';
$lang['files:synchronization_complete']		= 'Sincronizzazione per "%s" terminata';
$lang['files:untitled_folder']				= 'Cartella senza nome';

// Files
$lang['files:no_files']						= 'File non trovato';
$lang['files:file_uploaded']				= '"%s" è stato caricato';
$lang['files:unsuccessful_fetch']			= 'Non è stato possibile leggere "%s". Sicuro che sia un file pubblico?';
$lang['files:invalid_container']			= '"%s" sembra non essere un contenitore valido.';
$lang['files:no_records_found']				= 'Non sono stati trovati risultati';
$lang['files:invalid_extension']			= '"%s" ha una estensione che non è ammessa';
$lang['files:upload_error']					= 'L\'upload del file è fallito';
$lang['files:description_saved']			= 'La descrizione del file è stata salvata';
$lang['files:alt_saved']					= 'L\'attributo Alt dell\'immagine è stato salvato.';
$lang['files:file_moved']					= '"%s" è stato spostato con successo';
$lang['files:exceeds_server_setting']		= 'Il server non può gestire file così grossi';
$lang['files:exceeds_allowed']				= 'Il file eccede la dimensione massima';
$lang['files:file_type_not_allowed']		= 'Questo tipo di file non è ammesso';
$lang['files:replace_warning']				= 'Attenzione: Non sostituire un file con uno di tipo diverso (es. .jpg con .png)';
$lang['files:type_a']						= 'Audio';
$lang['files:type_v']						= 'Video';
$lang['files:type_d']						= 'Documento';
$lang['files:type_i']						= 'Immagine';
$lang['files:type_o']						= 'Altro';

/* End of file files_lang.php */
