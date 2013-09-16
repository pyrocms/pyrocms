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
				'url'		=> 'admin/users/fields/edit/-assign_id-',
				'label'		=> $this->lang->line('global:edit')
			),
			array(
				'url'		=> 'admin/users/fields/delete/-assign_id-',
				'label'		=> $this->lang->line('global:delete'),
				'confirm'	=> true
			)
		);

//		$this->template->title(lang('user:profile_fields_label'));

/*		$this->streams->cp->assignments_table(
								'profiles',
								'users',
								Settings::get('records_per_page'),
								'admin/users/fields/index',
								true,
								array('buttons' => $buttons));*/

		Cp\Fields::assignmentsTable('profiles', 'users')
			->title(lang('user:profile_fields_label'))
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
		$extra['title'] 		= lang('streams:new_field');
		$extra['show_cancel'] 	= true;
		$extra['cancel_uri'] 	= 'admin/users/fields';

		$this->streams->cp->field_form('profiles', 'users', 'new', 'admin/users/fields', null, array(), true, $extra);
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
		if ( ! $this->streams->cp->teardown_assignment_field($assign_id)) {
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

		$extra['title'] 		= lang('streams:edit_field');
		$extra['show_cancel'] 	= true;
		$extra['cancel_uri'] 	= 'admin/users/fields';

		$this->streams->cp->field_form('profiles', 'users', 'edit', 'admin/users/fields', $assign_id, array(), true, $extra);
	}
}
