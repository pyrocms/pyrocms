<?php namespace Pyro\Module\Streams_core\Core\Model\Query;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

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
		// Get set up with our environment
		$this->stream = $this->model->getStream();
		$this->fields = $this->model->getFields();
		$this->table = $this->model->getTable();

		
		// -------------------------------------
		// Filters (QueryString API)
		// -------------------------------------

		if (ci()->input->get('filter-'.$this->stream->stream_namespace.'-'.$this->stream->stream_slug)) {

			// Get all URL variables
			$query_string_variables = ci()->input->get();

			// Loop and process!
			foreach ($query_string_variables as $filter => $value) {
				
				// Split into components
				$commands = explode('-', $filter);

				// Filter?
				if ($commands[0] != 'f') continue;

				// Only filter our current namespace / stream
				if ($commands[1] != $this->stream->stream_namespace) continue;
				if ($commands[2] != $this->stream->stream_slug) continue;

				// Switch on the restriction
				switch ($commands[4]) {
					
					/**
					 * IS
					 * results in: filter = value
					 */
					case 'is':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], '=', $value);
						break;


					/**
					 * ISNOT
					 * results in: filter != value
					 */
					case 'isnot':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], '!=', $value);
						break;


					/**
					 * ISNOT
					 * results in: filter != value
					 */
					case 'isnot':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], '!=', $value);
						break;
					

					/**
					 * CONTAINS
					 * results in: filter LIKE '%value%'
					 */
					case 'contains':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], 'LIKE', '%'.$value.'%');
						break;


					/**
					 * DOESNOTCONTAIN
					 * results in: filter NOT LIKE '%value%'
					 */
					case 'doesnotcontain':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], 'NOT LIKE', '%'.$value.'%');
						break;


					/**
					 * STARTSWITH
					 * results in: filter LIKE 'value%'
					 */
					case 'startswith':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], 'LIKE', $value.'%');
						break;


					/**
					 * ENDSWITH
					 * results in: filter LIKE '%value'
					 */
					case 'endswith':
						
						// Gotta have a value for this one
						if (empty($value)) continue;

						// Do it
						$this->where($commands[3], 'LIKE', '%'.$value);
						break;


					/**
					 * ISEMPTY
					 * results in: (filter IS NULL OR filter = '')
					 */
					case 'isempty':
						
						$this->where(function($query) use ($commands, $value) {
							$query->where($commands[3], 'IS', 'NULL');
							$query->orWhere($commands[3], '=', '');
						});
						break;


					/**
					 * ISNOTEMPTY
					 * results in: filter > '')
					 */
					case 'isnotempty':
						
						$this->where($commands[3], '>', '');
						break;


					default: break;
				}
			}
		}


		// -------------------------------------
		// Ordering / Sorting (QueryString API)
		// -------------------------------------

		if (ci()->input->get('order-'.$this->stream->stream_namespace.'-'.$this->stream->stream_slug)) {
			if (ci()->input->get('sort-'.$this->stream->stream_namespace.'-'.$this->stream->stream_slug)) {
				$this->orderBy(ci()->input->get('order-'.$this->stream->stream_namespace.'-'.$this->stream->stream_slug), ci()->input->get('sort-'.$this->stream->stream_namespace.'-'.$this->stream->stream_slug));
			} else {
				$this->orderBy(ci()->input->get('order-'.$this->stream->stream_namespace.'-'.$this->stream->stream_slug), 'ASC');
			}
		}



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

		foreach ($this->entries as $entry)
		{
			// Pass our custom properties to the queried models
			$this->model->passProperties($entry);
		}

		// If we actually found models we will also eager load any relationships that
		// have been specified as needing to be eager loaded, which will solve the
		// n+1 query issue for the developers to avoid running a lot of queries.
		if (count($this->entries) > 0)
		{
			$this->with('createdByUser');

			if ($columns === array('*'))
				$this->eagerLoadFieldRelations($this->model->getFieldSlugs());
			else
				$this->eagerLoadFieldRelations($columns);

			$this->entries = $this->eagerLoadRelations($this->entries);
		}

		// Shall we return formatted entries or not?
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

		// Restore the primary key to the replicated model
		$clone->{$this->model->getKeyName()} = $entry->{$this->model->getKeyName()};	

		foreach (array_keys($clone->getAttributes()) as $field_slug)
		{
			if ($field_slug == 'created_by')
			{
				$clone->setAttribute('created_by', $clone->createdByUser);
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
	 * Get the relation instance for the given relation name.
	 *
	 * @param  string  $relation
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function getRelation($relation)
	{
		$me = $this;

		// We want to run a relationship query without any constrains so that we will
		// not have to remove these where clauses manually which gets really hacky
		// and is error prone while we remove the developer's own where clauses.
		$query = Relation::noConstraints(function() use ($me, $relation)
		{	
			if ($me->getModel()->isEnableFieldRelations() and $type = $me->getModel()->getFieldType($relation))
			{
				return $type->relation();	
			}
			else
			{
				return $me->getModel()->$relation();
			}
		});

		$nested = $this->nestedRelations($relation);

		// If there are nested relationships set on the query, we will put those onto
		// the query instances so that they can be handled after this relationship
		// is loaded. In this way they will all trickle down as they are loaded.
		if (count($nested) > 0)
		{
			$query->getQuery()->with($nested);
		}

		return $query;
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
            array_unshift($columns, $this->model->getTable().'.'.$this->model->getKeyName());
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

    /**
     * Eager load field type relations
     * @param  array  $columns The model columns
     * @return [type]          [description]
     */
    protected function eagerLoadFieldRelations($columns = array())
    {
    	$this->getModel()->setEagerFieldRelations($columns);

		if ($field_relations = $this->model->getEagerFieldRelations())
		{
			$this->with($field_relations);
		}
    }
}
