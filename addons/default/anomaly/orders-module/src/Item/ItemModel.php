<?php namespace Anomaly\OrdersModule\Item;

use Anomaly\OrdersModule\Order\Contract\OrderInterface;
use Anomaly\OrdersModule\Item\Contract\ItemInterface;
use Anomaly\OrdersModule\Modifier\ModifierCollection;
use Anomaly\OrdersModule\Modifier\ModifierModel;
use Anomaly\Streams\Platform\Model\Orders\OrdersItemsEntryModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ItemModel
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\OrdersModule\Item
 */
class ItemModel extends OrdersItemsEntryModel implements ItemInterface
{

    /**
     * Return the item total.
     *
     * @return float
     */
    public function total()
    {
        return $this
            ->getModifiers()
            ->apply($this->subtotal());
    }

    /**
     * Return the item subtotal.
     *
     * @return float
     */
    public function subtotal()
    {
        return $this->getQuantity() * $this->getPrice();
    }

    /**
     * Calculate total adjustments.
     *
     * @param $type
     * @return float
     */
    public function calculate($type)
    {
        $modifiers = $this
            ->getModifiers()
            ->type($type);

        return $modifiers->calculate($this->subtotal());
    }

    /**
     * Get the related order.
     *
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Get the price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get the quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Get the properties.
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Get the properties attribute.
     *
     * @return array
     */
    public function getPropertiesAttribute()
    {
        return json_decode($this->attributes['properties'], true);
    }

    /**
     * Set the properties attribute.
     *
     * @param array $properties
     * @return $this
     */
    public function setPropertiesAttribute(array $properties)
    {
        $this->attributes['properties'] = json_encode($properties);

        return $this;
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
        return $this->hasMany(ModifierModel::class, 'item_id')
            ->where('target', 'item');
    }
}
