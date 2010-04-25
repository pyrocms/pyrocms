<?php
class Forum_posts_m extends MY_Model
{
	/**
	 * Count Topics in Forum
	 *
	 * How many topics (posts which have no parent / are not a reply to anything) are in a forum.
	 * 
	 * @access       public
	 * @param        int 	[$forum_id] 	Which forum should be counted
	 * @return       int 	Returns a count of how many topics there are
	 * @package      forums
	 */
	public function count_topics_in_forum($forum_id)
	{
		return parent::count_by(array(
			'parent_id' => 0,
			'forum_id' => $forum_id
		));		
	}
	

	/**
	 * Count Replies in Forum
	 *
	 * How many replies have been made to topics in a forum.
	 * 
	 * @access       public
	 * @param        int 	[$forum_id] 	Which forum should be counted
	 * @return       int 	Returns a count of how many replies there are
	 * @package      forums
	 */
	public function count_replies_in_forum($forum_id)
	{
		return parent::count_by(array(
			'parent_id >' => 0,
			'forum_id' => $forum_id
		));
	}

	/**
	 * Count Posts in Topic
	 *
	 * How many posts are in a topic.
	 * 
	 * @access       public
	 * @param        int 	[$forum_id] 	Which topic should be counted
	 * @return       int 	Returns a count of how many posts there are
	 * @package      forums
	 */
	public function count_posts_in_topic($topic_id)
	{
		$this->db->or_where(array('id' => $topic_id, 'parent_id' => $topic_id));
		
		return parent::count_all();		
	}

	/**
	 * Get Posts in Topic
	 *
	 * Get all posts in a topic.
	 * 
	 * @access       public
	 * @param        int 	[$forum_id] 	Which topic should be counted
	 * @return       int 	Returns a count of how many posts there are
	 * @package      forums
	 */
	public function get_posts_by_topic($topic_id)
	{
		$this->db->or_where(array('id' => $topic_id, 'parent_id' => $topic_id));
		$this->db->order_by('created_on');
		return $this->db->get('forum_posts')->result();
	}

	/**
	 * Get Posts in Topics
	 *
	 * Return an array of all topics in a forum.
	 * 
	 * @access       public
	 * @param        int 	[$forum_id] 	Which forum should be counted
	 * @return       int 	Returns a count of how many topics there are
	 * @package      forums
	 */
	public function get_topics_by_forum($forum_id)
	{
		$this->db->where(array('forum_id' => $forum_id, 'parent_id' => 0));
		$query = $this->db->get('forum_posts');
		return $query->result();		
	}

	/**
	 * Get latest post in Forum
	 *
	 * How many replies have been made to topics in a forum.
	 * 
	 * @access       public
	 * @param        int 	[$forum_id] 	Which forum should be counted
	 * @return       int 	Returns a count of how many replies there are
	 * @package      forums
	 */
	public function last_forum_post($forum_id)
	{
		$this->db->where('forum_posts' . '.forum_id', $forum_id);
		$this->db->order_by('forum_posts' . '.created_on DESC');
		$this->db->limit(1);
		$this->db->join('forum_posts' . ' as `post2`', 'forum_posts' . '.parent_id = post2.id');

		return $this->db->get('forum_posts')->row();
	}

	/**
	 * Get latest post in Forum
	 *
	 * How many replies have been made to topics in a forum.
	 * 
	 * @access       public
	 * @param        int 	[$forum_id] 	Which forum should be counted
	 * @return       int 	Returns a count of how many replies there are
	 * @package      forums
	 */
	public function getLastPostInTopic($topic_id)
	{
		$this->db->or_where(array('id' => $topic_id, 'parent_id' => $topic_id));
		$this->db->order_by('created_on DESC');
		$this->db->limit(1);
		return $this->db->get('forum_posts')->row();
	}
	
	/**
	 * Get Author Info
	 *
	 *
	 * @access       public
	 * @param        int 	[$author_id] 	The author ID.
	 * @return       array
	 * @package      forums
	 */
	public function author_info($author_id)
	{
		$CI =& get_instance();
		$u_table = $CI->ion_auth_model->tables['users'];
		$m_table = $CI->ion_auth_model->tables['meta'];
		$m_join = $CI->ion_auth_model->meta_join;

		$this->db->select("$u_table.id, $u_table.email, $u_table.created_on, $u_table.last_login, $m_table.first_name, $m_table.last_name, CONCAT($m_table.first_name, ' ', $m_table.last_name) as full_name");
		$this->db->where(array("$u_table.id" => $author_id));
		$this->db->join($m_table, "$u_table.id = $m_table.$m_join", 'left');
		$this->db->limit(1);
		return $this->db->get($CI->ion_auth_model->tables['users'])->row();
	}


	/**
	 * Get topic
	 *
	 * Get the basic information about a topic (not the posts within it)
	 * 
	 * @access       public
	 * @param        int 	[$topic_id] 	Which topic to look at
	 * @return       int 	Returns an object containing a topic
	 * @package      forums
	 */
	function getTopic($topic_id = 0)
    {
		$this->db->where(array('id' => $topic_id, 'parent_id' => 0));
		return $this->db->get('forum_posts')->row();
	}
	

