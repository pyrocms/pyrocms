<?php

use Pyro\Module\Users\Model\Group;

/**
 * Roles controller for the groups module
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Users\Controllers
 *
 */
class Admin_groups extends Admin_Controller
{
    /**
     * The current active section
     *
     * @var string
     */
    protected $section = 'groups';

    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct();

        // Load the required classes
        $this->load->library('form_validation');

        $this->lang->load(array('group', 'permissions'));

        // Validation rules
        $this->validation_rules = array(
            array(
                'field' => 'name',
                'label' => lang('users:groups:name'),
                'rules' => 'trim|required|max_length[100]',
            ),
            array(
                'field' => 'description',
                'label' => lang('users:groups:description'),
                'rules' => 'trim|required|max_length[250]',
            )
        );
    }

    /**
     * Create a new group role
     */
    public function index()
    {
        $groups = Group::all();

        $this->template
            ->title($this->module_details['name'])
            ->set('groups', $groups)
            ->build('admin/groups/index');
    }

    /**
     * Create a new group role
     */
    public function add()
    {
        $group = new Group;

        if ($_POST) {
            $this->form_validation->set_rules($this->validation_rules);

            if ($this->form_validation->run()) {

                $group->name = $this->input->post('name');
                $group->description = $this->input->post('description');


                // Save permissions
                $new_perms = array();
                $roles = $this->input->post('module_roles');

                if ($modules = $this->input->post('modules')) {
                    foreach ($this->input->post('modules') as $module) {
                        if (isset($roles[$module]) and is_array($roles[$module])) {
                            foreach ($roles[$module] as $role) {
                                $new_perms["{$module}.{$role}"] = 1;
                            }
                        } else {
                            $new_perms["{$module}.general"] = 1;
                        }
                    }
                }

                $group->permissions = $new_perms;


                if ($group->save()) {
                    // Fire an event. A new group has been created.
                    Events::trigger('group_created', $group);

                    $this->session->set_flashdata('success', sprintf(lang('users:groups:add_success'), $group->name));
                } else {
                    $this->session->set_flashdata('error', sprintf(lang('users:groups:add_error'), $group->name));
                }

                redirect('admin/users/groups');
            }
        }

        // Loop through each validation rule
        foreach ($this->validation_rules as $rule) {
            $group->{$rule['field']} = set_value($rule['field']);
        }

        $this->template
            ->title($this->module_details['name'], lang('users:groups:add_title'))
            ->set('group', $group)
            ->set('modules', $this->get_modules_and_permissions())
            ->build('admin/groups/form');
    }

    /**
     * Edit a group role
     *
     * @param int $id The id of the group
     */
    public function edit($id = 0)
    {
        $group = Group::find($id);

        // Make sure we found something
        $group or redirect('admin/users/groups');

        if ($_POST) {

            $this->form_validation->set_rules($this->validation_rules);

            if ($this->form_validation->run()) {

                if (! in_array($group->name, array('admin', 'user'))) {
                    $group->name = $this->input->post('name');
                }
                $group->description = $this->input->post('description');

                // Save permissions
                $new_perms = array();
                $roles = $this->input->post('module_roles');

                if ($modules = $this->input->post('modules')) {
                    foreach ($this->input->post('modules') as $module) {
                        if (isset($roles[$module]) and is_array($roles[$module])) {
                            foreach ($roles[$module] as $role) {
                                $new_perms["{$module}.{$role}"] = 1;
                            }
                        } else {
                            $new_perms["{$module}.general"] = 1;
                        }
                    }
                }

                // Out with the old
                unset($group->permissions);

                // In with the new
                $group->permissions = $new_perms;

                if ($group->save()) {
                    // Fire an event. A group has been updated.
                    Events::trigger('group_updated', $group);
                    $this->session->set_flashdata('success', sprintf(lang('users:groups:edit_success'), $group->name));
                } else {
                    $this->session->set_flashdata('error', sprintf(lang('users:groups:edit_error'), $group->name));
                }

                redirect('admin/users/groups');
            }
        }

        $this->template
            ->title($this->module_details['name'], sprintf(lang('users:groups:edit_title'), $group->name))
            ->append_js('module::group.js')
            ->set('group', $group)
            ->set('modules', $this->get_modules_and_permissions())
            ->build('admin/groups/form');
    }

    /**
     * Delete group role(s)
     *
     * @param int $id The id of the group.
     */
    public function delete($id = 0)
    {
        if (Group::find($id)->delete()) {
            // Fire an event. A group has been deleted.
            Events::trigger('group_deleted', $id);

            $this->session->set_flashdata('success', lang('users:groups:delete_success'));
        } else {
            $this->session->set_flashdata('error', lang('users:groups:delete_error'));
        }

        redirect('admin/users/groups');
    }

    private function get_modules_and_permissions()
    {
        $modules = $this->moduleManager->getAll(array('is_backend' => true, 'installed' => true));

        foreach ($modules as &$module) {
            $module['roles'] = $this->moduleManager->roles($module['slug']);
        }

        return $modules;
    }
}
