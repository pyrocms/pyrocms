<?php defined('BASEPATH') OR exit('No direct script access allowed');

// set up the page types
$config['pages:default_page_types'] = array(
	array(
			'id' => 1,
			'title' => 'Default',
			'stream_id' => 1,
			'stream_slug' => 'generic',
			'body' => '<h2>{{ page:title }}</h2>'.PHP_EOL.'{{ page:body }}',
			'css' => '',
			'js' => '',
			'updated_on' => now(),
	),
	array(
			'id' => 2,
			'title' => 'System',
			'stream_id' => 2,
			'stream_slug' => 'system',
			'body' => '<h2>{{ page:title }}</h2>'.PHP_EOL.'{{ page:message_body }}',
			'css' => '',
			'js' => '',
			'updated_on' => now(),
	)
);


$config['pages:page_streams'] = array(
	array(
		'name' 		=> 'Generic', 
		'slug' 		=> 'generic', 
		'namespace' => 'pages', 
		'prefix' 	=> null, 
		'about' 	=> 'A basic page type to get you started adding content.'
	),
	array(
		'name' 		=> 'System', 
		'slug' 		=> 'system', 
		'namespace' => 'pages', 
		'prefix' 	=> null, 
		'about' 	=> 'A page type for system pages such as 404.'
	)
);


// define all custom fields that a new installation should have
$config['pages:default_fields']	= array(
	array(         
		'name'          => 'Body',
		'slug'          => 'body',
		'namespace'     => 'pages',
		'type'          => 'textarea',
		'extra'			=> array('editor_type' => 'advanced'),
		'assign'        => 'generic',
	),
	array(         
		'name'          => 'Message Body',
		'slug'          => 'message_body',
		'namespace'     => 'pages',
		'type'          => 'textarea',
		'extra'			=> array('editor_type' => 'advanced'),
		'assign'        => 'system',
	),
);


// insert default pages
$config['pages:default_pages'] = array(
	/* The home page. */
	array(
		'slug' => 'home',
		'title' => 'Home',
		'uri' => 'home',
		'stream_entry_id' => 1,
		'parent_id' => 0,
		'layout_id' => 1,
		'status' => 'live',
		'restricted_to' => '',
		'created_on' => now(),
		'is_home' => 1,
		'order' => now()
	),
	/* The contact page. */
	array(
		'slug' => 'contact',
		'title' => 'Contact',
		'uri' => 'contact',
		'stream_entry_id' => 2,
		'parent_id' => 0,
		'layout_id' => 1,
		'status' => 'live',
		'restricted_to' => '',
		'created_on' => now(),
		'is_home' => 0,
		'order' => now()
	),
	/* The 404 page. */
	array(
		'slug' => '404',
		'title' => 'Page missing',
		'uri' => '404',
		'stream_entry_id' => 1,/* It's the only entry in the system page type so it'll be the first */
		'parent_id' => 0,
		'layout_id' => 2,/* Notice that this page is assigned to the System page type */
		'status' => 'live',
		'restricted_to' => '',
		'created_on' => now(),
		'is_home' => 0,
		'order' => now()
	),
);

// and now the content for the pages
$config['pages:default_page_content'] = array(
	/* The home page data. */
	'generic' => array(
		array(
			'created' => date('Y-m-d H:i:s'),
			'body' => '<p>Welcome to our homepage. We have not quite finished setting up our website yet, but please add us to your bookmarks and come back soon.</p>',
			'created_by' => 1
		),
		/* The contact page data. */
		array(
			'created' => date('Y-m-d H:i:s'),
			'body' => '<p>To contact us please fill out the form below.</p>
				{{ contact:form name="text|required" email="text|required|valid_email" subject="dropdown|Support|Sales|Feedback|Other" message="textarea" attachment="file|zip" }}
					<div><label for="name">Name:</label>{{ name }}</div>
					<div><label for="email">Email:</label>{{ email }}</div>
					<div><label for="subject">Subject:</label>{{ subject }}</div>
					<div><label for="message">Message:</label>{{ message }}</div>
					<div><label for="attachment">Attach  a zip file:</label>{{ attachment }}</div>
				{{ /contact:form }}',
			'created_by' => 1
		),
	),
	/* The 404 page data. Assigned to the System page type */
	'system' => array(
		array(
			'created' => date('Y-m-d H:i:s'),
			'message_body' => '<p>We cannot find the page you are looking for, please click <a title="Home" href="{{ pages:url id=\'1\' }}">here</a> to go to the homepage.</p>',
			'created_by' => 1
		)
	),
);