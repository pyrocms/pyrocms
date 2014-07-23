<?php namespace Pyro\Module\Streams\Ui;

// The CP driver is broken down into more logical classes

use Pyro\Module\Streams\Exception\FieldAssignmentModelNotFoundException;
use Pyro\Module\Streams\Field\FieldAssignmentModel;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\FieldType\FieldTypeManager;
use Pyro\Module\Streams\Stream\StreamModel;

class FieldUi extends UiAbstract
{
    /**
     * Set table for namespace
     *
     * @param  string $namespace
     * @return object
     */
    public function namespaceTable($namespace = null)
    {
        $this->triggerMethod(__FUNCTION__);

        $this->namespace = $namespace;

        return $this;
    }

    /**
     * trigger assignment form
     *
     * @param  string  $stream_slug
     * @param  string  $namespace
     * @param  integer $assignment_id
     * @return object
     */
    public function assignmentForm($stream_slug, $namespace, $assignment_id = null)
    {
        $this
            ->triggerMethod('form')
            ->stream(StreamModel::findBySlugAndNamespace($stream_slug, $namespace))
            ->namespace($namespace)
            ->id($assignment_id);

        if (is_numeric($assignment_id)) {

            try {
                $this
                    // If we have no assignment, we can't continue
                    ->assignment(FieldAssignmentModel::findOrFail($assignment_id))
                    // Find the field now
                    ->currentField(FieldModel::findOrFail($this->assignment->field_id));

            } catch (FieldAssignmentModelNotFoundException $e) {
                $this->abort(true);
            }

        } else {

            $this
                ->assignment(new FieldAssignmentModel)
                ->currentField(new FieldModel);
        }

        return $this;
    }

    /**
     * trigger field form in namespace
     *
     * @param  string  $namespace
     * @param  integer $fieldId
     * @return object
     */
    public function namespaceForm($namespace, $fieldId = null)
    {
        $this
            ->triggerMethod('form')
            ->namespace($namespace)
            ->id($fieldId);

        if (is_numeric($fieldId)) {
            // Find the field now
            $this->currentField(FieldModel::findOrFail($fieldId));
        } else {
            $this->currentField(new FieldModel);
        }

        return $this;
    }

