<?php namespace Pyro\Module\Streams\Model;

use Pyro\Module\Streams\Entry\EntryModel;

class BlogsBlogEntryModel extends EntryModel
{
    /**
	 * The table
	 * @type string
	 */
    protected $table = 'blog';

    /**
     * The compiled stream data as an array
     */
    protected static $streamData = array(
        'id' => 1,
        'stream_name' => 'lang:blog:blog_title',
        'stream_slug' => 'blog',
        'stream_namespace' => 'blogs',
        'stream_prefix' => null,
        'about' => null,
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
                'id' => 1,
                'sort_order' => 1,
                'stream_id' => 1,
                'field_id' => 1,
                'required' => 'yes',
                'unique' => 'no',
                'instructions' => 'blogs.field.title.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 1,
                    'field_name' => 'lang:blog:title_label',
                    'field_slug' => 'title',
                    'field_namespace' => 'blogs',
                    'field_type' => 'text',
                    'field_data' => null,
                    'view_options' => null,
                    'locked' => 'yes',
                    'created_at' => '2014-02-24 15:53:52',
                    'updated_at' => '2014-02-24 15:53:52',
                ),
            ),
            array(
                'id' => 2,
                'sort_order' => 2,
                'stream_id' => 1,
                'field_id' => 2,
                'required' => 'yes',
                'unique' => 'no',
                'instructions' => 'blogs.field.intro.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 2,
                    'field_name' => 'lang:blog:intro_label',
                    'field_slug' => 'intro',
                    'field_namespace' => 'blogs',
                    'field_type' => 'wysiwyg',
                    'field_data' => array(
                        'editor_type' => 'simple',
                        'allow_tags' => 'y',
                    ),
                    'view_options' => null,
                    'locked' => 'yes',
                    'created_at' => '2014-02-24 15:53:52',
                    'updated_at' => '2014-02-24 15:53:52',
                ),
            ),
            array(
                'id' => 3,
                'sort_order' => 3,
                'stream_id' => 1,
                'field_id' => 3,
                'required' => 'yes',
                'unique' => 'yes',
                'instructions' => 'blogs.field.slug.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 3,
                    'field_name' => 'lang:global:slug',
                    'field_slug' => 'slug',
                    'field_namespace' => 'blogs',
                    'field_type' => 'slug',
                    'field_data' => array(
                        'slug_field' => 'title',
                    ),
                    'view_options' => null,
                    'locked' => 'yes',
                    'created_at' => '2014-02-24 15:53:53',
                    'updated_at' => '2014-02-24 15:53:53',
                ),
            ),
            array(
                'id' => 4,
                'sort_order' => 4,
                'stream_id' => 1,
                'field_id' => 4,
                'required' => 'yes',
                'unique' => 'no',
                'instructions' => 'blogs.field.body.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 4,
                    'field_name' => 'lang:global:body',
                    'field_slug' => 'body',
                    'field_namespace' => 'blogs',
                    'field_type' => 'wysiwyg',
                    'field_data' => array(
                        'editor_type' => 'advanced',
                    ),
                    'view_options' => null,
                    'locked' => 'yes',
                    'created_at' => '2014-02-24 15:53:53',
                    'updated_at' => '2014-02-24 15:53:53',
                ),
            ),
            array(
                'id' => 5,
                'sort_order' => 5,
                'stream_id' => 1,
                'field_id' => 5,
                'required' => 'no',
                'unique' => 'no',
                'instructions' => 'blogs.field.keywords.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 5,
                    'field_name' => 'lang:streams:keywords.name',
                    'field_slug' => 'keywords',
                    'field_namespace' => 'blogs',
                    'field_type' => 'keywords',
                    'field_data' => null,
                    'view_options' => null,
                    'locked' => 'no',
                    'created_at' => '2014-02-24 15:53:53',
                    'updated_at' => '2014-02-24 15:53:53',
                ),
            ),
            array(
                'id' => 6,
                'sort_order' => 6,
                'stream_id' => 1,
                'field_id' => 6,
                'required' => 'yes',
                'unique' => 'no',
                'instructions' => 'blogs.field.author.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 6,
                    'field_name' => 'lang:blog:author_label',
                    'field_slug' => 'author',
                    'field_namespace' => 'blogs',
                    'field_type' => 'user',
                    'field_data' => null,
                    'view_options' => null,
                    'locked' => 'yes',
                    'created_at' => '2014-02-24 15:53:53',
                    'updated_at' => '2014-02-24 15:53:53',
                ),
            ),
            array(
                'id' => 7,
                'sort_order' => 7,
                'stream_id' => 1,
                'field_id' => 7,
                'required' => 'no',
                'unique' => 'no',
                'instructions' => 'blogs.field.comments_enabled.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 7,
                    'field_name' => 'lang:blog:comments_enabled',
                    'field_slug' => 'comments_enabled',
                    'field_namespace' => 'blogs',
                    'field_type' => 'choice',
                    'field_data' => array(
                        'choice_data' => 'no : lang:global:no
1 day : lang:global:duration:1-day
1 week : lang:global:duration:1-week
2 weeks : lang:global:duration:2-weeks
1 month : lang:global:duration:1-month
3 months : lang:global:duration:3-months
always : lang:global:duration:always
',
                    ),
                    'view_options' => null,
                    'locked' => 'yes',
                    'created_at' => '2014-02-24 15:53:53',
                    'updated_at' => '2014-02-24 15:53:53',
                ),
            ),
            array(
                'id' => 8,
                'sort_order' => 8,
                'stream_id' => 1,
                'field_id' => 8,
                'required' => 'no',
                'unique' => 'no',
                'instructions' => 'blogs.field.status.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 8,
                    'field_name' => 'lang:blog:status_label',
                    'field_slug' => 'status',
                    'field_namespace' => 'blogs',
                    'field_type' => 'choice',
                    'field_data' => array(
                        'choice_data' => 'draft : lang:blog:draft_label
live : lang:blog:live_label
',
                    ),
                    'view_options' => null,
                    'locked' => 'yes',
                    'created_at' => '2014-02-24 15:53:53',
                    'updated_at' => '2014-02-24 15:53:53',
                ),
            ),
            array(
                'id' => 9,
                'sort_order' => 9,
                'stream_id' => 1,
                'field_id' => 9,
                'required' => 'no',
                'unique' => 'no',
                'instructions' => 'blogs.field.preview_hash.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 9,
                    'field_name' => 'lang:blog:preview_hash',
                    'field_slug' => 'preview_hash',
                    'field_namespace' => 'blogs',
                    'field_type' => 'text',
                    'field_data' => null,
                    'view_options' => null,
                    'locked' => 'yes',
                    'created_at' => '2014-02-24 15:53:53',
                    'updated_at' => '2014-02-24 15:53:53',
                ),
            ),
            array(
                'id' => 10,
                'sort_order' => 10,
                'stream_id' => 1,
                'field_id' => 10,
                'required' => 'yes',
                'unique' => 'no',
                'instructions' => 'blogs.field.category.instructions',
                'field_name' => null,
                'field' => array(
                    'id' => 10,
                    'field_name' => 'lang:blog:category_label',
                    'field_slug' => 'category',
                    'field_namespace' => 'blogs',
                    'field_type' => 'relationship',
                    'field_data' => array(
                        'title_field' => 'title',
                        'relation_class' => 'Pyro\\Module\\Blog\\BlogCategoryModel',
                    ),
                    'view_options' => null,
                    'locked' => 'yes',
                    'created_at' => '2014-02-24 15:53:53',
                    'updated_at' => '2014-02-24 15:53:53',
                ),
            ),
        ),
    );

    protected static $relationFieldsData = array(
        'author' => array(
            'method' => 'belongsTo',
            'related' => 'Pyro\Module\Users\Model\User',
            'foreignKey' => 'author',
        ),
        'category' => array(
            'method' => 'belongsTo',
            'related' => 'Pyro\Module\Blog\BlogCategoryModel',
            'foreignKey' => 'category',
        ),
    );

    
    public function author()
    {
        return $this->belongsTo('Pyro\Module\Users\Model\User');
    }

    public function category()
    {
        return $this->belongsTo('Pyro\Module\Blog\BlogCategoryModel');
    }

}