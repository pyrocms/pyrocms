<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Comments
 * @category 	Module
 **/
class Admin extends Admin_Controller
{
	/**
	 * Array that contains the validation rules
	 * @access private
	 * @var array
	 */
	private $validation_rules = array();

	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent constructor
		parent::Admin_Controller();

		// Load the required libraries, models, etc
		$this->load->library('form_validation');
		$this->load->model('comments_m');
		$this->lang->load('comments');

		// Set the validation rules
		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label'	=> lang('comments.name_label'),
				'rules'	=> 'trim'
			),
			array(
				'field'	=> 'email',
				'label' => lang('comments.email_label'),
				'rules'	=> 'trim|valid_email'
			),
			array(
				'field'	=> 'website',
				'label' => lang('comments.website_label'),
				'rules'	=> 'trim'
			),
			array(
				'field'	=> 'comment',
				'label' => lang('comments.send_label'),
				'rules'	=> 'trim|required'
			),
		);

	    $this->template->set_partial('shortcuts', 'admin/partials/shortcuts');

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
	}

	/**
	 * Index
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// If we are moderating comments, show unmoderated comments
		$this->approved();
	}

	public function unapproved()
	{
		// Create pagination links
		$total_rows = $this->comments_m->count_by('is_active', 0);
		$pagination = create_pagination('admin/comments/unapproved', $total_rows);

		// get all comments
		$comments = $this->comments_m
			->limit($pagination['limit'])
			->order_by('comments.created_on', 'desc')
			->get_many_by('comments.is_active', 0);

		$this->template
			->title($this->module_details['name'])
			->set('comments', process_comment_items($comments))
			->set('pagination', $pagination)
			->build('admin/index');
	}

	/**
	 * Displays active comments
	 * @access public
	 * @return void
	 */
	public function approved()
	{
		// Create pagination links
		$total_rows = $this->comments_m->count_by('is_active', 1);
		$pagination = create_pagination('admin/comments/approved', $total_rows);

		// get all comments
		$comments = $this->comments_m
			->limit($pagination['limit'])
			->order_by('comments.created_on', 'desc')
			->get_many_by('comments.is_active', 1);

		$this->template
			->title($this->module_details['name'])
			->set('comments', process_comment_items($comments))
			->set('pagination', $pagination)
			->build('admin/index');
	}

	/**
	 * Action method, called whenever the user submits the form
	 * @access public
	 * @return void
	 */
	public function action()
	{
		$action = strtolower($this->input->post('btnAction'));
		
		if ($action)
		{
			// Get the id('s)
			$id_array = $this->input->post('action_to');

			// Call the action we want to do
			if (method_exists($this, $action))
			{
				$this->{$action}($id_array);
			}
		}

		redirect('admin/comments');
	}

	/**
	 * Edit an existing comment
	 * @access public
	 * @return void
	 */
	public function edit($id = 0)
	{
		$id OR redirect('admin/comments');

		// Get the comment based on the ID
		$comment = $this->comments_m->get($id);

		// Validate the results
		if ($this->form_validation->run())
		{
			if($comment->user_id > 0)
			{
				$commenter['user_id'] 	= $this->input->post('user_id');
			}
			else
			{
				$commenter['name'] 		= $this->input->post('name');
				$commenter['email'] 	= $this->input->post('email');
			}

			$comment = array_merge($commenter, array(
				'comment'    	=> $this->input->post('comment'),
				'website'    	=> $this->input->post('website'),
				'module'   		=> $this->input->post('module'),
				'module_id' 	=> $this->input->post('module_id')
			));

			// Update the comment
			if($this->comments_m->update($id, $comment))
			{
				$this->session->set_flashdata('success', lang('comments.edit_success'));
			}
			else
			{
				$this->session->set_flashdata('error', lang('comments.edit_error'));
			}

			// Redirect the user
			redirect('admin/comments');
		}

		// Loop through each rule
		foreach($this->validation_rules as $rule)
		{
			if($this->input->post($rule['field']) !== FALSE)
			{
				$comment->{$rule['field']} = $this->input->post($rule['field']);
			}
		}

		$this->data->comment =& $comment;

		// Load WYSIWYG editor
		$this->template
			->title($this->module_details['name'], lang('comments.edit_title'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );
		$this->template->build('admin/form', $this->data);
	}

	// Admin: Delete a comment
	public function delete($ids)
	{
		// Check for one
		$ids = ( ! is_array($ids)) ? array($ids) : $ids;

		// Go through the array of ids to delete
		$comments = array();
		foreach ($ids as $id)
		{
			// Get the current comment so we can grab the id too
			if ($comment = $this->comments_m->get($id))
			{
				$this->comments_m->delete( (int) $id);

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

	/**
	 * Approve a comment
	 * @access public
	 * @param  mixed $ids		id or array of ids to process
	 * @param  bool $redirect	optional if a redirect should be done
	 * @return void
	 */
	public function approve($id, $redirect = TRUE)
	{
		$this->_do_action($id, 'approve');

		if ($redirect == TRUE) redirect('admin/comments');
	}

	/**
	 * Unapprove a comment
	 * @access public
	 * @param  mixed $ids		id or array of ids to process
	 * @param  bool $redirect	optional if a redirect should be done
	 * @return void
	 */
	public function unapprove($id, $redirect = TRUE)
	{
		$this->_do_action($id, 'unapprove');

		if ($redirect == TRUE) redirect('admin/comments');
	}

	/**
	 * Do the actual work for approve/unapprove
	 * @access protected
	 * @param  int|array $ids	id or array of ids to process
	 * @param  string $action	action to take: maps to model
	 * @return void
	 */
	protected function _do_action($ids, $action)
	{
		$ids		= ( ! is_array($ids)) ? array($ids) : $ids;
		$multiple	= (count($ids) > 1) ? '_multiple' : NULL;
		$status		= 'success';

		foreach ($ids as $id)
		{
			if ( ! $this->comments_m->{$action}($id))
			{
				$status = 'error';
				break;
			}
		}

		$this->session->set_flashdata( array($status=> lang('comments.'.$action.'_'.$status.$multiple)));
	}

	public function preview($id = 0)
	{
		$this->data->comment = $this->comments_m->get($id);
		$this->template->set_layout(FALSE);
		$this->template->build('admin/preview', $this->data);
	}
}
