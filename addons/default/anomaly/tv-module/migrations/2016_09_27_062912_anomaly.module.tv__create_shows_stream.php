<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class AnomalyModuleTvCreateShowsStream extends Migration
{

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'shows',
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'name',
        'description',
        'category',
    ];

}
