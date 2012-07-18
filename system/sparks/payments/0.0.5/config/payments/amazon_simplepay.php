<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['api_signature_version'] = "2";
$config['api_signature_method'] = "HmacSHA256";
$config['api_access_key'] = "AKIAJH777IYQBVL3AOZQ";
$config['api_access_secret_key'] = "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";
$config['api_endpoint_test'] = "https://authorize.payments-sandbox.amazon.com/pba/paypipeline";
$config['api_endpoint_production'] = "https://authorize.payments.amazon.com/pba/paypipeline";
$config['fps_endpoint_test'] = "https://fps.sandbox.amazonaws.com";
$config['fps_endpoint_production'] = "https://fps.amazonaws.com";
$config['fps_version'] = "2008-09-17";
$config['api_signature'] = "44dEwwa6P7C9iI94U/ra33Pn2TS9ie8MkfcvIRyLh7M=";
$config['api_account_id'] = "IMJQCXSTTXAC1LC65HRK5VIA5MP9J1S9SRUFRF";
$config['button_onetime_endpoint'] = 'https://authorize.payments-sandbox.amazon.com/pba/paypipeline';
$config['immediate_return'] = '1';
$config['collect_shipping_address'] = '1';
$config['ipn_url'] = 'http://www.test.com/notify';
$config['return_url'] = 'http://www.test.com/return';
$config['abandon_url'] = 'http://www.test.com/abandon';
$config['custom_button'] = '';
$config['button_choice'] = 'style1.white.small';
$config['donation_widget'] = '0';

$config['button_choices'] = array(
	'style1' => array(
		'white' => array(
			'small' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_small_paynow_withmsg_whitebg.gif',
			'med' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_medium_paynow_withmsg_whitebg.gif',
			'large' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_large_paynow_withmsg_whitebg.gif'
		),
		'light' => array(
			'small' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_small_paynow_withmsg_lightbg.gif',
			'med' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_medium_paynow_withmsg_lightbg.gif',
			'large' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_large_paynow_withmsg_lightbg.gif'
		),
		'dark' => array(
			'small' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_small_paynow_withmsg_darkbg.gif',
			'med' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_medium_paynow_withmsg_darkbg.gif',
			'large' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_large_paynow_withmsg_darkbg.gif'
		),				
	),
	'style2' => array(
		'white' => array(
			'small' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_small_paynow_withlogo_whitebg.gif',
			'med' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_medium_paynow_withlogo_whitebg.gif',
			'large' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_large_paynow_withlogo_whitebg.gif'
		),
		'light' => array(
			'small' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_small_paynow_withlogo_lightbg.gif',
			'med' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_medium_paynow_withlogo_lightbg.gif',
			'large' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_large_paynow_withlogo_lightbg.gif'
		),
		'dark' => array(
			'small' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_small_paynow_withlogo_darkbg.gif',
			'med' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_medium_paynow_withlogo_darkbg.gif',
			'large' => 'http://g-ecx.images-amazon.com/images/G/01/asp/beige_large_paynow_withlogo_darkbg.gif'
		),	
	),
	'style3' => array(
		'white' => array(
			'small' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_small_paynow_withmsg_whitebg.gif',
			'med' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_medium_paynow_withmsg_whitebg.gif',
			'large' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_large_paynow_withmsg_whitebg.gif'
		),
		'light' => array(
			'small' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_small_paynow_withmsg_lightbg.gif',
			'med' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_medium_paynow_withmsg_lightbg.gif',
			'large' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_large_paynow_withmsg_lightbg.gif'
		),
		'dark' => array(
			'small' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_small_paynow_withmsg_darkbg.gif',
			'med' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_medium_paynow_withmsg_darkbg.gif',
			'large' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_large_paynow_withmsg_darkbg.gif'
		),
	),
	'style4' => array(
		'white' => array(
			'small' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_small_paynow_withlogo_whitebg.gif',
			'med' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_medium_paynow_withlogo_whitebg.gif',
			'large' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_large_paynow_withlogo_whitebg.gif'
		),
		'light' => array(
			'small' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_small_paynow_withlogo_lightbg.gif',
			'med' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_medium_paynow_withlogo_lightbg.gif',
			'large' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_large_paynow_withlogo_lightbg.gif'
		),
		'dark' => array(
			'small' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_small_paynow_withlogo_darkbg.gif',
			'med' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_medium_paynow_withlogo_darkbg.gif',
			'large' => 'http://g-ecx.images-amazon.com/images/G/01/asp/golden_large_paynow_withlogo_darkbg.gif'
		),
	)
);
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