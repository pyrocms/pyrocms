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

	
	public function save($data)
	{
		if ($this->_get_count($data) < 1)
		{
			return parent::insert($data);
		}
	}
	
	private function _get_count($data)
	{
		return $this->db->or_where($data)->count_all_results('comment_blacklists');
	}

	public function is_blacklisted($data)
	{
		if ($this->_get_count($data) > 0)
		{
			return true;
		}
		return false;
	}
}
