<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Field\AbstractField;
use Pyro\Module\Files\Model\Folder as Folder;

/**
 * PyroStreams Image Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_image extends AbstractField
{
	public $field_type_slug			= 'image';

	// Files are saved as 15 character strings.
	public $db_col_type				= 'string';

	public $col_constraint 			= 15;

	public $custom_parameters		= array('folder', 'resize_width', 'resize_height', 'keep_ratio', 'allowed_types');

	public $version					= '1.3.0';

	public $author					= array('name' => 'Parse19', 'url' => 'http://parse19.com');

	public $input_is_file			= true;

	// --------------------------------------------------------------------------

	public function __construct()
	{
		ci()->load->library('image_lib');
	}

	public function event()
	{
		$this->js('imagefield.js');
		$this->css('imagefield.css');		
	}

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output()
	{
		ci()->load->config('files/files');

		$out = '';
		// if there is content and it is not dummy or cleared
		if ($this->value and $this->value != 'dummy')
		{
			$out .= '<span class="image_remove">X</span><a class="image_link" href="'.site_url('files/large/'.$this->value).'" target="_break"><img src="'.site_url('files/thumb/'.$this->value).'" /></a><br />';
			$out .= form_hidden($this->getParameter('form_slug'), $this->value);
		}
		else
		{
			$out .= form_hidden($this->form_slug, 'dummy');
		}

		$options['name'] 	= $this->form_slug;
		$options['name'] 	= $this->form_slug.'_file';
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
	public function pre_save($input, $field, $stream, $row_id, $form_data)
	{
		// If we do not have a file that is being submitted. If we do not,
		// it could be the case that we already have one, in which case just
		// return the numeric file record value.
		if ( ! isset($_FILES[$field->field_slug.'_file']['name']) or ! $_FILES[$field->field_slug.'_file']['name'])
		{
			// allow dummy as a reset
			if (isset($form_data[$field->field_slug]) and $form_data[$field->field_slug])
			{
				return $form_data[$field->field_slug];
			}
			else
			{
				return null;
			}
		}

		ci()->load->library('files/files');

		// Resize options
		$resize_width 	= (isset($field->field_data['resize_width'])) ? $field->field_data['resize_width'] : null;
		$resize_height 	= (isset($field->field_data['resize_height'])) ? $field->field_data['resize_height'] : null;
		$keep_ratio 	= (isset($field->field_data['keep_ratio']) and $field->field_data['keep_ratio'] == 'yes') ? true : false;

		// If you don't set allowed types, we'll set it to allow all.
		$allowed_types 	= (isset($field->field_data['allowed_types'])) ? $field->field_data['allowed_types'] : '*';

		$return = Files::upload($field->field_data['folder'], null, $field->field_slug.'_file', $resize_width, $resize_height, $keep_ratio, $allowed_types);

		if ( ! $return['status'])
		{
			ci()->session->set_flashdata('notice', $return['message']);
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
	 * Pre Output
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function pre_output()
	{
		if ( ! $this->value or $this->value == 'dummy' ) return null;

		// Get image data
		$image = ci()->db->select('filename, alt_attribute, description, name')->where('id', $this->value)->get('files')->row();

		if ( ! $this->value) return null;

		// This defaults to 100px wide
		return '<img src="'.site_url('files/thumb/'.$this->value).'" alt="'.$this->obvious_alt($image).'" />';
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
	public function pre_output_plugin()
	{
		if ( ! $this->value or $this->value == 'dummy' ) return null;

		ci()->load->library('files/files');

		$file = Files::getFile($this->value);

		if ($file['status'])
		{
			$image = $file['data'];

			// If we don't have a path variable, we must have an
			// older style image, so let's create a local file path.
			if ( ! $image->path)
			{
				$image_data['image'] = base_url(ci()->config->item('files:path').$image->filename);
			}
			else
			{
				$image_data['image'] = str_replace('{{ url:site }}', base_url(), $image->path);
			}

			// For <img> tags only
			$alt = $this->obvious_alt($image);

			$image_data['filename']			= $image->filename;
			$image_data['name']				= $image->name;
			$image_data['alt']				= $image->alt_attribute;
			$image_data['description']		= $image->description;
			$image_data['img']				= img(array('alt' => $alt, 'src' => $image_data['image']));
			$image_data['ext']				= $image->extension;
			$image_data['mimetype']			= $image->mimetype;
			$image_data['width']			= $image->width;
			$image_data['height']			= $image->height;
			$image_data['id']				= $image->id;
			$image_data['filesize']			= $image->filesize;
			$image_data['download_count']	= $image->download_count;
			$image_data['date_added']		= $image->date_added;
			$image_data['folder_id']		= $image->folder_id;
			$image_data['folder_name']		= $image->folder_name;
			$image_data['folder_slug']		= $image->folder_slug;
			$image_data['thumb']			= site_url('files/thumb/'.$input);
			$image_data['thumb_img']		= img(array('alt' => $alt, 'src'=> site_url('files/thumb/'.$input)));

			return $image_data;
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
		// Load the library
		ci()->load->library('files/files');

		// Get the folders
		$tree = ci()->files->folderTree();

		$tree = (array)$tree;

		if ( ! $tree)
		{
			return '<em>'.lang('streams:image.need_folder').'</em>';
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
	public function param_keep_ratio($value = null)
	{
		$choices = array('yes' => lang('global:yes'), 'no' => lang('global:no'));

		return array(
				'input' 		=> form_dropdown('keep_ratio', $choices, $value),
				'instructions'	=> lang('streams:image.keep_ratio_instr'));
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
		return array(
				'input'			=> form_input('allowed_types', $value),
				'instructions'	=> lang('streams:image.allowed_types_instr'));
	}

	// --------------------------------------------------------------------------

	/**
	 * Obvious alt attribute for <img> tags only
	 *
	 * @access	private
	 * @param	obj
	 * @return	string
	 */
	private function obvious_alt($image)
	{
		if ($image->alt_attribute) {
			return $image->alt_attribute;
		}
		if ($image->description) {
			return $image->description;
		}
		return $image->name;
	}

}
