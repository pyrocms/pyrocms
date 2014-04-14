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
                    'fields' => array('css'),
                ),
                array(
                    'title'  => 'Metadata',
                    'id'     => 'page-meta',
                    'fields' => array('css'),
                ),
                array(
                    'title'  => 'Content',
                    'id'     => 'page-fields',
                    'fields' => '*',
                ),
                array(
                    'title'  => 'Design',
                    'id'     => 'page-design',
                    'fields' => array('css'),
                ),
                array(
                    'title'  => 'Script',
                    'id'     => 'page-script',
                    'fields' => array('js'),
                ),
                array(
                    'title'  => 'Options',
                    'id'     => 'page-options',
                    'fields' => array('css'),
                ),
            )
        );
    }
}
