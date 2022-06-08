<?php /** @noinspection PhpFullyQualifiedNameUsageInspection */

return [

    /**
     * Specify whether the CP is enabled or not.
     */
    'cp_enabled'    => env('STREAMS_CP_ENABLED', true),

    /**
     * This is the URI  prefix
     * for the control panel.
     */
    'cp_prefix'     => env('STREAMS_CP_PREFIX', 'cp'),

    /**
     * The active theme.
     */
    'cp_theme'      => env('STREAMS_CP_THEME', 'default'),

    /*
     * Specify the CP fallback policy.
     *
     * This policy will be ran if no stream, route,
     * or component policy is otherwise specified.
     */
    'cp_policy'     => env('STREAMS_CP_POLICY'),

    /*
     * Specify the CP group middleware.
     */
    'cp_middleware' => [ 'web', 'cp' ],

    /**
     * Specify input types.
     */
    'input_types'   => [
        'text'   => \Streams\Ui\Components\Input::class,
        'hash'   => \Streams\Ui\Input\Input::class, // Default
        'input'  => \Streams\Ui\Input\Input::class,
        'string' => \Streams\Ui\Input\Input::class, // Default

        'date'     => \Streams\Ui\Input\Date::class,
        'time'     => \Streams\Ui\Input\Time::class,
        'datetime' => \Streams\Ui\Input\Datetime::class,

        'slug'  => \Streams\Ui\Input\Slug::class,
        'email' => \Streams\Ui\Input\Input::class,

        'color' => \Streams\Ui\Input\Color::class,
        'radio' => \Streams\Ui\Input\Radio::class,
        'range' => \Streams\Ui\Input\Range::class,

        'select'      => \Streams\Ui\Input\Select::class,
        'checkboxes'  => \Streams\Ui\Input\Checkboxes::class,
        'multiselect' => \Streams\Ui\Input\Multiselect::class,

        'integer' => \Streams\Ui\Input\Integer::class,
        'decimal' => \Streams\Ui\Input\Decimal::class,
        'float'   => \Streams\Ui\Input\Decimal::class,

        'textarea' => \Streams\Ui\Input\Textarea::class,
        'markdown' => \Streams\Ui\Input\Markdown::class,

        'file'  => \Streams\Ui\Input\File::class,
        'image' => \Streams\Ui\Input\Image::class,

        'relationship' => \Streams\Ui\Input\Relationship::class,

        'toggle'   => \Streams\Ui\Input\Toggle::class,
        'boolean'  => \Streams\Ui\Input\Checkbox::class, // Default
        'checkbox' => \Streams\Ui\Input\Checkbox::class,
    ],
    'components'    => [
        // 'table' => \Streams\Ui\Table\Table::class,
        'button' => \Streams\Ui\Blade\Components\ButtonComponent::class,
        // 'streams-ui-alert' => \Streams\Ui\Button\ButtonBlade::class,
        // 'ui-alert' => \Streams\Ui\Component\Components\Alert::class,
        // 'ui-toolbar' => \Streams\Ui\Component\Components\Toolbar::class,
        // 'ui-cp' => \Streams\Ui\Component\ControlPanel\ControlPanel::class,
        // 'ui-cp-topbar' => \Streams\Ui\Component\ControlPanel\ControlPanelHeader::class,
        // 'ui-cp-sidebar' => \Streams\Ui\Component\ControlPanel\ControlPanelSidebar::class
    ],
];
