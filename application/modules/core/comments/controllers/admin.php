<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		
		$this->load->library('validation');
		
		$this->load->model('comments_m');
		$this->lang->load('comments');
		
	    $this->template->set_partial('sidebar', 'admin/sidebar');
	}
	
	// Admin: List all comments
	public function index()
	{
		$this->load->helper('text');
		
		// Create pagination links
		$total_rows = $this->comments_m->count_by('is_active', 0);
		$this->data->pagination = create_pagination('admin/comments/index', $total_rows);
		
		// get all comments
		$this->data->comments = $this->comments_m->get_comments(array(
			'is_active' => 0,
			'limit' => $this->data->pagination['limit']			
		));
				
		$this->template->build('admin/index', $this->data);			
	}
	
	public function action()
	{
		if( $this->input->post('btnAction') )
		{
			// Get the action
			$id_array = $this->input->post('action_to');
			
			// Switch statement
			switch( strtolower( $this->input->post('btnAction') ) )
			{
				// Approve the comment
				case 'approve':
					// Loop through each ID
					foreach($id_array as $key => $value)
					{
						// Multiple ones ? 
						if(count($id_array) > 1)
						{
							$this->approve($value,FALSE,TRUE);
						}
						else
						{
							$this->approve($value,FALSE);
						}
					}
				break;
				// Unapprove the comment
				case 'unapprove':
					// Loop through each ID
					foreach($id_array as $key => $value)
					{
						// Multiple ones ? 
						if(count($id_array) > 1)
						{
							$this->unapprove($value,FALSE,TRUE);
						}
						else
						{
							$this->unapprove($value,FALSE);
						}
					}
				break;
				// Delete the comment
				case 'delete':
					$this->delete();
				break;
			}
			
			// Redirect
			redirect('admin/comments');
		}
		
	}
	
	public function active()
	{
		$this->load->helper('text');
		
		// Create pagination links
		$total_rows = $this->comments_m->count_by('is_active', 1);
		$this->data->pagination = create_pagination('admin/comments/active', $total_rows);
		
		// get all comments
		$this->data->comments = $this->comments_m->get_comments(array(
			'is_active' => 1,
			'limit' => $this->data->pagination['limit']				
		));

		$this->template->build('admin/index', $this->data);		
	}
		
	// Admin: Edit a comment
	public function edit($id = 0)
	{
		if (!$id)
		{
			redirect('admin/comments');
		}
				
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
		
		$comment = $this->comments_m->get($id);
		
		// Validation Successful ------------------------------
		if ($this->validation->run())
		{		
			if($comment->user_id > 0)
			{
				$commenter['user_id'] = $this->input->post('user_id');
			}
			else
			{
				$commenter['name'] = $this->input->post('name');
				$commenter['email'] = $this->input->post('email');
			}
			
			$comment = array_merge($commenter, array(
				'comment'    => $this->input->post('comment'),
				'website'    => $this->input->post('website'),
				'module'   => $this->input->post('module'),
				'module_id' => $this->input->post('module_id')
			));
			
			if($this->comments_m->update( $id, $comment ))
			{
				$this->session->set_flashdata( 'success', lang('comments.edit_success') );
			}
			else
			{
				$this->session->set_flashdata( 'error', lang('comments.edit_error') );
			}
			
			redirect('admin/comments');
		}		
		
		// Go through all the known fields and get the post values
		foreach(array_keys($rules) as $field)
		{
			if($this->input->post($field))
			{
				$comment->{$field} = $this->validation->$field;
			}
		}    	
		$this->data->comment =& $comment;
		
		// Load WYSIWYG editor
		$this->template->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->template->build('admin/form', $this->data);
	}	
		
	// Admin: Delete a comment
	public function delete($id = 0)
	{
		// Delete one
		$ids = ($id) ? array($id) : $this->input->post('action_to');
		
		// Go through the array of ids to delete
		$comments = array();
		foreach ($ids as $id)
		{
			// Get the current comment so we can grab the id too
			if($comment = $this->comments_m->get($id))
			{
				$this->comments_m->delete($id);
				
				// Wipe cache for this model, the content has changed
				$this->cache->delete('comment_m');				
				$comments[] = $comment->id;
			}
		}
		
		// Some comments have been deleted
		if(!empty($comments))
		{
			// Only deleting one comment
			if(count( $comments ) == 1)
			{
				$this->session->set_flashdata( 'success', sprintf(lang('comments.delete_single_success'), $comments[0]) );
			}			
			// Deleting multiple comments
			else
			{
				$this->session->set_flashdata( 'success', sprintf( lang('comments.delete_multi_success'), implode( ', #', $comments ) ) );
			}
		}
		
		// For some reason, none of them were deleted
		else
		{
			$this->session->set_flashdata( 'error', lang('comments.delete_error') );
		}
			
		redirect('admin/comments');
	}
	
	// Admin: activate a comment
	public function approve($id = 0, $redirect = TRUE, $multiple = FALSE)
	{
		if (!$id)
		{
			redirect('admin/comments');
		}
					
		if($this->comments_m->approve($id))
		{
			// Unapprove multiple comments ? 
			if($multiple == TRUE)
			{
				$this->session->set_flashdata( array('success'=> lang('comments.approve_success_multiple')));
			}
			else
			{
				$this->session->set_flashdata( array('success'=> lang('comments.approve_success')));
			}
		}
		
		else
		{
			// Error for multiple comments ? 
			if($multiple == TRUE)
			{
				$this->session->set_flashdata( array('error'=> lang('comments.approve_error_multiple')) );
			}
			else
			{
				$this->session->set_flashdata( array('error'=> lang('comments.approve_error')) );
			}
		}
		
		if($redirect == TRUE)
		{
			redirect('admin/comments');	
		}		
	}
	
	// Admin: deativate a comment
	public function unapprove($id = 0,$redirect = TRUE,$multiple = FALSE)
	{
		if (!$id)
		{
			redirect('admin/comments');
		}
					
		if($this->comments_m->unapprove($id))
		{
			// Unapprove multiple comments ? 
			if($multiple == TRUE)
			{
				$this->session->set_flashdata( array('success'=> lang('comments.unapprove_success_multiple')) );
			}
			
			else
			{
				$this->session->set_flashdata( array('success'=> lang('comments.unapprove_success')) );	
			}			
		}
		
		else
		{
			// Error for multiple comments ? 
			if($multiple == TRUE)
			{
				$this->session->set_flashdata( array('error'=> lang('comments.unapprove_error_multiple')) );
			}
			
			else
			{
				$this->session->set_flashdata( array('error'=> lang('comments.unapprove_error')) );
			}
		}
		
		if($redirect == TRUE)
		{
			redirect('admin/comments');	
		}
	}
	
	public function preview($id = 0)
	{		
		$this->data->comment = $this->comments_m->get($id);
		$this->template->set_layout(FALSE);
		$this->template->build('admin/preview', $this->data);
	}
}

?>