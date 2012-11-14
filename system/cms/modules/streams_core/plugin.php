<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Streams Core Plugin
 *
 * This plugin houses common Streams functions that need to be
 * globally accessible by streams tags, not just PyroStreams.
 *
 * @package		PyroStreams
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Plugin_Streams_core extends Plugin
{
	/**
	 * Field Function
	 * 
	 * Calls the plugin override function
	 */ 
	public function field()
	{
		$attr = $this->attributes();

		// Setting this in a separte var so we can unset it
		// from the array later that is passed to the parse_override function.
		$field_type = $attr['field_type'];

		// Call the field method
		if (method_exists($this->type->types->{$field_type}, 'plugin_override'))
		{
			// Get the actual field.
			$field = $this->fields_m->get_field_by_slug($attr['field_slug'], $attr['namespace']);

			if ( ! $field) return null;

			// We don't need these anymore
			unset($attr['field_type']);
			unset($attr['field_slug']);
			unset($attr['namespace']);

			return $this->type->types->{$field_type}->plugin_override($field, $attr);	
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Multiple Related Entries
	 *
	 * This works with the multiple relationship field
	 *
	 * @access	public
	 * @return	array
	 */
	public function multiple()
	{
		$rel_field 	= $this->attribute('field');
		$entry_id 	= $this->attribute('entry');
		$namespace 	= $this->attribute('namespace');
		$base_namespace = $this->attribute('base_namespace');

		// If there isn't a namespace, we'll just use 'streams'
		// to see if that works.
		if ( ! $namespace) $namespace = $base_namespace;

		// -------------------------------------
		
		if ( ! $field = $this->fields_m->get_field_by_slug($rel_field, $base_namespace)) return 'fu';

		// Get the stream
		$join_stream = $this->streams_m->get_stream($field->field_data['choose_stream']);
		
		// Get the fields		
		$fields = $this->streams_m->get_stream_fields($join_stream->id);

		$stream = $this->streams_m->get_stream($this->attribute('stream'), true, $base_namespace);

		if ( ! $stream) return 'by';
		
		// Add the join_multiple hook to the get_rows function
		$this->row_m->get_rows_hook = array($this, 'join_multiple');
		$this->row_m->get_rows_hook_data = array(
			'join_table' => $stream->stream_prefix.$stream->stream_slug.'_'.$join_stream->stream_slug,
			'join_stream' => $join_stream,
			'row_id' =>  $this->attribute('entry')		
		);
		
		$params = array(
			'arbitrary'			=> $entry_id, // For the cache
			'namespace'			=> $namespace,
			'stream'			=> $join_stream->stream_slug,
			'limit'				=> $this->attribute('limit'),
			'offset'			=> $this->attribute('offset', 0),
			'id'				=> $this->attribute('id', NULL),
			'date_by'			=> $this->attribute('date_by', 'created'),
			'exclude'			=> $this->attribute('exclude'),
			'show_upcoming'		=> $this->attribute('show_upcoming', 'yes'),
			'show_past'			=> $this->attribute('show_past', 'yes'),
			'year'				=> $this->attribute('year'),
			'month'				=> $this->attribute('month'),
			'day'				=> $this->attribute('day'),
			'restrict_user'		=> $this->attribute('restrict_user', 'no'),
			'where'				=> $this->attribute('where', NULL),
			'exclude'			=> $this->attribute('exclude', NULL),
			'exclude_by'		=> $this->attribute('exclude_by', 'id'),
			'disable'			=> $this->attribute('disable', NULL),
			'order_by'			=> $this->attribute('order_by'),
			'sort'				=> $this->attribute('sort', 'asc'),
			'exclude_called'	=> $this->attribute('exclude_called', 'no'),
			'paginate'			=> $this->attribute('paginate', 'no'),
			'pag_segment'		=> $this->attribute('pag_segment', 2),
			'partial'			=> $this->attribute('partial', NULL)			
		);

		$rows = $this->row_m->get_rows($params, $fields, $join_stream);

		return $rows['rows'];
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Join multiple
	 *
	 * Multiple join callback
	 *
	 * @access	public
	 * @param	array - array of settings
	 * @return	void
	 */
	public function join_multiple($data)
	{
		$this->row_m->sql['join'][] = "LEFT JOIN `{$this->db->dbprefix($data['join_table'])}` ON `{$this->db->dbprefix($data['join_table'])}`.`{$data['join_stream']->stream_slug}_id` = `{$this->db->dbprefix($data['join_stream']->stream_prefix.$data['join_stream']->stream_slug)}`.`id`";
		$this->row_m->sql['where'][] = "`{$this->db->dbprefix($data['join_table'])}`.`row_id` = '{$data['row_id']}'";
	}


}