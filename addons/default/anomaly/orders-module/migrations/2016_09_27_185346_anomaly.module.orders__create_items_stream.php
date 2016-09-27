<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class AnomalyModuleOrdersCreateItemsStream extends Migration
{

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'items'
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [];

}
