<?php namespace Pyro\Module\Blog;

use Pyro\Module\Streams_core\EntryDataModel;

class BlogsBlogModel extends EntryDataModel
{
    /**
     * The stream slug
     * @var string
     */
    protected $streamSlug = 'blog';

    /**
     * The stream namespace
     * @var string
     */
    protected $streamNamespace = 'blogs';
}