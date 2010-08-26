<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Permissions AJAX controller
 *
 * @author 		Phil Sturgeon - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Pages module
 * @category	Modules
 */
class Ajax extends Admin_Controller
{
    // AJAX Callbacks
    function module_controllers($module = '')
    {
        $controllers = $this->modules_m->get_module_controllers($module);
        exit(json_encode($controllers));
    }

    function controller_methods($module = '', $controller = 'admin')
    {
        $methods = $this->modules_m->get_module_controller_methods($module, $controller);
        exit(json_encode($methods));
    }
}
