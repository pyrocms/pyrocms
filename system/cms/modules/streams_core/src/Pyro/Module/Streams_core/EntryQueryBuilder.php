<?php namespace Pyro\Module\Streams_core;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\Relation;
use Pyro\Model\EloquentQueryBuilder;

class EntryQueryBuilder extends EloquentQueryBuilder
{
    protected $entries = array();

    /**
     * Enable or disable eager loading field type relations
     * @var boolean
     */
    protected $enable_auto_eager_loading = false;

    protected $foreign_keys = array();

    protected $columns = array('*');

    protected $field_maps = array();

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($columns = null, $exclude = false)
    {
        // Get set up with our environment

        $this->table = $this->model->getTable();

        //$columns = $this->prepareColumns($columns);

        $this->applyFilters();

        $this->entries = $this->getModels($columns);

        // If we actually found models we will also eager load any relationships that
        // have been specified as needing to be eager loaded, which will solve the
        // n+1 query issue for the developers to avoid running a lot of queries.
        if (count($this->entries) > 0) {
            $this->entries = $this->eagerLoadRelations($this->entries);
        }

        return $this->model->newCollection($this->entries);
    }

    /**
     * Prep columns
     * @param  array  $columns
     * @return array
     */
    protected function prepareColumns($columns = null)
    {
        $this->parseColumnsAndFieldMaps();

        if (empty($columns)) {
            $columns = $this->model->getColumns();
        } elseif (empty($columns) and $exclude) {
            $columns = $this->model->getAllColumnsExclude();
        }

        foreach ($columns as $key => $column) {

            $segments = explode(':', $column);

            $columns[$key] = $segments[count($segments)-1];
        }

        // We need to return the models with their keys
        //return $this->requireColumns($columns);
        return $columns;
    }

    public function requireColumns($columns)
    {
        $entry = new EntryModel;

        // Always include the primary key if we are selecting specific columns, regardless
        if ( ! $this->hasAsterisk($columns) and ! in_array($this->model->getKeyName(), $columns)) {
            array_unshift($columns, $this->model->getTable().'.'.$this->model->getKeyName());
        } elseif ($this->hasAsterisk($columns)) {
            $columns = $this->model->getAllColumns();
        }

        // Require keys
        foreach ($columns as $key => $column) {

            // Field types can require columns
            if ($type = $this->model->getFieldType($column)) {
                $columns = array_merge($columns, $type->requireEntryColumns());
            }

            // Foreing keys are required too
            if ($relation = $this->model->getRelationAttribute($column)) {

                if ($relation instanceof BelongsToMany) {

                    unset($columns[$key]);

                } elseif ($relation instanceof BelongsTo) {

                    $foreign_key = $relation->getForeignKey();
                    $columns[] = $foreign_key;

                    if ($column != $foreign_key) {
                        $columns = array_diff($columns, array($column));
                    }
                }
            }
        }

        return array_unique($columns);
    }

    /**
     * Test if ALL columns (*)
     * @param  array   $columns
     * @return boolean
     */
    public function hasAsterisk(array $columns = array())
    {
        if ( ! empty($columns)) {
            foreach ($columns as $column) {
                if ($column == '*') return true;
            }
        }

        return false;
    }

    /**
     * Get view option relations
     * @return array
     */
    public function getViewOptionRelations()
    {
        $relations = array();

        $view_options = $this->model->getColumns();

        if ($this->isEnableAutoEagerLoading() and ! empty($view_options)) {
            if (in_array('created_by', $view_options)) {
                $relations[] = 'createdByUser';
            }

            foreach ($view_options as $column) {
                $column = str_replace('relation:', '', $column);
                if ($this->hasRelation($column)) {
                    $relations[] = $column;
                }
            }
        }

        return array_unique($relations);
    }

