<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Relationship Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_relationship
{
	public $field_type_slug			= 'relationship';
	
	public $db_col_type				= 'int';

	public $custom_parameters		= array( 'choose_stream' );

	public $version					= '1.1';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

	// --------------------------------------------------------------------------
	
	public function event()
	{
		// Add autocomplete CSS just in case
		// $this->CI->type->add_css('relationship', 'autocomplete.css');	
	}

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data, $entry_id, $field)
	{	
		// Get slug stream
		$stream = $this->CI->streams_m->get_stream($data['custom']['choose_stream']);
		
		if ( ! $stream)
		{
			return '<em>'.$this->CI->lang->line('streams.relationship.doesnt_exist').'</em>';
		}

		$title_column = $stream->title_column;
		
		// Default to ID for title column
		if ( ! trim($title_column) or !$this->CI->db->field_exists($title_column, $stream->stream_prefix.$stream->stream_slug))
		{
			$title_column = 'id';
		}
	
		// Get the entries
		$obj = $this->CI->db->get($stream->stream_prefix.$stream->stream_slug);
		
		$choices = array();

		// If this is not required, then
		// let's allow a null option
		if ($field->is_required == 'no')
		{
			$choices[null] = $this->CI->config->item('dropdown_choose_null');
		}
		
		foreach ($obj->result() as $row)
		{
			// Need to replace with title column
			$choices[$row->id] = $row->$title_column;
		}
		
		// Output the form input
		return form_dropdown($data['form_slug'], $choices, $data['value'], 'id="'.$data['form_slug'].'"');
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a list of streams to choose from
	 *
	 * @access	public
	 * @return	string
	 */
	public function param_choose_stream($stream_id = false)
	{
		$choices = array();

		// Now get our streams and add them
		// under their namespace
		$streams = $this->CI->db->select('id, stream_name, stream_namespace')->get(STREAMS_TABLE)->result();
		
		foreach ($streams as $stream)
		{
			if ($stream->stream_namespace)
			{
				$choices[$stream->stream_namespace][$stream->id] = $stream->stream_name;
			}
		}
		
		return form_dropdown('choose_stream', $choices, $stream_id);
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting on the CP
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function pre_output($input, $data)
	{	
		// We only need this in the admin.
		// Relationships are taken care of by a join
		// on the front end
		if ($this->CI->uri->segment(1) != 'admin')
		{
			return null;
		}
	
		$stream = $this->CI->streams_m->get_stream($data['choose_stream']);

		$title_column = $stream->title_column;

		// -------------------------------------
		// Data Checks
		// -------------------------------------
		
		// Make sure the table exists still. If it was deleted we don't want to
		// have everything go to hell.
		if ( ! $this->CI->db->table_exists($stream->stream_prefix.$stream->stream_slug))
		{
			return null;
		}
		
		// We need to make sure the select is NOT null.
		// So, if we have no title column, let's use the id
		if (trim($title_column) == '')
		{
			$title_column = 'id';
		}

		// -------------------------------------
		// Get the entry
		// -------------------------------------
		
		$row = $this->CI->db
						->select('id, '.$title_column)
						->where('id', $input)
						->get($stream->stream_prefix.$stream->stream_slug)
						->row();
		
		if (isset($row->$title_column))
		{
			return '<a href="'.site_url('admin/streams/entries/view/'.$stream->id.'/'.$row->id).'">'.$row->$title_column.'</a>';
		}
		
		return null;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Format a relationship row
	 * 
	 * Note - this will only be processed in the event
	 * of a relationship inside of a relationship. Top-level
	 * relationships are handled by a join.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	array
	 */
	function pre_output_plugin($row, $custom)
	{
		// Okay good to go
		$stream = $this->CI->streams_m->get_stream($custom['choose_stream']);

		// Do it gracefully
		if ( ! $stream)
		{
			return null;
		}

		$obj = $this->CI->db->where('id', $row)->get($stream->stream_prefix.$stream->stream_slug);
		
		if ($obj->num_rows() == 0)
		{
			return null;
		}
		
		$returned_row = $obj->row();
		
		foreach ($returned_row as $key => $val)
		{
			$return[$key] = $val;
		}
		
		$stream_fields = $this->CI->streams_m->get_stream_fields($stream->id);

		return $this->CI->row_m->format_row($return, $stream_fields, $stream, false, true);
	}

	// --------------------------------------------------------------------------

	/**
	 * Search a field and stream
 	 *
	 * Accessed via AJAX
	 *
	 * @access    public
	 * @return    void
	 */
	public function ajax_rel_search()
	{
		/*$stream_slug = $this->CI->input->post('stream_slug');
		$title_column = $this->CI->input->post('title_column');

		$results = $this->CI->db->limit(6)
			->select("id, {$title_column}")
			->like($title_column, $this->CI->input->post('search_term'))
			->get($this->CI->config->item('stream_prefix').$stream_slug)
			->result();

		echo '<ul class="streams_dropdown">';

		foreach($results as $result):

		echo '<li><a class="'.$stream_slug.'_autocomplete_item" id="'.$result->id.'" name="'.$result->$title_column.'">'.$result->$title_column.'</a></li>';

		endforeach;

		echo '<ul>';*/
	}

}