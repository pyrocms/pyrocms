<?php namespace Pyro\Model;

use Illuminate\Database\Eloquent\Collection;

class EloquentCollection extends Collection
{
    public function findByAttribute($value = null, $attribute = null)
    {
        foreach ($this->items as $model) {
            if ($model->{$attribute} == $value) {
                return $model;
            }
        }

        return false;
    }

    /**
     * Get a clean tree of parent > child models by removing models
     * from the original collection that exists as children of other models
     *
     * @param  [type] $items        The children collection of another model
     * @param  string $children The name of the children attribute. Defaults to "children"
     *
     * @return array                The cleaned array of models
     */
    function tree($items = null, $children = 'children')
    {
        $items = !is_null($items) ? $items : $this->items;

        foreach ($items as $item) {
            // The first items are an array of models,
            // so we won't remove any models on our first loop
            // If the items are a collection the are most likely the children,
            // so remove those from the original collection so that
            // we don't end up with duplicates
            if ($items instanceof Collection) {
                foreach ($this->items as $key => $model) {
                    if ($model->getKey() == $item->getKey()) {
                        $this->forget($key);
                    }
                }
            }

            if (!$item->{$children}->isEmpty()) {
                $this->tree($item->{$children});
            }
        }

        return $this->items;
    }

    /**
     * Delete each
     *
     * @return void
     */
    public function delete()
    {
        $this->each(
            function ($model) {
                $model->delete();
            }
        );
    }

    /**
     * Save each
     *
     * @return void
     */
    public function save()
    {
        $this->each(
            function ($model) {
                $model->save();
            }
        );
    }
}