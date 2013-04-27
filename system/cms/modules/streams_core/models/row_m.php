<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Row Model
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Models
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Row_m extends MY_Model {

	/**
	 * Field Types to Ignore
	 *
	 * An array of the default columns
	 * that are created in every stream table
	 * that we don't need to include in
	 * some processes.
	 *
	 * @var 	array
	 */
	public $ignore = array('id', 'created', 'updated', 'created_by');

	// --------------------------------------------------------------------------
				
	/**
	 * Cycle Select String
	 *
	 * @var 	string
	 */
	public $data;

	// --------------------------------------------------------------------------
		
	/**
	 * Base Prefix
	 *
	 * Convenience Var
	 *
	 * @var 	string
	 */
	public $base_prefix;

	// --------------------------------------------------------------------------
			
	/**
	 * Cycle Select String
	 *
	 * Each of the arrays can also be a string,
	 * in which case they will not be imploded.
	 *
	 * @var 	string
	 */
	public $sql = array(
		'select'	=> array(), 	// will be joined by ','
		'where'		=> array(),		// will be joined by 'AND'
		'from'		=> array(),		// array of tables
		'join'		=> array(),		// array of joins
		'order_by'	=> array(),		// will be joined by ','
		'misc'		=> array()		// will be joined by line breaks
	);
	
	// --------------------------------------------------------------------------
			
	/**
	 * All fields (so we don't have)
	 * to keep grabbing them from
	 * the database.
	 *
	 * @var 	obj
	 */
	public $all_fields = array();
	
	// --------------------------------------------------------------------------
			
	/**
	 * Streams structure
	 *
	 * @var 	array
	 */
	public $structure;
	
	// --------------------------------------------------------------------------

	/**
	 * Array of IDs called, by stream.
	 * Used to exclude IDs already called.
	 * @since 2.1
	 */
	public $called;
	
	// --------------------------------------------------------------------------

	/**
	 * Hook for get_rows
	 *
	 * @param 	public
	 * @var 	array($obj, $method_name)
	 */
	public $get_rows_hook 	= array();

	// --------------------------------------------------------------------------
	
	/**
	 * Data to send to the function
	 *
	 * @var		obj
	 */
	public $get_rows_hook_data;

	// --------------------------------------------------------------------------

	/**
	 * Set Fields
	 *
	 * Grab the fields for a stream
	 *
	 * @param 	stream object
	 * @return 	void
	 */
	private function set_fields($stream_namespace)
	{
		// If our stream namespace doesn't exist
		if ( ! isset($this->all_fields[$stream_namespace]))
		{
			$this->all_fields[$stream_namespace] = $this->fields_m->get_all_fields($stream_namespace);
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Get Rows
	 *
	 * Get rows from a stream
	 *
	 * @return 	array 
	 * @param	array
	 * @param	obj
	 * @param	obj
	 * @return	array
	 */
	public function get_rows($params, $field = null, $stream)
	{
		$return = array();

		// Set our fields for formatting.
		$this->set_fields($stream->stream_namespace);

		// First, let's get all out fields. That's
		// right. All of them.
		$this->all_fields[] = $this->fields_m->get_all_fields();
		
		// Now the structure. We will need this as well.
		$this->structure = $this->gather_structure();
	
		// So we don't get things confused
		if (isset($params['stream']))
		{
			unset($params['stream']);
		}

		// -------------------------------------
		// Get Our Stream Fields
		// -------------------------------------

		$stream_fields = $this->streams_m->get_stream_fields($stream->id);

		// -------------------------------------
		// Extract Our Params
		// -------------------------------------

		extract($params, EXTR_OVERWRITE);

		// -------------------------------------
		// Set the site_ref
		// -------------------------------------
		// Allows you to use streams from other
		// sites on a multi-site managed site.
		// -------------------------------------

		if ( ! isset($site_ref)) $site_ref = SITE_REF;

		$this->db->set_dbprefix($site_ref.'_');

		// -------------------------------------
		// Convenience Vars
		// -------------------------------------
		
		$this->data = new stdClass();
		$this->data->stream = $stream;

		$this->select_prefix 	= $this->db->protect_identifiers($stream->stream_prefix.$stream->stream_slug, true).'.';
		
		// -------------------------------------
		// Start Query Build
		// -------------------------------------
		
		// We may build on this.
		$this->sql['select'][] = $this->db->protect_identifiers($stream->stream_prefix.$stream->stream_slug, true).'.*';

		// -------------------------------------
		// From
		// -------------------------------------
		
		$this->sql['from'][] = $this->db->protect_identifiers($stream->stream_prefix.$stream->stream_slug, true);

		// -------------------------------------
		// Get the day.
		// For calendars and stuff
		// -------------------------------------

		if (isset($get_day) and $get_day == true)
		{
			$this->sql['select'][] = 'DAY('.$this->format_mysql_date($date_by, $stream->stream_namespace).') as pyrostreams_cal_day';
		}
		
		// -------------------------------------
		// Filter API
		// -------------------------------------

		$filter_api = array();

		if ($this->input->get('filter-'.$stream->stream_slug))
		{
			// Get all URL variables
			$url_variables = $this->input->get();

			$processed = array();

			// Loop and process
			foreach ($url_variables as $filter => $value)
			{
				// -------------------------------------
				// Filter API Params
				// -------------------------------------
				// They all start with f-
				// No value? No soup for you!
				// -------------------------------------

				if (substr($filter, 0, 2) != 'f-') continue;	// Not a filter API parameter

				if (strlen($value) == 0) continue;				// No value.. boo

				$filter = substr($filter, 2);					// Remove identifier


				// -------------------------------------
				// Not
				// -------------------------------------
				// Default: false
				// -------------------------------------

				$not = substr($filter, 0, 4) == 'not-';

				if ($not) $filter = substr($filter, 4);			// Remove identifier


				// -------------------------------------
				// Exact
				// -------------------------------------
				// Default: false
				// -------------------------------------

				$exact = substr($filter, 0, 6) == 'exact-';

				if ($exact) $filter = substr($filter, 6);		// Remove identifier


				// -------------------------------------
				// Construct the where segment
				// -------------------------------------

				if ($exact)
				{
					if ($not)
					{
						$filter_api[] = $this->db->protect_identifiers($stream->stream_prefix.$stream->stream_slug.'.'.$filter).' != "'.urldecode($value).'"';
					}
					else
					{
						$filter_api[] = $this->db->protect_identifiers($stream->stream_prefix.$stream->stream_slug.'.'.$filter).' = "'.urldecode($value).'"';
					}
				}
				else
				{
					if ($not)
					{
						$filter_api[] = $this->db->protect_identifiers($stream->stream_prefix.$stream->stream_slug.'.'.$filter).' NOT LIKE "%'.urldecode($value).'%"';
					}
					else
					{
						$filter_api[] = $this->db->protect_identifiers($stream->stream_prefix.$stream->stream_slug.'.'.$filter).' LIKE "%'.urldecode($value).'%"';
					}
				}
			}
		}
	
		// -------------------------------------
		// Disable
		// -------------------------------------
		// Allows users to turn off relationships
		// and created_by to save some queries
		// -------------------------------------
		
		if (isset($disable) and $disable)
		{		
			// Can be pre-processed
			if ( ! is_array($disable))
			{
				$disable = explode('|', $disable);
			}
		}	
		else
		{
			$disable = array();
		}

		// -------------------------------------
		// Created By
		// -------------------------------------
		// We are grabbing several user variables
		// as part of the main query.
		// -------------------------------------

		if ( ! in_array('created_by', $disable))
		{
			$this->sql['select'][] = '`cb_users`.`id` as `created_by||user_id`';
			$this->sql['select'][] = '`cb_users`.`email` as `created_by||email`';
			$this->sql['select'][] = '`cb_users`.`username` as `created_by||username`';
            $this->sql['select'][] = '`profiles`.`display_name` as `created_by||display_name`';

			$this->sql['join'][] = 'LEFT JOIN '.$this->db->protect_identifiers('users', true).' as `cb_users` ON `cb_users`.`id`='.$this->db->protect_identifiers($stream->stream_prefix.$stream->stream_slug.'.created_by', true);
            $this->sql['join'][] = 'LEFT JOIN '.$this->db->protect_identifiers('profiles', true).' as `profiles` ON `profiles`.`user_id`='.$this->db->protect_identifiers($stream->stream_prefix.$stream->stream_slug.'.created_by', true);
		}

		// -------------------------------------
		// Field Type Hooks
		// -------------------------------------
		// By adding a query_build_hook() function, 
		// field types can affect the sql array
		// at this time.
		// -------------------------------------

		if ($stream_fields)
		{
			foreach ($stream_fields as $field_slug => $stream_field)
			{
				if ( ! in_array($field_slug, $disable)
						and isset($this->type->types->{$stream_field->field_type})
						and method_exists($this->type->types->{$stream_field->field_type}, 'query_build_hook'))
				{
					$this->type->types->{$stream_field->field_type}->query_build_hook($this->sql, $stream_field, $stream);
				}
			}
		}

		// -------------------------------------
		// Ordering and Sorting
		// -------------------------------------

		if (isset($sort) and $sort == 'random')
		{
			// If we are doing sort by random,
			// it is a string since it is the only one
			$this->sql['order_by'] = 'RAND()';
		}
		else
		{
			// Query string API overrides all
			// Check if there is one now
			if ($this->input->get('sort-'.$stream->stream_slug))
			{
				$sort = $this->input->get('sort-'.$stream->stream_slug);
			}
			// Default Sort. This should be set beforehand,
			// but setting it here is a last resort
			elseif ( ! isset($sort) or $sort == '')
			{
				$sort = 'DESC';
			}
	
			// Query string API overrides all
			// Check if there is one now
			if ($this->input->get('order-'.$stream->stream_slug))
			{
				$this->sql['order_by'][] = $this->select_prefix.$this->db->protect_identifiers($this->input->get('order-'.$stream->stream_slug)).' '.strtoupper($sort);
			}
			// Other sorting options
			elseif ( ! isset($order_by) or $order_by == '')
			{
				// Let's go with the stream setting now
				// since there isn't an override	
				if ($stream->sorting == 'title' and $stream->title_column)
				{
					$this->sql['order_by'][] = $this->select_prefix.$this->db->protect_identifiers($stream->title_column).' '.strtoupper($sort);	
				}
				elseif ($stream->sorting == 'custom')
				{
					$this->sql['order_by'][] = $this->select_prefix.$this->db->protect_identifiers('ordering_count').' '.strtoupper($sort);
				}
			}
			else
			{
				$this->sql['order_by'][] = $this->select_prefix.$this->db->protect_identifiers($order_by).' '.strtoupper($sort);
			}
		}

		// -------------------------------------
		// Exclude
		// -------------------------------------
		
		// Do we have anything in the excludes that we can add?
		if (isset($exclude_called) and $exclude_called == 'yes' and 
			isset($this->called[$stream->stream_slug]) and ! empty($this->called[$stream->stream_slug]))
		{
			$exclude .= '|'.implode('|', $this->called[$stream->stream_slug]);
		}
		
		if (isset($exclude) and $exclude)
		{		
			$exclusions = explode('|', $exclude);
			
			foreach ($exclusions as $exclude_id)
			{
				$this->sql['where'][] = $this->select_prefix.$this->db->protect_identifiers($exclude_by).' !='.$this->db->escape($exclude_id);
			}
		}

		// -------------------------------------
		// Include
		// -------------------------------------
		
		if (isset($include) and $include)
		{
			$inclusions 	= explode('|', $include);
			$includes 		= array();
			
			foreach ($inclusions as $include_id)
			{
				$includes[] = $this->select_prefix.$this->db->protect_identifiers($include_by).'='.$this->db->escape($include_id);
			}

			$this->sql['where'][] = '('.implode(' OR ', $includes).')';
		}

		// -------------------------------------
		// Where (Legacy)
		// -------------------------------------

		if (isset($where_legacy) and $where_legacy)
		{
			// Replace the segs
			
			$seg_markers 	= array('seg_1', 'seg_2', 'seg_3', 'seg_4', 'seg_5', 'seg_6', 'seg_7');
			$seg_values		= array($this->uri->segment(1), $this->uri->segment(2), $this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5), $this->uri->segment(6), $this->uri->segment(7));
		
			$where_legacy = str_replace($seg_markers, $seg_values, $where_legacy);
			
			$vals = explode('==', trim($where_legacy));
			
			if (count($vals) == 2)
			{
				$this->sql['where'][] = $this->select_prefix.$this->db->protect_identifiers($vals[0]).' ='.$this->db->escape($vals[1]);
			}
		}

		// -------------------------------------
		// Where (Current)
		// -------------------------------------

		if (isset($where) and $where)
		{
			if (is_string($where))
			{
				$this->sql['where'][] = $this->process_where($where);
			}
			else
			{
				foreach($where as $where_item)
				{
					$this->sql['where'][] = $this->process_where($where_item);
				}
			}
		}
		
		$this->sql['where'] = array_merge($this->sql['where'], $filter_api);
		
		// -------------------------------------
		// Show Upcoming
		// -------------------------------------

		if (isset($show_upcoming) and $show_upcoming == 'no')
		{
			$this->sql['where'][] = $this->format_mysql_date($date_by, $stream->stream_namespace).' <= CURDATE()';
		}

		// -------------------------------------
		// Show Past
		// -------------------------------------

		if (isset($show_past) and $show_past == 'no')
		{
			$this->sql['where'][] = $this->format_mysql_date($date_by, $stream->stream_namespace).' >= CURDATE()';
		}

		// -------------------------------------
		// Month / Day / Year
		// -------------------------------------
		
		if (isset($year) and is_numeric($year))
		{
			$this->sql['where'][] = 'YEAR('.$this->format_mysql_date($date_by, $stream->stream_namespace).')='.$this->db->escape($year);
		}

		if (isset($month) and is_numeric($month))
		{
			$this->sql['where'][] = 'MONTH('.$this->format_mysql_date($date_by, $stream->stream_namespace).')='.$this->db->escape($month);
		}

		if (isset($day) and is_numeric($day))
		{
			$this->sql['where'][] = 'DAY('.$this->format_mysql_date($date_by, $stream->stream_namespace).')='.$this->db->escape($day);
		}

		// -------------------------------------
		// Restrict User
		// -------------------------------------
		// This allows us to restrict returned
		// entries by created_by. $restrict_user
		// Could have the following values:
		// - 'current'
		// - a user id
		// - a username
		// -------------------------------------
	
		if (isset($restrict_user) and $restrict_user)
		{
			$restrict_user_id = null;

			if ($restrict_user != 'no')
			{
				// Should we restrict to the current user?
				if ($restrict_user == 'current')
				{
					// Check and see if a user is logged in
					// and then set the param
					if (isset($this->current_user->id) and is_numeric($this->current_user->id))
					{
						$restrict_user_id = $this->current_user->id;
					}
				}
				elseif (is_numeric($restrict_user))
				{
					// It's numeric, meaning we can just
					// use it below easy!
					$restrict_user_id = $restrict_user;
				}
				else
				{
					// Looks like they might have put in a user's handle
					$user = $this->db
							->select('id')
							->limit(1)
							->where('username', $restrict_user)
							->get('users')->row();

					if ($user)
					{
						$restrict_user_id = $user->id;
					}
				}
			}
		
			// Did we get a restrict user value from the
			// options above? If so, let's filter by it!
			if ($restrict_user_id)
			{
				$this->sql['where'][] = $this->select_prefix.$this->db->protect_identifiers('created_by').'='.$restrict_user_id;
			}
		}

		// -------------------------------------
		// Get by ID
		// -------------------------------------
		
		if (isset($id) and is_numeric($id))
		{
			$this->sql['where'][] = $this->select_prefix.$this->db->protect_identifiers('id').'='.$id;
			$limit 		= 1;
			$offset 	= 0;
		}

		// -------------------------------------
		// Single
		// -------------------------------------
		// I don't even know why this exists
		// really, but it does make sure that
		// limit is set to one.
		// -------------------------------------

		if (isset($single) and $single == 'yes')
		{
			$limit = 1;
		}

		// -------------------------------------
		// Hook
		// -------------------------------------
		// This hook can be used by fields
		// to add to the query
		// -------------------------------------
		
		if ($this->get_rows_hook)
		{
			if (method_exists($this->get_rows_hook[0], $this->get_rows_hook[1]))
			{
				$this->get_rows_hook[0]->{$this->get_rows_hook[1]}($this->get_rows_hook_data, $this);
			}
		}
		
		// -------------------------------------
		// Run Our Select
		// -------------------------------------

		$sql = $this->build_query($this->sql);

		// -------------------------------------
		// Pagination
		// -------------------------------------
		
		if (isset($paginate) and $paginate == 'yes')
		{
			// Run the query as is. It does not
			// have limit/offset, so we can get the
			// total num rows with the current
			// parameters we have applied.
			$return['pag_count'] = $this->db->query($sql)->num_rows();

			// Get the number.
			if (isset($pag_uri_method) and $pag_uri_method == 'query_string') 
			{
				// Get the query string var
				if ( ! isset($pag_query_var) or $pag_query_var) {
					$pag_query_var = 'page';
				}

				$pag_id = $this->input->get($pag_query_var);

				// We, at the very least, need to be on page 1.
				if ( ! $pag_id or ! is_numeric($pag_id) or $pag_id < 1)
				{
					$pag_id = 1;
				}
			}
			else
			{
				$pag_id = $this->uri->segment($pag_segment, 0);
			}
			
			if (isset($pag_method))
			{
				if ($pag_method == 'page') 
				{	
					$offset = $limit*($pag_id-1);
				}
				else
				{
					// Default is 'offset',
					// our segment holds the offset
					$offset = $pag_id;
				}
			}
			else
			{
				// If there is no pag_method set, we will
				// just use $pag_id as the offset.
				$offset = $pag_id;
			}
		}

		// -------------------------------------
		// Offset 
		// -------------------------------------
		// Normalize offset to 0 just in case.
		// -------------------------------------

		if ( ! isset($offset) or ! is_numeric($offset) or ! $offset or $offset < 0)
		{
			$offset = 0;
		}

		// -------------------------------------
		// Limit & Offset
		// -------------------------------------
		
		if (isset($limit) and is_numeric($limit))
		{
			$sql .= ' LIMIT '.$limit;
		}

		if (isset($offset) and is_numeric($offset) and $offset != 0)
		{
			$sql .= ' OFFSET '.$offset;
		}

		// -------------------------------------
		// Run the Get
		// -------------------------------------

		$rows = $this->db->query($sql)->result_array();

		// -------------------------------------
		// Reset SQL
		// We no longer need any of the SQL data.
		// If anything goes wrong with the items
		// below, we want to make sure we cleared
		// the SQL.
		// -------------------------------------

		$this->reset_sql();

		// -------------------------------------
		// Partials
		// -------------------------------------
		// Paritals are done after the data grab
		// so we can still partials outsider of
		// limits/offsets in queries.
		// -------------------------------------
				
		if (isset($partial) and ! is_null($partial))
		{
			if (count($partials = explode('of', $partial)) == 2 and is_numeric($partials[1]))
			{
				// Break the array into how many pieces
				// we want.
				$chunks = array_chunk($rows, ceil(count($rows)/$partials[1]), true);
								
				if (isset($chunks[$partials[0]-1]))
				{
					$rows =& $chunks[$partials[0]-1];
				}
			}
		}

		// -------------------------------------
		// Run formatting
		// -------------------------------------
				
		$return['rows'] = $this->format_rows($rows, $stream, $disable, $stream_fields);
	
		// Reset
		$this->get_rows_hook = array();
		$this->db->set_dbprefix(SITE_REF.'_');
				
		return $return;
	}

	// --------------------------------------------------------------------------

	/**
	 * Format MySQL Date
	 *
	 * Dates in streams can either be in UNIX or MYSQL format.
	 * This formats any MySQL dates so we can do our date functions as
	 * UNIX time stamps.
	 *
	 * @access 	public
	 * @param 	string 	$data_by
	 * @param 	string  $stream_namespace
	 * @return 	string
	 */
	public function format_mysql_date($date_by, $stream_namespace)
	{
		$return = $date_by;

		// Get the field and see if it has a preference for UNIX vs. MySQL
		if (array_key_exists($date_by, $this->all_fields[$stream_namespace]) and ($date_by != 'created' and $date_by != 'updated'))
		{
			if (isset($this->all_fields[$stream_namespace][$date_by]['field_data']['storage']) and $this->all_fields[$stream_namespace][$date_by]['field_data']['storage'] == 'unix')
			{
				return 'FROM_UNIXTIME('.$this->select_prefix.$this->db->protect_identifiers($date_by).')';
			}
		}

		return $this->select_prefix.$this->db->protect_identifiers($date_by);
	}

	// --------------------------------------------------------------------------

	/**
	 * Build Query
	 *
	 * Does not do LIMIT/OFFSET since that will
	 * be taken care of after pagination is 
	 * calculated.
	 *
	 * @access 	public
	 * @param 	array 	[$sql] 	an array of sql elements to parse
	 * 							into a sql string.
	 * @return 	string 	the compiled query
	 */
	public function build_query($sql = array())
	{
		// -------------------------------------
		// Select
		// -------------------------------------

		if (is_string($sql['select']))
		{
			$select = $sql['select'];
		}
		else
		{
			$select = implode(', ', $sql['select']);
		}
		
		// -------------------------------------
		// From
		// -------------------------------------

		if (isset($this->sql['from']) and is_string($sql['from']))
		{
			$from = $this->sql['from'];
		}
		else
		{
			$from = implode(', ', $sql['from']);
		}

		// -------------------------------------
		// Join
		// -------------------------------------

		if (isset($sql['join']) and is_string($sql['join']))
		{
			$join = $sql['join'];
		}
		else
		{
			(isset($sql['join'])) ? $join = implode(' ', $sql['join']) : $join = null;
		}

		// -------------------------------------
		// Where
		// -------------------------------------

		if (isset($sql['where']) and is_string($sql['where']))
		{
			$where = $sql['where'];
		}
		else
		{
			(isset($sql['where'])) ? $where = implode(' AND ', $sql['where']) : $where = null;
		}

		if ($where != '')
		{
			$where = 'WHERE '.$where;
		}

		// -------------------------------------
		// Order By
		// -------------------------------------
		// If there is a RAND, make sure it
		// is the only order by segment
		// -------------------------------------

		if (isset($sql['order_by']) and is_string($sql['order_by']))
		{
			$order_by = $sql['order_by'];
		}
		else
		{
			(isset($sql['order_by'])) ? $order_by = implode(', ', $sql['order_by']) : $order_by = null;
		}

		if ($order_by)
		{
			$order_by = 'ORDER BY '.$order_by;
		}

		// -------------------------------------
		// Misc
		// -------------------------------------

		if (isset($sql['misc']) && is_string($sql['misc']))
		{
			$misc = $sql['misc'];
		}
		else
		{
			(isset($sql['misc'])) ? $misc = implode(' ', $sql['misc']) : $misc = null;
		}

		// -------------------------------------
		// Return Built Query
		// -------------------------------------

		return "SELECT {$select}
		FROM {$from}
		{$join}
		{$where}
		{$misc}
		{$order_by} ";
	}

	// --------------------------------------------------------------------------

	/**
	 * Reset SQL query
	 *
	 * @access 	public
	 * @return 	void
	 */
	public function reset_sql()
	{
		$this->sql = array(
			'select'	=> array(),
			'where'		=> array(),
			'from'		=> array(),
			'order_by'	=> array(),
			'misc'		=> array()
		);
	}

	// --------------------------------------------------------------------------

	/**
	 * Process the where string. Anything in backticks 
	 * is considered a table name and has a table prefix
	 * added onto it.
	 *
	 * @access 	private
	 * @param 	string - where string
	 * @return 	string
	 */
	private function process_where($where)
	{
		// Get rid of where ()
		if ($where[0] == '(' and $where[strlen($where)-1] == ')')
		{
			$where = ltrim('(');
			$where = rtrim(')');
		}

		// Does this already have a specific table
		// that we are calling out for this where statement?
		// If so, then let's just forget about and return
		// the statement as is.
		if (strpos($where, '`.`') !== false)
		{
			return '('.$where.')';
		}

		// Find the fields between the backticks
		preg_match_all('/`[a-zA-Z0-9_]+`/', $where, $matches);

		if (isset($matches[0]) and is_array($matches[0]))
		{
			$matches[0] = array_unique($matches[0]);

			foreach ($matches[0] as $match)
			{
				$where = preg_replace('/(^.|)'.$match.'/', $this->select_prefix.$match, $where);
			}
		}

		return '('.$where.')';
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Format Rows
	 *
	 * Takes raw array of data
	 * from the DB and formats it. Adds
	 * things like count and odd/even.
	 *
	 * @access	public
	 * @param	array - rows from db
	 * @param	obj - stream
	 * @param	[array - disables]
	 * @return	array
	 */
	public function format_rows($data, $stream, $disable = array(), $stream_fields = null)
	{
		$count = 1;

		// We are keepig the option to get stream fields in the function
		// purely for legacy. We should be passing this in the format rows
		// so we can check for functions in the field types that need
		// to change the main query.
		if ( ! $stream_fields)
		{
			$stream_fields = $this->streams_m->get_stream_fields($stream->id);
		}

		$total = count($data);

		foreach ($data as $id => $item)
		{
			// Log the ID called
			$this->called[$stream->stream_slug][] = $item['id'];

			$this->extract_arrays($item);

			$data[$id] = $this->format_row($item, $stream_fields, $stream, false, true, $disable);
			
			// Give some info on if it is the last element
			$data[$id]['last'] = ($count == $total) ? '1' : '0';
						
			// Odd/Even			
			$data[$id]['odd_even'] = ($count%2 == 0) ? 'even' : 'odd';
			
			// Count
			$data[$id]['count'] = $count;
			
			$count++;
		}
		
		return $data;
	}

	// --------------------------------------------------------------------------

	/**
	 * Extract Arrays
	 *
	 * Takes a row array, and takes any ||'s as an
	 * array split. This means that we can do joins and then
	 * have them formatted in a way that the Lex parser
	 * will be able to work with.
	 *
	 * @access 	public
	 * @param 	array 	&$item
	 * @return 	void
	 */
	public function extract_arrays(&$item)
	{
		foreach ($item as $row_slug => $data)
		{
			if (strpos($row_slug, '||') !== false)
			{
				$pieces = explode('||', $row_slug, 2);

				unset($item[$row_slug]);

				if (isset($item[$pieces[0]]) and ! is_array($item[$pieces[0]]))
				{
					unset($item[$pieces[0]]);
				}

				$item[$pieces[0]][$pieces[1]] = $data;
			}
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get a row. Also has the option
	 * to format that data before returning it.
	 *
	 * @access	public
	 * @param	int
	 * @param	obj
	 * @param	[bool]
	 * @return	mixed
	 */
	public function get_row($id, $stream, $format_output = true, $plugin_call = false)
	{
		// Now the structure. We will need this as well.
		if ( ! $this->structure)
		{
			$this->structure = $this->gather_structure();
		}

		$stream_fields = $this->streams_m->get_stream_fields($stream->id);

		// Created By
		$this->db->select($stream->stream_prefix.$stream->stream_slug.'.*, '.$this->db->dbprefix('users').'.username as created_by_username, '.$this->db->dbprefix('users').'.id as created_by_user_id, '.$this->db->dbprefix('users').'.email as created_by_email');
		$this->db->join('users', 'users.id = '.$stream->stream_prefix.$stream->stream_slug.'.created_by', 'left');

		$obj = $this->db
						->limit(1)
						->where($stream->stream_prefix.$stream->stream_slug.'.id', $id)
						->get($stream->stream_prefix.$stream->stream_slug);
		
		if ($obj->num_rows() == 0)
		{
			return false;
		}
		else
		{
			$row = $obj->row();
			
			if ($format_output)
			{
				return $this->format_row($row , $stream_fields, $stream, true, $plugin_call);
			}
			else
			{	
				return $row;
			}
		}
	}

	// --------------------------------------------------------------------------	
	
	/**
	 * Format Row
	 *
	 * Formats a row based on format profile
	 *
	 * @access	public
	 * @param	array or obj
	 * @param	array
	 * @param	obj
	 * @param	[bool]
	 * @param	[bool]
	 * @param	[array - things to disable]
	 */
	public function format_row($row, $stream_fields, $stream, $return_object = true, $plugin_call = false,  $disable = array())
	{
		// Set our fields for formatting.
		$this->set_fields($stream->stream_namespace);

		// This is dumb and wil be refactored in 2.2 (I hope)
		$all_fields =& $this->all_fields[$stream->stream_namespace];

		// Now the structure. We will need this as well.
		if ( ! $this->structure)
		{
			$this->structure = $this->gather_structure();
		}

		// -------------------------------------
		// Format Rows
		// -------------------------------------
		// Go through each row and 
		// get the data from the plugin or
		// format it
		// -------------------------------------

		if ($row and (is_array($row) or  is_object($row)))
		{
			foreach ($row as $row_slug => $data)
			{
				// Easy out for our non-formattables and
				// fields we are disabling.
				if (in_array($row_slug, array('id', 'created_by')) or in_array($row_slug, $disable) or in_array('*', $disable))
				{
					continue;
				}
							
				// -------------------------------------
				// Format Dates
				// -------------------------------------
				// We simply want these to be UNIX stamps
				// -------------------------------------
				
				if ($row_slug == 'created' or $row_slug == 'updated')
				{
					if ($return_object)
					{
						$row->$row_slug = strtotime($row->$row_slug);
					}
					else
					{
						$row[$row_slug] = strtotime($row[$row_slug]);
					}
				}	

				// -------------------------------------
				// Format Columns
				// -------------------------------------

				if (array_key_exists($row_slug, $all_fields))
				{
					if ($return_object)
					{
						$row->$row_slug = $this->format_column($row_slug,
							$row->$row_slug, $row->id, $stream_fields->$row_slug->field_type, array_merge((array) $stream_fields->$row_slug->field_data, (array) $stream_fields->$row_slug), $stream, $plugin_call);
					}
					else
					{
						$row[$row_slug] = $this->format_column($row_slug,
							$row[$row_slug], $row['id'], $stream_fields->$row_slug->field_type, array_merge((array) $stream_fields->$row_slug->field_data, (array) $stream_fields->$row_slug), $stream, $plugin_call);
					}
				}
			}
		}

		// -------------------------------------
		// Run through alt processes
		// -------------------------------------
		// If this is not a plugin call, we just
		// need to get the alt processes and
		// add them to the row for display
		// -------------------------------------
		
		if ( ! $plugin_call)
		{
			if ($stream_fields)
			{
				foreach ($stream_fields as $row_slug => $f)
				{
					if (isset($f->field_type, $this->ignore))
					{
						if(
							isset($this->type->types->{$f->field_type}->alt_process) and 
							$this->type->types->{$f->field_type}->alt_process === true and 
							method_exists($this->type->types->{$f->field_type}, 'alt_pre_output')
						)
						{
							$out = $this->type->types->{$f->field_type}->alt_pre_output($row->id, $all_fields[$row_slug]['field_data'], $f->field_type, $stream);
								
							($return_object) ? $row->$row_slug = $out : $row[$row_slug] = $out;
						}
					}
				}
			}
		}
		
		return $row;			
	}

	// --------------------------------------------------------------------------	

	/**
	 * Format a single column
	 *
	 * @access 	public
	 * @params	
	 */
	public function format_column($column_slug, $column_data, $row_id, $type_slug, $field_data, $stream, $plugin = true)
	{
		// Does our type exist?
		if ( ! isset($this->type->types->{$type_slug}))
		{
			return null;
		}
		$plugin_call = null;
		// Is this an alt process type?
		if (isset($this->type->types->{$type_slug}->alt_process) and $this->type->types->{$type_slug}->alt_process === true)
		{
			if ( ! $plugin_call and method_exists($this->type->types->{$type_slug}, 'alt_pre_output'))
			{
				return $this->type->types->{$type_slug}->alt_pre_output($row_id, $field_data, $this->type->types->{$type_slug}, $stream);
			}
			
			return $column_data;
		}	
		else
		{
			// If not, check and see if there is a method
			// for pre output or pre_output_plugin
			if ($plugin and method_exists($this->type->types->{$type_slug}, 'pre_output_plugin'))
			{
				return $this->type->types->{$type_slug}->pre_output_plugin($column_data, $field_data, $column_slug);
			}
			elseif (method_exists($this->type->types->{$type_slug}, 'pre_output'))
			{
				return $this->type->types->{$type_slug}->pre_output($column_data, $field_data);
			}
		}

		return $column_data;
	}

	// --------------------------------------------------------------------------	
	
	/**
	 * Gather Structure
	 *
	 * Get the structure of the streams down. We never know
	 * when we are going to need this for formatting or
	 * reference.
	 *
	 * @access	public
	 * @return	array
	 */
	public function gather_structure()
	{		
		$obj = $this->db->query('
			SELECT '.PYROSTREAMS_DB_PRE.STREAMS_TABLE.'.*, '.PYROSTREAMS_DB_PRE.STREAMS_TABLE.'.id as stream_id, '.PYROSTREAMS_DB_PRE.FIELDS_TABLE.'.* 
			FROM '.PYROSTREAMS_DB_PRE.STREAMS_TABLE.', '.PYROSTREAMS_DB_PRE.ASSIGN_TABLE.', '.PYROSTREAMS_DB_PRE.FIELDS_TABLE.'
			WHERE '.PYROSTREAMS_DB_PRE.STREAMS_TABLE.'.id='.PYROSTREAMS_DB_PRE.ASSIGN_TABLE.'.stream_id and
			'.PYROSTREAMS_DB_PRE.FIELDS_TABLE.'.id='.PYROSTREAMS_DB_PRE.ASSIGN_TABLE.'.field_id');

		$fields = $obj->result();
		
		$struct = array();
		
		foreach ($this->streams_m->streams_cache as $stream_id => $stream)
		{
			if ($stream_id == 'ns') continue;

			$struct[$stream_id]['stream'] = $stream;
			
			foreach ($fields as $field)
			{
				if ($field->stream_slug == $stream->stream_slug)
				{
					$struct[$stream_id]['fields'][] = $field;
				}
			}
		}
		
		return $struct;
	}
	
	// --------------------------------------------------------------------------	
	
	/**
	 * Update a row in a stream
	 *
	 * @param	obj
	 * @param 	string
	 * @param	int
	 * @param	array   update data
	 * @param	array   skips - optional array of skips
	 * @param 	array   extra - optional assoc array of data to exclude from processing, but to
	 * 						include in saving to the database.
	 * @param 	bool    Should we only update those passed?
	 * @return	bool
	 */
	public function update_entry($fields, $stream, $row_id, $form_data, $skips = array(), $extra = array(), $include_only_passed = true)
	{
		$this->load->helper('text');

		// -------------------------------------
		// Include Only Passed
		// -------------------------------------
		// If we include only the passed vars,
		// then we skip everyhing else.
		// -------------------------------------

		if ($include_only_passed && $fields)
		{
			foreach ($fields as $field)
			{
				// If we haven't passed it, then we
				// want to skip it.
				if ( ! isset($form_data[$field->field_slug]))
				{
					$skips[] = $field->field_slug;
				}
			}

			// If we are including only the passed,
			// then we are simply going to process the fields that
			// we have passed without creating null
			// values for missing fields. This variable allows
			// run_field_pre_processes to do that.
			$set_missing_to_null = false;
		}
		else
		{
			$set_missing_to_null = true;
		}

		// -------------------------------------
		// Run through fields
		// -------------------------------------

		$update_data = $this->run_field_pre_processes($fields, $stream, $row_id, $form_data, $skips, $set_missing_to_null);

		// -------------------------------------
		// Set Updated Date
		// -------------------------------------

		if ( ! in_array('updated', $skips) and ! isset($extra['updated']))
		{
			$update_data['updated'] 	= date('Y-m-d H:i:s');
		}

		// -------------------------------------
		// Add Extra Data
		// -------------------------------------

		if ($extra)
		{
			$update_data = array_merge($update_data, $extra);
		}

		// -------------------------------------
		// Update data
		// -------------------------------------
		
		// Is there any logic to complete before updating?
		if ( Events::trigger('streams_pre_update_entry', array('stream' => $stream, 'entry_id' => $row_id, 'update_data' => $update_data)) === false ) return false;

		if ($update_data)
		{
			$this->db->where('id', $row_id);

			if ( ! $this->db->update($stream->stream_prefix.$stream->stream_slug, $update_data) )
			{
				return false;
			}
			else
			{
				// -------------------------------------
				// Event: Post Update Entry
				// -------------------------------------

				$trigger_data = array(
					'entry_id'		=> $row_id,
					'stream'		=> $stream,
					'update_data'		=> $update_data,
				);

				Events::trigger('streams_post_update_entry', $trigger_data);

				// -------------------------------------

				return $row_id;
			}
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Run fields through their pre-process
	 *
	 * Just used for updating right now
	 *
	 * @access	public
	 * @param	obj
	 * @param 	string
	 * @param	int
	 * @param	array - update data
	 * @param	skips - optional array of skips
	 * @param 	bool - set_missing_to_null. Should we set missing pieces of data to null
	 * 					for the database?
	 * @return	bool
	 */
	public function run_field_pre_processes($fields, $stream, $row_id, $form_data, $skips = array(), $set_missing_to_null = true)
	{
		$return_data = array();
		
		if ($fields)
		{
			foreach ($fields as $field)
			{
				// If we don't have a post item for this field, 
				// then simply set the value to null. This is necessary
				// for fields that want to run a pre_save but may have
				// a situation where no post data is sent (like a single checkbox)
				if ( ! isset($form_data[$field->field_slug]) and $set_missing_to_null)
				{
					$form_data[$field->field_slug] = null;
				}

				// If this is not in our skips list, process it.
				if ( ! in_array($field->field_slug, $skips))
				{
					$type = $this->type->types->{$field->field_type};
		
					if ( ! isset($type->alt_process) or ! $type->alt_process)
					{
						// If a pre_save function exists, go ahead and run it
						if (method_exists($type, 'pre_save'))
						{
							$return_data[$field->field_slug] = $type->pre_save(
										$form_data[$field->field_slug],
										$field,
										$stream,
										$row_id,
										$form_data);

							// We are unsetting the null values to as to
							// not upset db can be null rules.
							if (is_null($return_data[$field->field_slug]))
							{
								unset($return_data[$field->field_slug]);
							}
							else
							{
								$return_data[$field->field_slug] = $return_data[$field->field_slug];
							}
						}
						else
						{
							$return_data[$field->field_slug] = $form_data[$field->field_slug];
		
							// Make null - some fields don't like just blank values
							if ($return_data[$field->field_slug] == '')
							{
								$return_data[$field->field_slug] = null;
							}
						}
					}
					else
					{
						// If this is an alt_process, there can still be a pre_save,
						// it just won't return anything so we don't have to
						// save the value
						if (method_exists($type, 'pre_save'))
						{
							$type->pre_save(
										$form_data[$field->field_slug],
										$field,
										$stream,
										$row_id,
										$form_data
							);
						}
					}
				}
			}	
		}

		return $return_data;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Insert field to a stream
	 *
	 * @access	public
	 * @param	array - data
	 * @param	obj - our stream fields
	 * @param	obj - our stream
	 * @param	array - optional skipping fields
	 * @param 	array - optional assoc array of data to exclude from processing, but to
	 * 						include in saving to the database.
	 * @return	mixed
	 */
	public function insert_entry($data, $fields, $stream, $skips = array(), $extra = array())
	{
		$this->load->helper('text');

		// -------------------------------------
		// Run through fields
		// -------------------------------------

		$insert_data = array();
		
		$alt_process = array();
		
		if ($fields)
		{
			foreach ($fields as $field)
			{
				if ( ! in_array($field->field_slug, $skips) or (in_array($field->field_slug, $skips) and isset($_POST[$field->field_slug])))
				{
					$type = $this->type->types->{$field->field_type};
					
					if (isset($data[$field->field_slug]) and $data[$field->field_slug] != '')
					{
						// We don't process the alt process stuff.
						// This is for field types that store data outside of the
						// actual table
						if (isset($type->alt_process) and $type->alt_process === true)
						{
							$alt_process[] = $field->field_slug;
						}
						else
						{
							if (method_exists($type, 'pre_save'))
							{
								$insert_data[$field->field_slug] = $type->pre_save($data[$field->field_slug], $field, $stream, null, $data);
							}
							else
							{
								$insert_data[$field->field_slug] = $data[$field->field_slug];
							}

							if (is_null($insert_data[$field->field_slug]))
							{
								unset($insert_data[$field->field_slug]);
							}
							elseif(is_string($insert_data[$field->field_slug]))
							{
								$insert_data[$field->field_slug] = trim($insert_data[$field->field_slug]);
							}
						}
					}
					
					unset($type);
				}
			}
		}

		// -------------------------------------
		// Set Created Date
		// -------------------------------------

		if ( ! in_array('created', $skips) and ! isset($extra['created']))
		{
			$insert_data['created'] 	= date('Y-m-d H:i:s');
		}

		// -------------------------------------
		// Set Created By
		// -------------------------------------

		if ( ! in_array('created_by', $skips) and ! isset($extra['created_by']))
		{
			if (isset($this->current_user->id))
			{
				$insert_data['created_by'] 	= $this->current_user->id;
			}
			else
			{
				$insert_data['created_by'] 	= null;
			}
		}

		// -------------------------------------
		// Merge Extra Data
		// -------------------------------------

		if ( ! empty($extra))
		{
			$insert_data = array_merge($insert_data, $extra);
		}

		// -------------------------------------
		// Set incremental ordering
		// -------------------------------------
		
		$db_obj = $this->db->select("MAX(ordering_count) as max_ordering")->get($stream->stream_prefix.$stream->stream_slug);
		
		if ($db_obj->num_rows() == 0 or !$db_obj)
		{
			$ordering = 0;
		}
		else
		{
			$order_row = $db_obj->row();
			
			if ( ! is_numeric($order_row->max_ordering))
			{
				$ordering = 0;
			}
			else
			{
				$ordering = $order_row->max_ordering;
			}
		}

		$insert_data['ordering_count'] 	= $ordering+1;

		// -------------------------------------
		// Insert data
		// -------------------------------------

		// Is there any logic to complete before inserting?
		if ( Events::trigger('streams_pre_insert_entry', array('stream' => $stream, 'insert_data' => $insert_data)) === false ) return false;

		if ( ! $this->db->insert($stream->stream_prefix.$stream->stream_slug, $insert_data))
		{
			return false;
		}
		else
		{
			$id = $this->db->insert_id();
			
			// Process any alt process stuff
			foreach ($alt_process as $field_slug)
			{
				$this->type->types->{$fields->$field_slug->field_type}->pre_save($data[$field_slug], $fields->{$field_slug}, $stream, $id, $data);
			}
			
			// -------------------------------------
			// Event: Post Insert Entry
			// -------------------------------------

			$trigger_data = array(
				'entry_id'		=> $id,
				'stream'		=> $stream,
				'insert_data'	=> $insert_data
			);

			Events::trigger('streams_post_insert_entry', $trigger_data);

			// -------------------------------------

			return $id;
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Build Row Pagination
	 *
	 * @access	public
	 * @param	int $pag_segment pagination uri segment where the page num is
	 * @param	int $limit
	 * @param	int $total_rows count of all the rows
	 * @param	array $pagination_var array of pagination configs
	 * @param 	string [$pag_base] optional manual pagination base
	 * @return	string
	 */
	public function build_pagination($config, $limit, $total_rows, $pagination_vars, $pag_base = null)
	{
		$this->load->library('pagination');
		$pagination_config = array();

		// -------------------------------------
		// Page Config.
		// -------------------------------------
		// For backwards compatability, you can
		// pass the first variable as the $pag_segment,
		// but you can also pass an array of
		// config values.
		// -------------------------------------

		if ( ! is_array($config))
		{
			$pag_segment = $config;
		}
		else
		{
			$pag_segment = (isset($config['pag_segment'])) ? $config['pag_segment'] : 2;
			$pag_method = (isset($config['pag_method'])) ? $config['pag_method'] : 'offset';
			$pag_uri_method = (isset($config['pag_uri_method'])) ? $config['pag_uri_method'] : 'segment;';
			$pag_query_var = (isset($config['pag_query_var'])) ? $config['pag_query_var'] : 'page';
		}

		// Validate pag_segment	
		if ( ! is_numeric($pag_segment))
		{
			$pag_segment = 2;
		}

		// -------------------------------------
		// Config Set
		// -------------------------------------

		// Set use_page_numbers
		if (isset($pag_method) and $pag_method == 'page')
		{
			$pagination_config['use_page_numbers'] = true;
		} else {
			$pagination_config['uri_segment'] 		= $pag_segment;
		}

		// We want to preserve the query string
		// if we are using the query_string method.
		if (isset($pag_uri_method) and $pag_uri_method == 'query_string')
		{
			$pagination_config['page_query_string'] = true;
		}

		// Override $pag_base with config if we need to.
		if (isset($config['pag_base_url']) and $config['pag_base_url'])
		{
			$pag_base = $config['pag_base_url'];
		}

		if (isset($pag_query_var) and $pag_query_var)
		{
			$pagination_config['query_string_segment'] = $pag_query_var;
		}

		// -------------------------------------
		// Find Pagination base_url
		// -------------------------------------
		// We either are handed this or we
		// do it based on the pag_segment and 
		// the current URL.
		// -------------------------------------

		if ( ! $pag_base)
		{
			// Are we using a query string? If so, we just need to take
			// The entire current URL. Otherwise, we take the URL up to the
			// pagination segment.
			if (isset($pag_uri_method) and $pag_uri_method == 'query_string')
			{
				$pagination_config['base_url'] = current_url().'?';
			}
			else
			{ 
				$segments = array_slice($this->uri->segment_array(), 0, $pag_segment-1);
				$pagination_config['base_url'] = site_url(implode('/', $segments).'/');
			}
		}
		else
		{
			// We always set a manual base if it is provided.
			$pagination_config['base_url'] = $pag_base;
		}

		// -------------------------------------
		// Determine Limit
		// -------------------------------------
		
		if ( ! is_numeric($limit)) {
			$limit = 0;
		}
		
		// We cannot have a negative limit
		if ($limit < 0) {
			$limit = 0;
		}

		// -------------------------------------
		// Set basic pagination data
		// -------------------------------------

		$pagination_config['total_rows'] 		= $total_rows;
		$pagination_config['per_page'] 			= $limit;

		// Add in our pagination vars
		$pagination_config = array_merge($pagination_config, $pagination_vars);

		// -------------------------------------
		// Build and return pagination
		// -------------------------------------
										
		$this->pagination->initialize($pagination_config);
		
		return $this->pagination->create_links();
	
	}

	// --------------------------------------------------------------------------	
	
	/**
	 * Delete a row
	 *
	 * @access	public
	 * @param	int
	 * @param	obj
	 * @return 	bool
	 */
	public function delete_row($row_id, $stream)
	{
		// Get the row
		$db_obj = $this->db->limit(1)->where('id', $row_id)->get($stream->stream_prefix.$stream->stream_slug);
		
		if ($db_obj->num_rows() == 0)
		{
			return false;
		}
		
		// Get the ordering count
		$row = $db_obj->row();
		$ordering_count = $row->ordering_count;

		// We need ordering count to be a number.
		if ( ! is_numeric($ordering_count) or $ordering_count < 0)
		{
			$ordering_count = 1;
		}
		
		// Delete the actual row
		$this->db->where('id', $row_id);
		
		if ( ! $this->db->delete($stream->stream_prefix.$stream->stream_slug))
		{
			return false;
		}
		else
		{
			// -------------------------------------
			// Entry Destructs
			// -------------------------------------
			// Go through the assignments and call
			// entry destruct methods
			// -------------------------------------
		
			// Get the assignments
			$assignments = $this->fields_m->get_assignments_for_stream($stream->id);
			
			// Do they have a destruct function?
			if ($assignments)
			{
				foreach ($assignments as $assign)
				{
					if (method_exists($this->type->types->{$assign->field_type}, 'entry_destruct'))
					{
						// Get the field
						$field = $this->fields_m->get_field($assign->field_id);
						$this->type->types->{$assign->field_type}->entry_destruct($row, $field, $stream);
					}
				}
			}
		
			// -------------------------------------
			// Reset reordering
			// -------------------------------------
			// We're doing this by subtracting one to
			// everthing higher than the row's
			// order count
			// -------------------------------------

			$this->db->where('ordering_count >', $ordering_count)->select('id, ordering_count');
			$ord_obj = $this->db->get($stream->stream_prefix.$stream->stream_slug);
			
			if ($ord_obj->num_rows() > 0)
			{
				$rows = $ord_obj->result();
				
				foreach ($rows as $update_row)
				{
					$update_data['ordering_count'] = $update_row->ordering_count-1;
					
					$this->db->where('id', $update_row->id);
					$this->db->update($stream->stream_prefix.$stream->stream_slug, $update_data);
					
					$update_data = array();
				}
			}

			// -------------------------------------
			// Event: Post Delete Entry
			// -------------------------------------

			$trigger_data = array(
				'entry_id'		=> $row_id,
				'stream'		=> $stream
			);

			Events::trigger('streams_post_delete_entry', $trigger_data);

			// -------------------------------------
			
			return true;
		}
	}

}
