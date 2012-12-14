<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Redirect model
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Redirects\Models 
 */
class Redirect_m extends MY_Model
{

	public function get($id)
	{
		return $this->db->where($this->primary_key, $id)
			->get($this->_table)
			->row_array();
	}

	public function get_all()
	{
		//$this->db->where('site_id', $this->site->id);
		return $this->db->get('redirects')->result();
	}

	public function get_from($from)
	{
		return $this->db
			->like('from', $from, 'none')
			->get($this->_table)
			->row();
	}

	public function count_all()
	{
		return $this->db->count_all_results('redirects');
	}

	public function insert($input = array(), $skip_validation = false)
	{
		return $this->db->insert('redirects', array(
			'`type`' => $input['type'],
			'`from`' => str_replace('*', '%', $input['from']),
			'`to`' => trim($input['to'], '/'),
		));
	}

	public function update($id, $input = array(), $skip_validation = false)
	{
		$this->db->where(array(
			'id' => $id,
		));

		return $this->db->update('redirects', array(
			'`type`' => $input['type'],
			'`from`' => str_replace('*', '%', $input['from']),
			'`to`' => trim($input['to'], '/')
		));
	}

	public function delete($id)
	{
		return $this->db->delete('redirects', array(
			'id' => $id,
		));
	}

	// Callbacks
	public function check_from($from, $id = 0)
	{
		if($id > 0)
		{
			$this->db->where('id !=', $id);
		}

		return $this->db->where(array(
			'`from`' =>  str_replace('*', '%', $from),
		))->count_all_results('redirects');
	}
}