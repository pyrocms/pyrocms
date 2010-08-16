<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Roles controller for the permissions module
 * 
 * @author Phil Sturgeon - PyroCMS Dev Team
 * @package PyroCMS
 * @subpackage Permissions Module
 * @category Modules
 *
 */
class Admin_roles extends Admin_Controller
{
	/**
	 * Validation rules
	 * @access private
	 * @var array
	 */
	private $validation_rules = array();
	
	/**
	 * Constructor method
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Load the required classes
		$this->load->model('permissions_m');
		$this->load->library('form_validation');
		$this->lang->load('permissions');
		
		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'title',
				'label' => lang('perm_title_label'),
				'rules' => 'trim|required|max_length[100]'
			),
			array(
				'field' => 'name',
				'label' => lang('perm_abbrev_label'),
				'rules' => 'trim|required|max_length[50]'
			),
		);

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
        
        $this->template->set_partial('sidebar', 'admin/sidebar');
	}
	
	/**
	 * Index method
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Redirect
		redirect('admin/permissions');
	}	
	
	/**
	 * Create a new permission role
	 * 
	 * @access public
	 * @return void
	 */
	public function create()
	{		
		// Valid data?
		if ($this->form_validation->run())
		{
			// Got update
			if ( $this->permissions_m->new_role($_POST) > 0 )
			{
				$this->session->set_flashdata('success', lang('perm_role_add_success'));			
			}
			else
			{
				$this->session->set_flashdata('error', lang('perm_role_add_error'));
			}
			
			// Redirect
			redirect('admin/permissions');
		}
		else
		{
			// Loop through each validation rule
			foreach($this->validation_rules as $rule)
			{
				$permission_role->{$rule['field']} = set_value($rule['field']);
			}
		}
		
		// Render the view
		$this->data->permission_role =& $permission_role;
		$this->template->build('admin/roles/form', $this->data);
	}	
	
	
	/**
	 * Edit a permission role
	 * 
	 * @access public
	 * @param int $id The ID of the permission to edit
	 * @return void
	 */
	public function edit($id = 0)
	{	
		// Got ID?
		if (empty($id)) redirect('admin/permissions');
		
		if ( !$permission_role = $this->permissions_m->get_role($id) ) 
		{
			$this->session->set_flashdata('error', $this->lang->line('perm_role_not_exist_error'));
			redirect('admin/permissions/roles/create');
		}
		
		// Got validation?
		if ( $this->form_validation->run() )
		{
			$this->permissions_m->update_role($id, $_POST);
			$this->session->set_flashdata('success', $this->lang->line('perm_role_save_success'));	
			
			// Redirect		
			redirect('admin/permissions');
		}
		else
		{
			// Loop through each validation rule
			foreach( $this->validation_rules as $rule )
			{
				// Ignore if there was no POST data specified
				if ( $this->input->post($rule['field']) !== FALSE )
				{
					$permission_role->{$rule['field']} = set_value($rule['field']);
				}
			}
		}
		
		// Render the view
		$this->data->permission_role =& $permission_role;
		$this->template->build('admin/roles/form', $this->data);
	}
	
	/**
	 * Delete permission role(s)
	 * 
	 * @access public
	 * @param int $id The ID of the permission to delete
	 * @return void
	 */
	public function delete($id = 0)
	{	
		// Delete one
		if($id)
		{
			$this->permissions_m->delete_role($id);
			$this->permissions_m->delete_rule(array('permission_role_id'=>$id));		
		}
		else // Delete multiple
		{
			foreach (array_keys($this->input->post('delete')) as $id)
			{
				$this->permissions_m->delete_role($id);
				$this->permissions_m->delete_rule(array('permission_role_id'=>$id));
			}
		}
		$this->session->set_flashdata('success', $this->lang->line('perm_role_delete_success'));
		redirect('admin/permissions');
	}
}