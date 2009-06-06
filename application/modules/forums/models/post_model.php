<?php
class Post_model extends Model {

	var $fields = array('postID', 'forumID', 'authorID', 'parentID', 'post_title', 'post_text', 'post_type',
						'post_locked', 'post_hidden', 'post_date', 'post_viewcount', 'smileys');
	
	var $post_table = 'ForumPosts';

	var $subscriptionsTable = 'ForumSubscriptions';
	
	var $postID = 0;
	
	var $where = "";
	var $orderby = "";
	
	var $errorMsg = "";
	
	function getPropWhere($prop = '', $where = TRUE)
	{
		$this->db->select($prop, 1);
		$this->db->from($this->post_table);
		$this->db->where($where);
	
		$query = $this->db->get();
		$row = $query->row();
			
		return (isset($row->$prop)) ? $row->$prop : '';
	}
	
	function getTopicsInForum($forumID = 0)
    {
		$this->where = "parentID = 0 AND forumID = $forumID";
		return $this->getList();
		
	}
	 
	function getTopicData($topicID = 0)
    {
		$this->where = "postID = $topicID AND parentID = 0";
		return $this->getList();
		
	}

	function getReplyData($replyID = 0)
	{
		$this->where = "postID = $replyID";
		$data = $this->getList(1);
		if(!empty($data)) return $data[0];
		else return false;
	}
		
	function getRepliesInForum($forumID = 0)
    {
		$this->where = "parentID > 0 AND forumID = $forumID";
		return $this->getList();
		
	}

	function getTotalPostsInTopic($topicID = 0)
    {
		$this->where = "postID = $topicID OR parentID = $topicID";
		$this->orderby = "post_date ASC";
		return $this->getList();
	}
	
	function getPostsInTopic($topicID = 0, $offset = 0, $limit = 0)
    {
		$this->where = "postID = $topicID OR parentID = $topicID";
		$this->orderby = "post_date ASC";
		return $this->getList($limit, $offset);
	}


	function getList($limit = 0, $offset = 0)
    {

		$this->db->select('postID');
		$this->db->from($this->post_table);
		if($this->where != '') 		$this->db->where($this->where);
		if($limit > 0)   			$this->db->limit($limit, $offset);
		if($this->orderby != '') 	$this->db->orderby($this->orderby);
		else					 	$this->db->orderby('post_date', 'DESC');
		
		$query = $this->db->get();
		
		$this->where = "";
		$this->orderBy = "";
		
		$data = array();

		foreach($query->result_array() as $row):
			$data[] = $this->get($row['postID']);
		endforeach;

		return $data;

	}
	
	
    function get($postID = 0, $strip = false)
    {
		$this->postID = ($postID > 0) ? $postID : $this->postID;
        		
		// Get the article with this id
		$this->db->select($this->fields);
	
		$this->db->where('postID', $this->postID);
		$query = $this->db->get($this->post_table, 1);
				
		$this->where = "";
		$this->orderBy = "";
		
		$row = array();
		
		// Convert query to array and give all values a default empty string
		foreach($query->row_array() as $key => $value):			
			$row[$key] = ( isset($value) ) ? ($strip ? stripslashes($value) : $value) : '';
		endforeach;
						
		return $row;
    }


	function getLastPost($type, $typeID = 0)
	{
		switch($type):
			case 'user':
				$this->where = "authorID = $typeID";
			break;
			
			case 'forum':
				$this->where = "forumID = $typeID";
			break;
			
			case 'topic':
				$this->where = "postID = $typeID OR parentID = $typeID";
			break;
		endswitch;
					
		$this->orderby = "post_date DESC";
		$post = $this->getList(1);
		
		// Got one? Goody!
		if(count($post) == 1):
			return $post[0];
		endif;
		
		return false;
	}
	
	// Each time a user looks at a topic it will add 1
	function increaseViewcount($topicID = 0)
	{
		$this->db->query('UPDATE '. $this->post_table .' SET post_viewcount = post_viewcount + 1 WHERE postID = '.intval($topicID));
	}
	

