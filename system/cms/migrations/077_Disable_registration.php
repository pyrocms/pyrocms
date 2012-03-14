<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Disable_registration extends CI_Migration {

    public function up()
    {
        $this->load->model('settings/settings_m');

        if ( ! $this->settings_m->get_by(array('slug' => 'enable_registration')))
        {
            $this->settings_m->insert(
                array(
                    'slug'          => 'enable_registration',
                    'title'         => 'Enable user registration',
                    'description'   => 'Allow users to register in your site.',
                    'type'          => 'radio',
                    'default'       => '1',
                    'value'         => '',
                    'options'       => '1=Enabled|0=Disabled',
                    'is_required'   => '0',
                    'is_gui'        => '1',
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