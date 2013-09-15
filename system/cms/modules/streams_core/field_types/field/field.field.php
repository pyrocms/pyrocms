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
    public $custom_parameters   = array('namespace', 'storage', 'max_length');

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

	protected $selected_stream = null;

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

    	$selectable_fields_namespace = ! empty($this->field->field_data['namespace']) ? $this->field->field_data['namespace'] : $this->field->field_namespace;

    	if ($selected_field = $this->getSelectedField())
    	{


			// This is a field instance not an assignment. Ensure this is a complete field object.
			//$selected_field = $this->field_obj($selected_field);
			
			// This will load the selected field CSS and JS
			ci()->fields->run_field_events(array($selected_field));

			// Apply a default value if it exists in the selected field params
			$default_value = isset($selected_field->field_data['default_value']) ? $selected_field->field_data['default_value'] : null;

			// Set the value if any
			$value = isset($this->value) ? $this->value : $default_value;

			$selected_type = $selected_field->getType($this->entry);

			$selected_type->setValue($this->unformatted_value);

			// Build the selected field form
			$form .= form_hidden($this->field->field_slug, $selected_field->field_slug);
    		$form .= $selected_type->getForm();
    	}
		elseif($options = $this->get_selectable_fields($this->field->stream_slug, $this->field->stream_namespace, $selectable_fields_namespace, $this->field->field_slug))
		{	
			$form = form_dropdown($this->field->field_slug, $options, $this->defaults['data']);
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

		if ($selectable_fields_namespace and ! $this->stream->assignments->isEmpty())
		{
			$skip_fields = $this->stream->assignments->getFields()->getFieldSlugs();
		}

		// Get the fields and display the dropdown
		if ($fields = Model\Field::findManyByNamespace($selectable_fields_namespace, null, null, $skip_fields))
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
    // $input, $field, $stream, $row_id, $this->form_data
    public function pre_save()
    {

    	// First, determine if we have saved the selected field, if not, consider this a new entry
    	//$row = ci()->db->where('id', $row_id)->get($this->stream->stream_prefix.$this->stream->stream_slug)->row();

    	// @todo - find a less hacky way of checking if it has been updated
    	$method = strtotime($this->entry->getOriginal('updated')) > 0 ? 'edit' : 'new';

		$selectable_fields_namespace = ! empty($this->field->field_data['namespace']) ? $this->field->field_data['namespace'] : $this->field->field_namespace;

    	if ($selected_field = Model\Field::findBySlugAndNamespace($this->value, $selectable_fields_namespace))
		{
			// First update the the selected field slug
			$update_data = array(
	        	$this->field->field_slug.'_field_slug' => $this->value
	        );

			$post = ci()->input->post();

			//$this->entry->update($update_data);
    		
	    	if (isset($this->form_data))
	    	{
	    		//print_r($this->form_data); exit;

				// This is a field instance not an assignment. Ensure this is a complete field object.
				//$selected_field = $this->field_obj($selected_field);

				// Build the stream_fields object we will need for validation and pre processes
				$stream_fields = array($selected_field);
				
				// Run selected field validation
				//ci()->fields->set_rules($stream_fields, $method, array(), false, $row_id);
				//
				//and ($method == 'new' or ci()->form_validation->run() === true)
				//
				if ($this->field->field_data['storage'] != 'custom' )
				{
					//print_r($this->form_data); exit;

					// Run selected field pre processes
					$pre_process_data = Model\Entry::runFieldPreProcesses($stream_fields, $this->entry, $post, array(), false);

					$this->entry->{$this->field->field_slug} = $pre_process_data[$selected_field->field_slug];
			
					// Save it
					if ($this->entry->save())
					{
						// Fire an event to after updating this entry
						Events::trigger('field_field_type_updated', array(
							'field' => $this->field,
							'stream' => $this->stream,
							'row' => $this->entry,
							'form_data' => $this->form_data
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
				$output = $selected_type->alt_pre_output_field_field_type();
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
				//echo $this->value; exit;

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
    public function field_assignment_construct()
    {
    	$max_length = isset($this->field->field_data['max_length']) ? $this->field->field_data['max_length'] : 100;

    	$schema = ci()->pdb->getSchemaBuilder();
		
		$schema->table($this->stream->stream_prefix.$this->stream->stream_slug, function($table) use ($field, $max_length) {

			// Add a column to store the field slug
			$table
				->string($this->field->field_slug.'_field_slug', $max_length)
				->default('text');

			// Add a column to store the value if it doesn't use custom storage
			if ($this->field->field_data['storage'] != 'custom')
			{
				$table->text($this->field->field_slug);
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
			$table->dropColumn($this->field->field_slug.'_field_slug');

			// Drop the value column if it doesn't use custom storage
			if ($this->field->field_data['storage'] != 'custom')
			{
				$table->drop($this->field->field_slug);
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
				$options[$this->field->field_namespace] = humanize($this->field->field_namespace);
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
    * Field Object
    *
    * We have to set some properties here because this is a field instance rather than a assignment
    *
    * @param   object
    * @return  object
    */
	private function field_obj($field)
	{
		$this->field->field_id = $this->field->id;
		$this->field->is_required = isset($this->field->is_required) ? $this->field->is_required : 'no';
		$this->field->is_unique = isset($this->field->is_required) ? $this->field->is_required : 'no';

		return $field;
	}

	public function getSelectedField()
	{
		$selected_field_slug_column = $this->field->field_slug.'_field_slug'; 

		$selected_field_slug = isset($this->entry->{$selected_field_slug_column}) ? $this->entry->{$selected_field_slug_column} : $this->getDefault($this->field->field_slug);

		$selectable_fields_namespace = ! empty($this->field->field_data['namespace']) ? $this->field->field_data['namespace'] : $this->field->stream_namespace;

		return Model\Field::findBySlugAndNamespace($selected_field_slug, $selectable_fields_namespace);
	}

	public function getSelectedFieldType()
	{
		$field = $this->getSelectedField();

		if ($selected_type = $field->getType($this->entry->unformatted()))
		{
			$selected_type->setValue($this->value);

			return $selected_type;	
		}

		return false;
	}

}