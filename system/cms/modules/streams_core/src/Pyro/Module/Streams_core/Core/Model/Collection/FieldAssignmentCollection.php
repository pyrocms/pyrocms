<?php namespace Pyro\Module\Streams_core\Core\Model\Collection;

use Pyro\Collection\EloquentCollection;

class FieldAssignmentCollection extends EloquentCollection
{
	/**
	 * Get stream ids
	 * @return array The array of stream ids
	 */
	public function getStreamIds()
	{
		return array_values($this->lists('stream_id'));
	}

	/**
	 * Get field ids
	 * @return array The array of field ids
	 */
	public function getFieldIds()
	{
		return array_values($this->lists('field_id'));
	}
}