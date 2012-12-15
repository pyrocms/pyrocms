<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Profile_visibility_setting extends CI_Migration {

    public function up()
    {
        $insert = array(
                'slug' => 'profile_visibility',
                'title' => 'Profile Visibility',
                'description' => 'Specify who can view user profiles on the public site',
                'type' => 'select',
                'default' => 'public',
                'value' => '',
                'options' => 'public=profile_public|owner=profile_owner|hidden=profile_hidden|member=profile_member',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'users',
                'order' => 960,
            );

        $this->db->insert('settings', $insert);
    }

    public function down()
    {
		$this->db->where('slug', 'profile_visibility')->delete('settings');
    }
}