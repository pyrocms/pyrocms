<?php

use Pyro\Module\Blog\BlogEntryModel;
use Sitemap\Collection as SitemapCollection;
use Sitemap\Sitemap\SitemapEntry;
use Sitemap\Formatter\XML\URLSet;

/**
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog\Controllers
 */
class Sitemap extends Public_Controller
{
    /**
     * XML
     */
    public function xml()
    {
        $blogModel = new BlogEntryModel;

        $articles = $blogModel->live()->get();

        $collection = new SitemapCollection;
        $collection->setFormatter(new URLSet);

        // send em to XML!
        foreach ($articles as $article) {
            $entry = new SitemapEntry;

            $loc = site_url('blog/'.$article->created_at->format('Y/m/d').$article->slug);

            $entry->setLocation($loc);
            $entry->setLastMod($article->updated_at ?: $article->created_at);

            $collection->addSitemap($entry);
        }

        $this->output
            ->set_content_type('application/xml')
            ->set_output($collection->output());
    }
}
