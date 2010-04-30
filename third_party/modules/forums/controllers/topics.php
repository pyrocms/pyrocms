<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 0.9.8-rc2
 * @filesource
 */

/**
 * PyroCMS Forums Topic Controller
 *
 * Provides viewing and CRUD for topics
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @package		PyroCMS
 * @subpackage	Forums
 */
class Topics extends Public_Controller {

	/**
	 * Constructor
	 *
	 * Loads dependencies and template settings
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		parent::Public_Controller();

		// Load dependencies
		$this->load->models(array('forums_m', 'forum_posts_m', 'forum_subscriptions_m'));
		$this->load->helpers(array('bbcode', 'smiley'));
		$this->lang->load('forums');
		$this->load->config('forums');

		// Set Template Settings
		$this->template->enable_parser_body(FALSE);

		//$this->template->set_module_layout('default');

		$this->template->append_metadata(theme_css('forums.css'))
					   ->append_metadata(js('bbcode.js', 'forums'))
					   ->append_metadata(js('forums.js', 'forums'));

		$this->template->set_breadcrumb('Home', '/')
					   ->set_breadcrumb('Forums', 'forums');
	}

	/**
	 * View
	 *
	 * Loads the topic and displays it with all replies.
	 *
	 * @param	int	$topic_id	Id of the topic to display
	 * @param	int	$offset		The offset used for pagination
	 * @access	public
	 * @return	void
	 */
	public function view($topic_id, $offset = 0)
	{
		// Update view counter
		$this->forum_posts_m->add_topic_view($topic_id);
		
		// Pagination junk
		$per_page = '10';
		$pagination = create_pagination('forums/topics/view/'.$topic_id, $this->forum_posts_m->count_posts_in_topic($topic_id), $per_page, 5);
		if($offset < $per_page)
		{
			$offset = 0;
		}
		$pagination['offset'] = $offset;
		// End Pagination

		// If topic or forum do not exist then 404
		($topic = $this->forum_posts_m->get($topic_id)) or show_404();
		($forum = $this->forums_m->get($topic->forum_id)) or show_404();
	
		// Get a list of posts which have no parents (topics) in this forum
		$topic->posts = $this->forum_posts_m->get_posts_by_topic($topic_id, $offset, $per_page);
		foreach($topic->posts as &$post)
		{
			$post->author = $this->forum_posts_m->author_info($post->author_id);
			$post->author->post_count =  $this->forum_posts_m->count_user_posts($post->author_id);
		}
		$this->data->topic =& $topic;
		$this->data->forum =& $forum;
		$this->data->pagination = &$pagination;
		
		// Create page
		$this->template->title($topic->title);
		$this->template->set_breadcrumb($forum->title, 'forums/view/'.$forum->id);
		$this->template->set_breadcrumb($topic->title);
		$this->template->build('posts/view', $this->data);
	}


	function new_topic($forum_id = 0)
	{
		if(!$this->ion_auth->logged_in())
		{
			redirect('users/login');
		}
		
		// Get the forum name
		$forum = $this->forums_m->get($forum_id);
		
		// Chech if there is a forum with that ID
		if(!$forum)
		{
			show_404();
		}
		
		// Default this to a nope
		$this->data->show_preview = FALSE;
		
		if($this->input->post('submit') or $this->input->post('preview'))
		{
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('title', 'Title', 'trim|strip_tags|required|max_length[100]');
			$this->form_validation->set_rules('content', 'Message', 'trim|required');

			if ($this->form_validation->run() === TRUE)
			{
				if( $this->input->post('submit') )
				{
					$topic->title = set_value('title');
					$topic->content = htmlspecialchars_decode(set_value('content'), ENT_QUOTES);
					
					if($topic->id = $this->forum_posts_m->new_topic($this->user->id, $topic, $forum))
					{
						$this->forum_posts_m->set_topic_update($topic->id);

						// Add user to notify
						if($this->input->post('notify') == 1)
						{
							$this->forum_subscriptions_m->add($this->user->id, $topic->id);
						}
						else
						{
							$this->forum_subscriptions_m->delete_by(array('user_id' => $this->user->id, 'topic_id' => $topic->id));
						}
						redirect('forums/topics/view/'.$topic->id);
					}
					
					else
					{
						show_error("Error Message:  Error Accured While Adding Topic");
					}
				}
			
				// Preview button was hit, just show em what the post will look like
				elseif( $this->input->post('preview') )
				{
					// Define and Parse Preview
					//$this->data->preview = $this->forum_posts_m->postParse($message, $smileys);
					
					$this->data->show_preview = TRUE;
				}
			}
			
			else
			{
				$this->data->validation_errors = $this->form_validation->error_string();
			}
		}
		
		$this->data->forum =& $forum;
		$this->data->topic =& $topic;

		$this->data->bbcode_buttons = get_bbcode_buttons('content');

		$this->template->set_partial('bbcode', 'partials/bbcode');

		$this->template->set_breadcrumb($forum->title, 'forums/view/'.$forum->id);
		$this->template->set_breadcrumb('New Topic');
		$this->template->build('posts/new_topic', $this->data);
	}

	function stick($topic_id)
	{
		$this->ion_auth->logged_in() or redirect('users/login');

		$this->ion_auth->is_admin() or show_404();

		if($this->forum_posts_m->update($topic_id, array('sticky' => 1)))
		{
			$this->session->set_flashdata('success', 'Topic has been made sticky.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Topic could not be made sticky.');

		}
		redirect('forums/topics/view/' . $topic_id);
	}

	function unstick($topic_id)
	{
		$this->ion_auth->logged_in() or redirect('users/login');

		$this->ion_auth->is_admin() or show_404();

		if($this->forum_posts_m->update($topic_id, array('sticky' => 0)))
		{
			$this->session->set_flashdata('success', 'Topic has been unstuck.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Topic could not be unstuck.');

		}
		redirect('forums/topics/view/' . $topic_id);
	}

}
?>