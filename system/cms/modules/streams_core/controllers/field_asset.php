<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams\FieldTypeManager;

/**
 * PyroStreams Field Asset Controller
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Controllers
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_asset extends Public_Controller
{
    /**
     * The field type for the
     * field asset.
     *
     * @var		object
     */
    public $field_type;

    // --------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // Turn off the OP for these assets.
        $this->output->enable_profiler(false);

        $this->load->helper('file');
    }

    // --------------------------------------------------------------------------

    /**
     * Remap based on URL call
     */
    public function _remap($method)
    {
        // Check the type
        $type = $this->uri->segment(4);

        $this->field_type = FieldTypeManager::getType($type);

        // Check the file
        $file = $this->uri->segment(5);

        if (trim($file) == '') return null;

        $file = $this->security->sanitize_filename($file);

        // Call the method
        if ($method == 'css') {
            $this->_css($file);
        } elseif ($method == 'js') {
            $this->_js($file);
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Pull CSS
     *
     * @param	string - css file name
     * @return void
     */
    private function _css($file)
    {
        header("Content-Type: text/css");

        $file = $this->field_type->path_css.$file;

            if ( ! is_file($file)) return null;

        echo read_file($file);
    }

      // --------------------------------------------------------------------------

    /**
     * Pull JS
     *
     * @param	string - css file name
     * @return void
     */
    private function _js($file)
    {
        header("Content-Type: text/javascript");

        $file = $this->field_type->path_js.$file;

            if ( ! is_file($file)) return null;

        echo read_file($file);
    }

}
