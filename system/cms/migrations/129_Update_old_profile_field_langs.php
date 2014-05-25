<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_old_profile_field_langs extends CI_Migration
{
    private $migrate_keys = array(
        'user_first_name' => 'user:first_name',
        'user_last_name' => 'user:last_name',
        'user_lang' => 'user:lang',
    );

    public function up()
    {
        foreach ($this->migrate_keys as $oldKey => $newKey) {
            $this->db
                ->where('field_name', 'lang:'.$oldKey)
                ->set('field_name', 'lang:'.$newKey)
                ->update('data_fields');
        }
    }

    public function down()
    {
        foreach ($this->migrate_keys as $oldKey => $newKey) {
            $this->db
                ->where('field_name', 'lang:'.$newKey)
                ->set('field_name', 'lang:'.$oldKey)
                ->update('data_fields');
        }
    }
}
