<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['api_username'] = "58Lct5BSN";
$config['api_password'] = "6Wvtm62f543DSXpx";
//Note: you can sign into the test interface at test.authorize.net
$config['api_endpoint_test'] = "https://apitest.authorize.net/xml/v1/request.api";
$config['api_endpoint_production'] = "https://secure.authorize.net/gateway/transact.dll";
$config['email_customer'] = TRUE;
$config['test_mode'] = FALSE;

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
	'authorize_payment'	=>	array(
		'cc_type',
		'cc_number',
		'cc_exp',
		'amt'	
	),
	'capture_payment'	=>	array(
		'identifier'
	),
	'void_payment'		=>	array(
		'identifier'
	),
	'refund_payment'	=>	array(
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
		'cc_number',
		'cc_exp',
		'amt'
	),
	'search_transactions'	=>	array(
		'start_date'
	),
	'recurring_payment'		=>	array(
		'first_name',
		'last_name',
		'profile_start_date',
		'billing_period',
		'billing_frequency',
		'total_billing_cycles',
		'amt',
		'cc_type',
		'cc_exp',
		'cc_number',
		'country_code',
		'street',
		'city',
		'state',
		'postal_code'
	),
	'get_recurring_profile'	=>	array(
		'identifier'
	),
	'update_recurring_profile'	=>	array(
		'identifier'
	),	
	'cancel_recurring_profile'	=>	array(
		'identifier'
	),
);