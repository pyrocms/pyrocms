<?php namespace Anomaly\OrdersModule\Item\Command;

use Anomaly\OrdersModule\Item\Contract\ItemInterface;
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
     * The order item.
     *
     * @var ItemInterface
     */
    protected $item;

    /**
     * Create a new DeleteModifiers instance.
     *
     * @param ItemInterface $item
     */
    public function __construct(ItemInterface $item)
    {
        $this->item = $item;
    }

    /**
     * Handle the command.
     *
     * @param ModifierRepositoryInterface $modifiers
     */
    public function handle(ModifierRepositoryInterface $modifiers)
    {
        /* @var ModifierInterface|EloquentModel $modifier */
        foreach ($this->item->getModifiers() as $modifier) {
            $modifiers->delete($modifier);
        }
    }
}
