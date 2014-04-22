<?php namespace Pyro\FieldType;

use Pyro\Module\Files\Model\Folder;
use Pyro\Module\Files\Model\File as FileModel;
use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams Image Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Image extends FieldTypeAbstract
{
    /**
     * Field type slug
     * @var string
     */
	public $field_type_slug = 'image';

	/**
     * Files are stored as string IDs
     * @var string
     */
	public $db_col_type = false;

    /**
     * Alternative processing
     * Because field_slug != column
     * @var boolean
     */
    public $alt_process = true;

    /**
     * Custom field type options
     * @var array
     */
	public $custom_parameters = array(
		'folder',
		'resize_width',
		'resize_height',
		'keep_ratio',
		'allowed_types',
		'on_entry_destruct',
		);

    /**
     * Field type version
     * @var string
     */
	public $version = '1.3.0';

    /**
     * Who done it
     * @var array
     */
	public $author = array(
		'name' => 'Ryan Thompson - PyroCMS',
		'url' => 'http://pyrocms.com/'
		);

    /**
     * Construct
     */
	public function __construct()
	{
		ci()->load->library('image_lib');
		ci()->load->library('files/files');
	}

    /**
     * The field type relation
     * @return object
     */
    public function relation()
    {
        return $this->belongsTo($this->getParameter('relation_class', 'Pyro\Module\Files\Model\File'));
    }

	/**
	 * Run when building a form per type
	 * @return void 
	 */
	public function event()
	{
		$this->js('imagefield.js');
		$this->css('imagefield.css');		
	}

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function formInput()
	{
		ci()->load->config('files/files');

		$out = '';
		
		// if there is content and it is not dummy or cleared
		if ($this->value and $this->value != 'dummy') {

			$file = FileModel::find($this->value);

			$folder = Folder::find($file->folder_id);

			$path = ci()->parser->parse_string($file->path, $folder, true, false, null, false);

			$out .= '<span class="image_remove">X</span><a class="image_link" href="'.$path.'" target="_break"><img src="'.$path.'" /></a><br />';
			$out .= form_hidden($this->form_slug.'_id', $this->value);
		
		} else {

			$file = null;

			$out .= form_hidden($this->form_slug.'_id', 'dummy');

		}

		$options['name'] 	= $this->form_slug.'_file';

		$out .= '
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<div class="input-group">
						<div class="form-control uneditable-input span3" data-trigger="fileinput">
							<i class="glyphicon glyphicon-file fileinput-exists"></i>
							<span class="fileinput-filename">'.($file ? $file->name : null).'</span>
						</div>
						<span class="input-group-addon btn btn-default btn-file">
							<span class="fileinput-new">'.lang('streams:image.select_file').'</span>
							<span class="fileinput-exists">'.lang('streams:image.change').'</span>
							'.form_upload($options).'
						</span>
						<a href="#" class="input-group-addon btn btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times-circle"></i></a>
					</div>
				</div>';

		
		return $out;
	}

	/**
	 * Output public form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function publicFormInput()
	{
		// Gotta use this..
		ci()->load->config('files/files');

		// Load our file
		if ($this->value and $this->value != 'dummy')
			$file = FileModel::find($this->value);
		else
			$file = null;

		// Build the input's options
		$options['name'] = $this->form_slug.'_file';

		// GO!
		return form_upload($options).form_hidden($this->form_slug.'_id', $this->value);
	}

	/**
	 * Process before saving to database
	 *
	 * @access	public
	 * @param	array
	 * @param	obj
	 * @return	string
	 */
	public function preSave()
	{
		// If we do not have a file that is being submitted. If we do not,
		// it could be the case that we already have one, in which case just
		// return the numeric file record value.
		if ( ! isset($_FILES[$this->form_slug.'_file']['name']) or ! $_FILES[$this->form_slug.'_file']['name'])
		{
			// return what we got
			return $this->value;
		}

		ci()->load->library('files/files');

		// Resize options
		$return = \Files::upload(
			$this->getParameter('folder'),
			null,
			$this->form_slug.'_file',
			$this->getParameter('resize_width', null),
			$this->getParameter('resize_height', null),
			$this->getParameter('keep_ratio', false),
			$this->getParameter('allowed_types', '*')
			);

		if (! $return['status']) {
			ci()->session->set_flashdata('warning', $return['message']);
			return null;
		} else {
            \Events::trigger('file_uploaded', $return);
			return $return['data']['id'];
		}
	}

	/**
	 * Pre Output
	 * @return	Pyro\Module\Files\Model\File
	 */
	public function stringOutput()
	{
        if ($image = $this->getRelationResult()) {
            $attribtues = array(
                'width' => '100',
                'class' => 'img-thumbnail',
                );

            return img(ci()->parser->parse_string(
                $image->path,
                $$image->folder,
                true,
                false,
                null,
                false
                ),
            $this->obviousAlt($image),
            $attribtues
            );
        }
	}

	/**
     * Process before outputting for the plugin
     * @return array or null
     */
	public function pluginOutput()
	{
		if ($image = $this->getRelationResult()) {
            return $image->toArray();
        }

        return null;
	}

	/**
	 * Process before outputting for PHP
	 *
	 * @access	public
	 * @return	File
	 */
	public function dataOutput()
	{
		if ($image = $this->getRelationResult()) {
            return $image;
        }

        return null;
	}

	/**
	 * Ran when the entry is deleted
	 * @return void
	 */
	public function entryDestruct()
	{
		if ($this->getParameter('on_entry_destruct', 'keep') == 'delete') {
			
			// Delete that file
			\Files::deleteFile($this->value);
		}
	}

    /**
     * Overide the column name like field_slug_id
     * @param  Illuminate\Database\Schema   $schema
     * @return void
     */
    public function fieldAssignmentConstruct($schema)
    {
        $tableName = $this->getStream()->stream_prefix.$this->getStream()->stream_slug;

        $schema->table($tableName, function($table) {
            $table->string($this->field->field_slug.'_id')->nullable();
        });
    }

    /**
     * Get column name
     * @return string
     */
    public function getColumnName()
    {
        return parent::getColumnName().'_id';
    }

	/**
	 * Choose a folder to upload to.
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function paramFolder($value = null)
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

	/**
	 * Param Resize Width
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function paramResizeWidth($value = null)
	{
		return form_input('resize_width', $value);
	}

	/**
	 * Param Resize Height
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function paramResizeHeight($value = null)
	{
		return form_input('resize_height', $value);
	}

	/**
	 * Param Allowed Types
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function paramKeepRatio($value = null)
	{
		$choices = array('yes' => lang('global:yes'), 'no' => lang('global:no'));

		return array(
				'input' 		=> form_dropdown('keep_ratio', $choices, $value),
				'instructions'	=> lang('streams:image.keep_ratio_instr'));
	}

	/**
	 * Param Allowed Types
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function paramAllowedTypes($value = null)
	{
		return array(
				'input'			=> form_input('allowed_types', $value),
				'instructions'	=> lang('streams:image.allowed_types_instr'));
	}

	/**
	 * Obvious alt attribute for <img> tags only
	 *
	 * @access	private
	 * @param	obj
	 * @return	string
	 */
	private function obviousAlt($image)
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
