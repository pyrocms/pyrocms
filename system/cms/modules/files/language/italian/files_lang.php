<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

// General
$lang['files:files_title']					= 'File';
$lang['files:fetching']						= 'Racuperando i dati...';
$lang['files:fetch_completed']				= 'Completato';
$lang['files:save_failed']					= 'Spiacenti. I cambiamenti non possono essere salvati';
$lang['files:item_created']					= '"%s" è stato creato';
$lang['files:item_updated']					= '"%s" è stato aggiornato';
$lang['files:item_deleted']					= '"%s" è stato cancellato';
$lang['files:item_not_deleted']				= '"%s" non può essere cancellato';
$lang['files:item_not_found']				= 'Spiacenti. "%s" non è stato trovato';
$lang['files:sort_saved']					= 'Tipo di ordinamento salvato';
$lang['files:no_permissions']				= 'Non possiedi permessi sufficienti';

// Labels
$lang['files:activity']						= 'Attività';
$lang['files:places']						= 'Luoghi';
$lang['files:back']							= 'Indietro';
$lang['files:forward']						= 'Avanti';
$lang['files:start']						= 'Inizia Upload';
$lang['files:details']						= 'Dettagli';
$lang['files:name']							= 'Nome';
$lang['files:slug']							= 'link';
$lang['files:path']							= 'Path';
$lang['files:added']						= 'Data aggiunta';
$lang['files:width']						= 'Larghezza';
$lang['files:height']						= 'Altezza';
$lang['files:ratio']						= 'Ratio';
$lang['files:full_size']					= 'Dimensione normale';
$lang['files:filename']						= 'Nome file';
$lang['files:filesize']						= 'Dimensione file';
$lang['files:download_count']				= 'Contatore download';
$lang['files:download']						= 'Download';
$lang['files:location']						= 'Locazione';
$lang['files:description']					= 'Descrizione';
$lang['files:container']					= 'Contenitore';
$lang['files:bucket']						= 'Cestino';
$lang['files:check_container']				= 'Controlla validità';
$lang['files:search_message']				= 'Scrivi e premi enter';
$lang['files:search']						= 'Cerca';
$lang['files:synchronize']					= 'Sincronizza';
$lang['files:uploader']						= 'Trascina qui i file <br />oppure<br />Clicca per sceglierli';

// Context Menu
$lang['files:open']							= 'Apri';
$lang['files:new_folder']					= 'Nuova cartella';
$lang['files:upload']						= 'Upload';
$lang['files:rename']						= 'Rinomina';
$lang['files:delete']						= 'Cancella';
$lang['files:edit']							= 'Modifica';
$lang['files:details']						= 'Dettagli';

// Folders

$lang['files:no_folders']					= 'File e Cartelle sono gestite come faresti sul duo desktop. Premo il tasto destro del mouse nell\'area sottostante per creare la tua prima cartella. Per rinominarla, cancellarla o caricare file, premi ancora il tasto destro su di essa. Puoi anche modificarne i dettagli come ad esempio collegarla a una cartella che si trova nel cloud.';
$lang['files:no_folders_places']			= 'Le cartelle che creerai verranno mostrate qui sotto forma di albero che potrai espandere e ridurre. Clicca su "Luoghi" per vedere la cartella root.';
$lang['files:no_folders_wysiwyg']			= 'Non sono ancora state create cartelle';
$lang['files:new_folder_name']				= 'Cartella senza nome';
$lang['files:folder']						= 'Cartella';
$lang['files:folders']						= 'Cartelle';
$lang['files:select_folder']				= 'Seleziona una cartella';
$lang['files:subfolders']					= 'Sottocartella';
$lang['files:root']							= 'Root';
$lang['files:no_subfolders']				= 'Non ci sono sottocartelle';
$lang['files:folder_not_empty']				= 'Devi prima cancellare il contenuto di "%s"';
$lang['files:mkdir_error']					= 'Non siamo riusciti a creare la cartella che hai caricato. Dovrai crearla tu manualmente.';
$lang['files:chmod_error']					= 'La cartella upload non è scrivibile. Devi modificarne i permessi in 0777';
$lang['files:location_saved']				= 'La locazione della cartella è stata salvata';
$lang['files:container_exists']				= '"%s" esiste di già. Salva per unire il suo contenuto con questa cartella';
$lang['files:container_not_exists']			= '"%s" non esiste nel tuo account. Salva e proveremo a crearla';
$lang['files:error_container']				= '"%s" non è stato possibile crearla e non siamo in grado di determinarne il motivo.';
$lang['files:container_created']			= '"%s" è stata creata e ora è collegata a questa cartella';
$lang['files:unwritable']					= '"%s" non è scrivibile, per favore imposta i permessi a 0777';
$lang['files:specify_valid_folder']			= 'Devi specificare una cartella valida per caricare il file';
$lang['files:enable_cdn']					= 'Devi abilitare il CDN per "%s" dal tuo pannello di controllo Rackspace prima di sincronizzare';
$lang['files:synchronization_started']		= 'Sincronizzazione avviata';
$lang['files:synchronization_complete']		= 'La sincronizzazione per "%s" è stata completata';
$lang['files:untitled_folder']				= 'Cartella senza nome';

// Files
$lang['files:no_files']						= 'Non ci sono file';
$lang['files:file_uploaded']				= '"%s" è stato caricato';
$lang['files:unsuccessful_fetch']			= 'Non siamo in grado di scorrere "%s". Sei sicuro che sia un file pubblico?';
$lang['files:invalid_container']			= '"%s" sembra non essere un contenitore valido.';
$lang['files:no_records_found']				= 'Non sono stati trovati record';
$lang['files:invalid_extension']			= '"%s" ha una estensione che non è consentita';
$lang['files:upload_error']					= 'L\'upload del file è fallito';
$lang['files:description_saved']			= 'La descrizione del file è stata salvata';
$lang['files:file_moved']					= '"%s" è stata spostata con successo';
$lang['files:exceeds_server_setting']		= 'Il server non p in grado di gestire file così grandi';
$lang['files:exceeds_allowed']				= 'Il file supera le dimensioni massime consentite';
$lang['files:file_type_not_allowed']		= 'Questo tipo di file non è consentito';
$lang['files:type_a']						= 'Audio';
$lang['files:type_v']						= 'Video';
$lang['files:type_d']						= 'Documento';
$lang['files:type_i']						= 'Immagine';
$lang['files:type_o']						= 'Altro';

/* End of file files_lang.php */