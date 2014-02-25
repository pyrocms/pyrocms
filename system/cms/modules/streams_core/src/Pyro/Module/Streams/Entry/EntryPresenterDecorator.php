<?php namespace Pyro\Module\Streams\Entry;

use Pyro\Support\PresenterDecorator;

class EntryPresenterDecorator extends PresenterDecorator
{
    protected $entryViewOptions;

    public function setViewOptions(EntryViewOptions $entryViewOptions)
    {
        $this->entryViewOptions = $entryViewOptions;

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
        if ( ! $atom->getPresenterClass()) {
            return $atom;
        }

        if ($atom instanceOf BasePresenter) {
            return $atom;
        }

        $presenterClass = $atom->getPresenterClass();

        if ( ! class_exists($presenterClass)) {
            throw new PresenterNotFoundException($presenterClass);
        }

        if ($atom instanceOf Model) {
            $atom = $this->decorateRelations($atom);
        }

        return new $presenterClass($atom, $this->entryViewOptions);
    }
}
