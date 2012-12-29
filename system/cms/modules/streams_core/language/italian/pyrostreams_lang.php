<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "Si è verificato un problema nel salvare il campo.";
$lang['streams:field_add_success']						= "Campo aggiunto con successo.";
$lang['streams:field_update_error']						= "Si è verificato un problema nell'aggiornare il campo.";
$lang['streams:field_update_success']					= "Campo aggiornato con successo.";
$lang['streams:field_delete_error']						= "Si è verificato un problema nel cancellare questo campo.";
$lang['streams:field_delete_success']					= "Il campo è stato cancellato con successo.";
$lang['streams:view_options_update_error']				= "Si è verificato un problema nell'aggiornare la vista delle opzioni.";
$lang['streams:view_options_update_success']			= "La vista delle opzioni è stata aggiornata con successo.";
$lang['streams:remove_field_error']						= "Si è verificato un problema nel rimuovere questo campo.";
$lang['streams:remove_field_success']					= "Il campo è stato cancellato con successo.";
$lang['streams:create_stream_error']					= "Si è verificato un errore nel creare lo stream.";
$lang['streams:create_stream_success']					= "Stream creato con successo.";
$lang['streams:stream_update_error']					= "Si è verificato un problema nell'aggiornare lo stream.";
$lang['streams:stream_update_success']					= "Stream aggiornato con successo.";
$lang['streams:stream_delete_error']					= "Si è verificato un errore nel cancellare lo stream.";
$lang['streams:stream_delete_success']					= "Stream cancellato con successo.";
$lang['streams:stream_field_ass_add_error']				= "Si è verificato un errore nell'aggiungere il campo allo stream.";
$lang['streams:stream_field_ass_add_success']			= "Campo aggiunto con successo allo stream.";
$lang['streams:stream_field_ass_upd_error']				= "Si è verificato un errore aggiornando l'assegnamento al campo.";
$lang['streams:stream_field_ass_upd_success']			= "L'assegnamento al campo è stato aggiornato con successo.";
$lang['streams:delete_entry_error']						= "Si è verificato un problema nel cancellare questa voce.";
$lang['streams:delete_entry_success']					= "Voce cancellata con successo.";
$lang['streams:new_entry_error']						= "Si è verificato un errore nell'aggiungere questa voce.";
$lang['streams:new_entry_success']						= "Voce aggiunta correttamente.";
$lang['streams:edit_entry_error']						= "Si è verificato un problema nell'aggiornare questa voce.";
$lang['streams:edit_entry_success']						= "Voce aggiornata correttamente.";
$lang['streams:delete_summary']							= "Sicuro di voler cancellare lo stream <strong>%s</strong>? Questa azione rimuoverà <strong>%s %s</strong> definitivamente.";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "Non è stato fornito nessuno stream.";
$lang['streams:invalid_stream']							= "Stream non valido.";
$lang['streams:not_valid_stream']						= "Non è uno stream valido.";
$lang['streams:invalid_stream_id']						= "Stream ID non valido.";
$lang['streams:invalid_row']							= "Riga non valida.";
$lang['streams:invalid_id']								= "ID non valido.";
$lang['streams:cannot_find_assign']						= "Impossibile trovare l'assegnazione del campo.";
$lang['streams:cannot_find_pyrostreams']				= "Non è stato trovato PyroStreams.";
$lang['streams:table_exists']							= "Esiste già una tabella con il link (slug) %s.";
$lang['streams:no_results']								= "Non ci sono risultati";
$lang['streams:no_entry']								= "Impossibile trovare la voce.";
$lang['streams:invalid_search_type']					= "Non è una ricerca valida.";
$lang['streams:search_not_found']						= "Ricerca non trovata.";

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "Questo slug è già assegnato ad un altro campo.";
$lang['streams:not_mysql_safe_word']					= "Il campo %s è una parola riservata per MySQL.";
$lang['streams:not_mysql_safe_characters']				= "Il campo %s contiene caratteri non ammessi.";
$lang['streams:type_not_valid']							= "Per favore seleziona un tipo di campo valido.";
$lang['streams:stream_slug_not_unique']					= "Questo slug è già in uso per un altro stream.";
$lang['streams:field_unique']							= "Il campo %s deve essere unico.";
$lang['streams:field_is_required']						= "Il campo %s è obbligatorio.";
$lang['streams:date_out_or_range']						= "La data che hai scelto è fuori dai limiti consentiti.";

