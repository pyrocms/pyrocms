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

	/**
	 * Exists
	 *
	 * Checks if a given folder exists.
	 *
	 * @access	public
	 * @param	int		The folder id
	 * @return	bool	If the folder exists
	 */
	public function exists($folder_id)
	{
		if(parent::count_by(array('id' => $folder_id)) > 0)
		{
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Has Children
	 *
	 * Checks if a given folder has children or not.
	 *
	 * @access	public
	 * @param	int		The folder id
	 * @return	bool	If the folder has children
	 */
	public function has_children($folder_id)
	{
		if(parent::count_by(array('parent_id' => $folder_id)) > 0)
		{
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Get Children
	 *
	 * Gets all the children in a given folder.
	 *
	 * @access		public
	 * @param		int		$parent_id	The folder id
	 * @param		string	$type		The type of folders to return
	 * @return		array
	 */
	public function get_children($parent_id)
	{
		$return = array();

		$folders = $this->order_by('name')->get_many_by(array('parent_id' => $parent_id));

		foreach($folders as & $folder)
		{
			$return[$folder->id] = $folder->name;
		}

		return $return;
	}
}

/* End of file media_m.php */