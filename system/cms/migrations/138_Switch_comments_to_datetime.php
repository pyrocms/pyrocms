<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Switch_comments_to_datetime extends CI_Migration
{
    public function up()
    {
        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();
        
        ci()->pdb->statement('
            ALTER TABLE '.$prefix.'comments 
                ADD COLUMN `created_at` DATETIME NOT NULL 
        ');

        // Convert created_on from unixtime to created_at datetime 
        ci()->pdb->statement('
            UPDATE '.$prefix.'comments 
                SET `created_at` = FROM_UNIXTIME(`created_on`)
        ');

        // Be gone with the old created_on
        ci()->pdb->statement('
            ALTER TABLE '.$prefix.'comments DROP COLUMN `created_on`
        ');


        return true;
    }

    public function down()
    {
        return true;
    }
}