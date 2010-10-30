<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Group model
 *
 * @author Phil Sturgeon - PyroCMS Dev Team
 * @package PyroCMS
 * @subpackage Groups module
 * @category Modules
 *
 */
class Group_m extends CI_Model
{
	/**
	 * Check a rule based on it's role
	 *
	 * @access public
	 * @param string $role The role
	 * @param array $location
	 * @return mixed
	 */
	public function check_rule_by_role($role, $location)
	{
		// No more checking to do, admins win
		if ( $role == 1 )
		{
			return TRUE;
		}

		// Check the rule based on whatever parts of the location we have
		if ( isset($location['module']) )
		{
			 $this->db->where('(module = "'.$location['module'].'" or module = "*")');
		}

		if ( isset($location['controller']) )
		{
			 $this->db->where('(controller = "'.$location['controller'].'" or controller = "*")');
		}

		if ( isset($location['method']) )
		{
			 $this->db->where('(method = "'.$location['method'].'" or method = "*")');
		}

		// Check which kind of user?
		$this->db->where('g.id', $role);

		$this->db->from('permissions p');
		$this->db->join('groups as g', 'g.id = p.group_id');

		$query = $this->db->get();

		return $query->num_rows() > 0;
	}

	/**
	 * Return an object containing rule properties
	 *
	 * @access public
	 * @param int $id The ID of the role
	 * @return mixed
	 */
	public function get($id = 0)
	{
		return $this->db->get_where('groups', array(
			'id' => $id,
			//'site_id' => $this->site->id
		))->row();
	}

	/**
	 * Return an array of groups
	 *
	 * @access public
	 * @param array $params Optional parameters
	 * @return array
	 */
	public function get_all($params = array())
	{
		if ( isset($params['except']) )
		{
			$this->db->where_not_in('name', $params['except']);
		}

		return $this->db
			//->where('site_id', $this->site->id)
			->get('groups')->result();
	}

	/**
	 * Add a group
	 *
	 * @access public
	 * @param array $input The data to insert
	 * @return array
	 */
	public function insert($input)
	{
		return $this->db->insert('groups', array(
		'name' => $input['name'],
        	'description' => $input['description'],
			//'site_id' => $this->site->id
		));
	}

	/**
	 * Update a group
	 *
	 * @access public
	 * @param int $id The ID of the role
	 * @param array $input The data to update
	 * @return array
	 */
	public function update($id, $input)
	{
		return $this->db
			->where('id', $id)
			//->where('site_id', $this->site->id)
			->update('groups', array(
				'name' => $input['name'],
				'description' => $input['description']
			));
	}

	/**
	 * Delete a group
	 *
	 * @access public
	 * @param int $id The ID of the role to delete
	 * @return
	 */
	public function delete($id) {

		if ( ! is_array($id))
		{
			$id = array('id' => $id);
		}

		// Dont let them delete these.
		// The controller should handle the error message, this is just insurance
		$this->db->where_not_in('name', array('user', 'admin'));

		$this->db
			//->where('site_id', $this->site->id)
			->delete('groups', $id);
		
        return $this->db->affected_rows() > 0;
	}
}