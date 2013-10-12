<?php

use Pyro\Module\Pages\Model\Page;
use Pyro\Module\Search\Model\Search;

/**
* Blog Events Class
*
* @package 		PyroCMS
* @subpackage 	Blog Module
* @category 	events
* @author 		PyroCMS Dev Team
*/
class Events_Blog
{
    protected $ci;

    public function __construct()
    {
        // Post a blog to twitter and whatnot
        Events::register('post_published', array($this, 'index_post'));
        Events::register('post_updated', array($this, 'index_post'));
        Events::register('post_deleted', array($this, 'drop_post'));
    }

    public function index_post($id)
    {
    	$post = Page::find($id);

    	// Only index live articles
    	if ($post->status === 'live') {
            Search::index(
                'blog',
                'blog:post',
                'blog:posts',
                $id,
                $post->title,
                $post->body,
                $post->keywords,
                'blog/'.date('Y/m/', $post->created_on).$post->slug,
                'admin/blog/edit/'.$id,
                'admin/blog/delete/'.$id
                );
    	}
    	// Draft articles dont have uris yet
    	else {
    		Search::index(
                'blog',
                'blog:post',
                'blog:posts',
                $id,
                $post->title,
                $post->body,
                $post->keywords,
                null,
                'admin/blog/edit/'.$id,
                'admin/blog/delete/'.$id
                );
    	}
	}

    public function drop_post($ids)
    {
    	foreach ($ids as $id) {
			Search::drop_index('blog', 'blog:post', $id);
		}
	}
}

/* End of file events.php */
