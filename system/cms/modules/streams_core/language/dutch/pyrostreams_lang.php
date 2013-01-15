<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "Er was een probleem met het opslaan van uw veld.";
$lang['streams:field_add_success']						= "Uw veld is succesvol toegevoegd.";
$lang['streams:field_update_error']						= "Er was een probleem met het bijwerken van uw veld.";
$lang['streams:field_update_success']					= "Uw veld is succesvol bijgewerkt.";
$lang['streams:field_delete_error']						= "Er was een probleem met het verwijderen van uw veld.";
$lang['streams:field_delete_success']					= "Uw veld is succesvol verwijderd.";
$lang['streams:view_options_update_error']		= "Er was een probleem met het bijwerken van de weergave-opties.";
$lang['streams:view_options_update_success']	= "Weergave-opties zijn succesvol bijgewerkt.";
$lang['streams:remove_field_error']						= "Er was een probleem met het verwijderen van de weergave-opties.";
$lang['streams:remove_field_success']					= "Weergave-opties zijn succesvol verwijderd.";
$lang['streams:create_stream_error']					= "Er was een probleem met het maken van uw stream.";
$lang['streams:create_stream_success']				= "Uw stream is succesvol toegevoegd.";
$lang['streams:stream_update_error']					= "Er was een probleem met het bijwerken van uw stream.";
$lang['streams:stream_update_success']				= "Uw stream is succesvol bijgewerkt.";
$lang['streams:stream_delete_error']					= "Er was een probleem met het verwijderen van uw stream.";
$lang['streams:stream_delete_success']				= "Uw stream is succesvol verwijderd.";
$lang['streams:stream_field_ass_add_error']		= "Er was een probleem met het toevoegen van uw veld aan deze stream.";
$lang['streams:stream_field_ass_add_success']	= "Uw veld is succesvol toegevoegd aan deze stream.";
$lang['streams:stream_field_ass_upd_error']		= "Er was een probleem met het bijwerken van uw veld toewijzing.";
$lang['streams:stream_field_ass_upd_success']	= "Uw veld toewijzing is succesvol bijgewerkt.";
$lang['streams:delete_entry_error']						= "Er was een probleem met het verwijderen van uw ingave.";
$lang['streams:delete_entry_success']					= "Uw ingave is succesvol verwijderd.";
$lang['streams:new_entry_error']						  = "Er was een probleem met het toevoegen van uw ingave.";
$lang['streams:new_entry_success']						= "Uw ingave is succesvol toegevoegd.";
$lang['streams:edit_entry_error']						  = "Er was een probleem met het bijwerken van uw ingave.";
$lang['streams:edit_entry_success']						= "Uw ingave is succesvol bijgewerkt.";
$lang['streams:delete_summary']						  	= "Weet u zeker dat u de stream <strong>%s</strong> wilt verwijderen? Dit verwijderd <strong>delete %s %s</strong> permanent.";

/* Misc Errors */

$lang['streams:no_stream_provided']				= "Er is geen stream verstrekt.";
$lang['streams:invalid_stream']						= "Ongeldige stream.";
$lang['streams:not_valid_stream']					= "is geen geldige stream.";
$lang['streams:invalid_stream_id']        = "Ongeldig stream ID.";
$lang['streams:invalid_row']              = "Ongeldige rij.";
$lang['streams:invalid_id']								= "Ongeldig ID.";
$lang['streams:cannot_find_assign']				= "Veld toewijzing kan niet gevonden worden.";
$lang['streams:cannot_find_pyrostreams']  = "PyroStreams kan niet gevonden worden.";
$lang['streams:table_exists']							= "Een tabel met de slug %s bestaat al.";
$lang['streams:no_results']								= "Geen resultaten";
$lang['streams:no_entry']								  = "Ingave kan niet gevonden worden.";
$lang['streams:invalid_search_type']			= "is geen geldig zoek type.";
$lang['streams:search_not_found']					= "Zoekopdracht niet gevonden.";

/* Validation Messages */

$lang['streams:field_slug_not_unique']			= "Deze veld slug is al in gebruik.";
$lang['streams:not_mysql_safe_word']				= "Het %s veld is een MySQL gereserveerd woord.";
$lang['streams:not_mysql_safe_characters']	= "Het %s veld bevat ongeldige characters.";
$lang['streams:type_not_valid']							= "Selecteer een geldig veld type.";
$lang['streams:stream_slug_not_unique']			= "Deze stream slug is al in gebruik.";
$lang['streams:field_unique']							  = "Het %s veld moet uniek zijn.";
$lang['streams:field_is_required']					= "Het %s veld is verplicht.";
$lang['streams:date_out_or_range']					= "De datum die u heeft gekozen is buiten het toegestaande bereik.";

