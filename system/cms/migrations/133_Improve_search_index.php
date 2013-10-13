<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Improve_search_index extends CI_Migration
{
    public function up()
    {
        $schema = ci()->pdb->getSchemaBuilder();
        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

        // Add the new fields for Sentry
        $schema->table('search_index', function($table) {
            
            // Add permissions (JSON of IDs)
            $table->text('group_access')->nullable();
            $table->text('user_access')->nullable();

            // Add the scope
            $table->string('scope')->after('module');

            // Rename cp_edit_uri to just cp_uri
            $table->renameColumn('cp_edit_uri', 'cp_uri');

            // Drop cp_delete_uri - aint nobody got time for that
            $table->dropColumn('cp_delete_uri');
        });
    }

    public function down()
    {
        return true;
    }
}