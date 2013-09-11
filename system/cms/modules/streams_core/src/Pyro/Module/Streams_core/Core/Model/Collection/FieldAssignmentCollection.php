<?php namespace Pyro\Module\Streams_core\Core\Model\Collection;

use Pyro\Model\Collection\EloquentCollection;

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
	 * @return [type] [description]
	 */
	public function getFields()
	{
		$fields = array();

		foreach ($this->items as $assignment)
		{
			$fields[] = $assignment->field;
		}

		return new FieldCollection($fields);
	}
}