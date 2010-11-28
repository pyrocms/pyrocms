<?php  defined('BASEPATH') OR exit('No direct script access allowed');
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
 * PyroCMS File Folders Model
 *
 * Interacts with the file_folders table in the database.
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @author		Eric Barnes <eric@pyrocms.com>
 * @package		PyroCMS
 * @subpackage	Files
 */
class File_folders_m extends MY_Model {

	private $_folders = array();
	
	private $_all_folders = array();
	
	private $_sub_folders = array();
	
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
		return (bool) (parent::count_by(array('id' => $folder_id)) > 0);
	}
	
	// ------------------------------------------------------------------------
	
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
		return (bool) (parent::count_by(array('parent_id' => $folder_id)) > 0);
	}
	
	// ------------------------------------------------------------------------
	
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
	public function get_children($id, $lev = 0)
	{
		$return = array();

		$this->db
			->where('id', (int) $id)
			->order_by('name');
		
		$query = $this->db->get('file_folders');

		if ($query->num_rows() == 0) 
		{
			return array();
		}
		
		$folder = $query->row_array();
		
		$path = array();
		
		$path[$lev]['name'] = $folder['name'];
		$path[$lev]['slug'] = $folder['slug'];
		
		if ($folder['parent_id'] != 0) 
		{
			$path = array_merge($this->get_children($cat['parent_id'],$lev+1), $path);
		}
		
		return $path;
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Folder Tree
	 *
	 * Get folder in an array
	 *
	 * @uses folder_subtree
	 */
	public function folder_tree($start = FALSE, $i = 0)
	{
		$data = $this->_all_cats = $this->get_all('array');
		
		foreach ($data as $row)
		{
			// This assigns all the select fields to the array.
			foreach ($row AS $key => $val)
			{
				$arr[$key] = $val;
			}
			
			$menu_array[$row->id] = $arr;
		}
		
		unset($arr);
		
		// Confirm we have something to work with.
		if ( ! isset($menu_array))
		{
			return FALSE;
		}

		foreach ($menu_array as $key => $val)
		{
			// This checks if the start value is set. Instead of displaying all.
			if ($start !== FALSE && ($start == $val['parent_id'] OR $start == $val['id']))
			{
				foreach ($val AS $the_key => $the_val)
				{
					$arr[$the_key] = $the_val;
				}
				$this_depth = $i++;
				$arr = array_merge($arr, array('depth' => $this_depth));
				$this->_folders[$key] = $arr;
				$this->_folder_subtree($key, $menu_array, $this_depth--, $start);
			}
			elseif ($start === FALSE && 0 == $val['parent_id'])
			{
				foreach ($val AS $the_key => $the_val)
				{
					$arr[$the_key] = $the_val;
				}
				$this->_folders[$key] = $arr;
				$this->_folder_subtree($key, $menu_array, 0);
			}
		}

		return $arr;
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Folder Sub Tree
	 *
	 * Gets all the child folders for a parent.
	 *
	 * @param	int
	 * @param	array
	 * @param	int
	 */
	private function _folder_subtree($id, $menu_array, $depth = 0, $start = FALSE)
	{
		$depth++;
		foreach ($menu_array as $key => $val)
		{
			if ($id == $val['parent_id'])
			{
				foreach ($val AS $the_key => $the_val)
				{
					$arr[$the_key] = $the_val;
				}
				$arr = array_merge($arr, array('depth' => $depth));
				$this->_folders[$key] = $arr;
				$this->_folder_subtree($key, $menu_array, $depth, $start);
			}
		}
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Get Folders
	 *
	 * Get the full array of folders
	 *
	 * @return 	array
	 */
	public function get_folders()
	{
		if (empty($this->_folder))
		{
			$this->folder_tree();
		}
		
		return $this->_folders;
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Clear folders
	 *
	 * Clear out the folders so they do not overlap.
	 *
	 */
	public function clear_folders()
	{
		unset($this->_folders);
		$this->_folders = array();
	}
	
	// ------------------------------------------------------------------------
	
	/**
	* Breadcrumb
	* 
	* Generates a breadcrumb nav for folders
	* 
	* @param	int $node The current folder id
	* @param	int $lev The current level
	* @return	array
	*/
	public function breadcrumb($id, $lev = 0) 
	{
		$query = $this->db
			->where('id', (int) $id)
			->order_by('name')
			->get('file_folders');

		if ($query->num_rows() == 0) 
		{
			return array();
		}
		
		$cat = $query->row_array();
		
		$path = array();
		
		$path[$lev]['name'] = $cat['name'];
		$path[$lev]['id'] = $cat['id'];
		
		if ($cat['parent_id'] != 0) 
		{
			$path = array_merge($this->breadcrumb($cat['parent_id'],$lev+1), $path);
		}
		
		return $path;
	}
}

/* End of file file_folders_m.php */
/* Location: ./system/pyrocms/modules/files/models/file_folders_m.php */ 