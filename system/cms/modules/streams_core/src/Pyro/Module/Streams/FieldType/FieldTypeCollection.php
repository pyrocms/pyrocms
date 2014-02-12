<?php namespace Pyro\Module\Streams\FieldType;

use Illuminate\Support\Collection;

class FieldTypeCollection extends Collection
{

    /**
     * Test if includes
     *
     * @param  array $include
     *
     * @return boolean
     */
    public function includes($include = array())
    {
        $this->filter(
            function ($type) use ($include) {
                return in_array($type->field_type_slug, $include);
            }
        );
    }

    /**
     * Test if excludes
     *
     * @param  array $exclude
     *
     * @return boolean
     */
    public function excludes($exclude = array())
    {
        $this->filter(
            function ($type) use ($exclude) {
                return !in_array($type->field_type_slug, $exclude);
            }
        );
    }

    /**
     * Get options for field type
     *
     * @return array
     */
    public function getOptions()
    {
        $options = array();

        foreach ($this->items as $type) {
            $options[$type->field_type_slug] = lang('streams:' . $type->field_type_slug . '.name');
        }

        asort($options);

        return $options;
    }
}
