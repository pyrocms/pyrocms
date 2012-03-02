<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_indexes extends CI_Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('navigation_groups').' ADD INDEX abbrev (`abbrev`)');
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('modules').' ADD INDEX enabled (`enabled`)');
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('permissions ').' ADD INDEX group_id (`group_id`)');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('navigation_groups').' DROP INDEX abbrev');
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('modules').' DROP INDEX enabled ');
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('permissions ').' DROP INDEX group_id');
    }
}