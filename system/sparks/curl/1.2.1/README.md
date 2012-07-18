# CodeIgniter-cURL

CodeIgniter-cURL is a CodeIgniter library which makes it easy to do simple cURL requests 
and makes more complicated cURL requests easier too.

## Requirements

1. PHP 5.1+
2. CodeIgniter 1.7.x - 2.0-dev
3. PHP 5 (configured with cURL enabled)
4. libcurl

## Features

* POST/GET/PUT/DELETE requests over HTTP
* HTTP Authentication
* Follows redirects
* Returns error string
* Provides debug information
* Proxy support
* Cookies

## Download

http://philsturgeon.co.uk/code/codeigniter-curl

## Examples

	$this->load->library('curl'); 

### Simple calls

These do it all in one line of code to make life easy. They return the body of the page, or FALSE on fail.

	// Simple call to remote URL
	echo $this->curl->simple_get('http://example.com/');

	// Simple call to CI URI
	$this->curl->simple_post('controller/method', array('foo'=>'bar'));

	// Set advanced options in simple calls
	// Can use any of these flags http://uk3.php.net/manual/en/function.curl-setopt.php

	$this->curl->simple_get('http://example.com', array(CURLOPT_PORT => 8080));
	$this->curl->simple_post('http://example.com', array('foo'=>'bar'), array(CURLOPT_BUFFERSIZE => 10)); 

### Advanced calls

These methods allow you to build a more complex request.

	// Start session (also wipes existing/previous sessions)
	$this->curl->create('http://example.com/');

	// Option & Options
	$this->curl->option(CURLOPT_BUFFERSIZE, 10);
	$this->curl->options(array(CURLOPT_BUFFERSIZE => 10));

	// More human looking options
	$this->curl->option('buffersize', 10);

	// Login to HTTP user authentication
	$this->curl->http_login('username', 'password');

	// Post - If you do not use post, it will just run a GET request
	$post = array('foo'=>'bar');
	$this->curl->post($post);

	// Cookies - If you do not use post, it will just run a GET request
	$vars = array('foo'=>'bar');
	$this->curl->set_cookies($vars);

	// Proxy - Request the page through a proxy server
	// Port is optional, defaults to 80
	$this->curl->proxy('http://example.com', 1080);
	$this->curl->proxy('http://example.com');

	// Proxy login
	$this->curl->proxy_login('username', 'password');

	// Execute - returns responce
	echo $this->curl->execute();

	// Debug data ------------------------------------------------

	// Errors
	$this->curl->error_code; // int
	$this->curl->error_string;

	// Information
	$this->curl->info; // array
	
