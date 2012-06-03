<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['recurring_payment_button'] = array(
	'amt'						=>	'',	//Amount for the payment
	'desc'						=>	'', //A description for the transaction
	'trial_billing_frequency'	=>	'', //Set this if you want a trial.  Year, month, week, day.
	'trial_billing_cycles'		=>	'', //Total # of times you want the customer to be billed at the trial rate.
	'trial_amt'					=>	'',	//The trial rate.
	'profile_start_date' 		=> '',
	'billing_period' 			=> '',
	'billing_frequency' 		=> '',
	'total_billing_cycles' 		=> ''
);