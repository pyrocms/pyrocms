<?php namespace Pyro\Module\Blog;

use Pyro\Module\Streams_core\EntryModel;

class BlogEntryModel extends EntryModel
{

	protected $stream_slug = 'blog';

	protected $stream_namespace = 'blogs';

}