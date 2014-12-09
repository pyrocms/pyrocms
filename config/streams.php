<?php

return [

    /*
	|--------------------------------------------------------------------------
	| Distribution
	|--------------------------------------------------------------------------
	|
	| This controls the primary distribution used by Streams. The Streams
    | distribution is like the DNA of the application's unique characteristics.
	|
	*/

    'distribution'      => 'streams',
    /*
	|--------------------------------------------------------------------------
	| Available Locales
	|--------------------------------------------------------------------------
	|
	| This controls the top level locales that are available to the system.
    | This will prevent from locales where no translations exist.
	|
	*/

    'available_locales' => [
        'en',
        'fr',
    ],
    /*
	|--------------------------------------------------------------------------
	| Entry Management
	|--------------------------------------------------------------------------
	*/

    'entries'           => [
        'model'      => 'Anomaly\Streams\Platform\Entry\EntryModel',
        'repository' => 'Anomaly\Streams\Platform\Entry\EntryRepository',
    ],
    /*
	|--------------------------------------------------------------------------
	| Stream Management
	|--------------------------------------------------------------------------
	*/

    'streams'           => [
        'model'      => 'Anomaly\Streams\Platform\Stream\StreamModel',
        'repository' => 'Anomaly\Streams\Platform\Stream\StreamRepository',
    ],
    /*
	|--------------------------------------------------------------------------
	| Field Management
	|--------------------------------------------------------------------------
	*/

    'fields'            => [
        'model'      => 'Anomaly\Streams\Platform\Field\FieldModel',
        'repository' => 'Anomaly\Streams\Platform\Field\FieldRepository',
    ],
    /*
	|--------------------------------------------------------------------------
	| Assignment Management
	|--------------------------------------------------------------------------
	*/

    'assignments'       => [
        'model'      => 'Anomaly\Streams\Platform\Assignment\AssignmentModel',
        'repository' => 'Anomaly\Streams\Platform\Assignment\AssignmentRepository',
    ],
    /*
	|--------------------------------------------------------------------------
	| Module Management
	|--------------------------------------------------------------------------
	*/

    'modules'           => [
        'model'      => 'Anomaly\Streams\Platform\Addon\Module\ModuleModel',
        'repository' => 'Anomaly\Streams\Platform\Addon\Module\ModuleRepository',
    ],
];