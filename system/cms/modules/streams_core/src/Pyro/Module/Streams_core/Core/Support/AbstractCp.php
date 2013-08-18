<?php
namespace Pyro\Module\Streams_core\Core\Support;

use Closure;
use Pyro\Module\Streams_core\Core\Model;

abstract class AbstractCp
{
	protected static $instance;

	protected $query = null;

	protected $data = array();

	protected $render = null;

	protected $pagination = null;

	protected $pagination_uri = null;

	protected $offset = null;

	protected $offset_uri = null;

	protected $stream = null;

	protected $columns = array('*');

	protected $buttons = array();

	protected $title = null;

	protected $exclude = false;

	protected $form = null;

	protected $defaults = array();

	protected $return = null;

	public function query(Closure $callback = null)
	{
		$this->model = call_user_func($callback, $this->model);

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

	public function columns($columns = '*', $exclude = false)
	{
		$columns = is_string($columns) ? array($columns) : $columns;
		
		$this->columns = $columns;
		$this->exclude = $exclude;

		return $this;
	}

	public function buttons(array $buttons = array())
	{
		$this->buttons = $buttons;

		return $this;
	}

	public function title($title = null)
	{
		ci()->template->title(lang_label($title));

		$this->title;

		return $this;
	}

	public function tabs(array $tabs = array())
	{
		$this->tabs = $tabs;

		return $this;
	}

	public static function hidden(array $hidden = array())
	{
		$this->hidden = $hidden;

		return $this;
	}

	public static function defaults(array $defaults = array())
	{
		$this->defaults = $defaults;

		return $this;
	}

	public function redirect($return = null)
	{
		$this->return = $return;

		return $this;
	}

	public function render()
	{
		$method = camel_case('render'.$this->render);

		if (method_exists($this, $method))
		{
			return $this->{$method}();
		}

		return false;
	}

}