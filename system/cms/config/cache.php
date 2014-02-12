<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$cache = array(

	/*
	|--------------------------------------------------------------------------
	| Enable cache
	|--------------------------------------------------------------------------
	|
	| This option can be used to disable cache everywhere else. 
	| It overrides every other option.
	|
	*/
	'enable' => false,

	/*
	|--------------------------------------------------------------------------
	| Enable cache per environment
	|--------------------------------------------------------------------------
	|
	| This option allows to enable or disable per environment.
	|
	*/
	'environment' => array(
		// PYRO_DEVELOPMENT => true,
		// PYRO_STAGING => false,
		// PYRO_PRODUCTION => true
	),
	
	/*
	|--------------------------------------------------------------------------
	| Default Cache Driver
	|--------------------------------------------------------------------------
	|
	| This option controls the default cache "driver" that will be used when
	| using the Caching library. Of course, you may use other drivers any
	| time you wish. This is the default when another is not specified.
	|
	| Supported: "file", "database", "apc", "memcached", "redis", "array"
	|
	*/

    'driver' => 'file',

    /*
	|--------------------------------------------------------------------------
	| File Cache Location
	|--------------------------------------------------------------------------
	|
	| When using the "file" cache driver, we need a location where the cache
	| files may be stored. A sensible default has been specified, but you
	| are free to change it to any other place on disk that you desire.
	|
	*/

	'path' => APPPATH.'cache'.DIRECTORY_SEPARATOR.SITE_REF.DIRECTORY_SEPARATOR.'laravel',

	/*
	|--------------------------------------------------------------------------
	| Database Cache Connection
	|--------------------------------------------------------------------------
	|
	| When using the "database" cache driver you may specify the connection
	| that should be used to store the cached items. When this option is
	| null the default database connection will be utilized for cache.
	|
	*/

	'connection' => null,

	/*
	|--------------------------------------------------------------------------
	| Database Cache Table
	|--------------------------------------------------------------------------
	|
	| When using the "database" cache driver we need to know the table that
	| should be used to store the cached items. A default table name has
	| been provided but you're free to change it however you deem fit.
	|
	*/

	'table' => 'cache',

	/*
	|--------------------------------------------------------------------------
	| Memcached Servers
	|--------------------------------------------------------------------------
	|
	| Now you may specify an array of your Memcached servers that should be
	| used when utilizing the Memcached cache driver. All of the servers
	| should contain a value for "host", "port", and "weight" options.
	|
	*/

	'memcached' => array(

		array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 100),

	),

	/*
	|--------------------------------------------------------------------------
	| Cache Key Prefix
	|--------------------------------------------------------------------------
	|
	| When utilizing a RAM based store such as APC or Memcached, there might
	| be other applications utilizing the same cache. So, we'll specify a
	| value to get prefixed to all our keys so we can avoid collisions.
	|
	*/

	'prefix' => 'pyrocms',

	/*
	|--------------------------------------------------------------------------
	| Redis Databases
	|--------------------------------------------------------------------------
	|
	| Redis is an open source, fast, and advanced key-value store that also
	| provides a richer set of commands than a typical key-value systems
	| such as APC or Memcached. Laravel makes it easy to dig right in.
	|
	*/

	'redis' => array(

		'cluster' => false,

		'default' => array(
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0,
		),

	),

	// Set the RSS cache time
	'rss_cache' => 3600, // 1 hour TTL on blog rss caching

	// Set the location for simplepie cache
	'simplepie_cache_dir' => APPPATH.'cache'.DIRECTORY_SEPARATOR.SITE_REF.DIRECTORY_SEPARATOR.'simplepie'

);

// Make sure all the folders exist
is_dir($cache['path']) OR mkdir($cache['path'], DIR_WRITE_MODE, TRUE);
is_dir($cache['simplepie_cache_dir']) OR mkdir($cache['simplepie_cache_dir'], DIR_WRITE_MODE, TRUE);
