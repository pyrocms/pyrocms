<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->library('validation');
		$this->load->model('comments_m');
		$this->lang->load('comments');	
	}
	
	// Admin: List all comments
	public function index()
	{
		$this->load->helper('text');
		// Create pagination links
		$total_rows = $this->comments_m->countComments(array('is_active' => 0));
		$this->data->pagination = create_pagination('admin/comments/index', $total_rows);
		
		// get all comments
		$this->data->comments = $this->comments_m->getComments(array(
			'is_active' => 0,
			'limit' => $this->data->pagination['limit']			
		));
				
		$this->data->active_comments = FALSE;
		$this->layout->create('admin/index', $this->data);			
	}
	
	public function active()
	{
		$this->load->helper('text');
		// Create pagination links
		$total_rows = $this->comments_m->countComments(array('is_active' => 1));
		$this->data->pagination = create_pagination('admin/comments/active', $total_rows);
		
		// Get a list of all modules
		$modules = $this->comments_m->getUsedModules();
		
		// get all comments
		$this->data->comments = $this->comments_m->getComments(array(
			'is_active' => 1,
			'limit' => $this->data->pagination['limit']				
		));

		$this->data->modules = $modules + array('module' => 'all');
		$this->data->active_comments = TRUE;
		$this->layout->create('admin/index', $this->data);		
	}
		
	// Admin: Edit a comment
	public function edit($id = 0)
	{
		if (!$id) redirect('admin/comments/index');
				
		$rules['name'] = 'trim';
		$rules['email'] = 'trim|valid_email';
		$rules['body'] = 'trim|required';
		
		if(!$this->user_lib->logged_in())
		{
			$rules['name'] .= '|required';
			$rules['email'] .= '|required';
		}
		
		$this->validation->set_rules($rules);
		$this->validation->set_fields();		
		
		$comment = $this->comments_m->getComment($id);
		
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
				'body'    => $this->input->post('body'),
				'module'   => $this->input->post('module'),
				'module_id' => $this->input->post('module_id')
			));
			
			if($this->comments_m->updateComment( $comment, $id ))
			{
				$this->session->set_flashdata( 'success', $this->lang->line('comments_edit_success') );
			}
			else
			{
				$this->session->set_flashdata( 'error', $this->lang->line('comments_edit_error') );
			}
			
			redirect('admin/comments/index');
		}		
		
		// Go through all the known fields and get the post values
		foreach(array_keys($rules) as $field)
		{
			if(isset($_POST[$field])) $comment->$field = $this->validation->$field;
		}    	
		$this->data->comment =& $comment;
		
		// Load WYSIWYG editor
		$this->layout->extra_head( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->layout->create('admin/form', $this->data);
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
			if($comment = $this->comments_m->getComment($id))
			{
				$this->comments_m->deleteComment($id);
				
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
				$this->session->set_flashdata( 'success', sprintf($this->lang->line('comments_delete_single_success'), $comments[0]) );
			}			
			// Deleting multiple comments
			else
			{
				$this->session->set_flashdata( 'success', sprintf( $this->lang->line('comments_delete_multi_success'), implode( ', #', $comments ) ) );
			}
		}
		
		// For some reason, none of them were deleted
		else
		{
			$this->session->set_flashdata( 'error', $this->lang->line('comments_delete_error') );
		}
			
		redirect('admin/comments/index');
	}
	
	// Admin: activate a comment
	public function approve($id = 0)
	{
		if (!$id) redirect('admin/comments/index');
					
		if($this->comments_m->approveComment($id, 1))
		{
			$this->session->set_flashdata( array('success'=> $this->lang->line('comment_approve_success')) );
		}
		else
		{
			$this->session->set_flashdata( array('error'=> $this->lang->line('comment_approve_error')) );
		}
		redirect('admin/comments/index');	
	}
	
	// Admin: deativate a comment
	public function unapprove($id = 0)
	{
		if (!$id) redirect('admin/comments/index');
					
		if($this->comments_m->approveComment($id, 0))
		{
			$this->session->set_flashdata( array('success'=> $this->lang->line('comment_unapprove_success')) );
		}
		else
		{
			$this->session->set_flashdata( array('error'=> $this->lang->line('comment_unapprove_error')) );
		}
		redirect('admin/comments/index');	
	}
	
	public function preview($id = 0)
	{		
		$this->data->comment = $this->comments_m->getComment($id);
		$this->layout->wrapper(FALSE);
		$this->layout->create('admin/preview', $this->data);
	}
}

?>