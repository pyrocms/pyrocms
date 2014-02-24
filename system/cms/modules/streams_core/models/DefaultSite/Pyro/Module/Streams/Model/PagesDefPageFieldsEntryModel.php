<?php namespace Pyro\Module\Streams\Model;

use Pyro\Module\Streams\Entry\EntryModel;

class PagesDefPageFieldsEntryModel extends EntryModel
{
    /**
	 * The table
	 * @type string
	 */
    protected $table = 'def_page_fields';

    /**
     * The compiled stream data as an array
     */
    protected static $streamData = array(
        'id' => 2,
        'stream_name' => 'Default',
        'stream_slug' => 'def_page_fields',
        'stream_namespace' => 'pages',
        'stream_prefix' => null,
        'about' => 'A basic page type to get you started adding content.',
        'view_options' => array(
            'id',
            'created_at',
        ),
        'title_column' => null,
        'sorting' => 'title',
        'permissions' => 'N;',
        'hidden' => 'no',
        'menu_path' => null,
        'assignments' => array(
            array(
                'id' => 11,
                'sort_order' => 1,
                'stream_id' => 2,
                'field_id' => 11,
                'required' => 'no',
                'unique' => 'no',
                'instructions' => 'pages.field.body.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 11,
                    'field_name' => 'lang:pages:body_label',
                    'field_slug' => 'body',
                    'field_namespace' => 'pages',
                    'field_type' => 'wysiwyg',
                    'field_data' => array(
                        'editor_type' => 'advanced',
                        'allow_tags' => 'y',
                    ),
                    'view_options' => null,
                    'locked' => 'no',
                    'created_at' => '2014-02-24 15:53:53',
                    'updated_at' => '2014-02-24 15:53:53',
                ),
            ),
        ),
    );

    protected static $relationFieldsData = array(
    );

    
}