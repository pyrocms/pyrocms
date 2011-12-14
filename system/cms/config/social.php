<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['social'] = array(
	
	'link_multiple_providers' => true,
	
	'providers' => array(
	
		'facebook' => array(
			// 'id' => '192553490816292',
			// 'secret' => '05d5df5de45b6ddd94e4bcff7d51b8f4',
			'scope' => array('email', 'offline_access', 'user_website'),
		),
		
		'google' => array(
			// 'id' => '87891653784.apps.googleusercontent.com',
			// 'secret' => '4CzyS_BOj8t0itNvdPPhmAX9',
			// 'scope' => 'https://www.googleapis.com/auth/userinfo.profile',
		),
	
		'twitter' => array(
			'key' => 'cmqDr6qsJQFNsbcSztwN5g',
			'secret' => '1wscDDBRthdFkSn19HXqBpsNWzMsU1XxPqYWjV8Ppw',
		),
		
	),
);