<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Comments
 * @category 	Module
 */
class Admin extends Admin_Controller {

	/**
	 * Array that contains the validation rules
	 * @access private
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
			'rules' => 'trim'
		),
		array(
			'field' => 'comment',
			'label' => 'lang:comments.send_label',
			'rules' => 'trim|required'
		),
	);

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
		// Only show is_active = 0 if we are moderating comments
		$base_where = array('comments.is_active' => (int) ! Settings::get('moderate_comments'));

		//capture active
		$base_where['comments.is_active'] = is_int($this->session->flashdata('is_active')) ? $this->session->flashdata('is_active') : $base_where['comments.is_active'];
		$base_where['comments.is_active'] = $this->input->post('f_active') ? (int) $this->input->post('f_active') : $base_where['comments.is_active'];

		//capture module slug
		$base_where = $this->input->post('module_slug') ? $base_where + array('module' => $this->input->post('module_slug')) : $base_where;

		// Create pagination links
		$total_rows = $this->comments_m->count_by($base_where);
		$pagination = create_pagination('admin/comments/index', $total_rows);

		$comments = $this->comments_m
			->limit($pagination['limit'])
			->order_by('comments.created_on', 'desc')
			->get_many_by($base_where);

		$content_title = $base_where['comments.is_active'] ? lang('comments.active_title') : lang('comments.inactive_title');

		$this->input->is_ajax_request() && $this->template->set_layout(FALSE);

		$module_list = $this->comments_m->get_slugs();

		$this->template
			->title($this->module_details['name'])
			->set_partial('filters', 'admin/partials/filters')
			->append_metadata( js('admin/filter.js') )
			->set('module_list',		$module_list)
			->set('content_title',		$content_title)
			->set('comments',			process_comment_items($comments))
			->set('comments_active',	$base_where['comments.is_active'])
			->set('pagination',			$pagination)
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
			if ($comment->user_id > 0)
			{
				$commenter['user_id'] = $this->input->post('user_id');
			}
			else
			{
				$commenter['name']	= $this->input->post('name');
				$commenter['email']	= $this->input->post('email');
			}

			$comment = array_merge($commenter, array(
				'comment' => $this->input->post('comment'),
				'website' => $this->input->post('website')
			));

			// Update the comment
			$this->comments_m->update($id, $comment)
				? $this->session->set_flashdata('success', lang('comments.edit_success'))
				: $this->session->set_flashdata('error', lang('comments.edit_error'));

			redirect('admin/comments');
		}

		// Loop through each rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== FALSE)
			{
				$comment->{$rule['field']} = $this->input->post($rule['field']);
			}
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('comments.edit_title'), $comment->id))
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->set('comment', $comment)
			->build('admin/form', $this->data);
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
				$this->comments_m->delete((int) $id);

				// Wipe cache for this model, the content has changed
				$this->pyrocache->delete('comment_m');
				$comments[] = $comment->id;
			}
		}

		// Some comments have been deleted
		if ( ! empty($comments))
		{
			(count($comments) == 1)
				? $this->session->set_flashdata('success', sprintf(lang('comments.delete_single_success'), $comments[0]))				/* Only deleting one comment */
				: $this->session->set_flashdata('success', sprintf(lang('comments.delete_multi_success'), implode(', #', $comments )));	/* Deleting multiple comments */
		}

		// For some reason, none of them were deleted
		else
		{
			$this->session->set_flashdata('error', lang('comments.delete_error'));
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
	public function approve($id = 0, $redirect = TRUE)
	{
		$id && $this->_do_action($id, 'approve');

		$redirect AND redirect('admin/comments');
	}

	/**
	 * Unapprove a comment
	 * @access public
	 * @param  mixed $ids		id or array of ids to process
	 * @param  bool $redirect	optional if a redirect should be done
	 * @return void
	 */
	public function unapprove($id = 0, $redirect = TRUE)
	{
		$id && $this->_do_action($id, 'unapprove');

		if ($redirect)
		{
			$this->session->set_flashdata('is_active', 1);

			redirect('admin/comments');
		}
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

		$this->session->set_flashdata(array($status => lang('comments.' . $action . '_' . $status . $multiple)));
	}

	public function preview($id = 0)
	{
		$this->data->comment = $this->comments_m->get($id);
		$this->template->set_layout(FALSE);
		$this->template->build('admin/preview', $this->data);
	}

}
