<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams.save_field_error'] 						= "Fältet kunde inte sparas.";
$lang['streams.field_add_success']						= "Fältet sparades.";
$lang['streams.field_update_error']						= "Fältet kunde inte uppdateras.";
$lang['streams.field_update_success']					= "Fältet uppdaterat.";
$lang['streams.field_delete_error']						= "Fältet kunde inte raderas.";
$lang['streams.field_delete_success']					= "Fältet raderat.";
$lang['streams.view_options_update_error']				= "Det gick inte att uppdatera inställningarna av visning.";
$lang['streams.view_options_update_success']			= "Inställningarna av visning är uppdaterade.";
$lang['streams.remove_field_error']						= "Det gick inte att radera fältet.";
$lang['streams.remove_field_success']					= "Fältet kunde inte raderas.";
$lang['streams.create_stream_error']					= "Det gick inte att skapa en ny stream.";
$lang['streams.create_stream_success']					= "Stream skapad.";
$lang['streams.stream_update_error']					= "Uppdatering av stream misslyckades.";
$lang['streams.stream_update_success']					= "Uppdatering av stream utförd.";
$lang['streams.stream_delete_error']					= "Det gick inte att radera stream.";
$lang['streams.stream_delete_success']					= "Stream raderad.";
$lang['streams.stream_field_ass_add_error']				= "Det gick inte att lägga till fältet till denna stream.";
$lang['streams.stream_field_ass_add_success']			= "Fältet tillagt.";
$lang['streams.stream_field_ass_upd_error']				= "Fält-tilldelningen misslyckades.";
$lang['streams.stream_field_ass_upd_success']			= "Fält-tilldelningen uppdaterad.";
$lang['streams.delete_entry_error']						= "Det gick inte att radera posten.";
$lang['streams.delete_entry_success']					= "Posten raderad.";
$lang['streams.new_entry_error']						= "Det gick inte att lägga till posten.";
$lang['streams.new_entry_success']						= "Posten tillagd.";
$lang['streams.edit_entry_error']						= "Det gick inte att uppdatera posten.";
$lang['streams.edit_entry_success']						= "Posten raderad.";
$lang['streams.delete_summary']							= "Är du säker på att du vill radera <strong>%s</strong> stream? Detta kommer att <strong>radera %s %s</strong>.";

/* Misc Errors */

$lang['streams.no_stream_provided']						= "Ingen stream har valts.";
$lang['streams.invalid_stream']							= "Ogiltig stream.";
$lang['streams.not_valid_stream']						= "inte en giltig stream.";
$lang['streams.invalid_stream_id']						= "Ogiltigt stream ID.";
$lang['streams.invalid_row']							= "Ogiltig rad.";
$lang['streams.invalid_id']								= "Ogiltigt ID.";
$lang['streams.cannot_find_assign']						= "Kan inte hitta fältkopping.";
$lang['streams.cannot_find_pyrostreams']				= "Kan inte hitta PyroStreams.";
$lang['streams.table_exists']							= "En tabell med slugg-namnet %s finns redan.";
$lang['streams.no_results']								= "Inget innehåll hittades";
$lang['streams.no_entry']								= "Kan inte hitta någon post.";
$lang['streams.invalid_search_type']					= "ingen giltig söktyp.";
$lang['streams.search_not_found']						= "Sökning kunde inte hittas.";

/* Validation Messages */

$lang['streams.field_slug_not_unique']					= "Denna fält-slugg används redan.";
$lang['streams.not_mysql_safe_word']					= "%s fältet är reserverat av MySQL databasen.";
$lang['streams.not_mysql_safe_characters']				= "%s fältet innehåller ogiltiga tecken.";
$lang['streams.type_not_valid']							= "Vänligen, ange en giltig fälttyp.";
$lang['streams.stream_slug_not_unique']					= "Denna stream slugg används redan.";
$lang['streams.field_unique']							= "%s fältet måste vara unikt.";
$lang['streams.field_is_required']						= "%s fältet är obligatoriskt.";
$lang['streams.date_out_or_range']						= "The date you have chosen is out of the acceptable range."; #translate

