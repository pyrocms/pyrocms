<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Permissions controller
 *
 * @author 		Phil Sturgeon, Yorick Peterse - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Pages module
 * @category	Modules
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
    public function __construct()
    {
		// Call the parent's constructor
        parent::__construct();

        $this->load->model('permission_m');
        $this->load->model('groups/group_m');
        $this->lang->load('permissions');
        $this->lang->load('groups/group');
    }

    /**
     * Index methods, lists all permissions
	 * @access public
	 * @return void
     */
	public function index()
    {
    	$this->template->groups = $this->group_m->get_all();
    	
		// Render the view
        $this->template
        	->title($this->module_details['name'])
        	->build('admin/index', $this->data);
    }

	public function group($group_id)
    {
		$this->load->library('form_validation');

		if($_POST)
		{
			// register the user
        	$this->permission_m->save($group_id, $this->input->post('modules'));
			
			$this->session->set_flashdata('success', lang('permissions.message_group_saved'));

       		redirect('admin/permissions/group/'.$group_id);
		}

		$this->template->edit_permissions = $this->permission_m->get_group($group_id);

		$this->template->module_groups = $this->module_m->get_all(array('is_backend' => TRUE));
		$this->template->group = $this->group_m->get($group_id);

        $this->template->build('admin/group', $this->data);
    }
}