<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Field\AbstractField;
use Pyro\Module\Streams_core\Core\Field;
use Pyro\Module\Streams_core\Core\Model;

/**
 * Field Field Type
 *
 * @author  Osvaldo Brignoni
 * @package PyroCMS\Addon\FieldType
 */
class Field_field extends AbstractField
{
	/**
	 * Field Type Name
	 *
	 * @var 	string
	 */
	public $field_type_name 		= 'Field';
	
	/**
	 * Field Type Slug
	 *
	 * @var 	string
	 */
	public $field_type_slug			= 'field';
	
	/**
	 * Alt Process
	 *
	 * This field type is alternatively processed.
	 *
	 * @var 	bool
	 */
	public $alt_process				= true;
	
	/**
	 * Database Column Type
	 *
	 * We'll work with two columns [field_slug] and [field_slug]_field 
	 * [field_slug] string - stores the value processed by the selected field
	 * [field_slug]_field int - stores the selected field id
	 * 
	 * @var 	string|bool
	 */
	public $db_col_type				= false;

	/**
	 * Custom Parameters
	 *
	 * namespace - the selectable fields namespace
	 * slug - field_slug stored as a parameter
	 *
	 * @var 	array
	 */
    public $custom_parameters   = array('namespace', 'storage', 'max_length', 'field_slug');

	/**
	 * Version Number
	 *
	 * @var 	string
	 */
	public $version					= '1.0';

	/**
	 * Author
	 *
	 * @var 	string
	 */
	public $author					= array('name' => 'Osvaldo Brignoni', 'url' => 'http://obrignoni.com');

	protected $selected_field = null;

	protected $selected_type = null;

    /**
    * Output the form
    *
    * @param   array
    * @param   integer
    * @param   object
    * @return  string
    */
    public function form_output()
    {	
    	$form = '';

    	if ($selected_field = $this->getSelectedField())
    	{
			// This is a field instance not an assignment. Ensure this is a complete field object.
			$selected_field = $this->field_obj($selected_field);
			
			// This will load the selected field CSS and JS
			ci()->fields->run_field_events(array($selected_field));

			// Apply a default value if it exists in the selected field params
			$default_value = isset($selected_field->field_data['default_value']) ? $selected_field->field_data['default_value'] : null;

			// Set the value if any
			$value = isset($this->entry->{$field->field_slug}) ? $this->entry->{$field->field_slug} : $default_value;

			$selected_type = $this->getSelectedFieldType();

			// Build the selected field form
			$form .= form_hidden($field->field_slug, $selected_field->field_slug);
    		$form .= $selected_type->getForm();
    	}
		elseif($options = $this->get_selectable_fields($field->stream_slug, $field->stream_namespace, $selectable_fields_namespace, $field->field_slug))
		{	
			$form = form_dropdown($field->field_slug, $options, $selected_field->field_slug);
		}
    	else
    	{
    		$form = lang('streams:field.must_add_fields');
    	}

		return $form;
    }

    public function get_selectable_fields($stream_slug, $stream_namespace, $selectable_fields_namespace)
    {
	    // This will prevent fields assigned to this stream from being selectable for entry.
		$skip_fields = array();

		$options = false;

		if ($selectable_fields_namespace and ($assignments = ci()->streams->streams->get_assignments($stream_slug, $stream_namespace)))
		{
			foreach ($assignments as $assignment)
			{
				$skip_fields[] = $assignment->field_slug;
			}
		}

		// Get the fields and display the dropdown
		if ($fields = ci()->fields_m->get_fields($selectable_fields_namespace, false, 0, array_unique($skip_fields)))
		{
			foreach ($fields as $selectable)
			{
				// Ensure the field type does NOT select itself
				if ($selectable->field_type != $this->field_type_slug)
				{
					$options[$selectable->field_slug] = lang_label($selectable->field_name);		    			
				}
			}		
		}

		return $options;
    }

