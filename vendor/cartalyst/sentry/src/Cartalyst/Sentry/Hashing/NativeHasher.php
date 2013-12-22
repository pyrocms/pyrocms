<?php namespace Cartalyst\Sentry\Hashing;
/**
 * Part of the Sentry package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

class NativeHasher implements HasherInterface {

	/**
	 * Array of alternative hashing functions
	 */
	private static $fallbacks = array();

	/**
	 * Add Fallback
	 *
	 * Add an alternative hashing function for verifying passwords.
	 *
	 * @param  string $algo
	 * @param  function $function
	 * @param  array $options
	 */
	public static function addFallback($algo, $function, $options = array())
	{
		static::$fallbacks[$algo] = array(
			'function' => $function,
			'options' => $options
		);
	}

	/**
	 * Hash string.
	 *
	 * @param  string $string
	 * @return string
	 * @throws \RuntimeException
	 */
	public function hash($string)
	{
		// Usually caused by an old PHP environment, see
		// https://github.com/cartalyst/sentry/issues/98#issuecomment-12974603
		// and https://github.com/ircmaxell/password_compat/issues/10
		if ( ! function_exists('password_hash'))
		{
			throw new \RuntimeException('The function password_hash() does not exist, your PHP environment is probably incompatible. Try running [vendor/ircmaxell/password-compat/version-test.php] to check compatibility or use an alternative hashing strategy.');
		}

		if (($hash = password_hash($string, PASSWORD_DEFAULT)) === false)
		{
			throw new \RuntimeException('Error generating hash from string, your PHP environment is probably incompatible. Try running [vendor/ircmaxell/password-compat/version-test.php] to check compatibility or use an alternative hashing strategy.');
		}

		return $hash;
	}

	/**
	 * Check string against hashed string.
	 *
	 * @param  string  $string
	 * @param  string  $hashedString
	 * @return bool
	 */
	public function checkhash($string, $hashedString)
	{
		$verified = password_verify($string, $hashedString);
		if ( ! $verified) 
		{
			// Try the fallbacks
			foreach (static::$fallbacks as $algo => $fallback)
			{
				$verified = $fallback['function']($string, $hashedString, $fallback['options']);
				if ($verified) break;
			}
		}
		return $verified;
	}

	/**
	 * Check if the algorithm of the input should be upgraded.
	 *
	 * @param  string $hashedString
	 * @return bool
	 */
	public function needsRehashed($hashedString)
	{
		return password_needs_rehash($hashedString, PASSWORD_DEFAULT);
	}
}
