<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Allow_users_salt_null extends CI_Migration
{
    public function up()
    {
        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

        ci()->pdb->statement('
            ALTER TABLE '.$prefix.'settings'.' 
                MODIFY COLUMN `type` enum(\'text\',\'textarea\',\'password\',\'select\',\'select-multiple\',\'radio\',\'checkbox\') NOT NULL DEFAULT "text"
        ');

        // Some really old installs had empty string values, which should not be valid. They were themes, so...
        ci()->pdb->statement('
            UPDATE '.$prefix.'settings'.' 
            SET `type` = "select"
            WHERE `type` = ""
        ');

        // Users salt is optional as Sentry does things differently
        ci()->pdb->statement('
            ALTER TABLE '.$prefix.'users'.' 
                MODIFY COLUMN `salt` varchar(6)
        ');

        return true;
    }

    public function down()
    {
        return true;
    }
}