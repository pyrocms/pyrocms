<?php namespace Anomaly\OrdersModule\Order;

use Anomaly\OrdersModule\Order\Command\DeleteItems;
use Anomaly\OrdersModule\Order\Command\DeleteModifiers;
use Anomaly\OrdersModule\Order\Contract\OrderInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\EntryObserver;

/**
 * Class OrderObserver
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\OrdersModule\Order
 */
class OrderObserver extends EntryObserver
{

    /**
     * Fired just before saving the entry.
     *
     * @param EntryInterface|OrderInterface $entry
     */
    public function creating(EntryInterface $entry)
    {
        if (!$entry->getStrId()) {
            $entry->setAttribute('str_id', str_random());
        }

        parent::creating($entry);
    }

    /**
     * Run after a record has been deleted.
     *
     * @param OrderInterface|EntryInterface $entry
     */
    public function deleted(EntryInterface $entry)
    {
        $this->dispatch(new DeleteItems($entry));
        $this->dispatch(new DeleteModifiers($entry));

        parent::deleted($entry);
    }
}
