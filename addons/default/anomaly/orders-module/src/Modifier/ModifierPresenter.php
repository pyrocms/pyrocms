<?php namespace Anomaly\OrdersModule\Modifier;

use Anomaly\OrdersModule\Modifier\Contract\ModifierInterface;
use Anomaly\Streams\Platform\Entry\EntryPresenter;

/**
 * Class ModifierPresenter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ModifierPresenter extends EntryPresenter
{

    /**
     * The decorated object.
     *
     * @var ModifierInterface
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
