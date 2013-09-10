<?php

use Pyro\Module\Pages\Model\Page;

/**
* Sample Events Class
*
* @package 		PyroCMS
* @subpackage 	Social Module
* @category 	events
* @author 		PyroCMS Dev Team
*/
class Events_Search
{
    protected $ci;

    public function __construct()
    {
        // Load the search index model
        ci()->load->model('search/search_index_m');

		// Post a blog to twitter and whatnot
        Events::register('post_published', array($this, 'index_post'));
        Events::register('post_updated', array($this, 'index_post'));
        Events::register('post_deleted', array($this, 'drop_post'));

		// Post a blog to twitter and whatnot
        Events::register('page_created', array($this, 'index_page'));
        Events::register('page_updated', array($this, 'index_page'));
        Events::register('page_deleted', array($this, 'drop_page'));
    }

    public function index_post($id)
    {
    	ci()->load->model('blog/blog_m');

    	$post = ci()->blog_m->get($id);

    	// Only index live articles
    	if ($post->status === 'live') {
    		ci()->search_index_m->index(
    			'blog',
    			'blog:post',
    			'blog:posts',
    			$id,
    			'blog/'.date('Y/m/', $post->created_on).$post->slug,
    			$post->title,
    			$post->body,
    			array(
    				'cp_edit_uri' 	=> 'admin/blog/edit/'.$id,
    				'cp_delete_uri' => 'admin/blog/delete/'.$id,
    				'keywords' 		=> $post->keywords,
    			)
    		);
    	}
    	// Remove draft articles
    	else {
    		ci()->search_index_m->drop_index('blog', 'blog:post', $id);
    	}
	}

    public function drop_post($ids)
    {
    	foreach ($ids as $id) {
			ci()->search_index_m->drop_index('blog', 'blog:post', $id);
		}
	}

    public function index_page(Page $page)
    {
    	// Only index live articles
    	if ($page->status === 'live') {
    		ci()->search_index_m->index(
    			'pages',
    			'pages:page',
    			'pages:pages',
    			$page->id,
    			$page->uri,
    			$page->title,
    			$page->meta_description ?: null,
    			array(
    				'cp_edit_uri' 	=> 'admin/pages/edit/'.$page->id,
    				'cp_delete_uri' => 'admin/pages/delete/'.$page->id,
    				'keywords' 		=> $page->meta_keywords,
    			)
    		);

    	// Remove draft articles
    	} else {
    		ci()->search_index_m->drop_index('pages', 'pages:page', $page->id);
    	}
	}

    public function drop_page($ids)
    {
    	foreach ((array) $ids as $id) {
			ci()->search_index_m->drop_index('pages', 'pages:page', $id);
		}
	}
}

/* End of file events.php */
