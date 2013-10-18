<?php
namespace Pyro\Module\Streams_core\Core\Support;

use Closure;
use Pyro\Module\Streams_core\Core\Model;
use Pyro\Support\AbstractCallable;

abstract class AbstractCp extends AbstractCallable
{
	/**
	 * Add URI
	 * @var string
	 */
	protected $add_uri = null;

	/**
	 * Allow title column to be set
	 * @var boolean
	 */
	protected $allow_title_column_set = false;

	/**
	 * Simple filter configuration
	 * @var array
	 */
	protected $filters = array();

	/**
	 * Button configuration
	 * @var array
	 */
	protected $buttons = array();

	/**
	 * Cancel URI
	 * @var string
	 */
	protected $cancel_uri = null;

	/**
	 * Columns
	 * @var array
	 */
	protected $columns = array('*');

	/**
	 * Current field type
	 * @var string
	 */
	protected $current_field_type = null;

	/**
	 * Data
	 * @var array
	 */
	protected $data = null;

	/**
	 * Defaults
	 * @var array
	 */
	protected $defaults = array();

	/**
	 * Sort direction
	 * @var string
	 */
	protected $direction = 'asc';

	/**
	 * The entry
	 * @var object
	 */
	protected $entry = null;

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
	 * Failure message
	 * @var string
	 */
	protected $failure_message = null;

	/**
	 * Fields
	 * @var array
	 */
	protected $fields = null;

	/**
	 * Field names
	 * @var array
	 */
	protected $field_names = array();

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
	 * Form
	 * @var string
	 */
	protected $form = null;

	/**
	 * Form fields
	 * @var array
	 */
	protected $form_fields = null;

	/**
	 * Form wrapper
	 * @var boolean
	 */
	protected $form_wrapper = true;

	/**
	 * Headers
	 * @var array
	 */
	protected $headers = null;

	/**
	 * Hidden fields by slug
	 * @var array
	 */
	protected $hidden = array();

	/**
	 * Include types
	 * @var array
	 */
	protected $include_types = array();

	/**
	 * ID
	 * @var mixed
	 */
	protected $id = null;

	/**
	 * The instance
	 * @var object
	 */
	protected static $instance;

	/**
	 * Limit results
	 * @var integer
	 */
	protected $limit = 0;

	/**
	 * New or edit
	 * @var string
	 */
	protected $mode = null;

	/**
	 * The model used
	 * @var object
	 */
	protected $model = null;

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
	 * Render
	 * @var boolean
	 */
	protected $render = null;

	/**
	 * Redirect url
	 * @var string
	 */
	protected $redirect = null;

	/**
	 * Show cancel button
	 * @var array
	 */
	protected $show_cancel = array();

	/**
	 * Skip these fields
	 * @var array
	 */
	protected $skips = array();

	/**
	 * Standard columns
	 * @var array
	 */
	protected $standard_columns = array();

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
	 * Success message
	 * @var string
	 */
	protected $success_message = null;

	/**
	 * Tab configuration
	 * @var array
	 */
	protected $tabs = array();

	/**
	 * Title
	 * @var string
	 */
	protected $title = null;

	/**
	 * View
	 * @var string
	 */
	protected $view = null;

	/**
	 * View wrapper
	 * @var string
	 */
	protected $view_wrapper = null;

	/**
	 * Override view
	 * @var boolean
	 */
	protected $view_override = false;

	/**
	 * Enable saving
	 * @var boolean
	 */
	protected $enable_save = true;

	/**
	 * Select
	 * @var array
	 */
	protected $select = array('*');

	/**
	 * Construct and bring in assets
	 */
	public function __construct()
	{
		ci()->load->language('streams_core/pyrostreams');
		ci()->load->config('streams_core/streams');

		// Load the language file
		if (is_dir(APPPATH.'libraries/Streams')) {
			ci()->lang->load('streams_api', 'english', false, true, APPPATH.'libraries/Streams/');
		}

		$this->data = new \stdClass;
	}

	/**
	 * Add URI
	 * @param string $add_uri
	 * @return object
	 */
	public function addUri($add_uri = null)
	{
		$this->add_uri = $add_uri;

		return $this;
	}	

	/**
	 * Allow to set column title
	 * @param  boolean $allow_title_column_set
	 * @return object
	 */
	public function allowSetColumnTitle($allow_title_column_set = false)
	{
		$this->allow_title_column_set = $allow_title_column_set;

		return $this;
	}	

