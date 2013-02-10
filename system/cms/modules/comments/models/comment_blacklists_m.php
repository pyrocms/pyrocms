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
		// We will always get an email address since it's required.
		// The only variable is the website. If it wasn't provided,
		// we can't check by it.
		if ( ! trim($data['website']))
		{
			return (bool)$this->db->where('email', $data['email'])->count_all_results('comment_blacklists');
		}

		return (bool)$this->_get_count($data);
	}
}