	// Each time a user looks at a topic it will add 1
	function increaseViewcount($topic_id = 0)
	{
		$this->db->set('view_count = view_count + 1');
		$this->db->where('id', (int) $topic_id);
		$this->db->update('forum_posts');
	}
	

	
	function new_topic($user_id, $topic, $forum)
	{
		$this->load->helper('date');

		$insert = array(
			'forum_id' 		=> $forum->id,
			'author_id' 	=> $user_id,
			'parent_id' 	=> 0,
			'title' 		=> $this->input->xss_clean($topic->title),
			'content' 			=> $this->input->xss_clean($topic->text),
			'created_on' 	=> now(),
			'view_count' 	=> 0,
        );
		
        $this->db->insert('forum_posts', $insert);
		
        return $this->db->insert_id();
	}
	
	function new_reply($user_id, $reply, $topic)
	{
		$this->load->helper('date');

		$insert = array(
			'forum_id' 		=> $topic->forum_id,
			'author_id' 	=> $user_id,
			'parent_id' 	=> $topic->id,
			'title' 		=> '',
			'content'		=> $reply->content,
			'created_on' 	=> now(),
			'view_count' 	=> 0,
        );
		
        $this->db->insert('forum_posts', $insert);

        return $this->db->insert_id();
	}
	
	function get_reply($reply_id = 0)
	{
		$this->db->where('id', $reply_id);
		return $this->db->get('forum_posts', 1)->row();
	}
	
	function getPost($post_id = 0)
	{
		$this->db->where('id', $post_id);
		return $this->db->get('forum_posts', 1)->row();
	}
	
/*

	function getTotalPostsInTopic($topicID = 0)
    {
		$this->where = "postID = $topicID OR parentID = $topicID";
		$this->orderby = "post_date ASC";
		return $this->getList();
	}
	


	function getList($limit = 0, $offset = 0)
    {

		$this->db->select('postID');
		$this->db->from('forum_posts');
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
		$query = $this->db->get('forum_posts', 1);
				
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
		$this->db->query('UPDATE '. 'forum_posts' .' SET post_viewcount = post_viewcount + 1 WHERE postID = '.intval($topicID));
	}
	

	function editReply($postID, $text)
	{
		$update_data = array(
              'post_text' => $this->input->xss_clean($text)
        );
		$this->db->where('postID', $postID);
		$this->db->update('forum_posts', $update_data);
		return ($this->db->affected_rows() > 0);
	}

	function deleteReply($postID)
	{
       	$this->db->where('postID', $postID);
		$this->db->delete('forum_posts');
		return ($this->db->affected_rows() > 0);
	}	

	function postTopic($user_id, $forum_id = 0, $title = "", $text = "", $smileys = 0)
	{
		$forum = $this->forums_m->get($forum_id);
		if(!empty($forum))
		{
			$post_type = 1;
			$insert_data = array(
			   'forumID' 		=>	$forum_id,
               'authorID' 		=>	$user_id,
               'parentID' 		=>	0,
               'post_title' 	=>	$this->input->xss_clean($title),
               'post_text' 		=>	$this->input->xss_clean($text),
               'post_type' 		=>	$this->input->xss_clean($post_type),
               'post_locked' 	=>	0,
               'post_hidden' 	=>	0,
               'post_date' 		=>	gmdate('Y-m-d H:i:s'),
               'post_viewcount' =>	0,
			   'smileys'		=>	$this->input->xss_clean($smileys)
            );
			$this->db->insert('forum_posts', $insert_data);
			return ($this->db->affected_rows() > 0);
			
		} else {
			return false;
		}
	}

	function AddNotify($topicID, $user_id)
	{
		// to-do
		// table TopicSubscriptions
		// fields id, topicID, userID
		
		// Check if allready in the list
		$this->db->select('*');
		$this->db->where('topicID', $topicID);
		$this->db->where('userID', $user_id);
		$query = $this->db->get($this->subscriptionsTable);

		if($query->num_rows() == 0)
		{
			$insert_data = array(
	               'topicID' 		=>	$topicID,
	               'userID' 		=>	$user_id
	        );	
			$this->db->insert($this->subscriptionsTable, $insert_data);
			return ($this->db->affected_rows() > 0);
		}
	}

	function NewPostNotify($topicID, $user_id)
	{
		$mail_array = array();

		$this->db->select('*');
		$this->db->where('topicID', $topicID);
		$this->db->where('userID !=', $user_id);
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
		    $this->email->message('Dear '.$user_data['user_name'].'. <br>A new message has been posted in topic: '.site_url('forums/topics/view/'.$topicID).' <br>To unsubscribe please visit: '.site_url('forums/topics/unsubscribe/'.$topicID).' ');
		    $this->email->send();
		}
	}

	function unSubscribe($topicID = 0, $user_id = 0)
	{
		$this->db->where('topicID', $topicID);
		$this->db->where('userID', $user_id);
		$this->db->delete($this->subscriptionsTable);
		return ($this->db->affected_rows() > 0);
	}

	function postParse($text, $smileys = 1)
	{
		$text = parse_bbcode($text);
		if($smileys) $text = parse_smileys($text);
		$text = nl2br(stripslashes($text));
		return $text;
	}
	*/
}
?>