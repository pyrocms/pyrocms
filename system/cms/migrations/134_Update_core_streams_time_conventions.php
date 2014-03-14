<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams\Stream\StreamModel;

class Migration_Update_core_streams_time_conventions extends CI_Migration
{
    public function up()
    {
        // Load our schema builder
        $schema = ci()->pdb->getSchemaBuilder();

        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();
        
        // Get all the streams
        $streams = StreamModel::all();

        // Update son..
        foreach ($streams as $slug => $stream) {
            
            // Build the table
            $table = $stream->stream_prefix.$stream->stream_slug;

            /**
             * First update the column names
             */

            // Rename created to created_at
            if ($schema->hasColumn($table, 'created')) {
                ci()->pdb->statement('ALTER TABLE `'.$prefix.$table.'` CHANGE `created` `created_at` DATETIME NOT NULL;');    
            }
            
            // Rename updated to updated_at
            if ($schema->hasColumn($table, 'updated')) {
                ci()->pdb->statement('ALTER TABLE `'.$prefix.$table.'` CHANGE `updated` `updated_at` DATETIME NOT NULL;');
            }

            /**
             * Now loop through the streams in the db and update the view options
             */
            
            // Duplicate em
            $view_options = $stream->view_options;

            // Look for created
            if (($result = array_search('created', $view_options)) !== false) {
                $view_options[$result] = 'created_at';
            }

            // Look for updated
            if (($result = array_search('updated', $view_options)) !== false) {
                $view_options[$result] = 'updated_at';
            }

            // Update the object
            $stream->view_options = $view_options;

            // Save
            $stream->save();
        }
    }

    public function down()
    {
        return true;
    }
}