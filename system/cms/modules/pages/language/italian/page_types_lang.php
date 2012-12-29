<?php defined('BASEPATH') or exit('No direct script access allowed');

// tabs
$lang['page_types:html_label']                 = 'HTML';
$lang['page_types:css_label']                  = 'CSS';
$lang['page_types:basic_info']                 = 'Informazioni base';

// labels
$lang['page_types:updated_label']              = 'Aggiornato';
$lang['page_types:layout']                     = 'Layout';
$lang['page_types:auto_create_stream']         = 'Crea un nuovo Stream per questo Tipo di pagina.';
$lang['page_types:select_stream']              = 'Stream';
$lang['page_types:theme_layout_label']         = 'Tema del layout';
$lang['page_types:save_as_files']              = 'Salva come File';
$lang['page_types:content_label']              = 'Contenuto tab etichetta';
$lang['page_types:title_label']                = 'Titolo etichetta';
$lang['page_types:sync_files']                 = 'Sincronizza file';

// titles
$lang['page_types:list_title']                 = 'Elenco layout delle pagine';
$lang['page_types:list_title_sing']            = 'Tipo pagina';
$lang['page_types:create_title']               = 'Aggiungi un layout di pagina';
$lang['page_types:edit_title']                 = 'Modifica il layout di pagina "%s"';

// messages
$lang['page_types:no_pages']                   = 'Non ci sono layout di pagina.';
$lang['page_types:create_success_add_fields']  = 'Hai creato un nuovo tipo di pagina; ora aggiungi i campi che vuoi che la tua pagina abbia.';
$lang['page_types:create_success']             = 'Il layout di pagina è stato creato.';
$lang['page_types:success_add_tag']            = 'Il campo della pagina è stato aggiunto. Ad ogni modo prima che il suo contenuto venga mostrato dovrai inserire il suo tag nella textarea della pagina';
$lang['page_types:create_error']               = 'Questo layout di pagina non è stato creato.';
$lang['page_types:page_type.not_found_error']  = 'Questo layout di pagina non esiste.';
$lang['page_types:edit_success']               = 'Il layout di pagina "%s" è stato salvato.';
$lang['page_types:delete_home_error']          = 'Non puoi eliminare il layout di pagina di default.';
$lang['page_types:delete_success']             = 'Il layout di pagina #%s è stato eliminato.';
$lang['page_types:mass_delete_success']        = '%s layout di pagina sono stati eliminati.';
$lang['page_types:delete_none_notice']         = 'Nessun layout di pagina è stato eliminato.';
$lang['page_types:already_exist_error']        = 'Una tabella con quel nome esiste di già. Per favore scegli un nome diverso per il tipo di questa pagina.';
$lang['page_types:_check_pt_slug_msg']         = 'Lo slug del tipo di pagina deve essere unico.'; 

$lang['page_types:variable_introduction']      = 'In questo campo sono disponibili due variabili';
$lang['page_types:variable_title']             = 'Contiene il titolo della pagina.';
$lang['page_types:variable_body']              = 'Contiene il corpo HTML della pagina.';
$lang['page_types:sync_notice']                = 'E\' stato possibile sincronizzare solo %s dal file system.';
$lang['page_types:sync_success']               = 'File sincronizzati con successo.';
$lang['page_types:sync_fail']                  = 'Non è stato possibile sincronizzare i file.';

// Instructions
$lang['page_types:stream_instructions']        = 'Questo stream manterrà i campi personalizzati per il tuo tipo di pagina. Puoi scegliere un nuovo stream o uno nuovo verrà creato per te.';
$lang['page_types:saf_instructions']           = 'Selezionando questa opzione verrà salvato su un semplice file il layout della pagina, così come tutti i CSS e JS personalizzati, all\'interno della cartella assets/page_types.'; 
$lang['page_types:content_label_instructions'] = 'Questo rinomina il tab che contiene lo stream dei campi per il tipo di pagina.';
$lang['page_types:title_label_instructions']   = 'Questo rinomina il campi titolo della pagina da "Titolo" permettendoti di utilizzare qualsiasi altra cosa tu voglia, per esempio "Nome prodotto" o "Nome del dipendente".';

// Misc
$lang['page_types:delete_message']             = 'Sei sicuro di voler cancellare questo tipo di pagina? Questa azione cancellera <strong>%s</strong> pagine che usano questo layout, tutte le pagine figlie e qualsiasi altro dato che è associato a queste pagina. <strong>L\'operazione non può essere annullata</strong>.';

$lang['page_types:delete_streams_message']     = 'Questo cancellarà anche <strong>%s stream</strong> associati a questo tipo pagina.';