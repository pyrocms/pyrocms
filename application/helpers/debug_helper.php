<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Code Igniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package		CodeIgniter
* @author		Rick Ellis
* @copyright	Copyright (c) 2006, pMachine, Inc.
* @license		http://www.codeignitor.com/user_guide/license.html
* @link			http://www.codeigniter.com
* @since        Version 1.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* Code Igniter Debug Helpers
*
* @package		CodeIgniter
* @subpackage	Helpers
* @category		Helpers
* @author       Philip Sturgeon < email@philsturgeon.co.uk >
*/

// ------------------------------------------------------------------------


/**
  * Debug Helper
  *
  * Outputs the given variable with formatting and location
  *
  * @access		public
  * @param		mixed    variable to be output
  */

function power_dump($testing, $file = '', $line = '')
{
	echo "<pre>".$file.' @ line: '.$line .'<br />Result: ';
	var_dump($testing);
	echo "</pre>";
}

?>