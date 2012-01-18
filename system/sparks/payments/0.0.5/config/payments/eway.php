<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['api_cid'] = "87654321";
//Note: you can sign into the test interface at test.authorize.net
$config['api_endpoint_test'] = "https://www.eway.com.au/gateway/xmltest/testpage.asp";
$config['api_endpoint_production'] = "https://www.eway.com.au/gateway_cvn/xmlpayment.asp";

$config['required_params'] = array(
	'oneoff_payment'	=>	array(
		'first_name',
		'last_name',
		'email',
		'cc_number',
		'cc_exp',	
		'street',
		'postal_code'
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