    /**
     * Set instance per stream and namespace
     *
     * @param  strign $stream_slug
     * @param  string $namespace
     * @return object
     */
    public function assignmentsTable($stream_slug, $namespace = null)
    {
        $this->triggerMethod(__FUNCTION__);

        $this->stream = StreamModel::findBySlugAndNamespace($stream_slug, $namespace);

        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Boot
     *
     * @return array|void
     */
    protected function boot()
    {
        $this->messages(
            array(
                'success' => lang('streams:field_save_success'),
                'error'   => lang('streams:save_field_error')
            )
        );
    }

    // --------------------------------------------------------------------------
    // trigger METHODS
    // --------------------------------------------------------------------------
    // trigger methods cannot be used directly.
    // The corresponding trigger method will run when you call the render() at the end of any chain of methods.
    //
    // i.e.
    // FieldUi::table()->modifier()->modifier()->modifier()->render();
    //
    // In this example, render() will call triggerTable() because the first method was table().
    //
    // --------------------------------------------------------------------------

    /**
     * trigger assignments table
     *
     * @return string
     */
    protected function triggerAssignmentsTable()
    {
        // -------------------------------------
        // Get fields and create pagination if necessary
        // -------------------------------------
        $this->assignments = FieldAssignmentModel::findManyByStreamId(
            $this->stream->id,
            $this->limit,
            $this->offset,
            $this->sort,
            false
        );

        foreach ($this->assignments as $k => $assignment) {
            if ($assignment->field and $assignment->field->is_locked == 'yes') {
                unset($this->assignments[$k]);
            }
        }

        if ($this->limit > 0) {
            $this->paginationTotalRecords(FieldAssignmentModel::countByStreamId($this->stream->id, false));
        }

        ci()->template->append_metadata('<script>var fields_offset=' . (int)$this->offset . ';</script>');
        ci()->template->append_js('streams/assignments.js');

        $this->content = ci()->load->view('streams_core/fields/table_assignments', $this->attributes, true);

        return $this;
    }

    /**
     * trigger namespace table
     *
     * @return string
     */
    protected function triggerNamespaceTable()
    {
        // -------------------------------------
        // Get fields and create pagination if necessary
        // -------------------------------------
        $this->fields = FieldModel::findManyByNamespace($this->namespace, $this->limit, $this->offset, $this->skips);

        if ($this->limit) {
            $this->paginationTotalRecords(ci()->fields_m->count_fields($this->namespace));
        }

        $this->content = ci()->load->view('streams_core/fields/table_namespace', $this->attributes, true);

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Custom Field Form
     * Creates a custom field form.
     * This allows you to easily create a form that users can
     * use to add new fields to a stream. This functions as the
     * form assignment as well.
     *
     * @param    string - stream slug
     * @param    string - namespace
     * @param    string - method - new or edit. defaults to new
     * @param    string - uri to return to after success/fail
     * @param    [int - the assignment id if we are editing]
     * @param    [array - field types to include]
     * @param    [bool - view override - setting this to true will build template]
     * @param    [array - extra params (see below)]
     * @return    mixed - void or string
     *                  Extra parameters to pass in $extra array:
     *                  title    - Title of the form header (if using view override)
     *                  $extra['title'] = 'Streams Sample';
     *                  show_cancel - bool. Show the cancel button or not?
     *                  cancel_url - uri to link to for cancel button
     *                  see docs for more.
     */
    protected function triggerForm()
    {
        if ($redirect = $this->getRedirectSave() and $this->getAbort()) {
            redirect($redirect);
        }

        if ($_POST and ci()->input->post('field_type')) {
            $this->currentField->field_type = ci()->input->post('field_type');
        }

        // Need this for the view
        $this->method = $this->id ? 'edit' : 'new';

        $types = $this->getSelectableFieldTypes();

        // Get our list of available fields
        $this->field_types = array(null => '-----') + $types->getOptions();

        // -------------------------------------
        // Field Type Assets
        // -------------------------------------
        // These are assets field types may
        // need when adding/editing fields
        // -------------------------------------
        FieldTypeManager::loadFieldCrudAssets($types);


        // -------------------------------------
        // Cancel Button
        // -------------------------------------

        /*        $this->show_cancel = $this->show_cancel;
                $this->cancel_uri = $this->cancel_uri;*/

        // -------------------------------------
        // Validation & Setup
        // -------------------------------------

        if (!$this->id) {
            //ci()->fields_m->fields_validation[1]['rules'] .= '|streams_unique_field_slug[new:'.$namespace.']';

            // ci()->fields_m->fields_validation[1]['rules'] .= '|streams_col_safe[new:'.$this->stream->stream_prefix.$this->stream->stream_slug.']';
        } else {
            // @todo edit version of this.
            // ci()->fields_m->fields_validation[1]['rules'] .= '|streams_unique_field_slug['.$this->currentField->field_slug.':'.$namespace.']';

            // ci()->fields_m->fields_validation[1]['rules'] .= '|streams_col_safe[edit:'.$this->stream->stream_prefix.$this->stream->stream_slug.':'.$this->currentField->field_slug.']';
        }

        $assign_validation = array(
            array(
                'field' => 'is_required',
                'label' => 'Is Required', // @todo languagize
                'rules' => 'trim'
            ),
            array(
                'field' => 'is_unique',
                'label' => 'Is Unique', // @todo languagize
                'rules' => 'trim'
            ),
            array(
                'field' => 'instructions',
                'label' => 'Instructions', // @todo languageize
                'rules' => 'trim'
            )
        );

        // @todo - fix this
        // Get all of our valiation into one super validation object
        $validation = array(); //array_merge(ci()->fields_m->fields_validation, $assign_validation);

        // Check if $skips is set to bypass validation for specified field slugs

        // No point skipping field_name & field_type
        /*		$disallowed_skips = array('field_name', 'field_type');

                if (count($this->skips) > 0) {
                    foreach ($this->skips as $skip) {
                        // First check if the current skip is disallowed
                        if (in_array($skip['slug'], $disallowed_skips)) {
                            continue;
                        }

                        foreach ($validation as $key => $value) {
                            if (in_array($value['field'], $skip)) {
                                unset($validation[$key]);
                            }
                        }
                    }
                }*/

        if (ci()->input->post('field_type')) {
            $field_type = ci()->input->post('field_type');
        } else {
            $field_type = $this->currentField->field_type;
        }

        //ci()->form_validation->set_rules($validation);

        // -------------------------------------
        // Process Data
        // -------------------------------------
        // ci()->form_validation->run() - @todo - fix validation
        //
        $post_data = ci()->input->post();

        // Repopulate title column set
        $this->title_column_status = false;

        if (isset($this->stream)) {
            if ($this->enableSetColumnTitle and $this->currentField->getKey()) {
                if ($this->stream->title_column) {
                    if ($this->stream->title_column == ci()->input->post('title_column')) {
                        $post_data['title_column'] = $this->currentField->field_slug;

                        $this->title_column_status = true;
                    }
                } elseif ($this->stream->title_column and $this->stream->title_column == $this->currentField->field_slug) {
                    $this->title_column_status = true;
                }
            } elseif ($this->enableSetColumnTitle and !$this->currentField->getKey()) {
                if (ci()->input->post('title_column')) {
                    $post_data['title_column'] = $this->currentField->field_slug;

                    $this->title_column_status = true;
                }
            }
        }

        if ($post_data) {
            // -------------------------------------
            // See if we need our param fields
            // -------------------------------------

            // Set custom data from $skips param
            // @todo - fix this
            /*			if (count($this->skips) > 0) {
                            foreach ($this->skips as $skip) {
                                if ($skip['slug'] == 'field_slug' && ( ! isset($skip['value']) || empty($skip['value']))) {
                                    show_error('Set a default value for field_slug in your $skips param.');
                                } else {
                                    $post_data[$skip['slug']] = $skip['value'];
                                }
                            }
                        }*/

            // Figure out where this is coming from - post or data

            if ($this->current_type = FieldTypeManager::getType($field_type)) {
                $field_data = array();

                // Build items out of post data
                foreach ($this->current_type->getCustomParameters() as $param) {
                    if ($value = ci()->input->post($param)) {
                        $field_data[$param] = $value;
                    } elseif (isset($this->currentField->field_data[$param])) {
                        $field_data[$param] = $this->currentField->field_data[$param];
                    }
                }
            }

            $this->currentField->fill(
                array(
                    'field_name'      => $post_data['field_name'],
                    'field_slug'      => $post_data['field_slug'],
                    'field_type'      => $post_data['field_type'],
                    'field_namespace' => $this->namespace,
                    'field_data'      => $field_data
                )
            );

            if (!$this->currentField->save()) {
                ci()->session->set_flashdata('notice', lang('streams:save_field_error'));
            }

            if (isset($this->stream) and isset($this->assignment)) {
                $post_data = array(
                    'instructions' => isset($post_data['instructions']) ? $post_data['instructions'] : null,
                    'field_name'   => isset($post_data['field_name']) ? $post_data['field_name'] : null,
                    'is_required'  => isset($post_data['is_required']) ? $post_data['is_required'] : false,
                    'is_unique'    => isset($post_data['is_unique']) ? $post_data['is_unique'] : false,
                );

                if (!($edit = $this->assignment->getKey())) {
                    // Add the assignment
                    $success = $this->stream->assignField($this->currentField, $post_data);
                } else {
                    // Update the assignment
                    $success = $this->assignment->update($post_data);
                }

                if (!$success) {
                    ci()->session->set_flashdata(
                        'notice',
                        lang_label($this->getMessageError())
                    );
                } else {
                    $default_messageSuccess = $edit ? lang('streams:field_update_success') : lang(
                        'streams:field_add_success'
                    );

                    ci()->session->set_flashdata(
                        'success',
                        lang_label($this->getMessageSuccess())
                    );
                }
            }

            if ($redirect) {
                redirect($redirect);
            }
        }

        $this->parameters = FieldTypeManager::buildParameters($field_type, $this->namespace, $this->currentField);


        // -------------------------------------
        // Set our data for the form
        // -------------------------------------

        foreach ($validation as $field) {
            if (!isset($_POST[$field['field']]) and $this->id) {
                // We don't know where the value is. Hooray
                if (isset($this->currentField->{$field['field']})) {
                    $this['field']->{$field['field']} = $this->currentField->{$field['field']};
                } else {
                    $this['field']->{$field['field']} = $assignment->{$field['field']};
                }
            } else {
                $this['field']->{$field['field']} = ci()->input->post($field['field']);
            }
        }

        // -------------------------------------
        // Run field setup events
        // -------------------------------------
        /*EntryFormBuilder::runFieldSetupEvents($this->currentField);*/

        // -------------------------------------
        // Build page
        // -------------------------------------

        ci()->template->append_js('streams/fields.js');

        // Set the cancel URI. If there is no cancel URI, then we won't
        // have a cancel button.
        $this->content = ci()->load->view('streams_core/fields/form', $this->attributes, true);

        return $this;
    }

    /**
     * Get selected field types
     *
     * @return array
     */
    public function getSelectableFieldTypes()
    {
        $types = FieldTypeManager::getAllTypes();

        // -------------------------------------
        // Include/Exclude Field Types
        // -------------------------------------
        // Allows the inclusion or exclusion of
        // field types.
        // -------------------------------------

        if ($this->include_types) {
            $types = $types->includes($this->include_types);
        } elseif (count($this->exclude_types) > 0) {
            $types = $types->excludes($this->exclude_types);
        }

        return $types;
    }
}
