<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends Public_Controller
{	
	function __construct()
	{
		parent::Public_Controller();
		$this->load->library('validation');
		$this->load->model('comments_m');
		$this->lang->load('comments');		
	}
	
	function create($module = 'home', $id = 0)
	{		
		$rules['name'] = 'trim';
		$rules['email'] = 'trim|valid_email';
		$rules['website'] = 'trim';
		$rules['comment'] = 'trim|required';
		
		if(!$this->user_lib->logged_in())
		{
			$rules['name'] .= '|required';
			$rules['email'] .= '|required';
		}
		
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		
		$comment = array(
			'comment' => $this->input->post('comment'),
			'website' => $this->input->post('website'),
			'module' => $module,
			'module_id' => $id,
		
			// If they are an admin, comments go straight through
			'is_active' => $this->user_lib->check_role('admin')
		);
		
		// Logged in? in which case, we already know their name and email
		if($this->user_lib->logged_in())
		{
			$comment['user_id'] = $this->data->user->id;
		}
		else
		{
			$comment['name'] = $this->input->post('name');
			$comment['email'] = $this->input->post('email');
		}
		
		// Validation Successful ------------------------------
		if ($this->validation->run())
		{
			$result = $this->_allow_comment($comment);
			
			// Run Akismet or the crazy CSS bot checker
			if($result['status'] == FALSE)
			{
				$this->session->set_flashdata('error', $result['message']);
			}
			
			else
			{
				// Save the comment
				if($this->comments_m->insert( $comment ))
				{
					if($this->settings->item('moderate_comments') || $this->user_lib->check_role('admin'))
					{
						$this->session->set_flashdata('success', lang('comments.add_success'));
					}
					
					else
					{
						$this->session->set_flashdata('success', lang('comments.add_approve'));
					}
				}
				
				else
				{
					$this->session->set_flashdata('error', lang('comments.add_error'));
				}
			}
		}
		
		// Validation Failed ------------------------------
		else
		{		
			$this->session->set_flashdata('comment', $comment );			
			$this->session->set_flashdata('error', $this->validation->error_string );
		}
		
		// If for some reason the post variable doesnt exist, just send to module main page
		$redirect_to = $this->input->post('redirect_to') ? $this->input->post('redirect_to') : $module;
		redirect($redirect_to);
	}
	
	
	function _allow_comment($comment)
	{
		// Dumb-check
		$this->load->library('user_agent');
		
		if($this->agent->is_robot())
		{
			return array('status' => FALSE, 'message' => "You are clearly a robot.");
		}
		
		// Sneaky bot-check
		if( $this->input->post('d0ntf1llth1s1n') )
		{
			return array('status' => FALSE, 'message' => "You are probably a robot.");
		}
		
		// Check Akismet if an API key exists
		if($this->settings->item('akismet_api_key'))
		{
			$this->load->library('akismet');
			
			$comment = array(
				'author'	=> $this->input->post('name'),
				'email'		=> $this->input->post('email'),
				'website'	=> $this->input->post('website'),
				'body'		=> $this->input->post('body')
			);
			
			$config = array(
				'blog_url' => BASE_URL,
				'api_key' => $this->settings->item('akismet_api_key'),
				'comment' => $comment
			);
			
			$this->akismet->init($config);
		
			if($this->akismet->is_spam())
			{
				return array('status' => FALSE, 'message' => 'Looks like this is spam, sorry dude.');
			}
			
			if($this->akismet->errors_exist())
			{
				return array('status' => FALSE, 'message' => implode('<br />', $this->akismet->get_errors()));
			}
		}

		// F**k knows, its probably fine...
		return array('status' => TRUE);
	}
}
?>