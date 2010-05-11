<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

/**
 * PyroCMS Media Folders Model
 *
 * Interacts with the media_folders table in the database.
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @package		PyroCMS
 * @subpackage	Media
 */
class Media_folders_m extends MY_Model {


	public function has_children($folder_id)
	{
		if(parent::count_by(array('parent_id' => $folder_id)) > 0)
		{
			return TRUE;
		}
		return FALSE;
	}

	public function get_children($parent_id, $type)
	{
		static $depth = 0;
		$return = array();

		$folders = $this->order_by('name')->get_many_by(array('parent_id' => $parent_id, 'type' => $type));

		foreach($folders as & $folder)
		{
			$return[$folder->id] = str_repeat('&nbsp;&nbsp;', $depth) . $folder->name;

			if($this->has_children($folder->id))
			{
				$depth++;
				$return = $return + $this->get_children($folder->id, $type);
				$depth--;
			}
		}

		return $return;
	}
}

/* End of file media_m.php */