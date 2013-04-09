<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Disable_registration extends CI_Migration
{
    public function up()
    {
        $this->load->model('settings/setting_m');

        if ( ! $this->setting_m->get('enable_registration')) {
            $this->setting_m->insert(
                array(
                    'slug'          => 'enable_registration',
                    'title'         => 'Enable user registration',
                    'description'   => 'Allow users to register in your site.',
                    'type'          => 'radio',
                    'default'       => '1',
                    'value'         => '',
                    'options'       => '1=Enabled|0=Disabled',
                    'is_required'   => true,
                    'is_gui'        => true,
                    'module'        => 'users',
                    'order'         => '961'
                )
            );

        }
    }

    public function down()
    {
    }
}
