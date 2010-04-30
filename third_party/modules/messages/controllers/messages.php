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
 * PyroCMS Messages Controller
 *
 * Provides viewing and CRUD for Messages
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @package		PyroCMS
 * @subpackage	Messages
 */
class Messages extends Public_Controller
{

	/**
	 * Constructor
	 *
	 * Load dependencies and template settings
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		parent::Public_Controller();
		
		$this->load->models(array('messages_m', 'messages_sent_m'));
		$this->load->helper('bbcode');
		$this->load->library('messages_lib');
		$this->lang->load('messages');
		
		$this->template->enable_parser_body(FALSE);

		// Set the unread messages count
		$this->data->unread = $this->messages_m->count_unread($this->user->id);

		// Add a link to the forum CSS into the head
		$this->template->append_metadata(js('bbcode.js', 'messages'));
		$this->template->append_metadata(js('messages.js', 'messages'));
		$this->template->append_metadata(js('jquery.autocomplete.min.js', 'messages'));
		$this->template->append_metadata(css('jquery.autocomplete.css', 'messages'));
		$this->template->set_breadcrumb('Home', '/');
		$this->template->set_breadcrumb('Messages', 'forums/messages');
	}

	/**
	 * Index
	 *
	 * Redirects to the inbox.
	 *
	 * @access	public
	 * @return	void
	 */
	public function index()
	{
		redirect('messages/inbox');
	}

	/**
	 * Inbox
	 *
	 * Shows user inbox messages
	 *
	 * @param	int	$offset Pagination offset
	 * @access	public
	 * @return	void
	 */
	public function inbox($action = 'list', $var1 = 0, $var2 = FALSE)
	{
		//If not logged in go to login page
		$this->ion_auth->logged_in() or redirect('users/login');

		switch ($action)
		{
			case 'list':
				$this->_list_inbox($var1);
				break;
			case 'view':
				$this->_view_inbox($var1);
				break;
			case 'delete':
				$this->_delete_inbox($var1, $var2);
				break;
			default:
				show_404();
		}
	}

	/**
	 * Sent
	 *
	 * Shows user sent messages
	 *
	 * @param	int	$offset Pagination offset
	 * @access	public
	 * @return	void
	 */
	public function sent($action = 'list', $var1 = 0, $var2 = FALSE)
	{
		//If not logged in go to login page
		$this->ion_auth->logged_in() or redirect('users/login');

		switch ($action)
		{
			case 'list':
				$this->_list_sent($var1);
				break;
			case 'view':
				$this->_view_sent($var1);
				break;
			case 'delete':
				$this->_delete_sent($var1, $var2);
				break;
			default:
				show_404();
		}

	}


	/**
	 * Compose
	 *
	 * Creates a new message
	 *
	 * @param	int	$to_id	Id of the recipient
	 * @access	public
	 * @return	void
	 */
	public function compose($to_id = 0)
	{
		//If not logged in go to login page
		$this->ion_auth->logged_in() or redirect('users/login');

		// Must have a to or 404
		(isset($to_id)) or show_404();

		$this->load->library('form_validation');

		$this->form_validation->set_rules('to', 'To', 'trim|xss_clean|strip_tags|required');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|xss_clean|strip_tags|required');
		$this->form_validation->set_rules('content', 'Message', 'trim|xss_clean|strip_tags|required');

		$message->subject = '';
		$message->content = '';
		// The form has been submitted one way or another
		if($this->input->post('submit') or $this->input->post('preview'))
		{
			if ($this->form_validation->run() === TRUE)
			{
				if( $this->input->post('submit') )
				{
					$message->from_id = $this->user->id;
					$message->to_id = $this->ion_auth_model->get_user_by_email($this->input->post('to'))->row()->id;
					$message->subject = $this->input->post('subject');
					$message->content = $this->input->post('content');
					$message->sent = now();

					$message->id = $this->messages_m->insert($message);
					$this->messages_sent_m->insert($message);
					$message->from = $this->user->first_name . ' ' . $this->user->last_name;

					if($message->id)
					{
						$this->messages_lib->notify($this->ion_auth_model->get_user($message->to_id)->row()->email, $message);

						redirect('messages');
					}

					else
					{
						show_error("Error sending message.");
					}
				}
				elseif( $this->input->post('preview') )
				{
					$this->data->show_preview = TRUE;

					$message->subject = set_value('subject');
					$message->content = set_value('content');
				}
			}
		}
		if($to_id)
		{
			$message->to =& $this->ion_auth_model->get_user($to_id)->row()->email;
		}
		else
		{
			$message->to = set_value('to');
		}

		$this->data->message =& $message;

		$this->data->bbcode_buttons = get_bbcode_buttons();

		$this->template->set_breadcrumb('New Message');
		$this->data->messages_body = $this->load->view('compose', $this->data, TRUE);
		$this->template->build('layouts/default', $this->data);
	}

