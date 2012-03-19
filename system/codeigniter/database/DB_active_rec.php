<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Active Record Class
 *
 * This is the platform-independent base Active Record implementation class.
 *
 * @package		CodeIgniter
 * @subpackage	Drivers
 * @category	Database
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class CI_DB_active_record extends CI_DB_driver {

	protected $return_delete_sql		= FALSE;
	protected $reset_delete_data		= FALSE;

	protected $ar_select			= array();
	protected $ar_distinct			= FALSE;
	protected $ar_from			= array();
	protected $ar_join			= array();
	protected $ar_where			= array();
	protected $ar_like			= array();
	protected $ar_groupby			= array();
	protected $ar_having			= array();
	protected $ar_keys			= array();
	protected $ar_limit			= FALSE;
	protected $ar_offset			= FALSE;
	protected $ar_order			= FALSE;
	protected $ar_orderby			= array();
	protected $ar_set			= array();
	protected $ar_wherein			= array();
	protected $ar_aliased_tables		= array();
	protected $ar_store_array		= array();
	protected $ar_where_group_started	= FALSE;
	protected $ar_where_group_count		= 0;

	// Active Record Caching variables
	protected $ar_caching				= FALSE;
	protected $ar_cache_exists			= array();
	protected $ar_cache_select			= array();
	protected $ar_cache_from			= array();
	protected $ar_cache_join			= array();
	protected $ar_cache_where			= array();
	protected $ar_cache_like			= array();
	protected $ar_cache_groupby			= array();
	protected $ar_cache_having			= array();
	protected $ar_cache_orderby			= array();
	protected $ar_cache_set				= array();

	protected $ar_no_escape 			= array();
	protected $ar_cache_no_escape			= array();

	/**
	 * Select
	 *
	 * Generates the SELECT portion of the query
	 *
	 * @param	string
	 * @return	object
	 */
	public function select($select = '*', $escape = NULL)
	{
		if (is_string($select))
		{
			$select = explode(',', $select);
		}

		foreach ($select as $val)
		{
			$val = trim($val);

			if ($val != '')
			{
				$this->ar_select[] = $val;
				$this->ar_no_escape[] = $escape;

				if ($this->ar_caching === TRUE)
				{
					$this->ar_cache_select[] = $val;
					$this->ar_cache_exists[] = 'select';
					$this->ar_cache_no_escape[] = $escape;
				}
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Select Max
	 *
	 * Generates a SELECT MAX(field) portion of a query
	 *
	 * @param	string	the field
	 * @param	string	an alias
	 * @return	object
	 */
	public function select_max($select = '', $alias = '')
	{
		return $this->_max_min_avg_sum($select, $alias, 'MAX');
	}

	// --------------------------------------------------------------------

	/**
	 * Select Min
	 *
	 * Generates a SELECT MIN(field) portion of a query
	 *
	 * @param	string	the field
	 * @param	string	an alias
	 * @return	object
	 */
	public function select_min($select = '', $alias = '')
	{
		return $this->_max_min_avg_sum($select, $alias, 'MIN');
	}

	// --------------------------------------------------------------------

	/**
	 * Select Average
	 *
	 * Generates a SELECT AVG(field) portion of a query
	 *
	 * @param	string	the field
	 * @param	string	an alias
	 * @return	object
	 */
	public function select_avg($select = '', $alias = '')
	{
		return $this->_max_min_avg_sum($select, $alias, 'AVG');
	}

	// --------------------------------------------------------------------

	/**
	 * Select Sum
	 *
	 * Generates a SELECT SUM(field) portion of a query
	 *
	 * @param	string	the field
	 * @param	string	an alias
	 * @return	object
	 */
	public function select_sum($select = '', $alias = '')
	{
		return $this->_max_min_avg_sum($select, $alias, 'SUM');
	}

	// --------------------------------------------------------------------

	/**
	 * Processing Function for the four functions above:
	 *
	 *	select_max()
	 *	select_min()
	 *	select_avg()
	 *	select_sum()
	 *
	 * @param	string	the field
	 * @param	string	an alias
	 * @return	object
	 */
	protected function _max_min_avg_sum($select = '', $alias = '', $type = 'MAX')
	{
		if ( ! is_string($select) OR $select == '')
		{
			$this->display_error('db_invalid_query');
		}

		$type = strtoupper($type);

		if ( ! in_array($type, array('MAX', 'MIN', 'AVG', 'SUM')))
		{
			show_error('Invalid function type: '.$type);
		}

		if ($alias == '')
		{
			$alias = $this->_create_alias_from_table(trim($select));
		}

		$sql = $this->protect_identifiers($type.'('.trim($select).')').' AS '.$this->protect_identifiers(trim($alias));
		$this->ar_select[] = $sql;
		$this->ar_no_escape[] = NULL;

		if ($this->ar_caching === TRUE)
		{
			$this->ar_cache_select[] = $sql;
			$this->ar_cache_exists[] = 'select';
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Determines the alias name based on the table
	 *
	 * @param	string
	 * @return	string
	 */
	protected function _create_alias_from_table($item)
	{
		if (strpos($item, '.') !== FALSE)
		{
			$item = explode('.', $item);
			return end($item);
		}

		return $item;
	}

	// --------------------------------------------------------------------

	/**
	 * DISTINCT
	 *
	 * Sets a flag which tells the query string compiler to add DISTINCT
	 *
	 * @param	bool
	 * @return	object
	 */
	public function distinct($val = TRUE)
	{
		$this->ar_distinct = (is_bool($val)) ? $val : TRUE;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * From
	 *
	 * Generates the FROM portion of the query
	 *
	 * @param	mixed	can be a string or array
	 * @return	object
	 */
	public function from($from)
	{
		foreach ((array)$from as $val)
		{
			if (strpos($val, ',') !== FALSE)
			{
				foreach (explode(',', $val) as $v)
				{
					$v = trim($v);
					$this->_track_aliases($v);
					$v = $this->ar_from[] = $this->protect_identifiers($v, TRUE, NULL, FALSE);

					if ($this->ar_caching === TRUE)
					{
						$this->ar_cache_from[] = $v;
						$this->ar_cache_exists[] = 'from';
					}
				}
			}
			else
			{
				$val = trim($val);

				// Extract any aliases that might exist. We use this information
				// in the _protect_identifiers to know whether to add a table prefix
				$this->_track_aliases($val);
				$this->ar_from[] = $val = $this->protect_identifiers($val, TRUE, NULL, FALSE);

				if ($this->ar_caching === TRUE)
				{
					$this->ar_cache_from[] = $val;
					$this->ar_cache_exists[] = 'from';
				}
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Join
	 *
	 * Generates the JOIN portion of the query
	 *
	 * @param	string
	 * @param	string	the join condition
	 * @param	string	the type of join
	 * @return	object
	 */
	public function join($table, $cond, $type = '')
	{
		if ($type != '')
		{
			$type = strtoupper(trim($type));

			if ( ! in_array($type, array('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER')))
			{
				$type = '';
			}
			else
			{
				$type .= ' ';
			}
		}

		// Extract any aliases that might exist. We use this information
		// in the _protect_identifiers to know whether to add a table prefix
		$this->_track_aliases($table);

		// Strip apart the condition and protect the identifiers
		if (preg_match('/([\[\w\.]+)([\W\s]+)(.+)/', $cond, $match))
		{
			$cond = $this->protect_identifiers($match[1]).$match[2].$this->protect_identifiers($match[3]);
		}

		// Assemble the JOIN statement
		$this->ar_join[] = $join = $type.'JOIN '.$this->protect_identifiers($table, TRUE, NULL, FALSE).' ON '.$cond;

		if ($this->ar_caching === TRUE)
		{
			$this->ar_cache_join[] = $join;
			$this->ar_cache_exists[] = 'join';
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Where
	 *
	 * Generates the WHERE portion of the query. Separates
	 * multiple calls with AND
	 *
	 * @param	mixed
	 * @param	mixed
	 * @return	object
	 */
	public function where($key, $value = NULL, $escape = TRUE)
	{
		return $this->_where($key, $value, 'AND ', $escape);
	}

	// --------------------------------------------------------------------

	/**
	 * OR Where
	 *
	 * Generates the WHERE portion of the query. Separates
	 * multiple calls with OR
	 *
	 * @param	mixed
	 * @param	mixed
	 * @return	object
	 */
	public function or_where($key, $value = NULL, $escape = TRUE)
	{
		return $this->_where($key, $value, 'OR ', $escape);
	}

	// --------------------------------------------------------------------

	/**
	 * Where
	 *
	 * Called by where() or or_where()
	 *
	 * @param	mixed
	 * @param	mixed
	 * @param	string
	 * @return	object
	 */
	protected function _where($key, $value = NULL, $type = 'AND ', $escape = NULL)
	{
		$type = $this->_group_get_type($type);

		if ( ! is_array($key))
		{
			$key = array($key => $value);
		}

		// If the escape value was not set will will base it on the global setting
		if ( ! is_bool($escape))
		{
			$escape = $this->_protect_identifiers;
		}

		foreach ($key as $k => $v)
		{
			$prefix = (count($this->ar_where) === 0 AND count($this->ar_cache_where) === 0) ? '' : $type;

			if (is_null($v) && ! $this->_has_operator($k))
			{
				// value appears not to have been set, assign the test to IS NULL
				$k .= ' IS NULL';
			}

			if ( ! is_null($v))
			{
				if ($escape === TRUE)
				{
					$k = $this->protect_identifiers($k, FALSE, $escape);
					$v = ' '.$this->escape($v);
				}

				if ( ! $this->_has_operator($k))
				{
					$k .= ' = ';
				}
			}
			else
			{
				$k = $this->protect_identifiers($k, FALSE, $escape);
			}

			$this->ar_where[] = $prefix.$k.$v;
			if ($this->ar_caching === TRUE)
			{
				$this->ar_cache_where[] = $prefix.$k.$v;
				$this->ar_cache_exists[] = 'where';
			}

		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Where_in
	 *
	 * Generates a WHERE field IN ('item', 'item') SQL query joined with
	 * AND if appropriate
	 *
	 * @param	string	The field to search
	 * @param	array	The values searched on
	 * @return	object
	 */
	public function where_in($key = NULL, $values = NULL)
	{
		return $this->_where_in($key, $values);
	}

	// --------------------------------------------------------------------

	/**
	 * Where_in_or
	 *
	 * Generates a WHERE field IN ('item', 'item') SQL query joined with
	 * OR if appropriate
	 *
	 * @param	string	The field to search
	 * @param	array	The values searched on
	 * @return	object
	 */
	public function or_where_in($key = NULL, $values = NULL)
	{
		return $this->_where_in($key, $values, FALSE, 'OR ');
	}

	// --------------------------------------------------------------------

	/**
	 * Where_not_in
	 *
	 * Generates a WHERE field NOT IN ('item', 'item') SQL query joined
	 * with AND if appropriate
	 *
	 * @param	string	The field to search
	 * @param	array	The values searched on
	 * @return	object
	 */
	public function where_not_in($key = NULL, $values = NULL)
	{
		return $this->_where_in($key, $values, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Where_not_in_or
	 *
	 * Generates a WHERE field NOT IN ('item', 'item') SQL query joined
	 * with OR if appropriate
	 *
	 * @param	string	The field to search
	 * @param	array	The values searched on
	 * @return	object
	 */
	public function or_where_not_in($key = NULL, $values = NULL)
	{
		return $this->_where_in($key, $values, TRUE, 'OR ');
	}

	// --------------------------------------------------------------------

	/**
	 * Where_in
	 *
	 * Called by where_in, where_in_or, where_not_in, where_not_in_or
	 *
	 * @param	string	The field to search
	 * @param	array	The values searched on
	 * @param	boolean	If the statement would be IN or NOT IN
	 * @param	string
	 * @return	object
	 */
	protected function _where_in($key = NULL, $values = NULL, $not = FALSE, $type = 'AND ')
	{
		if ($key === NULL OR $values === NULL)
		{
			return;
		}

		$type = $this->_group_get_type($type);

		if ( ! is_array($values))
		{
			$values = array($values);
		}

		$not = ($not) ? ' NOT' : '';

		foreach ($values as $value)
		{
			$this->ar_wherein[] = $this->escape($value);
		}

		$prefix = (count($this->ar_where) === 0) ? '' : $type;
		$this->ar_where[] = $where_in = $prefix.$this->protect_identifiers($key).$not.' IN ('.implode(', ', $this->ar_wherein).') ';

		if ($this->ar_caching === TRUE)
		{
			$this->ar_cache_where[] = $where_in;
			$this->ar_cache_exists[] = 'where';
		}

		// reset the array for multiple calls
		$this->ar_wherein = array();
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Like
	 *
	 * Generates a %LIKE% portion of the query. Separates
	 * multiple calls with AND
	 *
	 * @param	mixed
	 * @param	mixed
	 * @return	object
	 */
	public function like($field, $match = '', $side = 'both')
	{
		return $this->_like($field, $match, 'AND ', $side);
	}

	// --------------------------------------------------------------------

	/**
	 * Not Like
	 *
	 * Generates a NOT LIKE portion of the query. Separates
	 * multiple calls with AND
	 *
	 * @param	mixed
	 * @param	mixed
	 * @return	object
	 */
	public function not_like($field, $match = '', $side = 'both')
	{
		return $this->_like($field, $match, 'AND ', $side, 'NOT');
	}

	// --------------------------------------------------------------------

	/**
	 * OR Like
	 *
	 * Generates a %LIKE% portion of the query. Separates
	 * multiple calls with OR
	 *
	 * @param	mixed
	 * @param	mixed
	 * @return	object
	 */
	public function or_like($field, $match = '', $side = 'both')
	{
		return $this->_like($field, $match, 'OR ', $side);
	}

	// --------------------------------------------------------------------

	/**
	 * OR Not Like
	 *
	 * Generates a NOT LIKE portion of the query. Separates
	 * multiple calls with OR
	 *
	 * @param	mixed
	 * @param	mixed
	 * @return	object
	 */
	public function or_not_like($field, $match = '', $side = 'both')
	{
		return $this->_like($field, $match, 'OR ', $side, 'NOT');
	}

	// --------------------------------------------------------------------

	/**
	 * Like
	 *
	 * Called by like() or orlike()
	 *
	 * @param	mixed
	 * @param	mixed
	 * @param	string
	 * @return	object
	 */
	protected function _like($field, $match = '', $type = 'AND ', $side = 'both', $not = '')
	{
		$type = $this->_group_get_type($type);

		if ( ! is_array($field))
		{
			$field = array($field => $match);
		}

		foreach ($field as $k => $v)
		{
			$k = $this->protect_identifiers($k);
			$prefix = (count($this->ar_like) === 0) ? '' : $type;
			$v = $this->escape_like_str($v);

			if ($side === 'none')
			{
				$like_statement = $prefix." $k $not LIKE '{$v}'";
			}
			elseif ($side === 'before')
			{
				$like_statement = $prefix." $k $not LIKE '%{$v}'";
			}
			elseif ($side === 'after')
			{
				$like_statement = $prefix." $k $not LIKE '{$v}%'";
			}
			else
			{
				$like_statement = $prefix." $k $not LIKE '%{$v}%'";
			}

			// some platforms require an escape sequence definition for LIKE wildcards
			if ($this->_like_escape_str != '')
			{
				$like_statement = $like_statement.sprintf($this->_like_escape_str, $this->_like_escape_chr);
			}

			$this->ar_like[] = $like_statement;
			if ($this->ar_caching === TRUE)
			{
				$this->ar_cache_like[] = $like_statement;
				$this->ar_cache_exists[] = 'like';
			}

		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Starts a query group.
	 *
	 * @param	string (Internal use only)
	 * @param	string (Internal use only)
	 * @return	object
	 */
	public function group_start($not = '', $type = 'AND ')
	{
		$type = $this->_group_get_type($type);
		$this->ar_where_group_started = TRUE;
		$prefix = (count($this->ar_where) === 0 AND count($this->ar_cache_where) === 0) ? '' : $type;
		$this->ar_where[] = $value = $prefix.$not.str_repeat(' ', ++$this->ar_where_group_count).' (';

		if ($this->ar_caching)
		{
			$this->ar_cache_where[] = $value;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Starts a query group, but ORs the group
	 *
	 * @return	object
	 */
	public function or_group_start()
	{
		return $this->group_start('', 'OR ');
	}

	// --------------------------------------------------------------------

	/**
	 * Starts a query group, but NOTs the group
	 *
	 * @return	object
	 */
	public function not_group_start()
	{
		return $this->group_start('NOT ', 'AND ');
	}

	// --------------------------------------------------------------------

	/**
	 * Starts a query group, but OR NOTs the group
	 *
	 * @return	object
	 */
	public function or_not_group_start()
	{
		return $this->group_start('NOT ', 'OR ');
	}

	// --------------------------------------------------------------------

	/**
	 * Ends a query group
	 *
	 * @return	object
	 */
	public function group_end()
	{
		$this->ar_where_group_started = FALSE;
		$this->ar_where[] = $value = str_repeat(' ', $this->ar_where_group_count--) . ')';

		if ($this->ar_caching)
		{
			$this->ar_cache_where[] = $value;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Group_get_type
	 *
	 * Called by group_start(), _like(), _where() and _where_in()
	 *
	 * @param	string
	 * @return	string
	 */
	protected function _group_get_type($type)
	{
		if ($this->ar_where_group_started)
		{
			$type = '';
			$this->ar_where_group_started = FALSE;
		}

		return $type;
	}

	// --------------------------------------------------------------------

	/**
	 * GROUP BY
	 *
	 * @param	string
	 * @return	object
	 */
	public function group_by($by)
	{
		if (is_string($by))
		{
			$by = explode(',', $by);
		}

		foreach ($by as $val)
		{
			$val = trim($val);

			if ($val != '')
			{
				$this->ar_groupby[] = $val = $this->protect_identifiers($val);

				if ($this->ar_caching === TRUE)
				{
					$this->ar_cache_groupby[] = $val;
					$this->ar_cache_exists[] = 'groupby';
				}
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Sets the HAVING value
	 *
	 * Separates multiple calls with AND
	 *
	 * @param	string
	 * @param	string
	 * @return	object
	 */
	public function having($key, $value = '', $escape = TRUE)
	{
		return $this->_having($key, $value, 'AND ', $escape);
	}

	// --------------------------------------------------------------------

	/**
	 * Sets the OR HAVING value
	 *
	 * Separates multiple calls with OR
	 *
	 * @param	string
	 * @param	string
	 * @return	object
	 */
	public function or_having($key, $value = '', $escape = TRUE)
	{
		return $this->_having($key, $value, 'OR ', $escape);
	}

	// --------------------------------------------------------------------

	/**
	 * Sets the HAVING values
	 *
	 * Called by having() or or_having()
	 *
	 * @param	string
	 * @param	string
	 * @return	object
	 */
	protected function _having($key, $value = '', $type = 'AND ', $escape = TRUE)
	{
		if ( ! is_array($key))
		{
			$key = array($key => $value);
		}

		foreach ($key as $k => $v)
		{
			$prefix = (count($this->ar_having) === 0) ? '' : $type;

			if ($escape === TRUE)
			{
				$k = $this->protect_identifiers($k);
			}

			if ( ! $this->_has_operator($k))
			{
				$k .= ' = ';
			}

			if ($v != '')
			{
				$v = ' '.$this->escape($v);
			}

			$this->ar_having[] = $prefix.$k.$v;
			if ($this->ar_caching === TRUE)
			{
				$this->ar_cache_having[] = $prefix.$k.$v;
				$this->ar_cache_exists[] = 'having';
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Sets the ORDER BY value
	 *
	 * @param	string
	 * @param	string	direction: asc or desc
	 * @param	bool	enable field name escaping
	 * @return	object
	 */
	public function order_by($orderby, $direction = '', $escape = TRUE)
	{
		if (strtolower($direction) === 'random')
		{
			$orderby = ''; // Random results want or don't need a field name
			$direction = $this->_random_keyword;
		}
		elseif (trim($direction) != '')
		{
			$direction = (in_array(strtoupper(trim($direction)), array('ASC', 'DESC'), TRUE)) ? ' '.$direction : ' ASC';
		}


		if ((strpos($orderby, ',') !== FALSE) && $escape === TRUE)
		{
			$temp = array();
			foreach (explode(',', $orderby) as $part)
			{
				$part = trim($part);
				if ( ! in_array($part, $this->ar_aliased_tables))
				{
					$part = $this->protect_identifiers(trim($part));
				}

				$temp[] = $part;
			}

			$orderby = implode(', ', $temp);
		}
		elseif ($direction != $this->_random_keyword)
		{
			if ($escape === TRUE)
			{
				$orderby = $this->protect_identifiers($orderby);
			}
		}

		$this->ar_orderby[] = $orderby_statement = $orderby.$direction;

		if ($this->ar_caching === TRUE)
		{
			$this->ar_cache_orderby[] = $orderby_statement;
			$this->ar_cache_exists[] = 'orderby';
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Sets the LIMIT value
	 *
	 * @param	integer	the limit value
	 * @param	integer	the offset value
	 * @return	object
	 */
	public function limit($value, $offset = NULL)
	{
		$this->ar_limit = (int) $value;

		if ( ! is_null($offset))
		{
			$this->ar_offset = (int) $offset;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Sets the OFFSET value
	 *
	 * @param	integer	the offset value
	 * @return	object
	 */
	public function offset($offset)
	{
		$this->ar_offset = (int) $offset;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * The "set" function.  Allows key/value pairs to be set for inserting or updating
	 *
	 * @param	mixed
	 * @param	string
	 * @param	boolean
	 * @return	object
	 */
	public function set($key, $value = '', $escape = TRUE)
	{
		$key = $this->_object_to_array($key);

		if ( ! is_array($key))
		{
			$key = array($key => $value);
		}

		foreach ($key as $k => $v)
		{
			if ($escape === FALSE)
			{
				$this->ar_set[$this->protect_identifiers($k)] = $v;
			}
			else
			{
				$this->ar_set[$this->protect_identifiers($k, FALSE, TRUE)] = $this->escape($v);
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Get SELECT query string
	 *
	 * Compiles a SELECT query string and returns the sql.
	 *
	 * @access	public
	 * @param	string	the table name to select from (optional)
	 * @param	boolean	TRUE: resets AR values; FALSE: leave AR vaules alone
	 * @return	string
	 */
	public function get_compiled_select($table = '', $reset = TRUE)
	{
		if ($table != '')
		{
			$this->_track_aliases($table);
			$this->from($table);
		}

		$select =  $this->_compile_select();

		if ($reset === TRUE)
		{
			$this->_reset_select();
		}

		return $select;
	}

	// --------------------------------------------------------------------

	/**
	 * Get
	 *
	 * Compiles the select statement based on the other functions called
	 * and runs the query
	 *
	 * @param	string	the table
	 * @param	string	the limit clause
	 * @param	string	the offset clause
	 * @return	object
	 */
	public function get($table = '', $limit = null, $offset = null)
	{
		if ($table != '')
		{
			$this->_track_aliases($table);
			$this->from($table);
		}

		if ( ! is_null($limit))
		{
			$this->limit($limit, $offset);
		}

		$result = $this->query($this->_compile_select());
		$this->_reset_select();
		return $result;
	}

	/**
	 * "Count All Results" query
	 *
	 * Generates a platform-specific query string that counts all records
	 * returned by an Active Record query.
	 *
	 * @param	string
	 * @return	string
	 */
	public function count_all_results($table = '')
	{
		if ($table != '')
		{
			$this->_track_aliases($table);
			$this->from($table);
		}

		$result = $this->query($this->_compile_select($this->_count_string.$this->protect_identifiers('numrows')));
		$this->_reset_select();

		if ($result->num_rows() === 0)
		{
			return 0;
		}

		$row = $result->row();
		return (int) $row->numrows;
	}
	// --------------------------------------------------------------------

	/**
	 * Get_Where
	 *
	 * Allows the where clause, limit and offset to be added directly
	 *
	 * @param	string	the where clause
	 * @param	string	the limit clause
	 * @param	string	the offset clause
	 * @return	object
	 */
	public function get_where($table = '', $where = null, $limit = null, $offset = null)
	{
		if ($table != '')
		{
			$this->from($table);
		}

		if ( ! is_null($where))
		{
			$this->where($where);
		}

		if ( ! is_null($limit))
		{
			$this->limit($limit, $offset);
		}

		$result = $this->query($this->_compile_select());
		$this->_reset_select();
		return $result;
	}

	// --------------------------------------------------------------------

	/**
	 * Insert_Batch
	 *
	 * Compiles batch insert strings and runs the queries
	 *
	 * @param	string	the table to retrieve the results from
	 * @param	array	an associative array of insert values
	 * @return	object
	 */
	public function insert_batch($table = '', $set = NULL)
	{
		if ( ! is_null($set))
		{
			$this->set_insert_batch($set);
		}

		if (count($this->ar_set) === 0)
		{
			if ($this->db_debug)
			{
				// No valid data array. Folds in cases where keys and values did not match up
				return $this->display_error('db_must_use_set');
			}
			return FALSE;
		}

		if ($table == '')
		{
			if ( ! isset($this->ar_from[0]))
			{
				return ($this->db_debug) ? $this->display_error('db_must_set_table') : FALSE;
			}

			$table = $this->ar_from[0];
		}

		// Batch this baby
		for ($i = 0, $total = count($this->ar_set); $i < $total; $i += 100)
		{
			$this->query($this->_insert_batch($this->protect_identifiers($table, TRUE, NULL, FALSE), $this->ar_keys, array_slice($this->ar_set, $i, 100)));
		}

		$this->_reset_write();
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * The "set_insert_batch" function.  Allows key/value pairs to be set for batch inserts
	 *
	 * @param	mixed
	 * @param	string
	 * @param	boolean
	 * @return	object
	 */
	public function set_insert_batch($key, $value = '', $escape = TRUE)
	{
		$key = $this->_object_to_array_batch($key);

		if ( ! is_array($key))
		{
			$key = array($key => $value);
		}

		$keys = array_keys(current($key));
		sort($keys);

		foreach ($key as $row)
		{
			if (count(array_diff($keys, array_keys($row))) > 0 OR count(array_diff(array_keys($row), $keys)) > 0)
			{
				// batch function above returns an error on an empty array
				$this->ar_set[] = array();
				return;
			}

			ksort($row); // puts $row in the same order as our keys

			if ($escape === FALSE)
			{
				$this->ar_set[] =  '('.implode(',', $row).')';
			}
			else
			{
				$clean = array();
				foreach ($row as $value)
				{
					$clean[] = $this->escape($value);
				}

				$this->ar_set[] =  '('.implode(',', $clean).')';
			}
		}

		foreach ($keys as $k)
		{
			$this->ar_keys[] = $this->protect_identifiers($k);
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Get INSERT query string
	 *
	 * Compiles an insert query and returns the sql
	 *
	 * @access	public
	 * @param	string	the table to insert into
	 * @param	boolean	TRUE: reset AR values; FALSE: leave AR values alone
	 * @return	string
	 */
	public function get_compiled_insert($table = '', $reset = TRUE)
	{
		if ($this->_validate_insert($table) === FALSE)
		{
			return FALSE;
		}

		$sql = $this->_insert(
			$this->protect_identifiers($this->ar_from[0], TRUE, NULL, FALSE),
			array_keys($this->ar_set),
			array_values($this->ar_set)
		);

		if ($reset === TRUE)
		{
			$this->_reset_write();
		}

		return $sql;
	}

	// --------------------------------------------------------------------

	/**
	 * Insert
	 *
	 * Compiles an insert string and runs the query
	 *
	 * @access	public
	 * @param	string	the table to insert data into
	 * @param	array	an associative array of insert values
	 * @return	object
	 */
	public function insert($table = '', $set = NULL)
	{
		if ( ! is_null($set))
		{
			$this->set($set);
		}

		if ($this->_validate_insert($table) === FALSE)
		{
			return FALSE;
		}

		$sql = $this->_insert(
			$this->protect_identifiers($this->ar_from[0], TRUE, NULL, FALSE),
			array_keys($this->ar_set),
			array_values($this->ar_set)
		);

		$this->_reset_write();
		return $this->query($sql);
	}

	// --------------------------------------------------------------------

	/**
	 * Validate Insert
	 *
	 * This method is used by both insert() and get_compiled_insert() to
	 * validate that the there data is actually being set and that table
	 * has been chosen to be inserted into.
	 *
	 * @access	public
	 * @param	string	the table to insert data into
	 * @return	string
	 */
	protected function _validate_insert($table = '')
	{
		if (count($this->ar_set) === 0)
		{
			return ($this->db_debug) ? $this->display_error('db_must_use_set') : FALSE;
		}

		if ($table == '')
		{
			if ( ! isset($this->ar_from[0]))
			{
				return ($this->db_debug) ? $this->display_error('db_must_set_table') : FALSE;
			}
		}
		else
		{
			$this->ar_from[0] = $table;
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Replace
	 *
	 * Compiles an replace into string and runs the query
	 *
	 * @param	string	the table to replace data into
	 * @param	array	an associative array of insert values
	 * @return	object
	 */
	public function replace($table = '', $set = NULL)
	{
		if ( ! is_null($set))
		{
			$this->set($set);
		}

		if (count($this->ar_set) === 0)
		{
			return ($this->db_debug) ? $this->display_error('db_must_use_set') : FALSE;
		}

		if ($table == '')
		{
			if ( ! isset($this->ar_from[0]))
			{
				return ($this->db_debug) ? $this->display_error('db_must_set_table') : FALSE;
			}

			$table = $this->ar_from[0];
		}

		$sql = $this->_replace($this->protect_identifiers($table, TRUE, NULL, FALSE), array_keys($this->ar_set), array_values($this->ar_set));
		$this->_reset_write();
		return $this->query($sql);
	}

	// --------------------------------------------------------------------

	/**
	 * Get UPDATE query string
	 *
	 * Compiles an update query and returns the sql
	 *
	 * @access	public
	 * @param	string	the table to update
	 * @param	boolean	TRUE: reset AR values; FALSE: leave AR values alone
	 * @return	string
	 */
	public function get_compiled_update($table = '', $reset = TRUE)
	{
		// Combine any cached components with the current statements
		$this->_merge_cache();

		if ($this->_validate_update($table) === FALSE)
		{
			return FALSE;
		}

		$sql = $this->_update($this->protect_identifiers($this->ar_from[0], TRUE, NULL, FALSE), $this->ar_set, $this->ar_where, $this->ar_orderby, $this->ar_limit);

		if ($reset === TRUE)
		{
			$this->_reset_write();
		}

		return $sql;
	}

	// --------------------------------------------------------------------

	/**
	 * Update
	 *
	 * Compiles an update string and runs the query
	 *
	 * @param	string	the table to retrieve the results from
	 * @param	array	an associative array of update values
	 * @param	mixed	the where clause
	 * @return	object
	 */
	public function update($table = '', $set = NULL, $where = NULL, $limit = NULL)
	{
		// Combine any cached components with the current statements
		$this->_merge_cache();

		if ( ! is_null($set))
		{
			$this->set($set);
		}

		if ($this->_validate_update($table) === FALSE)
		{
			return FALSE;
		}

		if ($where != NULL)
		{
			$this->where($where);
		}

		if ($limit != NULL)
		{
			$this->limit($limit);
		}

		$sql = $this->_update($this->protect_identifiers($this->ar_from[0], TRUE, NULL, FALSE), $this->ar_set, $this->ar_where, $this->ar_orderby, $this->ar_limit, $this->ar_like);
		$this->_reset_write();
		return $this->query($sql);
	}

	// --------------------------------------------------------------------

	/**
	 * Validate Update
	 *
	 * This method is used by both update() and get_compiled_update() to
	 * validate that data is actually being set and that a table has been
	 * chosen to be update.
	 *
	 * @access	public
	 * @param	string	the table to update data on
	 * @return	bool
	 */
	protected function _validate_update($table = '')
	{
		if (count($this->ar_set) == 0)
		{
			return ($this->db_debug) ? $this->display_error('db_must_use_set') : FALSE;
		}

		if ($table == '')
		{
			if ( ! isset($this->ar_from[0]))
			{
				return ($this->db_debug) ? $this->display_error('db_must_set_table') : FALSE;
			}
		}
		else
		{
			$this->ar_from[0] = $table;
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Update_Batch
	 *
	 * Compiles an update string and runs the query
	 *
	 * @param	string	the table to retrieve the results from
	 * @param	array	an associative array of update values
	 * @param	string	the where key
	 * @return	bool
	 */
	public function update_batch($table = '', $set = NULL, $index = NULL)
	{
		// Combine any cached components with the current statements
		$this->_merge_cache();

		if (is_null($index))
		{
			return ($this->db_debug) ? $this->display_error('db_must_use_index') : FALSE;
		}

		if ( ! is_null($set))
		{
			$this->set_update_batch($set, $index);
		}

		if (count($this->ar_set) === 0)
		{
			return ($this->db_debug) ? $this->display_error('db_must_use_set') : FALSE;
		}

		if ($table == '')
		{
			if ( ! isset($this->ar_from[0]))
			{
				return ($this->db_debug) ? $this->display_error('db_must_set_table') : FALSE;
			}

			$table = $this->ar_from[0];
		}

		// Batch this baby
		for ($i = 0, $total = count($this->ar_set); $i < $total; $i += 100)
		{
			$this->query($this->_update_batch($this->protect_identifiers($table, TRUE, NULL, FALSE), array_slice($this->ar_set, $i, 100), $this->protect_identifiers($index), $this->ar_where));
		}

		$this->_reset_write();
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * The "set_update_batch" function.  Allows key/value pairs to be set for batch updating
	 *
	 * @param	array
	 * @param	string
	 * @param	boolean
	 * @return	object
	 */
	public function set_update_batch($key, $index = '', $escape = TRUE)
	{
		$key = $this->_object_to_array_batch($key);

		if ( ! is_array($key))
		{
			// @todo error
		}

		foreach ($key as $k => $v)
		{
			$index_set = FALSE;
			$clean = array();
			foreach ($v as $k2 => $v2)
			{
				if ($k2 == $index)
				{
					$index_set = TRUE;
				}
				else
				{
					$not[] = $k.'-'.$v;
				}

				$clean[$this->protect_identifiers($k2)] = ($escape === FALSE) ? $v2 : $this->escape($v2);
			}

			if ($index_set == FALSE)
			{
				return $this->display_error('db_batch_missing_index');
			}

			$this->ar_set[] = $clean;
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Empty Table
	 *
	 * Compiles a delete string and runs "DELETE FROM table"
	 *
	 * @param	string	the table to empty
	 * @return	object
	 */
	public function empty_table($table = '')
	{
		if ($table == '')
		{
			if ( ! isset($this->ar_from[0]))
			{
				return ($this->db_debug) ? $this->display_error('db_must_set_table') : FALSE;
			}

			$table = $this->ar_from[0];
		}
		else
		{
			$table = $this->protect_identifiers($table, TRUE, NULL, FALSE);
		}

		$sql = $this->_delete($table);
		$this->_reset_write();
		return $this->query($sql);
	}

	// --------------------------------------------------------------------

	/**
	 * Truncate
	 *
	 * Compiles a truncate string and runs the query
	 * If the database does not support the truncate() command
	 * This function maps to "DELETE FROM table"
	 *
	 * @param	string	the table to truncate
	 * @return	object
	 */
	public function truncate($table = '')
	{
		if ($table == '')
		{
			if ( ! isset($this->ar_from[0]))
			{
				return ($this->db_debug) ? $this->display_error('db_must_set_table') : FALSE;
			}

			$table = $this->ar_from[0];
		}
		else
		{
			$table = $this->protect_identifiers($table, TRUE, NULL, FALSE);
		}

		$sql = $this->_truncate($table);
		$this->_reset_write();
		return $this->query($sql);
	}

	// --------------------------------------------------------------------

	/**
	 * Get DELETE query string
	 *
	 * Compiles a delete query string and returns the sql
	 *
	 * @access	public
	 * @param	string	the table to delete from
	 * @param	boolean	TRUE: reset AR values; FALSE: leave AR values alone
	 * @return	string
	 */
	public function get_compiled_delete($table = '', $reset = TRUE)
	{
		$this->return_delete_sql = TRUE;
		$sql = $this->delete($table, '', NULL, $reset);
		$this->return_delete_sql = FALSE;
		return $sql;
	}

	// --------------------------------------------------------------------

	/**
	 * Delete
	 *
	 * Compiles a delete string and runs the query
	 *
	 * @param	mixed	the table(s) to delete from. String or array
	 * @param	mixed	the where clause
	 * @param	mixed	the limit clause
	 * @param	boolean
	 * @return	object
	 */
	public function delete($table = '', $where = '', $limit = NULL, $reset_data = TRUE)
	{
		// Combine any cached components with the current statements
		$this->_merge_cache();

		if ($table == '')
		{
			if ( ! isset($this->ar_from[0]))
			{
				return ($this->db_debug) ? $this->display_error('db_must_set_table') : FALSE;
			}

			$table = $this->ar_from[0];
		}
		elseif (is_array($table))
		{
			foreach ($table as $single_table)
			{
				$this->delete($single_table, $where, $limit, FALSE);
			}

			$this->_reset_write();
			return;
		}
		else
		{
			$table = $this->protect_identifiers($table, TRUE, NULL, FALSE);
		}

		if ($where != '')
		{
			$this->where($where);
		}

		if ($limit != NULL)
		{
			$this->limit($limit);
		}

		if (count($this->ar_where) === 0 && count($this->ar_wherein) === 0 && count($this->ar_like) === 0)
		{
			return ($this->db_debug) ? $this->display_error('db_del_must_use_where') : FALSE;
		}

		$sql = $this->_delete($table, $this->ar_where, $this->ar_like, $this->ar_limit);
		if ($reset_data)
		{
			$this->_reset_write();
		}

		return ($this->return_delete_sql === TRUE) ? $sql : $this->query($sql);
	}

	// --------------------------------------------------------------------

	/**
	 * DB Prefix
	 *
	 * Prepends a database prefix if one exists in configuration
	 *
	 * @param	string	the table
	 * @return	string
	 */
	public function dbprefix($table = '')
	{
		if ($table == '')
		{
			$this->display_error('db_table_name_required');
		}

		return $this->dbprefix.$table;
	}

	// --------------------------------------------------------------------

	/**
	 * Set DB Prefix
	 *
	 * Set's the DB Prefix to something new without needing to reconnect
	 *
	 * @param	string	the prefix
	 * @return	string
	 */
	public function set_dbprefix($prefix = '')
	{
		return $this->dbprefix = $prefix;
	}

	// --------------------------------------------------------------------

	/**
	 * Track Aliases
	 *
	 * Used to track SQL statements written with aliased tables.
	 *
	 * @param	string	The table to inspect
	 * @return	string
	 */
	protected function _track_aliases($table)
	{
		if (is_array($table))
		{
			foreach ($table as $t)
			{
				$this->_track_aliases($t);
			}
			return;
		}

		// Does the string contain a comma?  If so, we need to separate
		// the string into discreet statements
		if (strpos($table, ',') !== FALSE)
		{
			return $this->_track_aliases(explode(',', $table));
		}

		// if a table alias is used we can recognize it by a space
		if (strpos($table, ' ') !== FALSE)
		{
			// if the alias is written with the AS keyword, remove it
			$table = preg_replace('/ AS /i', ' ', $table);

			// Grab the alias
			$table = trim(strrchr($table, ' '));

			// Store the alias, if it doesn't already exist
			if ( ! in_array($table, $this->ar_aliased_tables))
			{
				$this->ar_aliased_tables[] = $table;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Compile the SELECT statement
	 *
	 * Generates a query string based on which functions were used.
	 * Should not be called directly.  The get() function calls it.
	 *
	 * @return	string
	 */
	protected function _compile_select($select_override = FALSE)
	{
		// Combine any cached components with the current statements
		$this->_merge_cache();

		// Write the "select" portion of the query
		if ($select_override !== FALSE)
		{
			$sql = $select_override;
		}
		else
		{
			$sql = ( ! $this->ar_distinct) ? 'SELECT ' : 'SELECT DISTINCT ';

			if (count($this->ar_select) === 0)
			{
				$sql .= '*';
			}
			else
			{
				// Cycle through the "select" portion of the query and prep each column name.
				// The reason we protect identifiers here rather then in the select() function
				// is because until the user calls the from() function we don't know if there are aliases
				foreach ($this->ar_select as $key => $val)
				{
					$no_escape = isset($this->ar_no_escape[$key]) ? $this->ar_no_escape[$key] : NULL;
					$this->ar_select[$key] = $this->protect_identifiers($val, FALSE, $no_escape);
				}

				$sql .= implode(', ', $this->ar_select);
			}
		}

		// Write the "FROM" portion of the query
		if (count($this->ar_from) > 0)
		{
			$sql .= "\nFROM ".$this->_from_tables($this->ar_from);
		}

		// Write the "JOIN" portion of the query
		if (count($this->ar_join) > 0)
		{
			$sql .= "\n".implode("\n", $this->ar_join);
		}

		// Write the "WHERE" portion of the query
		if (count($this->ar_where) > 0 OR count($this->ar_like) > 0)
		{
			$sql .= "\nWHERE ";
		}

		$sql .= implode("\n", $this->ar_where);

		// Write the "LIKE" portion of the query
		if (count($this->ar_like) > 0)
		{
			if (count($this->ar_where) > 0)
			{
				$sql .= "\nAND ";
			}

			$sql .= implode("\n", $this->ar_like);
		}

		// Write the "GROUP BY" portion of the query
		if (count($this->ar_groupby) > 0)
		{
			$sql .= "\nGROUP BY ".implode(', ', $this->ar_groupby);
		}

		// Write the "HAVING" portion of the query
		if (count($this->ar_having) > 0)
		{
			$sql .= "\nHAVING ".implode("\n", $this->ar_having);
		}

		// Write the "ORDER BY" portion of the query
		if (count($this->ar_orderby) > 0)
		{
			$sql .= "\nORDER BY ".implode(', ', $this->ar_orderby);
			if ($this->ar_order !== FALSE)
			{
				$sql .= ($this->ar_order == 'desc') ? ' DESC' : ' ASC';
			}
		}

		// Write the "LIMIT" portion of the query
		if (is_numeric($this->ar_limit))
		{
			return $this->_limit($sql."\n", $this->ar_limit, $this->ar_offset);
		}

		return $sql;
	}

	// --------------------------------------------------------------------

	/**
	 * Object to Array
	 *
	 * Takes an object as input and converts the class variables to array key/vals
	 *
	 * @param	object
	 * @return	array
	 */
	public function _object_to_array($object)
	{
		if ( ! is_object($object))
		{
			return $object;
		}

		$array = array();
		foreach (get_object_vars($object) as $key => $val)
		{
			// There are some built in keys we need to ignore for this conversion
			if ( ! is_object($val) && ! is_array($val) && $key != '_parent_name')
			{
				$array[$key] = $val;
			}
		}

		return $array;
	}

	// --------------------------------------------------------------------

	/**
	 * Object to Array
	 *
	 * Takes an object as input and converts the class variables to array key/vals
	 *
	 * @param	object
	 * @return	array
	 */
	public function _object_to_array_batch($object)
	{
		if ( ! is_object($object))
		{
			return $object;
		}

		$array = array();
		$out = get_object_vars($object);
		$fields = array_keys($out);

		foreach ($fields as $val)
		{
			// There are some built in keys we need to ignore for this conversion
			if ($val !== '_parent_name')
			{
				$i = 0;
				foreach ($out[$val] as $data)
				{
					$array[$i++][$val] = $data;
				}
			}
		}

		return $array;
	}

	// --------------------------------------------------------------------

	/**
	 * Start Cache
	 *
	 * Starts AR caching
	 *
	 * @return	void
	 */
	public function start_cache()
	{
		$this->ar_caching = TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Stop Cache
	 *
	 * Stops AR caching
	 *
	 * @return	void
	 */
	public function stop_cache()
	{
		$this->ar_caching = FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Flush Cache
	 *
	 * Empties the AR cache
	 *
	 * @access	public
	 * @return	void
	 */
	public function flush_cache()
	{
		$this->_reset_run(array(
			'ar_cache_select'		=> array(),
			'ar_cache_from'			=> array(),
			'ar_cache_join'			=> array(),
			'ar_cache_where'		=> array(),
			'ar_cache_like'			=> array(),
			'ar_cache_groupby'		=> array(),
			'ar_cache_having'		=> array(),
			'ar_cache_orderby'		=> array(),
			'ar_cache_set'			=> array(),
			'ar_cache_exists'		=> array(),
			'ar_cache_no_escape'	=> array()
		));
	}

	// --------------------------------------------------------------------

	/**
	 * Merge Cache
	 *
	 * When called, this function merges any cached AR arrays with
	 * locally called ones.
	 *
	 * @return	void
	 */
	protected function _merge_cache()
	{
		if (count($this->ar_cache_exists) === 0)
		{
			return;
		}

		foreach ($this->ar_cache_exists as $val)
		{
			$ar_variable	= 'ar_'.$val;
			$ar_cache_var	= 'ar_cache_'.$val;

			if (count($this->$ar_cache_var) === 0)
			{
				continue;
			}

			$this->$ar_variable = array_unique(array_merge($this->$ar_cache_var, $this->$ar_variable));
		}

		// If we are "protecting identifiers" we need to examine the "from"
		// portion of the query to determine if there are any aliases
		if ($this->_protect_identifiers === TRUE AND count($this->ar_cache_from) > 0)
		{
			$this->_track_aliases($this->ar_from);
		}

		$this->ar_no_escape = $this->ar_cache_no_escape;
	}

	// --------------------------------------------------------------------

	/**
	 * Reset Active Record values.
	 *
	 * Publicly-visible method to reset the AR values.
	 *
	 * @return	void
	 */
	public function reset_query()
	{
		$this->_reset_select();
		$this->_reset_write();
	}

	// --------------------------------------------------------------------

	/**
	 * Resets the active record values.  Called by the get() function
	 *
	 * @param	array	An array of fields to reset
	 * @return	void
	 */
	protected function _reset_run($ar_reset_items)
	{
		foreach ($ar_reset_items as $item => $default_value)
		{
			if ( ! in_array($item, $this->ar_store_array))
			{
				$this->$item = $default_value;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Resets the active record values.  Called by the get() function
	 *
	 * @return	void
	 */
	protected function _reset_select()
	{
		$this->_reset_run(array(
					'ar_select'		=> array(),
					'ar_from'		=> array(),
					'ar_join'		=> array(),
					'ar_where'		=> array(),
					'ar_like'		=> array(),
					'ar_groupby'		=> array(),
					'ar_having'		=> array(),
					'ar_orderby'		=> array(),
					'ar_wherein'		=> array(),
					'ar_aliased_tables'	=> array(),
					'ar_no_escape'		=> array(),
					'ar_distinct'		=> FALSE,
					'ar_limit'		=> FALSE,
					'ar_offset'		=> FALSE,
					'ar_order'		=> FALSE
					)
				);
	}

	// --------------------------------------------------------------------

	/**
	 * Resets the active record "write" values.
	 *
	 * Called by the insert() update() insert_batch() update_batch() and delete() functions
	 *
	 * @return	void
	 */
	protected function _reset_write()
	{
		$this->_reset_run(array(
					'ar_set'	=> array(),
					'ar_from'	=> array(),
					'ar_where'	=> array(),
					'ar_like'	=> array(),
					'ar_orderby'	=> array(),
					'ar_keys'	=> array(),
					'ar_limit'	=> FALSE,
					'ar_order'	=> FALSE
					)
				);
	}

}

/* End of file DB_active_rec.php */
/* Location: ./system/database/DB_active_rec.php */
