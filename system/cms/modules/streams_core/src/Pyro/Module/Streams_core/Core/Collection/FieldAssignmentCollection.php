<?php namespace Pyro\Module\Streams_core\Core\Collection;

use Pyro\Collection\EloquentCollection;

class FieldAssignmentCollection extends EloquentCollection
{
	public function getFields()
	{
		$fields = array();

		foreach ($this->items as $assignment)
		{	
			if ($assignment->field)
			{
				$fields[] = $assignment->field;
			}
		}

		return new FieldCollection($fields);
	}
}