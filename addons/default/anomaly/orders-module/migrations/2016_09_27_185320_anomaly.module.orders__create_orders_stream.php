<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class AnomalyModuleOrdersCreateOrdersStream extends Migration
{

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'orders'
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [];

}
