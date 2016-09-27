<?php namespace Anomaly\OrdersModule\Order\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface;
use Anomaly\UsersModule\User\Contract\UserInterface;

/**
 * Interface OrderRepositoryInterface
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\OrdersModule\Order\Contract
 */
interface OrderRepositoryInterface extends EntryRepositoryInterface
{

    /**
     * Find a order by it's string ID.
     *
     * @param $id
     * @return null|OrderInterface
     */
    public function findByStrId($id);

    /**
     * Find a order by it's user.
     *
     * @param UserInterface $user
     * @return null|OrderInterface
     */
    public function findByUser(UserInterface $user);
}
