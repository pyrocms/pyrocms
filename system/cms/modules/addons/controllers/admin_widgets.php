<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Admin controller for the widgets module.
 *
 * @package   PyroCMS\Core\Modules\Addons\Controllers
 * @author    PyroCMS Dev Team
 * @copyright Copyright (c) 2012, PyroCMS LLC
 */
class Admin_Widgets extends Admin_Controller
{
    /**
     * The current active section
     *
     * @var string
     */
    protected $section = 'widgets';

    /**
     * Every time this controller is called it should:
     * - load the widgets and addons language files
     * - remove the view layout if the request is an AJAX request
     */
    public function __construct()
    {
        parent::__construct();

        $this->widgets = $this->widgetManager->getModel();

        $this->lang->load('addons');
        $this->lang->load('widgets');

        if ($this->input->is_ajax_request()) {
            $this->template->set_layout(false);
        }
    }

    /**
     * Index method
     * lists both enabled and disabled widgets
     */
    public function index()
    {
        $this->widgetManager->registerUnavailableWidgets();

        $widgets = $this->widgets->findAllInstalled();

        // Create the layout
        $this->template
            ->title($this->module_details['name'])
            ->set('widgets', $widgets)
            ->build('admin/widgets/index');
    }

    /**
     * Enable widget
     *
     * @param string $id       The id of the widget
     * @param bool   $redirect Optional if a redirect should be done
     */
    public function enable($id = null, $redirect = true)
    {
        $id and $this->doAction(array($id), 'enable');

        if ($redirect) {
            $this->session->set_flashdata('enabled', 0);

            redirect('admin/addons/widgets');
        }
    }

    /**
     * Disable widget
     *
     * @param string $id       The id of the widget
     * @param bool   $redirect Optional if a redirect should be done
     */
    public function disable($id = '', $redirect = true)
    {
        $id and $this->doAction(array($id), 'disable');

        // todo: Shouldn't there be a: $this->session->flashdata('disabled',0); as in the enable() above?
        $redirect and redirect('admin/addons/widgets');
    }

    /**
     * Do the actual work for enable/disable
     *
     * @param array  $ids    Id or array of Ids to process
     * @param string $action Action to take: maps to model
     */
    protected function doAction(array $ids, $action)
    {
        $ids = ( ! is_array($ids)) ? array($ids) : $ids;
        $multiple = (count($ids) > 1) ? '_mass' : null;

        $widgets = $this->widgets->findManyInId($ids);

        foreach ($widgets as $widget) {

            switch ($action) {
                case 'enable':
                    $widget->enable();
                    Events::trigger('widget_enabled', $widget);
                    break;

                case 'disable':
                    $widget->disable();
                    Events::trigger('widget_disabled', $widget);
            }
        }

        $this->session->set_flashdata(array('success' => lang('widgets:'.$action.'_success'.$multiple)));
    }

}
