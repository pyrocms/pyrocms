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
 * PyroCMS Forums Posts Controller
 *
 * Provides CRUD for topic replies
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @package		PyroCMS
 * @subpackage	Forums
 */
class Posts extends Public_Controller {

	/**
	 * Constructor
	 *
	 * Loads dependencies and sets template settings
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		parent::Public_Controller();

		// Load dependencies
		$this->load->models(array('forums_m', 'forum_posts_m', 'forum_subscriptions_m'));
		$this->load->helper('smiley');
		$this->load->library('Forums_lib');
		$this->load->config('forums');
		$this->lang->load('forums');

		if(!$this->settings->item('forums_editor'))
		{
			$this->forums_m->add_setting();
		}

		$this->load->helper($this->settings->item('forums_editor'));

		// Template settings
		$this->template->enable_parser_body(FALSE);

		//$this->template->set_module_layout('default');

		$this->template->append_metadata(theme_css('forums.css'))
					   ->append_metadata(js('forums.js', 'forums'));

		$this->template->set_breadcrumb('Home', '/')
					   ->set_breadcrumb('Forums', 'forums');
	}
	
	/**
	 * View Reply
	 *
	 * Takes the reply and redirects to the correct topic and page.
	 *
	 * @param	int	$reply_id	Id of the reply
	 * @access	public
	 * @return	void
	 */
	public function view_reply($reply_id = 0)
	{
		// If not a valid reply then 404
		($reply = $this->forum_posts_m->get_reply($reply_id)) || show_404();

		// Get the offset (for pagination)
		$per_page = 10;
		$offset = (int) ($this->forum_posts_m->count_prior_posts($reply->parent_id, $reply->created_on) / $per_page);
		$offset = ($offset == 0) ? '' : '/' . ($offset * $per_page);

		// Propogate flashdata
		$this->session->set_flashdata('notice', $this->session->flashdata('notice'));
		$this->session->set_flashdata('error', $this->session->flashdata('error'));
		$this->session->set_flashdata('success', $this->session->flashdata('success'));


		// This is a reply
		if($reply->parent_id > 0)
		{
			redirect('forums/topics/view/'.$reply->parent_id . $offset . '#'.$reply_id);
		}
		
		// This is a new topic
		else
		{
			redirect('forums/topics/view/'.$reply_id);
		}
	}

	/**
	 * Quote Reply
	 *
	 * Stores the quote of $post_id in flashdata then redirects to edit_reply.
	 *
	 * @param	int	$post_id	Id of the post to quote
	 * @access	public
	 * @return	void
	 */
	public function quote_reply($post_id)
	{
		// If post is not valid 404
		($quote = $this->forum_posts_m->get_post($post_id)) || show_404();

		// Put the quote in the flashdata.
		$this->session->set_flashdata('forum_quote', serialize($quote));
		
		// Det the topic's id
		$topic_id = $quote->parent_id > 0 ? $quote->parent_id : $quote->id;
		
		// Redirect to the normal reply form. It will pick the quote up
		redirect('forums/posts/new_reply/'.$topic_id);
	}

	/**
	 * New Reply
	 *
	 * Displays new reply form and adds reply to topic
	 *
	 * @param	int	$topic_id	Id of the topic to reply too
	 * @access	public
	 * @return	void
	 */
	public function new_reply($topic_id = 0)
	{
		// Can't reply if you aren't logged it
		$this->ion_auth->logged_in() or redirect('users/login');

		// Get the topic and forum info
		$topic = $this->forum_posts_m->get_topic($topic_id);
		$forum = $this->forums_m->get(@$topic->forum_id);

		// Chech if there is a forum with that ID
		($topic and $forum) or show_404();

		// If it's a quote reply get the flashdata
		if($this->session->flashdata('forum_quote'))
		{
			$quote = unserialize($this->session->flashdata('forum_quote'));

			if($this->settings->item('forums_editor') == 'bbcode')
			{
				$reply->content = '[quote]'.$quote->content.'[/quote]';
			}
			elseif($this->settings->item('forums_editor') == 'textile')
			{
				$reply->content = 'bq..  '.$quote->content . "\n\n";
			}
		}

		// If not a reply jsut set the content to the form validation value
		else
		{
			$reply->content = set_value('content');
		}

		// Default's notify based on if the user is subscribed already
		$reply->notify = $this->forum_subscriptions_m->is_subscribed($this->user->id, $topic_id);

		// Decode the content.  This is required because of DB encoding.
		$reply->content = htmlspecialchars_decode($reply->content, ENT_QUOTES);

		// The form has been submitted one way or another
		if($this->input->post('submit') or $this->input->post('preview'))
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('content', 'Message', 'trim|required');
			$this->form_validation->set_rules('notify', 'Subscription notification', 'trim|strip_tags|max_length[1]');

			// Run form validation and add the reply
			if ($this->form_validation->run() === TRUE)
			{
				// Add the reply already
				if( $this->input->post('submit') )
				{
					// Try and add the reply
					if($reply->id = $this->forum_posts_m->new_reply($this->user->id, $reply, $topic))
					{
						// Set Topic Update Time
						$this->forum_posts_m->set_topic_update($topic->id);
						
						// Set some info needed for notificaations
						$reply->title = $topic->title;
						$reply->topic_id = $topic->id;
						$recipients = $this->forums_lib->get_recipients($topic_id);

						// Send notifications
						$this->forums_lib->notify_reply($recipients, $reply);

						// User wants to be notified
						if($this->input->post('notify') == 1)
						{
							$this->forum_subscriptions_m->add($this->user->id, $topic->id);
						}

						// User does NOT want to be notified, so unsubscribe them.
						else
						{
							$this->forum_subscriptions_m->delete_by(array('user_id' => $this->user->id, 'topic_id' => $topic->id));
						}
						$this->session->set_flashdata('success', 'Reply has been added.');
						redirect('forums/posts/view_reply/'.$reply->id);
					}

					// Couldn't add the reply for some reason
					else
					{
						show_error("There was a problem adding the reply.");
					}
				}

				// Preview button was hit, just show em what the post will look like
				elseif( $this->input->post('preview') )
				{
					$this->data->show_preview = TRUE;
				}
			}

			// Form validation failed, set errors.
			else
			{
				$this->data->messages['error'] = validation_errors();
			}
		}

