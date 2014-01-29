<?php namespace Pyro\Module\Streams_core;

use Illuminate\Support\Str;
use Pyro\Model\EloquentCollection;

class EntryCollection extends EloquentCollection
{
    /**
     * Get entry options
     * @param  string or null $attribute
     * @return array
     */
    public function getEntryOptions($attribute = null)
    {
        $options = array();

        foreach($this->items as $entry) {
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
     * @return array
     */
    public function lists($title_column = null, $key = null)
    {
        if ($title_column and $key) {
            return parent::lists($title_column, $key);
        }

        $options = array();

        foreach($this->items as $entry) {
            $options[$entry->getKey()] = $entry->getTitleColumnValue($title_column);
        }

        return $options;
    }

    public function getPresenter($viewOptions = array(), $defaultFormat = null, $presenter = null)
    {
        if ($presenter) {
            $this->presenter = $presenter;
        }

        $decorator = new EntryPresenterDecorator;

        return $decorator->viewOptions($viewOptions, $defaultFormat)->decorate($this);
    }
    /**
      * Get the collection of items as a plain array.
      *
      * @return array
      */
/*    public function toArray()
    {
        return array_map(function($value) {
           
            if ($value instanceof EntryPresenter) {
                return $value->getModel()->toArray();
            }

           return  ? $value->toArray() : $value;

        }, $this->items);
    }*/
}
