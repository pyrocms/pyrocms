<?php namespace Pyro\Module\Streams_core;

use Illuminate\Support\Collection;

class EntryViewOptionCollection extends Collection
{
	protected $fields;

	public function __construct(array $viewOptions = array(), $fields = array())
	{
		foreach ($viewOptions as &$viewOption) {
			$viewOption->fields(FieldCollection::make($fields));
		}

		parent::__construct($viewOptions);
	}

    /**
     * Get view options field names
     * @return array
     */
    public function getFieldNames()
    {
        $labels = array();

        foreach ($this->items as $key => $viewOption) {
            $labels[$viewOption->get('field_slug')] = $viewOption->getFieldName();
        }

        return $labels;
    }

    /**
     * Get view options field names
     * @return array
     */
    public function getFieldSlugs()
    {
        $fieldSlugs = array();

        foreach ($this->items as $viewOption) {
            $fieldSlugs[] = $viewOption->get('field_slug');
        }

        return $fieldSlugs;
    }
}