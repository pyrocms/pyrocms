<?php namespace Pyro\Module\Streams_core;

use Pyro\Support\PresenterDecorator;

class EntryPresenterDecorator extends PresenterDecorator
{
	protected $viewOptions = array();

	public function viewOptions($viewOptions = array(), $defaultFormat = null)
	{
		$this->viewOptions = $viewOptions;
		
		$this->defaultFormat = $defaultFormat;

		return $this;
	}

    /**
     * decorate an individual class
     *
     * @param mixed $atom
     * @return mixed
     */
    protected function decorateAtom($atom)
    {
    	if ( ! $this->viewOptions instanceof EntryViewOptions) {
    		$this->viewOptions = new EntryViewOptions($atom, $this->viewOptions, $this->defaultFormat);
    	}

        if ( ! isset($atom->presenterClass)) {
            return $atom;
        }

        if ($atom instanceOf BasePresenter) {
            return $atom;
        }

        $presenterClass = $atom->presenterClass;

        if ( ! class_exists($presenterClass)) {
            throw new PresenterNotFoundException($presenterClass);
        }

        if ($atom instanceOf Model) {
            $atom = $this->decorateRelations($atom);
        }

        return new $presenterClass($atom, $this->viewOptions);
    }

}