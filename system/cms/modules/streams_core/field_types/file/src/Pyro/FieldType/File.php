<?php namespace Pyro\FieldType;

use Pyro\Module\Files\Model\Folder;
use Pyro\Module\Files\Model\File as FileModel;
use Pyro\Module\Streams_core\Core\Field\AbstractField;

/**
 * PyroStreams File Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class File extends AbstractField
{
	public $field_type_slug			= 'file';

	// Files are saved as 15 character strings.
	public $db_col_type				= 'string';
	
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
	public function formInput($params)
	{
		ci()->load->config('files/files');

		// Get the file
		if ($this->value) {
			$current_file = FileModel::find($this->value);
		} else {
			$current_file = null;
		}

		$out = '';

		if ($current_file) {
			$out .= '<div class="file_info"><span href="#" class="file_remove">X</span><a href="'.base_url('files/download/'.$current_file->id).'">'.$current_file->name.'</a></div>';
		}

		// Output the actual used value
		$out .= form_hidden($this->form_slug, $this->getValue('dummy'));

		$options['name'] 	= $this->form_slug;
		$options['name'] 	= $this->form_slug.'_file';

		$this->js('filefield.js');
		$this->css('filefield.css');

		return $out .= form_upload($options);
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before saving to database
	 *
	 * @param	array
	 * @param	obj
	 * @return	string
	 */
	public function preSave($input, $field)
	{
		// If we do not have a file that is being submitted. If we do not,
		// it could be the case that we already have one, in which case just
		// return the numeric file record value.
		if ( ! isset($_FILES[$field->field_slug.'_file']['name']) or ! $_FILES[$field->field_slug.'_file']['name']) {
			if (ci()->input->post($field->field_slug)) {
				return ci()->input->post($field->field_slug);
			} else {
				return null;
			}
		}

		ci()->load->library('files/files');

		// If you don't set allowed types, we'll set it to allow all.
		$allowed_types 	= (isset($field->field_data['allowed_types'])) ? $field->field_data['allowed_types'] : '*';

		$return = Files::upload($field->field_data['folder'], null, $field->field_slug.'_file', null, null, null, $allowed_types);

		if (! $return['status']) {
			ci()->session->set_flashdata('notice', $return['message']);

			return null;
		} else {
			// Return the ID of the file DB entry
			return $return['data']['id'];
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting
	 *
	 * @param	array
	 * @return	mixed - null or string
	 */
	public function stringOutput($input, $params)
	{
		if ( ! $input) return null;

		ci()->load->config('files/files');

		$file = FileModel::find($input);

		if ($file) {
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
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	mixed - null or array
	 */
	public function pluginOutput($input, $params)
	{
		if ( ! $input) return null;

		$image_data = array();

		ci()->load->config('files/files');
		ci()->load->helper('html');

		$file = FileModel::find($input);

		return $file ? $file : false;
	}

	// --------------------------------------------------------------------------

	/**
	 * Choose a folder to upload to.
	 *
	 * @param	[string - value]
	 * @return	string
	 */
	public function paramFolder($value = null)
	{
		ci()->load->library('files/files');

		// Get the folders
		$tree = (array) Files::folderTreeRecursive();

		if (! $tree) {
			return '<em>'.lang('streams:file.folder_notice').'</em>';
		}

		$choices = array();

		foreach ($tree as $tree_item) {
			// We are doing this to be backwards compat
			// with PyroStreams 1.1 and below where
			// This is an array, not an object
			$tree_item = (object) $tree_item;

			$choices[$tree_item->id] = $tree_item->name;
		}

		return form_dropdown('folder', $choices, $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * Param Allowed Types
	 *
	 * @param	[string - value]
	 * @return	string
	 */
	public function paramAllowedTypes($value = null)
	{
		$instructions = '<p class="note">'.lang('streams:file.allowed_types_instructions').'</p>';

		return '<div style="float: left;">'.form_input('allowed_types', $value).$instructions.'</div>';
	}

}
