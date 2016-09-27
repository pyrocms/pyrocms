<?php namespace Anomaly\OrdersModule\Modifier;

use Anomaly\OrdersModule\Modifier\Contract\ModifierInterface;
use Anomaly\Streams\Platform\Entry\EntryCollection;

/**
 * Class ModifierCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ModifierCollection extends EntryCollection
{

    /**
     * Return only modifiers with target.
     *
     * @param $target
     * @return ModifierCollection
     */
    public function target($target)
    {
        return $this->filter(
            function ($modifier) use ($target) {

                /* @var ModifierInterface $modifier */
                return $modifier->getTarget() == $target;
            }
        );
    }

    /**
     * Return only modifiers with scope.
     *
     * @param $scope
     * @return ModifierCollection
     */
    public function scope($scope)
    {
        return $this->filter(
            function ($modifier) use ($scope) {

                /* @var ModifierInterface $modifier */
                return $modifier->getScope() == $scope;
            }
        );
    }

    /**
     * Return only modifiers with type.
     *
     * @param $type
     * @return ModifierCollection
     */
    public function type($type)
    {
        return $this->filter(
            function ($modifier) use ($type) {

                /* @var ModifierInterface $modifier */
                return in_array($modifier->getType(), (array)$type);
            }
        );
    }

    /**
     * Return subtraction modifiers.
     *
     * @return ModifierCollection
     */
    public function subtractions()
    {
        /* @var ModifierValue $value */
        $value = app(ModifierValue::class);

        return $this->filter(
            function ($modifier) use ($value) {

                /* @var ModifierInterface $modifier */
                return $value->isSubtraction($modifier->getValue());
            }
        );
    }

    /**
     * Return addition modifiers.
     *
     * @return ModifierCollection
     */
    public function additions()
    {
        /* @var ModifierValue $value */
        $value = app(ModifierValue::class);

        return $this->filter(
            function ($modifier) use ($value) {

                /* @var ModifierInterface $modifier */
                return $value->isAddition($modifier->getValue());
            }
        );
    }

    /**
     * Sum the calculated values.
     *
     * @param $value
     * @return float
     */
    public function calculate($value)
    {
        return $this->sum(
            function ($modifier) use ($value) {

                /* @var ModifierInterface $modifier */
                return $modifier->calculate($value);
            }
        );
    }

    /**
     * Apply the modifier values.
     *
     * @param $value
     * @return float
     */
    public function apply($value)
    {
        $this->map(
            function ($modifier) use (&$value) {

                /* @var ModifierInterface $modifier */
                $value = $modifier->apply($value);
            }
        );

        return $value;
    }
}
