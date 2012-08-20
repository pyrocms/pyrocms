<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Image Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_image
{
	public $field_type_slug			= 'image';
	
	public $db_col_type				= 'int';

	public $custom_parameters		= array('folder', 'resize_width', 'resize_height', 'allowed_types');

	public $version					= '1.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

	public $input_is_file			= TRUE;

	// --------------------------------------------------------------------------
	
	public function __construct()
	{
		get_instance()->load->library('image_lib');
	}
	
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
		
		if ($params['value'])
		{
			// Get the file		
			$current_file = $this->CI->db
						->limit(1)
						->where('id', $params['value'])
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
			$out .= $this->_output_thumb($current_file, true).br();
		}
		
		// Output the actual used value
		if (is_numeric($params['value']))
		{
			$out .= form_hidden($params['form_slug'], $params['value']);
		}
		else
		{
			$out .= form_hidden( $params['form_slug'], 'dummy');
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
			if (is_numeric($this->CI->input->post($field->field_slug)))
			{
				return $this->CI->input->post($field->field_slug);
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
		
		// Set allowed types to all if there is none
		if (trim($field->field_data['allowed_types']) == '')
		{
			$upload_config['allowed_types'] 	= '*';
		}
		else
		{
			$upload_config['allowed_types'] 	= $field->field_data['allowed_types'];
		}

		// Do the upload
		$this->CI->load->library('upload', $upload_config);

		if ( ! $this->CI->upload->do_upload($field->field_slug . '_file'))
		{
			$this->CI->session->set_flashdata('notice', lang('streams.image.image_errors').' '.$this->CI->upload->display_errors());	
			
			return null;
		}
		else
		{
			$image = $this->CI->upload->data();
			
			// -------------------------------------
			// Upload File
			// -------------------------------------
			// We are going to use the PyroCMS way here.
			// -------------------------------------
			
			$img_config = array();
			
			// -------------------------------------
			// Create Thumb
			// -------------------------------------
			// No matter what, we make a thumb
			// -------------------------------------
					
			$img_config['source_image']		= FCPATH.$this->CI->config->item('files:path').$image['file_name'];
			$img_config['create_thumb'] 	= TRUE;
			$img_config['maintain_ratio'] 	= TRUE;
			$img_config['height']	 		= 1;
			$img_config['master_dim']	 	= 'width';
			
			// For small images, we don't want to
			// make a thumb that is larger than
			// the actual image.
			if ($image['image_width'] > 200)
			{
				$img_config['width']	 	= 200;
			}
			else
			{
				$img_config['width']	 	= $image['image_width'];
			}
					
			$this->CI->image_lib->initialize($img_config);
			$this->CI->image_lib->resize();			
			$this->custom_clear();
			
			unset($img_config);

			// -------------------------------------
			// Resize
			// -------------------------------------

			if (is_numeric($field->field_data['resize_width']))
			{
				$img_config['source_image']		= FCPATH . $this->CI->config->item('files:path').$image['file_name'];
				$img_config['quality']			= '100%';
				$img_config['create_thumb'] 	= false;
				$img_config['maintain_ratio'] 	= true;
				$img_config['width']	 		= $field->field_data['resize_width'];
				
				if (is_numeric($field->field_data['resize_height']))
				{
					// We are using a hard numeric value for the resize h&w
					$img_config['height']	 		= $field->field_data['resize_height'];
					$img_config['maintain_ratio']	= false;
				}	
				else
				{
					// We need to come close to what the height is, because
					// they left that blank
					$scale = $image['image_width']/$img_config['width'];
					
					$img_config['height']	 		= $image['image_height']/$scale;
					$img_config['maintain_ratio']	= true;
				}
				
				$this->CI->image_lib->initialize($img_config);
				$this->CI->image_lib->resize();
				$this->custom_clear();
			}
			
			// Use resized numbers for the files module.
			if (isset($img_config['width']) and is_numeric($img_config['width']))
			{
				$image['image_width'] = $img_config['width'];
			}

			if (isset($img_config['height']) and is_numeric($img_config['height']))
			{
				$image['image_height'] = $img_config['height'];
			}
			
			// Insert the data
			$this->CI->file_m->insert(array(
				'folder_id' 		=> $field->field_data['folder'],
				'user_id' 			=> $this->CI->current_user->id,
				'type' 				=> 'i',
				'name' 				=> $image['file_name'],
				'description' 		=> '',
				'filename' 			=> $image['file_name'],
				'extension' 		=> $image['file_ext'],
				'mimetype' 			=> $image['file_type'],
				'filesize' 			=> $image['file_size'],
				'width' 			=> (int) $image['image_width'],
				'height' 			=> (int) $image['image_height'],
				'date_added' 		=> time(),
			));
		
			$id = $this->CI->db->insert_id();
			
			unset($img_config);
			
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
	 * @return	mixed - null or string
	 */	
	public function pre_output($input, $params)
	{
		if ( ! $input) return null;

		$this->CI->load->config('files/files');
		
		$db_obj = $this->CI->db
							->limit(1)
							->where('id', $input)
							->get('files');
		
		if ($db_obj->num_rows() > 0)
		{
			return $this->_output_thumb($db_obj->row(), false);
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
	 * @return	mixed - string or array
	 */
	public function pre_output_plugin($input, $params)
	{
		if ( ! $input) return null;

		$image_data = array();
	
		$this->CI->load->config('files/files');
		$this->CI->load->helper('html');
		
		$this->CI->db->limit(1);
		$this->CI->db->where('id', $input);
		$db_obj = $this->CI->db->get('files');
		
		if ($db_obj->num_rows() > 0)
		{
			$image = $db_obj->row();
			
			$full = $this->CI->config->item('files:path').$image->name;
		
			$image_data['filename']		= $image->name;
			$image_data['image']		= base_url().$full;
			$image_data['img']			= img(array('alt'=>$image->name, 'src'=>$full));
			$image_data['ext']			= $image->extension;
			$image_data['mimetype']		= $image->mimetype;
			$image_data['width']		= $image->width;
			$image_data['height']		= $image->height;
			$image_data['id']			= $image->id;

			//If there is a thumb, add it.
			$path 			= FCPATH . $this->CI->config->item('files:path');
			$plain_name 	= str_replace($image->extension, '', $image->filename);
			
			if( file_exists( $path . '/'.$plain_name.'_thumb'.$image->extension ) )
			{
			
				$image_data['thumb']		= base_url().$this->CI->config->item('files:path').$plain_name.'_thumb' . $image->extension;
				$image_data['thumb_img']	= img( array('alt'=>$image->name, 'src'=> $this->CI->config->item('files:path').$plain_name.'_thumb' . $image->extension) );
			}
			else
			{
				// The image may be small enough to be it's own thumb, so let's
				// put that in there anyways
				$image_data['thumb']		= base_url().$full;
				$image_data['thumb_img']	= img(array('alt'=>$image->name, 'src'=>$full));
			}			
		}
		else
		{
			// We want just blank if there is no image.
			$image_data['filename']		= null;
			$image_data['image']		= null;
			$image_data['img']			= null;
			$image_data['ext']			= null;
			$image_data['mimetype']		= null;
			$image_data['width']		= null;
			$image_data['height']		= null;
			$image_data['thumb']		= null;
			$image_data['thumb_img']	= null;
		}
		
		return $image_data;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Output thumb
	 *
	 * Used mostly for the back end
	 *
	 * @access	private
	 * @param	obj
	 * @param	bool
	 * @return	string
	 */
	private function _output_thumb($image, $scale = false)
	{	
		$message = '';
	
		$this->CI->load->helper('html');

		$path 			= FCPATH . $this->CI->config->item('files:path');
		$plain_name 	= str_replace($image->extension, '', $image->filename);
	
		$image_config = array(
		          'alt' 		=> $image->name,
		          'title' 		=> $image->name
		);
			
		if (file_exists($path.'/'.$plain_name.'_thumb'.$image->extension))
		{
			$use_link = true;

			$image_config['src']	= $this->CI->config->item('files:path').'/'.$plain_name.'_thumb'.$image->extension;
		}	
		elseif (file_exists( $path . '/'.$image->name ) )
		{
			$use_link = false;

			$image_config['src']	= $this->CI->config->item('files:path').'/'.$image->name;
		}
		
		if (isset($use_link) and $use_link)
		{
			return '<a href="'.$this->CI->config->item('files:path').$image->name.'" target="_blank">'.img($image_config).'</a>'.br();
		}
		else
		{
			return img($image_config).br();
		}
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
			return '<em>'.lang('streams.image.need_folder').'</em>';
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
	 * Param Resize Width
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function param_resize_width($value = null)
	{
		return form_input('resize_width', $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Param Resize Height
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function param_resize_height($value = null)
	{
		return form_input('resize_height', $value);
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
		return form_input('allowed_types', $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Custom Clear
	 *
	 * This is a temporary solution until
	 * PyroCMS updates to the version of CodeIgniter
	 * that has the Img Library fix in it
	 *
	 * This correctly clears all of the Img Libary values
	 * and sets them back to default.
	 *
	 * @access	private
	 * @return	void
	 */
	private function custom_clear()
	{
		$props = array('library_path', 'source_image', 'new_image', 'width', 'height', 'rotation_angle', 'x_axis', 'y_axis', 'wm_text', 'wm_overlay_path', 'wm_font_path', 'source_folder', 'dest_folder', 'mime_type', 'orig_width', 'orig_height', 'image_type', 'size_str', 'full_src_path', 'full_dst_path');

		foreach ($props as $val)
		{
			$this->CI->image_lib->$val = '';
		}

		$this->CI->image_lib->image_library 		= 'gd2';
		$this->CI->image_lib->dynamic_output 		= FALSE;
		$this->CI->image_lib->quality 				= '90';
		$this->CI->image_lib->create_thumb 			= FALSE;
		$this->CI->image_lib->thumb_marker 			= '_thumb';
		$this->CI->image_lib->maintain_ratio 		= TRUE;
		$this->CI->image_lib->master_dim 			= 'auto';
		$this->CI->image_lib->wm_type 				= 'text';
		$this->CI->image_lib->wm_x_transp 			= 4;
		$this->CI->image_lib->wm_y_transp 			= 4;
		$this->CI->image_lib->wm_font_size 			= 17;
		$this->CI->image_lib->wm_vrt_alignment 		= 'B';
		$this->CI->image_lib->wm_hor_alignment 		= 'C';
		$this->CI->image_lib->wm_padding 			= 0;
		$this->CI->image_lib->wm_hor_offset 		= 0;
		$this->CI->image_lib->wm_vrt_offset 		= 0;
		$this->CI->image_lib->wm_shadow_distance 	= 2;
		$this->CI->image_lib->wm_opacity 			= 50;
		$this->CI->image_lib->create_fnc 			= 'imagecreatetruecolor';
		$this->CI->image_lib->copy_fnc 				= 'imagecopyresampled';
		$this->CI->image_lib->error_msg 			= array();
		$this->CI->image_lib->wm_use_truetype 		= FALSE;
	}
	
}