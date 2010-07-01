<?php defined('BASEPATH') or exit('No direct script access allowed');

class Settings_m extends MY_Model {

	function get($slug = '')
	{
		return $this->db
			->select('slug, type, IF(`value` = "", `default`, `value`) as `value`', FALSE)
			->where('slug', $slug)
			->get('settings')
			->row();
	}

	function get_all()
	{
		return $this->db
			->select('slug, type, IF(`value` = "", `default`, `value`) as `value`', FALSE)
			->get('settings')
			->result();
	}

	function get_settings($params = array())
	{
		return $this->db
			->select('slug, type, title, description, `default`, `options`')
			->select('IF(`value` = "", `default`, `value`) as `value`, is_required, module', FALSE)
			->where($params)
			->get('settings')
			->result();
	}

	function update($slug = '', $params = array())
	{
		return $this->db->update('settings', $params, array('slug' => $slug));
	}

	function sections()
	{
		$this->db->select('module');
		$this->db->distinct();
		$this->db->where('module != ""');

		$query = $this->db->get('settings');

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