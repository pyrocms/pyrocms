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

		$instance->namespace = $namespace;

		return $instance;
	}

	public static function namespaceTable($namespace = null)
	{
		$instance = static::instance(__FUNCTION__);

		$instance->namespace = $namespace;

		return $instance;
	}

	public static function assignmentForm($stream_slug, $namespace, $id = null)
	{
		$instance = static::instance(__FUNCTION__);

		$instance->stream = Data\Streams::getStream($stream_slug, $namespace);

		$instance->namespace = $namespace;

		$instance->id = $id;

		return $instance;
	}

	public static function namespaceForm($id)
	{
		return static::instance(__FUNCTION__);
	}

	// --------------------------------------------------------------------------

	// --------------------------------------------------------------------------
	// RENDER METHODS
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
		$this->data['buttons'] = $this->buttons;


		// -------------------------------------
		// Get fields and create pagination if necessary
		// -------------------------------------

		$this->data['assignments'] = Model\FieldAssignment::findManyByStreamId($this->stream->id, $this->limit, $this->offset, $this->direction);

		if (is_numeric($this->pagination))
		{	


			$this->data['pagination'] = create_pagination(
											$pagination_uri,
											ci()->fields_m->count_fields($namespace),
											$pagination, // Limit per page
											$page_uri // URI segment
										);
		}
		else
		{
			//$this->data['assignments'] = Model\Field::findManyByNamespace($this->namespace, false, 0, $this->skips);

			$this->data['pagination'] = null;
		}

		// Allow to set custom 'Add Field' uri
		$this->data['add_uri'] = $this->add_uri;
		
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
		$this->data['buttons'] = $this->buttons;

		// -------------------------------------
		// Get fields and create pagination if necessary
		// -------------------------------------
		$this->data['fields'] = Model\Field::findManyByNamespace($this->namespace, $this->pagination, $this->offset, $this->skips);

		if (is_numeric($this->pagination))
		{	
			$this->data['pagination'] = create_pagination(
											$pagination_uri,
											ci()->fields_m->count_fields($namespace),
											$pagination, // Limit per page
											$page_uri // URI segment
										);
		}
		else
		{
			$this->data['pagination'] = null;
		}

		// Allow view to inherit custom 'Add Field' uri
		$this->data['add_uri'] = $this->add_uri;
		
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
	protected function renderAssignmentForm()
	{
		$data = array();
		$data['current_field'] = new \stdClass;

		$data['method'] = $this->id ? 'edit' : 'new';

		$fields = $this->stream->assignments->getFields();

		// -------------------------------------
		// Include/Exclude Field Types
		// -------------------------------------
		// Allows the inclusion or exclusion of
		// field types.
		// -------------------------------------

		if ($this->include_types)
		{
			$ft_types = new stdClass();

			foreach (ci()->type->types as $type)
			{
				if (in_array($type->field_type_slug, $include_types))
				{
					$ft_types->{$type->field_type_slug} = $type;
				}
			}
		}
		elseif (count($this->exclude_types) > 0)
		{
			$ft_types = new \stdClass();

			foreach (ci()->type->types as $type)
			{
				if ( ! in_array($type->field_type_slug, $this->include_types))
				{
					$ft_types->{$type->field_type_slug} = $type;
				}
			}
		}
		else
		{
			//$ft_types = ci()->type->types;
		}

		// -------------------------------------
		// Field Type Assets
		// -------------------------------------
		// These are assets field types may
		// need when adding/editing fields
		// -------------------------------------
   		
   		//ci()->type->load_field_crud_assets($ft_types);
   		
   		// -------------------------------------
        
		// Need this for the view
		//$data['method'] = $data['method'];

		// Get our list of available fields
		$data['field_types'] = Field\Type::getLoader()->getAllTypes()->getOptions();

		// -------------------------------------
		// Get the field if we have the assignment
		// -------------------------------------
		// We'll always work off the assignment.
		// -------------------------------------

		//$this->stream->assignments


		if ($this->id)
		{
			if ( ! $data['assignment'] = Model\FieldAssignment::with('field')->find($this->id))
			{
				// If we have no assignment, we can't continue
				show_error('Could not find assignment');
			}

			// Find the field now
			$data['current_field'] = $data['assignment']->field;

			// We also must have a field if we're editing
			if ( ! $data['current_field']) show_error('Could not find field.');
		}
		elseif ($_POST and ci()->input->post('field_type'))
		{
			$data['current_field'] = new \stdClass();
			$data['current_field']->field_type = ci()->input->post('field_type');
		}
		else
		{
			$data['current_field'] = null;
		}

		// -------------------------------------
		// Should we should the set as title
		// column checkbox?
		// -------------------------------------

		if (isset($extra['allow_title_column_set']) and $extra['allow_title_column_set'] === true) {
			$data['allow_title_column_set'] = true;
		} else {
			$data['allow_title_column_set'] = false;
		}

		// -------------------------------------
		// Cancel Button
		// -------------------------------------

		$data['show_cancel'] = (isset($extra['show_cancel']) and $extra['show_cancel']) ? true : false;
		$data['cancel_uri'] = (isset($extra['cancel_uri'])) ? $extra['cancel_uri'] : null;

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
			// ci()->fields_m->fields_validation[1]['rules'] .= '|streams_unique_field_slug['.$data['current_field']->field_slug.':'.$namespace.']';

			// ci()->fields_m->fields_validation[1]['rules'] .= '|streams_col_safe[edit:'.$this->stream->stream_prefix.$this->stream->stream_slug.':'.$data['current_field']->field_slug.']';
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

		//ci()->form_validation->set_rules($validation);

		// -------------------------------------
		// Process Data
		// -------------------------------------
		// ci()->form_validation->run() - @todo - fix validation
		// 
		$post_data = ci()->input->post();

		if ($post_data)
		{

			// Set custom data from $skips param
			if (count($this->skips) > 0)
			{	
				foreach ($skips as $skip)
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

			if ($data['method'] == 'new')
			{

				/*if ( ! ci()->fields_m->insert_field(
									$post_data['field_name'],
									$post_data['field_slug'],
									$post_data['field_type'],
									$namespace,
									$post_data // @todo - implement this part below
					))
				{*/


				if ( ! $field = Model\Field::create(array(
									'field_name' => $post_data['field_name'],
									'field_slug' => $post_data['field_slug'],
									'field_type' => $post_data['field_type'],
									'field_namespace' => $this->namespace,
									
					)))
				{
				
					ci()->session->set_flashdata('notice', lang('streams:save_field_error'));	
				}
				else
				{
					// Add the assignment
					if( ! ci()->streams_m->add_field_to_stream($field->id, $this->stream->id, $post_data))
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
				if ( ! $data['current_field']->update(array_merge($post_data,array('field_namespace' => $this->namespace))))
				{
				
					ci()->session->set_flashdata('notice', lang('streams:save_field_error'));	
				}
				else
				{
					// Add the assignment
					if( ! $data['assignment']->update($post_data))
					{
						ci()->session->set_flashdata('notice', lang('streams:save_field_error'));	
					}
					else
					{
						ci()->session->set_flashdata('success', (isset($extra['success_message']) ? $extra['success_message'] : lang('streams:field_update_success')));
					}
				}

			}
	
			redirect($this->return);
		}

	// -------------------------------------
		// See if we need our param fields
		// -------------------------------------
		
		if (ci()->input->post('field_type') or $this->id)
		{
			// Figure out where this is coming from - post or data
			if (ci()->input->post('field_type'))
			{
				$field_type = ci()->input->post('field_type');
			}
			else
			{
				$field_type = $data['current_field']->field_type;
			}
		
			if (isset(ci()->type->types->{$field_type}))
			{
				// Get the type so we can use the custom params
				$data['current_type'] = ci()->type->types->{$field_type};

				if ( ! is_object($data['current_field']))
				{
					$data['current_field'] = new stdClass();
					$data['current_field']->field_data = array();
				}
				
				// Get our standard params
				//require_once(PYROSTEAMS_DIR.'libraries/Parameter_fields.php');
				
				$data['parameters'] = new Field\Parameter;
				
				if (isset($data['current_type']->custom_parameters) and is_array($data['current_type']->custom_parameters))
				{
					// Build items out of post data
					foreach ($data['current_type']->custom_parameters as $param)
					{
						if ( ! isset($_POST[$param]) and $data['method'] == 'edit')
						{
							if (isset($data['current_field']->field_data[$param]))
							{
								$data['current_field']->field_data[$param] = $data['current_field']->field_data[$param];
							}
						}
						else
						{
							$data['current_field']->field_data[$param] = ci()->input->post($param);
						}
					}
				}
			}
		}

		// -------------------------------------
		// Set our data for the form	
		// -------------------------------------

		foreach ($validation as $field)
		{
			if ( ! isset($_POST[$field['field']]) and $this->id)
			{
				// We don't know where the value is. Hooray
				if (isset($data['current_field']->{$field['field']}))
				{
					$data['field']->{$field['field']} = $data['current_field']->{$field['field']};
				}
				else
				{
					$data['field']->{$field['field']} = $assignment->{$field['field']};
				}
			}
			else
			{
				$data['field']->{$field['field']} = ci()->input->post($field['field']);
			}
		}

		// Repopulate title column set
		$data['title_column_status'] = false;

		if ($data['allow_title_column_set'] and $data['method'] == 'edit') {

			if ($this->stream->title_column and $this->stream->title_column == ci()->input->post('title_column')) {
				$data['title_column_status'] = true;
			}
			elseif ($this->stream->title_column and $this->stream->title_column == $data['current_field']->field_slug) {
				$data['title_column_status'] = true;
			}
			
		} elseif ($data['allow_title_column_set'] and $data['method'] == 'new' and $_POST) {

			if (ci()->input->post('title_column')) {
				$data['title_column_status'] = true;
			}
		}



		// -------------------------------------
		// Run field setup events
		// -------------------------------------

		Field\Form::runFieldSetupEvents($this->stream, $data['method'], $data['current_field']);

		// -------------------------------------
		// Build page
		// -------------------------------------

		ci()->template->append_js('streams/fields.js');

		// Set the cancel URI. If there is no cancel URI, then we won't
		// have a cancel button.
		$data['cancel_uri'] = (isset($extra['cancel_uri'])) ? $extra['cancel_uri'] : null;

		$table = ci()->load->view('admin/partials/streams/field_assignment_form', $data, true);
		
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

	protected function renderNamespaceForm()
	{

	}
}