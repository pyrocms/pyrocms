<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['social'] = array(
	
	'link_multiple_providers' => true,
	
	'providers' => array(
	
		'facebook' => array(
			'id' => '192553490816292',
			'secret' => '05d5df5de45b6ddd94e4bcff7d51b8f4',
			'scope' => array('email', 'offline_access', 'user_website'),
		),
	
		'twitter' => array(
			'key' => 'hAPEbF0szAnD2yWNXyJ1Q',
			'secret' => '9j55x4QLBEFy8o8Np9F7Uw2ALkOv7ypFuVPYhI0mU',
		),
		
	),
);