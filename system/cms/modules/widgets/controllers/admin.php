<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Pyro\Module\Addons\WidgetInstanceModel;

/**
 * Admin controller for widgets instances.
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Widgets\Controllers
 */
class Admin extends Admin_Controller
{
    /**
     * The current active section
     *
     * @var string
     */
    protected $section = 'instances';

    /**
     * Constructor method
     *
     * @return \Admin_instances
     */
    public function __construct()
    {
        parent::__construct();

        $this->lang->load('widgets');

        $this->widgets         = $this->widgetManager->getModel();
        $this->widgetAreas     = $this->widgetManager->getAreaModel();
        $this->widgetInstances = $this->widgetManager->getInstanceModel();

        if ($this->input->is_ajax_request()) {
            $this->template->set_layout(false);
        }

        $this->template
            ->append_js('module::widgets.js')
            ->append_css('module::widgets.css');
    }

    /**
     * Index method, lists all active widgets
     *
     * @return void
     */
    public function index()
    {
        // Find all available widgets
        $available_widgets = $this->widgets->findAllEnabledOrder();

        // Find areas, with instances and their widgets
        $areas = $this->widgetAreas->findAllWithInstances();

        $this->template
            ->title($this->module_details['name'])
            ->set('areas', $areas)
            ->set('available_widgets', $available_widgets)
            ->build('admin/index');
    }

    /**
     * List all available widgets
     *
     * @param str $slug The slug of the widget
     * @return void
     */
    public function ajax_instances($slug = null)
    {
        if (!$slug) {
            set_status_header(404);
            return;
        }

        $area = $this->widgetAreas->findBySlug($slug);

        $this->load->view('admin/ajax/instance/index', array('instances' => $area->instances));
    }

    /**
     * Create the form for a new widget instance
     *
     * @return void
     */
    public function create($slug = '')
    {
        if (!$slug) {
            set_status_header(404);
            return;
        }

        $widget = $this->widgetManager->get($slug);

        if (!$widget) {
            set_status_header(404);
            return;
        }


        // Empty, fresh and clean
        $instance = new WidgetInstanceModel;

        // Process the form
        if ($this->input->method() === 'post') {

            $instance->name           = $this->input->post('name');
            $instance->widget_id      = $this->input->post('widget_id');
            $instance->widget_area_id = $this->input->post('widget_area_id');

            $options = $this->input->post();
            unset($options['name'], $options['widget_id'], $options['widget_area_id']);

            $instance->options = $options;

            if ($this->widgetManager->validate($widget) and $instance->save()) {

                // Pass the widget instance to the widget_instance_created event
                Events::trigger('widget_instance_created', $instance);

                $status  = 'success';
                $message = lang('success_label');

            } else {
                $status  = 'error';
                $message = lang('error_label');
            }

            if ($this->input->is_ajax_request()) {

                $data = array();
                if ($status === 'success') {
                    $data['messages'][$status] = $message;
                }

                $message = $this->load->view('admin/partials/notices', $data, true);

                return $this->template->build_json(
                    array(
                        'status'  => $status,
                        'message' => $message,
                        'active'  => ($instance->area ? '#area-' . $instance->area->slug . ' header' : false)
                    )
                );
            }

            if ($status === 'success') {
                $this->session->set_flashdata($status, $message);
                redirect('admins/widgets');
                return;
            }

            $this->template->set('messages', array($status => $message));
        }

        // Use the Widget Manager to render HTML for the form
        $form = $this->widgetManager->renderBackend($widget, $instance);

        // Record, not the class file
        $widget_record = $this->widgets->findBySlug($slug);

        $this->template
            ->set('widget', $widget_record)
            ->set('form', $form)
            ->set('instance', $instance)
            ->build('admin/instances/form');
    }

    /**
     * Create the form for editing a widget instance
     *
     * @return void
     */
    public function edit($id = 0)
    {
        if (!($id and $widget = $this->widgets->find($id))) {
            // @todo: set error
            return false;
        }

        $data = array();

        if ($input = $this->input->post()) {

            $id        = $input['id'];
            $name      = $input['name'];
            $widget_id = $input['widget_id'];

            unset($input['id'], $input['name'], $input['widget_id']);

            $result = $this->widgetInstances
                ->whereId($id)
                ->update(
                    array(
                        'name'    => $name,
                        'options' => serialize($input),
                    )
                );

            if ($result) {
                // Fire an event. A widget instance has been updated pass the widget instance id.
                Events::trigger('widget_instance_updated', $id);

                $status  = 'success';
                $message = lang('success_label');

                $widget = $this->widgets->find($id);
                $area   = $this->widgetAreas->find($widget->widget_area_id);
            } else {
                $status  = 'error';
                $message = $result['error'];
            }

            if ($this->input->is_ajax_request()) {
                $data = array();

                $status === 'success' AND $data['messages'][$status] = $message;
                $message = $this->load->view('admin/partials/notices', $data, true);

                return $this->template->build_json(
                    array(
                        'status'  => $status,
                        'message' => $message,
                        'active'  => (isset($area) && $area ? '#area-' . $area->slug . ' header' : false)
                    )
                );
            }

            if ($status === 'success') {
                $this->session->set_flashdata($status, $message);
                redirect('admins/widgets');
                return;
            }

            $data['messages'][$status] = $message;
        }

        $this->db->order_by('`name`');

        $areas = $this->widgetAreas->findAll()->toArray();
        $areas = array_for_select($areas, 'id', 'name');

        $data['widget'] = $widget;
        $data['instance'] = $instance = $this->widgetInstances->find($id);
        $data['form']   = $this->widgetManager->renderBackend($this->widgetManager->get($widget->slug), $instance);

        $this->template->build('admin/instances/form', $data);
    }

    /**
     * Delete a widget instance
     *
     * @return void
     */
    public function delete($id = 0)
    {
        $instance = $this->widgetInstances->find($id);

        if ($instance and $instance->delete()) {

            // Fire an event. A widget instance has been deleted.
            Events::trigger('widget_instance_deleted', $id);

            $status  = 'success';
            $message = lang('success_label');
        } else {
            $status  = 'error';
            $message = lang('general_error_label');
        }

        if ($this->input->is_ajax_request()) {
            $data    = array('messages' => array($status => $message));
            $message = $this->load->view('admin/partials/notices', $data, true);

            return $this->template->build_json(
                array(
                    'status'  => $status,
                    'message' => $message
                )
            );
        }

        $this->session->set_flashdata($status, $message);
        redirect('admin/widgets');
    }

}
