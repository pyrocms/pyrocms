<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Pages\Controllers
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
		$this->load->model('page_m');

		$doc = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');

		// Get all pages
		$pages = $this->page_m->get_many_by('status', 'live');
		
		// send em to XML!
		foreach ($pages as $page)
		{			
			// Skip the 404 page!
			if (in_array($page->uri, array('404')))
			{
				continue;
			}

			$node = $doc->addChild('url');
		
			$loc = site_url($page->is_home ? '' : $page->uri);

			$node->addChild('loc', $loc);

			if ($page->updated_on)
			{
				$node->addChild('lastmod', date(DATE_W3C, $page->updated_on));
			}
		}

		$this->output
			->set_content_type('application/xml')
			->set_output($doc->asXML());
	}
}
