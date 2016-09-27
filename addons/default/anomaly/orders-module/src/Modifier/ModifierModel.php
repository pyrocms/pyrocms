<?php namespace Anomaly\OrdersModule\Modifier;

use Anomaly\OrdersModule\Order\Contract\OrderInterface;
use Anomaly\OrdersModule\Item\Contract\ItemInterface;
use Anomaly\OrdersModule\Modifier\Command\ApplyModifier;
use Anomaly\OrdersModule\Modifier\Command\CalculateValue;
use Anomaly\OrdersModule\Modifier\Contract\ModifierInterface;
use Anomaly\Streams\Platform\Model\Orders\OrdersModifiersEntryModel;

/**
 * Class ModifierModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ModifierModel extends OrdersModifiersEntryModel implements ModifierInterface
{

    /**
     * Apply the modifier to the value.
     *
     * @param $value
     * @return float
     */
    public function apply($value)
    {
        return $this->dispatch(new ApplyModifier($this, $value));
    }

    /**
     * Calculate the value.
     *
     * @param $value
     * @return float
     */
    public function calculate($value)
    {
        return $this->dispatch(new CalculateValue($this, $value));
    }

    /**
     * Return whether this modifier
     * is an addition or not.
     *
     * @return bool
     */
    public function isAddition()
    {
        return (new ModifierValue())->isAddition($this->getValue());
    }

    /**
     * Return whether this modifier
     * is a subtraction or not.
     *
     * @return bool
     */
    public function isSubtraction()
    {
        return (new ModifierValue())->isSubtraction($this->getValue());
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
     * Get the related item.
     *
     * @return ItemInterface
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the scope.
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Get the target.
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Get the value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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
}