/* Field Labels */

$lang['streams:label.field']							= "Campo";
$lang['streams:label.field_required']					= "Il campo è obbligatorio?";
$lang['streams:label.field_unique']						= "Il campo deve essere unico?";
$lang['streams:label.field_instructions']				= "Istruzioni del campo";
$lang['streams:label.make_field_title_column']			= "Rendi il nome del campo il titolo della colonna";
$lang['streams:label.field_name']						= "Nome del campo";
$lang['streams:label.field_slug']						= "Slug del campo";
$lang['streams:label.field_type']						= "Tipo del campo";
$lang['streams:id']										= "ID";
$lang['streams:created_by']								= "Creato da";
$lang['streams:created_date']							= "Data di creazione";
$lang['streams:updated_date']							= "Data aggiornata";
$lang['streams:value']									= "Valore";
$lang['streams:manage']									= "Gestisci";
$lang['streams:search']									= "Cerca";
$lang['streams:stream_prefix']							= "Prefisso dello stream";

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "Mostra sul form quando aggiungi o cancelli dati.";
$lang['streams:instr.stream_full_name']					= "Nome completo per lo stream.";
$lang['streams:instr.slug']								= "Minuscolo, solo lettere e trattini bassi (underscore).";

/* Titles */

$lang['streams:assign_field']							= "Assegna il campo allo Stream";
$lang['streams:edit_assign']							= "Modifica assegnamenti dello stream";
$lang['streams:add_field']								= "Crea campo";
$lang['streams:edit_field']								= "Modifica campo";
$lang['streams:fields']									= "Campi";
$lang['streams:streams']								= "Stream";
$lang['streams:list_fields']							= "Lista campi";
$lang['streams:new_entry']								= "Nuovo inserimento";
$lang['streams:stream_entries']							= "Voci dello stream";
$lang['streams:entries']								= "Voci";
$lang['streams:stream_admin']							= "Stream Admin"; 
$lang['streams:list_streams']							= "Lista Streams";
$lang['streams:sure']									= "Sei sicuro";
$lang['streams:field_assignments'] 						= "Assegnamenti campi allo Stream";
$lang['streams:new_field_assign']						= "Nuova assegnazione del campo";
$lang['streams:stream_name']							= "Nome Stream";
$lang['streams:stream_slug']							= "Stream Slug";
$lang['streams:about']									= "About"; 
$lang['streams:total_entries']							= "Voci totali";
$lang['streams:add_stream']								= "Nuovo Stream";
$lang['streams:edit_stream']							= "Modifica Stream";
$lang['streams:about_stream']							= "Info sullo Stream";
$lang['streams:title_column']							= "Titolo colonna";
$lang['streams:sort_method']							= "Metodo di ordinamento";
$lang['streams:add_entry']								= "Aggiungi voce";
$lang['streams:edit_entry']								= "Modifica voce";
$lang['streams:view_options']							= "Vedi opzioni";
$lang['streams:stream_view_options']					= "Vedi opzioni Stream";
$lang['streams:backup_table']							= "Backup tabella Stream";
$lang['streams:delete_stream']							= "Cancella Stream";
$lang['streams:entry']									= "Voce";
$lang['streams:field_types']							= "Tipi del campo";
$lang['streams:field_type']								= "Tipo del campo";
$lang['streams:database_table']							= "Tabella database";
$lang['streams:size']									= "Grandezza";
$lang['streams:num_of_entries']							= "Numero di voci";
$lang['streams:num_of_fields']							= "Numero di campi";
$lang['streams:last_updated']							= "Ultimo aggiornamento";
$lang['streams:export_schema']							= "Esporta Schema";

/* Startup */

