<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Make_field_name_nullable extends CI_Migration
{
    public function up()
    {
        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();
        
        ci()->pdb->statement("ALTER TABLE `" . $prefix . "data_field_assignments` MODIFY `field_name` VARCHAR(60);");

        return true;
    }

    public function down()
    {
        return true;
    }
}