	/**
	 * List Inbox
	 *
	 * Lists user's inbox
	 *
	 * @param	int	$offset	Pagination offset
	 * @access	private
	 * @return	void
	 */
	private function _list_inbox($offset)
	{
		// Pagination junk
		$per_page = '10';
		$pagination = create_pagination('messages/inbox', $this->messages_m->count_messages($this->user->id), $per_page, 3);
		if($offset < $per_page)
		{
			$offset = 0;
		}
		$pagination['offset'] = $offset;
		// End Pagination

		// If topic or forum do not exist then 404
		$messages = $this->messages_m->get_messages($this->user->id, $offset, $per_page);

		foreach($messages as &$msg)
		{
			$msg->to = $this->ion_auth_model->get_user($msg->to_id)->row();
			$msg->from = $this->ion_auth_model->get_user($msg->from_id)->row();
		}
		$this->data->messages =& $messages;
		$this->data->pagination = &$pagination;

		// Create page
		$this->template->title(lang('messages_inbox_title'));
		$this->template->set_breadcrumb(lang('messages_title'), 'messages');
		$this->template->set_breadcrumb(lang('messages_inbox_title'));
		$this->data->messages_body = $this->load->view('inbox', $this->data, TRUE);
		$this->template->build('layouts/default', $this->data);
	}
	/**
	 * View Inbox
	 *
	 * Shows the given message from the inbox
	 *
	 * @param	int	$message_id	Id of the message
	 * @access	privte
	 * @return	void
	 */
	private function _view_inbox($message_id = 0)
	{
		//If not logged in go to login page
		$this->ion_auth->logged_in() or redirect('users/login');

		//If it's an invalid message, show 404
		($message = $this->messages_m->get($message_id)) || show_404();

		//Redirect to login if this is another users message
		if(($this->user->id != $message->to_id) && ($this->user->id != $message->from_id))
		{
			$this->session->set_flashdata('error', 'You can not view other user messages.');
			redirect('messages/inbox');
		}

		//Get from and to user info
		$from = $this->ion_auth_model->get_user($message->from_id)->row();
		$to = $this->ion_auth_model->get_user($message->to_id)->row();

		// Set message as read
		$this->messages_m->mark_read($message_id);
		
		// Reduce total unread count by 1;
		$this->data->unread--;

		//Set template data
		$this->data->message =& $message;
		$this->data->from =& $from;
		$this->data->to =& $to;

		//Set breadcrumbs
		$this->template->set_breadcrumb($message->subject);

		//Show the template
		$this->data->messages_body = $this->load->view('view', $this->data, TRUE);
		$this->template->build('layouts/default', $this->data);
	}
	
