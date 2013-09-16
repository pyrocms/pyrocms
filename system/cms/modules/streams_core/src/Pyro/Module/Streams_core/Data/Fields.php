<?php namespace Pyro\Module\Streams_core\Data;

use Closure;
use Pyro\Module\Streams_core\Core\Field;
use Pyro\Module\Streams_core\Core\Model;
use Pyro\Module\Streams_core\Core\Support\AbstractData;
use Pyro\Module\Streams_core\Core\Support\Exception;

class Fields extends AbstractData
{
	/**
	 * Add field
	 *
	 * @param	array - field_data
	 * @return	bool
	 */
	public static function addField($field)
	{
		extract($field);
	
		// -------------------------------------
		// Validate Data
		// -------------------------------------
		
		// Do we have a field name?
		if ( ! isset($name) or ! trim($name))
		{
			throw new Exception\EmptyFieldNameException;
		}			

		// Do we have a field slug?
		if( ! isset($slug) or ! trim($slug))
		{
			throw new Exception\EmptyFieldSlugException;
		}

		// Do we have a namespace?
		if( ! isset($namespace) or ! trim($namespace))
		{
			throw new Exception\EmptyFieldNamespaceException;	
		}
		
		// Is this stream slug already available?
		if ($field = Model\Field::findBySlugAndNamespace($slug, $namespace))
		{
			throw new Exception\FieldSlugInUseException('The Field slug is already in use for this namespace. Attempted ['.$slug.','.$namespace.']');
		}

		// Is this a valid field type?
		if ( ! isset($type) or ! Field\Type::getLoader()->getType($type))
		{
			throw new Exception\InvalidFieldTypeException('Invalid field type. Attempted ['.$type.']');
		}

		// Set locked 
		$locked = (isset($locked) and $locked === true) ? 'yes' : 'no';
		
		// Set extra
		if ( ! isset($extra) or ! is_array($extra)) $extra = array();
	
		// -------------------------------------
		// Create Field
		// -------------------------------------

		$attributes = array(
			'field_name' => $name,
			'field_slug' => $slug,
			'field_type' => $type,
			'field_namespace' => $namespace,
			'field_data' => $extra,
			'is_locked' => $locked
		);

		if ( ! $field = Model\Field::create($attributes)) return false;

		// -------------------------------------
		// Assignment (Optional)
		// -------------------------------------

		if (isset($assign) and $assign != '' and $stream = Model\Stream::findBySlugAndNamespace($assign, $namespace))
		{
			$data = array();
		
			// Title column
			$data['title_column'] = isset($title_column) ? $title_column : false;

			// Instructions
			$data['instructions'] = (isset($instructions) and $instructions != '') ? $instructions : null;
			
			// Is Unique
			$data['is_unique'] = isset($unique) ? $unique : false;
			
			// Is Required
			$data['is_required'] = isset($required) ? $required : false;
		
			// Add actual assignment
			return $stream->assignField($field, $data);
		}
		
		return $field;
	}

	/**
	 * Add fields
	 * @param array  $fields             The array of fields
	 * @param [type] $assign_stream_slug The optional stream slug to assign all fields. Avoids the need to add it individually.
	 * @param [type] $namespace          The optional namespace for all fields. Avoids the need to add it individually.
	 */
	public static function addFields($fields = array(), $assign_stream_slug = null, $namespace = null)
	{
		if (empty($fields)) return false;

		$success = true;

		foreach ($fields as $field)
		{
			if ($assign_stream_slug)
			{
				$field['assign'] = $assign_stream_slug;
			}

			if ($namespace)
			{
				$field['namespace'] = $namespace;
			}

			if( ! static::addField($field))
			{
	            $success = false;
	        }
	    }

	    return $success;
	}

