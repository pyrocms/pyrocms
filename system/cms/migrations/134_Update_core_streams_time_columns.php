<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Model\Stream;

class Migration_Update_core_streams_time_columns extends CI_Migration
{
    public function up()
    {
        // Load our schema builder
        $schema = $this->pdb->getSchemaBuilder();

        // Get all the streams
        $streams = Stream::all();

        // Update son..
        foreach ($streams as $slug => $stream) {
            
            // Build the table
            $table = SITE_REF.'_'.$stream->stream_prefix.$stream->stream_slug;

            // Rename created to created_at
            ci()->pdb->statement('ALTER TABLE `'.$table.'` CHANGE `created` `created_at` DATETIME NOT NULL;');

            // Rename updated to updated_at
            ci()->pdb->statement('ALTER TABLE `'.$table.'` CHANGE `updated` `updated_at` DATETIME NOT NULL;');
        }

        //die('Done');
    }

    public function down()
    {
        return true;
    }
}