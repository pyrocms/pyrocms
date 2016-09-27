<?php namespace Anomaly\OrdersModule\Modifier;

/**
 * Class ModifierValue
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ModifierValue
{


    /**
     * Return whether the value is a percentage.
     *
     * @param $value
     * @return bool
     */
    public function isPercentage($value)
    {
        return (preg_match('/%/', $value) == 1);
    }

    /**
     * Return whether the value is a subtraction.
     *
     * @param $value
     * @return bool
     */
    public function isSubtraction($value)
    {
        return (preg_match('/\-/', $value) == 1);
    }

    /**
     * Return whether the value is an addition.
     *
     * @param $value
     * @return bool
     */
    public function isAddition($value)
    {
        return (preg_match('/\+/', $value) == 1) || (!starts_with($value, ['+', '-']));
    }

    /**
     * Removes arithmetic signs (%,+,-).
     *
     * @param $value
     * @return mixed
     */
    public function clean($value)
    {
        return str_replace(array('%', '-', '+'), '', $value);
    }
}
