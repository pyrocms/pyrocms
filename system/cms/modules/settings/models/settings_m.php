<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0
 * @filesource
 */

/**
 * PyroCMS Settings Model
 *
 * Allows for an easy interface for site settings
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @package		PyroCMS
 * @subpackage	Settings
 */
class Settings_m extends MY_Model {

	/**
	 * Get
	 * 
	 * Gets a setting based on the $where param.  $where can be either a string
	 * containing a slug name or an array of WHERE options.
	 *
	 * @access	public
	 * @param	mixed	$where
	 * @return	object
	 */
	public function get($where)
	{
		if(!is_array($where))
		{
			$where = array('slug' => $where);
		}
		
		return $this->db
			->select('*, IF(`value` = "", `default`, `value`) as `value`', FALSE)
			->where($where)
			->get('settings')
			->row();
	}

	/**
	 * Get All
	 * 
	 * Gets all settings based on the $where param.  $where can be either a string
	 * containing a module name or an array of WHERE options.
	 *
	 * @access	public
	 * @param	mixed	$where
	 * @return	object
	 */
	public function get_all($where = array())
	{
		if ( ! is_array($where))
		{
			$where = array('module' => $where);
		}

		return $this->db
			->select('*, IF(`value` = "", `default`, `value`) as `value`', FALSE)
			->where($where)
			->order_by('`order`', 'DESC')
			->get('settings')
			->result();
	}
	
	/**
	 * Get Settings
	 * 
	 * This function is depriciated.  You should use get_all() instead.
	 *
	 * @deprecated	Since v1.0
	 * @access		public
	 * @param		mixed	$where
	 * @return		object
	 */
	public function get_settings($where = NULL)
	{
		return $this->get_all($where);
	}

	/**
	 * Update
	 * 
	 * Updates a setting for a given $slug.
	 *
	 * @access	public
	 * @param	string	$slug
	 * @param	array	$params
	 * @return	bool
	 */
	public function update($slug = '', $params = array())
	{
		return $this->db->update('settings', $params, array('slug' => $slug));
	}

	/**
	 * Sections
	 * 
	 * Gets all the sections (modules) from the settings table.
	 *
	 * @access	public
	 * @return	array
	 */
	public function sections()
	{
		$query = $this->db->select('module')
			->distinct()
			->where('module != ""')
			->get('settings');

		if ($query->num_rows() == 0)
		{
			return FALSE;
		}

		$sections = array();

		foreach ($query->result() as $section)
		{
			$sections[$section->module] = ucfirst($section->module);
		}

		return $sections;
	}

}

/* End of file settings_m.php */