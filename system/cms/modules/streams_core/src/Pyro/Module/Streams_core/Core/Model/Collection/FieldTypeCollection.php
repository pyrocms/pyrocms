<?php namespace Pyro\Module\Streams_core\Core\Model\Collection;

class FieldTypeCollection extends \Illuminate\Support\Collection
{

	public function includes($include = array())
	{
		$this->filter(function($type) use ($include) {
			return in_array($type->field_type_slug, $include);
		});
	}

	public function excludes($exclude = array())
	{
		$this->filter(function($type) use ($exclude) {
			return ! in_array($type->field_type_slug, $exclude);
		});
	}

	public function getOptions()
	{
		$options = array();

		foreach ($this->items as $type)
		{
			$options[$type->field_type_slug] = lang('streams:'.$type->field_type_slug.'.name');
		}

		asort($options);

		return $options;
	}
}