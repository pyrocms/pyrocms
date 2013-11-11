<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Model\Stream;
use Pyro\Module\Streams_core\Core\Model\Field;
use Pyro\Module\Streams_core\Core\Model\FieldAssignment;

class Migration_Remove_variables_syntax_column extends CI_Migration
{
    public function up()
    {
        $schema = ci()->pdb->getSchemaBuilder();

        if ($stream = Stream::findBySlugAndNamespace('variables', 'variables')) {

            if ($field = Field::findBySlugAndNamespace('syntax', 'variables')) {

                if ($assignment = FieldAssignment::findByFieldIdAndStreamId($field->getKey(), $stream->getKey())) {

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