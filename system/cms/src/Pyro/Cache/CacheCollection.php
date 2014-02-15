<?php namespace Pyro\Cache;

use Illuminate\Support\Collection;

class CacheCollection extends Collection
{
	protected $collectionKey;

	/**
	 * Construct
	 * @param array  $items
	 * @param string $key
	 */
	public function __construct(array $items, string $key = null)
	{
		$this->items = $items;

		$this->collectionKey = $key;
	}

	public function setKey($key = null)
	{
		$this->collectionKey = $key;

		return $this;
	}

	public function unique()
	{
		$this->items = array_unique($this->items);

		$this->values();
		
		return $this;
	}

	public function addKeys(array $keys = array())
	{
		foreach ($keys as $key) {
			$this->push($key);
		}

		$this->unique();

		return $this;
	}

	public function index()
	{	
		if ($keys = ci()->cache->get($this->collectionKey)) {
			$this->addKeys($keys);
		}

		$this->unique();

		ci()->cache->forget($this->collectionKey);

		$self = $this;

		ci()->cache->rememberForever($this->collectionKey, function() use ($self) {
			return $self->all();
		});

		return $this;
	}

	public function flush()
	{
		foreach ($this->items as $key) {
			ci()->cache->forget($key);
		}

		ci()->cache->forget($this->collectionKey);

		$this->items = array();

		return $this;
	}
}
