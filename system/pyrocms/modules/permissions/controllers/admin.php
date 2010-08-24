<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
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

        $this->load->model('permissions_m');
        $this->load->model('groups/group_m');
        $this->load->helper('array');
        $this->lang->load('permissions');
        $this->lang->load('groups/group');
		$this->load->library('form_validation');

		// Validation rules
		$this->validation_rules = array(
			array(
				'field' => 'module',
				'label' => lang('perm_module_label'),
				'rules' => 'trim|required'
			),
			array(
				'field' => 'controller',
				'label' => lang('perm_controller_label'),
				'rules' => 'trim|required'
			),
			array(
				'field' => 'method',
				'label' => lang('perm_method_label'),
				'rules' => 'trim|required'
			),
			array(
				'field' => 'role_type',
				'label' => lang('perm_type_label'),
				'rules' => 'trim|required'
			),
			array(
				'field' => 'user_id',
				'label' => lang('perm_user_label'),
				'rules' => 'trim|numeric'
			),
			array(
				'field' => 'group_id',
				'label' => lang('perm_group_label'),
				'rules' => 'trim|numeric'
			),
		);

        // Get "roles" (like access levels)
        $this->data->groups 			= $this->group_m->get_all(array('except' => array('admin')));
        $this->data->groups_select 	= array_for_select($this->data->groups, 'id', 'name');
        $this->data->users 			= $this->users_m->get_all();
        $this->data->users_select 	= array_for_select($this->data->users, 'id', 'full_name');

        $modules 					= $this->modules_m->get_modules(array('is_backend' => true));
        $this->data->modules_select = array('*' => lang('perm_module_select_default')) + array_for_select($modules, 'slug', 'name');

        $this->template->append_metadata('
			<script type="text/javascript">
				var roleDeleteConfirm = "' . 			lang('perm_role_delete_confirm') 		. '";
				var permControllerSelectDefault = "' . 	lang('perm_controller_select_default') . '";
				var permMethodSelectDefault = "' . 		lang('perm_method_select_default') 	. '";
			</script>
		');

        $this->template->append_metadata( js('permissions.js', 'permissions') );
	    $this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
    }

    /**
     * Index methods, lists all permissions
	 * @access public
	 * @return void
     */
    public function index()
    {
        // Go through all the permission roles
        foreach($this->data->groups as $role)
        {
            //... and get rules for each one
            $this->data->rules[$role->name] = $this->permissions_m->get_rules(array('role' => $role->id));
        }

		// Loop through each user
        foreach($this->data->users as $user)
        {
            $this->data->rules[$user->id] = $this->permissions_m->get_rules(array('user_id' => $user->id));
        }

		// Render the view
        $this->template
        	->title($this->module_data['name'])
        	->build('admin/index', $this->data);
    }

	/**
	 * Create a new rules
	 * @access public
	 * @return void
	 */
    public function create()
    {
		// Add some extra rules
        if ($this->input->post('role_type') == 'user')
        {
			$this->validation_rules[4]['rules'] .= '|required';
        }
        else
        {
            $this->validation_rules[5]['rules'] .= '|required';
        }

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

		// Got validation?
        if ($this->form_validation->run())
        {
			// Try to create the new rule
            if($this->permissions_m->insert($_POST) > 0)
            {
                $this->session->set_flashdata('success', lang('perm_rule_add_success'));
            }
            else
            {
                $this->session->set_flashdata('error', lang('perm_rule_add_error'));
            }

			// Redirect
            redirect('admin/permissions');
        }

		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			$permission_rule->{$rule['field']} = set_value($rule['field']);
		}


        // Get controllers and methods arrays for selected values to populate ajax boxes
		$this->data->permission_rule 	=& $permission_rule;
        $this->data->controllers_select = array('*' => lang('perm_controller_select_default')) 	+ array_for_select($this->modules_m->get_module_controllers($this->validation_rules[0]));
        $this->data->methods_select 	= array('*' => lang('perm_method_select_default')) 		+ array_for_select($this->modules_m->get_module_controller_methods($this->validation_rules[0], $this->validation_rules[1]));
        $this->template
        	->title($this->module_data['name'],lang('perm_rule_add'))
        	->build('admin/form', $this->data);
    }

	/**
	 * Edit permission rules
	 *
	 * @access public
	 * @param int $id The ID of the rule to edit
	 * @return void
	 */
    public function edit($id = 0)
    {
		// Got ID?
        if ( empty($id) )
		{
			 redirect('admin/permissions');
		}

		// Get the permissions
        $permission_rule = $this->permissions_m->get_rule($id);

		if ( !$permission_rule )
        {
            $this->session->set_flashdata('error', lang('perm_rule_not_exist_error'));
            redirect('admin/permissions/create');
        }

		// Set some extra rules based on the role type
        if ( $this->input->post('role_type') == 'user' )
        {
			$this->validation_rules[4]['rules'] .= '|required';
        }
        else
        {
            $this->validation_rules[5]['rules'] .= '|required';
        }

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);

        if ($this->form_validation->run())
        {
            $this->permissions_m->update($id, $_POST);
            $this->session->set_flashdata('success', lang('perm_rule_save_success'));
            redirect('admin/permissions');
        }

		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			$permission_rule->{$rule['field']} = set_value($rule['field']);
		}

        // Get controllers and methods arrays for selected values to populate ajax boxes
        $this->data->permission_rule 		=& $permission_rule;
 		$this->data->controllers_select 	= array('*' => lang('perm_controller_select_default')) + array_for_select($this->modules_m->get_module_controllers($this->data->permission_rule->module));
        $this->data->methods_select 		= array('*' => lang('perm_method_select_default')) + array_for_select($this->modules_m->get_module_controller_methods($this->data->permission_rule->module, $this->data->permission_rule->controller));

        $this->template
        	->title($this->module_data['name'],lang('perm_rule_edit'))
        	->build('admin/form', $this->data);
    }

	/**
	 * Delete permission rules
	 *
	 * @access public
	 * @param int $id The ID of the rule
	 * @return void
	 */
    public function delete($id = 0)
    {
        // Delete one
        if ($id)
        {
            $this->permissions_m->delete($id);
        }

        // Delete multiple
        else
        {
            if ($this->input->post('delete'))
            {
                foreach(array_keys($this->input->post('delete')) as $id)
                {
                    $this->permissions_m->delete($id);
                }
            }
        }

        $this->session->set_flashdata('success', lang('perm_rule_delete_success'));
        redirect('admin/permissions');
    }

    // AJAX Callbacks
	// #TODO: Not sure how to document the 2 methods below. - Yorick
    function module_controllers($module = '')
    {
        $controllers = $this->modules_m->get_module_controllers($module);
        exit(json_encode($controllers));
    }

    function controller_methods($module = '', $controller = 'admin')
    {
        $methods = $this->modules_m->get_module_controller_methods($module, $controller);
        exit(json_encode($methods));
    }
}
