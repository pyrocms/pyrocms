<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class AnomalyModuleTvCreateTvFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'name'        => 'text',
        'description' => 'wysiwyg',
        'category'    => [
            'type'    => 'select',
            'config' => [
                'options' => [
                    'Mystery',
                    'Documentary',
                ],
            ]
        ],
    ];

}
