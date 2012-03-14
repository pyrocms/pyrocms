<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config['change_transaction_status'] = array
		(
			'identifier'			=>	'',  //Required. Unique identifier for the transaction, generated from a previous transaction.
			'action'				=>	''  //Required.  Should be Accept or Deny.
		);