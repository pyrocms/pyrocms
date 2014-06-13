<?php namespace Pyro\Module\Blog;

use Pyro\Module\Streams\Ui\EntryUi;

class BlogEntryUi extends EntryUi
{

    public function boot()
    {
        parent::boot();

        ci()->lang->load(array('blog', 'categories'));

        // Filters to display on our table
        $this
            ->filters(
                array(
                    'title',
                    'status',
                )
            )
            // Fields to display in our table
            ->fields(
                array(
                    'title',
                    'category'        => array(
                        'name'     => lang('blog:category_label'),
                        'template' => '{{ entry:category:title }}',
                    ),
                    'created_at',
                    'status',
                    'created_by_user' => array( // @todo - this should be an editable field
                        'name' => 'Written By', // @todo - language
                    ),
                )
            )
            // Buttons to display in our table
            ->buttons(
                array(
                    array(
                        'url'   => '{{ url }}',
                        'label' => lang('global:view')
                    ),
                    array(
                        'url'    => 'admin/blog/edit/{{ id }}',
                        'label'  => lang('global:edit')
                    ),
                    array(
                        'url'     => 'admin/blog/delete/{{ id }}',
                        'label'   => lang('global:delete'),
                        'confirm' => true
                    )
                )
            )
            // Tab structure for our form
            ->tabs(
                array(
                    array(
                        'title'  => lang('blog:content_label'),
                        'id'     => 'blog-content-tab',
                        'fields' => array(
                            'title',
                            'slug',
                            'status',
                            'body',
                        ),
                    ),
                    array(
                        'title'  => lang('global:custom_fields'),
                        'id'     => 'profile-fields',
                        'fields' => '*'
                    ),
                )
            )
            ->defaults(
                array(
                    'preview_hash' => rand_string(20)
                )
            )
            ->hidden(
                array(
                    'preview_hash'
                )
            ); /*->onQuery(function($model) {
                    return $model->whereHas('category', function($q) {
                            $q->where('slug', 'like', 'two%');
                        });
                });*/
    }
}
