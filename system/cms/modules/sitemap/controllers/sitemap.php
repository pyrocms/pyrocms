<?php

use Sitemap\Collection as SitemapCollection;
use Sitemap\Sitemap\SitemapEntry;
use Sitemap\Formatter\XML\SitemapIndex;

/**
 * Sitemap module public controller
 *
 * Renders a human-readable sitemap with all public pages and blog categories
 * Also renders a machine-readable sitemap for search engines
 *
 * @author  	Barnabas Kendall <barnabas@bkendall.biz>
 * @license 	Apache License v2.0
 * @version 	1.1
 * @package		PyroCMS\Core\Modules\Sitemap\Controllers
 */
class Sitemap extends Public_Controller
{
    /**
     * XML method - output sitemap in XML format for search engines
     *
     * @return void
     */
    public function xml()
    {
        // first get a list of enabled modules, use them for the listing
        $modules = $this->moduleManager->getAll(array(
            'is_frontend' => true,
        ));

        $collection = new SitemapCollection;
        $collection->setFormatter(new SitemapIndex);

        foreach ($modules as $module) {
            // To understand recursion, you must first understand recursion
            if (
                $module['slug'] == 'sitemap'
                or ( ! file_exists($module['path'].'/controllers/sitemap.php'))
            ) {
                continue;
            }

            if( $module['slug'] == "blog" ) {
                $this->load->model('blog/blog_m');
                $posts = $this->blog_m->get_many_by(array('status', 'live'));

                if( count($posts) == 0 ) {
                    continue;
                }
            }

            $basic = new SitemapEntry;
            $basic->setLocation(site_url($module['slug'].'/sitemap/xml'));

            $collection->addSitemap($basic);
        }

        $this->output
            ->set_content_type('application/xml')
            ->set_output($collection->output());
    }
}
