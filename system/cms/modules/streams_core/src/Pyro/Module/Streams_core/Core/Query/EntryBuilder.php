<?php namespace Pyro\Module\Streams_core\Core\Query;

use Illuminate\Database\Eloquent\Builder;

class EntryBuilder extends Builder
{
	protected $entries = array();

	/**
	 * Execute the query as a "select" statement.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function get($columns = array('*'), $exclude = false)
	{
		$this->stream = $this->model->getStream();

		if ($exclude)
		{
			$columns = $this->stream->assignments->getFields()->getFieldsSlugsExclusive($columns);
			// @todo - restore the non-field columns like id, updated, 
		}

		$this->entries = $this->getModels($columns);

		// If we actually found models we will also eager load any relationships that
		// have been specified as needing to be eager loaded, which will solve the
		// n+1 query issue for the developers to avoid running a lot of queries.
		if (count($this->entries) > 0)
		{
			$entries = $this->eagerLoadRelations($this->entries);
		}

		return $this->model->newCollection($this->formatEntries($this->entries), $this->entries);
	}

	public function formatEntries(array $entries = array())
	{	
		// returns the models with the attributes formated by their corresponding field type
		$formatted = array();

		foreach ($entries as $entry)
		{
			$formatted[] = $this->formatEntry($entry);
		}

		return $formatted;
	}

	public function formatEntry($entry = null, $properties = array())
	{
		// Replicate the model to keep the original intact
		$clone = $entry->replicate();

		foreach (array_keys($clone->getAttributes()) as $field_slug)
		{
			// Get the field type instance from the entry
			if ($type = $entry->getFieldType($field_slug))
			{
				// Set the unformatted value, we might need it
				$clone->setUnformattedValue($field_slug, $entry->{$field_slug});
				
				// If there exist a field for the corresponding attribute, format it
				$clone->{$field_slug} = $type->getFormattedValue();

			}
			else
			{
				// If not replicate the raw value
				$clone->{$field_slug} = $entry->{$field_slug};
			}
		};

		// Restore the primary key to the replicated model, only if it is set
		if (isset($entry->{$this->model->getKeyName()}))
		{
			$clone->{$this->model->getKeyName()} = $entry->{$this->model->getKeyName()};	
		}

		return $clone;	
	}
}