<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Chunks Field Type
 *
 * This field type is only for use in the Pages module, and 
 * is for backwards compatibility purposes only.
 *
 * @package		PyroCMS\Core\Modules\Pages\Field Types
 * @author		PyroCMS (Adam Fairholm)
 */
class Field_chunks
{
	public $field_type_slug			= 'chunks';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.0';

	public $admin_display			= 'full';

	public $author					= array('name'=>'PyroCMS', 'url'=>'http://www.pyrocms.com');
		
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
		// We need a page ID.
		if ( ! defined('PAGE_ID')) return null;

		$data = array();

		// Get the chunks
		$this->CI->load->model('page_chunk_m');

		$data['chunks'] = $this->CI->page_chunk_m->get_many_by('page_id', PAGE_ID);

		if ($_POST)
		{

			// validation failed, we must repopulate the chunks form
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
	 * Process before saving to database
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function pre_save()
	{
		$this->CI->load->model('page_chunk_m');

		$input = $this->CI->input->post();

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

		if ($chunks)
		{
			// Get rid of the old
			$this->CI->page_chunk_m->delete_by('page_id', PAGE_ID);

			// And add the new ones
			$i = 1;
			foreach ($chunks as $chunk)
			{
				$this->CI->page_chunk_m->insert(array(
					'slug' 		=> preg_replace('/[^a-zA-Z0-9_-]/', '', $chunk->slug),
					'class' 	=> preg_replace('/[^a-zA-Z0-9_-\s]/', '', $chunk->class),
					'page_id' 	=> PAGE_ID,
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