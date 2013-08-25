<?php namespace Pyro\Module\Streams_core\Core\Model\Collection;

class FieldTypeCollection extends \Illuminate\Support\Collection
{
	public function getOptions()
	{
		$options = array();

		foreach ($this->items as $slug => $type)
		{
			$options[$slug] = lang('streams:'.$type->field_type_slug.'.name');
		}

		return $options;
	}
}