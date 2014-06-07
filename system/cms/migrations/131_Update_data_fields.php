<?php

class Migration_Update_data_fields extends CI_Migration
{
    public function up()
    {
        $schema = $this->pdb->getSchemaBuilder();

        if (!$schema->hasColumn('data_fields', 'updated_at')) {
            $schema->table(
                'data_fields',
                function ($table) {
                    $table->datetime('updated_at')->nullable();
                }
            );
        }

        if (!$schema->hasColumn('data_fields', 'created_at')) {
            $schema->table(
                'data_fields',
                function ($table) {
                    $table->datetime('created_at')->nullable();
                }
            );
        }
    }

    public function down()
    {
        return true;
    }
}