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
		if ($exclude)
		{
			$columns = $this->model->getAllColumnsExclude($columns);
		}

		$columns = $this->prepareColumns($columns);

		// We prepare the view options after preparing the columns and before the key is required
		$this->prepareViewOptions($columns);

		// We need to return the models with their keys
		$columns = $this->requireKey($columns);

		$this->entries = $this->getModels($columns);

		// If we actually found models we will also eager load any relationships that
		// have been specified as needing to be eager loaded, which will solve the
		// n+1 query issue for the developers to avoid running a lot of queries.
		if (count($this->entries) > 0)
		{
			$relations = $this->entries[0]->getModel()->getRelations();

			if (in_array('created_by', $columns) and empty($relations['user']))
			{
				$this->with('user');
			}

			$this->entries = $this->eagerLoadRelations($this->entries);
		}

		return $this->model->newCollection($this->formatEntries($this->entries), $this->entries);
	}

	public function formatEntries(array $entries = array())
	{	
		// returns the models with the attributes formated by their corresponding field type
		$formatted = array();

		foreach ($entries as $entry)
		{
			$formatted[$entry->getKey()] = $this->formatEntry($entry);
		}

		return $formatted;
	}

	public function formatEntry($entry = null)
	{
		// Replicate the model to keep the original intact
		$clone = $entry->replicate();

		$clone->setFields($this->model->getFields());
		
		// Restore the primary key to the replicated model, only if it is set
		if (isset($entry->{$this->model->getKeyName()}))
		{
			$clone->{$this->model->getKeyName()} = $entry->{$this->model->getKeyName()};	
		}

		foreach (array_keys($clone->getAttributes()) as $field_slug)
		{
			// Get the field type instance from the entry
			if (in_array($field_slug, $this->model->getStandardColumns()))
			{
				// If not replicate the raw value
				$clone->{$field_slug} = $entry->{$field_slug};
			}
			elseif ($type = $entry->getFieldType($field_slug))
			{
				// Set the unformatted value, we might need it
				$clone->setUnformattedValue($field_slug, $entry->{$field_slug});
				
				// If there exist a field for the corresponding attribute, format it
				$clone->{$field_slug} = $type->getFormattedValue();
			}
		};

		return $clone;	
	}

    protected function prepareColumns(array $columns = array('*'))
    {
    	// Remove any columns that don't exist
        $columns = array_intersect($columns, $this->model->getAllColumns());

    	// If for some reason we passed an empty array, put the asterisk back
    	$columns = empty($columns) ? array('*') : $columns;

        // Make sure there are no duplicate columns
        return array_unique($columns);
    }

    public function requireKey(array $columns = array())
    {
    	// Always include the primary key if we are selecting specific columns, regardless
        if (count($columns) === 1 and $columns[0] !== '*')
        {
            array_unshift($columns, $this->model->getKeyName());
        }

        return $columns;
    }

    public function hasAsterisk(array $columns = array())
    {
    	if ( ! empty($columns))
    	{
			foreach ($columns as $column)
			{
				if ($column == '*') return true;
			}
    	}
    	
    	return false;
    }

    protected function prepareViewOptions(array $columns = array('*'))
    {	
    	// Use existing stored view options only if we have an asterisk 
    	if ($this->hasAsterisk($columns) and $stream = $this->model->getStream() and ! empty($stream->view_options))
    	{
    		$columns = $stream->view_options;
    	}
    	// If there are no stored options and there is an asterisk, get all columns
		elseif ($this->hasAsterisk($columns))
		{
			$columns = $this->model->getAllColumns();
		}

		// or we just set the columns that were passed to the method
		$this->model->setViewOptions($columns);

		return $columns;
    }

}