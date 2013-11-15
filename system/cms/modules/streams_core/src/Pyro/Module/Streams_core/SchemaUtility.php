<?php namespace Pyro\Module\Streams_core;

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

		// Remove all fields in namespace
		return FieldModel::deleteByNamespace($namespace);
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
	public static function convertTableToStream($stream_slug, $namespace, $stream_prefix, $stream_name, $about = null, $title_column = null, $view_options = array('id', 'created'))
	{
		$schema = ci()->pdb->getSchemaBuilder();
		$prefix = ci()->pdb->getQueryGrammar()->getTablePrefix();

		$table = $prefix.$stream_prefix.$stream_slug;

		// ----------------------------
		// Table data checks
		// ----------------------------

		// Does the table w/ the prefix exist?
		// If not, then forget it. We can't make a stream
		// out of a table that doesn't exist.


		if ( ! $schema->hasTable($table))
		{
			return false;
		}

		// Maybe this table already exsits in our streams table?
		// If so we can't have that.
		if(ci()->pdb->table(STREAMS_TABLE)
			->where('stream_slug', $stream_slug)
			->where('stream_prefix', $stream_prefix)
			->where('stream_namespace', $namespace)
			->get())
		{
			return false;
		}

		// We need an ID field to be able to make
		// a table into a stream.
		if ( ! $schema->hasColumn($table, 'id'))
		{
			return false;
		}

		// ----------------------------
		// Add some fields to profiles
		// in prep for making it a stream
		// ----------------------------
		$schema->table($table, function($table) use ($schema)
		{
			// Created Field
			if ( ! $schema->hasColumn($table->getTable(), 'created'))
			{
				$table->datetime('created')->nullable();
			}

			// Updated Field
			if ( ! $schema->hasColumn($table->getTable(), 'updated'))
			{
				$table->datetime('updated')->nullable();
			}

			// Created_by Field
			if ( ! $schema->hasColumn($table->getTable(), 'created_by'))
			{
				$table->integer('created_by')->nullable();
			}

			// Ordering count Field
			if ( ! $schema->hasColumn($table->getTable(), 'ordering_count'))
			{
				$table->integer('ordering_count')->nullable();
			}
		});

		// ----------------------------
		// Order The Columns
		// ----------------------------

		ci()->pdb->statement("ALTER TABLE `".$table."` MODIFY COLUMN `created` DATETIME AFTER id");
		ci()->pdb->statement("ALTER TABLE `".$table."` MODIFY COLUMN `updated` DATETIME AFTER created");
		ci()->pdb->statement("ALTER TABLE `".$table."` MODIFY COLUMN `created_by` INT(11) AFTER updated");
		ci()->pdb->statement("ALTER TABLE `".$table."` MODIFY COLUMN `ordering_count` INT(11) AFTER created_by");

		// ----------------------------
		// Add to stream table
		// ----------------------------

		$stream = array(
			'stream_name'		=> $stream_name,
			'stream_namespace'	=> $namespace,
			'stream_prefix' 	=> $stream_prefix,
			'stream_slug'		=> $stream_slug,
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
	public static function convertColumnToField($stream_slug, $namespace, $field_name, $field_slug, $field_type, $extra = array(), $assign_data = array())
	{
		$schema = ci()->pdb->getSchemaBuilder();

		// Get the stream
		if ( ! $stream = $this->stream_obj($stream_slug, $namespace)) {
			$this->log_error('invalid_stream', 'convert_column_to_field');
			return false;
		}

		// Make sure this column actually exists.
		if ( ! $schema->hasColumn($stream->stream_prefix.$stream->stream_slug, $field_slug)) {
			$this->log_error('no_column', 'convert_column_to_field');
			return false;
		}

		// Maybe we already added this?
		if (ci()->pdb->table(FIELDS_TABLE)
			->where('field_slug', $field_slug)
			->where('field_namespace', $namespace)
			->take(1)
			->count() == 1)
		{
			return false;
		}

		// If it does, we are in business! Let's add the field
		// metadata + the field assignment

		// ----------------------------
		// Add Field Metadata
		// ----------------------------

		if ( ! isset($extra) or ! is_array($extra)) $extra = array();

		if ( ! ($field_id = ci()->fields_m->insert_field($field_name, $field_slug, $field_type, $namespace, $extra))) return false;

		// ----------------------------
		// Add Assignment
		// ----------------------------

		$data = array();
		extract($assign_data);

		// Title column
		if (isset($title_column) and $title_column === true) {
			$data['title_column'] = 'yes';
		}

		// Instructions
		$data['instructions'] = (isset($instructions) and $instructions != '') ? $instructions : null;

		// Is Unique
		if (isset($unique) and $unique === true) {
			$data['is_unique'] = 'yes';
		}

		// Is Required
		if (isset($required) and $required === true) {
			$data['is_required'] = 'yes';
		}

		// Add actual assignment
		// The 4th parameter is to stop the column from being
		// created, since we already did that.
		return ci()->streams_m->add_field_to_stream($field_id, $stream->id, $data, false);
	}
}
