<?php namespace Pyro\FieldType;

use Illuminate\Support\Str;

use Pyro\Model\Eloquent;
use Pyro\Module\Streams_core\AbstractFieldType;
use Pyro\Module\Streams_core\EntryModel;
use Pyro\Module\Streams_core\FieldModel;
use Pyro\Module\Streams_core\StreamModel;

/**
 * PyroStreams Relationship Field Type
 *
 * @package        PyroCMS\Core\Modules\Streams Core\Field Types
 * @author        Parse19
 * @copyright    Copyright (c) 2011 - 2012, Parse19
 * @license        http://parse19.com/pyrostreams/docs/license
 * @link        http://parse19.com/pyrostreams
 */
class Relationship extends AbstractFieldType
{
    /**
     * Field type slug
     * @var string
     */
    public $field_type_slug = 'relationship';

    /**
     * DB column type
     * @var string
     */
    public $db_col_type = false;

    /**
     * Custom parameters
     * @var array
     */
    public $custom_parameters = array(
        'stream',
        'method',
        'search_fields',
        'placeholder',
        'option_format',
        'label_format',
        'relation_class',
        );

    /**
     * Version
     * @var string
     */
    public $version = '2.0';

    /**
     * Author
     * @var  array
     */
    public $author = array(
        'name' => 'Ryan Thompson - PyroCMS',
        'url' => 'http://pyrocms.com/'
        );

    ///////////////////////////////////////////////////////////////////////////////
    // -------------------------    METHODS       ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Relation
     * @return object The relation object
     */
    public function relation()
    {
        return $this->belongsTo($this->getRelationClass());
    }

    /**
     * Fired when form is built per field
     * @return void
     */
    public function fieldEvent()
    {
        // Get related entries
        $entry = $this->getRelationResult();

        // Basically the selectize config mkay?
        $this->appendMetadata(
            $this->view(
                'data/relationship.js.php',
                array(
                    'relatedModel' => $this->getRelationClass(),
                    'fieldType' => $this,
                    'entry' => $entry,
                    ),
                true
                )
            );
    }

    /**
     * Fired when filters are built per field
     * @return void
     */
    public function filterFieldEvent()
    {
        // Set the value
        $this->setValue(ci()->input->get($this->getFilterSlug('is')));
        
        // Get related entries
        $relatedModel = $this->getRelationClass();

        // Get it
        $entry = $relatedModel::select('*')->find($this->getValue());

        // Basically the selectize config mkay?
        $this->appendMetadata(
            $this->view(
                'data/relationship.js.php',
                array(
                    'relatedModel' => $this->getRelationClass(),
                    'fieldType' => $this,
                    'entry' => $entry,
                    ),
                true
                )
            );
    }

    /**
     * Output form input
     *
     * @access     public
     * @return    string
     */
    public function formInput()
    {
        // Attribtues
        $attributes = array(
            'class' => $this->form_slug.'-selectize skip',
            'placeholder' => $this->getParameter('placeholder', $this->field->field_name),
            );

        // String em up
        $attribute_string = '';

        foreach ($attributes as $attribute => $value) {
            $attribute_string .= $attribute.'="'.$value.'" ';
        }

        // Return an HTML dropdown
        return form_dropdown($this->form_slug, array(), null, $attribute_string);
    }

    /**
     * Output the form input for frontend use
     * @return string 
     */
    public function publicFormInput()
    {
        // Is this a small enough dataset?
        if ($this->totalOptions() < 1000) {
            return form_dropdown($this->form_slug, $this->getOptions(), $this->value);
        } else {
            return form_input($this->form_slug, $this->value);
        }
    }

    /**
     * Output filter input
     *
     * @access     public
     * @return    string
     */
    public function filterInput()
    {
        // Attribtues
        $attributes = array(
            'class' => $this->form_slug.'-selectize skip',
            'placeholder' => $this->getParameter('placeholder', $this->field->field_name),
            );

        // String em up
        $attribute_string = '';

        foreach ($attributes as $attribute => $value) {
            $attribute_string .= $attribute.'="'.$value.'" ';
        }

        // Return an HTML dropdown
        return form_dropdown($this->getFilterSlug('is'), array(), null, $attribute_string);
    }

    /**
     * Pre Ouput
     * @return  mixed   null or string
     */
    public function stringOutput()
    {
        if ($entry = $this->getRelationResult()) {

            return $entry->getTitleColumnValue();
        }

        return null;
    }

    /**
     * Pre Ouput Plugin
     * @return array
     */
    public function pluginOutput()
    {
        if ($entry = $this->getRelationResult()) {
            return $entry->first()->asPlugin()->toArray();
        }

        return null;
    }

    /**
     * Pre Ouput Data
     * @return RelationClassModel
     */
    public function dataOutput()
    {
        if ($entry = $this->getRelationResult()) {
            return $entry->first();
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
            $table->integer($this->field->field_slug.'_id')->nullable();
        });
    }

    /**
     * Choose a stream to relate to.. or remote source
     * @param  mixed $value
     * @return string
     */
    public function paramStream($value = '')
    {
        $options = StreamModel::getStreamAssociativeOptions();

        return form_dropdown('stream', $options, $value);
    }

    /**
     * Option format
     * @param  string $value
     * @return html
     */
    public function paramOptionFormat($value = '')
    {
        return form_input('option_format', $value);
    }

    /**
     * Label format
     * @param  string $value
     * @return html
     */
    public function paramLabelFormat($value = '')
    {
        return form_input('label_format', $value);
    }

    /**
     * Search for entries!
     * @return string JSON
     */
    public function ajaxSearch()
    {
        // Get the post data
        $post = ci()->input->post();


        /**
         * Get THIS field and type
         */
        $field = FieldModel::findBySlugAndNamespace($post['field_slug'], $post['stream_namespace']);
        $fieldType = $field->getType(null);

        
        /**
         * Get the relationClass
         */
        $relatedModel = $fieldType->getRelationClass();


        /**
         * Search for RELATED entries
         */
        if (method_exists($relatedModel, 'streamsRelationshipAjaxSearch')) {
            echo $relatedModel::streamsRelationshipAjaxSearch($fieldType);
        } else {
            echo $relatedModel::select(explode('|', $fieldType->getParameter('select_fields', '*')))
                ->where($fieldType->getParameter('search_fields', 'id'), 'LIKE', '%'.$post['term'].'%')
                ->take(10)
                ->get();
        }

        exit;
    }

    /**
     * Get filter slug
     * @param  string $condition
     * @param  string $field_slug
     * @return string
     */
    public function getFilterSlug($condition = 'contains', $field_slug = null)
    {
        $field_slug = $field_slug ? $field_slug : $this->field->field_slug;

        return $this->getFilterSlugPrefix().$field_slug.'_id-'.$condition;
    }
}