	function postReply($userID, $topicID = 0, $message = "", $smileys = 0)
	{	
		$topic = $this->post_model->getTopicData($topicID);
		if(!empty($topic))
		{
			$post_type = 1;
			$topic_postID = intval($topic[0]['postID']);
			$topic_forumID = intval($topic[0]['forumID']);
			$topic_title = $this->input->xss_clean($topic[0]['post_title']);
			$insert_data = array(
			   'forumID' => $topic_forumID,
               'authorID' => $userID,
               'parentID' => $topic_postID,
               'post_title' => 'Re: '.$this->input->xss_clean($topic_title),
               'post_text' => $this->input->xss_clean($message),
               'post_type' => $this->input->xss_clean($post_type),
               'post_locked' => 0,
               'post_hidden' => 0,
               'post_date' => gmdate('Y-m-d H:i:s'),
               'post_viewcount' => 0,
			   'smileys'	=> $this->input->xss_clean($smileys)
            );
			$this->db->insert($this->post_table, $insert_data);
			return ($this->db->affected_rows() > 0);
			
		} else {
			return false;
		}
	}

	function editReply($postID, $message)
	{
		$update_data = array(
              'post_text' => $this->input->xss_clean($message)
        );
		$this->db->where('postID', $postID);
		$this->db->update($this->post_table, $update_data);
		return ($this->db->affected_rows() > 0);
	}

	function deleteReply($postID)
	{
       	$this->db->where('postID', $postID);
		$this->db->delete($this->post_table);
		return ($this->db->affected_rows() > 0);
	}	

	function postTopic($userID, $forumID = 0, $title = "", $message = "", $smileys = 0)
	{
		$forum = $this->forum_model->getForum($forumID);
		if(!empty($forum))
		{
			$post_type = 1;
			$insert_data = array(
			   'forumID' 		=>	$forumID,
               'authorID' 		=>	$userID,
               'parentID' 		=>	0,
               'post_title' 	=>	$this->input->xss_clean($title),
               'post_text' 		=>	$this->input->xss_clean($message),
               'post_type' 		=>	$this->input->xss_clean($post_type),
               'post_locked' 	=>	0,
               'post_hidden' 	=>	0,
               'post_date' 		=>	gmdate('Y-m-d H:i:s'),
               'post_viewcount' =>	0,
			   'smileys'		=>	$this->input->xss_clean($smileys)
            );
			$this->db->insert($this->post_table, $insert_data);
			return ($this->db->affected_rows() > 0);
			
		} else {
			return false;
		}
	}

	function AddNotify($topicID, $userID)
	{
		// to-do
		// table TopicSubscriptions
		// fields id, topicID, userID
		
		// Check if allready in the list
		$this->db->select('*');
		$this->db->where('topicID', $topicID);
		$this->db->where('userID', $userID);
		$query = $this->db->get($this->subscriptionsTable);

		if($query->num_rows() == 0)
		{
			$insert_data = array(
	               'topicID' 		=>	$topicID,
	               'userID' 		=>	$userID
	        );	
			$this->db->insert($this->subscriptionsTable, $insert_data);
			return ($this->db->affected_rows() > 0);
		}
	}

	function NewPostNotify($topicID, $userID)
	{
		$mail_array = array();

		$this->db->select('*');
		$this->db->where('topicID', $topicID);
		$this->db->where('userID !=', $userID);
		$query = $this->db->get($this->subscriptionsTable);
		
		$i=0;
		foreach ($query->result_array() as $row)
		{
			$mail_array[$i]['user_id'] = $row['userID'];
			$mail_array[$i]['user_name'] = getUserFullNameFromId($row['userID']);			
			$mail_array[$i]['user_email'] = getUserProperty('email', $row['userID']);
			$i++;
		}

		$this->load->library('email');
		foreach ($mail_array as $user_data)
		{
		    $this->email->clear();
		
		    $this->email->to($user_data['user_email']);
		    $this->email->from($this->config->item('admin_email'));
		    $this->email->subject('New Message in Topic');
		    $this->email->message('Dear '.$user_data['user_name'].'. <br>A new message has been posted in topic: '.site_url('forums/topics/view_topic/'.$topicID).' <br>To unsubscribe please visit: '.site_url('forums/topics/unsubscribe/'.$topicID).' ');
		    $this->email->send();
		}
	}

	function unSubscribe($topicID = 0, $userID = 0)
	{
		$this->db->where('topicID', $topicID);
		$this->db->where('userID', $userID);
		$this->db->delete($this->subscriptionsTable);
		return ($this->db->affected_rows() > 0);
	}

	function postParse($message, $smileys = 1)
	{
		$message = parse_bbcode($message);
		if($smileys) $message = parse_smileys($message);
		$message = nl2br(stripslashes($message));
		return $message;
	}	
}
?>