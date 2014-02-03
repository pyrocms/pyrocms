<?php namespace Pyro\Module\Streams_core;

use Illuminate\Support\Collection;
use Pyro\Support\Fluent;

class FieldGroupCollection extends Collection
{
    protected $fieldCollection;

    public function __construct(array $fieldGroups, FieldCollection $fieldCollection)
    {
        $this->items = $fieldGroups;
        
        $this->fieldCollection = $fieldCollection;
    }

    /**
     * Distribute fields across field groups
     *
     * @return array
     */
    protected function distribute()
    {
        $availableFields = $this->fieldCollection->getAssociativeFieldSlugs();

        foreach ($this->items as $fieldGroup) {
            if (! empty($fieldGroup['fields']) and is_array($fieldGroup['fields'])) {
                foreach ($fieldGroup['fields'] as $slug) {
                    unset($availableFields[$slug]);
                }
            }
        }

        foreach ($this->items as &$fieldGroup) {
            if (! empty($fieldGroup['fields']) and $fieldGroup['fields'] === '*') {
                $fieldGroup['fields'] = $availableFields;
            }

            is_array($fieldGroup['fields']) or $fieldGroup['fields'] = array();
        }

        return $this;
    }
}