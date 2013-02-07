<?php
// Errors on full!
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
require 'goutte.phar';
define('PYRO_DB_HOST','127.0.0.1');
define('PYRO_HOST', isset($_SERVER['PYRO_TEST_HOST']) ? $_SERVER['PYRO_TEST_HOST'] : 'localhost');
