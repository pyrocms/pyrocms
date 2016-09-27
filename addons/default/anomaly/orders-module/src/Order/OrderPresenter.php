<?php namespace Anomaly\OrdersModule\Order;

use Anomaly\OrdersModule\Order\Contract\OrderInterface;
use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Illuminate\Session\Store;

/**
 * Class OrderPresenter
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\OrdersModule\Order
 */
class OrderPresenter extends EntryPresenter
{

    /**
     * The decorated object.
     *
     * @var OrderInterface
     */
    protected $object;

    /**
     * Return the status of the order.
     *
     * @return string
     */
    public function status()
    {
        $date = $this->object->lastModified();

        if ($date->diffInMinutes() < 15) {
            return 'active';
        }

        if ($date->diffInMinutes() < 60) {
            return 'stale';
        }

        return 'abandoned';
    }

    /**
     * Return the status label.
     *
     * @param string $size
     * @return string
     */
    public function label($text = null, $context = null, $size = null)
    {
        if (!$text) {
            switch ($this->status()) {
                case 'active':
                    return parent::label('anomaly.module.orders::status.active', 'success', $size);
                    break;

                case 'stale':
                    return parent::label('anomaly.module.orders::status.stale', 'warning', $size);
                    break;

                case 'abandoned':
                    return parent::label('anomaly.module.orders::status.abandoned', 'default', $size);
                    break;
            }

            return parent::label('anomaly.module.order::status.abandoned', 'secondary', $size);
        }

        return parent::label($text, $context, $size);
    }
}
