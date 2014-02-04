<?php namespace Pyro\Module\Streams_core;

use Pyro\Module\Streams_core\Exceptions\InvalidStreamModelException;

/**
 * Streams Utilities Driver
 *
 * Functions to help out with common utility tasks.
 *
 * @author  	Parse19
 * @package  	PyroCMS\Core\Libraries\Streams\Drivers
 */

class SchemaUtility
{
    /**
     * Remove Namespace
     *
     * Performs all uninstall actions for a specific
     * namespace.
     *
     * @param	string - namespace
     * @return	bool
     */
    public static function destroyNamespace($namespace)
    {
        // Some field destructs use stream data from the cache,
        // so let's make sure that the slug cache has run.

        $streams = StreamModel::findManyByNamespace($namespace);

        $streams->each(function ($stream) {
            $stream->delete();
        });

        // Make sure that garbage is collected even it the stream is not present anymore
        FieldModel::where('field_namespace', '=', $namespace)->delete();

        FieldAssignmentModel::cleanup();
        FieldModel::cleanup();

        // Remove all fields in namespace
        return true;
    }

    // --------------------------------------------------------------------------

    /**
     * Convert table to stream.
     *
     * Note: this does NOT handle fields
     * at this time. This must be done manually.
     *
     * We are trying not to make a lot of assumptions
     * in this function, lest we get anything else
     * in the database messed up.
      *
     * @param	string - table slug
     * @param	string - namespace
     * @param	string - stream prefix
     * @param	string - full stream name
     * @param	[string - about the stream]
     * @param	[string - title column]
     * @param	[array - view options]
     * @return	bool
     */
    public static function convertTableToStream($streamSlug, $namespace, $stream_prefix, $stream_name, $about = null, $title_column = null, $view_options = array('id', 'created_at'))
    {
        $schema = ci()->pdb->getSchemaBuilder();
        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

        $table = $prefix.$stream_prefix.$streamSlug;

        // ----------------------------
        // Table data checks
        // ----------------------------

        // Does the table w/ the prefix exist?
        // If not, then forget it. We can't make a stream
        // out of a table that doesn't exist.


        if ( ! $schema->hasTable($table)) {
            return false;
        }

        // Maybe this table already exsits in our streams table?
        // If so we can't have that.
        if(StreamModel::findBySlugAndNamespace($streamSlug, $namespace)) {
            return false;
        }

        // We need an ID field to be able to make
        // a table into a stream.
        if ( ! $schema->hasColumn($table, 'id')) {
            return false;
        }

        // ----------------------------
        // Add some fields to profiles
        // in prep for making it a stream
        // ----------------------------
        $schema->table($table, function($table) use ($schema) {
            // Created Field
            if ( ! $schema->hasColumn($table->getTable(), 'created_at')) {
                $table->datetime('created_at')->nullable();
            }

            // Updated Field
            if ( ! $schema->hasColumn($table->getTable(), 'created_at')) {
                $table->datetime('updated_at')->nullable();
            }

            // Created_by Field
            if ( ! $schema->hasColumn($table->getTable(), 'created_by')) {
                $table->integer('created_by')->nullable();
            }

            // Ordering count Field
            if ( ! $schema->hasColumn($table->getTable(), 'ordering_count')) {
                $table->integer('ordering_count')->nullable();
            }
        });

        // ----------------------------
        // Order The Columns
        // ----------------------------

        ci()->pdb->statement("ALTER TABLE `".$table."` MODIFY COLUMN `created_at` DATETIME AFTER id");
        ci()->pdb->statement("ALTER TABLE `".$table."` MODIFY COLUMN `updated_at` DATETIME AFTER updated_at");
        ci()->pdb->statement("ALTER TABLE `".$table."` MODIFY COLUMN `created_by` INT(11) AFTER updated_at");
        ci()->pdb->statement("ALTER TABLE `".$table."` MODIFY COLUMN `ordering_count` INT(11) AFTER created_by");

        // ----------------------------
        // Add to stream table
        // ----------------------------

        $stream = array(
            'stream_name'		=> $stream_name,
            'stream_namespace'	=> $namespace,
            'stream_prefix' 	=> $stream_prefix,
            'stream_slug'		=> $streamSlug,
            'about'				=> $about,
            'title_column'		=> $title_column,
            'sorting'			=> 'title',
            'view_options'		=> $view_options
        );

        return StreamModel::create($stream);
    }

    // --------------------------------------------------------------------------

    /**
     * Field to Stream Frield
     *
     * Allows you to take a column in a stream table
     * and turn it into a stream field.
     *
     * @param	string - namespace
     * @return	bool
     */
    public static function convertColumnToField($streamSlug, $namespace, $fieldName, $fieldSlug, $fieldType, $extra = array(), $assignData = array())
    {
        $schema = ci()->pdb->getSchemaBuilder();

        // Get the stream
        if ( ! $stream = StreamModel::findBySlugAndNamespace($streamSlug, $namespace)) {
            return false;
        }

        // Make sure this column actually exists.
        if ( ! $schema->hasColumn($stream->stream_prefix.$stream->stream_slug, $fieldSlug)) {
            return false;
        }

        // Maybe we already added this?
        if ($field = FieldModel::addField(array(
            'field_name'          => 'lang:streams:column_data',
            'slug'          => $fieldSlug,
            'type'          => $fieldType,
            'assign'        => $streamSlug,
            'extra'         => $extra,
        )));

        return $stream->assignField($field, $assignData, false);
    }
}