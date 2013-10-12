<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_permissions_to_search_index extends CI_Migration
{
    public function up()
    {
        $schema = $this->pdb->getSchemaBuilder();

        // Add the new fields for Sentry
        $schema->table('search_index', function($table) {
            $table->text('group_access')->nullable();
            $table->text('user_access')->nullable();

            //$table->index(array('group_access', 'user_access'));
        });
    }

    public function down()
    {
        return true;
    }
}