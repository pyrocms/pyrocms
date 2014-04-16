<?php namespace Pyro\Module\Pages\Ui;

use Pyro\Module\Streams\Ui\EntryUi;

class PageEntryUi extends EntryUi
{
    /**
     * Boot
     *
     * @return array|void
     */
    public function boot()
    {
        parent::boot();

        $this->tabs(
            array(
                array(
                    'title'  => 'Details',
                    'id'     => 'page-details',
                    'fields' => array(
                        'title',
                        'slug',
                        'status',
                        'class',
                    ),
                ),
                array(
                    'title'  => 'Content',
                    'id'     => 'page-fields',
                    'fields' => '*',
                ),
                array(
                    'title'  => 'Metadata',
                    'id'     => 'page-meta',
                    'fields' => array(
                        'meta_title',
                        'meta_keywords',
                        'meta_description',
                    ),
                ),
                array(
                    'title'  => 'Design',
                    'id'     => 'page-design',
                    'fields' => array(
                        'css'
                    ),
                ),
                array(
                    'title'  => 'Script',
                    'id'     => 'page-script',
                    'fields' => array(
                        'js'
                    ),
                ),
                array(
                    'title'  => 'Options',
                    'id'     => 'page-options',
                    'fields' => array(
                        'restricted_to',
                        'comments_enabled',
                        'rss_enabled',
                        'is_home',
                        'strict_uri',
                        'meta_robots_no_index',
                        'meta_robots_no_follow',
                    ),
                ),
            )
        );
    }
}
