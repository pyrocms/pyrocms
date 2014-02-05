<?php namespace Pyro\Module\Streams_core;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Pyro\Module\Users\Model\User;
use Pyro\Support\Presenter;

class EntryPresenter extends Presenter
{
	protected $entryViewOptions;

	public function __construct(EntryModel $model, EntryViewOptions $entryViewOptions)
	{
		$this->resource = $model;

		$this->entryViewOptions = $entryViewOptions;
	}

    /**
     * String output
     * @param  string
     * @return string
     */
    protected function getStringOutput($key = null)
    {
    	$template = null;

        if ($viewOption = $this->entryViewOptions->getBySlug($key)) {
            $template = $viewOption->getTemplate();
        }

        $value = $this->resource->getAttribute($key);

        if ($template) {

            return ci()->parser->parse_string($template, array('entry' => $this->resource), true, false, array(
                'stream' => $this->resource->getStreamSlug(),
                'namespace' => $this->resource->getStreamNamespace()
            ));

        } elseif ($type = $this->resource->getFieldType($key)) {

            return $type->stringOutput();

        } elseif ($this->isDate($value)) {

            return $this->getDateOutput($value);
        
        } elseif ($this->isUser($value)) {

            return $this->getUserOutput($value);
        
        } 

        return $value;
    }

    protected function isUser($value = null)
    {
    	return $value instanceof User;
    }

    protected function isDate($value = null)
    {
    	return $value instanceof Carbon;
    }

    protected function getUserOutput($value)
    {
    	return ci()->parser->parse_string('<a href="admin/users/edit/{{ id }}">{{ username }}</a>', $value, true);
    }

    protected function getDateOutput($value)
    {
    	return $value->format(\Settings::get('date_format'));
    }

	/**
     * Magic Method access initially tries for local methods then, defers to
     * the decorated object.
     */
    public function __get($key)
    {
    	$viewOption = $this->entryViewOptions->getBySlug($key);

        if ($viewOption and $callback = $viewOption->getCallback()) {

            return call_user_func($callback, $this->resource);

        } elseif ($viewOption and $format = $viewOption->getFormat()) {

        	$fieldTypeMethod = Str::studly($format).'Output';

        	$method = 'get'.$fieldTypeMethod;

        	if (method_exists($this, $method)) {
        		return $this->{$method}($key);
        	}

			if ($fieldType = $this->resource->getFieldType($key)) {
				return $fieldType->{$fieldTypeMethod}();
			} 
        }

        $method = Str::camel($key);

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        return $this->resource->$key;
    }
}