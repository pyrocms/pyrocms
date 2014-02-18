<?php namespace Pyro\Module\Streams\Entry;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Pyro\Model\EloquentReflection;
use Pyro\Module\Streams\Stream\StreamModel;

class EntryQueryFilter
{
    /**
     * The query builder instance
     *
     * @var EntryQueryBuilder
     */
    protected $query;

    /**
     * The parent model
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The stream
     *
     * @var StreamModel
     */
    protected $stream;

    public function __construct(Builder $query)
    {
        $this->query = $query;
        $this->model = $query->getModel();
        $this->stream = $this->model->getStream();
    }

    public function getQuery()
    {
        // -------------------------------------
        // Filters (QueryString API)
        // -------------------------------------
        if (ci()->input->get('filter-' . $this->stream->stream_namespace . '-' . $this->stream->stream_slug)) {

            // Get all URL variables
            $queryStringVariables = ci()->input->get();

            // Loop and process!
            foreach ($queryStringVariables as $filter => $value) {

                // Split into components
                $commands = explode('-', $filter);

                // Filter? namespace ? stream ?
                if ($commands[0] != 'f' or
                    $commands[1] != $this->stream->stream_namespace or
                    $commands[2] != $this->stream->stream_slug
                ) {
                    continue;
                }

                // Get the original fieldSlug
                $fieldSlug = $commands[3];

                // Get the filterBy array
                $filterBy = explode('|', $fieldSlug);

                // The first item in the array is the qualified fieldSlug
                $fieldSlug = array_shift($filterBy);

                // Get the camel case relation method from the fieldSlug
                $relationMethod = Str::camel($fieldSlug);

                // Get the constraint type string
                $constraintType = $commands[4];

                // Enable whereHas logic only if the slug is a relation
                if ($value != null) {
                    if ($relation = $this->reflection($this->model)->getRelationClass($relationMethod)) {
                        $this->query->whereHas(
                            $relationMethod,
                            function ($query) use ($filterBy, $constraintType, $value) {
                                // Do a constraint for each column from the related model
                                foreach ($filterBy as $column) {
                                    /**
                                     * @todo - Here is an opportunity to override the constraint
                                     * by parsing each column string. Revisit to implement this feature.
                                     */
                                    $this->constraint($query, $constraintType, $column, $value);
                                }
                            }
                        );
                    } else {

                        // Do a normal constraint
                        $this->constraint($this->query, $constraintType, $fieldSlug, $value);
                    }
                }
            }
        }

        // -------------------------------------
        // Ordering / Sorting (QueryString API)
        // -------------------------------------

        if ($orderBy = ci()->input->get(
            'order-' . $this->stream->stream_namespace . '-' . $this->stream->stream_slug
        )
        ) {

            $sort = ci()->input->get(
                'sort-' . $this->stream->stream_namespace . '-' . $this->stream->stream_slug,
                'ASC'
            );

            $this->order($this->query, $orderBy, $sort);
        }

        return $this->query;
    }

    /**
     * Get a new EloquentReflection object
     *
     * @param $model
     *
     * @return EloquentReflection
     */
    protected function reflection($model)
    {
        return new EloquentReflection($model);
    }

    /**
     * Constraint
     *
     * @param Builder $query
     * @param         $constraintType
     * @param         $filterByColumn
     * @param         $value
     *
     * @return Builder
     */
    protected function constraint(Builder $query, $constraintType, $filterByColumn, $value)
    {
        $constraint = new EntryQueryFilterConstraint($query, $constraintType, $filterByColumn, $value);

        return $constraint->getQuery();
    }

    /**
     * Order
     *
     * @param Builder $query
     * @param                   $orderBy
     * @param                   $order
     *
     * @return Builder
     */
    public function order(Builder $query, $orderBy, $order)
    {
        $order = new EntryQuerySorter($query, $orderBy, $order);

        return $order->getQuery();
    }
}