    /**
    * Pre Save
    *
    * Here we delegate validation and pre processing to the selected field type and save the returned result.
    *
    * @param   array
    * @param   integer
    * @param   object
    * @return  string
    */
    public function pre_save($input, $field, $stream, $row_id, $form_data)
    {
    	// First, determine if we have saved the selected field, if not, consider this a new entry
    	$row = ci()->db->where('id', $row_id)->get($this->stream->stream_prefix.$this->stream->stream_slug)->row();

    	// @todo - find a less hacky way of checking if it has been updated
    	$method = strtotime($row->updated) > 0 ? 'edit' : 'new';

		$selectable_fields_namespace = ! empty($field->field_data['namespace']) ? $field->field_data['namespace'] : $field->field_namespace;

    	if ($selected_field = ci()->fields_m->get_field_by_slug($input, $selectable_fields_namespace))
		{
			// First update the the selected field slug
			$update_data = array(
	        	$field->field_slug.'_field_slug' => $input
	        );

			ci()->db->where('id', $row_id)->update($this->stream->stream_prefix.$this->stream->stream_slug, $update_data);
    	
	    	if (isset($form_data[$selected_field->field_slug]))
	    	{
				// This is a field instance not an assignment. Ensure this is a complete field object.
				$selected_field = $this->field_obj($selected_field);

				// Build the stream_fields object we will need for validation and pre processes
				$stream_fields = new stdClass;
				$stream_fields->{$selected_field->field_slug} = $selected_field;
				
				// Run selected field validation
				ci()->fields->set_rules($stream_fields, $method, array(), false, $row_id);

				if ($field->field_data['storage'] != 'custom' and ($method == 'new' or ci()->form_validation->run() === true))
				{
					// Run selected field pre processes
					$pre_process_data = ci()->row_m->run_field_pre_processes($stream_fields, $stream, $row_id, $form_data, array(), false);

					$update_data = array(
						$field->field_slug => $pre_process_data[$selected_field->field_slug]
					);
					// Save it
					if (ci()->db->where('id', $row_id)->update($this->stream->stream_prefix.$this->stream->stream_slug, $update_data))
					{
						// Fire an event to after updating this entry
						Events::trigger('field_field_type_updated', array(
							'field' => $field,
							'stream' => $stream,
							'row' => $row,
							'form_data' => $form_data
						));
					}
	    		}
	    		else
	    		{
	    			ci()->session->set_flashdata('error', 'Invalid '.humanize($selected_field->field_slug).' value.');
	    			redirect(current_url());
	    		}
			}
		}
    }

	/**
	 * Alt Pre Output
	 *
	 * Process before outputting to the backend
	 *
	 * @param	array
	 * @return	string
	 */
	public function alt_pre_output()
	{
		$output = '';

		$selected_field_slug_column = $this->field->field_data['field_slug'].'_field_slug';

		$selectable_fields_namespace = ! empty($this->field->field_data['namespace']) ? $this->field->field_data['namespace'] : $this->stream->stream_namespace;

		// Get the only the entry columns we need
		$select[] = $selected_field_slug_column; 
		if ($this->field->field_data['storage'] != 'custom')
		{
			$select[] = $this->field->field_data['field_slug'];
		}

		if ($selected_type = $this->getSelectedFieldType())
		{

			// This is an option for field types that primarily return an array
			// First check if the field wants to alternatively return a string
			if (method_exists($selected_type, 'alt_pre_output_field_field_type'))
			{
				$output = $selected_type->alt_pre_output_field_field_type($this->entry, $this->field->field_data, $type, $this->stream, $selected_field);
			}
			// Check if the field has $return_unprocessed_field_field_type property and return the unprocessed column value
			elseif ($selected_type 
				and isset($selected_type->return_unprocessed_field_field_type)
				and ! $selected_type->return_unprocessed_field_field_type
				and isset($this->entry->{$this->field->field_data['field_slug']}))
			{
				$output = $this->entry->{$this->field->field_data['field_slug']};					
			}
			// Else we will expect this field to go through its pre process and return a string
			elseif ($this->field->field_data['storage'] != 'custom')
			{
				$output = $selected_type->getFormattedValue();

				//$output = $this->builder->formatAttribute($this->entry->{$this->field->field_data['field_slug']}, $this->field);

				// Double check if this is a string, decode any html entities. Else, return the unprocessed value
				// This ensures that Lex tags get decoded before getting parsed
				$output = is_string($output) ? html_entity_decode($output,ENT_COMPAT,"utf-8") : $this->entry->{$this->field->field_data['field_slug']};
				// Wrap this in some nice html, only for the Admin pages
			}

					if (defined('ADMIN_THEME'))
		{
			$output = is_string($output) ? ci()->parser->parse_string($output, array(), true) : $output;
			$output = '<div class="streams-field-field-output '.$selected_type->field->field_slug.'">'. 
			$output .' <span class="muted">('.lang_label($selected_type->field->field_name).')</span></div>';
		}
		}

		return $output;
	}

