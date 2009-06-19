<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->model('permissions_m');		
		$this->load->helper('array');
		$this->lang->load('permissions');
		
		// Get Navigation Groups
		$this->data->roles = $this->permissions_m->getRoles(array('except'=>array('admin')));
		$this->data->roles_select = array_for_select($this->data->roles, 'id', 'title');		
		$modules = $this->modules_m->getModules(array('is_backend'=>true));
		$this->data->modules_select = array('*'=> lang('perm_module_select_default'))+array_for_select($modules, 'slug', 'name');
		
		$this->layout->extra_head('
			<script>
				var roleDeleteConfirm = "'.$this->lang->line('perm_role_delete_confirm').'";
				var permControllerSelectDefault = "'.$this->lang->line('perm_controller_select_default').'";
				var permMethodSelectDefault = "'.$this->lang->line('perm_method_select_default').'";
			</script>
		');	
			
		$this->layout->extra_head( js('permissions.js', 'permissions') );	
	}
	
	// Admin: List all permission rules
	function index()
	{	
		// Go through all the permission roles
		foreach($this->data->roles as $role)
		{
			//... and get rules for each one
			$this->data->rules[$role->abbrev] = $this->permissions_m->getRules(array('role' => $role->id));
		}	
					
		$this->layout->create('admin/index', $this->data);
	}
	
	// Admin: Create a new rule
	function create()
	{	
		$this->load->library('validation');
		$rules['module'] = 'trim|required';
		$rules['controller'] = 'trim|required';
		$rules['method'] = 'trim|required';
		$rules['permission_role_id'] = 'trim|numeric|required';
		$rules['user_id'] = 'trim';//|required';		
		$this->validation->set_rules($rules);		
		$fields['permission_role_id'] = 'Role';
		$this->validation->set_fields($fields);
		
		if ($this->validation->run())
		{		
			if ( $this->permissions_m->newRule($_POST) > 0 )
			{
				$this->session->set_flashdata('success', $this->lang->line('perm_rule_add_success'));		
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('perm_rule_add_error'));
			}
			redirect('admin/permissions/index');
		}
		
		foreach(array_keys($rules) as $field)
		{
			$this->data->permission_rule->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
		}
		
		// Get controllers and methods arrays for selected values to populate ajax boxes
		$this->data->controllers_select = array('*'=> $this->lang->line('perm_controller_select_default'))+array_for_select($this->modules_m->getControllers($this->validation->module));
		$this->data->methods_select = array('*'=> $this->lang->line('perm_method_select_default'))+array_for_select($this->modules_m->getMethods($this->validation->module, $this->validation->controller));
		
		$this->layout->create('admin/rules/form', $this->data);
	}
	
	// Admin: Edit a permission rule
	function edit($id = 0)
	{	
		if (empty($id)) redirect('admin/permissions/index');
		
		$this->data->permission_rule = $this->permissions_m->getRule( $id );
		if (!$this->data->permission_rule)
		{
			$this->session->set_flashdata('error', $this->lang->line('perm_rule_not_exist_error'));
			redirect('admin/permissions/create');
		}		
		
		$this->load->library('validation');
		$rules['module'] = 'trim|required';
		$rules['controller'] = 'trim|required';
		$rules['method'] = 'trim|required';
		$rules['permission_role_id'] = 'trim|numeric|required';
		$rules['user_id'] = 'trim';//|required';		
		
		$this->validation->set_rules($rules);		
		$fields['permission_role_id'] = 'Role';
		$this->validation->set_fields($fields);		
		
		if ($this->validation->run())
		{
			$this->permissions_m->updateRule($id, $_POST);
			$this->session->set_flashdata('success', $this->lang->line('perm_rule_save_success'));			
			redirect('admin/permissions/index');
		}
		
		foreach(array_keys($rules) as $field)
		{
			if(isset($_POST[$field])) $this->data->permission_rule->$field = $this->validation->$field;
		}
		
		// Get controllers and methods arrays for selected values to populate ajax boxes
		$this->data->controllers_select = array('*'=> $this->lang->line('perm_controller_select_default'))+array_for_select($this->modules_m->getControllers($this->data->permission_rule->module));
		$this->data->methods_select = array('*'=> $this->lang->line('perm_method_select_default'))+array_for_select($this->modules_m->getMethods($this->data->permission_rule->module, $this->data->permission_rule->controller));
		
		$this->layout->create('admin/rules/form', $this->data);
	}
	
	// Admin: Delete permission rules
	function delete($id = 0)
	{	
		// Delete one
		if($id)
		{
			$this->permissions_m->deleteRule($id);
		}	// Delete multiple
		else
		{
			if( $this->input->post('delete') )
			{
				foreach (array_keys($this->input->post('delete')) as $id)
				{
					$this->permissions_m->deleteRule($id);
				}
			}
		}		
		$this->session->set_flashdata('success', $this->lang->line('perm_rule_delete_success'));
		redirect('admin/permissions/index');
	}	
	
	// AJAX Callbacks	
	function module_controllers($module = '')
	{
		$controllers = $this->modules_m->getControllers($module);
		exit(json_encode($controllers));
	}
	
	function controller_methods($module = '', $controller = 'admin')
	{
		$methods = $this->modules_m->getMethods($module, $controller);
		exit(json_encode($methods));
	}
}
?>