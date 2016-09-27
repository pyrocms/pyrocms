<?php namespace Anomaly\OrdersModule\Order\Command;

use Anomaly\OrdersModule\Order\Contract\OrderInterface;
use Anomaly\OrdersModule\Order\Contract\OrderRepositoryInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

/**
 * Class GetOrder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\OrdersModule\Order\Command
 */
class GetOrder
{
    
    /**
     * Handle the command.
     *
     * @param OrderRepositoryInterface $orders
     * @param Store                   $session
     * @param Request                 $request
     * @param Guard                   $auth
     * @return OrderInterface
     */
    public function handle(OrderRepositoryInterface $orders, Store $session, Request $request, Guard $auth)
    {
        if (!$order = $orders->findByStrId($session->get('anomaly.module.orders::order'))) {
            $order = $orders->create(
                [
                    'user'       => $auth->user(),
                    'session'    => $session->getId(),
                    'ip_address' => $request->ip(),
                ]
            );
        }

        /* @var OrderInterface $order */
        $session->set('anomaly.module.orders::order', $order->getStrId());

        return $order;
    }
}
