<?php

/**
 * The Lex Autoloader (this is case-sensative)
 */
class Lex_Autoloader
{

	protected static $load_path = './';

	/**
	 * Registers the Autoloader
	 *
	 * @return  void
	 */
	public static function register()
	{
		self::$load_path = dirname(dirname(__FILE__)).'/';
		ini_set('unserialize_callback_func', 'spl_autoload_call');
		spl_autoload_register('Lex_Autoloader::load');
	}

	/**
	 * Autoloads the Lex classes, if it is not a Lex class it simply
	 * returns.
	 *
	 * @param   string   $class  class name
	 * @return  bool
	 */
	static public function load($class)
	{
		if (strpos($class, 'Lex') !== 0)
		{
			return false;
		}

		$file = self::$load_path.str_replace(array('_', "\0"), array('/', ''), $class).'.php';
		$file = str_replace('/', DIRECTORY_SEPARATOR, $file);
		if (is_file($file))
		{
			require $file;

			return true;
		}

		return false;
	}
}
