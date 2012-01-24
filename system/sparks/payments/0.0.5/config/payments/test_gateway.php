<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//Set to either gateway or local
$config['return_mode'] = "local";

//Set to either success or failure
$config['set_response_to'] = "success";

//Set to either xml or string
$config['request_format'] = "xml";
$config['response_format'] = "xml";

/**
 * Required Parameters
 * 
 * Avoid sending payments to the gateway unless param requirements are met
*/

$config['required_params'] = array(
	'oneoff_payment_button'	=>	array(
		'amt',
		'desc',
	),
	'authorize_payment_button' => array(
		'amt',
		'desc'
	),
	'capture_payment_button' => array(
		'amt',
		'desc',
		'billing_period'
	),
	'recurring_payment_button' => array(
		'amt',
		'desc',
		'billing_period',
		'billing_frequency'
	),
	'void_transaction' => array(
		'identifier'
	),
	'cancel_recurring_profile' => array(
		'identifier'
	),
);