/* Field Labels */

$lang['streams.label.field']							= "Fält";
$lang['streams.label.field_required']					= "Fältet är obligatoriskt";
$lang['streams.label.field_unique']						= "Fältet är unikt";
$lang['streams.label.field_instructions']				= "Instruktioner för fältet";
$lang['streams.label.make_field_title_column']			= "Ange detta fält som 'title' kolumn";
$lang['streams.label.field_name']						= "Fältnamn";
$lang['streams.label.field_slug']						= "Fältslugg";
$lang['streams.label.field_type']						= "Fälttyp";
$lang['streams.id']										= "ID";
$lang['streams.created_by']								= "Skapad av";
$lang['streams.created_date']							= "Skapad datum";
$lang['streams.updated_date']							= "Uppdaterad datum";
$lang['streams.value']									= "Värde";
$lang['streams.manage']									= "Hantera";
$lang['streams.search']									= "sök";
$lang['streams:stream_prefix']							= "Stream prefix";

/* Field Instructions */

$lang['streams.instr.field_instructions']				= "Visas på formuläret när man lägger till eller uppdaterar data.";
$lang['streams.instr.stream_full_name']					= "Namnet på din stream.";
$lang['streams.instr.slug']								= "Gemener, bara bokstäver och understreck.";

/* Titles */

$lang['streams.assign_field']							= "Koppla fält till stream";
$lang['streams.edit_assign']							= "Redigera stream kopplingar";
$lang['streams.add_field']								= "Skapa fält";
$lang['streams.edit_field']								= "Redigera fält";
$lang['streams.fields']									= "Fält";
$lang['streams.streams']								= "Streams";
$lang['streams.list_fields']							= "Lista fält";
$lang['streams.new_entry']								= "Ny post";
$lang['streams.stream_entries']							= "Stream poster";
$lang['streams.entries']								= "Poster";
$lang['streams.stream_admin']							= "Stream-hantering";
$lang['streams.list_streams']							= "Lista streams";
$lang['streams.sure']									= "Är du säker?";
$lang['streams.field_assignments'] 						= "Stream fält-kopplingar";
$lang['streams.new_field_assign']						= "Ny fält-koppling";
$lang['streams.stream_name']							= "Stream-namn";
$lang['streams.stream_slug']							= "Stream-slugg";
$lang['streams.about']									= "Om";
$lang['streams.total_entries']							= "Poster totalt";
$lang['streams.add_stream']								= "Ny stream";
$lang['streams.edit_stream']							= "Redigera stream";
$lang['streams.about_stream']							= "om denna stream";
$lang['streams.title_column']							= "Titel kolumn";
$lang['streams.sort_method']							= "Sorteringsmetod";
$lang['streams.add_entry']								= "Lägg till post";
$lang['streams.edit_entry']								= "Redigera post";
$lang['streams.view_options']							= "Visningsalternativ";
$lang['streams.stream_view_options']					= "Stream visningsalternativ";
$lang['streams.backup_table']							= "Säkerhetskopiera Stream-tabell";
$lang['streams.delete_stream']							= "Radera stream";
$lang['streams.entry']									= "Post";
$lang['streams.field_types']							= "Fälttyper";
$lang['streams.field_type']								= "Fälttype";
$lang['streams.database_table']							= "Databastabell";
$lang['streams.size']									= "Storlek";
$lang['streams.num_of_entries']							= "Antal poster";
$lang['streams.num_of_fields']							= "Antal fält";
$lang['streams.last_updated']							= "Senast uppdaterad";

/* Startup */

