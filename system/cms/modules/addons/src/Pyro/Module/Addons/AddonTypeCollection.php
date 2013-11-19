<?php namespace Pyro\Module\Addons;

use Pyro\Model\EloquentCollection;

class AddonTypeCollection extends EloquentCollection
{

	/**
	 * Test if includes
	 * @param  array  $include
	 * @return boolean
	 */
	public function includes($include = array())
	{
		$this->filter(function($type) use ($include) {
			return in_array($type->type_slug, $include);
		});
	}

	/**
	 * Test if excludes
	 * @param  array  $exclude
	 * @return boolean
	 */
	public function excludes($exclude = array())
	{
		$this->filter(function($type) use ($exclude) {
			return ! in_array($type->type_slug, $exclude);
		});
	}
}
