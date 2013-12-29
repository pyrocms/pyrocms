<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Allow_users_salt_null extends CI_Migration
{
    public function up()
    {
        $this->db->query('
            ALTER TABLE '.$this->db->dbprefix('settings').' 
                MODIFY COLUMN `type` enum(\'text\',\'textarea\',\'password\',\'select\',\'select-multiple\',\'radio\',\'checkbox\') NOT NULL DEFAULT "text"
        ');

        // Some really old installs had empty string values, which should not be valid. They were themes, so...
        $this->db->query('
            UPDATE '.$this->db->dbprefix('settings').' 
            SET `type` = "select"
            WHERE `type` = ""
        ');

        // Users salt is optional as Sentry does things differently
        $this->db->query('
            ALTER TABLE '.$this->db->dbprefix('users').' 
                MODIFY COLUMN `salt` varchar(6)
        ');

        return true;
    }

    public function down()
    {
        return true;
    }
}