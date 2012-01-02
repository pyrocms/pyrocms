<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Redirect_m extends MY_Model
{
	function get_all()
	{
		//$this->db->where('site_id', $this->site->id);
		return $this->db->get('redirects')->result();
	}

	function get_from($from)
	{
		//$this->db->where('site_id', $this->site->id);
		$this->db->where($this->db->escape($from)." LIKE ".
			$this->db->dbprefix('redirects').".from", null, false);
		$data = $this->db->get('redirects')->row();
		return $data;
	}

	function count_all()
	{
		//$this->db->where('site_id', $this->site->id);
		return $this->db->count_all_results('redirects');
	}

	function insert($input = array())
	{
		return $this->db->insert('redirects', array(
			'`type`' => $input['type'],
			'`from`' => str_replace('*', '%', $input['from']),
			'`to`' => trim($input['to'], '/'),
		//	'site_id' => $this->site->id
		));
	}

	function update($id, $input = array())
	{
		$this->db->where(array(
			'id' => $id,
		//	'site_id' => $this->site->id
		));

		return $this->db->update('redirects', array(
			'`type`' => $input['type'],
			'`from`' => str_replace('*', '%', $input['from']),
			'`to`' => trim($input['to'], '/')
		));
	}

	function delete($id)
	{
		return $this->db->delete('redirects', array(
			'id' => $id,
		//	'site_id' => $this->site->id
		));
	}

	// Callbacks
	function check_from($from, $id = 0)
	{
		if($id > 0)
		{
			$this->db->where('id !=', $id);
		}

		return $this->db->where(array(
			'`from`' =>  str_replace('*', '%', $from),
		//	'site_id' => $this->site->id
		))->count_all_results('redirects');
	}
}