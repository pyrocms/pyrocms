<?php namespace Pyro\Module\Streams\Entry;

use Illuminate\Database\Eloquent\Builder;

class EntryQueryFilterConstraint
{

    /**
     * Query builder
     *
     * @var EntryFormBuilder
     */
    protected $query;

    /**
     * Constraint type
     *
     * @var string
     */
    protected $constraintType;

    /**
     * Filter by column
     *
     * @var string
     */
    protected $filterByColumn;

    /**
     * Value
     *
     * @var string
     */
    protected $value;

    /**
     * Construct
     *
     * @param Builder $query
     * @param         $constraintType
     * @param         $filterByColumn
     * @param         $value
     */
    public function __construct(Builder $query, $constraintType, $filterByColumn, $value)
    {
        $this->query = $query;

        $this->constraintType = $constraintType;

        $this->filterByColumn = $filterByColumn;

        $this->value = $value;
    }

    /**
     * Get query
     *
     * @return Builder|EntryFormBuilder
     */
    public function getQuery()
    {
        // Switch on the restriction
        switch ($this->constraintType) {

            /**
             * IS
             * results in: filter = value
             */
            case 'is':

                // Gotta have a value for this one
                if (empty($this->value)) {
                    continue;
                }

                // Do it
                $this->query->where($this->filterByColumn, '=', $this->value);
                break;

            /**
             * ISNOT
             * results in: filter != value
             */
            case 'isnot':

                // Gotta have a value for this one
                if (empty($this->value)) {
                    continue;
                }

                // Do it
                $this->query->where($this->filterByColumn, '!=', $this->value);
                break;


            /**
             * CONTAINS
             * results in: filter LIKE '%value%'
             */
            case 'contains':

                // Gotta have a value for this one
                if (empty($this->value)) {
                    continue;
                }

                // Do it
                $this->query->where($this->filterByColumn, 'LIKE', '%' . $this->value . '%');
                break;


            /**
             * DOESNOTCONTAIN
             * results in: filter NOT LIKE '%value%'
             */
            case 'doesnotcontain':

                // Gotta have a value for this one
                if (empty($this->value)) {
                    continue;
                }

                // Do it
                $this->query->where($this->filterByColumn, 'NOT LIKE', '%' . $this->value . '%');
                break;


            /**
             * STARTSWITH
             * results in: filter LIKE 'value%'
             */
            case 'startswith':

                // Gotta have a value for this one
                if (empty($this->value)) {
                    continue;
                }

                // Do it
                $this->query->where($this->filterByColumn, 'LIKE', $this->value . '%');
                break;


            /**
             * ENDSWITH
             * results in: filter LIKE '%value'
             */
            case 'endswith':

                // Gotta have a value for this one
                if (empty($this->value)) {
                    continue;
                }

                // Do it
                $this->query->where($this->filterByColumn, 'LIKE', '%' . $this->value);
                break;


            /**
             * ISEMPTY
             * results in: (filter IS NULL OR filter = '')
             */
            case 'isempty':

                $this->query->where(
                    function ($query) {
                        $query->where($this->filterByColumn, 'IS', 'NULL');
                        $query->orWhere($this->filterByColumn, '=', '');
                    }
                );
                break;


            /**
             * ISNOTEMPTY
             * results in: filter > '')
             */
            case 'isnotempty':

                $this->query->where($this->filterByColumn, '>', '');
                break;

            default:
                break;
        }

        return $this->query;
    }
}