$lang['streams:start.add_one']							= "aggiungerne uno";
$lang['streams:start.no_fields']						= "Non hai ancora creato nessun campo. Per iniziare puoi ";
$lang['streams:start.no_assign'] 						= "Sembra che non ci siano ancora campi per questo stream. Per iniziare puoi ";
$lang['streams:start.add_field_here']					= "aggiungere qui un campo";
$lang['streams:start.create_field_here']				= "crea qui un campo";
$lang['streams:start.no_streams']						= "Non ci sono ancora stream, puoi iniziare da";
$lang['streams:start.no_streams_yet']					= "Non ci sono ancora stream.";
$lang['streams:start.adding_one']						= "aggiungine uno";
$lang['streams:start.no_fields_to_add']					= "Non sono stati aggiunti campi";
$lang['streams:start.no_fields_msg']					= "Non ci sono campi da aggiungere a questo stream. In PyroStreams, i campi possono essere condivisi tra diversi stream e devono essere creati prima di essere aggiunti allo stream. Puoi iniziare ";
$lang['streams:start.adding_a_field_here']				= "aggiungendo un campo qui";
$lang['streams:start.no_entries']						= "Non ci sono ancora voci per <strong>%s</strong>. Per iniziare puoi ";
$lang['streams:add_fields']								= "aggiungere campi";
$lang['streams:no_entries']								= 'Non ci sono dati';
$lang['streams:add_an_entry']							= "aggiungere una voce";
$lang['streams:to_this_stream_or']						= "per questo stream o";
$lang['streams:no_field_assign']						= "Non sono stati assegnati campi";
$lang['streams:no_fields_msg_first']					= "Sembra che non ci siano ancora campi per questo stream.";
$lang['streams:no_field_assign_msg']					= "Prima di iniziare a inserire i dati devi ";
$lang['streams:add_some_fields']						= "assegnare qualche campo";
$lang['streams:start.before_assign']					= "Prima di assegnare campi allo stream devi creare qualche campo. Puoi ";
$lang['streams:start.no_fields_to_assign']				= "Sembra che non ci siano campi disponibili per essere assegnati. Prima di poter assegnare un campo devi ";

/* Buttons */

$lang['streams:yes_delete']								= "Si, cancella";
$lang['streams:no_thanks']								= "No grazie";
$lang['streams:new_field']								= "Nuovo campo";
$lang['streams:edit']									= "Modifica";
$lang['streams:delete']									= "Cancella";
$lang['streams:remove']									= "Rimuovi";
$lang['streams:reset']									= "Reset";

/* Misc */

$lang['streams:field_singular']							= "campo";
$lang['streams:field_plural']							= "campi";
$lang['streams:by_title_column']						= "Titolo colonna";
$lang['streams:manual_order']							= "Ordine manuale";
$lang['streams:stream_data_line']						= "Modifica i dati base dello stream.";
$lang['streams:view_options_line'] 						= "Scegli quali colonne devono essere visibili nella lista della pagina.";
$lang['streams:backup_line']							= "Fai il backup e scarica la tabella dello stream in un archivio zip.";
$lang['streams:permanent_delete_line']					= "Cancella definitivamente lo stream e tutti i suoi dati.";
$lang['streams:choose_a_field_type']					= "Scegli un tipo per il campo";
$lang['streams:choose_a_field']							= "Scegli un tipo";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "Libreria reCaptcha inizializzata";
$lang['recaptcha_no_private_key']						= "Non hai fornito una API key per Recaptcha";
$lang['recaptcha_no_remoteip'] 							= "Per ragioni di sicurezza devi passare l'indirizzo ip remoto al reCAPTCHA";
$lang['recaptcha_socket_fail'] 							= "Impossibile aprire il socket";
$lang['recaptcha_incorrect_response'] 					= "Risposta non corretta per l'immagine di sicurezza";
$lang['recaptcha_field_name'] 							= "Immagine di sicurezza";
$lang['recaptcha_html_error'] 							= "Si è verificato un errore nel caricare l'immagine di sicurezza. Per favore riprova più tardi";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "Lunghezza massimo";
$lang['streams:upload_location'] 						= "Cartella di Upload";
$lang['streams:default_value'] 							= "Valore di default";

$lang['streams:menu_path']								= 'Menu Path';
$lang['streams:about_instructions']						= 'Una piccola descrizione dello stream.';
$lang['streams:slug_instructions']						= 'Questo sarà anche il nome della tabella nel tuo database.';
$lang['streams:prefix_instructions']					= 'Se usato, questo sarà il prefisso della tabella nel database. Utile nel caso di nomi uguali.';
$lang['streams:menu_path_instructions']					= 'Dove vuoi che la sezione e sotto sezione venga mostrata nel menu. Separali da un forward slash. Es: <strong>Main Section / Sub Section</strong>.';

/* End of file pyrostreams_lang.php */