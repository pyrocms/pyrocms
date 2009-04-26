<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['mp_cache_dir'] = APPPATH.'cache/';

$config['mp_cache_default_expiry'] = 0;

// Will soon make these options into settings items
$config['navigation_cache'] = 21600; // 6 hours
$config['rss_cache'] = 3600; // 1 hour

?>