<?php namespace Anomaly\OrdersModule\Order\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class OrderTableBuilder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\OrdersModule\Order\Table
 */
class OrderTableBuilder extends TableBuilder
{

    /**
     * The table filters.
     *
     * @var array|string
     */
    protected $filters = [];

    /**
     * The table columns.
     *
     * @var array|string
     */
    protected $columns = [
        'entry.last_modified' => [
            'sort_column' => 'updated_at',
        ],
        'ip_address',
        'entry.items.quantity',
        [
            'heading' => 'module::field.status.name',
            'value'   => 'entry.status_label',
        ],
        'entry.user.display_name ?: "Guest"',
    ];

    /**
     * The table buttons.
     *
     * @var array|string
     */
    protected $buttons = [
        'edit',
    ];

    /**
     * The table actions.
     *
     * @var array|string
     */
    protected $actions = [
        'delete',
    ];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The table assets.
     *
     * @var array
     */
    protected $assets = [];

}
