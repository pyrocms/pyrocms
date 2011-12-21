<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Modules
 * @category 	Blog
 */
class Sitemap extends Public_Controller
{
	/**
	 * XML
	 * @access public
	 * @return void
	 */
	public function xml()
	{
		$this->load->model('blog_m');

		$doc = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');

		// Get all pages
		$articles = $this->blog_m->get_many_by(array('status', 'live'));

		// send em to XML!
		foreach ($articles as $article)
		{			
			$node = $doc->addChild('url');

			$loc = site_url('blog/'.date('Y/m/', $article->created_on).$article->slug);

			$node->addChild('loc', $loc);

			if ($article->updated_on)
			{
				$node->addChild('lastmod', date(DATE_W3C, $article->updated_on));
			}
		}

		$this->output
			->set_content_type('application/xml')
			->set_output($doc->asXML());			
	
	}
}
