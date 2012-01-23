<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['api_username'] = "iambrs_1298074268_biz_api1.gmail.com";
$config['api_password'] = "1298074286";
$config['api_signature'] = "Awe05O9DgD-XyAL3-HsFoqNs..1VAOncRYkwEN.LCh-94svEO5c0i0Ar ";
$config['api_endpoint_test'] = "https://api-3t.sandbox.paypal.com/nvp?";
$config['api_endpoint_production'] = "https://api-3t.paypal.com/nvp";
$config['api_version'] = "66.0";

/**
 * Required Parameters
 * 
 * Avoid sending payments to the gateway unless param requirements are met
*/

$config['required_params'] = array(
	'oneoff_payment'	=>	array(
		'cc_type',
		'cc_number',
		'cc_exp',
		'amt'
	),
	'reference_payment' =>	array(
		'identifier',
		'amt',
	),
	'authorize_payment'	=>	array(
		'cc_type',
		'cc_number',
		'cc_exp',
		'amt'	
	),
	'capture_payment'	=>	array(
		'identifier',
		'cc_type',
		'cc_number',
		'cc_exp',
		'amt'
	),
	'void_payment'		=>	array(
		'identifier'
	),
	'get_transaction_details'	=>	array(
		'identifier'
	),
	'change_transaction_status'	=>	array(
		'identifier',
		'action'
	),
	'refund_payment'	=>	array(
		'identifier',
		'refund_type'
	),
	'search_transactions'	=>	array(
		'start_date'
	),
	'recurring_payment'		=>	array(
		'profile_start_date',
		'billing_period',
		'billing_frequency',
		'amt',
		'cc_type',
		'cc_number',
		'exp_date',
		'country_code',
		'street',
		'city',
		'state',
		'postal_code'
	),
	'get_recurring_profile'	=>	array(
		'identifier'
	),
	'suspend_recurring_profile'	=>	array(
		'identifier'
	),
	'activate_recurring_profile'	=>	array(
		'identifier'
	),
	'cancel_recurring_profile'	=>	array(
		'identifier'
	),
	'recurring_bill_outstanding'	=>	array(
		'identifier'
	),
	'update_recurring_profile'	=>	array(
		'identifier'
	)
);