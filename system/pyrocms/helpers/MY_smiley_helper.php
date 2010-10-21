<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2010, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Smiley Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/smiley_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Smiley Javascript
 *
 * Returns the javascript required for the smiley insertion.  Optionally takes
 * an array of aliases to loosely couple the smiley array to the view.
 *
 * @access	public
 * @param	mixed	alias name or array of alias->field_id pairs
 * @param	string	field_id if alias name was passed in
 * @return	array
 */
if ( ! function_exists('smiley_js'))
{
	function smiley_js($alias = '', $field_id = '', $inline = TRUE)
	{
		static $do_setup = TRUE;

		$r = '';
	
		if ($alias != '' && ! is_array($alias))
		{
			$alias = array($alias => $field_id);
		}

		if ($do_setup === TRUE)
		{
				$do_setup = FALSE;
			
				$m = array();
			
				if (is_array($alias))
				{
					foreach($alias as $name => $id)
					{
						$m[] = '"'.$name.'" : "'.$id.'"';
					}
				}
			
				$m = '\{'.implode(',', $m).'}';
			
				$r .= <<<EOF
				var smiley_map = {$m};

				function insert_smiley(smiley, field_id) {
					var el = document.getElementById(field_id), newStart;
				
					if ( ! el && smiley_map[field_id]) {
						el = document.getElementById(smiley_map[field_id]);
					
						if ( ! el)
							return false;
					}
				
					el.focus();
					smiley = " " + smiley;

					if ('selectionStart' in el) {
						newStart = el.selectionStart + smiley.length;

						el.value = el.value.substr(0, el.selectionStart) +
										smiley +
										el.value.substr(el.selectionEnd, el.value.length);
						el.setSelectionRange(newStart, newStart);
					}
					else if (document.selection) {
						document.selection.createRange().text = smiley;
					}
				}
EOF;
		}
		else
		{
			if (is_array($alias))
			{
				foreach($alias as $name => $id)
				{
					$r .= 'smiley_map["'.$name.'"] = "'.$id.'";'."\n";
				}
			}
		}

		if ($inline)
		{
			return '<script type="text/javascript" charset="utf-8">/*<![CDATA[ */'.$r.'// ]]></script>';			
		}
		else
		{
			return $r;
		}
	}
}

/* End of file smiley_helper.php */
/* Location: ./system/helpers/smiley_helper.php */