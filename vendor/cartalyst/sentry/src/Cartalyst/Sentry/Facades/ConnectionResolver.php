<?php namespace Cartalyst\Sentry\Facades;
/**
 * Part of the Sentry package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Connection;
use PDO;

class ConnectionResolver implements ConnectionResolverInterface {

	/**
	 * The PDO instance.
	 *
	 * @var PDO
	 */
	protected $pdo;

	/**
	 * The PDO driver name.
	 *
	 * @var string
	 */
	protected $driver;

	/**
	 * The table prefix.
	 *
	 * @var string
	 */
	protected $tablePrefix = '';

	/**
	 * The default connection name.
	 *
	 * @var string
	 */
	protected $defaultConnection;

	/**
	 * The database connection.
	 *
	 * @var \Illuminate\Database\Connection
	 */
	protected $connection;

	/**
	 * Create a new connection resolver.
	 *
	 * @param  \PDO $pdo
	 * @param  string $driverName
	 * @param  string $tablePrefix
	 * @return void
	 */
	public function __construct(PDO $pdo, $driverName, $tablePrefix = '')
	{
		$this->pdo         = $pdo;
		$this->driverName  = $driverName;
		$this->tablePrefix = $tablePrefix;
	}

	/**
	 * Get a database connection instance.
	 *
	 * @param  string  $name
	 * @return \Illuminate\Database\Connection
	 */
	public function connection($name = null)
	{
		return $this->getConnection();
	}

	/**
	 * Get the default connection name.
	 *
	 * @return string
	 */
	public function getDefaultConnection()
	{
		return $this->getConnection();
	}

	/**
	 * Set the default connection name.
	 *
	 * @param  string  $name
	 * @return void
	 */
	public function setDefaultConnection($name)
	{
		$this->defaultConnection = $name;
	}

	/**
	 * Returns the database connection.
	 *
	 * @return \Illuminate\Database\Connection
	 * @throws \InvalidArgumentException
	 */
	public function getConnection()
	{
		if ($this->connection === null)
		{
			$this->connection = new Connection($this->pdo, '', $this->tablePrefix);

			// We will now provide the query grammar to the connection.
			switch ($this->driverName)
			{
				case 'mysql':
					$queryGrammar = 'Illuminate\Database\Query\Grammars\MySqlGrammar';
					break;

				case 'pgsql':
					$queryGrammar = 'Illuminate\Database\Query\Grammars\PostgresGrammar';
					break;

				case 'sqlsrv':
					$queryGrammar = 'Illuminate\Database\Query\Grammars\SqlServerGrammar';
					break;

				case 'sqlite':
					$queryGrammar = 'Illuminate\Database\Query\Grammars\SQLiteGrammar';
					break;

				default:
					throw new \InvalidArgumentException("Cannot determine grammar to use based on {$this->driverName}.");
					break;
			}

			$this->connection->setQueryGrammar(new $queryGrammar);
		}

		return $this->connection;
	}

}
