<?php namespace Anomaly\OrdersModule\Item;

use Anomaly\OrdersModule\Item\Contract\ItemInterface;
use Anomaly\Streams\Platform\Entry\EntryPresenter;

/**
 * Class ItemPresenter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ItemPresenter extends EntryPresenter
{

    /**
     * The decorated object.
     *
     * @var ItemInterface
     */
    protected $object;

    /**
     * Return a property value.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function property($key, $default = null)
    {
        return array_get($this->object->getProperties(), $key, $default);
    }

    /**
     * Map through properties too.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (isset($this->object->getProperties()[$key])) {
            return $this->property($key);
        }

        return parent::__get($key);
    }
}
