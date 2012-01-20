<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      PyroCMS Development Team
 * @package     PyroCMS
 * @subpackage  Controllers
 */
class Ajax extends MY_Controller
{
    public function url_title()
    {
        $this->load->helper('text');

        $slug = trim(url_title($this->input->post('title'), 'dash', TRUE), '-');

        $this->output->set_output($slug);
    }

}
