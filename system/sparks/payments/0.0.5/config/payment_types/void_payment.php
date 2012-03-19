<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['void_payment'] = array
		(
			'identifier'			=>	'',	//Required. Unique identifier for the transaction, generated from a previous authorization.
			'note'					=>	'' //An optional note to be submitted along with the request.
		);