<?php namespace Anomaly\TvModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

class TvModuleServiceProvider extends AddonServiceProvider
{

    protected $bindings = [
        'shows.form' => 'Anomaly\TvModule\Show\Form\ShowFormBuilder'
    ];

}
