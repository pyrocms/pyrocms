<?php defined('BASEPATH') OR exit('No direct script access allowed');
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

function dump()
{
	list($callee) = debug_backtrace();
	$arguments = $callee['args'];
	$total_arguments = count($arguments);

	echo '<fieldset style="background: #fefefe !important; border:2px red solid; padding:5px">';
	echo '<legend style="background:lightgrey; padding:5px;">'.$callee['file'].' @ line: '.$callee['line'].'</legend><pre>';

	$i = 0;
	foreach ($arguments as $argument)
	{
		echo '<br/><strong>Debug #'.(++$i).' of '.$total_arguments.'</strong>: ';
		var_dump($argument);
	}

	echo "</pre>";
	echo "</fieldset>";
}