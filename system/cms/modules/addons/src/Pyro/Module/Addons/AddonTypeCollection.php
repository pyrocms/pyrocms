<?php namespace Pyro\Module\Addons;

use Pyro\Model\EloquentCollection;

class AddonTypeCollection extends EloquentCollection
{
	/**
	 * By slug
	 * @var array
	 */
	protected $by_slug = null;

	///////////////////////////////////////////////////////////////////////////////
	// -------------------------	  METHODS 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////////

	/**
	 * Construct
	 * @param array $types
	 */
	public function  __construct($types = array())
	{
		parent::__construct($types);
		
		foreach ($types as $type)
		{
			// Index by slug
			if (isset($type->slug))
				$this->by_slug[$type->slug] = $type;
		}
	}

	/**
	 * Find type by slug
	 * @param  string $slug
	 * @return object
	 */
	public function findBySlug($slug = null)
	{
		return isset($this->by_slug[$slug]) ? $this->by_slug[$slug] : null;
	}

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
