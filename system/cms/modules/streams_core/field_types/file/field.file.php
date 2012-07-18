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
	
	public $db_col_type				= 'int';

	public $custom_parameters		= array('folder', 'allowed_types');

	public $version					= '1.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');
	
	public $input_is_file			= TRUE;
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	function form_output($params)
	{
		$this->CI->load->config('files/files');
		
		// Get the file
		$db_obj = $this->CI->db
							->where('id', $params['value'])
							->limit(1)
							->get('files');
		
		$out = '';
		
		if ($db_obj->num_rows() != 0)
		{
			$out .= $this->_output_link($db_obj->row()).'<br />';
		}
		else
		{
			$out .= '';
		}
		
		// Output the actual used value
		if (is_numeric($params['value']))
		{
			$out .= form_hidden($params['form_slug'], $params['value']);
		}
		else
		{
			$out .= form_hidden($params['form_slug'], 'dummy');
		}

		$options['name'] 	= $params['form_slug'];
		$options['name'] 	= $params['form_slug'].'_file';
		
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
		// Only go through the pre_save upload if there is a file ready to go
		if (isset($_FILES[$field->field_slug.'_file']['name']) && $_FILES[$field->field_slug.'_file']['name'] != '')
		{
			// Do nothing
		}	
		else
		{
			// If we have a file already just return that value
			if (is_numeric($this->CI->input->post( $field->field_slug )))
			{
				return $this->CI->input->post( $field->field_slug );
			}
			else
			{
				return null;
			}
		}	
	
		$this->CI->load->model('files/file_m');
		$this->CI->load->config('files/files');

		// Set upload data
		$upload_config['upload_path'] 		= FCPATH . $this->CI->config->item('files:path') . '/';
		$upload_config['allowed_types'] 	= $field->field_data['allowed_types'];

		// Do the upload
		$this->CI->load->library('upload', $upload_config);

		if ( ! $this->CI->upload->do_upload( $field->field_slug . '_file' ))
		{
			// @todo - languagize
			$this->CI->session->set_flashdata('notice', 'The following errors occurred when adding your file: '.$this->CI->upload->display_errors());	
			
			return null;
		}
		else
		{
			$file = $this->CI->upload->data();
			
			// Insert the data
			// We are going to use the PyroCMS way here.
			$this->CI->file_m->insert(array(
				'folder_id' 		=> $field->field_data['folder'],
				'user_id' 			=> $this->CI->current_user->id,
				'type' 				=> 'd',
				'name' 				=> $file['file_name'],
				'description' 		=> '',
				'filename' 			=> $file['file_name'],
				'extension' 		=> $file['file_ext'],
				'mimetype' 			=> $file['file_type'],
				'filesize' 			=> $file['file_size'],
				'date_added' 		=> time(),
			));
		
			$id = $this->CI->db->insert_id();
			
			// Return the ID
			return $id;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */	
	function pre_output($input, $params)
	{
		$this->CI->load->config('files/files');
		
		$db_obj = $this->CI->db->limit(1)->where('id', $input)->get('files');
		
		if ($db_obj->num_rows() > 0)
		{
			return $this->_output_link($db_obj->row(), false);
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
	 * @return	array
	 */
	function pre_output_plugin($input, $params)
	{
		$image_data = array();
	
		$this->CI->load->config('files/files');
		$this->CI->load->helper('html');
		
		$db_obj = $this->CI->db->limit(1)->where('id', $input)->get('files');
		
		if ($db_obj->num_rows() > 0)
		{
			$file = $db_obj->row();
					
			$file_data['filename']		= $file->name;
			$file_data['file']			= base_url().$this->CI->config->item('files:path').'/'.$file->filename;
			$file_data['ext']			= $file->extension;
			$file_data['mimetype']		= $file->mimetype;
		}
		else
		{
			$file_data['filename']		= null;
			$file_data['ext']			= null;
			$file_data['mimetype']		= null;
		}

		return $file_data;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Output link
	 *
	 * Used mostly for the back end
	 *
	 * @access	private
	 * @param	obj
	 * @return	string
	 */
	private function _output_link($file)
	{	
		return '<a href="'.$this->CI->config->item('files:path').$file->filename.'" target="_blank">'.$file->filename.'</a><br />';
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
			return '<em>'.lang('streams.file.folder_notice').'</em>';
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
		$instructions = '<p class="note">'.lang('streams.file.allowed_types_instrcutions').'</p>';
		
		return '<div style="float: left;">'.form_input('allowed_types', $value).$instructions.'</div>';
	}
	
}