    protected function parseColumnsAndFieldMaps($columns = array())
    {
        $field_maps = array();

        $columns = array();

        foreach ($this->model->getViewOptions() as $key => $value) {
            if (is_numeric($key)) {

                $columns[] = $value;

            } else {

                if ( ! Str::startsWith($key, 'lang:')) {
                    $columns[] = $key;
                }

                $segments = explode(':', $key);

                $key = $segments[count($segments)-1];

                $field_maps[$key] = $value;
            }
        }

        $this->model
            ->setColumns($columns)
            ->setFieldMaps($field_maps);
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
        $query = Relation::noConstraints(function() use ($me, $relation) {
            return $me->model->getRelationAttribute($relation);
        });

        $nested = $this->nestedRelations($relation);

        // If there are nested relationships set on the query, we will put those onto
        // the query instances so that they can be handled after this relationship
        // is loaded. In this way they will all trickle down as they are loaded.
        if (count($nested) > 0) {
            $query->getQuery()->with($nested);
        }

        return $query;
    }

    public function getRelationAttribute($attribute = null)
    {
        $attribute = camel_case($attribute);

        if (method_exists($this->model, $attribute) and $relation = $this->model->$attribute() and ($relation instanceof Relation)) {

            return $relation;

        } elseif ($type = $this->model->getFieldType($attribute) and $type->hasRelation()) {

            return $type->relation();

        }

        return null;
    }

    public function hasRelation($attribute = null)
    {
        return $this->model->getRelationAttribute($attribute) instanceof Relation;
    }

    public function relationAsJoin($attribute)
    {
        $attribute = strtolower($attribute);

        if ($this->hasRelation($attribute)) {

            $relation = $this->model->getRelationAttribute($attribute);

            $related_table = $relation->getRelated()->getTable();

            $related_key = $relation->getRelated()->getKeyName();

            if ($relation instanceof BelongsTo) {

                return $this->join($related_table, $related_table.'.'.$related_key, '=', $this->model->getTable().'.'.$relation->getForeignKey());

            } elseif ($relation instanceof BelongsToMany) {

                //

            }

        } else {

            // Throw exception if its not an instance of Relation

        }
    }

    /**
     * Enable or disable automatic eager loading
     * @param boolean $format
     * @return  object
     */
    public function enableAutoEagerLoading($enable_auto_eager_loading = true)
    {
        $this->enable_auto_eager_loading = $enable_auto_eager_loading;

        return $this;
    }

    /**
     * Is eager loading field relations enabled
     * @return boolean
     */
    public function isEnableAutoEagerLoading()
    {
        return $this->enable_auto_eager_loading;
    }


    protected function applyFilters()
    {
        // -------------------------------------
        // Filters (QueryString API)
        // -------------------------------------

        if (ci()->input->get('filter-'.$this->model->getStream()->stream_namespace.'-'.$this->model->getStream()->stream_slug)) {

            // Get all URL variables
            $query_string_variables = ci()->input->get();

            // Loop and process!
            foreach ($query_string_variables as $filter => $value) {

                // Split into components
                $commands = explode('-', $filter);

                // Filter?
                if ($commands[0] != 'f') continue;

                // Only filter our current namespace / stream
                if ($commands[1] != $this->model->getStream()->stream_namespace) continue;
                if ($commands[2] != $this->model->getStream()->stream_slug) continue;

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

        if ($order_by = ci()->input->get('order-'.$this->model->getStream()->stream_namespace.'-'.$this->model->getStream()->stream_slug)) {
            if ($sort_by = ci()->input->get('sort-'.$this->model->getStream()->stream_namespace.'-'.$this->model->getStream()->stream_slug)) {

                if ($order_by_relation = $this->model->getRelationAttribute($order_by) and $order_by_relation instanceof Relation) {
                    $order_by = $order_by_relation->getForeignKey();
                }

                $this->orderBy($order_by, $sort_by);
            } else {
                $this->orderBy($order_by, 'ASC');
            }
        }

        return $this;
    }

    /**
     * Retrieve the "count" result of the query.
     * @param  string $column
     * @return int
     */
    public function count($column = '*')
    {
        $this->applyFilters();

        return parent::count($column);
    }
}
