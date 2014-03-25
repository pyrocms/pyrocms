<?php namespace Pyro\Module\Streams\Stream;

use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\Field\FieldAssignmentModel;

use Pyro\Module\Streams\Exceptions\InvalidStreamModelException;

/**
 * Streams Utilities Driver
 *
 * Functions to help out with common utility tasks.
 *
 * @author  	Parse19
 * @package  	PyroCMS\Core\Libraries\Streams\Drivers
 */

class StreamSchema
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

        $streams->delete();

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
    public static function convertTableToStream($streamSlug, $namespace, $streamPrefix, $streamName, $about = null, $titleColumn = null, $viewOptions = array('id', 'created_at'))
    {
        $schema = ci()->pdb->getSchemaBuilder();
        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

        $table = $streamPrefix.$streamSlug;
        $prefixedTable = $prefix.$streamPrefix.$streamSlug;

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
        if (! $schema->hasColumn($table, 'id')) {
            return false;
        }

        // ----------------------------
        // Add some fields to profiles
        // in prep for making it a stream
        // ----------------------------
        $schema->table($table, function($table) use ($schema) {

            // Created Field
            if (! $schema->hasColumn($table->getTable(), 'created_at')) {
                $table->datetime('created_at')->nullable();
            }

            // Updated Field
            if (! $schema->hasColumn($table->getTable(), 'updated_at')) {
                $table->datetime('updated_at')->nullable();
            }

            // Created_by Field
            if (! $schema->hasColumn($table->getTable(), 'created_by')) {
                $table->integer('created_by')->nullable();
            }

            // Ordering count Field
            if (! $schema->hasColumn($table->getTable(), 'ordering_count')) {
                $table->integer('ordering_count')->nullable();
            }
        });

        // ----------------------------
        // Order The Columns
        // ----------------------------

        ci()->pdb->statement("ALTER TABLE `".$prefixedTable."` MODIFY COLUMN `created_at` DATETIME AFTER id");
        ci()->pdb->statement("ALTER TABLE `".$prefixedTable."` MODIFY COLUMN `updated_at` DATETIME AFTER created_at");
        ci()->pdb->statement("ALTER TABLE `".$prefixedTable."` MODIFY COLUMN `created_by` INT(11) AFTER updated_at");
        ci()->pdb->statement("ALTER TABLE `".$prefixedTable."` MODIFY COLUMN `ordering_count` INT(11) AFTER created_by");

        // ----------------------------
        // Add to stream table
        // ----------------------------

        $stream = array(
            'stream_name'		=> $streamName,
            'stream_namespace'	=> $namespace,
            'stream_prefix' 	=> $streamPrefix,
            'stream_slug'		=> $streamSlug,
            'about'				=> $about,
            'title_column'		=> $titleColumn,
            'sorting'			=> 'title',
            'view_options'		=> $viewOptions
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

        $prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

        // Get the stream
        if (! $stream = StreamModel::findBySlugAndNamespace($streamSlug, $namespace)) {
            return false;
        }

        // Make sure this column actually exists.
        if (! $schema->hasColumn($stream->stream_prefix.$stream->stream_slug, $fieldSlug)) {
            return false;
        }

        // Maybe we already added this?
        if ($field = FieldModel::addField(array(
            'name'          => $fieldName,
            'namespace'     => $namespace,
            'slug'          => $fieldSlug,
            'type'          => $fieldType,
            'assign'        => $streamSlug,
            'extra'         => $extra,
        )));

        return $stream->assignField($field, $assignData, false);
    }
}
