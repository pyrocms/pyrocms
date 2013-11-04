<?php
namespace Pyro\Module\Streams_core\Core\Support;

use Closure;
use Pyro\Support\AbstractCallable;

abstract class AbstractDataCp extends AbstractCallable
{

	/**
	 * Include types
	 * @var array
	 */
	protected $include_types = array();


	/**
	 * New or edit
	 * @var string
	 */
	protected $mode = null;



	/**
	 * Namespace
	 * @var strign
	 */
	protected $namespace = null;

	/**
	 * Offset
	 * @var integer
	 */
	protected $offset = null;

	/**
	 * Offset URI
	 * @var string
	 */
	protected $offset_uri = null;

	/**
	 * Order by field slug
	 * @var string
	 */
	protected $order_by = null;

	/**
	 * Pagination count
	 * @var integer
	 */
	protected $pagination = null;

	/**
	 * Pagination URI before marker
	 * @var string
	 */
	protected $pagination_uri = null;

	/**
	 * Stream
	 * @var mixed
	 */
	protected $stream = null;

	/**
	 * Stream fields
	 * @var array
	 */
	protected $stream_fields = null;

	/**
	 * Enable saving
	 * @var boolean
	 */
	protected $enable_save = true;

	/**
	 * Select
	 * @var array
	 */
	protected $select = null;


	/**
	 * Exclude these fields
	 * @var mixed
	 */
	protected $exclude = false;

	/**
	 * Exclude these field types
	 * @var array
	 */
	protected $exclude_types = array();


	/**
	 * Field slugs
	 * @var array
	 */
	protected $field_slugs = array();

	/**
	 * Field types
	 * @var array
	 */
	protected $field_types = null;

	/**
	 * ID
	 * @var mixed
	 */
	protected $id = null;


	/**
	 * Limit results
	 * @var integer
	 */
	protected $limit = 0;


	/**
	 * The model used
	 * @var object
	 */
	protected $model = null;

	/**
	 * Set the limit
	 * @param  integer $limit 
	 * @return object         
	 */
	public function limit($limit = 0)
	{
		$this->limit = $limit;

		return $this;
	}

	/**
	 * On query callback
	 * @param  function $callback 
	 * @return object           
	 */
	public function onQuery(Closure $callback = null)
	{
		$this->addCallback(__FUNCTION__, $callback);

		return $this;
	}

	/**
	 * On saved callback
	 * @param  function $callback 
	 * @return object            
	 */
	public function onSaved(Closure $callback)
	{
		$this->addCallback(__FUNCTION__, $callback);

		return $this;
	}

	/**
	 * On saving callback
	 * @param  function $callback 
	 * @return object            
	 */
	public function onSaving(Closure $callback)
	{
		$this->addCallback(__FUNCTION__, $callback);

		return $this;
	}

	/**
	 * Set order direction
	 * @param  string $direction 
	 * @return object            
	 */
	public function orderDirection($direction = 'asc')
	{
		$this->direction = $direction;

		return $this;
	}

	/**
	 * Set order by
	 * @param  string $column 
	 * @return object         
	 */
	public function orderBy($column = null)
	{
		$this->order_by = $column;

		return $this;
	}

	/**
	 * Set defaults
	 * @param  array  $defaults 
	 * @return object           
	 */
	public function defaults(array $defaults = array())
	{
		$this->defaults = $defaults;

		return $this;
	}

/**
	 * Filters
	 * @param  array  $filters
	 * @return object
	 */
	public function filters(array $filters = array())
	{
		$this->filters = $filters;

		return $this;
	}

	/**
	 * Set pagination config
	 * @param  [type] $pagination     [description]
	 * @param  [type] $pagination_uri [description]
	 * @return [type]                 [description]
	 */
	public function pagination($limit = null, $pagination_uri = null)
	{
		$this->limit = $limit;
		$this->pagination_uri = $pagination_uri;
		
		// -------------------------------------
		// Find offset URI from array
		// -------------------------------------

		if (is_numeric($this->limit))
		{
			$segs = explode('/', $this->pagination_uri);
			$this->offset_uri = count($segs)+1;

			$this->offset = ci()->input->get('page');

			// Calculate actual offset if not first page
			if ( $this->offset > 0 )
			{
				$this->offset = ($this->offset - 1) * $this->limit;
			}
		}
		else
		{
			$this->offset_uri = null;
			$this->offset = 0;
		}

		return $this;
	}

	/**
	 * Set skipped fields
	 * @param  array  $skips 
	 * @return object        
	 */
	public function skips(array $skips = array())
	{
		$this->skips = $skips;

		return $this;
	}


/**
	 * Set enable saving
	 * @param  boolean $enable_saving 
	 * @return object               
	 */
	public function enableSave($enable_save = false)
	{
		$this->enable_save = $enable_save;

		return $this;
	}

	/**
	 * Set excluded types
	 * @param  array  $exclude_types 
	 * @return object
	 */
	public function excludeTypes(array $exclude_types = array())
	{
		$this->exclude_types = $exclude_types;

		return $this;
	}

	/**
	 * Set included types
	 * @param  array  $include_types 
	 * @return object                
	 */
	public function includeTypes(array $include_types = array())
	{
		$this->include_types = $include_types;

		return $this;
	}

	public function select($select = null)
	{
		$this->select = $select;

		return $this;
	}

	/**
	 * Set fields
	 * @param  string  $columns
	 * @param  boolean $exclude
	 * @return object           
	 */
	public function fields($view_options = '*', $exclude = false)
	{		
		$this->data->view_options = is_string($view_options) ? array($view_options) : $view_options;
		$this->exclude = $exclude;

		return $this;
	}

	protected function mergeData($data = array())
	{
		$this->data = (object) array_merge((array) $this->data, (array) $data);
	}

	/**
	 * Dynamically get variables from the data object
	 * @param  string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		if (isset($this->data->{$name}))
		{
			return $this->data->{$name};
		}

		return null;
	}

}
