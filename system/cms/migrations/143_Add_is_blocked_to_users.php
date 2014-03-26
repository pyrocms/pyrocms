<?php

use Pyro\Module\Streams\Stream\StreamModel;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\FieldType\FieldTypeManager;
use Pyro\Module\Streams\Stream\StreamSchema;

class Migration_Add_is_blocked_to_users extends CI_Migration
{
    public function up()
    {
        $this->pdb->getSchemaBuilder()->table(
            'users',
            function ($table) {
                $table->boolean('is_blocked')->default(false);
            }
        );
    }

    public function down()
    {
        return true;
    }
}