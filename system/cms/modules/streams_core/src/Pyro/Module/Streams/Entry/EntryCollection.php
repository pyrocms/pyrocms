<?php namespace Pyro\Module\Streams\Entry;

use Pyro\Model\EloquentCollection;

class EntryCollection extends EloquentCollection
{
    protected $model;

    public function __construct(array $items = array(), EntryModel $model = null)
    {
        parent::__construct($items);

        $this->model = $model;
    }

    /**
     * Get entry options
     *
     * @param  string or null $attribute
     *
     * @return array
     */
    public function getEntryOptions($attribute = null)
    {
        $options = array();

        foreach ($this->items as $entry) {
            if ($attribute) {
                $options[$entry->getKey()] = $entry->{$attribute};
            } else {
                $options[$entry->getKey()] = $entry->getTitleColumnValue();
            }
        }

        return $options;
    }

    /**
     * Lists
     *
     * @return array
     */
    public function lists($title_column = null, $key = null)
    {
        if ($title_column and $key) {
            return parent::lists($title_column, $key);
        }

        $options = array();

        foreach ($this->items as $entry) {
            $options[$entry->getKey()] = $entry->getTitleColumnValue($title_column);
        }

        return $options;
    }

    /**
     * Get the presenter object
     *
     * @param array  $viewOptions
     * @param string $defaultFormat
     *
     * @return Pyro\Support\Presenter|Pyro\Model\Eloquent
     */
    public function getPresenter($viewOptions = array(), $defaultFormat = null)
    {
        $decorator = new EntryPresenterDecorator;

        $viewOptions = EntryViewOptions::make($this->model, $viewOptions, $defaultFormat);

        return $decorator->setViewOptions($viewOptions)->decorate($this);
    }

    /**
     * To array
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();

        foreach ($array as $k => &$v) {
            $v['_count'] = $k;
        }

        return $array;
    }
}
