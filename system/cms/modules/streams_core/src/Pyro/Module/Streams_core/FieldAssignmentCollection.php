<?php namespace Pyro\Module\Streams_core;

use Pyro\Model\EloquentCollection;

class FieldAssignmentCollection extends EloquentCollection
{
	/**
	 * Get stream ids from the assignment collection
	 * @return array The array of stream ids
	 */
	public function getStreamIds()
	{
		return array_values($this->lists('stream_id'));
	}

	/**
	 * Get field ids from the assignment collection
	 * @return array The array of field ids
	 */
	public function getFieldIds()
	{
		return array_values($this->lists('field_id'));
	}

	/**
	 * Get a field collection from the assignment collection
	 * @return array
	 */
	public function getFields($stream = null)
	{
		$fields = array();

		foreach ($this->items as $assignment)
		{
			$assignment->field->setStream($stream);

			$fields[] = $assignment->field;
		}

		return new FieldCollection($fields);
	}
}