<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Chunks Field Type
 *
 * This field type is only for use in the Pages module, and 
 * is for backwards compatibility purposes only. In fact,
 * the chunks field type is only loaded when working in the pages
 * module, and it has elements that only work with the pages
 * module, so don't use it for anything else!
 *
 * @package		PyroCMS\Core\Modules\Pages\Field Types
 * @author		PyroCMS
 */
class Field_chunks
{
	public $field_type_slug			= 'chunks';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.0.0';

	public $admin_display			= 'full';

	public $author					= array('name' => 'PyroCMS', 'url' => 'http://www.pyrocms.com');
		
	// --------------------------------------------------------------------------

	/**
	 * Output Form
	 *
	 * We will grab our chunks based on the page_id
	 * and display each form.
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data)
	{
		// Get the chunks
		$this->CI->load->model('page_chunk_m');

		// If we dont have a page ID, then let's just
		// make an empty page chunks array with 1 entry.
		if (isset(ci()->page_id))
		{
			$data['chunks'] = $this->CI->page_chunk_m->get_many_by('page_id', ci()->page_id);
		}
		else
		{
			$data['chunks'] = array(
					array(
						'slug'		=> 'default',
						'class'		=> null,
						'type'		=> null,
						'body'		=> null	
					)
				);
		}

		if ($_POST)
		{
			// Validation failed, we must repopulate the chunks form
			$chunk_slugs 	= $this->CI->input->post('chunk_slug') ? array_values($this->CI->input->post('chunk_slug')) : array();
			$chunk_classes 	= $this->CI->input->post('chunk_class') ? array_values($this->CI->input->post('chunk_class')) : array();
			$chunk_bodies 	= $this->CI->input->post('chunk_body') ? array_values($this->CI->input->post('chunk_body')) : array();
			$chunk_types 	= $this->CI->input->post('chunk_type') ? array_values($this->CI->input->post('chunk_type')) : array();

			$chunk_bodies_count = count($chunk_bodies);
			
			for ($i = 0; $i < $chunk_bodies_count; $i++)
			{
				$data['chunks'][$i] = array(
					//'id' 	=> $i,
					'slug' 	=> ! empty($chunk_slugs[$i]) 	? $chunk_slugs[$i] 	: '',
					'class' => ! empty($chunk_classes[$i]) 	? $chunk_classes[$i] 	: '',
					'type' 	=> ! empty($chunk_types[$i]) 	? $chunk_types[$i] 	: '',
					'body' 	=> ! empty($chunk_bodies[$i]) 	? $chunk_bodies[$i] : '',
				);
			}
		}

		return $this->CI->type->load_view('chunks', 'chunks_form', $data, true);
	}	

	// --------------------------------------------------------------------------

	/**
	 * Pre Save
	 *
	 * Process before saving to database. We have a dummy
	 * value in the form so this gets processed, but we
	 * ignore it and grab all the chunk inputs.
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function pre_save($raw_input, $field, $stream, $row_id, $input)
	{
		$this->CI->load->model('page_chunk_m');

		$slugs = array('chunk_slug', 'chunk_class', 'chunk_body', 'chunk_type');
		
		foreach ($slugs as $slug)
		{
			if ( ! isset($input[$slug])) $input[$slug] = null; 
		}

		$chunk_slugs 	= $input['chunk_slug'] ? array_values($input['chunk_slug']) : array();
		$chunk_class 	= $input['chunk_class'] ? array_values($input['chunk_class']) : array();
		$chunk_bodies 	= $input['chunk_body'] ? array_values($input['chunk_body']) : array();
		$chunk_types 	= $input['chunk_type'] ? array_values($input['chunk_type']) : array();

		$chunks = array();

		$chunk_bodies_count = count($chunk_bodies);
		
		for ($i = 0; $i < $chunk_bodies_count; $i++)
		{
			$chunks[] = (object) array(
				'slug' => ! empty($chunk_slugs[$i]) ? $chunk_slugs[$i] : '',
				'class' => ! empty($chunk_class[$i]) ? $chunk_class[$i] : '',
				'type' => ! empty($chunk_types[$i]) ? $chunk_types[$i] : '',
				'body' => ! empty($chunk_bodies[$i]) ? $chunk_bodies[$i] : '',
			);
		}

		// No matter what, we are going to need to get rid of
		// old page chunks.
		$this->CI->page_chunk_m->delete_by('page_id', ci()->page_id);

		// If we have chunks, let's go ahead and add them. 
		if ($chunks)
		{
			$i = 1;
			foreach ($chunks as $chunk)
			{
				$this->CI->page_chunk_m->insert(array(
					'slug' 		=> preg_replace('/[^a-zA-Z0-9_-]/', '', $chunk->slug),
					'class' 	=> preg_replace('/[^a-zA-Z0-9_-\s]/', '', $chunk->class),
					'page_id' 	=> ci()->page_id,
					'body' 		=> $chunk->body,
					'parsed'	=> ($chunk->type == 'markdown') ? parse_markdown($chunk->body) : '',
					'type' 		=> $chunk->type,
					'sort' 		=> $i++,
				));
			}
		}

		return '*';
	}

}