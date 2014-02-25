<?php

use Pyro\Module\Keywords\Model\Keyword;

/**
 * Maintain a central list of keywords to label and organize your content.
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Keywords\Controllers
 *
 */
class Admin extends Admin_Controller
{
    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct();

        // Load the required classes
        $this->load->library('form_validation');

        $this->lang->load('keywords');

        // Validation rules
        $this->validation_rules = array(
            array(
                'field' => 'name',
                'label' => lang('keywords:name'),
                'rules' => 'trim|required|max_length[50]|strtolower|unique[keywords.name]'
            ),
        );
    }

    /**
     * Create a new keyword
     *
     * @return  void
     */
    public function index()
    {
        $keywords = Keyword::findAndSortByName();

        $this->template
            ->title($this->module_details['name'])
            ->set('keywords', $keywords)
            ->build('admin/index');
    }

    /**
     * Create a new keyword
     *
     * @return void
     */
    public function add()
    {
        $keyword = new Keyword();

        $this->form_validation->set_rules($this->validation_rules);

        if ($this->form_validation->run()) {

            $name = $this->input->post('name');

            if ($result = Keyword::create(array('name' => $name))) {
                // Fire an event. A new keyword has been added.
                Events::trigger('keyword_created', $result);

                $this->session->set_flashdata('success', sprintf(lang('keywords:add_success'), $name));
            } else {
                $this->session->set_flashdata('error', sprintf(lang('keywords:add_error'), $name));
            }

            redirect('admin/keywords');
        }

        // Loop through each validation rule
        foreach ($this->validation_rules as $rule) {
            $keyword->{$rule['field']} = set_value($rule['field']);
        }

        $this->template
            ->title($this->module_details['name'], lang('keywords:add_title'))
            ->set('keyword', $keyword)
            ->build('admin/form');
    }

    /**
     * Edit a keyword
     *
     * @param int $id The ID of the keyword to edit
     *
     * @return void
     */
    public function edit($id = 0)
    {
        $keyword = Keyword::find($id);

        // Make sure we found something
        $keyword or redirect('admin/keywords');

        $this->form_validation->set_rules($this->validation_rules);

        if ($this->form_validation->run()) {

            $keyword->name = $this->input->post('name');

            if ($keyword->save()) {
                // Fire an event. A keyword has been updated.
                Events::trigger('keyword_updated', $keyword);
                $this->session->set_flashdata('success', sprintf(lang('keywords:edit_success'), $keyword->name));
            } else {
                $this->session->set_flashdata('error', sprintf(lang('keywords:edit_error'), $keyword->name));
            }

            redirect('admin/keywords');
        }

        $this->template
            ->title($this->module_details['name'], sprintf(lang('keywords:edit_title'), $keyword->name))
            ->set('keyword', $keyword)
            ->build('admin/form');
    }

    /**
     * Delete keyword role(s)
     *
     * @param int $id The ID of the keyword to delete
     *
     * @return void
     */
    public function delete($id = 0)
    {
        if ($result = Keyword::find($id)->delete()) {
            // Fire an event. A keyword has been deleted.
            Events::trigger('keyword_deleted', $result);
            $this->session->set_flashdata('success', lang('keywords:delete_success'));
        } else {
            $this->session->set_flashdata('error', lang('keywords:delete_error'));
        }

        redirect('admin/keywords');
    }

    /**
     * AJAX Autocomplete
     *
     * @return void Returns nothing; instead it outputs a JSON string of keywords
     */
    public function autocomplete()
    {
        echo Keyword::findLikeTerm($this->input->get('term'))->toJson();
    }
}
