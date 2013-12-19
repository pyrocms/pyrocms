<?php
/**
 * Encoding tests for SimplePie_Misc::change_encoding() and SimplePie_Misc::encoding()
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

class EncodingTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Test if we have mbstring
	 *
	 * Used for depends
	 */
	public function test_has_mbstring()
	{
		$this->assertTrue(function_exists('mb_convert_encoding'));
	}

	/**
	 * Test if we have iconv (crazy if we don't)
	 *
	 * Used for depends
	 */
	public function test_has_iconv()
	{
		$this->assertTrue(function_exists('iconv'));
	}

	/**#@+
	 * UTF-8 methods
	 */
	/**
	 * Provider for the convert toUTF8* tests
	 */
	public static function toUTF8()
	{
		return array(
			array('A', 'A', 'ASCII'),
			array("\xa1\xdb", "\xe2\x88\x9e", 'Big5'),
			array("\xa1\xe7", "\xe2\x88\x9e", 'EUC-JP'),
			array("\xa1\xde", "\xe2\x88\x9e", 'GBK'),
			array("\x81\x87", "\xe2\x88\x9e", 'Shift_JIS'),
			array("\x2b\x49\x68\x34\x2d", "\xe2\x88\x9e", 'UTF-7'),
			array("\xfe\xff\x22\x1e", "\xe2\x88\x9e", 'UTF-16'),
			array("\xff\xfe\x1e\x22", "\xe2\x88\x9e", 'UTF-16'),
			array("\x22\x1e", "\xe2\x88\x9e", 'UTF-16BE'),
			array("\x1e\x22", "\xe2\x88\x9e", 'UTF-16LE'),
		);
	}

	/**
	 * Special cases with mbstring handling
	 */
	public static function toUTF8_mbstring()
	{
		return array(
			array("\xa1\xc4", "\xe2\x88\x9e", 'EUC-KR'),
		);
	}

	/**
	 * Special cases with iconv handling
	 */
	public static function toUTF8_iconv()
	{
		return array(
			array("\xfe\xff\x22\x1e", "\xe2\x88\x9e", 'UTF-16'),
		);
	}

	/**
	 * Convert * to UTF-8
	 *
	 * @dataProvider toUTF8
	 */
	public function test_convert_UTF8($input, $expected, $encoding)
	{
		$encoding = SimplePie_Misc::encoding($encoding);
		$this->assertEquals($expected, SimplePie_Misc::change_encoding($input, $encoding, 'UTF-8'));
	}

	/**
	 * Convert * to UTF-8 using mbstring
	 *
	 * Special cases only
	 * @depends test_has_mbstring
	 * @dataProvider toUTF8_mbstring
	 */
	public function test_convert_UTF8_mbstring($input, $expected, $encoding)
	{
		$encoding = SimplePie_Misc::encoding($encoding);
		if (version_compare(phpversion(), '5.3', '<'))
		{
			$this->assertEquals($expected, Mock_Misc::__callStatic('change_encoding_mbstring', array($input, $encoding, 'UTF-8')));
		}
		else
		{
			$this->assertEquals($expected, Mock_Misc::change_encoding_mbstring($input, $encoding, 'UTF-8'));
		}
	}

	/**
	 * Convert * to UTF-8 using iconv
	 *
	 * Special cases only
	 * @depends test_has_iconv
	 * @dataProvider toUTF8_iconv
	 */
	public function test_convert_UTF8_iconv($input, $expected, $encoding)
	{
		$encoding = SimplePie_Misc::encoding($encoding);
		if (version_compare(phpversion(), '5.3', '<'))
		{
			$this->assertEquals($expected, Mock_Misc::__callStatic('change_encoding_iconv', array($input, $encoding, 'UTF-8')));
		}
		else {
			$this->assertEquals($expected, Mock_Misc::change_encoding_iconv($input, $encoding, 'UTF-8'));
		}
	}
	/**#@-*/

	/**#@+
	 * UTF-16 methods
	 */
	public static function toUTF16()
	{
		return array(
			array("\x22\x1e", "\x22\x1e", 'UTF-16BE'),
			array("\x1e\x22", "\x22\x1e", 'UTF-16LE'),
		);
	}

	/**
	 * Convert * to UTF-16
	 * @dataProvider toUTF16
	 */
	public function test_convert_UTF16($input, $expected, $encoding)
	{
		$encoding = SimplePie_Misc::encoding($encoding);
		$this->assertEquals($expected, SimplePie_Misc::change_encoding($input, $encoding, 'UTF-16'));
	}
	/**#@-*/

	public function test_nonexistant()
	{
		$this->assertFalse(SimplePie_Misc::change_encoding('', 'TESTENC', 'UTF-8'));
	}

	public static function assertEquals($expected, $actual, $message = '', $delta = 0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false)
	{
		if (is_string($expected))
		{
			$expected = bin2hex($expected);
		}
		if (is_string($actual))
		{
			$actual = bin2hex($actual);
		}
		parent::assertEquals($expected, $actual, $message, $delta, $maxDepth, $canonicalize, $ignoreCase);
	}
}

class Mock_Misc extends SimplePie_Misc
{
	public static function __callStatic($name, $args)
	{
		return call_user_func_array(array('SimplePie_Misc', $name), $args);
	}
}