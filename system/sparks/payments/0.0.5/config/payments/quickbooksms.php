<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['api_application_login'] = "cfpayments.codeigniter.local";
$config['api_connection_ticket'] = "TGT-172-3nhcl7svhgXazfMDkaC_QQ";
$config['api_endpoint_test'] = "https://merchantaccount.ptc.quickbooks.com/j/AppGateway";
$config['api_endpoint_production'] = "https://merchantaccount.quickbooks.com/j/AppGateway";
$config['api_qbxml'] = 'qbmsxml version="4.5"';
//Live: https://merchantaccount.quickbooks.com/j/AppGateway

$config['required_params'] = array(
	'oneoff_payment'	=>	array(
		'cc_number',
		'cc_exp',
		'amt'
	),	
	'authorize_payment'	=> array(
		'cc_number',
		'cc_exp',
		'amt'
	),
	'capture_payment'	=> array(
		'identifier'
	),
	'void_payment'	=>	array(
		'identifier'
	),
	'refund_payment'	=>	array(
		'identifier'
	)		
);