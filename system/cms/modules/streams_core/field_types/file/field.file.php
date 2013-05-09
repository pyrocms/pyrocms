<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams File Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_file
{
	public $field_type_slug			= 'file';

	// Files are saved as 15 character strings.
	public $db_col_type				= 'char';
	public $col_constraint 			= 15;

	public $custom_parameters		= array('folder', 'allowed_types');

	public $version					= '1.2.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

	public $input_is_file			= true;

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($params)
	{
		$this->CI->load->config('files/files');

		// Get the file
		if ($params['value'])
		{
			$current_file = $this->CI->db
							->where('id', $params['value'])
							->limit(1)
							->get('files')
							->row();
		}
		else
		{
			$current_file = null;
		}

		$out = '';

		if ($current_file)
		{
			$out .= '<div class="file_info"><span href="#" class="file_remove">X</span><a href="'.base_url('files/download/'.$current_file->id).'">'.$current_file->name.'</a></div>';
		}

		// Output the actual used value
		if ($params['value'])
		{
			$out .= form_hidden($params['form_slug'], $params['value']);
		}
		else
		{
			$out .= form_hidden($params['form_slug'], 'dummy');
		}

		$options['name'] 	= $params['form_slug'];
		$options['name'] 	= $params['form_slug'].'_file';

		$this->CI->type->add_js('file', 'filefield.js');
		$this->CI->type->add_css('file', 'filefield.css');

		return $out .= form_upload($options);
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before saving to database
	 *
	 * @access	public
	 * @param	array
	 * @param	obj
	 * @return	string
	 */
	public function pre_save($input, $field)
	{
		// If we do not have a file that is being submitted. If we do not,
		// it could be the case that we already have one, in which case just
		// return the numeric file record value.
		if ( ! isset($_FILES[$field->field_slug.'_file']['name']) or ! $_FILES[$field->field_slug.'_file']['name'])
		{
			if ($this->CI->input->post($field->field_slug))
			{
				return $this->CI->input->post($field->field_slug);
			}
			else
			{
				return null;
			}
		}

		$this->CI->load->library('files/files');

		// If you don't set allowed types, we'll set it to allow all.
		$allowed_types 	= (isset($field->field_data['allowed_types'])) ? $field->field_data['allowed_types'] : '*';

		$return = Files::upload($field->field_data['folder'], null, $field->field_slug.'_file', null, null, null, $allowed_types);

		if ( ! $return['status'])
		{
			$this->CI->session->set_flashdata('notice', $return['message']);

			return null;
		}
		else
		{
			// Return the ID of the file DB entry
			return $return['data']['id'];
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting
	 *
	 * @access	public
	 * @param	array
	 * @return	mixed - null or string
	 */
	public function pre_output($input, $params)
	{
		if ( ! $input) return null;

		$this->CI->load->config('files/files');

		$file = $this->CI->db
						->limit(1)
						->select('name')
						->where('id', $input)
						->get('files')->row();

		if ($file)
		{
			return '<a href="'.base_url('files/download/'.$input).'">'.$file->name.'</a>';
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting for the plugin
	 *
	 * This creates an array of data to be merged with the
	 * tag array so relationship data can be called with
	 * a {field.column} syntax
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	mixed - null or array
	 */
	public function pre_output_plugin($input, $params)
	{
		if ( ! $input) return null;

		$file_data = array();

		$this->CI->load->config('files/files');
		$this->CI->load->helper('html');

		$db_obj = $this->CI->db->limit(1)->where('id', $input)->get('files');

		$file = $this->CI->db
						->limit(1)
						->select('name, extension, mimetype, filesize')
						->where('id', $input)
						->get('files')->row();

		if ($file)
		{
			$file_data['filename']		= $file->name;
			$file_data['file']			= site_url('files/download/'.$input);
			$file_data['ext']			= $file->extension;
			$file_data['mimetype']		= $file->mimetype;
			$file_data['filesize']		= $file->filesize;
		}
		else
		{
			$file_data['filename']		= null;
			$file_data['ext']			= null;
			$file_data['mimetype']		= null;
			$file_data['filesize']		= null;
		}

		return $file_data;
	}

	// --------------------------------------------------------------------------

	/**
	 * Choose a folder to upload to.
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function param_folder($value = null)
	{
		// Get the folders
		$this->CI->load->model('files/file_folders_m');

		$tree = $this->CI->file_folders_m->get_folders();

		$tree = (array)$tree;

		if ( ! $tree)
		{
			return '<em>'.lang('streams:file.folder_notice').'</em>';
		}

		$choices = array();

		foreach ($tree as $tree_item)
		{
			// We are doing this to be backwards compat
			// with PyroStreams 1.1 and below where
			// This is an array, not an object
			$tree_item = (object)$tree_item;

			$choices[$tree_item->id] = $tree_item->name;
		}

		return form_dropdown('folder', $choices, $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Param Allowed Types
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function param_allowed_types($value = null)
	{
		$instructions = '<p class="note">'.lang('streams:file.allowed_types_instructions').'</p>';

		return '<div style="float: left;">'.form_input('allowed_types', $value).$instructions.'</div>';
	}

}
