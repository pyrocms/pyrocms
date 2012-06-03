<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['recurring_bill_outstanding'] = array(
			'identifier'	=> '', //Required.  Should have been returned when you created the profile.
			'amt'			=>	'', //The outstanding amount to bil.  Cannot exceed total owed.
			'note'			=> '' //This is just a note.
		);