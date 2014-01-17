<?php namespace Pyro\FieldType;

use Pyro\Module\Files\Model\Folder;
use Pyro\Module\Files\Model\File as FileModel;
use Pyro\Module\Streams_core\AbstractFieldType;

/**
 * PyroStreams File Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class File extends AbstractFieldType
{
    /**
     * Field type slug
     * @var string
     */
	public $field_type_slug = 'file';

    /**
     * No column - we'll make our own below
     * @var boolean
     */
	public $db_col_type = false;
	
    /**
     * Custom field type parameters
     * @var array
     */
	public $custom_parameters = array(
		'folder',
		'on_entry_destruct',
		'allowed_types',
		);

    /**
     * Field type version
     * @var string
     */
	public $version = '1.2.0';

    /**
     * Who made it?
     * @var array
     */
	public $author = array(
        'name '=> 'Ryan Thompson - PyroCMS',
        'url' => 'http://www.pyrocms.com/'
        );

    /**
     * Construct
     */
    public function __construct()
	{
		ci()->load->config('files/files');
	}

    /**
     * The field type relation
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function relation()
    {
        return $this->belongsTo($this->getRelationClass('Pyro\Module\Files\Model\File'));
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
		// Get the file
		if ($this->value) {
			$file = FileModel::find($this->value);
		} else {
			$file = null;
		}

		$out = '';

		if ($file) {
			$out .= '<div class="file_info"><span href="#" class="file_remove">X</span><a href="'.base_url('files/download/'.$file->id).'">'.$file->name.'</a></div>';
		}

		// Output the actual used value
		$out .= form_hidden($this->form_slug.'_id', $this->value);

		$options['name'] 	= $this->form_slug.'_file';

		$this->js('filefield.js');
		$this->css('filefield.css');

		return $out .= form_upload($options);
	}

	/**
	 * Process before saving to database
	 *
	 * @param	array
	 * @param	obj
	 * @return	string
	 */
	public function preSave()
	{
		// If we do not have a file that is being submitted. If we do not,
		// it could be the case that we already have one, in which case just
		// return the numeric file record value.
		if (! isset($_FILES[$this->form_slug.'_file']['name']) or ! $_FILES[$this->form_slug.'_file']['name']) {
			if (ci()->input->post($this->form_slug.'_id')) {
				return ci()->input->post($this->form_slug.'_id');
			} else {
				return null;
			}
		}

		ci()->load->library('files/files');

		$return = \Files::upload($this->getParameter('folder'), null, $this->form_slug.'_file', null, null, null, $this->getParameter('allowed_types', '*'));

		if (! $return['status']) {
			ci()->session->set_flashdata('warning', $return['message']);
			return null;
		} else {
			return $return['data']['id'];
		}
	}

	/**
     * Format the Admin output
     * 
     * @return [type] [description]
     */
    public function stringOutput()
    {
        if ($file = $this->getRelationResult()) {
            return '<a href="'.base_url('files/download/'.$file->id).'">'.$file->name.'</a>';
        }
    }

    /**
     * Pre Ouput Plugin
     * 
     * This takes the data from the join array
     * and formats it using the row parser.
     * 
     * @return array
     */
    public function pluginOutput()
    {
        if ($file = $this->getRelationResult()) {
            return $file->toArray();
        }

        return null;
    }

    /**
     * Pre Ouput Data 
     * @return array
     */
    public function dataOutput()
    {
        if ($file = $this->getRelationResult()) {
            return $file;
        }

        return null;
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
	 * Choose a folder to upload to.
	 *
	 * @param	[string - value]
	 * @return	string
	 */
	public function paramFolder($value = null)
	{
		ci()->load->library('files/files');

		// Get the folders
		$tree = (array) \Files::folderTreeRecursive();

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
