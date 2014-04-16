<?php namespace Pyro\Module\Templates\Ui;

use Pyro\Module\Streams\Ui\EntryUi;

class TemplateEntryUi extends EntryUi
{
    /**
     * Get default attributes
     *
     * @return array
     */
    public function boot()
    {
        parent::boot();

        // Filters to display on our table
        $this
            ->limit(100)
            ->orderBy('name')
            ->sort('asc')
            ->filters(
                array(
                    'name',
                    'description',
                )
            )
            ->fields(
                array(
                    'linkPreview' => array(
                        'name' => lang('name_label'),
                    ),
                    'description',
                    'lang',
                    'buttons'     => array(
                        'class' => 'textright'
                    ),
                )
            )
            ->messages(
                array(
                    'success' => lang('templates:tmpl_create_success')
                )
            )
            ->redirects(
                'admin/templates'
            );
    }
}
