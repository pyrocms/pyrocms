<?php
namespace Pyro\Module\Streams_core\Core\Support;

use Closure;
use Pyro\Module\Streams_core\Core\Model;

abstract class AbstractCp extends AbstractSupport
{

	protected $add_uri = null;

	protected $buttons = array();

	protected $columns = array('*');

	protected $data = array();

	protected $defaults = array();

	protected $entry = null;

	protected $exclude = false;

	protected $exclude_types = null;

	protected $fields = null;

	protected $field_names = array();

	protected $field_slugs = array();

	protected $form = null;

	protected $form_fields = null;

	protected $form_wrapper = true;

	protected $hidden = array();

	protected $include_types = null;

	protected $id = null;

	protected static $instance;

	protected $mode = null;

	protected $model = null;

	protected $namespace = null;

	protected $no_fields_message = null;

	protected $offset = null;

	protected $offset_uri = null;

	protected $pagination = null;

	protected $pagination_uri = null;

	protected $render = null;

	protected $return = null;

	protected $standard_columns = array();

	protected $skips = null;

	protected $stream = null;

	protected $stream_fields = null;

	protected $tabs = array();

	protected $title = null;

	protected $view_override = true;

	public function addUri($add_uri = null)
	{
		$this->add_uri = $add_uri;

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

	public function fields($columns = '*', $exclude = false)
	{
		$columns = is_string($columns) ? array($columns) : $columns;
		
		$this->columns = $columns;
		$this->exclude = $exclude;

		return $this;
	}

	public static function hidden(array $hidden = array())
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

	public function query(Closure $callback = null)
	{
		$this->model = call_user_func($callback, $this->model);

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

}