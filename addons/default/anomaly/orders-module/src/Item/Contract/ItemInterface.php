<?php namespace Anomaly\OrdersModule\Item\Contract;

use Anomaly\OrdersModule\Order\Contract\OrderInterface;
use Anomaly\OrdersModule\Modifier\ModifierCollection;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Interface ItemInterface
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\OrdersModule\Item\Contract
 */
interface ItemInterface extends EntryInterface
{

    /**
     * Return the item total.
     *
     * @return float
     */
    public function total();

    /**
     * Return the item subtotal.
     *
     * @return float
     */
    public function subtotal();

    /**
     * Calculate total adjustments.
     *
     * @param $type
     * @return float
     */
    public function calculate($type);

    /**
     * Get the related order.
     *
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * Get the order relation.
     *
     * @return BelongsTo
     */
    public function order();

    /**
     * Get the price.
     *
     * @return float
     */
    public function getPrice();

    /**
     * Get the options.
     *
     * @return array
     */
    public function getOptions();

    /**
     * Get the quantity.
     *
     * @return int
     */
    public function getQuantity();

    /**
     * Get the properties.
     *
     * @return array
     */
    public function getProperties();

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
