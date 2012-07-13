<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_comment_blacklist_table extends CI_Migration {
    
    public function up()
    {
            $table_name = $this->db->dbprefix('comment_blacklists');
            $this->db->query("
                CREATE TABLE $table_name (
                id int(11) NOT NULL primary key auto_increment,
                website varchar(255) NULL,
                email varchar(150) NULL)
            ");
    }

     public function down()
     {
         $table_name = $this->db->dbprefix('comment_blacklist');
         $this->db->query("DROP TABLE $table_name");
     }
}
