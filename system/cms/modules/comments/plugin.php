<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Example Plugin
 *
 * Quick plugin to demonstrate how things work
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2009 - 2010, PyroCMS
 *
 */
class Plugin_Comments extends Plugin
{
	/**
	 * Count
	 *
	 * Usage:
	 * {{ comments:count item_id="{{ page:id }} [module="pages"] [type="number"] }}
	 *
	 * @param	array
	 * @return	array
	 */
	function count()
	{
		$item_id = $this->attribute('item_id', 0);
		$module = $this->attribute('module', $this->module);
		$type = $this->attribute('type', FALSE);
		
		$this->load->helper('comments/comments');
		
		return count_comments($item_id, $module, $type);
	}
}

/* End of file example.php */