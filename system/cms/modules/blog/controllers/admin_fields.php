<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Pyro\Module\Streams_core\Cp;
use Pyro\Module\Streams_core\Data;

/**
 * Admin Blog Fields
 *
 * Manage custom blogs fields for
 * your blog.
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Users\Controllers
 */
class Admin_fields extends Admin_Controller
{
	protected $section = 'fields';

	// --------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		// If they cannot administer profile fields,
		// then they can't access anythere here.
		role_or_die('users', 'admin_blog_fields');

		$this->load->driver('streams');
		$this->lang->load(array('blog', 'categories'));
	}

	// --------------------------------------------------------------------------

	/**
	 * List out profile fields
	 *
	 * @return 	void
	 */
	public function index()
	{
		$buttons = array(
			array(
				'url'		=> 'admin/blog/fields/edit/{{ id }}',
				'label'		=> $this->lang->line('global:edit'),
				'class'		=> 'btn-sm btn-success',
			),
			array(
				'url'		=> 'admin/blog/fields/delete/{{ id }}',
				'label'		=> $this->lang->line('global:delete'),
				'class'		=> 'btn-sm btn-danger',
				'confirm'	=> true,
			)
		);

		Cp\Fields::assignmentsTable('blog', 'blogs')
			->title(lang('global:custom_fields'))
			->addUri('admin/blog/fields/create')
			->pagination(Settings::get('records_per_page'), 'admin/blog/fields/index')
			->buttons($buttons)
			->render();
	}

	// --------------------------------------------------------------------------

	/**
	 * Create
	 *
	 * Create a new custom blog field
	 *
	 * @return 	void
	 */
	public function create()
	{
		Cp\Fields::assignmentForm('blog', 'blogs')
			->title(lang('streams:add_field'))
			->redirect('admin/blog/fields')
			->cancelUri('admin/blog/fields')
			->allowSetColumnTitle(false)
			->render();
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete
	 *
	 * Delete a custom blog profile field.
	 *
	 * @return 	void
	 */
	public function delete()
	{
		if ( ! $assign_id = $this->uri->segment(5)) {
			show_error(lang('streams:cannot_find_assign'));
		}

		// Tear down the assignment
		if ( ! $this->streams->cp->teardown_assignment_field($assign_id)) {
		    $this->session->set_flashdata('notice', lang('streams:field_delete_error'));
		} else {
		    $this->session->set_flashdata('success', lang('streams:field_delete_success'));
		}

		redirect('admin/blog/fields');
	}

	// --------------------------------------------------------------------------

	/**
	 * Edit a profile field
	 *
	 * @return 	void
	 */
	public function edit()
	{
		if ( ! $assign_id = $this->uri->segment(5)) {
			show_error(lang('streams:cannot_find_assign'));
		}

		$extra = array(
			'title'			=> lang('streams:edit_field'),
			'show_cancel'	=> true,
			'cancel_uri'	=> 'admin/blog/fields'
		);

		Cp\Fields::assignmentForm('blog', 'blogs', $this->uri->segment(5))
			->title(lang('streams:edit_field'))
			->redirect('admin/blog/fields')
			->cancelUri('admin/blog/fields')
			->allowSetColumnTitle(false)
			->render();
	}
}
