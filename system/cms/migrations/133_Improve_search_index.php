<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Improve_search_index extends CI_Migration
{
    public function up()
    {
        $schema = $this->pdb->getSchemaBuilder();

        // Add the new fields for Sentry
        $schema->table('search_index', function($table) {
            
            // Add permissions (JSON of IDs)
            $table->text('group_access')->nullable();
            $table->text('user_access')->nullable();

            // Add the scope
            $table->string('scope')->after('module');

            // Drop cp_delete_uri - aint nobody got time for that
            $table->dropColumn('cp_delete_uri');
        });

        // Rename cp_edit_uri to just cp_uri
        //$table->renameColumn('cp_edit_uri', 'cp_uri');
        ci()->pdb->statement('ALTER TABLE `'.SITE_REF.'_search_index` CHANGE `cp_edit_uri` `cp_uri` VARCHAR(255) NOT NULL  DEFAULT "";');

        // Rename cp_edit_uri to just cp_uri
        //$table->renameColumn('entry_key', 'entry_singular');
        ci()->pdb->statement('ALTER TABLE `'.SITE_REF.'_search_index` CHANGE `entry_key` `entry_singular` VARCHAR(255) NOT NULL  DEFAULT "";');
    }

    public function down()
    {
        return true;
    }
}