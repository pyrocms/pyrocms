<?php namespace Anomaly\OrdersModule\Order;

use Anomaly\OrdersModule\Order\Contract\OrderInterface;
use Anomaly\OrdersModule\Order\Contract\OrderRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;
use Anomaly\UsersModule\User\Contract\UserInterface;

/**
 * Class OrderRepository
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\OrdersModule\Order
 */
class OrderRepository extends EntryRepository implements OrderRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var OrderModel
     */
    protected $model;

    /**
     * Create a new OrderRepository instance.
     *
     * @param OrderModel $model
     */
    public function __construct(OrderModel $model)
    {
        $this->model = $model;
    }

    /**
     * Find a order by it's string ID.
     *
     * @param $id
     * @return null|OrderInterface
     */
    public function findByStrId($id)
    {
        return $this->model->where('str_id', $id)->first();
    }

    /**
     * Find a order by it's user.
     *
     * @param UserInterface $user
     * @return null|OrderInterface
     */
    public function findByUser(UserInterface $user)
    {
        return $this->model->where('user_id', $user->getId())->first();
    }
}
