<?php namespace Anomaly\OrdersModule\Modifier\Command;

use Anomaly\OrdersModule\Modifier\Contract\ModifierInterface;
use Anomaly\OrdersModule\Modifier\ModifierValue;

/**
 * Class ApplyModifier
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ApplyModifier
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
     * Create a new ApplyModifier instance.
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
            if ($value->isSubtraction($modification)) {
                $result = floatval($this->value - ($this->value * ($delta / 100)));
            } else {
                $result = floatval($this->value + ($this->value * ($delta / 100)));
            }
        } else {
            if ($value->isSubtraction($modification)) {
                $result = floatval($this->value - $delta);
            } else {
                $result = floatval($this->value + $delta);
            }
        }

        return $result < 0 ? 0.00 : $result;
    }
}
