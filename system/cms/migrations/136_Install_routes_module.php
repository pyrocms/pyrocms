<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Addons\ModuleManager;

class Migration_Install_routes_module extends CI_Migration
{
    public function up()
    {
        // Install Routes if not installed
        if (! module_installed('routes')) {
            ModuleManager::install('routes', $is_core = true);
        }

        return true;
    }

    public function down()
    {
        return true;
    }
}