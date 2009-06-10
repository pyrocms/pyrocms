<?php
class Forum_model extends Model {

	var $category_table = 'ForumCategories';
	var $forum_table = 'Forums';
	var $post_table = 'ForumPosts';
	
	var $categoryID = 0;
	var $forumID = 0;

		
	// --- Category Related Queries --- //
	function getCategories()
    {
		$this->db->from($this->category_table);	
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	
    function getCategory($categoryID = 0)
    {
		$this->categoryID = ($categoryID > 0) ? $categoryID : $this->categoryID;
	
		$this->db->where('categoryID', $this->categoryID);
		$query = $this->db->get($this->category_table, 1);

		$row = array();
		
		// Convert query to array and give all values a default empty string
		foreach($query->row_array() as $key => $value):			
			$row[$key] = ( isset($value) ) ? $value : '';
		endforeach;
						
		return $row;
    }
	
	// --- Forum Related Queries --- //
	function getForumList($categoryID = 0)
    {
		$this->categoryID = ($categoryID > 0) ? $categoryID : $this->categoryID;
		
		$this->db->from($this->forum_table);	
		$this->db->where('categoryID', $this->categoryID);
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
		
	function getForum($forumID = 0)
    {
		$this->forumID = ($forumID > 0) ? $forumID : $this->forumID;
	
		$this->db->where('forumID', $this->forumID);
		$query = $this->db->get($this->forum_table, 1);

		$row = array();
		
		// Convert query to array and give all values a default empty string
		foreach($query->row_array() as $key => $value):			
			$row[$key] = ( isset($value) ) ? $value : '';
		endforeach;
						
		return $row;
    }
	
}
?>