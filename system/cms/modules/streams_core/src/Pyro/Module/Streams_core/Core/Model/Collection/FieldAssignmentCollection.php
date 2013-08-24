<?php namespace Pyro\Module\Streams_core\Core\Model\Collection;

use Pyro\Collection\EloquentCollection;

class FieldAssignmentCollection extends EloquentCollection
{
	public function getStreamIds()
	{
		$stream_ids = array();
		
		foreach ($this->items as $key => $assignment)
		{
			$stream_ids[] = $assignment->stream_id;
		}

		return $stream_ids;
	}
}