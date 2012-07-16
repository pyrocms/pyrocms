<?php

/*
* Comment_blacklist_m
* @author Matt Frost
*
* Model for the comment blacklist feature
*/

class Comment_blacklists_m extends MY_Model {
	
	private $data;
   
	public function __construct()
	{
		$this->_table = $this->db->dbprefix('comment_blacklists');
	}

	
	public function insert($data)
	{
		if ($this->_get_count($data)->count < 1)
		{
			return parent::insert($data);
		}
	}
	
	private function _get_count($data)
	{
		foreach($data as $k => $v)
		{
			$where .= "`$k`='$v' OR "; 
		}
		$this->db->select('count(*) as count')->from('comment_blacklists')->where(substr($where,0,-4)); 
		return $this->db->get()->row();
	}

	public function is_blacklisted($data)
	{
		if ($this->_get_count($data)->count > 0)
		{
			return true;
		}
		return false;
	}
}
