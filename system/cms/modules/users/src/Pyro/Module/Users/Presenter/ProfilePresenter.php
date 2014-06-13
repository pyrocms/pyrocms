<?php namespace Pyro\Module\Users\Presenter;

use Pyro\Module\Streams\Entry\EntryPresenter;

class ProfilePresenter extends EntryPresenter
{
    protected $appends = array(
        'isActivatedLang',
        'createdByUser',
        'linkEdit',
        'linkDetails',
    );

    public function isActivatedLang()
    {
        if ($this->resource->user->is_activated) {
            return lang('global:yes');
        } else {
            return lang('global:no');
        }
    }
}