    /**
    * Field Assignment Construct
    *
    * @param   object
    * @param   object
    * @return  void
    */
    public function field_assignment_construct($field, $stream)
    {
    	$max_length = isset($field->field_data['max_length']) ? $field->field_data['max_length'] : 100;

    	$schema = ci()->pdb->getSchemaBuilder();
		
		$schema->table($this->stream->stream_prefix.$this->stream->stream_slug, function($table) use ($field, $max_length) {

			// Add a column to store the field slug
			$table
				->string($field->field_slug.'_field_slug', $max_length)
				->default('text');

			// Add a column to store the value if it doesn't use custom storage
			if ($field->field_data['storage'] != 'custom')
			{
				$table->text($field->field_slug);
			}
		});
    }

    /**
    * Field Assignment Destruct
    *
    * @param   object
    * @param   object
    * @return  void
    */
    public function field_assignment_destruct($field, $stream)
    {
    	$schema = ci()->pdb->getSchemaBuilder();

		$schema->table($this->stream->stream_prefix.$this->stream->stream_slug, function($table) use ($field) {
			// Drop the field slug column
			$table->dropColumn($field->field_slug.'_field_slug');

			// Drop the value column if it doesn't use custom storage
			if ($field->field_data['storage'] != 'custom')
			{
				$table->drop($field->field_slug);
			}
		});
    }

    /**
    * Namespace Parameter
    *
    * @param   string
    * @return  array
    */
    public function param_namespace($value = null)
    {
		$options = array(
			0 => lang('streams:field.param_default')
		);

		if ($fields = ci()->db->select('field_namespace')->distinct()->order_by('field_namespace')->get(FIELDS_TABLE)->result())
		{
			foreach ($fields as $field)
			{
				$options[$field->field_namespace] = humanize($field->field_namespace);
			}
		}

		return array(
			'input' 		=> form_dropdown('namespace', $options, $value),
			'instructions'	=> lang('streams:field.namespace_instructions')
		);
    }

    /**
    * Storage Parameter
    *
    * @param   string
    * @return  array
    */
    public function param_storage($value = null)
    {
		$options = array(
			'default' => lang('streams:field.param_default'),
			'custom' => lang('streams:field.param_custom')
		);

		return array(
			'input' 		=> form_dropdown('storage', $options, $value),
			'instructions'	=> lang('streams:field.storage_instructions')
		);
    }

    /**
    * Field Slug Parameter
    *
    * Don't display the form.
    * 
    * @param   string
    * @return  bool
    */
    public function param_field_slug()
    {
    	return false;
    }

    /**
    * Pre Save Field Slug Parameter
    *
    * The field slug automatically saved as a parameter. We will need it for alt_pre_output()
    * 
    * @param   array
    * @return  string
    */
    public function param_field_slug_pre_save($field)
    {
    	return $field['field_slug'];
    } 

    /**
    * Field Object
    *
    * We have to set some properties here because this is a field instance rather than a assignment
    *
    * @param   object
    * @return  object
    */
	private function field_obj($field)
	{
		$field->field_id = $field->id;
		$field->is_required = isset($field->is_required) ? $field->is_required : 'no';
		$field->is_unique = isset($field->is_required) ? $field->is_required : 'no';

		return $field;
	}

	public function getSelectedField()
	{
		//echo $this->field; exit;

		$selected_field_slug_column = $this->field->field_slug.'_field_slug'; 

		$selected_field_slug = $this->entry->{$selected_field_slug_column} ? $this->entry->{$selected_field_slug_column} : $this->value;

		$selectable_fields_namespace = ! empty($this->field->field_data['namespace']) ? $this->field->field_data['namespace'] : $this->field->stream_namespace;

		$selected_field = Model\Field::getBySlugAndNamespace($selected_field_slug, $selectable_fields_namespace);
	}

	public function getSelectedFieldType()
	{
		if ($selected_type = Field\Type::getLoader()->getType($this->value))
		{
			return $selected_type;	
		}

		return false;
	}

}