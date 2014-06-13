<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;
use Pyro\Module\Streams\Stream\StreamModel;

/**
 * Class Multiple
 *
 * @package Pyro\FieldType
 * @author  AI Web Systems, Inc. - Ryan Thompson
 */
class Multiple extends FieldTypeAbstract
{
    /**
     * Field type slug
     *
     * @var string
     */
    public $field_type_slug = 'multiple';

    /**
     * DB column type
     *
     * @var string
     */
    public $db_col_type = false;

    /**
     * Alt process
     *
     * @var boolean
     */
    public $alt_process = true;

    /**
     * Custom parameters
     *
     * @var array
     */
    public $custom_parameters = array(
        'input_method',
        'relation_class',
    );

    /**
     * Version
     *
     * @var string
     */
    public $version = '2.0.0';

    /**
     * Author
     *
     * @var  array
     */
    public $author = array(
        'name' => 'Ryan Thompson - PyroCMS',
        'url'  => 'https://www.pyrocms.com/about/the-team'
    );

    /**
     * Relation
     *
     * @return null|\Pyro\Module\Streams\FieldType\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function relation()
    {
        return $this->belongsToMany($this->getRelationClass(), $this->getTableName(), 'entry_id', 'related_id');
    }

    /**
     * Field event
     */
    public function fieldEvent()
    {
        if ($this->getParameter('use_ajax')) {
            $class = $this->getRelationClass();
            $model = new $class;

            $data = array(
                'value'          => $this->getRelationResult(),
                'jquerySelector' => $this->form_slug . '-selectize',
                'valueField'     => $model->getFieldTypeRelationshipValueField(),
                'searchFields'   => $model->getFieldTypeRelationshipSearchFields(),
                'itemTemplate'   => $model->getPresenter()->getFieldTypeRelationshipItemTemplate(),
                'optionTemplate' => $model->getPresenter()->getFieldTypeRelationshipOptionTemplate(),
                'relationClass'  => $this->getRelationClass(),
            );

            $this->appendMetadata($this->view('fragments/relationship.js.php', $data, true));
        }
    }

    /**
     * Output form input
     *
     * @access     public
     * @return    string
     */
    public function formInput()
    {
        $table = $this->getTableName();

        if (!$this->getParameter('use_ajax')) {
            $attributes = '';
        } else {
            $attributes = 'class="' . $this->form_slug . '-selectize skip"';
        }

        $attributes .= ' placeholder="' . lang_label($this->getPlaceholder()) . '"';

        $values = ci()->pdb
            ->table($table)
            ->whereEntryId(isset($this->entry->id) ? $this->entry->id : 0)
            ->lists('related_id');

        return form_multiselect($this->form_slug . '[]', $this->getOptions(), $values, $attributes);
    }

    /**
     * Output the form input for frontend use
     *
     * @return string
     */
    public function publicFormInput()
    {
        return form_dropdown($this->form_slug, $this->getOptions(), $this->value);
    }

    /**
     * Process before saving
     *
     * @return string
     */
    public function preSave()
    {
        $table = $this->getTableName();

        ci()->pdb->table($table)->where('entry_id', $this->entry->getKey())->delete();

        $insert = array();

        foreach ((array)ci()->input->post($this->form_slug) as $id) {
            if ($id) {
                $insert[] = array(
                    'entry_id'   => $this->entry->getKey(),
                    'related_id' => $id,
                );
            }
        }

        if (!empty($insert)) {
            ci()->pdb->table($table)->insert($insert);
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
        $options = array(null => lang_label($this->getPlaceholder())) + $this->getOptions();

        return form_dropdown($this->getFilterSlug('is'), $options, $this->getFilterValue('is'));
    }

    /**
     * String output
     *
     * @return  mixed   null or string
     */
    public function stringOutput()
    {
        $model = $this->getParameter('relation_class');

        if ($collection = $this->getRelationResult() and $collection->count() and $model = new $model) {
            return implode(', ', $collection->lists($model->getTitleColumn()));
        }

        return null;
    }

    /**
     * Plugin output
     *
     * @return array
     */
    public function pluginOutput()
    {
        if ($collection = $this->getRelationResult()) {
            return $collection;
        }

        return null;
    }

    /**
     * Data output
     *
     * @return RelationClassModel
     */
    public function dataOutput()
    {
        return $this->pluginOutput();
    }

    /**
     * Choose a stream to relate to.. or remote source
     *
     * @param  mixed $value
     * @return string
     */
    public function paramStream($value = null)
    {
        $options = StreamModel::getStreamAssociativeOptions();

        return form_dropdown('stream', $options, $value);
    }

    /**
     * Options
     *
     * @return array
     */
    public function getOptions()
    {
        if (!$this->getParameter('use_ajax')) {
            if ($relatedClass = $this->getRelationClass()) {

                $relatedModel = new $relatedClass;

                if (!$relatedModel instanceof RelationshipInterface) {
                    throw new ClassNotInstanceOfRelationshipInterfaceException;
                }

                return $relatedModel->getFieldTypeRelationshipOptions($this);
            }
        }

        return array();
    }

    /**
     * Get column name
     *
     * @return string
     */
    public function getColumnName()
    {
        return parent::getColumnName() . '_id';
    }

    /**
     * Get placeholder
     *
     * @return string
     */
    public function getPlaceholder($type = null, $default = null)
    {
        if ($this->getParameter('use_ajax')) {
            $placeholder = lang('streams.multiple.placeholder');
        } else {
            $placeholder = $this->field->field_name;
        }

        return $this->getParameter('placeholder', $placeholder);
    }

    /**
     * Run this when the field gets assigned
     *
     * @return void
     */
    public function fieldAssignmentConstruct()
    {
        $instance = $this;

        $schema = ci()->pdb->getSchemaBuilder();

        $schema->dropIfExists($this->getTableName());

        $schema->create(
            $this->getTableName(),
            function ($table) use ($instance) {
                $table->integer('entry_id');
                $table->integer('related_id');
            }
        );
    }

    /**
     * Field assignment destruct
     */
    public function fieldAssignmentDestruct()
    {
        $schema = ci()->pdb->getSchemaBuilder();

        $schema->dropIfExists($this->getTableName());
    }

    /**
     * Namespace destruct
     */
    public function namespaceDestruct()
    {
        $this->fieldAssignmentConstruct();
    }

    /**
     * Get the table
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->getStream()->stream_prefix . $this->getStream()->stream_slug . '_' . $this->field->field_slug;
    }

    /**
     * Search
     *
     * @return string
     */
    public function ajaxSearch()
    {
        $class = ci()->input->post('relation_class');
        $model = new $class;
        $term  = urldecode(ci()->input->post('term'));

        echo $model->getFieldTypeRelationshipResults($term);
    }
}