<?php namespace Pyro\Module\Streams_core\Cp;

// The CP driver is broken down into more logical classes

use Closure;
use Pyro\Module\Streams_core\Data;
use Pyro\Module\Streams_core\Core\Field;
use Pyro\Module\Streams_core\Core\Model;
use Pyro\Module\Streams_core\Core\Support\AbstractCp;

class Fields extends AbstractCp
{
	public static function assignmentsTable($stream_slug, $namespace = null)
	{
		$instance = static::instance(__FUNCTION__);

		$instance->stream = Data\Streams::getStream($stream_slug, $namespace);

		$instance->data->namespace = $namespace;

		return $instance;
	}

	public static function namespaceTable($namespace = null)
	{
		$instance = static::instance(__FUNCTION__);

		$instance->data->namespace = $namespace;

		return $instance;
	}

	public static function assignmentForm($stream_slug, $namespace, $assignment_id = null)
	{
		// The renderForm() method is shared with assignmentForm() and namespaceForm()
		$instance = static::instance('form');

		$instance->data->stream = Data\Streams::getStream($stream_slug, $namespace);

		$instance->data->namespace = $namespace;

		$instance->id = $assignment_id;

		if (is_numeric($assignment_id))
		{
			// If we have no assignment, we can't continue
			$instance->data->assignment = Model\FieldAssignment::findOrFail($assignment_id);

			// Find the field now
			$instance->data->current_field = Model\Field::findOrFail($instance->data->assignment->field_id);
		}
		else
		{
			$instance->data->current_field = new Model\Field;
		}

		return $instance;
	}

	public static function namespaceForm($namespace, $field_id = null)
	{
		// The renderForm() method is shared with assignmentForm() and namespaceForm()
		$instance = static::instance('form');

		$instance->data->namespace = $namespace;

		$instance->id = $field_id;

		if (is_numeric($field_id))
		{
			// Find the field now
			$instance->data->current_field = Model\Field::findOrFail($field_id);
		}
		else
		{
			$instance->data->current_field = new Model\Field;
		}

		return $instance;
	}

	// --------------------------------------------------------------------------
	// RENDER METHODS
	// --------------------------------------------------------------------------
	// Render methods cannot be used directly.
	// The corresponding render method will run when you call the render() at the end of any chain of methods.
	// 
	// i.e.
	// Cp\Fields::table()->modifier()->modifier()->modifier()->render();
	// 
	// In this example, render() will call renderTable() because the first static method was table().
	// 
	// --------------------------------------------------------------------------

	protected function renderAssignmentsTable()
	{
		$this->data->buttons = $this->buttons;


		// -------------------------------------
		// Get fields and create pagination if necessary
		// -------------------------------------

		$this->data->assignments = Model\FieldAssignment::findManyByStreamId($this->stream->id, $this->limit, $this->offset, $this->direction);

		if (is_numeric($this->pagination))
		{	


			$this->data->pagination = create_pagination(
											$pagination_uri,
											ci()->fields_m->count_fields($namespace),
											$pagination, // Limit per page
											$page_uri // URI segment
										);
		}
		else
		{
			//$this->data->assignments = Model\Field::findManyByNamespace($this->data->namespace, false, 0, $this->skips);

			$this->data->pagination = null;
		}

		// Allow to set custom 'Add Field' uri
		$this->data->add_uri = $this->add_uri;
		
		// -------------------------------------
		// Build Fields
		// -------------------------------------

		$table = ci()->load->view('admin/partials/streams/assignments', $this->data, true);
		
		if ($this->view_override)
		{
			// Hooray, we are building the template ourself.
			ci()->template->build('admin/partials/blank_section', array('content' => $table));
		}
		else
		{
			// Otherwise, we are returning the table
			return $table;
		}
	}

