<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams\Field\FieldAssignmentModel;
use Pyro\Module\Streams\FieldType\FieldTypeManager;

/**
 * PyroStreams AJAX Controller
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Controllers
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Ajax extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // No matter what we don't show the profiler
        // in our AJAX calls.
        $this->output->enable_profiler(false);

        $this->error_message = 'invalid request';

        // We need this for all of the variable setups in
        // the Type library __construct
        $this->load->library('streams_core/Type');

        // Only AJAX gets through!
        if ( ! $this->input->is_ajax_request()) die($this->error_message);

           // You also need to be logged in
           if ( ! is_logged_in()) die($this->error_message);
    }

    // --------------------------------------------------------------------------

    /**
     * Get our build params
     *
     * Accessed via AJAX
     *
     * @return	void
     */
    public function build_parameters()
    {
        $type = $this->input->post('data');
        $namespace = $this->input->post('namespace');

        echo FieldTypeManager::buildParameters($type, $namespace);
    }

    // --------------------------------------------------------------------------

    /**
     * Update the field order
     *
     * Accessed via AJAX
     *
     * @return	void
     */
    public function update_field_order()
    {
        $this->_check_module_accessibility();

        $ids = explode(',', $this->input->post('order'));

        // Set the count by the offset for
        // paginated lists
        $order_count = $this->input->post('offset') + 1;

        foreach ($ids as $id) {

            FieldAssignmentModel::updateSortOrder($id, $order_count);

            ++$order_count;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Update the entries order
     *
     * Accessed via AJAX
     *
     * @return	void
     */
    public function ajax_entry_order_update()
    {
        $this->_check_module_accessibility();

        // Get the stream from the ID
        $this->load->model('streams_core/streams_m');
        $stream = $this->streams_m->get_stream($this->input->post('stream_id'));

        $ids = explode(',', $this->input->post('order'));

        // Set the count by the offset for
        // paginated lists
        $order_count = $this->input->post('offset')+1;

        foreach ($ids as $id) {
            ci()->pdb
                ->table($stream->stream_prefix.$stream->stream_slug)
                ->take(1)
                ->where('id', $id)
                ->update(array('ordering_count' => $order_count));

            ++$order_count;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Check for Module accessibility.
     *
     * This is really all we can do in 2.1/develop to allow non-admins
     * to re-order and access control panel streams functions. We
     * are basically checking to see if the current logged
     * in user has access to the module that
     * is calling the function via JS.
     *
     * @return 	mixed
     */
    private function _check_module_accessibility()
    {
        // We always let the admins in
        if (ci()->current_user->isSuperUser()) {
            return true;
        }

        // Get module slug
        $module = ci()->input->post('streams_module');

        if ( ! $module) die(ci()->error_message);

        ci()->load->library('encrypt');

        $module = ci()->encrypt->decode($module);

        if ( ! $module) die(ci()->error_message);

        // Do we have permission for this module?
        if ( ! ci()->current_user->hasAccess($module)) {
            die(ci()->error_message);
        }
    }

}