$lang['streams.start.add_one']							= "lägg till en här";
$lang['streams.start.no_fields']						= "Du har inte skapat några fält än. Till att börja med kan du";
$lang['streams.start.no_assign'] 						= "Det finns inga fält kopplade till denna stream. Till att börja med kan du";
$lang['streams.start.add_field_here']					= "lägg till ett fält här";
$lang['streams.start.create_field_here']				= "skapa ett fält här";
$lang['streams.start.no_streams']						= "Streams saknas, men du kan börja med";
$lang['streams.start.no_streams_yet']					= "Det finns inga streams ännu.";
$lang['streams.start.adding_one']						= "lägg till en";
$lang['streams.start.no_fields_to_add']					= "Inga fält att lägga till";		
$lang['streams.start.no_fields_msg']					= "Det finns inga fält att lägga till, till denna stream. I PyroStreams, kan fälttyper delas mellan streams. Fälten måste skapas innan de kan kopplas till en stream. Du kan börja med att";
$lang['streams.start.adding_a_field_here']				= "lägga till ett fält här";
$lang['streams.start.no_entries']						= "Det finnns inga poster i <strong>%s</strong>. Till att börja med kan du";
$lang['streams.add_fields']								= "koppla fält";
$lang['streams.add_an_entry']							= "lägga till en post";
$lang['streams.to_this_stream_or']						= "till denna stream eller";
$lang['streams.no_field_assign']						= "Inga fält-kopplingar";
$lang['streams.no_fields_msg_first']					= "Finns inga fält kopplade till denna stream.";
$lang['streams.no_field_assign_msg']					= "Innan du kan lägra data så måste du";
$lang['streams.add_some_fields']						= "koppla fält";
$lang['streams.start.before_assign']					= "Innan du kopplar några fält till en stream så måste du skapa ett fält. Du kan";
$lang['streams.start.no_fields_to_assign']				= "Finns inga tillgängliga fält att koppla till din stream. Innan du kan koppla ett fält måste du ";

/* Buttons */

$lang['streams.yes_delete']								= "Ja, radera";
$lang['streams.no_thanks']								= "Nej tack";
$lang['streams.new_field']								= "Nytt fält";
$lang['streams.edit']									= "Redigera";
$lang['streams.delete']									= "Radera";
$lang['streams.remove']									= "Ta bort";
$lang['streams.reset']									= "Återställ";

/* Misc */

$lang['streams.field_singular']							= "fält";
$lang['streams.field_plural']							= "fält";
$lang['streams.by_title_column']						= "Genom 'title' kolumn";
$lang['streams.manual_order']							= "Manuell sortering";
$lang['streams.stream_data_line']						= "Redigera grundläggande stream-data.";
$lang['streams.view_options_line'] 						= "Välj vilka kolumner som ska synas på data-sidan.";
$lang['streams.backup_line']							= "Säkerhetskopiera och ladda ner stream-tabellen som en Zip-fil.";
$lang['streams.permanent_delete_line']					= "Radera stream och alla dess poster permanent.";
$lang['streams.choose_a_field_type']					= "Välj fälttyp";
$lang['streams.choose_a_field']							= "Välj fält";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "reCaptcha bibliotek initialiserat";
$lang['recaptcha_no_private_key']						= "Du angav inte en API-nyckel för Recaptcha";
$lang['recaptcha_no_remoteip'] 							= "Av säkerhetsskäl så måste du ange 'remote ip' till reCAPTCHA";
$lang['recaptcha_socket_fail'] 							= "Kunde inte öppna socket";
$lang['recaptcha_incorrect_response'] 					= "Säkerhetsbilden mottogs felaktigt";
$lang['recaptcha_field_name'] 							= "Säkerhetsbild";
$lang['recaptcha_html_error'] 							= "Ett fel inträffade när säkerhetsbilden skulle laddas. Försök igen senare";

/* Default Parameter Fields */

$lang['streams.max_length'] 							= "Maxlängd";
$lang['streams.upload_location'] 						= "Plats för uppladning";
$lang['streams.default_value'] 							= "Standardvärde";

/* End of file pyrostreams_lang.php */