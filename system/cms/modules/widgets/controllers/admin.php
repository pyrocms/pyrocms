<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for widgets instances.
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Widgets\Controllers
 *
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

        $this->widgets = $this->widgetManager->getModel();
        $this->widgetAreas = $this->widgetManager->getAreaModel();
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
            ->name($this->module_details['name'])
            ->set('widget_areas', $areas)
            ->set('available_widgets', $available_widgets)
            ->build('admin/index');
    }

    /**
     * List all available widgets
     *
     * @param str $slug The slug of the widget
     * @return void
     */
    public function ajax_instances($slug = '')
    {
        $widgets = $this->widgets->list_area_instances($slug);

        $this->load->view('admin/ajax/instance/index', array('widgets' => $widgets));
    }

    /**
     * Create the form for a new widget instance
     *
     * @return void
     */
    public function create($slug = '')
    {
        if ( ! ($slug and $widget = $this->widgets->findBySlug($slug))) {
            set_status_header(404);
            return;
        }

        $data = array();

        if ($input = $this->input->post()) {

            $name           = $input['name'];
            $widget_id      = $input['widget_id'];
            $widget_area_id = $input['widget_area_id'];

            $options = array_diff(array('name' => 1, 'widget_id' => 1, 'widget_area_id' => 1), $input);

            // Create the widget with basic info
            $instance = $this->widgets->create(compact('name', 'widget_id', 'widget_area_id', 'options'));

            if ($result['status'] === 'success') {
                // Fire an event. A widget instance has been created. pass the widget id
                Events::trigger('widget_instance_created', $widget_id);

                $status     = 'success';
                $message    = lang('success_label');

                $area = $this->widgets->get_area($widget_area_id);
            } else {
                $status     = 'error';
                $message    = $result['error'];
            }

            if ($this->input->is_ajax_request()) {
                $data = array();

                $status === 'success' AND $data['messages'][$status] = $message;
                $message = $this->load->view('admin/partials/notices', $data, true);

                return $this->template->build_json(array(
                    'status'    => $status,
                    'message'   => $message,
                    'active'    => (isset($area) && $area ? '#area-' . $area->slug . ' header' : false)
                ));
            }

            if ($status === 'success') {
                $this->session->set_flashdata($status, $message);
                redirect('admins/widgets');
                return;
            }

            $data['messages'][$status] = $message;
        }

        // Use the Widget Manager to render HTML for the form
        $form = $this->widgetManager->renderBackend($widget, $instance);

        $this->template
            ->set('widget', $widget)
            ->set('form', $form)
            ->build('admin/instances/form', $data);
    }

    /**
     * Create the form for editing a widget instance
     *
     * @return void
     */
    public function edit($id = 0)
    {
        if ( ! ($id && $widget = $this->widgets->find($id))) {
            // @todo: set error
            return false;
        }

        $data = array();

        if ($input = $this->input->post()) {
            $name          = $input['name'];
            $widget_id      = $input['widget_id'];
            $widget_area_id = $input['widget_area_id'];
            $instance_id    = $input['widget_instance_id'];

            unset($input['name'], $input['widget_id'], $input['widget_area_id'], $input['widget_instance_id']);

            $result = $this->widgets->edit_instance($instance_id, $name, $widget_area_id, $input);

            if ($result['status'] === 'success') {
                // Fire an event. A widget instance has been updated pass the widget instance id.
                Events::trigger('widget_instance_updated', $instance_id);

                $status     = 'success';
                $message    = lang('success_label');

                $area = $this->widgets->get_area($widget_area_id);
            } else {
                $status     = 'error';
                $message    = $result['error'];
            }

            if ($this->input->is_ajax_request()) {
                $data = array();

                $status === 'success' AND $data['messages'][$status] = $message;
                $message = $this->load->view('admin/partials/notices', $data, true);

                return $this->template->build_json(array(
                    'status'    => $status,
                    'message'   => $message,
                    'active'    => (isset($area) && $area ? '#area-' . $area->slug . ' header' : false)
                ));
            }

            if ($status === 'success') {
                $this->session->set_flashdata($status, $message);
                redirect('admins/widgets');
                return;
            }

            $data['messages'][$status] = $message;
        }

        $this->db->order_by('`name`');

        $areas = $this->widgets->list_areas();
        $areas = array_for_select($areas, 'id', 'name');

        $data['widget'] = $widget;
        $data['form']   = $this->widgets->render_backend($widget->slug, isset($widget->options) ? $widget->options : array());

        $this->template->build('admin/instances/form', $data);
    }

    /**
     * Delete a widget instance
     *
     * @return void
     */
    public function delete($id = 0)
    {
        if ($this->widgets->delete_instance($id)) {
            // Fire an event. A widget instance has been deleted.
            Events::trigger('widget_instance_deleted', $id);

            $status = 'success';
            $message = lang('success_label');
        } else {
            $status = 'error';
            $message = lang('general_error_label');
        }

        if ($this->input->is_ajax_request()) {
            $data = array();

            $data['messages'][$status] = $message;
            $message = $this->load->view('admin/partials/notices', $data, true);

            return $this->template->build_json(array(
                'status'    => $status,
                'message'   => $message
            ));
        }

        $this->session->set_flashdata($status, $message);
        redirect('admin/widgets');
    }

}
