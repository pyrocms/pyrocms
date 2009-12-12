<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends Public_Controller
{	
	function __construct()
	{
		parent::Public_Controller();
		$this->load->plugin('captcha');
		$this->load->library('validation');
		$this->load->model('comments_m');
		$this->lang->load('comments');		
	}
	
	function create($module = 'home', $id = 0)
	{		
		$rules['name'] = 'trim';
		$rules['email'] = 'trim|valid_email';
		$rules['body'] = 'trim|required';
		
		if(!$this->user_lib->logged_in())
		{
			$rules['name'] .= '|required';
			$rules['email'] .= '|required';
		}
		
		if($this->settings->item('captcha_enabled') && !$this->user_lib->logged_in())
		{
			$rules['captcha'] = 'trim|required|callback__CheckCaptcha';
		}
		
		$this->validation->set_rules($rules);
		$this->validation->set_fields();
		
		// Validation Successful ------------------------------
		if ($this->validation->run())
		{		
			// Logged in? in which case, we already know their name and email
			if($this->user_lib->logged_in())
			{
				$commenter['user_id'] = $this->data->user->id;
			}
			else
			{
				$commenter['name'] = $this->input->post('name');
				$commenter['email'] = $this->input->post('email');
			}
			
			$comment = array_merge($commenter, array(
				'body'    => $this->input->post('body'),
				'module'   => $module,
				'module_id' => $id,
			
				// If they are an admin, comments go straight through
				'is_active' => $this->user_lib->check_role('admin')
			));
			
			if($this->comments_m->newComment( $comment ))
			{
				if($this->user_lib->check_role('admin'))
				{
					$this->session->set_flashdata('success', $this->lang->line('comment_add_success'));
				}
				
				else
				{
					$this->session->set_flashdata('success', $this->lang->line('comment_add_approve'));
				}
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('comment_add_error'));
			}			
		}
		
		// Validation Failed ------------------------------
		else
		{		
			if(!$this->user_lib->logged_in())
			{
				$comment['name'] = $this->input->post('name');
				$comment['email'] = $this->input->post('email');
			}
			
			$comment['body'] = $this->input->post('body');
			$this->session->set_flashdata('comment', $comment );			
			$this->session->set_flashdata('error', $this->validation->error_string );
		}
		
		// If for some reason the post variable doesnt exist, just send to module main page
		$redirect_to = $this->input->post('redirect_to') ? $this->input->post('redirect_to') : $module;
		redirect($redirect_to);
	}
	
	// Callback: from create()
	function _CheckCaptcha($title = '')
	{
		$captcha_id = $this->input->post('captcha_id');
		$captcha_word = $this->session->flashdata('captcha_'.$captcha_id);
		
		if ($captcha_word != $this->input->post('captcha'))
		{
			$this->validation->set_message('_CheckCaptcha', $this->lang->line('comment_capcha_error'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
?>