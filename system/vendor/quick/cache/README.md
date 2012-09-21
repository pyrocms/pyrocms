# Quick Cache

A quick and easy to use PSR-2 driver based caching library that will cache simple key/value pairs or call methods and cache their results.

### Includes Drivers For

* Redis (using the fantastic predis library)
* Filesystem

### Author

* [Jerel Unruh](http://unruhdesigns.com/)

### License

MIT License

## Usage

First install it via composer by placing this in a composer.json file

	{
		"require": {
		    "quick/cache": "v1.0.0"
		}
	}

and running `composer.phar install`

Now you can use it in your code by calling the class:

	$cache = new Quick\Cache;

	$cache->set('name', 'Jerel Unruh', $ttl = 3600); /* will expire in 3600 seconds */

	$name = $cache->get('name');

	$cache->forget('name');

Let it call your methods for you and handle the results:

	// you can pass any config items in an array
	$cache = new Quick\Cache(array('driver' => 'redis'));

	// pass any arguments as an array
	$cache->method($this->UserModel, 'getUsersByGroup', array('admin', 'desc'), 3600);

	$cache->method('Project\Model\UserModel', 'getUsersByGroup');

	// clear all the data cached for this class
	$cache->clear('Project\Model\UserModel');

	// or just this class + method
	$cache->clear('Project\Model\UserModel', 'getUsersByGroup');

Flush all cached items for this driver. Don't use this in production as it's expensive. Use it when taking an app from staging to live or etc.

	$cache = new Quick\Cache;

	$cache->flush();

## Configuration

All configuration details can be set in the config files in vendor/quick/cache/config. There is also a config class that allows you to set details programmatically. The only thing that cannot be changed with the config class is the driver. It must be set in the global config file or when instantiating the class;

	$cache = new Quick\Cache(array('driver' => 'file'));

	$config = $cache->config_instance();

	$config->set('cache_path', 'project/cache/');

At the same time we can run another instance with different configurations

	$redis_cache = new Quick\Cache(array('driver' => 'redis'));

	$redis_config = $redis_cache->config_instance();

	$redis_config->set_many(array(
		'redis_connection' => array(
			'host'     => '127.0.0.1',
			'port'     => 6379,
			),
		'redis_prefix' => 'cache',
	));

	// if you set the connection details manually you must refresh the connection
	$redis_cache->connect();

Other methods

	$cache_path = $config->get('cache_path');

	$config_items = $config->get_all();

	$config->load('custom_driver');

## Testing

Quick Cache is unit tested using phpUnit. I use Guard to run my tests while I work, if you have it installed you can test like this:

	cd ./vendor/quick/cache
	guard

If not you can run them via phpUnit

	cd ./vendor/quick/cache
	phpunit --colors --bootstrap tests/bootstrap.php --strict --debug --verbose tests

Do not run these tests on a production environment! It will *FLUSH* your database!

## Errors

If Quick Cache encounters a serious error that it needs to tell you about (such as unwriteable directories) it will throw a `QuickCacheException`