	/**
	 * Delete Inbox
	 *
	 * Sends a message to the trash or permanently deletes it.
	 *
	 * @param	int		$message_id	Id of the message
	 * @param	bool	$permanent	Permanently delete message
	 * @access	private
	 * @return	void
	 */
	private function _delete_inbox($message_id, $permanent = FALSE)
	{
		$this->ion_auth->logged_in() or redirect('users/login');
		
		$message = $this->messages_m->get($message_id);

		// Chech if there is a forum with that ID
		($this->user->id == $message->to_id) or show_404();

		// Delete it permanently
		if($permanent)
		{
			$this->messages_m->delete($message_id);
			$this->session->set_flashdata('success', lang('messages_deleted_message'));

		}

		// Put it in the trash
		else
		{
			$this->messages_m->update($message_id, array('in_trash' => 1, 'trashed_on' => now()));
			$this->session->set_flashdata('success', lang('messages_trashed_message'));
		}

		if(strstr('messages/sent', $_SERVER['HTTP_REFERER']))
		{
			redirect('messages/sent');
		}
		else
		{
			redirect('messages/inbox');
		}
	}

	/**
	 * List Sent
	 *
	 * Lists user's sent
	 *
	 * @param	int	$offset	Pagination offset
	 * @access	private
	 * @return	void
	 */
	private function _list_sent($offset)
	{
		// Pagination junk
		$per_page = '10';
		$pagination = create_pagination('messages/sent', $this->messages_sent_m->count_messages($this->user->id), $per_page, 3);
		if($offset < $per_page)
		{
			$offset = 0;
		}
		$pagination['offset'] = $offset;
		// End Pagination

		// If topic or forum do not exist then 404
		$messages = $this->messages_sent_m->get_messages($this->user->id, $offset, $per_page);

		foreach($messages as &$msg)
		{
			$msg->to = $this->ion_auth_model->get_user($msg->to_id)->row();
			$msg->from = $this->ion_auth_model->get_user($msg->from_id)->row();
		}
		$this->data->messages =& $messages;
		$this->data->pagination = &$pagination;

		// Create page
		$this->template->title(lang('messages_sent_title'));
		$this->template->set_breadcrumb(lang('messages_title'), 'messages');
		$this->template->set_breadcrumb(lang('messages_sent_title'));
		$this->data->messages_body = $this->load->view('sent', $this->data, TRUE);
		$this->template->build('layouts/default', $this->data);
	}

	/**
	 * View Sent
	 *
	 * Shows the given sent message
	 *
	 * @param	int	$message_id	Id of the message
	 * @access	public
	 * @return	void
	 */
	private function _view_sent($message_id = 0)
	{
		//If it's an invalid message, show 404
		($message = $this->messages_sent_m->get($message_id)) || show_404();

		//Redirect to login if this is another users message
		if(($this->user->id != $message->to_id) && ($this->user->id != $message->from_id))
		{
			$this->session->set_flashdata('error', 'You can not view other user\'s messages.');
			redirect('messages/sent');
		}

		//Get from and to user info
		$from = $this->ion_auth_model->get_user($message->from_id)->row();
		$to = $this->ion_auth_model->get_user($message->to_id)->row();

		//Set template data
		$this->data->message =& $message;
		$this->data->from =& $from;
		$this->data->to =& $to;

		//Set breadcrumbs
		$this->template->set_breadcrumb($message->subject);

		//Show the template
		$this->data->messages_body = $this->load->view('view', $this->data, TRUE);
		$this->template->build('layouts/default', $this->data);
	}

	/**
	 * Delete Sent
	 *
	 * Deletes a sent message
	 *
	 * @param	int		$message_id	Id of the message
	 * @param	bool	$permanent	Permanently delete message
	 * @access	private
	 * @return	void
	 */
	private function _delete_sent($message_id, $permanent = FALSE)
	{
		$message = $this->messages_sent_m->get($message_id);

		// Chech if there is a forum with that ID
		($this->user->id == $message->from_id) or show_404();

		// Delete it permanently
		if($permanent)
		{
			$this->messages_sent_m->delete($message_id);
			$this->session->set_flashdata('success', lang('messages_deleted_message'));

		}

		// Put it in the trash
		else
		{
			$this->messages_sent_m->update($message_id, array('in_trash' => 1, 'trashed_on' => now()));
			$this->session->set_flashdata('success', lang('messages_trashed_message'));
		}

		redirect('messages/sent');
	}
}
?>