<?php namespace Anomaly\OrdersModule\Order\Command;

use Anomaly\OrdersModule\Order\Contract\OrderInterface;
use Anomaly\OrdersModule\Item\Contract\ItemInterface;
use Anomaly\OrdersModule\Item\Contract\ItemRepositoryInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class DeleteItems
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DeleteItems
{

    /**
     * The order instance.
     *
     * @var OrderInterface
     */
    protected $order;

    /**
     * Create a new DeleteItems instance.
     *
     * @param OrderInterface $order
     */
    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }

    /**
     * Handle the command.
     *
     * @param ItemRepositoryInterface $items
     */
    public function handle(ItemRepositoryInterface $items)
    {
        /* @var ItemInterface|EloquentModel $item */
        foreach ($this->order->getItems() as $item) {
            $items->delete($item);
        }
    }
}
