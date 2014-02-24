<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams\FieldType\FieldTypeManager;
use Illuminate\Support\Str;

/**
 * PyroStreams Public AJAX Controller
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Controllers
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Public_ajax extends Public_Controller
{
    public function __construct()
    {
        parent::__construct();

        // We need this for all of the variable setups in
        // the Type library __construct
        $this->load->library('Type');

        // Only AJAX gets through!
           if ( ! $this->input->is_ajax_request()) {
               die('Must be an ajax request.');
           }
    }

    // --------------------------------------------------------------------------

    /**
     * Fieldtype AJAX Function
     *
     * Accessed via AJAX
     *
     * @return	void
     */
    public function field()
    {
        $segments = $this->uri->segment_array();

        if ( ! isset($segments[4]) or ! isset($segments[5])) {
            exit('Field class or method not found.');
        }

        $field_type 	= $segments[4];
        $method 		= $segments[5];
        $params			= array_slice($segments, 5);

        // Is this a valid field type?
        if ( ! $type = FieldTypeManager::getType($field_type)) {
            exit('Invalid Field Type.');
        }

        // We prefix all ajax functions with ajax_
        $method = Str::studly('ajax_'.$method);

        // Does the method exist?
        if (method_exists($type, $method)) {
            exit(call_user_func_array(array($type, $method), $params));
        }

        exit("Method '{$method}' not found.");
    }

}
