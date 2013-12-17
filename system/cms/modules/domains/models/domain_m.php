<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS Domains Model
 *
 * @author		Ryan Thompson - AI Web Systems, Inc.
 * @package		PyroCMS\Core\Modules\Domains\Models
 */
class Domain_m extends MY_Model
{
	public function __construct()
	{		
		parent::__construct();
	}

	public function get($id)
	{
		return $this->db->query("SELECT * FROM core_domains WHERE id = ".$this->db->escape($id)." and site_id = ".$this->db->escape($this->_site_id))->row(0);
	}

	public function get_all()
	{
		return $this->db->query("SELECT * FROM core_domains WHERE site_id = ".$this->db->escape($this->_site_id)." ORDER BY domain ASC")->result();
	}

	public function count_all()
	{
		return $this->db->query("SELECT id FROM core_domains WHERE site_id = ".$this->db->escape($this->_site_id))->num_rows();
	}

	public function insert($input = array(), $skip_validation = false)
	{
		return $this->db->query("INSERT INTO core_domains (type, domain, site_id) VALUES ('".$this->db->escape_str($input['type'])."', '".$this->db->escape_str($input['domain'])."', ".$this->db->escape($this->_site_id).")");
	}

	public function update($id, $input = array(), $skip_validation = false)
	{
		return $this->db->query("UPDATE core_domains SET type = '".$this->db->escape_str($input['type'])."', domain = '".$this->db->escape_str($input['domain'])."' WHERE id = ".$this->db->escape($id)." and site_id = ".$this->db->escape($this->_site_id));
	}

	public function delete($id)
	{
		return $this->db->query("DELETE FROM core_domains WHERE id = ".$this->db->escape($id)." and site_id = ".$this->db->escape($this->_site_id));
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
			return $this->db->query("SELECT id FROM core_domains WHERE id != ".$this->db->escape($id)." and domain = '".$this->db->escape_str($domain)."'")->num_rows();
		}
		else
		{
			return $this->db->query("SELECT id FROM core_domains WHERE domain = '".$this->db->escape_str($domain)."'")->num_rows();
		}
	}
}