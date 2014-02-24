<?php namespace Pyro\Module\Streams\Model;

use Pyro\Module\Streams\Entry\EntryModel;

class VariablesVariablesEntryModel extends EntryModel
{
    /**
	 * The table
	 * @type string
	 */
    protected $table = 'variables';

    /**
     * The compiled stream data as an array
     */
    protected static $streamData = array(
        'id' => 4,
        'stream_name' => 'lang:variables:name',
        'stream_slug' => 'variables',
        'stream_namespace' => 'variables',
        'stream_prefix' => null,
        'about' => 'lang:variables:description',
        'view_options' => array(
            'id',
            'created_at',
        ),
        'title_column' => 'name',
        'sorting' => 'title',
        'permissions' => 'N;',
        'hidden' => 'no',
        'menu_path' => null,
        'assignments' => array(
            array(
                'id' => 27,
                'sort_order' => 1,
                'stream_id' => 4,
                'field_id' => 27,
                'required' => 'yes',
                'unique' => 'yes',
                'instructions' => 'variables.field.name.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 27,
                    'field_name' => 'lang:streams:column_name',
                    'field_slug' => 'name',
                    'field_namespace' => 'variables',
                    'field_type' => 'slug',
                    'field_data' => array(
                        'max_length' => 100,
                    ),
                    'view_options' => null,
                    'locked' => 'no',
                    'created_at' => '2014-02-24 15:53:54',
                    'updated_at' => '2014-02-24 15:53:54',
                ),
            ),
            array(
                'id' => 28,
                'sort_order' => 2,
                'stream_id' => 4,
                'field_id' => 28,
                'required' => 'yes',
                'unique' => 'no',
                'instructions' => 'variables.field.data.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 28,
                    'field_name' => 'lang:streams:column_data',
                    'field_slug' => 'data',
                    'field_namespace' => 'variables',
                    'field_type' => 'field',
                    'field_data' => array(
                        'max_length' => 100,
                        'namespace' => 'variables',
                        'field_slug' => 'data',
                    ),
                    'view_options' => null,
                    'locked' => 'no',
                    'created_at' => '2014-02-24 15:53:54',
                    'updated_at' => '2014-02-24 15:53:54',
                ),
            ),
        ),
    );

    protected static $relationFieldsData = array(
    );

    
}