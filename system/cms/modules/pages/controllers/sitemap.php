<?php

use Carbon\Carbon;
use Pyro\Module\Pages\Model\Page;
use Sitemap\Collection as SitemapCollection;
use Sitemap\Sitemap\SitemapEntry;
use Sitemap\Formatter\XML\URLSet;

/**
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Pages\Controllers
 */
class Sitemap extends Public_Controller
{
    /**
     * XML
     *
     * @return void
     */
    public function xml()
    {
        // Get all pages
        $pages = Page::findStatus('live');

        $collection = new SitemapCollection;
        $collection->setFormatter(new URLSet);

        foreach ($pages as $page) {
            // Skip the 404 page!
            if (in_array($page->uri, array('404'))) {
                continue;
            }

            $entry = new SitemapEntry;
            $entry->setLocation(site_url($page->is_home ? '' : $page->uri));

            $lastMod = $page->updated_at ?: $page->created_at;
            $entry->setLastMod(Carbon::parse($lastMod)->toW3CString());

            $collection->addSitemap($entry);
        }

        $this->output
            ->set_content_type('application/xml')
            ->set_output($collection->output());
    }
}
