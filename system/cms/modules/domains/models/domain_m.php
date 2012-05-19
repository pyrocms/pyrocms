<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Domains model
 *
 * @author 		Ryan Thompson - AI Web Systems, Inc.
 * @package 	cms/core/modules/domains/models
 */
class Domain_m extends MY_Model
{
	public function __construct()
	{		
		parent::__construct();
	}

	public function get($id)
	{
		$this->_table = 'domains';
		$this->db->set_dbprefix('core_');

		return $this->db->where($this->primary_key, $id)
			->get('domains')
			->row_array();
	}

	public function get_all()
	{
		$this->_table = 'domains';
		$this->db->set_dbprefix('core_');

		return $this->db->get('domains')->result();
	}

	public function count_all()
	{
		$this->_table = 'domains';
		$this->db->set_dbprefix('core_');

		return $this->db->count_all_results('domains');
	}

	public function insert($input = array())
	{
		return $this->db->query("INSERT INTO core_domains (type, domain, site_id) VALUES ('".$this->db->escape_str($input['type'])."', '".$this->db->escape_str($input['domain'])."', ".$this->db->escape($this->_site_id).")");
	}

	public function update($id, $input = array())
	{
		return $this->db->query("UPDATE core_domains SET type = '".$this->db->escape_str($input['type'])."', domain = '".$this->db->escape_str($input['domain'])."' WHERE id = ".$this->db->escape($id)." AND site_id = ".$this->db->escape($this->_site_id));
	}

	public function delete($id)
	{
		return $this->db->query("DELETE FROM core_domains WHERE id = ".$this->db->escape($id)." AND site_id = ".$this->db->escape($this->_site_id));
	}

	// Callbacks
	public function check_domain($domain, $id)
	{
		/*
			We are working with core_ so prefixes are weird for validation.
			We will use two different manual queries here to avoid complications.
		*/
		if($id > 0)
		{
			return $this->db->query("SELECT id from core_domains WHERE id != ".$this->db->escape($id)." AND domain = '".$this->db->escape_str($domain)."' AND site_id = '".$this->db->escape_str($this->_site_id)."'")->num_rows();
		}
		else
		{
			return $this->db->query("SELECT id from core_domains WHERE domain = '".$this->db->escape_str($domain)."' AND site_id = '".$this->db->escape_str($this->_site_id)."'")->num_rows();
		}
	}
}