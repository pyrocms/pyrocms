<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Rename_is_prefixed_columns extends CI_Migration
{
    public function up()
    {
        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();
        $schema = ci()->pdb->getSchemaBuilder();

        $schema->table(
            'data_field_assignments',
            function ($table) use ($schema, $prefix) {
                if ($schema->hasColumn($table->getTable(), 'is_required')) {
                    ci()->pdb->statement("ALTER TABLE `" . $prefix . $table->getTable() . "` CHANGE `is_required` `required` ENUM('yes', 'no') NOT NULL;");
                }

                if ($schema->hasColumn($table->getTable(), 'is_unique')) {
                    ci()->pdb->statement("ALTER TABLE `" . $prefix . $table->getTable() . "` CHANGE `is_unique` `unique` ENUM('yes', 'no') NOT NULL;");
                }
            }
        );

        $schema->table(
            'data_streams',
            function ($table) use ($schema, $prefix) {
                if ($schema->hasColumn($table->getTable(), 'is_hidden')) {
                    ci()->pdb->statement("ALTER TABLE `" . $prefix . $table->getTable() . "` CHANGE `is_hidden` `hidden` ENUM('yes', 'no') NOT NULL;");
                }
            }
        );

        return true;
    }

    public function down()
    {
        return true;
    }
}