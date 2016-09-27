<?php namespace Anomaly\OrdersModule\Order\Command;

use Anomaly\OrdersModule\Order\Contract\OrderInterface;
use Anomaly\OrdersModule\Modifier\Contract\ModifierInterface;
use Anomaly\OrdersModule\Modifier\Contract\ModifierRepositoryInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class DeleteModifiers
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DeleteModifiers
{

    /**
     * The order instance.
     *
     * @var OrderInterface
     */
    protected $order;

    /**
     * Create a new DeleteModifiers instance.
     *
     * @param OrderInterface $order
     */
    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }

    /**
     * Handle the command.
     *
     * @param ModifierRepositoryInterface $modifiers
     */
    public function handle(ModifierRepositoryInterface $modifiers)
    {
        /* @var ModifierInterface|EloquentModel $modifier */
        foreach ($this->order->getModifiers() as $modifier) {
            $modifiers->delete($modifier);
        }
    }
}
