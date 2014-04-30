<?php namespace Pyro\Module\Users\Presenter;

class ProfileEntryPresenter extends ProfilePresenterAbstract
{

    /**
     * is_activated
     *
     * @return string
     */
    public function userIsActivated()
    {

        if($this->resource->user->is_activated == 1){
            return '<i class="c-green fa fa-check-circle"></i>';
        } else {
            return '<i class="c-red fa fa-ban"></i>';
        }

    }



    /**
     * is_blocked
     *
     * @return string
     */
    public function userIsBlocked()
    {

        if($this->resource->user->is_blocked == 1){
            return '<i class="c-red fa fa-ban"></i>';
        } else {
            return '<i class="c-green fa fa-check-circle"></i>';
        }

    }
}
