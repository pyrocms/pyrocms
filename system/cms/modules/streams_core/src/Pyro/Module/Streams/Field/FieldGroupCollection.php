<?php namespace Pyro\Module\Streams\Field;

use Illuminate\Support\Collection;

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
    public function distribute()
    {
        $availableFields = $this->fieldCollection->getAssociativeFieldSlugs();

        foreach ($this->items as $fieldGroup) {
            if (!empty($fieldGroup['fields']) and is_array($fieldGroup['fields'])) {
                $fieldGroup['title'] = !empty($fieldGroup['title']) ? lang($fieldGroup['title']) : null;
                foreach ($fieldGroup['fields'] as $slug) {
                    unset($availableFields[$slug]);
                }
            }
        }

        foreach ($this->items as &$fieldGroup) {
            if (!empty($fieldGroup['fields']) and $fieldGroup['fields'] === '*') {
                $fieldGroup['fields'] = $availableFields;
            }

            isset($fieldGroup['fields']) or $fieldGroup['fields'] = array();
        }

        return $this;
    }
}
