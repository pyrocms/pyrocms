<?php namespace Pyro\Module\Pages\Ui;

use Pyro\Module\Pages\Model\PageType;
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
                'content' => array(
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

        $this->onForm(
            function () {

                $types = new PageType();

                $pageType = $types->find(ci()->input->get('page_type'));

                // @todo - I don't like this: if realistic to fix by 3.0.. do it.
                if (isset($pageType->title_label) and $pageType->title_label) {
                    ci()->lang->language['global:title'] = $pageType->title_label;
                }

                if (isset($pageType->content_label) and $pageType->content_label) {
                    $tabs = $this->tabs;

                    $tabs['content']['title'] = $pageType->content_label;

                    $this->tabs($tabs);
                }
            }
        );
    }
}
