<?php namespace Anomaly\OrdersModule\Item;

use Anomaly\OrdersModule\Item\Command\DeleteModifiers;
use Anomaly\OrdersModule\Item\Contract\ItemInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryObserver;

class ItemObserver extends EntryObserver
{

    /**
     * Run after a record has been deleted.
     *
     * @param ItemInterface|EntryInterface $entry
     */
    public function deleted(EntryInterface $entry)
    {
        $this->dispatch(new DeleteModifiers($entry));

        parent::deleted($entry);
    }
}
