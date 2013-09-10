<?php
namespace Pyro\Module\Streams_core\Core\Support;

use Closure;
use Pyro\Module\Streams_core\Core\Model;

abstract class AbstractCp extends AbstractSupport
{
	protected $add_uri = null;

	protected $allow_title_column_set = false;

	protected $buttons = array();

	protected $cancel_uri = null;

	protected $columns = array('*');

	protected $current_field_type = null;

	protected $data = null;

	protected $defaults = array();

	protected $direction = 'asc';

	protected $entry = null;

	protected $exclude = false;

	protected $exclude_types = array();

	protected $failure_message = null;

	protected $fields = null;

	protected $field_names = array();

	protected $field_slugs = array();

	protected $field_types = null;

	protected $form = null;

	protected $form_fields = null;

	protected $form_wrapper = true;

	protected $hidden = array();

	protected $include_types = array();

	protected $id = null;

	protected static $instance;

	protected $limit = 0;

	protected $mode = null;

	protected $model = null;

	protected $namespace = null;

	protected $no_fields_message = null;

	protected $offset = null;

	protected $offset_uri = null;

	protected $order_by = null;

	protected $pagination = null;

	protected $pagination_uri = null;

	protected $render = null;

	protected $return = null;

	protected $show_cancel = array();

	protected $skips = array();

	protected $standard_columns = array();

	protected $stream = null;

	protected $stream_fields = null;

	protected $success_message = null;

	protected $tabs = array();

	protected $title = null;

	protected $view_override = true;

	protected $enable_post = true;

	public function __construct()
	{
		parent::__construct();
		
		$this->data = new \stdClass;
	}

	public function addUri($add_uri = null)
	{
		$this->add_uri = $add_uri;

		return $this;
	}	

	public function allowSetColumnTitle($allow_title_column_set = false)
	{
		$this->allow_title_column_set = $allow_title_column_set;

		return $this;
	}	

	public function cancelUri($cancel_uri = null)
	{
		$this->cancel_uri = $cancel_uri;

		return $this;
	}	

	public function buttons(array $buttons = array())
	{
		$this->buttons = $buttons;

		return $this;
	}

	public function defaults(array $defaults = array())
	{
		$this->defaults = $defaults;

		return $this;
	}

	public function excludeTypes(array $exclude_types = array())
	{
		$this->exclude_types = $exclude_types;

		return $this;
	}

	public function includeTypes(array $include_types = array())
	{
		$this->include_types = $include_types;

		return $this;
	}

	public function fields($columns = '*', $exclude = false)
	{
		$columns = is_string($columns) ? array($columns) : $columns;
		
		$this->columns = $columns;
		$this->exclude = $exclude;

		return $this;
	}

	public function hidden(array $hidden = array())
	{
		$this->hidden = $hidden;

		return $this;
	}

	protected static function instance($render = null)
	{
		$instance = new static;

		$instance->render = $render;

		return $instance;
	}

	public function limit($limit = 0)
	{
		$this->limit = $limit;

		return $this;
	}

	public function orderDirection($direction = 'asc')
	{
		$this->direction = $direction;

		return $this;
	}

	public function orderBy($column = null)
	{
		$this->order_by = $column;

		return $this;
	}

	public function pagination($pagination = null, $pagination_uri = null)
	{
		$this->pagination = $pagination;
		$this->pagination_uri = $pagination_uri;
		
		// -------------------------------------
		// Find offset URI from array
		// -------------------------------------

		if (is_numeric($this->pagination))
		{
			$segs = explode('/', $this->pagination_uri);
			$this->offset_uri = count($segs)+1;

				$this->offset = ci()->uri->segment($this->offset_uri, 0);

			// Calculate actual offset if not first page
			if ( $offset > 0 )
			{
				$this->offset = ($offset - 1) * $this->pagination;
			}
		}
		else
		{
			$this->offset_uri = null;
			$this->offset = 0;
		}
	
		return $this;
	}

	public function redirect($return = null)
	{
		$this->return = $return;

		return $this;
	}

	public function render($return = false)
	{
		$method = camel_case('render'.$this->render);

		if (method_exists($this, $method))
		{
			return $this->{$method}($return);
		}

		return false;
	}

	public function onQuery(Closure $callback = null)
	{
		$this->addCallback(__FUNCTION__, $callback);

		return $this;
	}

	public function onSaved(Closure $callback)
	{
		$this->addCallback(__FUNCTION__, $callback);

		return $this;
	}

	public function onSaving(Closure $callback)
	{
		$this->addCallback(__FUNCTION__, $callback);

		return $this;
	}

	public function skips(array $skips = array())
	{
		$this->skips = $skips;

		return $this;
	}

	public function successMessage($success_message = null)
	{
		$this->success_message = $success_message;

		return $this;
	}

	public function failureMessage($failure_message = null)
	{
		$this->failure_message = $failure_message;

		return $this;
	}

	public function tabs(array $tabs = array())
	{
		$this->tabs = $tabs;

		return $this;
	}

	public function title($title = null)
	{
		ci()->template->title(lang_label($title));

		$this->title;

		return $this;
	}

	public function enablePost($enable_post = false)
	{
		$this->enable_post = $enable_post;

		return $this;
	}

	public function viewOverride($view_override = true)
	{
		$this->view_override = $view_override;

		return $this;
	}

}