	/**
	 * Assign field to stream
	 *
	 * @param	string - namespace
	 * @param	string - stream slug
	 * @param	string - field slug
	 * @param	array - assign data
	 * @return	mixed - false or assignment ID
	 */
	public static function assignField($stream_slug, $namespace, $field_slug, $assign_data = array())
	{
		// -------------------------------------
		// Validate Data
		// -------------------------------------

		$stream = Model\Stream::findBySlugAndNamespaceOrFail($stream_slug, $namespace);
		
		if ( ! $field = Model\Field::findBySlugAndNamespace($field_slug, $namespace))
		{
			throw new Exception\InvalidFieldException('Invalid field. Attempted ['.$field_slug.']');
		}

		// -------------------------------------
		// Assign Field
		// -------------------------------------
	
		// Add actual assignment
		return $stream->assignField($field, $assign_data);
	}

	/**
	 * De-assign field
	 *
	 * This also removes the actual column
	 * from the database.
	 *
	 * @param	string - namespace
	 * @param	string - stream slug
	 * @param	string - field slug
	 * @return	bool
	 */
	public static function deassignField($namespace, $stream_slug, $field_slug)
	{
		// -------------------------------------
		// Validate Data
		// -------------------------------------

		if ( ! $stream = Model\Stream::findBySlugAndNamespace($stream_slug, $namespace))
		{
			throw new Exception\InvalidStreamException('Invalid stream. Attempted ['.$stream_slug.','.$namespace.']');
		}

		if ( ! $field = Model\Field::findBySlugAndNamespace($field_slug, $namespace))
		{
			throw new Exception\InvalidFieldException('Invalid field. Attempted ['.$field_slug.']');
		}

		// -------------------------------------
		// De-assign Field
		// -------------------------------------
		
		return $stream->removeFieldAssignment($field);
	}

	/**
	 * Delete field
	 *
	 * @param	string - field slug
	 * @param	string - field namespace
	 * @return	bool
	 */
	public static function deleteField($field_slug, $namespace)
	{
		// Do we have a field slug?
		if( ! isset($field_slug) or ! trim($field_slug))
		{
			throw new Exception\EmptyFieldSlugException;
		}
		
		// Do we have a namespace?
		if( ! isset($namespace) or ! trim($namespace))
		{
			throw new Exception\EmptyFieldNamespaceException;	
		}

		if ( ! $field = Model\Field::findBySlugAndNamespace($field_slug, $namespace)) return false;
	
		return $field->delete();
	}

	/**
	 * Update field
	 *
	 * @param	string - slug
	 * @param	array - new data
	 * @return	bool
	 */
	public static function updateField($field_slug, $field_namespace, $field_name = null, $field_type = null, $field_data = array())
	{
		// Do we have a field slug?
		if( ! isset($field_slug) or ! trim($field_slug))
		{
			throw new Exception\EmptyFieldSlugException;
		}

		// Do we have a namespace?
		if( ! isset($field_namespace) or ! trim($field_namespace))
		{
			throw new Exception\EmptyFieldNamespaceException;	
		}
	
		// Find the field by slug and namespace or throw an exception
		if ( ! $field = Model\Field::findBySlugAndNamespace($field_slug, $field_namespace)) return false;

		// Is this a valid field type?
		if (isset($field_type) and ! Field\Type::getLoader()->getType($field_type))
		{
			throw new Exception\InvalidFieldTypeException('Invalid field type. Attempted ['.$type.']');
		}

		return $field->update($field_data);
	}

	/**
	 * Get assigned fields for
	 * a stream.
	 *
	 * @param	string - field slug
	 * @param	string - namespace
	 * @return	object
	 */
	public static function getFieldAssignments($field_slug, $namespace)
	{
		// Do we have a field slug?
		if( ! isset($field_slug) or ! trim($field_slug))
		{
			throw new Exception\EmptyFieldSlugException;
		}
	
		if ( ! $field = Model\Field::findBySlugAndNamespace($field_slug, $namespace)) return false;
	
		return $field->assignments;
	}
}
