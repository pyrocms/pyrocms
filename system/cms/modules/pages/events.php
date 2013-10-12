<?php

use Pyro\Module\Search\Model\Search;

/**
* Pages Events Class
*
* @package 		PyroCMS
* @subpackage 	Blog Module
* @category 	events
* @author 		PyroCMS Dev Team
*/
class Events_Pages
{
    protected $ci;

    public function __construct()
    {
        // Post a blog to twitter and whatnot
        Events::register('page_created', array($this, 'index_page'));
        Events::register('page_updated', array($this, 'index_page'));
        Events::register('page_deleted', array($this, 'drop_page'));
    }

    public function index_page($page)
    {
    	// Only index live articles
    	if ($page->status === 'live') {
            Search::index(
                'pages',
                'pages:page',
                'pages:pages',
                $page->id,
                $page->title,
                $page->meta_description ?: null,
                $page->meta_keywords,
                $page->uri,
                'admin/pages/edit/'.$page->id,
                'admin/pages/delete/'.$page->id
                );
    	}
    	// Draft pages dont have uris yet
    	else {
    		Search::index(
                'pages',
                'pages:page',
                'pages:pages',
                $page->id,
                $page->title,
                $page->meta_description ?: null,
                $page->meta_keywords,
                null,
                'admin/pages/edit/'.$page->id,
                'admin/pages/delete/'.$page->id
                );
    	}
	}

    public function drop_post($ids)
    {
    	foreach ($ids as $id) {
			Search::drop_index('pages', 'pages:page', $id);
		}
	}
}
