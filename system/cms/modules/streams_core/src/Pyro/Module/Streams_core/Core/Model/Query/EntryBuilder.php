<?php namespace Pyro\Module\Streams_core\Core\Model\Query;

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
			$relations = $this->model->getRelations();

			if (in_array('created_by', $columns) and empty($relations['createdByUser']))
			{
				$this->with('createdByUser');
			}

			$this->entries = $this->eagerLoadRelations($this->entries);
		}

		if ($this->model->isFormat())
		{
			return $this->model->newCollection($this->formatEntries($this->entries), $this->entries);
		}
		else
		{
			return $this->model->newCollection($this->entries);
		}
	}

	/**
	 * Format entries
	 * @param  array  $entries
	 * @return array
	 */
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

	/**
	 * Format an entry
	 * @param  object $entry
	 * @return object
	 */
	public function formatEntry($entry = null)
	{
		// Replicate the model to keep the original intact
		$clone = $entry->replicate();
		
		// We must set the fields for both the entry and the clone
		// Setting them on the clone will have an effect on the resulting collection and 
		// Setting them on the entry will have an effect when returning a single model
		$entry->setStream($this->model->getStream());
		$entry->setFields($this->model->getFields());
		$clone->setFields($this->model->getFields());

		// Restore the primary key to the replicated model
		$clone->{$this->model->getKeyName()} = $entry->{$this->model->getKeyName()};	

		foreach (array_keys($clone->getAttributes()) as $field_slug)
		{
			if ($field_slug == 'created_by')
			{
				$clone->created_by = $entry->created_by_user;
			}
			elseif ($type = $entry->getFieldType($field_slug))
			{
				// Set the unformatted value, we might need it
				$clone->setUnformattedValue($field_slug, $entry->{$field_slug});

				$clone->setPluginValue($field_slug, $type->getFormattedValue(true));
				
				// If there exist a field for the corresponding attribute, format it
				$clone->{$field_slug} = $type->getFormattedValue();
			}
		};

		// Store the unformatted entry in case we need it later
		$clone->setUnformattedEntry($entry);

		return $clone;	
	}

	/**
	 * Prep columns
	 * @param  array  $columns
	 * @return array
	 */
    protected function prepareColumns(array $columns = array('*'))
    {
    	// Remove any columns that don't exist
        $columns = array_intersect($columns, $this->model->getAllColumns());

    	// If for some reason we passed an empty array, put the asterisk back
    	$columns = empty($columns) ? array('*') : $columns;

        // Make sure there are no duplicate columns
        return array_unique($columns);
    }

    /**
     * Require the primary key
     * @param  array  $columns
     * @return array
     */
    public function requireKey(array $columns = array())
    {
    	// Always include the primary key if we are selecting specific columns, regardless
        if ( ! $this->hasAsterisk($columns) and ! in_array($this->model->getKeyName(), $columns))
        {
            array_unshift($columns, $this->model->getKeyName());
        }

        return $columns;
    }

    /**
     * Test if ALL columns (*)
     * @param  array   $columns
     * @return boolean
     */
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

    /**
     * Prep view options
     * @param  array  $columns
     * @return array
     */
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
