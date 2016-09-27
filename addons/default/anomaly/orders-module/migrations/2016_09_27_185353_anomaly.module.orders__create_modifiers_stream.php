<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class AnomalyModuleOrdersCreateModifiersStream extends Migration
{

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'modifiers'
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [];

}
