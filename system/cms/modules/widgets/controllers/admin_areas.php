<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Pyro\Module\Addons\WidgetAreaModel;

/**
 * Admin controller for adding and managing widget areas.
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Widgets\Controllers
 *
 */
class Admin_areas extends Admin_Controller
{
    /**
     * The current active section
     *
     * @var string
     */
    protected $section = 'areas';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->lang->load('widgets');

        $this->widgets = $this->widgetManager->getModel();
        $this->widgetAreas = $this->widgetManager->getAreaModel();

        if ($this->input->is_ajax_request()) {
            $this->template->set_layout(false);
        }

        $this->template
            ->append_js('module::widgets.js')
            ->append_css('module::widgets.css');
    }

    public function index()
    {
        $areas = $this->widgetAreas->findAllWithInstances();

        // Create the layout
        return $this->template
            ->title($this->module_details['name'])
            ->set('areas', $areas)
            ->build('admin/areas/index', null, $this->method !== 'index');
    }

    /**
     * Add a new widget area
     *
     * @return void
     */
    public function create()
    {
        $area = new WidgetAreaModel;

        if ($this->input->method() === 'post') {

            $area->name = $this->input->post('name');
            $area->slug = $this->input->post('slug');

            if ($area->save()) {

                // Fire an event. A widget area has been created.
                Events::trigger('widget_area_created', $area);

                $status     = 'success';
                $message    = lang('success_label');
            } else {
                $status     = 'error';
                $message    = lang('error_label');
            }

            if ($this->input->is_ajax_request()) {
                $data = array('messages' => array($status => $message));
                $message = $this->load->view('admin/partials/notices', $data, true);

                return $this->template->build_json(array(
                    'status'    => $status,
                    'message'   => $message,
                    'html'      => ($status === 'success' ? $this->index() : null),
                    'active'    => (isset($area) && $area ? '#area-' . $area->slug . ' header' : false)
                ));
            }

            if ($status === 'success') {
                $this->session->set_flashdata($status, $message);

                redirect('admin/widgets/areas');
            }

            $this->template->set('messages', array($status => $message));

        } elseif (validation_errors()) {
            if ($this->input->is_ajax_request()) {
                $status     = 'error';
                $message    = $this->load->view('admin/partials/notices', array(), true);

                return $this->template->build_json(array(
                    'status'    => $status,
                    'message'   => $message
                ));
            }
        }

        $this->template
            ->set('area', $area)
            ->build('admin/areas/form');
    }

    /**
     * Edit widget area
     *
     * @param int ID of the widget area to edit
     * @return void
     */
    public function edit($slug = null)
    {
        if (! ($slug and $area = $this->widgetAreas->findBySlug($slug))) {
            // @todo: set error
            return false;
        }

        if ($this->input->method() === 'post') {

            $area->name = $this->input->post('name');
            $area->slug = $this->input->post('slug');

            if ($area->save()) {

                // Fire an event. A widget area has been updated.
                Events::trigger('widget_area_updated', $area);

                $status     = 'success';
                $message    = lang('success_label');
            } else {
                $status     = 'error';
                $message    = lang('general_error_label');
            }

            if ($this->input->is_ajax_request()) {
                $data = array('messages' => array($status => $message));
                $message = $this->load->view('admin/partials/notices', $data, true);

                return $this->template->build_json(array(
                    'status'    => $status,
                    'message'   => $message,
                    'html'      => ($status === 'success' ? $this->index() : null),
                    'active'    => "#area-{$area->slug} header"
                ));
            }

            if ($status === 'success') {
                $this->session->set_flashdata($status, $message);
                redirect('admim/widgets/areas');
            }

            $this->template->set('messages', array($status => $message));

        } elseif (validation_errors()) {
            if ($this->input->is_ajax_request()) {
                $status     = 'error';
                $message    = $this->load->view('admin/partials/notices', array(), true);

                return $this->template->build_json(array(
                    'status'    => $status,
                    'message'   => $message
                ));
            }
        }

        $this->template
            ->set('area', $area)
            ->build('admin/areas/form');
    }

    /**
     * Delete an existing widget area
     *
     * @return void
     */
    public function delete($id = 0)
    {
        $area = $this->widgetAreas->find($id);

        if ($area->delete()) {
            // Fire an event. A widget area has been deleted.
            Events::trigger('widget_area_deleted', $id);

            $status = 'success';
            $message = lang('success_label');
        } else {
            $status = 'error';
            $message = lang('general_error_label');
        }

        if ($this->input->is_ajax_request()) {
            $data = array('messages' => array($status => $message));
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
