<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// in case someone uses the CodeIgniter cache we set the site specific path for them
$config['cache_path'] = APPPATH . 'cache/' . SITE_REF . '/codeigniter/';

$config['rss_cache'] = 3600; // 1 hour TTL on blog rss caching

// Set the location for simplepie cache
$config['simplepie_cache_dir'] = APPPATH . 'cache/' . SITE_REF . '/simplepie/';

// Make sure all the folders exist
is_dir($config['cache_path']) OR mkdir($config['cache_path'], DIR_WRITE_MODE, TRUE);
is_dir($config['simplepie_cache_dir']) OR mkdir($config['simplepie_cache_dir'], DIR_WRITE_MODE, TRUE);

/**
 * You can use multiple instances of Quick Cache in your app. For example:
 *
 * $other_cache = new Quick\Cache(array('driver' => 'redis', 'other_config' => 'some value'));
 * $config = $other_cache->config_instance();
 * $config->set('some_other_item', 'my value');
 *
 * In this way you can cache some items in Redis, some in the filesystem, and some
 * using a driver for your other favorite store
 */

// you can use either "file" or "redis" drivers currently. If you want to
// contribute a driver come to http://github.com/jerel/quick-cache
ci()->cache = new Quick\Cache(array('driver' => 'file'));

$qc_config = ci()->cache->config_instance();

/* Global Config */
$qc_config->set('expiration', 86400 /* default Time To Live in seconds */);

/* Filesystem Driver Config */
$qc_config->set('cache_path', APPPATH.'cache/'.SITE_REF.'/'); /* make sure all paths have a trailing slash */
$qc_config->set('object_dir', 'object_cache/');
$qc_config->set('dir_chmod', 0777);

/* Redis Driver Config
$qc_config->set('redis_prefix', 'cache.'.SITE_REF);
$qc_config->set('redis_connection', array(
		'host'     => '127.0.0.1',
		'port'     => 6379,
		// 'database' => 15
		)
);
// this is also valid syntax for the redis connection
// $qc_config->set('redis_connection', 'tcp://127.0.0.1:6379');

// refresh the connection with the new connection parameters
ci()->cache->connect();

*/
