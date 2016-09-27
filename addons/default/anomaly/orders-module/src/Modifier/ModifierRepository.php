<?php namespace Anomaly\OrdersModule\Modifier;

use Anomaly\OrdersModule\Modifier\Contract\ModifierRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class ModifierRepository extends EntryRepository implements ModifierRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var ModifierModel
     */
    protected $model;

    /**
     * Create a new ModifierRepository instance.
     *
     * @param ModifierModel $model
     */
    public function __construct(ModifierModel $model)
    {
        $this->model = $model;
    }
}
