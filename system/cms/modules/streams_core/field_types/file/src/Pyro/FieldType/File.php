<?php namespace Pyro\FieldType;

use Pyro\Module\Files\Model\Folder;
use Pyro\Module\Files\Model\File as FileModel;
use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams File Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class File extends FieldTypeAbstract
{
    public $field_type_slug = 'file';

    // Files are saved as 15 character strings.
    public $db_col_type = 'string';

    public $custom_parameters = array(
        'folder',
        'on_entry_destruct',
        'allowed_types',
        );

    public $version = '1.2.0';

    public $author = array('name'=>'Parse19', 'url'=>'http://parse19.com');

    public $input_is_file = true;

    // --------------------------------------------------------------------------

    public function __construct()
    {
        ci()->load->config('files/files');
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
        $out .= form_hidden($this->getFormSlug(), $this->value);

        $options['name'] 	= $this->getFormSlug();
        $options['name'] 	= $this->getFormSlug().'_file';

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
    public function preSave()
    {
        // If we do not have a file that is being submitted. If we do not,
        // it could be the case that we already have one, in which case just
        // return the numeric file record value.
        if (! isset($_FILES[$this->getFormSlug().'_file']['name']) or ! $_FILES[$this->getFormSlug().'_file']['name']) {
            if (ci()->input->post($this->getFormSlug())) {
                return ci()->input->post($this->getFormSlug());
            } else {
                return null;
            }
        }

        ci()->load->library('files/files');

        $return = \Files::upload($this->getParameter('folder'), null, $this->getFormSlug().'_file', null, null, null, $this->getParameter('allowed_types', '*'));

        if (! $return['status']) {

            // What happened now??
            ci()->session->set_flashdata('warning', $return['message']);

            return null;
        } else {
            // Return the ID of the file DB entry
            \Events::trigger('file_uploaded', $return);
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
    public function stringOutput()
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
    public function pluginOutput()
    {
        if ( ! $this->value) return null;

        $file = FileModel::find($this->value);

        return $file ? $file : false;
    }

    // --------------------------------------------------------------------------

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

    /**
     * Get column name
     * @return string
     */
    public function getColumnName()
    {
        return parent::getColumnName().'_id';
    }

}
