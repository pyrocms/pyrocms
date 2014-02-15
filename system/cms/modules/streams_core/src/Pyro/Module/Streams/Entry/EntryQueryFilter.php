<?php namespace Pyro\Module\Streams\Entry;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Pyro\Model\EloquentReflection;

class EntryQueryFilter
{
    protected $query;

    protected $model;

    public function __construct(EntryQueryBuilder $query)
    {
        $this->filterQuery($query);
    }

    protected function filterQuery($query)
    {


        // -------------------------------------
        // Filters (QueryString API)
        // -------------------------------------
        $model = $query->getModel();

        $stream = $model->getStream();

        if (ci()->input->get('filter-' . $stream->stream_namespace . '-' . $stream->stream_slug)) {

            // Get all URL variables
            $queryStringVariables = ci()->input->get();

            // Loop and process!
            foreach ($queryStringVariables as $filter => $value) {

                // Split into components
                $commands = explode('-', $filter);

                // Filter? namespace ? stream ?
                if ($commands[0] != 'f' or
                    $commands[1] != $stream->stream_namespace or
                    $commands[2] != $stream->stream_slug
                ) {
                    continue;
                }

                $fieldSlug = $commands[3];

                $constraintType = $commands[4];

                $filterBy = explode('|', $fieldSlug);

                $fieldSlug = array_shift($filterBy);

                if ($relation = $this->reflection($model)->getRelationClass($fieldSlug)) {

                    $query->whereHas(
                        'category',
                        function ($query) use ($filterBy, $constraintType, $value) {
                            foreach ($filterBy as $column) {
                                $this->constrain($query, $constraintType, $column, $value);
                            }
                        }
                    );

                } else {

                    $query = $this->constrain($query, $constraintType, $fieldSlug, $value);

                }
            }
        }

        // -------------------------------------
        // Ordering / Sorting (QueryString API)
        // -------------------------------------

        if ($orderBy = ci()->input->get(
            'order-' . $stream->stream_namespace . '-' . $stream->stream_slug
        )
        ) {

            $sort = ci()->input->get(
                'sort-' . $stream->stream_namespace . '-' . $stream->stream_slug,
                'ASC'
            );

            $this->order($query, $orderBy, $sort);
        }

        return $this;
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
     * @return Builder|EntryFormBuilder
     */
    protected function constrain(Builder $query, $constraintType, $filterByColumn, $value)
    {
        $constraint = new EntryQueryFilterConstraint($query, $constraintType, $filterByColumn, $value);

        return $constraint->getQuery();
    }

    /**
     * Order
     *
     * @param EntryQueryBuilder $query
     * @param                   $orderBy
     * @param                   $order
     *
     * @return EntryQueryBuilder
     */
    public function order(EntryQueryBuilder $query, $orderBy, $order)
    {
        $order = new EntryQuerySorter($query, $orderBy, $order);

        return $order->getQuery();
    }
}