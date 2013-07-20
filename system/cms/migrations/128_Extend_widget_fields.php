<?php

/**
 * Migration 128: Extend Widget Fields
 *
 * Store more widget names in the title array
 * 
 * Added April 30th, 2013
 */

class Migration_Extend_widget_fields extends CI_Migration
{
    public function up()
    {
        $this->dbforge->modify_column('widgets', array(
            'title' => array(
                'name' => 'name',
                'type' => 'TEXT',
            ),
        ));

        $this->dbforge->modify_column('widget_areas', array(
            'title' => array(
                'name' => 'name',
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
        ));

        $this->dbforge->modify_column('widget_instances', array(
            'title' => array(
                'name' => 'name',
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
        ));

        $schema = $this->pdb->getSchemaBuilder();

        $schema->table('widgets', function($table) {
            $table->string('author_website')->nullable();
        });
    }

    public function down()
    {
        $this->dbforge->modify_column('widgets', array(
            'name' => array(
                'name' => 'title',
                'type' => 'varchar',
                'constraint' => 255,
            ),
        ));

        $this->dbforge->modify_column('widget_areas', array(
            'name' => array(
                'name' => 'title',
                'type' => 'varchar',
                'constraint' => 255,
            ),
        ));

        $this->dbforge->modify_column('widget_instances', array(
            'name' => array(
                'name' => 'title',
                'type' => 'varchar',
                'constraint' => 255,
            ),
        ));

        $schema = $this->pdb->getSchemaBuilder();

        $schema->table('widgets', function($table) {
            $table->dropColumn('author_website');
        });

        return true;
    }
}