<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroCMS Settings Model
 *
 * Allows for an easy interface for site settings
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Settings\Models
 */

class Settings_m extends MY_Model {

	/**
	 * Get
	 *
	 * Gets a setting based on the $where param.  $where can be either a string
	 * containing a slug name or an array of WHERE options.
	 *
	 * @param	mixed	$where
	 * @return	object
	 */
	public function get($where)
	{
		if ( ! is_array($where))
		{
			$where = array('slug' => $where);
		}

		return $this->pdb
			->table($this->_table)
			->select('*, IF(`value` = "", `default`, `value`) as `value`')
			->where($where)
			->first();
	}

	/**
	 * Get Many By
	 *
	 * Gets all settings based on the $where param.  $where can be either a string
	 * containing a module name or an array of WHERE options.
	 *
	 * @param	mixed	$where
	 * @return	object
	 */
	public function get_many_by($where = array())
	{
		if ( ! is_array($where))
		{
			$where = array('module' => $where);
		}

		$this->pdb
			->where($where)
			->orderBy('order', 'DESC');
		
		return $this->get_all();
	}

	/**
	 * Update
	 *
	 * Updates a setting for a given $slug.
	 *
	 * @param	string	$slug
	 * @param	array	$params
	 * @return	bool
	 */
	public function update($slug = '', $params = array(), $skip_validation = false)
	{
		return $this->pdb
			->table($this->_table)
			->where('slug', '=', $slug)
			->update($params);
	}

	/**
	 * Sections
	 *
	 * Gets all the sections (modules) from the settings table.
	 *
	 * @return	array  Return an array of modules
	 */
	public function sections()
	{
		$sections = $this->pdb
			->table($this->_table)
			->select('module')
			->distinct()
			->where('module', '!=', '')
			->get();

		return array_map(function($section) {
		    return $section->module;
		}, $sections);
	}

}

/* End of file settings_m.php */