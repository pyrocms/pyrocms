<?php

use Pyro\Module\Streams\Ui\FieldUi;

/**
 * Admin fields controller for the variables module
 *
 * @author		PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Variables\Controllers
 */
class Admin_fields extends Admin_Controller
{
    /**
     * Variable's ID
     *
     * @var		int
     */
    public $id = 0;

    public $section = 'fields';

    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct();

        $this->lang->load('variables/variables');

        $this->fieldsUi = new FieldUi;
    }

    /**
     * The selectable fields table
     */
    public function index()
    {
        $buttons = array(
            array(
                'label' => lang('global:edit'),
                'url' => 'admin/variables/fields/form/-field_id-'
            ),
            array(
                'label' => lang('global:delete'),
                'url' => 'admin/variables/fields/delete/-field_id-',
                'confirm' => true
            )
        );

        $this->fieldsUi->namespaceTable('variables')
            ->skips(array('name', 'syntax', 'data'))
            ->title(lang('variables:fields_title'))
            ->buttons($buttons)
            ->render();

    }

    /**
     * The field form that allows creating and configuring field instances
     */
    public function form($id = null)
    {
        if ($id) {
            $title = lang('streams:edit_field');
        } else {
            $title = lang('streams:add_field');
        }

        $this->fieldsUi->namespaceForm('variables', $id)->title($title)->render();
    }

    public function delete()
    {

    }
}
