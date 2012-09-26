<?php
/*
 * This file belongs to the Quick Cache package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * copyright 2012 -- Jerel Unruh -- http://unruhdesigns.com
 */

// travis-ci will have the vendor dir inside this packages folder
if (is_file(__DIR__.'/../../../../vendor/autoload.php')) {
	require_once __DIR__.'/../../../../vendor/autoload.php';
} else {
	require_once __DIR__.'/../vendor/autoload.php';
}

class QuickCacheException extends \Exception {};

if ( ! is_writable(__DIR__)) {
    exit(__DIR__.' must be writable so that we have a place to write and read cache files to for testing. Please change the permissions.');
}
