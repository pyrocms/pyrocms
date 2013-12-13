<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\StreamModel;
use Pyro\Module\Streams_core\FieldModel;
use Pyro\Module\Streams_core\FieldAssignmentModel;

class Migration_Remove_variables_syntax_column extends CI_Migration
{
    public function up()
    {
        $schema = ci()->pdb->getSchemaBuilder();

        if ($stream = StreamModel::findBySlugAndNamespace('variables', 'variables')) {

            if ($field = FieldModel::findBySlugAndNamespace('syntax', 'variables')) {

                if ($assignment = FieldAssignmentModel::findByFieldIdAndStreamId($field->getKey(), $stream->getKey())) {

                    $assignment->delete();
                }

                $field->delete();                
            }

            $schema->table('variables', function ($table) {
                $table->dropColumn('syntax');
            });
        }

        return true;
    }

    public function down()
    {
        return true;
    }
}