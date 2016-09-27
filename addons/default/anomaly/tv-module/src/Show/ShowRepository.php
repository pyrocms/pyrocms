<?php namespace Anomaly\TvModule\Show;

use Anomaly\TvModule\Show\Contract\ShowRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class ShowRepository extends EntryRepository implements ShowRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var ShowModel
     */
    protected $model;

    /**
     * Create a new ShowRepository instance.
     *
     * @param ShowModel $model
     */
    public function __construct(ShowModel $model)
    {
        $this->model = $model;
    }
}
