<?php namespace Pyro\View;

use Pyro\Support\AbstractCallable;
use Illuminate\Html\HtmlBuilder as Html;

class Ui extends AbstractCallable
{
	public function buttons()
	{
		$instance = static::instance(__FUNCTION__);

		// Do shit with the class
		//$html = new Html;

		// initialize vars
	}

	public function renderButtons()
	{
		// load view
		// render buttons
	}

	public function menu()
	{

	}

	public function search()
	{

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
			return $this->{$method}($return);
		}

		return false;
	}
}