<?php namespace Anomaly\OrdersModule\Order;

use Anomaly\OrdersModule\Order\Contract\OrderInterface;
use Anomaly\OrdersModule\Item\ItemCollection;
use Anomaly\OrdersModule\Item\ItemModel;
use Anomaly\OrdersModule\Modifier\Contract\ModifierInterface;
use Anomaly\OrdersModule\Modifier\ModifierCollection;
use Anomaly\OrdersModule\Modifier\ModifierModel;
use Anomaly\Streams\Platform\Model\Orders\OrdersOrdersEntryModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class OrderModel
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\OrdersModule\Order
 */
class OrderModel extends OrdersOrdersEntryModel implements OrderInterface
{

    /**
     * Return the order total.
     *
     * @return float
     */
    public function total()
    {
        $items = $this->getItems();

        return $this->adjust($items->total());
    }

    /**
     * Return the order subtotal.
     *
     * @return float
     */
    public function subtotal()
    {
        return $this
            ->getItems()
            ->subtotal();
    }

    /**
     * Return the item quantity.
     *
     * @return float
     */
    public function quantity()
    {
        $items = $this->getItems();

        return $items->quantity();
    }

    /**
     * Return the total adjustments.
     *
     * @param $type
     * @param string $target
     */
    public function adjustments($type)
    {
        $items = $this->getItems();

        $modifiers = $this
            ->getModifiers()
            ->type($type);

        return $items->adjustments($type) + $modifiers->calculate($items->total());
    }

    /**
     * Return the total discounts.
     *
     * @param $target
     * @return float
     */
    protected function adjust($value)
    {
        $modifiers = $this->getModifiers();

        /* @var ModifierInterface $modifier */
        foreach ($modifiers as $modifier) {
            $value = $modifier->apply($value);
        }

        return $value;
    }

    /**
     * Get the string ID.
     *
     * @return string
     */
    public function getStrId()
    {
        return $this->str_id;
    }

    /**
     * Get related items.
     *
     * @return ItemCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Return the items relationship.
     *
     * @return HasMany
     */
    public function items()
    {
        return $this->hasMany(ItemModel::class, 'order_id');
    }

    /**
     * Get related modifiers.
     *
     * @return ModifierCollection
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }

    /**
     * Return the modifiers relationship.
     *
     * @return HasMany
     */
    public function modifiers()
    {
        return $this->hasMany(ModifierModel::class, 'order_id')
            ->where('target', 'subtotal');
    }
}
