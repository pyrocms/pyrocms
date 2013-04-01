<?php

use Pyro\Module\Redirects\Model\Redirect;

/**
 * Cms controller for the redirects module
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Redirects\Controllers
 */
class Admin extends Admin_Controller
{
    /**
     * Array containing the validation rules.
     *
     * @var array
     */
    protected $validation_rules = array(
        array(
            'field' => 'type',
            'label' => 'lang:redirects:type',
            'rules' => 'trim|required|integer'
        ),
        'from' => array(
            'field' => 'from',
            'label' => 'lang:redirects:from',
            'rules' => 'trim|required|max_length[250]|callback__check_unique'
        ),
        array(
            'field' => 'to',
            'label' => 'lang:redirects:to',
            'rules' => 'trim|required|max_length[250]'
        )
    );

    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct();

        // Load the required classes
        $this->load->library('form_validation');
        $this->lang->load('redirects');
    }

    /**
     * List all redirects
     */
    public function index()
    {
        // Create pagination links
        $total_rows = Redirect::all()->count();
        $this->template->pagination = create_pagination('admin/redirects/index', $total_rows);
        // Using this data, get the relevant results
        $this->template->redirects = Redirect::skip($this->template->pagination['offset'])->take($this->template->pagination['limit'])->get();
        $this->template->build('admin/index');
    }

    /**
     * Create a new redirect
     */
    public function add()
    {
        $redirect = new Redirect;

        $this->form_validation->set_rules($this->validation_rules);

        // Got validation?
        if ($this->form_validation->run()) {

            $result = Redirect::create(array(
                'type' => $this->input->post('type'),
                'from' => $this->input->post('from'),
                'to' => $this->input->post('to')
            ));

            if ($result) {
                $this->session->set_flashdata('success', lang('redirects:add_success'));

                Events::trigger('redirect_created');
            } else {
                $this->session->set_flashdata('error', lang('redirects:add_error'));
            }

            redirect('admin/redirects');
        }

        // Loop through each validation rule
        foreach ($this->validation_rules as $rule) {
            $redirect->{$rule['field']} = set_value($rule['field']);
        }

        $this->template
            ->title($this->module_details['name'], lang('redirects:list_title'))
            ->set('redirect', $redirect)
            ->build('admin/form');
    }

    /**
     * Edit an existing redirect
     *
     * @param int $id The ID of the redirect
     *
     * @return void
     */
    public function edit($id = 0)
    {
        // Got ID?
        $id or redirect('admin/redirects');

        // Get the redirect
        $redirect = Redirect::find($id);

        $this->form_validation->set_rules(array_merge($this->validation_rules, array(
            'from' => array(
                'field' => 'from',
                'label' => 'lang:redirects:from',
                'rules' => 'trim|required|max_length[250]|callback__check_unique['.$id.']'
            )
        )));

        if ($this->form_validation->run()) {
            $redirect->type = $this->input->post('type');
            $redirect->from = $this->input->post('from');
            $redirect->to = $this->input->post('to');

            if ($redirect->save()) {
                $this->session->set_flashdata('success', $this->lang->line('redirects:edit_success'));

                Events::trigger('redirect_updated', $id);

                redirect('admin/redirects');
            } else {
                $this->session->set_flashdata('error', $this->lang->line('redirects:edit_error'));
            }
        }

        $this->template
            ->set('redirect', $redirect)
            ->build('admin/form');
    }

    /**
     * Delete an existing redirect
     *
     * @param int $id The ID of the redirect
     *
     * @return void
     */
    public function delete($id = 0)
    {
        $id_array = (! empty($id)) ? array($id) : $this->input->post('action_to');

        // Delete multiple
        if (! empty($id_array)) {
            $deleted = 0;
            $to_delete = 0;
            foreach ($id_array as $id) {
                if (Redirect::find($id)->delete()) {
                    $deleted++;
                } else {
                    $this->session->set_flashdata('error', sprintf($this->lang->line('redirects:mass_delete_error'), $id));
                }
                $to_delete++;
            }

            if ($deleted > 0) {
                $this->session->set_flashdata('success', sprintf($this->lang->line('redirects:mass_delete_success'), $deleted, $to_delete));
            }

            Events::trigger('redirect_deleted', $id_array);
        } else {
            $this->session->set_flashdata('error', $this->lang->line('redirects:no_select_error'));
        }

        redirect('admin/redirects');
    }

    /**
     * Callback method for validating the redirect's name
     *
     * @param  string $from
     * @return bool
     */
    public function _check_unique($from, $id = null)
    {
        if ( ! Redirect::findByFromAndId($from, $id)) {
            return true;
        }

        $this->form_validation->set_message('_check_unique', sprintf(lang('redirects:request_conflict_error'), $from));
        return false;
    }
}
