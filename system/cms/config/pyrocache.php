<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// we set this here so Pro can set the correct SITE_REF
$config['cache_path'] = APPPATH . 'cache/' . SITE_REF . '/codeigniter/';

$config['cache_dir'] = APPPATH.'cache/' . SITE_REF . '/';

$config['cache_default_expires'] = 0;

// Will soon make these options into settings items
$config['navigation_cache'] = 21600; // 6 hours
$config['rss_cache'] = 3600; // 1 hour

// Set the location for simplepie cache
$config['simplepie_cache_dir'] = APPPATH . 'cache/' . SITE_REF . '/simplepie/';

// Make sure all the folders exist
is_dir($config['cache_path']) OR mkdir($config['cache_path'], DIR_WRITE_MODE, TRUE);
is_dir($config['cache_dir']) OR mkdir($config['cache_dir'], DIR_WRITE_MODE, TRUE);
is_dir($config['simplepie_cache_dir']) OR mkdir($config['simplepie_cache_dir'], DIR_WRITE_MODE, TRUE);