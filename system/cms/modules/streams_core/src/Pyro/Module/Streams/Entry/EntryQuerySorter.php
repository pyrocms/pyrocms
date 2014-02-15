<?php namespace Pyro\Module\Streams\Entry;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class EntryQuerySorter
{
    /**
     * Order by column
     *
     * @var null|string
     */
    protected $orderBy = null;

    /**
     * Sort direction
     *
     * @var string
     */
    protected $sort = 'ASC';

    /**
     * Order by relation method
     *
     * @var string
     */
    protected $orderByRelationMethod;

    /**
     * Construct
     *
     * @param EntryQueryBuilder $query
     * @param                   $orderBy
     * @param                   $sort
     */
    public function __construct(EntryQueryBuilder $query, $orderBy, $sort)
    {
        $this->query                 = $query;
        $this->model                 = $query->getModel();
        $this->orderBy               = $orderBy;
        $this->sort                  = $sort;
        $this->orderByRelationMethod = Str::camel($orderBy);
    }

    /**
     * Get query
     *
     * @return EntryQueryBuilder
     */
    public function getQuery()
    {
        if ($this->model->hasRelationMethod($this->orderByRelationMethod)) {

            $orderByRelation = $this->model->{$this->orderByRelationMethod}();

            if ($orderByRelation instanceof BelongsTo) {

                $related = $orderByRelation->getRelated();

                // @todo - Untested, verify this actually works

                $this->orderBy = $related->getTable() . '.' . $related->getOrderByColumn();

                if (!$this->orderBy and $related instanceof EntryModel) {

                    $stream = $related->getStream();

                    if (!empty($stream->title_column)) {
                        $this->orderBy = $related->getTable() . '.' . $stream->title_column;
                    }
                }

                $joinColumn = $this->model->getTable() . '.' . $orderByRelation->getForeignKey();

                if ($this->orderBy) {
                    $this->query->join(
                        $related->getTable(),
                        $joinColumn,
                        '=',
                        $related->getTable() . '.' . $related->getKeyName()
                    );
                }
            }

        }

        if ($this->orderBy) {
            $this->query->orderBy($this->orderBy, $this->sort);
        }

        return $this->query;
    }
}