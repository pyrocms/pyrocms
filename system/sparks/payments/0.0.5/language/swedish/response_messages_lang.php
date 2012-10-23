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

$lang['response_message_not_a_module'] = 'Betalningsmodulen är inte giltig';
$lang['response_message_invalid_input'] = 'Betalningsmodulen saknar korrekt formatering.';
$lang['response_message_invalid_date_params'] = 'Enheter måste beskrivas som "År", "Månad" eller "Dag"';
$lang['response_message_not_a_method'] = 'Metoden i förfrågan existerar inte.';
$lang['response_message_required_params_missing'] = 'Obligatoriska fält saknas';
$lang['response_message_authorize_payment_success'] = 'Behörighetsvalideringen lyckades';
$lang['response_message_authorize_payment_local_failure'] = 'Behörighetsvalideringen skickades till betalningsleverantören men valideringen misslyckades';
$lang['response_message_authorize_payment_gateway_failure'] = 'Behörighetskontrollen nekades av betalningsleverantören. ';
$lang['response_message_oneoff_payment_success'] = 'Transaktionen genomfördes';
$lang['response_message_oneoff_payment_local_failure'] = 'Transaktionen kunde inte skickas då den inte kunde valideras.';
$lang['response_message_oneoff_payment_gateway_failure'] = 'Betalningen kunde inte genomföras då den inte accepterades av batelningsleverantören.';
$lang['response_message_oneoff_payment_button_success'] = 'Generering av betalningsknappen lyckades';
$lang['response_message_oneoff_payment_button_local_failure'] = 'Ett problem uppstod när betalningsknappen skulle skapas.';
$lang['response_message_oneoff_payment_button_gateway_failure'] = 'Betalningsknappen kunde inte skapas.';
$lang['response_message_reference_payment_success'] = 'Transaktionen genomfördes';
$lang['response_message_reference_payment_local_failure'] = 'Kunde inte skicka betalningsförfrågan på grund av att den lokala valideringen misslyckades.';
$lang['response_message_reference_payment_gateway_failure'] = 'Betalningen kunde inte genomföras då den nekades av betalningsleverantören';
$lang['response_message_capture_payment_success'] = 'Betalningen togs emot med lyckat reslutat';
$lang['response_message_capture_payment_local_failure'] = 'Kunde inte ta emot betalningsförfrågan på grund av att den lokala valideringen misslyckades.';
$lang['response_message_capture_payment_gateway_failure'] = 'Betalningsförfrågan nekades av betalningsleverantören.';
$lang['response_message_void_payment_success'] = 'Betalningen blev ogiltigförklarad.';
$lang['response_message_void_refund_success'] = 'Återbetalningen lyckades';
$lang['response_message_void_payment_local_failure'] = 'Förfrågan om att ogiltigförklara transaktionen kunde inte skickas då den lokala valideringen misslyckades';
$lang['response_message_void_payment_gateway_failure'] = 'Begäran togs inte emot av betalningsleverantören';
$lang['response_message_void_refund_gateway_failure'] = 'Förfrågan om att ogiltigförklara transaktionen togs inte emot av betalningsleverantören.';
$lang['response_message_get_transaction_details_success'] = 'Data om transaktionen mottogs.';
$lang['response_message_get_transaction_details_local_failure'] = 'Transaktionen kunde inte skickas på grund av att den lokala valideringen misslyckades.';
$lang['response_message_get_transaction_details_gateway_failure'] = 'Transaktionen kunde inte tas emot av betalningsleverantören.';
$lang['response_message_change_transaction_status_success'] = 'Transaktionsstatus uppdaterad';
$lang['response_message_change_transaction_status_local_failure'] = 'Transaktionstatus kunde inte skickas på grund av att den lokala valideringen misslyckades.';
$lang['response_message_change_transaction_status_gateway_failure'] = 'Transaktionstatus kunde inte tas emot av betalningsleverantören';
$lang['response_message_refund_payment_success'] = 'Återbetalning har utförts.';
$lang['response_message_refund_payment_local_failure'] = 'Begäran om återbetalning misslyckades på grund av valideringsproblem lokalt';
$lang['response_message_refund_payment_gateway_failure'] = 'Återbetalning nekades av betalningsleverantören.';
$lang['response_message_search_transactions_success'] = 'Transaktionsinformation mottagen';
$lang['response_message_search_transactions_local_failure'] = 'Transaktionsökningen kunde inte utföras på grund av lokalt valideringsproblem';
$lang['response_message_search_transactions_gateway_failure'] = 'Sökningen misslyckades';
$lang['response_message_recurring_payment_success'] = 'Återkommande betalningar har initierats';
$lang['response_message_recurring_payment_local_failure'] = 'Begäran om återkommande betalningar kunde inte skickas på grund av lokalt valideringsproblem';
$lang['response_message_recurring_payment_gateway_failure'] = 'Begäran om återkommande betalningar accepterades inte av betalningsleverantören.';
$lang['response_message_get_recurring_profile_success'] = 'Profil för återkommande betalningar tog emot.';
$lang['response_message_get_recurring_profile_local_failure'] = 'Profil för återkommande betalningar kunde inte tas emot på grund av valideringsproblem.';
$lang['response_message_get_recurring_profile_gateway_failure'] = 'Profil för återkommande betalningar kunde inte tas emot av betalningsleverantören';
$lang['response_message_suspend_recurring_profile_success'] = 'Profil för återkommande betalningar har upphört.';
$lang['response_message_suspend_recurring_profile_local_failure'] = 'Begäran om upphörande av återkommande betalningar kunde inte skickas på grund av valideringsproblem.';
$lang['response_message_suspend_recurring_profile_gateway_failure'] = 'Begäran om upphörande av återkommande betalningar kunde inte tas emot av betalningsleverantören.';
$lang['response_message_activate_recurring_profile_success'] = 'Profil för återkommande betalningar har aktiverats.';
$lang['response_message_activate_recurring_profile_local_failure'] = 'Aktivering av profil för återkommande betalningar kunde inte skickas på grund av valideringsproblem.';
$lang['response_message_activate_recurring_profile_gateway_failure'] = 'Aktivering av profil för återkommande betalningar kunde inte utföras av betalningsleverantören.';
$lang['response_message_cancel_recurring_profile_success'] = 'Profil för återkommande betalningar har tagits bort.';
$lang['response_message_cancel_recurring_profile_local_failure'] = 'Profil för återkommande betalningar kunde inte tas bort på grund av valideringsproblem.';
$lang['response_message_cancel_recurring_profile_gateway_failure'] = 'Profil för återkommande betalningar kunde inte tas bort hos betalningsleverantören.';
$lang['response_message_recurring_bill_outstanding_success'] = 'Utestående fordran har skickats';
$lang['response_message_recurring_bill_outstanding_local_failure'] = 'Utestående fordran kunde inte skickas på grund av valideringsproblem.';
$lang['response_message_recurring_bill_outstanding_gateway_failure'] = 'Utestående fordran kunde inte tas emot av betalningsleverantören.';
$lang['response_message_update_recurring_profile_success'] = 'Profil för återkommande betalningar har uppdaterats.';
$lang['response_message_update_recurring_profile_local_failure'] = 'Profil för återkommande betalningar kunde inte skickas på grund av valideringsproblem.';
$lang['response_message_update_recurring_profile_gateway_failure'] = 'Profil för återkommande betalningar kunde inte tas emot av betalningsleverantören.';


/* End of file response_messages_lang.php */  
/* Location: system/sparks/payments/0.0.5/language/swedish/response_messages_lang.php */  
