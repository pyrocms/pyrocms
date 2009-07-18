<?php
// Require the core class
require_once('includes/core_class.php');
$core 	= new Core();

// Clean the cache
$core->clean_cache("../application/cache");

// Recreate the cache directory
$core->create_cache_dir("../application/cache");

// Redirect the user
header("Location: index.php");
?>
