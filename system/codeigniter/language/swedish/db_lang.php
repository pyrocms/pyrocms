<?php defined('BASEPATH') or exit('No direct script access allowed');

 /**
 * Swedish translation.
 *
 * @author		marcus@incore.se
 * @package		PyroCMS  
 * @link		http://pyrocms.com
 * @date		2012-10-22
 * @version		1.1.0
 */

$lang['db_invalid_connection_str'] = 'Det gick inte att avgöra vilka databasinställningar som ska användas med hjälp av din anslutningssträng.';
$lang['db_unable_to_connect'] = 'Det går inte att ansluta till din databas genom att använda de angivna inställningarna.';
$lang['db_unable_to_select'] = 'Det gick inte att välja databasen: %s';
$lang['db_unable_to_create'] = 'Det gick inte att skapa databasen: %s';
$lang['db_invalid_query'] = 'SQL-frågan är inte korrekt.';
$lang['db_must_set_table'] = 'Du måste ställa in databas-tabellen för att användas med din sökning.';
$lang['db_must_use_set'] = 'Du måste använda "set" för att uppdatera en post.';
$lang['db_must_use_index'] = 'Du måste ange ett index för batchuppdateringar.';
$lang['db_batch_missing_index'] = 'En eller flera rader somska uppdateras saknar indexvärde.';
$lang['db_must_use_where'] = 'Uppdateringar är inte tillåtna om de inte innehåller en "where"-sats.';
$lang['db_del_must_use_where'] = 'Deletes är inte tillåtna om de inte innehåller ett "where" eller "like".';
$lang['db_field_param_missing'] = 'För att hämta fält kräves namnet på tabellen som en parameter.';
$lang['db_unsupported_function'] = 'Den här funktionen är inte tillgänglig för databasen du använder.';
$lang['db_transaction_failure'] = 'Transaktionen misslyckades: Återställning har utförts.';
$lang['db_unable_to_drop'] = 'Det gick inte att anvönda "drop" på den angivna databasen.';
$lang['db_unsuported_feature'] = 'Funktionen fungerar inte med den databas du använder';
$lang['db_unsuported_compression'] = 'Filkomprimeringsformatet stöds inte av servern.';
$lang['db_filepath_error'] = 'Det går inte att skriva data till sökvägen du angett.';
$lang['db_invalid_cache_path'] = 'Cache-sökvägen du angav är antingen inte giltig eller så är den skrivskyddad.';
$lang['db_table_name_required'] = 'Kommandot kräver ett tabellnamn.';
$lang['db_column_name_required'] = 'Kommandot kräver ett kolumnnamn.';
$lang['db_column_definition_required'] = 'Kommandot kräver en kolumndefinition.';
$lang['db_unable_to_set_charset'] = 'Det gick inte att ställa in teckenuppsättning %s för klientanslutning';
$lang['db_error_heading'] = 'Ett databasfel inträffade';


/* End of file db_lang.php */  
/* Location: system/codeigniter/language/swedish/db_lang.php */  