/* Field Labels */

$lang['streams:label.field']							      = "Veld";
$lang['streams:label.field_required']					  = "Veld is verplicht";
$lang['streams:label.field_unique']						  = "Veld is uniek";
$lang['streams:label.field_instructions']				= "Veld instructies";
$lang['streams:label.make_field_title_column']	= "Maak veld de titel column";
$lang['streams:label.field_name']						    = "Veld naam";
$lang['streams:label.field_slug']					    	= "Veld slug";
$lang['streams:label.field_type']					    	= "Field type";
$lang['streams:id']								          		= "ID";
$lang['streams:created_by']					      			= "Gemaakt door";
$lang['streams:created_date']				      			= "Gemaakt op";
$lang['streams:updated_date']			      				= "Bewerkt op";
$lang['streams:value']						        			= "Waarde";
$lang['streams:manage']						        			= "Beheer";
$lang['streams:search']						        			= "Zoek";
$lang['streams:stream_prefix']			     				= "Stream prefix";

/* Field Instructions */

$lang['streams:instr.field_instructions']	= "Weergeef op formulier wanneer data wordt ingevoerd of bewerkt.";
$lang['streams:instr.stream_full_name']		= "Volledige naam voor uw stream.";
$lang['streams:instr.slug']								= "Lowercase, alleen letters en underscores.";

/* Titles */

$lang['streams:assign_field']							= "Wijs veld toe aan Stream";
$lang['streams:edit_assign']							= "Wijzig veld toewijzing";
$lang['streams:add_field']								= "Nieuw veld";
$lang['streams:edit_field']								= "Wijzig veld";
$lang['streams:fields']									  = "Velden";
$lang['streams:streams']							  	= "Streams";
$lang['streams:list_fields']							= "Velden overzicht";
$lang['streams:new_entry']								= "Nieuwe ingave";
$lang['streams:stream_entries']						= "Stream ingaves";
$lang['streams:entries']						  		= "Ingaves";
$lang['streams:stream_admin']							= "Stream Admin";
$lang['streams:list_streams']							= "Overzicht Streams";
$lang['streams:sure']							    		= "Weet u het zeker?";
$lang['streams:field_assignments'] 				= "Stream veld toewijzingen";
$lang['streams:new_field_assign']					= "Nieuwe veld toewijzing";
$lang['streams:stream_name']							= "Stream naam";
$lang['streams:stream_slug']							= "Stream slug";
$lang['streams:about']							  		= "Over";
$lang['streams:total_entries']						= "Totaal aantal ingaves";
$lang['streams:add_stream']								= "Nieuwe Stream";
$lang['streams:edit_stream']							= "Wijzig Stream";
$lang['streams:about_stream']							= "Over deze Stream";
$lang['streams:title_column']							= "Titel column";
$lang['streams:sort_method']							= "Sorteer methode";
$lang['streams:add_entry']								= "Nieuwe ingave";
$lang['streams:edit_entry']								= "Wijzig ingave";
$lang['streams:view_options']							= "Weergave opties";
$lang['streams:stream_view_options']			= "Stream weergave opties";
$lang['streams:backup_table']							= "Backup Stream tabel";
$lang['streams:delete_stream']						= "Verwijder Stream";
$lang['streams:entry']								  	= "Ingave";
$lang['streams:field_types']							= "Veld types";
$lang['streams:field_type']								= "Veld type";
$lang['streams:database_table']						= "Database tabel";
$lang['streams:size']							    		= "Formaat";
$lang['streams:num_of_entries']						= "Aantal ingave";
$lang['streams:num_of_fields']						= "Aantal velden";
$lang['streams:last_updated']							= "Laatst bijgewerkt";
$lang['streams:export_schema']						= "Export schema"; #translate

/* Startup */

