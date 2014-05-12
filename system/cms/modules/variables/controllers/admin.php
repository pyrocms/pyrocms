<?php

use Pyro\Module\Streams\Ui\EntryUi;
use Pyro\Module\Streams\FieldType\FieldTypeManager;
use Pyro\Module\Variables\Model\VariableEntryModel;

/**
 * Admin controller for the variables module
 *
 * @author        PyroCMS Dev Team
 * @package       PyroCMS\Core\Modules\Variables\Controllers
 */
class Admin extends Admin_Controller
{
    /**
     * Variable's ID
     *
     * @var        int
     */
    public $id = 0;

    /**
     * Section
     *
     * @var string
     */
    public $section = 'variables';

    /**
     * @var Pyro\Module\Variables\Model\VariableEntryModel
     */
    protected $variables;

    /**
     * @var Pyro\Module\Streams\EntryUi
     */
    protected $variablesUi;

    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct();

        $this->lang->load('variables/variables');

        $this->template->append_css('module::variables.css');

        $this->variables   = new VariableEntryModel;
        $this->variablesUi = new EntryUi;
    }

    /**
     * List all variables
     */
    public function index()
    {
        $buttons = array(
            array(
                'label' => lang('global:edit'),
                'url'   => 'admin/variables/edit/{{ id }}'
            ),
            array(
                'label'   => lang('global:delete'),
                'url'     => 'admin/variables/delete/{{ id }}',
                'confirm' => true
            ),
        );

        $form = $this->selectable_fields_form();

        $this->variablesUi->table($this->variables)
            ->fields(
                array(
                    'name',
                    'data'   => '{{ entry:data }} <span class="muted">{{ entry:data_field_slug }}</span>',
                    'syntax' => '<span class="syntax">&#123;&#123; variables:{{ entry:name }} &#125;&#125;</span>'
                )
            )
            ->title(lang('variables:name') . $form)
            ->buttons($buttons)
            ->filters(array('name'))
            ->pagination(Settings::get('records_per_page'), 'admin/variables')
            ->render();
    }

    /**
     * Generate a selectable fields form
     */
    private function selectable_fields_form($field_slug = null)
    {
        $stream = $this->variables->getStream();

        $field_type = FieldTypeManager::getType('field');

        $field_type->setStream($stream);

        $options = $field_type->getSelectableFields('variables');

        if (!$field_slug) {
            $unselected = array('---' => '---');

            $options = array_merge($unselected, $options);
        }

        $js = 'onchange="javascript:var field_slug = $(this).val(); if (field_slug != \'---\') { window.open(SITE_URL+\'admin/variables/create/\'+field_slug, \'_self\'); }"';

        return '<span class="variables-selectable-fields-form"><span>' . lang('streams:label.field') . '</span> ' . form_dropdown(
            'data',
            $options,
            $field_slug,
            $js
        ) . '</span>';
    }

    /**
     * Create a new variable
     */
    public function create($field_slug = null)
    {
        $form = $this->selectable_fields_form($field_slug);

        $extra['return'] = $extra['cancel_uri'] = 'admin/variables/edit/-id-';

        $defaults = array();

        // Override selected field
        if (is_string($field_slug)) {
            $defaults['data_field_slug'] = $field_slug;
        }

        $this->variablesUi->form($this->variables)
            ->title(lang('variables:create_title') . $form)
            ->defaults($defaults)
            ->skips(array('foo', 'bar'))
            ->messages(
                array(
                    'success' => lang('variables:add_success'),
                )
            )
            ->redirects('admin/variables')
            ->render();
    }

    /**
     * Edit an existing variable
     *
     * @param    int $id The ID of the variable
     */
    public function edit($id = null)
    {
        // From cancel_uri?
        if ($id == '-id-') {
            redirect(site_url('admin/variables'));
        }

        $variable = $this->variables->find($id);

        $form = $this->selectable_fields_form($variable->data_field_slug, '---', true);

        $this->variablesUi->form($variable)
            ->title('Edit ' . $form)
            ->messages(
                array(
                    'success' => sprintf(lang('variables:edit_success'), $variable->name),
                )
            )
            ->redirects('admin/variables')
            ->render();
    }

    /**
     * Delete an existing variable
     *
     * @param    int $id The ID of the variable
     */
    public function delete($id = null)
    {
        $variable = $this->variables->find($id);

        if ($variable and $variable->delete()) {
            $this->session->set_flashdata('success', sprintf(lang('variables:delete_success'), $variable->name));

            redirect('admin/variables');
        }
    }
}
