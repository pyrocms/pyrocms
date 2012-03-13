<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin User Fields
 *
 * Manage custom user fields.
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Users\Controllers
 */
class Admin_fields extends Admin_Controller {

	protected $section = 'fields';

	// --------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		$this->load->driver('streams');
	}

	// --------------------------------------------------------------------------
	
	/**
	 * List out profile fields
	 *
	 * @access 	public
	 * @return 	void
	 */
	function index()
	{
		$buttons = array(
			array(
				'url'		=> 'admin/users/fields/edit/-assign_id-', 
				'label'		=> $this->lang->line('user_edit_profile_field')
			)
		);

		$this->streams->cp->assignments_table(
								'profiles',
								'users',
								$this->settings->item('records_per_page'),
								'admin/users/fields/index',
								$buttons,
								true);
	}

	// --------------------------------------------------------------------------

	/**
	 * Create a new profile field
	 *
	 * @access 	public
	 * @return 	void
	 */
	function create()
	{
		$this->streams->cp->field_form('profiles', 'users', 'new', 'admin/users/fields', null, array(), true);
	}

	// --------------------------------------------------------------------------

	/**
	 * Delete a profile field
	 *
	 * @access 	public
	 * @return 	void
	 */
	function delete()
	{
	}

	// --------------------------------------------------------------------------

	/**
	 * Edit a profile field
	 *
	 * @access 	public
	 * @return 	void
	 */
	function edit()
	{
		if ( ! $assign_id = $this->uri->segment(5))
		{
			show_error('Unable to find assignment');
		}

		$this->streams->cp->field_form('profiles', 'users', 'edit', 'admin/users/fields', $assign_id, array(), true);
	}
}