$lang['streams:start.add_one']							= "hier een toevoegen";
$lang['streams:start.no_fields']						= "U heeft nog geen velden toegevoegd. Om te beginnen, kunt u ";
$lang['streams:start.no_assign'] 						= "Het ziet er naar uit dat deze stream nog geen velden heeft. Om te beginnen, kunt u";
$lang['streams:start.add_field_here']				= "hier een veld toevoegen";
$lang['streams:start.create_field_here']		= "hier een veld toevoegen";
$lang['streams:start.no_streams']						= "Er zijn nog geen streams. Om te beginnen, kunt u ";
$lang['streams:start.no_streams_yet']				= "Er zijn nog geen streams.";
$lang['streams:start.adding_one']						= "hier een stream toevoegen.";
$lang['streams:start.no_fields_to_add']			= "Er zijn geen velden om toe te voegen.";
$lang['streams:start.no_fields_msg']				= "Er zijn geen velden om aan deze stream toe te voegen. In PyroStreams, veld types kunnen worden verdeeld onder streams en moeten eerst worden toegevoegd. Om te beginnen, kunt u";
$lang['streams:start.adding_a_field_here']	= "hier een veld toevoegen";
$lang['streams:start.no_entries']						= "Er zijn nog geen ingaves voor <strong>%s</strong>. Om te beginnen, kunt u";
$lang['streams:add_fields']								  = "een veld toewijzen";
$lang['streams:no_entries']								= 'No entries'; #translate
$lang['streams:add_an_entry']						  	= "een ingave toevoegen";
$lang['streams:to_this_stream_or']					= "voor deze stream of";
$lang['streams:no_field_assign']						= "Geen veld toewijzingen";
$lang['streams:no_fields_msg_first']				= "Het ziet er naar uit dat deze stream geen velden heeft.";
$lang['streams:no_field_assign_msg']				= "Voordat u kunt beginnen, moet u eerst";
$lang['streams:add_some_fields']						= "een paar velden toewijzen";
$lang['streams:start.before_assign']				= "Voordat u velden kut toewijzen, moet u eerst een veld maken. u kunt";
$lang['streams:start.no_fields_to_assign']	= "Het ziet er naar uit dat er geen velden zijn om toe te wijzen. Voordat u een veld kunt toewijzen moet u eerst";

/* Buttons */

$lang['streams:yes_delete']								= "Ja, verwijder";
$lang['streams:no_thanks']								= "Nee bedankt";
$lang['streams:new_field']								= "Nieuw veld";
$lang['streams:edit']								    	= "Bewerk";
$lang['streams:delete']							  		= "Verwijder";
$lang['streams:remove']							  		= "Haal weg";
$lang['streams:reset']							  		= "Reset";

/* Misc */

$lang['streams:field_singular']						= "veld";
$lang['streams:field_plural']							= "velden";
$lang['streams:by_title_column']					= "bij titel column";
$lang['streams:manual_order']							= "Handmatige volgorde";
$lang['streams:stream_data_line']					= "Bewerk basis stream data.";
$lang['streams:view_options_line'] 				= "Kies welke colummen zichtbaar moeten zijn op de data pagina.";
$lang['streams:backup_line']							= "Backup en download stream tabel in een zip bestand.";
$lang['streams:permanent_delete_line']		= "verwijder een stream en alle data permanent.";
$lang['streams:choose_a_field_type']			= "Kies een veld type";
$lang['streams:choose_a_field']						= "Kies een veld";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 				= "reCaptcha bibliotheek geïnstalleerd";
$lang['recaptcha_no_private_key']						= "U heeft geen API key for Recaptcha opgegeven";
$lang['recaptcha_no_remoteip'] 							= "Om beveiligings redenen, moet u de remote ip naar reCAPTCHA opgeven";
$lang['recaptcha_socket_fail'] 							= "Kan socket niet openen";
$lang['recaptcha_incorrect_response'] 			= "Ongeldige beveiligings afbeelding reactie";
$lang['recaptcha_field_name'] 							= "Beveiligings afbeelding";
$lang['recaptcha_html_error'] 							= "Fout tijdens het laden van de beveiligings afbeelding. Probeer het later nog eens.";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "Maximale lengte";
$lang['streams:upload_location'] 					= "Upload locatie";
$lang['streams:default_value'] 						= "Standaard waarde";

$lang['streams:menu_path']								= 'Menu Path'; #translate
$lang['streams:about_instructions']						= 'A short description of your stream.'; #translate
$lang['streams:slug_instructions']						= 'This will also be the database table name for your stream.'; #translate
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.'; #translate
$lang['streams:menu_path_instructions']					= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.'; #translate

/* End of file pyrostreams_lang.php */
