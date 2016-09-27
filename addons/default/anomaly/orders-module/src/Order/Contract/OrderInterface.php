<?php namespace Anomaly\OrdersModule\Order\Contract;

use Anomaly\OrdersModule\Item\ItemCollection;
use Anomaly\OrdersModule\Modifier\ModifierCollection;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Interface OrderInterface
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\OrdersModule\Order\Contract
 */
interface OrderInterface extends EntryInterface
{

    /**
     * Return the order total.
     *
     * @return float
     */
    public function total();

    /**
     * Return the order subtotal.
     *
     * @return float
     */
    public function subtotal();

    /**
     * Return the item quantity.
     *
     * @return float
     */
    public function quantity();

    /**
     * Return the total adjustments.
     *
     * @param $type
     * @param string $target
     */
    public function adjustments($type);

    /**
     * Get the string ID.
     *
     * @return string
     */
    public function getStrId();

    /**
     * Get related items.
     *
     * @return ItemCollection
     */
    public function getItems();

    /**
     * Return the items relationship.
     *
     * @return HasMany
     */
    public function items();

    /**
     * Get related modifiers.
     *
     * @return ModifierCollection
     */
    public function getModifiers();

    /**
     * Return the modifiers relationship.
     *
     * @return HasMany
     */
    public function modifiers();
}
