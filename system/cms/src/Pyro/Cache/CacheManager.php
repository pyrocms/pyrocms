<?php namespace Pyro\Cache;

use Illuminate\Cache\CacheManager as IlluminateCacheManager;
use Illuminate\Cache\ApcStore;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\FileStore;
use Illuminate\Cache\MemcachedStore;
use Illuminate\Cache\WincacheStore;
use Illuminate\Cache\XCacheStore;
use Illuminate\Cache\RedisStore;
use Illuminate\Cache\DatabaseStore;
use Illuminate\Filesystem\Filesystem;

class CacheManager extends IlluminateCacheManager
{
	/**
	 * Create an instance of the APC cache driver.
	 *
	 * @return \Illuminate\Cache\ApcStore
	 */
	protected function createApcDriver()
	{
		return $this->repository(new ApcStore(new ApcWrapper, $this->getPrefix()));
	}

	/**
	 * Create an instance of the array cache driver.
	 *
	 * @return \Illuminate\Cache\ArrayStore
	 */
	protected function createArrayDriver()
	{
		return $this->repository(new ArrayStore);
	}

	/**
	 * Create an instance of the file cache driver.
	 *
	 * @return \Illuminate\Cache\FileStore
	 */
	protected function createFileDriver()
	{
		$path = $this->app['config']['cache.path'];

		return $this->repository(new FileStore(new Filesystem, $path));
	}

	/**
	 * Create an instance of the Memcached cache driver.
	 *
	 * @return \Illuminate\Cache\MemcachedStore
	 */
	protected function createMemcachedDriver()
	{
		$servers = $this->app['config']['cache.memcached'];

		$memcached = $this->app['memcached.connector']->connect($servers);

		return $this->repository(new MemcachedStore($memcached, $this->getPrefix()));
	}

	/**
	 * Create an instance of the WinCache cache driver.
	 *
	 * @return \Illuminate\Cache\WinCacheStore
	 */
	protected function createWincacheDriver()
	{
		return $this->repository(new WinCacheStore($this->getPrefix()));
	}

	/**
	 * Create an instance of the XCache cache driver.
	 *
	 * @return \Illuminate\Cache\WinCacheStore
	 */
	protected function createXcacheDriver()
	{
		return $this->repository(new XCacheStore($this->getPrefix()));
	}

	/**
	 * Create an instance of the Redis cache driver.
	 *
	 * @return \Illuminate\Cache\RedisStore
	 */
	protected function createRedisDriver()
	{
		$redis = $this->app['config']['redis'];

		return $this->repository(new RedisStore($redis, $this->getPrefix()));
	}

	/**
	 * Create an instance of the database cache driver.
	 *
	 * @return \Illuminate\Cache\DatabaseStore
	 */
	protected function createDatabaseDriver()
	{
		$connection = $this->getDatabaseConnection();

		$encrypter = $this->app['encrypter'];

		// We allow the developer to specify which connection and table should be used
		// to store the cached items. We also need to grab a prefix in case a table
		// is being used by multiple applications although this is very unlikely.
		$table = $this->app['config']['cache.table'];

		$prefix = $this->getPrefix();

		return $this->repository(new DatabaseStore($connection, $encrypter, $table, $prefix));
	}

	/**
	 * Get the database connection for the database driver.
	 *
	 * @return \Illuminate\Database\Connection
	 */
	protected function getDatabaseConnection()
	{
		$connection = $this->app['config']['cache.connection'];

		return $this->app['db']->connection($connection);
	}

	/**
	 * Get the cache "prefix" value.
	 *
	 * @return string
	 */
	public function getPrefix()
	{
		return $this->app['config']['cache.prefix'];
	}

	/**
	 * Get the default cache driver name.
	 *
	 * @return string
	 */
	protected function getDefaultDriver()
	{
		return $this->app['config']['cache.driver'];
	}
}