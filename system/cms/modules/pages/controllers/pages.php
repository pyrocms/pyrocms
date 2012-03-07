<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Modules
 * @category 	Pages
 */
class Pages extends Public_Controller
{
	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('page_m');
		$this->load->model('page_layouts_m');
		
		// This basically keeps links to /home always pointing to the actual homepage even when the default_controller is changed
		// No page is mentioned and we aren't using pages as default (eg blog on homepage)
		if ( ! $this->uri->segment(1) AND $this->router->default_controller != 'pages')
		{
			redirect('');
		}
	}

	/**
	 * Catch all requests to this page in one mega-function
	 * @access public
	 * @param string $method The method to call
	 * @return void
	 */
	public function _remap($method)
	{
		// This page has been routed to with pages/view/whatever
		if ($this->uri->rsegment(1, '').'/'.$method == 'pages/view')
		{
			$url_segments = $this->uri->total_rsegments() > 0 ? array_slice($this->uri->rsegment_array(), 2) : null;
		}
		
		// not routed, so use the actual URI segments
		else
		{
			if (($url_segments = $this->uri->uri_string()) === 'favicon.ico')
			{
				$favicon = $this->asset->image_path('favicon.ico', '_theme_');

				if (file_exists(FCPATH.$favicon) && is_file(FCPATH.$favicon))
				{
					header('Content-type: image/x-icon');
					readfile(FCPATH.$favicon);
				}
				
				else
				{
					set_status_header(404);
				}

				exit;
			}

			$url_segments = $this->uri->total_segments() > 0 ? $this->uri->segment_array() : null;
		}
		
		// If it has .rss on the end then parse the RSS feed
		$url_segments && preg_match('/.rss$/', end($url_segments))
			? $this->_rss($url_segments)
			: $this->_page($url_segments);
	}

	/**
	 * Page method
	 * @access public
	 * @param array $url_segments The URL segments
	 * @return void
	 */
	public function _page($url_segments)
	{
		$page = $url_segments !== NULL
		
			// Fetch this page from the database via cache
			? $this->pyrocache->model('page_m', 'get_by_uri', array($url_segments))

			: $this->pyrocache->model('page_m', 'get_home');

		// If page is missing or not live (and not an admin) show 404
		if ( ! $page OR ($page->status == 'draft' AND ( ! isset($this->current_user->group) OR $this->current_user->group != 'admin')))
		{
			// Load the '404' page. If the actual 404 page is missing (oh the irony) bitch and quit to prevent an infinite loop.
			if ( ! ($page = $this->pyrocache->model('page_m', 'get_by_uri', array('404'))))
			{
				show_error('The page you are trying to view does not exist and it also appears as if the 404 page has been deleted.');
			}
		}
		
		// If this is a homepage, do not show the slug in the URL
		if ($page->is_home and $url_segments)
		{
			redirect('', 'location', 301);
		}

		// If the page is missing, set the 404 status header
		if ($page->slug == '404')
		{
			$this->output->set_status_header(404);
		}

		// Nope, it's a page but do they have access?
		elseif ($page->restricted_to)
		{
			$page->restricted_to = (array) explode(',', $page->restricted_to);

			// Are they logged in and an admin or a member of the correct group?
			if ( ! $this->current_user OR (isset($this->current_user->group) AND $this->current_user->group != 'admin' AND ! in_array($this->current_user->group_id, $page->restricted_to)))
			{
				redirect('users/login/'.(empty($url_segments) ? '' : implode('/', $url_segments)));
			}
		}

		// Don't worry about breadcrumbs for 404 or restricted
		elseif (count($url_segments) > 1)
		{
			// we dont care about the last one
			array_pop($url_segments);

			// This array of parents in the cache?
			if ( ! $parents = $this->pyrocache->get('page_m/'.md5(implode('/', $url_segments))))
			{
				$parents = $breadcrumb_segments = array();

				foreach ($url_segments as $segment)
				{
					$breadcrumb_segments[] = $segment;

					$parents[] = $this->pyrocache->model('page_m', 'get_by_uri', array($breadcrumb_segments));
				}

				// Cache for next time
				$this->pyrocache->write($parents, 'page_m/'.md5(implode('/', $url_segments)));
			}

			foreach ($parents as $parent_page)
			{
				$this->template->set_breadcrumb($parent_page->title, $parent_page->uri);
			}
		}
			
		// Not got a meta title? Use slogan for homepage or the normal page title for other pages
		if ($page->meta_title == '')
		{
			$page->meta_title = $page->is_home ? $this->settings->site_slogan : $page->title;
		}
		
		// If this page has an RSS feed, show it
		if ($page->rss_enabled)
		{
			    $this->template->append_metadata('<link rel="alternate" type="application/rss+xml" title="'.$page->meta_title.'" href="'.site_url(uri_string(). '.rss').'" />');
		}
		
		// Wrap the page with a page layout, otherwise use the default 'Home' layout
		if ( ! $page->layout = $this->page_layouts_m->get($page->layout_id))
		{
		    // Some pillock deleted the page layout, use the default and pray to god they didnt delete that too
		    $page->layout = $this->page_layouts_m->get(1);
		}
	
		// Set pages layout files in your theme folder
		if ($this->template->layout_exists($page->uri.'.html'))
		{
			$this->template->set_layout($page->uri.'.html');
		}

		// If a Page Layout has a Theme Layout that exists, use it
		if ( ! empty($page->layout->theme_layout) AND $this->template->layout_exists($page->layout->theme_layout)
			// But Allow that you use layout files of you theme folder without override the defined by you in your control panel
			AND ($this->template->layout_is('default.html') OR $page->layout->theme_layout !== 'default.html'))
		{
			$this->template->set_layout($page->layout->theme_layout);
		}

		// Grab all the chunks that make up the body
		$page->chunks = $this->db->order_by('sort')
			->get_where('page_chunks', array('page_id' => $page->id))
			->result();
		
		$chunk_html = '';
		foreach ($page->chunks as $chunk)
		{
			$chunk_html .= 	'<div class="page-chunk '.$chunk->slug.'">' .
						'<div class="page-chunk-pad">' .
								(($chunk->type == 'markdown') ? $chunk->parsed : $chunk->body) .
						'</div>' .
					'</div>'.PHP_EOL;
		}
		
		// Parse it so the content is parsed. We pass along $page so that {{ page:id }} and friends work in page content
		$page->body = $this->parser->parse_string(str_replace(array('&#39;', '&quot;'), array("'", '"'), $chunk_html), array('theme' => $this->theme, 'page' => $page), TRUE);
		
		// Create page output
		$this->template->title($page->meta_title)
			
			->set_metadata('keywords', $page->meta_keywords)
			->set_metadata('description', $page->meta_description)
			
			->set('page', $page)
			
			// Most likely the other breadcrumbs are set above, set this one
			->set_breadcrumb($page->title);

		if ($page->layout->css OR $page->css)
		{
			$this->template->append_metadata('
				<style type="text/css">
					'.$page->layout->css.'
					'.$page->css.'
				</style>');
		}
		
		if ($page->layout->js OR $page->js)
		{
			$this->template->append_metadata('
				<script type="text/javascript">
					'.$page->layout->js.'
					'.$page->js.'
				</script>');
		}

		if ($page->slug == '404')
		{
			log_message('error', 'Page Missing: '.$this->uri->uri_string());
		}

		echo $this->template->build('pages/page', NULL, TRUE, FALSE);
	}

	/**
	 * RSS method
	 * @access public
	 * @param array $url_segments The URL segments
	 * @return void
	 */
	public function _rss($url_segments)
	{
		// Remove the .rss suffix
		$url_segments += array(preg_replace('/.rss$/', '', array_pop($url_segments)));
		
		// Fetch this page from the database via cache
		$page = $this->pyrocache->model('page_m', 'get_by_uri', array($url_segments));
		
		// If page is missing or not live (and not an admin) show 404
		if (empty($page) OR ($page->status == 'draft' AND $this->current_user->group !== 'admin') OR ! $page->rss_enabled)
		{
			// Will try the page then try 404 eventually
			$this->_page('404');
			return;
		}
		
		$children = $this->pyrocache->model('page_m', 'get_many_by', array(array(
			'parent_id' => $page->id,
			'status' => 'live'
		)));
    	
		$data->rss->title = ($page->meta_title ? $page->meta_title : $page->title).' | '. $this->settings->site_name;
		$data->rss->description = $page->meta_description;
		$data->rss->link = site_url($url_segments);
		$data->rss->creator_email = $this->settings->contact_email;
		
		if ( ! empty($children))
		{
			$this->load->helper(array('date', 'xml'));
			
			foreach($children as &$row)
			{
				$row->link = $row->uri ? $row->uri : $row->slug;
				$row->created_on = standard_date('DATE_RSS', $row->created_on);
				
				$item = array(
					//'author' => $row->author,
					'title' => xml_convert($row->title),
					'link' => $row->link,
					'guid' => $row->link,
					'description'  => $row->meta_description,
					'date' => $row->created_on
				);
						
				$data->rss->items[] = (object) $item;
			}
		}
		
		$this->load->view('rss', $data);
	}
}
