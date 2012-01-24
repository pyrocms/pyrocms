<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['api_cid'] = "1000001";
$config['api_username'] = "teststore";
$config['api_password'] = "psigate1234";
$config['api_recurring_password'] = "testpass";
$config['api_endpoint_test'] = "https://dev.psigate.com:7989/Messenger/XMLMessenger";
$config['api_endpoint_production'] = ""; //YOU SHOULD RECEIVE THIS FROM PSIGATE AFTER SIGNING UP
$config['api_recurring_endpoint_test'] = "https://dev.psigate.com:8645/Messenger/AMMessenger";
$config['api_recurring_endpoint_production'] = ""; //YOU SHOULD RECEIVE THIS FROM PSIGATE AFTER SIGNING UP

$config['required_params'] = array(
	'oneoff_payment'	=>	array(
		'cc_number',
		'cc_exp',
		'cc_code',
		'amt'
	),
	'authorize_payment'	=>	array(
		'cc_number',
		'cc_exp',
		'cc_code',
		'amt'
	),
	'capture_payment'	=>	array(
		'identifier'
	),
	'void_payment'	=>	array(
		'identifier'
	),	
	'refund_payment'=>	array(
		'identifier',
		'identifier_2'
	),					
);