<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comments controller (frontend)
 *
 * @author 		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Comments\Controllers
 */
class Comments extends Public_Controller
{

	/**
	 * An array containing the validation rules
	 * 
	 * @var array
	 */
	private $validation_rules = array(
		array(
			'field' => 'name',
			'label' => 'lang:comments.name_label',
			'rules' => 'trim'
		),
		array(
			'field' => 'email',
			'label' => 'lang:comments.email_label',
			'rules' => 'trim|valid_email'
		),
		array(
			'field' => 'website',
			'label' => 'lang:comments.website_label',
			'rules' => 'trim|max_length[255]'
		),
		array(
			'field' => 'comment',
			'label' => 'lang:comments.message_label',
			'rules' => 'trim|required'
		),
	);

	/**
	 * Constructor method
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');
		$this->load->model('comments_m');
		$this->lang->load('comments');
	}

	/**
	 * Create a new comment
	 *
	 * @param type $module The module that has a comment-able model.
	 * @param int $id The id for the respective comment-able model of a module.
	 */
	public function create($module = 'home', $id = 0)
	{
		// Set the comment data
		$comment = $_POST;

		// Logged in? in which case, we already know their name and email
		if ($this->ion_auth->logged_in())
		{
			$comment['user_id'] = $this->current_user->id;
			$comment['name'] = $this->current_user->display_name;
			$comment['email'] = $this->current_user->email;
			$comment['website'] = $this->current_user->website;
		}
		else
		{
			$this->validation_rules[0]['rules'] .= '|required';
			$this->validation_rules[1]['rules'] .= '|required';
		}

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		$comment['module'] = $module;
		$comment['module_id'] = $id;
		$comment['is_active'] = (bool) ((isset($this->current_user->group) && $this->current_user->group == 'admin') OR !$this->settings->moderate_comments);

		// Validate the results
		if ($this->form_validation->run())
		{
			// ALLOW ZEH COMMENTS!? >:D
			$result = $this->_allow_comment();

			foreach ($comment as &$data)
			{
				// Remove {pyro} tags and html
				$data = escape_tags($data);
			}

			// Run Akismet or the crazy CSS bot checker
			if ($result['status'] == FALSE)
			{
				$this->session->set_flashdata('comment', $comment);
				$this->session->set_flashdata('error', $result['message']);
			}
			else
			{
				// Save the comment
				if ($comment_id = $this->comments_m->insert($comment))
				{
					// Approve the comment straight away
					if (!$this->settings->moderate_comments OR (isset($this->current_user->group) && $this->current_user->group == 'admin'))
					{
						$this->session->set_flashdata('success', lang('comments.add_success'));

						// Add an event so third-party devs can hook on
						Events::trigger('comment_approved', $comment);
					}

					// Do we need to approve the comment?
					else
					{
						$this->session->set_flashdata('success', lang('comments.add_approve'));
					}

					$comment['comment_id'] = $comment_id;

					// If markdown is allowed we will parse the body for the email
					if (Settings::get('comment_markdown'))
					{
						$comment['comment'] = parse_markdown($comment['comment']);
					}

					// Send the notification email
					$this->_send_email($comment);
				}

				// Failed to add the comment
				else
				{
					$this->session->set_flashdata('error', lang('comments.add_error'));
				}
			}
		}

		// The validation has failed
		else
		{
			$this->session->set_flashdata('error', validation_errors());

			// Loop through each rule
			foreach ($this->validation_rules as $rule)
			{
				if ($this->input->post($rule['field']) !== FALSE)
				{
					$comment[$rule['field']] = escape_tags($this->input->post($rule['field']));
				}
			}
			$this->session->set_flashdata('comment', $comment);
		}

		// If for some reason the post variable doesnt exist, just send to module main page
		$redirect_to = $this->input->post('redirect_to') ? $this->input->post('redirect_to') : $module;

		if ($redirect_to == 'pages')
		{
			$redirect_to = 'home';
		}

		redirect($redirect_to);
	}

	/**
	 * Method to check whether we want to allow the comment or not
	 * 
	 * @return array
	 */
	private function _allow_comment()
	{
		// Dumb-check
		$this->load->library('user_agent');

		// Sneaky bot-check
		if ($this->agent->is_robot() OR $this->input->post('d0ntf1llth1s1n'))
		{
			return array('status' => FALSE, 'message' => 'You are probably a robot.');
		}

		// Check Akismet if an API key exists
		if ($this->settings->item('akismet_api_key'))
		{
			$this->load->library('akismet');

			$comment = array(
				'author' => $this->current_user ? $this->current_user->first_name.' '.$this->current_user->last_name : $this->input->post('name'),
				'email' => $this->current_user ? $this->current_user->email : $this->input->post('email'),
				'website' => $this->current_user ? $this->current_user->website : $this->input->post('website'),
				'body' => $this->input->post('body')
			);

			$config = array(
				'blog_url' => BASE_URL,
				'api_key' => $this->settings->item('akismet_api_key'),
				'comment' => $comment
			);

			$this->akismet->init($config);

			if ($this->akismet->is_spam())
			{
				return array('status' => FALSE, 'message' => 'Looks like this is spam. If you believe this is incorrect please contact the site administrator.');
			}

			if ($this->akismet->errors_exist())
			{
				return array('status' => FALSE, 'message' => implode('<br />', $this->akismet->get_errors()));
			}
		}

		// F**k knows, its probably fine...
		return array('status' => TRUE);
	}

	/**
	 * Send an email
	 *
	 * @param array $comment The comment data.
	 * @return boolean 
	 */
	private function _send_email($comment = array())
	{
		$this->load->library('email');
		$this->load->library('user_agent');

		// Add in some extra details
		$comment['slug'] = 'comments';
		$comment['sender_agent'] = $this->agent->browser().' '.$this->agent->version();
		$comment['sender_ip'] = $this->input->ip_address();
		$comment['sender_os'] = $this->agent->platform();
		$comment['redirect_url'] = anchor(ltrim($comment['redirect_to'], '/').'#'.$comment['comment_id']);
		$comment['reply-to'] = $comment['email'];

		//trigger the event
		return (bool) Events::trigger('email', $comment);
	}

}