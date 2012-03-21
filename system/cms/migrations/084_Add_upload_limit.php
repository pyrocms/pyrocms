<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_upload_limit extends CI_Migration {

    public function up()
    {
        $insert = array(
                'slug' => 'files_upload_limit',
                'title' => 'Filesize Limit',
                'description' => 'Maximum filesize to allow when uploading. Specify the size in MB. Example: 5',
                'type' => 'text',
                'default' => '5',
                'value' => '5',
                'options' => '',
                'is_required' => 1,
                'is_gui' => 1,
                'module' => 'files',
                'order' => 987,
            );

        $this->db->insert('settings', $insert);
    }

    public function down()
    {
		$this->db->where('slug', 'files_upload_limit')->delete('settings');
    }
}