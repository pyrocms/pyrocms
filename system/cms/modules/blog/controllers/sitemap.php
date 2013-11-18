<?php

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
		$this->load->model('blog_m');

		$articles = $this->blog_m->get_many_by(array('status', 'live'));

		$collection = new SitemapCollection;
		$collection->setFormatter(new URLSet);

		// send em to XML!
		foreach ($articles as $article) {
			$entry = new SitemapEntry;

			$loc = site_url('blog/'.date('Y/m/', $article->created_at).$article->slug);
			
			$entry->setLocation($loc);
			$entry->setLastMod(date(DATE_W3C, $article->updated_at ?: $article->created_at));

			$collection->addSitemap($entry);
		}

		$this->output
			->set_content_type('application/xml')
			->set_output($collection->output());
	}
}
