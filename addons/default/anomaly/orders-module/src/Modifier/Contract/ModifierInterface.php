<?php namespace Anomaly\OrdersModule\Modifier\Contract;

use Anomaly\OrdersModule\Order\Contract\OrderInterface;
use Anomaly\OrdersModule\Item\Contract\ItemInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Interface ModifierInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface ModifierInterface extends EntryInterface
{

    /**
     * Apply the modifier to the value.
     *
     * @param $value
     * @return float
     */
    public function apply($value);

    /**
     * Calculate the value.
     *
     * @param $value
     * @return float
     */
    public function calculate($value);

    /**
     * Return whether this modifier
     * is an addition or not.
     *
     * @return bool
     */
    public function isAddition();

    /**
     * Return whether this modifier
     * is a subtraction or not.
     *
     * @return bool
     */
    public function isSubtraction();

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
     * Get the related item.
     *
     * @return ItemInterface
     */
    public function getItem();

    /**
     * Get the item relation.
     *
     * @return BelongsTo
     */
    public function item();

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the type.
     *
     * @return string
     */
    public function getType();

    /**
     * Get the scope.
     *
     * @return string
     */
    public function getScope();

    /**
     * Get the target.
     *
     * @return string
     */
    public function getTarget();

    /**
     * Get the value.
     *
     * @return string
     */
    public function getValue();

    /**
     * Get the properties.
     *
     * @return array
     */
    public function getProperties();
}
