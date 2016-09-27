<?php namespace Anomaly\OrdersModule\Modifier\Command;

use Anomaly\OrdersModule\Modifier\Contract\ModifierInterface;
use Anomaly\OrdersModule\Modifier\ModifierValue;

/**
 * Class CalculateValue
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CalculateValue
{

    /**
     * The modifier instance.
     *
     * @var ModifierInterface
     */
    protected $modifier;

    /**
     * The value to apply
     * the modifier to.
     *
     * @var float
     */
    protected $value;

    /**
     * Create a new CalculateValue instance.
     *
     * @param ModifierInterface $modifier
     * @param float $value
     */
    public function __construct(ModifierInterface $modifier, $value)
    {
        $this->value    = $value;
        $this->modifier = $modifier;
    }

    /**
     * Handle the command.
     *
     * @param ModifierValue $value
     * @return float
     */
    public function handle(ModifierValue $value)
    {
        $modification = $this->modifier->getValue();

        $delta = $value->clean($modification);

        if ($value->isPercentage($modification)) {
            $delta = floatval($this->value * ($delta / 100));
        }

        return $delta;
    }
}
