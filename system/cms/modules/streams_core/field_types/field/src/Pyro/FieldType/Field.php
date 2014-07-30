<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;
use Pyro\Module\Streams\Field\FieldModel;

/**
 * Field Field Type
 *
 * @author  Osvaldo Brignoni
 * @package PyroCMS\Addon\FieldType
 */
class Field extends FieldTypeAbstract
{
    /**
     * Field Type Name
     *
     * @var    string
     */
    public $field_type_name = 'Field';

    /**
     * Field Type Slug
     *
     * @var    string
     */
    public $field_type_slug = 'field';

    /**
     * Alt Process
     * This field type is alternatively processed.
     *
     * @var    bool
     */
    public $alt_process = true;

    /**
     * Database Column Type
     * We'll work with two columns [field_slug] and [field_slug]_field
     * [field_slug] string - stores the value processed by the selected field
     * [field_slug]_field int - stores the selected field id
     *
     * @var    string|bool
     */
    public $db_col_type = 'string';

    /**
     * Custom Parameters
     * namespace - the selectable fields namespace
     * slug - field_slug stored as a parameter
     *
     * @var    array
     */
    public $custom_parameters = array('namespace', 'storage', 'max_length');

    /**
     * Version Number
     *
     * @var    string
     */
    public $version = '1.0';

    /**
     * Author
     *
     * @var    string
     */
    public $author = array('name' => 'Osvaldo Brignoni', 'url' => 'http://obrignoni.com');

    protected $selected_field = null;

    protected $selectedType = null;

    protected $selected_stream = null;

    /**
     * Require columns to be selected for the query
     *
     * @return [type] [description]
     */
    public function requireEntryColumns()
    {
        return ($this->getParameter('storage') != 'custom') ? array($this->getFieldSlugColumn()) : array();
    }

    /**
     * Event
     *
     * @return void
     */
    public function event()
    {
        if ($selectedType = $this->getSelectedFieldType()) {
            $selectedType->event();
        }
    }

    /**
     * Form input
     *
     * @param   array
     * @param   integer
     * @param   object
     * @return  string
     */
    public function formInput()
    {
        $form = '';

        $selectable_fields_namespace = $this->getParameter('namespace', $this->field->field_namespace);

        if ($selectedType = $this->getSelectedFieldType()) {
            $selected_field = $selectedType->getField();

            // Build the selected field form
            $form .= form_hidden($this->getFormSlug(), $selected_field->field_slug);
            $form .= $selectedType->formInput();
        } elseif ($options = $this->getSelectableFields($selectable_fields_namespace) and !empty($options)) {
            $form = form_dropdown($this->getFormSlug(), $options, $this->getFieldSlugValue());
        } else {
            $form = lang('streams:field.must_add_fields');
        }

        return $form;
    }

    /**
     * Get selectable fields
     *
     * @param  string $selectable_fields_namespace
     * @return array
     */
    public function getSelectableFields($selectable_fields_namespace = null)
    {
        $selectable_fields_namespace = $selectable_fields_namespace ? $selectable_fields_namespace : $this->getSelectableFieldNamespace(
        );

        // This will prevent fields assigned to this stream from being selectable for entry.
        $skip_fields = array();

        $options = array();

        if ($selectable_fields_namespace and !$this->stream->assignments->isEmpty()) {
            $skip_fields = $this->stream->assignments->getFieldSlugs();
        }

        // Get the fields and display the dropdown
        if ($fields = FieldModel::findManyByNamespace($selectable_fields_namespace, null, null, $skip_fields)) {
            foreach ($fields as $selectable) {
                // Ensure the field type does NOT select itself
                if ($selectable->field_type != $this->field_type_slug) {
                    $options[$selectable->field_slug] = lang_label($selectable->field_name);
                }
            }
        }

        return $options;
    }

    /**
     * Pre Save
     * Here we delegate validation and pre processing to the selected field type and save the returned result.
     *
     * @param   array
     * @param   integer
     * @param   object
     * @return  string
     */
    // $input, $field, $stream, $row_id, $this->form_data
    public function preSave()
    {
        // @todo - find a less hacky way of checking if it has been updated
        $method = $this->entry->getOriginal('updated_at') != '0000-00-00 00:00:00' ? 'edit' : 'new';

        if ($selectedType = $this->getSelectedFieldType()) {
            $selected_field = $selectedType->getField();

            // First update the the selected field slug
            $this->entry->setAttribute($this->getColumnName(), $this->getFieldSlugValue());

            $this->entry->save();

            if ($post = ci()->input->post()) {
                // Run selected field validation
                //ci()->fields->set_rules($stream_fields, $method, array(), false, $row_id);
                //
                //and ($method == 'new' or ci()->form_validation->run() === true)
                //
                if ($this->getParameter('storage') != 'custom' and !$selectedType->alt_process) {
                    $this->entry->setAttribute($this->field->field_slug, $selectedType->preSave());

                    // Save it
                    if ($this->entry->save()) {
                        // Fire an event to after updating this entry
                        \Events::trigger(
                            'field_field_type_updated',
                            array(
                                'field'     => $this->field,
                                'stream'    => $this->stream,
                                'entry'     => $this->entry,
                                'form_data' => $post
                            )
                        );
                    }
                } else {
                    ci()->session->set_flashdata(
                        'error',
                        'Invalid ' . humanize($selected_field->field_slug) . ' value.'
                    );
                    redirect(current_url());
                }
            }
        }
    }