	/**
	 * Set the cancel URI
	 * @param  string $cancel_uri
	 * @return object
	 */
	public function cancelUri($cancel_uri = null)
	{
		$this->cancel_uri = $cancel_uri;

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
	 * Is subclass of Entry
	 * @param  string  $subclass 
	 * @param  string  $class
	 * @return boolean
	 */
	public function isSubclassOfEntry($subclass, $class = 'Pyro\Module\Streams_core\Core\Model\Entry')
	{
		if ( ! is_string($subclass)) return false;

		if ( ! class_exists($subclass)) return false;

		$reflection = new \ReflectionClass($subclass);

		return $reflection->isSubclassOf($class);
	}

	/**
	 * Buttons
	 * @param  array  $buttons
	 * @return object
	 */
	public function buttons(array $buttons = array())
	{
		$this->buttons = $buttons;

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

	public function disableFormOpen($disable_form_open = true)
	{
		$this->data->disable_form_open = $disable_form_open;

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

	/**
	 * Set fields
	 * @param  string  $columns
	 * @param  boolean $exclude
	 * @return object           
	 */
	public function fields($columns = '*', $exclude = false)
	{		
		$this->columns = is_string($columns) ? array($columns) : $columns;
		$this->exclude = $exclude;

		return $this;
	}

	/**
	 * Get pagination
	 * @param  integer $total_records The total records
	 * @return array                The pagination array
	 */
	protected function getPagination($total_records = null)
	{
		$pagination = create_pagination(
			$this->pagination_uri,
			$total_records,
			$this->limit, // Limit per page
			$this->offset_uri // URI segment
		);

		$pagination['links'] = str_replace('-1', '1', $pagination['links']);

		return $pagination;
	}

	/**
	 * Set hidden fields
	 * @param  array  $hidden 
	 * @return object         
	 */
	public function hidden(array $hidden = array())
	{
		$this->hidden = $hidden;

		return $this;
	}

	/**
	 * Get the instance
	 * @param  boolean $render 
	 * @return object         
	 */
	protected static function instance($render = null)
	{
		$instance = new static;

		$instance->render = $render;

		return $instance;
	}

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

			$this->offset = ci()->uri->segment($this->offset_uri, 0);

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
	 * Set return URI
	 * @param  string $return 
	 * @return object         
	 */
	public function redirect($redirect = null)
	{
		$this->data->redirect = $redirect;

		return $this;
	}

	/**
	 * Set render
	 * @param  boolean $return 
	 * @return object          
	 */
	public function render($return = false)
	{
		$method = camel_case('render'.$this->render);

		if (method_exists($this, $method))
		{
			$this->{$method}();
		}

		if ($return) return $this->data->content;
		
		ci()->template->build($this->view_wrapper ?: 'admin/partials/blank_section', $this->data);
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
	 * Set success message
	 * @param  string $success_message 
	 * @return object                  
	 */
	public function successMessage($success_message = null)
	{
		$this->success_message = $success_message;

		return $this;
	}

	/**
	 * Set failure message
	 * @param  string $failure_message 
	 * @return object                  
	 */
	public function failureMessage($failure_message = null)
	{
		$this->failure_message = $failure_message;

		return $this;
	}

	public function noEntriesMessage($no_entries_message = null)
	{
		$instance->data->no_entries_message = $no_entries_message;
	}

	public function noFieldsMessage($no_fields_message = null)
	{
		$this->data->no_fields_message = $no_fields_message;
	}

	/**
	 * Set tab configuration
	 * @param  array  $tabs 
	 * @return object       
	 */
	public function tabs(array $tabs = array())
	{
		$this->tabs = $tabs;

		return $this;
	}

	/**
	 * Set title
	 * @param  string $title 
	 * @return object        
	 */
	public function title($title = null)
	{
		ci()->template->title(lang_label($title));

		$this->title = $title;

		return $this;
	}

	/**
	 * View
	 * @param  string $view [description]
	 * @return [type]       [description]
	 */
	public function view($view = null, $data = array())
	{
		$this->view = $view;
		$this->mergeData($data);

		return $this;
	}

	/**
	 * View wrapper
	 * @param  string $view_wrapper
	 * @param  array  $data
	 * @return object
	 */
	public function viewWrapper($view_wrapper = null, $data = array())
	{
		$this->view_wrapper = $view_wrapper;
		$this->mergeData($data);

		return $this;
	}

	/**
	 * Set view override option
	 * @param  boolean $view_override 
	 * @return object                 
	 */
	public function viewOverride($view_override = false)
	{
		$this->view_override = $view_override;

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

	/**
	 * Render the object when treated as a string
	 * @return string [description]
	 */
	public function __toString()
	{
		return $this->render(true);
	}
}
