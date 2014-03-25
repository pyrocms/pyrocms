<?php

use Pyro\Module\Templates\Model\TemplateEntryModel;
use Pyro\Module\Templates\Ui\TemplateEntryUi;

/**
 * Email Templates Admin Controller
 *
 * @author  Ryan Thompson - PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Templates\Controllers
 */
class Admin extends Admin_Controller
{
    /**
     * Create a new Admin instance
     */
    public function __construct()
    {
        parent::__construct();

        $this->lang->load('templates');

        $this->ui        = new TemplateEntryUi();
        $this->templates = new TemplateEntryModel();
    }

    /**
     * Display available templates
     */
    public function index()
    {
        $this->ui->table($this->templates)->render();
    }

    /**
     *  Create an email template
     */
    public function create()
    {
        $this->ui->form($this->templates)->render();
    }

    /**
     * Edit an email template
     *
     * @param bool $id
     */
    public function edit($id = false)
    {
        $template = $this->templates->find($id);

        if ($template->is_default) {
            $this->ui->skips(
                array(
                    'name',
                    'slug',
                    'description',
                )
            );
        }

        $this->ui->form($this->templates, $id)->render();
    }

    /**
     * Delete, but we will not allow deletion of default templates
     *
     * @param   int $id
     * @return  void
     */
    public function delete($id)
    {
        $template = $this->templates->find($id);

        if (!$template->is_defualt and $template->delete()) {
            ci()->session->set_flashdata('success', lang('templates:single_delete_success'));
        } else {
            ci()->session->set_flashdata('error', lang('templates:default_delete_error'));
        }

        redirect('admin/templates');
    }

    /**
     * Preview how your templates may be rendered
     *
     * @param bool|int $id
     * @return  void
     */
    public function preview($id = false)
    {
        $email_template = TemplateEntryModel::find($id);

        $this->template
            ->set_layout('modal')
            ->build('admin/preview', array('email_template' => $email_template));
    }

    /**
     * Takes an existing template as a template.  Usefull for creating a template
     * for another language
     *
     * @param bool|int $id
     * @return  void
     */
    public function create_copy($id = false)
    {
        $id = (int)$id;

        //we will need this later after the form submission
        $copy = TemplateEntryModel::find($id);

        //unset the id and is_default from $copy we don't need or want them anymore
        unset($copy->id);
        unset($copy->is_default);

        //lets get all variations of this template so we can remove the lang options
        $existing = TemplateEntryModel::findBySlug($copy->slug);

        $lang_options = $this->template->lang_options;

        if (!empty($existing)) {
            foreach ($existing as $tpl) {
                unset($lang_options[$tpl->lang]);
            }
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules($this->_clone_rules);

        if ($this->form_validation->run()) {
            // insert stuff to db
            $copy->lang = $this->input->post('lang');

            if ($new_id = TemplateEntryModel::insert($copy->toArray())) {
                // Fire the "created" event here also.
                Events::trigger('email_template_created');

                $this->session->set_flashdata('success', sprintf(lang('templates:tmpl_clone_success'), $copy->name));
                redirect('admin/templates/edit/' . $new_id);
            } else {
                $this->session->set_flashdata('error', sprintf(lang('templates:tmpl_clone_error'), $copy->name));
            }

            redirect('admin/templates');
        }

        $this->template
            ->set('lang_options', $lang_options)
            ->set('template_name', $copy->name)
            ->build('admin/copy');
    }

}