		// Set variables for the view
		$this->data->quote =& $quote;
		$this->data->reply =& $reply;
		$this->data->forum =& $forum;
		$this->data->topic =& $topic;

		// Template settings, then build
		$this->template->set_partial('buttons', 'partials/buttons');
		$this->template->set_breadcrumb($forum->title, 'forums/view/'.$topic->forum_id);
		$this->template->set_breadcrumb($topic->title, 'forums/topics/view/'.$topic->id);
		$this->template->set_breadcrumb('New Reply');
		$this->template->build('posts/reply_form', $this->data);
	}

	/**
	 * Edit Reply
	 *
	 * Allows users to edit their replies. Admins can edit all.
	 *
	 * @param	int $reply_id	Id of reply to edit
	 * @access	public
	 * @return	void
	 */
	public function edit_reply($reply_id)
	{
		// Can't edit if you aren't logged in
		$this->ion_auth->logged_in() or redirect('users/login');

		// Get the reply info
		$reply = $this->forum_posts_m->get($reply_id);

		// This is the main topic so get it's info
		if(empty($reply->parent_id))
		{
			$topic = $this->forum_posts_m->get_topic($reply_id);
		}

		// This is a reply so get the parent's info
		else
		{
			$topic = $this->forum_posts_m->get_topic($reply->parent_id);
		}

		// Get forum info
		$forum = $this->forums_m->get($reply->forum_id);

		// Vlaid topic and forum? No? 404.
		($topic && $forum) or show_404();

		// You have to be the author or an admin.  Neither? 404.
		($this->user->id && $reply->author_id) or $this->ion_auth->is_admin() or show_404();

		// Override with post data if it exists
		$this->input->post('content') and $reply->content = set_value('content');
		$this->input->post('notify') and $reply->notify = set_value('notify');

		// Must decode the content.  DB encodes quotes and such.
		$reply->content = htmlspecialchars_decode($reply->content, ENT_QUOTES);

		// The form has been submitted one way or another
		if($this->input->post('submit') or $this->input->post('preview'))
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('content', 'Message', 'trim|required');
			$this->form_validation->set_rules('notify', 'Subscription notification', 'trim|strip_tags|max_length[1]');

			// Did we pass form validation?
			if ($this->form_validation->run() === TRUE)
			{
				// Go ahead and update the reply
				if( $this->input->post('submit') )
				{
					$reply->id = $this->forum_posts_m->update($reply_id, array(
						'content' => $reply->content
					));

					// Yay it was added.
					if($reply->id)
					{
						$this->session->set_flashdata('notice', 'Reply was edited successfully.');
						redirect('forums/posts/view_reply/'.$topic->id);
					}

					else
					{
						show_error("There was a problem adding thid reply.");
					}
				}

				// Preview button was hit, just show em what the post will look like
				elseif( $this->input->post('preview') )
				{
					$this->data->show_preview = TRUE;
				}
			}

			// did not pass form validation
			else
			{
				$this->data->messages['error'] = validation_errors();
			}
		}

		// Default's notify based on if the user is subscribed already
		$reply->notify = $this->forum_subscriptions_m->is_subscribed($this->user->id, $topic->id);

		// Infor for the view
		$this->data->forum =& $forum;
		$this->data->topic =& $topic;
		$this->data->reply =& $reply;

		//Template Settings and build
		$this->template->set_partial('buttons', 'partials/buttons');
		$this->template->set_breadcrumb($forum->title, 'forums/view/'.$forum->id);
		$this->template->set_breadcrumb($topic->title, 'forums/topics/view/'.$topic->id);
		$this->template->set_breadcrumb('New Reply');

		$this->template->build('posts/reply_form', $this->data);
	}

	/**
	 * Delete Reply
	 *
	 * Allows users to delete their posts, admins can delete any.
	 *
	 * @param	int	$reply_id Id of the reply to delete
	 * @access	public
	 * @return	void
	 */
	public function delete_reply($reply_id)
	{
		// You gotta be logged in
		$this->ion_auth->logged_in() or redirect('users/login');

		// Get the reply
		$reply = $this->forum_posts_m->get($reply_id);

		// You can't delete a topic unless you are admin
		//($reply->parent_id == 0 && !$this->ion_auth->is_admin()) or show_404();

		// Chech if it is the user's reply or if admin
		($this->user->id && $reply->author_id) or $this->ion_auth->is_admin() or show_404();

		// Delete the post
		$this->forum_posts_m->delete($reply_id);

		// If it's a topic delete all the replies
		if($reply->parent_id == 0)
		{
			$this->forum_posts_m->delete_by(array('parent_id' => $reply_id));
			
			$this->session->set_flashdata('notice', 'The topic has been deleted.');
			redirect('forums/view/' . $reply->forum_id);
		}
		
		// It's a single reply
		else
		{
			$this->session->set_flashdata('success', 'The reply has been deleted.');
			redirect('forums/topics/view/' . $reply->parent_id);
		}
	}
}
