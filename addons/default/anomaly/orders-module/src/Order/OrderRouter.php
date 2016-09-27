<?php namespace Anomaly\OrdersModule\Order;

use Anomaly\Streams\Platform\Entry\EntryRouter;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Support\Presenter;

class OrderRouter extends EntryRouter
{

    public function itemsAdd($parameters)
    {
        $entry = array_pull($parameters, 'entry');

        if ($entry && $entry instanceof Presenter) {
            $entry = $entry->getObject();
        }

        if ($entry && $entry instanceof EloquentModel) {
            $parameters['entry_id']   = $entry->getId();
            $parameters['entry_type'] = get_class($entry);
        }

        return $this->url->route('anomaly.module.orders::items.add', $parameters);
    }
}
