<?php namespace Anomaly\ExampleModule\Widget;

use Anomaly\ExampleModule\Widget\Contract\WidgetRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class WidgetRepository extends EntryRepository implements WidgetRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var WidgetModel
     */
    protected $model;

    /**
     * Create a new WidgetRepository instance.
     *
     * @param WidgetModel $model
     */
    public function __construct(WidgetModel $model)
    {
        $this->model = $model;
    }
}
