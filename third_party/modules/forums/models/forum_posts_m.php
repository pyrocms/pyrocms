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
		return parent::count_by("id = $topic_id OR parent_id = $topic_id");
	}

	/**
	 * Add a view to a topic
	 *
	 *
	 * @access       public
	 * @param        int 	[$topic_id]
	 * @return       NULL
	 * @package      forums
	 */

	public function add_topic_view($topic_id)
	{
		$this->db->set('view_count', 'view_count + 1', FALSE);
		$this->db->where('id', (int) $topic_id);
		$this->db->update('forum_posts');
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
	public function last_topic_post($topic_id)
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
	function get_topic($topic_id = 0)
    {
		$this->db->where(array('id' => $topic_id, 'parent_id' => 0));
		return $this->db->get('forum_posts')->row();
	}

	// Each time a user looks at a topic it will add 1
	function increaseViewcount($topic_id = 0)
	{
		$this->db->set('view_count', 'view_count + 1', FALSE);
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
			'title' 		=> $topic->title,
			'content' 			=> $topic->content,
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
	
	function get_post($post_id = 0)
	{
		$this->db->where('id', $post_id);
		return $this->db->get('forum_posts', 1)->row();
	}
	
}
?>