	protected function renderNamespaceTable()
	{
		$this->data->buttons = $this->buttons;

		// -------------------------------------
		// Get fields and create pagination if necessary
		// -------------------------------------
		$this->data->fields = Model\Field::findManyByNamespace($this->data->namespace, $this->pagination, $this->offset, $this->skips);

		if (is_numeric($this->pagination))
		{	
			$this->data->pagination = create_pagination(
											$pagination_uri,
											ci()->fields_m->count_fields($namespace),
											$pagination, // Limit per page
											$page_uri // URI segment
										);
		}
		else
		{
			$this->data->pagination = null;
		}

		// Allow view to inherit custom 'Add Field' uri
		$this->data->add_uri = $this->add_uri;
		
		// -------------------------------------
		// Build Pages
		// -------------------------------------

		$table = ci()->load->view('admin/partials/streams/fields', $this->data, true);
		
		if ($this->view_override)
		{
			// Hooray, we are building the template ourself.
			ci()->template->build('admin/partials/blank_section', array('content' => $table));
		}
		else
		{
			// Otherwise, we are returning the table
			return $table;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Custom Field Form
	 *
	 * Creates a custom field form.
	 *
	 * This allows you to easily create a form that users can
	 * use to add new fields to a stream. This functions as the
	 * form assignment as well.
	 *
	 * @param	string - stream slug
	 * @param	string - namespace
	 * @param 	string - method - new or edit. defaults to new
	 * @param 	string - uri to return to after success/fail
	 * @param 	[int - the assignment id if we are editing]
	 * @param	[array - field types to include]
	 * @param	[bool - view override - setting this to true will build template]
	 * @param	[array - extra params (see below)]
	 * @return	mixed - void or string
	 *
	 * Extra parameters to pass in $extra array:
	 *
	 * title	- Title of the form header (if using view override)
	 *			$extra['title'] = 'Streams Sample';
	 * 
	 * show_cancel - bool. Show the cancel button or not?
	 * cancel_url - uri to link to for cancel button
	 *
	 * see docs for more.
	 */
	protected function renderForm()
	{

		if ($_POST and ci()->input->post('field_type'))
		{
			$this->data->current_field->field_type = ci()->input->post('field_type');
		}

		// Need this for the view
		$this->data->method = $this->id ? 'edit' : 'new';

		$types = $this->getSelectableFieldTypes();

		// Get our list of available fields
		$this->data->field_types = $types->getOptions();

		// -------------------------------------
		// Field Type Assets
		// -------------------------------------
		// These are assets field types may
		// need when adding/editing fields
		// -------------------------------------
   		Field\Type::loadFieldCrudAssets($types);

		// -------------------------------------
		// Get the field if we have the assignment
		// -------------------------------------
		// We'll always work off the assignment.
		// -------------------------------------

   		$this->data->allow_title_column_set = $this->allow_title_column_set;

		// -------------------------------------
		// Cancel Button
		// -------------------------------------

		$this->data->show_cancel = $this->show_cancel;
		$this->data->cancel_uri = $this->cancel_uri;

		// -------------------------------------
		// Validation & Setup
		// -------------------------------------

		if ( ! $this->id)
		{
			//ci()->fields_m->fields_validation[1]['rules'] .= '|streams_unique_field_slug[new:'.$namespace.']';

			// ci()->fields_m->fields_validation[1]['rules'] .= '|streams_col_safe[new:'.$this->stream->stream_prefix.$this->stream->stream_slug.']';
		}
		else
		{
			// @todo edit version of this.
			// ci()->fields_m->fields_validation[1]['rules'] .= '|streams_unique_field_slug['.$this->data->current_field->field_slug.':'.$namespace.']';

			// ci()->fields_m->fields_validation[1]['rules'] .= '|streams_col_safe[edit:'.$this->stream->stream_prefix.$this->stream->stream_slug.':'.$this->data->current_field->field_slug.']';
		}

		$assign_validation = array(
			array(
				'field'	=> 'is_required',
				'label' => 'Is Required', // @todo languagize
				'rules'	=> 'trim'
			),
			array(
				'field'	=> 'is_unique',
				'label' => 'Is Unique', // @todo languagize
				'rules'	=> 'trim'
			),
			array(
				'field'	=> 'instructions',
				'label' => 'Instructions', // @todo languageize
				'rules'	=> 'trim'
			)
		);

		// @todo - fix this
		// Get all of our valiation into one super validation object
		$validation = array(); //array_merge(ci()->fields_m->fields_validation, $assign_validation);

		// Check if $skips is set to bypass validation for specified field slugs

		// No point skipping field_name & field_type
		$disallowed_skips = array('field_name', 'field_type');

		if (count($this->skips) > 0)
		{
			foreach ($this->skips as $skip)
			{
				// First check if the current skip is disallowed
				if (in_array($skip['slug'], $disallowed_skips))
				{
					continue;
				}

				foreach ($validation as $key => $value) 
				{
					if (in_array($value['field'], $skip))
					{
						unset($validation[$key]);
					}
				}
			}
		}

		if (ci()->input->post('field_type'))
		{
			$field_type = ci()->input->post('field_type');
		}
		else
		{
			$field_type = $this->data->current_field->field_type;
		}

		//ci()->form_validation->set_rules($validation);

		// -------------------------------------
		// Process Data
		// -------------------------------------
		// ci()->form_validation->run() - @todo - fix validation
		// 
		$post_data = ci()->input->post();

		// Repopulate title column set
		$this->data->title_column_status = false;

		if (isset($this->data->stream))
		{
			if ($this->data->allow_title_column_set and $this->data->current_field->getKey())
			{
				if ($this->data->stream->title_column)
				{
					if ($this->data->stream->title_column == ci()->input->post('title_column'))
					{
						$post_data['title_column'] = $this->data->current_field->field_slug;
						
						$this->data->title_column_status = true;
					}
				}
				elseif ($this->data->stream->title_column and $this->data->stream->title_column == $this->data->current_field->field_slug)
				{
					$this->data->title_column_status = true;
				}
			}
			elseif ($this->data->allow_title_column_set and ! $this->data->current_field->getKey())
			{
				if (ci()->input->post('title_column'))
				{
					$post_data['title_column'] = $this->data->current_field->field_slug;

					$this->data->title_column_status = true;	
				}
			}			
		}

		if ($post_data)
		{
			// -------------------------------------
			// See if we need our param fields
			// -------------------------------------
			
			// Set custom data from $skips param
			if (count($this->skips) > 0)
			{	
				foreach ($this->skips as $skip)
				{
					if ($skip['slug'] == 'field_slug' && ( ! isset($skip['value']) || empty($skip['value'])))	
					{
						show_error('Set a default value for field_slug in your $skips param.');
					}
					else
					{
						$post_data[$skip['slug']] = $skip['value'];
					}
				}
			}

			if ($this->data->method == 'new')
			{
				if ( ! $field = Model\Field::create(array_merge($post_data, array(
						'field_name' => $post_data['field_name'],
						'field_slug' => $post_data['field_slug'],
						'field_type' => $post_data['field_type'],
						'field_namespace' => $this->data->namespace,			
					))))
				{
					ci()->session->set_flashdata('notice', lang('streams:save_field_error'));	
				}
				elseif (isset($this->data->stream))
				{
					// Add the assignment
					if( ! $this->data->stream->assignField($field, $post_data))
					{
						ci()->session->set_flashdata('notice', lang('streams:save_field_error'));	
					}
					else
					{
						ci()->session->set_flashdata('success', (isset($extra['success_message']) ? $extra['success_message'] : lang('streams:field_add_success')));	
					}
				}
			}
			else
			{
				if ( ! $this->data->current_field->update(array_merge($post_data,array('field_namespace' => $this->data->namespace))))
				{
					ci()->session->set_flashdata('notice', lang('streams:save_field_error'));	
				}
				elseif (isset($this->data->assignment))
				{
					// Add the assignment
					if( ! $this->data->assignment->update($post_data))
					{
						ci()->session->set_flashdata('notice', lang('streams:save_field_error'));	
					}
					else
					{
						ci()->session->set_flashdata('success', (isset($extra['success_message']) ? $extra['success_message'] : lang('streams:field_update_success')));
					}
				}

			}
	
			// Figure out where this is coming from - post or data

			if ($this->data->current_type = Field\Type::getLoader()->getType($field_type))
			{				
				$field_data = array();

				if (isset($this->data->current_type->custom_parameters) and is_array($this->data->current_type->custom_parameters))
				{
					// Build items out of post data
					foreach ($this->data->current_type->custom_parameters as $param)
					{
						if ($value = ci()->input->post($param))
						{
							$field_data[$param] = $value;
						}
						elseif (isset($this->data->current_field->field_data[$param]))
						{
							$field_data[$param] = $this->data->current_field->field_data[$param];
						}
					}
				}
			}

			$this->data->current_field->field_data = $field_data;

			$this->data->current_field->save();
			
			redirect($this->return);
		}

		$this->data->parameter_output = Field\Type::buildParameters($field_type, $this->data->namespace, $this->data->current_field);
		

		// -------------------------------------
		// Set our data for the form	
		// -------------------------------------

		foreach ($validation as $field)
		{
			if ( ! isset($_POST[$field['field']]) and $this->id)
			{
				// We don't know where the value is. Hooray
				if (isset($this->data->current_field->{$field['field']}))
				{
					$this->data['field']->{$field['field']} = $this->data->current_field->{$field['field']};
				}
				else
				{
					$this->data['field']->{$field['field']} = $assignment->{$field['field']};
				}
			}
			else
			{
				$this->data['field']->{$field['field']} = ci()->input->post($field['field']);
			}
		}

		// -------------------------------------
		// Run field setup events
		// -------------------------------------
		Field\Form::runFieldSetupEvents($this->data->current_field);

		// -------------------------------------
		// Build page
		// -------------------------------------

		ci()->template->append_js('streams/fields.js');

		// Set the cancel URI. If there is no cancel URI, then we won't
		// have a cancel button.
		$this->data->cancel_uri = $this->cancel_uri;

		$table = ci()->load->view('admin/partials/streams/field_form', $this->data, true);
		
		if ($this->view_override)
		{
			// Hooray, we are building the template ourself.
			ci()->template->build('admin/partials/blank_section', array('content' => $table));
		}
		else
		{
			// Otherwise, we are returning the table
			return $table;
		}
	}

	public function getSelectableFieldTypes()
	{
		$types = Field\Type::getLoader()->getAllTypes();

		// -------------------------------------
		// Include/Exclude Field Types
		// -------------------------------------
		// Allows the inclusion or exclusion of
		// field types.
		// -------------------------------------

		if ($this->include_types)
		{
			$types = $types->includes($this->include_types);
		}
		elseif (count($this->exclude_types) > 0)
		{
			$types = $types->excludes($this->exclude_types);
		}

		return $types;
	}

}