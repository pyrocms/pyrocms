<?php namespace Anomaly\OrdersModule\Item;

use Anomaly\OrdersModule\Item\Contract\ItemInterface;
use Anomaly\Streams\Platform\Entry\EntryCollection;

/**
 * Class ItemCollection
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\OrdersModule\Item
 */
class ItemCollection extends EntryCollection
{

    /**
     * Return the total.
     *
     * @return float
     */
    public function total()
    {
        return $this->sum(
            function ($item) {

                /* @var ItemInterface $item */
                return $item->total();
            }
        );
    }

    /**
     * Return the subtotal.
     *
     * @return float
     */
    public function subtotal()
    {
        return $this->sum(
            function ($item) {

                /* @var ItemInterface $item */
                return $item->subtotal();
            }
        );
    }

    /**
     * Return the total calculations.
     *
     * @return float
     */
    public function adjustments($type)
    {
        return $this->sum(
            function ($item) use ($type) {

                /* @var ItemInterface $item */
                return $item->calculate($type);
            }
        );
    }

    /**
     * Return the total quantity.
     *
     * @return int
     */
    public function quantity()
    {
        return $this->sum(
            function ($item) {

                /* @var ItemInterface $item */
                return $item->getQuantity();
            }
        );
    }
}
