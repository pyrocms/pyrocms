<?php
/**
 * Tests for SimplePie_Item
 *
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
 * @version 1.3.1
 * @copyright 2004-2011 Ryan Parman, Geoffrey Sneddon, Ryan McCue
 * @author Ryan Parman
 * @author Geoffrey Sneddon
 * @author Ryan McCue
 * @link http://simplepie.org/ SimplePie
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

require_once dirname(__FILE__) . '/bootstrap.php';

class ItemTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Run a test using a sprintf template and data
	 *
	 * @param string $template 
	 */
	protected function checkFromTemplate($template, $data, $expected)
	{
		if (!is_array($data))
		{
			$data = array($data);
		}
		$xml = vsprintf($template, $data);
		$feed = new SimplePie();
		$feed->set_raw_data($xml);
		$feed->enable_cache(false);
		$feed->init();

		return $feed;
	}

	public static function titleprovider()
	{
		return array(
			array('Feed Title', 'Feed Title'),

			// RSS Profile tests
			array('AT&amp;T', 'AT&amp;T'),
			array('AT&#x26;T', 'AT&amp;T'),
			array("Bill &amp; Ted's Excellent Adventure", "Bill &amp; Ted's Excellent Adventure"),
			array("Bill &#x26; Ted's Excellent Adventure", "Bill &amp; Ted's Excellent Adventure"),
			array('The &amp; entity', 'The &amp; entity'),
			array('The &#x26; entity', 'The &amp; entity'),
			array('The &amp;amp; entity', 'The &amp;amp; entity'),
			array('The &#x26;amp; entity', 'The &amp;amp; entity'),
			array('I &lt;3 Phil Ringnalda', 'I &lt;3 Phil Ringnalda'),
			array('I &#x3C;3 Phil Ringnalda', 'I &lt;3 Phil Ringnalda'),
			array('A &lt; B', 'A &lt; B'),
			array('A &#x3C; B', 'A &lt; B'),
			array('A&lt;B', 'A&lt;B'),
			array('A&#x3C;B', 'A&lt;B'),
			array("Nice &lt;gorilla&gt; what's he weigh?", "Nice &lt;gorilla&gt; what's he weigh?"),
			array("Nice &#x3C;gorilla&gt; what's he weigh?", "Nice &lt;gorilla&gt; what's he weigh?"),
		);
	}

	/**
	 * @dataProvider titleprovider
	 */
	public function testTitleRSS20($title, $expected)
	{
		$data =
'<rss version="2.0">
	<channel>
		<title>%s</title>
	</channel>
</rss>';
		$feed = $this->checkFromTemplate($data, $title, $expected);
		$this->assertEquals($expected, $feed->get_title());
	}

	/**
	 * @dataProvider titleprovider
	 */
	public function testTitleRSS20WithDC10($title, $expected)
	{
		$data =
'<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.0/">
	<channel>
		<dc:title>%s</dc:title>
	</channel>
</rss>';
		$feed = $this->checkFromTemplate($data, $title, $expected);
		$this->assertEquals($expected, $feed->get_title());
	}

	/**
	 * @dataProvider titleprovider
	 */
	public function testTitleRSS20WithDC11($title, $expected)
	{
		$data =
'<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<dc:title>%s</dc:title>
	</channel>
</rss>';
		$feed = $this->checkFromTemplate($data, $title, $expected);
		$this->assertEquals($expected, $feed->get_title());
	}

	/**
	 * @dataProvider titleprovider
	 */
	public function testTitleRSS20WithAtom03($title, $expected)
	{
		$data =
'<rss version="2.0" xmlns:a="http://purl.org/atom/ns#">
	<channel>
		<a:title>%s</a:title>
	</channel>
</rss>';
		$feed = $this->checkFromTemplate($data, $title, $expected);
		$this->assertEquals($expected, $feed->get_title());
	}

	/**
	 * @dataProvider titleprovider
	 */
	public function testTitleRSS20WithAtom10($title, $expected)
	{
		$data =
'<rss version="2.0" xmlns:a="http://www.w3.org/2005/Atom">
	<channel>
		<a:title>%s</a:title>
	</channel>
</rss>';
		$feed = $this->checkFromTemplate($data, $title, $expected);
		$this->assertEquals($expected, $feed->get_title());
	}

	/**
	 * Based on a test from old bug 18
	 *
	 * @dataProvider titleprovider
	 */
	public function testTitleRSS20WithImageTitle($title, $expected)
	{
		$data =
'<rss version="2.0">
	<channel>
		<title>%s</title>
		<image>
			<title>Image title</title>
		</image>
	</channel>
</rss>';
		$feed = $this->checkFromTemplate($data, $title, $expected);
		$this->assertEquals($expected, $feed->get_title());
	}

	/**
	 * Based on a test from old bug 18
	 *
	 * @dataProvider titleprovider
	 */
	public function testTitleRSS20WithImageTitleReversed($title, $expected)
	{
		$data =
'<rss version="2.0">
	<channel>
		<image>
			<title>Image title</title>
		</image>
		<title>%s</title>
	</channel>
</rss>';
		$feed = $this->checkFromTemplate($data, $title, $expected);
		$this->assertEquals($expected, $feed->get_title());
	}
}
