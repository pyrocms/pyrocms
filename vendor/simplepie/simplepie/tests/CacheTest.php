<?php
/**
 * SimplePie
 *
 * A PHP-Based RSS and Atom Feed Framework.
 * Takes the hard work out of managing a complete RSS/Atom solution.
 *
 * Copyright (c) 2004-2012, Ryan Parman, Geoffrey Sneddon, Ryan McCue, and contributors
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 *
 * 	* Redistributions of source code must retain the above copyright notice, this list of
 * 	  conditions and the following disclaimer.
 *
 * 	* Redistributions in binary form must reproduce the above copyright notice, this list
 * 	  of conditions and the following disclaimer in the documentation and/or other materials
 * 	  provided with the distribution.
 *
 * 	* Neither the name of the SimplePie Team nor the names of its contributors may be used
 * 	  to endorse or promote products derived from this software without specific prior
 * 	  written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS
 * OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS
 * AND CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
 * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package SimplePie
 * @version 1.4-dev
 * @copyright 2004-2011 Ryan Parman, Geoffrey Sneddon, Ryan McCue
 * @author Ryan Parman
 * @author Geoffrey Sneddon
 * @author Ryan McCue
 * @link http://simplepie.org/ SimplePie
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

/**
 * This is a dirty, dirty hack
 */
class Exception_Success extends Exception {

}

class Mock_CacheLegacy extends SimplePie_Cache
{
	public static function get_handler($location, $filename, $extension)
	{
		trigger_error('Legacy cache class should not have get_handler() called');
	}
	public function create($location, $filename, $extension)
	{
		throw new Exception_Success('Correct function called');
	}
}

class Mock_CacheNew extends SimplePie_Cache
{
	public static function get_handler($location, $filename, $extension)
	{
		throw new Exception_Success('Correct function called');
	}
	public function create($location, $filename, $extension)
	{
		trigger_error('New cache class should not have create() called');
	}
}

class CacheTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException Exception_Success
	 */
	public function testDirectOverrideLegacy()
	{
		$feed = new SimplePie();
		$feed->set_cache_class('Mock_CacheLegacy');
		$feed->get_registry()->register('File', 'Mock_File');
		$feed->set_feed_url('http://example.com/feed/');

		$feed->init();
	}

	/**
	 * @expectedException Exception_Success
	 */
	public function testDirectOverrideNew()
	{
		$feed = new SimplePie();
		$feed->get_registry()->register('Cache', 'Mock_CacheNew');
		$feed->get_registry()->register('File', 'Mock_File');
		$feed->set_feed_url('http://example.com/feed/');

		$feed->init();
	}
}