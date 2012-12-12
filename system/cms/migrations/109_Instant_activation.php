<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Instant_activation extends CI_Migration
{
    public function up()
    {
        $this->db
            ->where('slug', 'activation_email')
            ->update('settings', array(
                'type' => 'select', 
                'options' => '0=activate_by_admin|1=activate_by_email|2=no_activation'
                )
            );
    }

    public function down()
    {
        $this->db
            ->where('slug', 'activation_email')
            ->update('settings', array(
                'type' => 'radio', 
                'options' => '1=Enabled|0=Disabled'
                )
            );
    }
}