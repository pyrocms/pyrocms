<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_indexes extends CI_Migration
{
    public function up()
    {
        if ( ! $this->has_key('navigation_groups', 'abbrev'))
        {
            $this->db->query('ALTER TABLE '.$this->db->dbprefix('navigation_groups').' ADD INDEX abbrev (`abbrev`)');
        }
        
        if ( ! $this->has_key('modules', 'enabled'))
        {
            $this->db->query('ALTER TABLE '.$this->db->dbprefix('modules').' ADD INDEX enabled (`enabled`)');
        }

        if ( ! $this->has_key('permissions', 'group_id'))
        {
            $this->db->query('ALTER TABLE '.$this->db->dbprefix('permissions').' ADD INDEX group_id (`group_id`)');
        }

        if ( ! $this->has_key('profiles', 'user_id'))
        {
            $this->db->query('ALTER TABLE '.$this->db->dbprefix('profiles').' ADD INDEX user_id (`user_id`)');
        }
    }

    public function down()
    {
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('navigation_groups').' DROP INDEX abbrev');
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('modules').' DROP INDEX enabled ');
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('permissions ').' DROP INDEX group_id');
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('profiles').' DROP INDEX user_id');
    }

    /**
     * Quick little function to 
     * check if a key has been added
     */
    public function has_key($table, $index)
    {   
        $query = $this->db->query("SHOW INDEX FROM {$this->db->dbprefix($table)}");

        foreach ($query->result() as $row)
        {
            if ($row->Key_name == $index)
            {
                return true;
            }
        }

        return false;
    }
}