<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Pyro\Module\Streams_core\Cp;

/**
 * Admin User Fields
 *
 * Manage custom user fields.
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Users\Controllers
 */
class Admin_fields extends Admin_Controller
{
	/**
	 * The current active section
	 *
	 * @var string
	 */
	protected $section = 'fields';

	// --------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		$this->load->driver('streams');

		$this->lang->load('group');

		// If they cannot administer profile fields,
		// then they can't access anythere here.
		role_or_die('users', 'admin_profile_fields');
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
				'url'		=> 'admin/users/fields/edit/{{id}}',
				'label'		=> lang('global:edit')
			),
			array(
				'url'		=> 'admin/users/fields/delete/{{id}}',
				'label'		=> lang('global:delete'),
				'confirm'	=> true
			)
		);

		Cp\Fields::assignmentsTable('profiles', 'users')
			->title(lang('user:profile_fields_label'))
			->pagination(Settings::get('records_per_page'), 'admin/users/fields/index')
			->buttons($buttons)
			->render();		
	}

	// --------------------------------------------------------------------------

	/**
	 * Create a new profile field
	 *
	 * @return 	void
	 */
	public function create()
	{
		// $extra['show_cancel'] 	= true;

		Cp\Fields::assignmentForm('profiles', 'users')
			->title(lang('streams:new_field'))
			->redirect('admin/users/fields')
			->render();
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete a profile field
	 *
	 * @return 	void
	 */
	public function delete()
	{
		if ( ! $assign_id = $this->uri->segment(5)) {
			show_error(lang('streams:cannot_find_assign'));
		}

		// Tear down the assignment
		if ( ! Data\Fields::teardownFieldAssignment($assign_id)) {
		    $this->session->set_flashdata('notice', lang('user:profile_delete_failure'));
		} else {
		    $this->session->set_flashdata('success', lang('user:profile_delete_success'));
		}

		redirect('admin/users/fields');
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

		//$extra['show_cancel'] 	= true;

		Cp\Fields::assignmentForm('profiles', 'users', $assign_id)
			->title(lang('streams:edit_field'))
			->redirect('admin/users/fields')
			->render();
	}
}