    /**
     * Alt Pre Output
     * Process before outputting to the backend
     *
     * @param    array
     * @return    string
     */
    public function stringOutput()
    {
        if ($selectedType = $this->getSelectedFieldType()) {
            return $selectedType->stringOutput();
        }

        return null;
    }

    /**
     * Field Assignment Construct
     *
     * @param   object
     * @param   object
     * @return  void
     */
    public function fieldAssignmentConstruct()
    {
        $maxLength = $this->getParameter('max_length', 100);
        $schema    = ci()->pdb->getSchemaBuilder();
        $self      = $this;

        $schema->table(
            $this->stream->stream_prefix . $this->stream->stream_slug,
            function ($table) use (
                $self,
                $maxLength,
                $schema
            ) {
                $field = $self->getField();

                // Add a column to store the field slug
                if (!$schema->hasColumn($table->getTable(), $field->field_slug . '_field_slug')) {
                    $table->string($field->field_slug . '_field_slug', $maxLength)->default('text');
                }

                // Add a column to store the value if it doesn't use custom storage
                if ($self->getParameter('storage') != 'custom'
                    and !$schema->hasColumn($table->getTable(), $field->field_slug)
                ) {
                    $table->text($field->field_slug)->default('');
                }
            }
        );
    }

    /**
     * Field Assignment Destruct
     *
     * @param   object
     * @param   object
     * @return  void
     */
    public function fieldAssignmentDestruct()
    {
        $schema = ci()->pdb->getSchemaBuilder();

        // We have to do this trick for PHP 5.3.7+
        $self = $this;

        $schema->table(
            $this->stream->stream_prefix . $this->stream->stream_slug,
            function ($table) use ($self, $schema) {

                $field = $self->getField();

                // Drop the field slug column
                if ($schema->hasColumn($table->getTable(), $field->field_slug . '_field_slug')) {
                    $table->dropColumn($field->field_slug . '_field_slug');
                }

                // Drop the value column if it doesn't use custom storage
                if ($self->getParameter('storage') != 'custom'
                    and $schema->hasColumn($table->getTable(), $field->field_slug)
                ) {

                    $table->dropColumn($field->field_slug);
                }
            }
        );
    }

    /**
     * Get column name
     *
     * @return string
     */
    public function getColumnName()
    {
        return parent::getColumnName() . '_field_slug';
    }

    /**
     * Namespace Parameter
     *
     * @param   string
     * @return  array
     */
    public function paramNamespace($value = null)
    {
        $options = array(
            0 => lang('streams:field.param_default')
        );

        $options = array_merge($options, FieldModel::getFieldNamespaceOptions());

        return array(
            'input'        => form_dropdown('namespace', $options, $value),
            'instructions' => lang('streams:field.namespace_instructions')
        );
    }

    /**
     * Storage Parameter
     *
     * @param   string
     * @return  array
     */
    public function paramStorage($value = null)
    {
        $options = array(
            'default' => lang('streams:field.param_default'),
            'custom'  => lang('streams:field.param_custom')
        );

        return array(
            'input'        => form_dropdown('storage', $options, $value),
            'instructions' => lang('streams:field.storage_instructions')
        );
    }

    public function getSelectableFieldNamespace()
    {
        return $this->getParameter('namespace', $this->field->stream_namespace);
    }

    public function getSelectedField()
    {
        if (!$fieldSlugValue = $this->getDefault()) {
            $fieldSlugValue = $this->getFieldSlugValue();
        }

        return FieldModel::findBySlugAndNamespace($fieldSlugValue, $this->getSelectableFieldNamespace());
    }

    public function getSelectedFieldType()
    {
        if ($field = $this->getSelectedField() and $selectedType = $field->getType($this->entry)) {
            $selectedType->setValueFieldSlugOverride($this->field->field_slug);

            return $selectedType;
        }

        return false;
    }

    public function getFieldSlugValue()
    {
        return $this->getFormValue($this->getColumnName(), $this->getDefault($this->getColumnName()));
    }
}
