<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	// Validation rules to be used for create and edit
	private $rules = array(
		'title' 			=> 'trim|required|ma_length[100]',
		'category_id' 		=> 'trim|numeric',
		'intro' 			=> 'trim|required',
		'body' 				=> 'trim|required',
		'status' 			=> 'trim|alpha',
		
		'created_on_day' 	=> 'trim|numeric|required',
		'created_on_month' 	=> 'trim|numeric|required',
		'created_on_year' 	=> 'trim|numeric|required',
		
		'created_on_hour' 	=> 'trim|numeric|required',
		'created_on_minute' => 'trim|numeric|required'
	);
	
	function __construct()
	{
		parent::Admin_Controller();
		
		$this->load->model('news_m');
		$this->load->module_model('categories', 'categories_m');
		$this->load->helper('date');
		$this->lang->load('news');
		
		// Date ranges for select boxes
		$this->data->days = array_combine($days = range(1, 31), $days);
		$this->data->months = array_combine($months = range(1, 12), $months);
		$this->data->years = array_combine($years = range(date('Y')-2, date('Y')+2), $years);
		
		$this->data->hours = array_combine($hours = range(1, 23), $hours);
		$this->data->minutes = array_combine($minutes = range(1, 59), $minutes);
		
		$this->data->categories = array();
		if($categories = $this->categories_m->getCategories())
		{
			foreach($categories as $category)
			{
				$this->data->categories[$category->id] = $category->title;
			}
		}
	}
	
	// Admin: List news articles
	function index()
	{
		// Create pagination links
		$total_rows = $this->news_m->countArticles(array('show_future'=>TRUE, 'status' => 'all'));
		$this->data->pagination = create_pagination('admin/news/index', $total_rows);
		
		// Using this data, get the relevant results
		$this->data->news = $this->news_m->getNews(array(
			'show_future'=>TRUE,
			'status' => 'all',
			'order'	=> 'created_on DESC, status',
			'limit' => $this->data->pagination['limit']
		));
		
		$this->layout->create('admin/index', $this->data);
	}
	
	// Admin: Create a new article
	function create()
	{
		$this->load->library('validation');
		$this->rules['title'] .= '|callback__createTitleCheck';
		$this->validation->set_rules($this->rules);
		$this->validation->set_fields();
		
		// Go through all the known fields and get the post values
		foreach(array_keys($this->rules) as $field)
		{
			$article->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
		}
		
		if ($this->validation->run())
		{
			if ($this->news_m->newArticle($_POST))
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('news_article_add_success'), $this->input->post('title')));
			
				// The twitter module is here, and enabled!
				if($this->settings->item('twitter_news') == 1 && $this->input->post('status') == 'live')
				{
					$url = shorten_url('news/'.$this->input->post('created_on_year').'/'.$this->input->post('created_on_month').'/'.url_title($this->input->post('title')));
					$this->twitter_m->update(sprintf($this->lang->line('news_twitter_posted'), $this->input->post('title'), $url));
				}
				// End twitter code
			}            
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('news_article_add_error'));
			}			
			redirect('admin/news/index');
		}		
		$this->data->article =& $article;
		
		// Load WYSIWYG editor
		$this->layout->extra_head( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->layout->create('admin/form', $this->data);
	}
	
	// Admin: Edit an article
	function edit($id = 0)
	{
		if (!$id) redirect('admin/news/index');
		
		$this->load->library('validation');
		$this->validation->set_rules($this->rules);
		$this->validation->set_fields();		
		$article = $this->news_m->getArticle($id, 'all');
		
		if ($this->validation->run())
		{
			if ($this->news_m->updateArticle($_POST, $id))
			{
				$this->session->set_flashdata(array('success'=> sprintf($this->lang->line('news_edit_success'), $this->input->post('title'))));
				
				// The twitter module is here, and enabled!
				if($this->settings->item('twitter_news') == 1 && ($article->status != 'live' && $this->input->post('status') == 'live'))
				{
					$url = shorten_url('news/'.$this->input->post('created_on_year').'/'.str_pad($this->input->post('created_on_month'), 2, '0', STR_PAD_LEFT).'/'.url_title($this->input->post('title')));
					$this->load->module_model('twitter', 'twitter_m');
					$this->twitter_m->update(sprintf($this->lang->line('news_twitter_posted'), $this->input->post('title'), $url));
				}
				// End twitter code
			}
			else
			{
				$this->session->set_flashdata(array('error'=> $this->lang->line('news_edit_error')));
			}
			redirect('admin/news/index');
		}
		
		// Go through all the known fields and get the post values
		foreach(array_keys($this->rules) as $field)
		{
			if(isset($_POST[$field])) $article->$field = $this->validation->$field;
		}    	
		$this->data->article =& $article;
		
		// Load WYSIWYG editor
		$this->layout->extra_head( $this->load->view('fragments/wysiwyg', $this->data, TRUE) );		
		$this->layout->create('admin/form', $this->data);
	}	
	
	function preview($id = 0)
	{		
		$this->data->article = $this->news_m->getArticle($id, 'all');    	
		$this->layout->wrapper(FALSE);
		$this->layout->create('admin/preview', $this->data);
	}
	
	// Admin: Different actions
	function action()
	{
		switch($this->input->post('btnAction'))
		{
			case 'publish':
				$this->publish();
			break;
			case 'delete':
				$this->delete();
			break;
			default:
				redirect('admin/news/index');
			break;
		}
	}
	
	// Admin: Publish an article
	function publish($id = 0)
	{
		// Publish one
		$ids = ($id) ? array($id) : $this->input->post('action_to');
		
		// Go through the array of slugs to publish
		$article_titles = array();
		foreach ($ids as $id)
		{
			// Get the current page so we can grab the id too
			if($article = $this->news_m->getArticle($id, 'all') )
			{
				$this->news_m->publishArticle($id);
				
				// Wipe cache for this model, the content has changed
				$this->cache->delete('news_m');				
				$article_titles[] = $article->title;
			}
		}
	
		// Some articles have been published
		if(!empty($article_titles))
		{
			// Only publishing one article
			if( count($article_titles) == 1 )
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('news_publish_success'), $article_titles[0]));
			}			
			// Publishing multiple articles
			else
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('news_mass_publish_success'), implode('", "', $article_titles)));
			}
		}		
		// For some reason, none of them were published
		else
		{
			$this->session->set_flashdata('notice', $this->lang->line('news_publish_error'));
		}		
		redirect('admin/news/index');
	}
	
	// Admin: Delete an article
	function delete($id = 0)
	{
		// Delete one
		$ids = ($id) ? array($id) : $this->input->post('action_to');
		
		// Go through the array of slugs to delete
		$article_titles = array();
		foreach ($ids as $id)
		{
			// Get the current page so we can grab the id too
			if($article = $this->news_m->getArticle($id, 'all') )
			{
				$this->news_m->deleteArticle($id);
				
				// Wipe cache for this model, the content has changed
				$this->cache->delete('news_m');				
				$article_titles[] = $article->title;
			}
		}
		
		// Some pages have been deleted
		if(!empty($article_titles))
		{
			// Only deleting one page
			if( count($article_titles) == 1 )
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('news_delete_success'), $article_titles[0]));
			}			
			// Deleting multiple pages
			else
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('news_mass_delete_success'), implode('", "', $article_titles)));
			}
		}		
		// For some reason, none of them were deleted
		else
		{
			$this->session->set_flashdata('notice', $this->lang->line('news_delete_error'));
		}		
		redirect('admin/news/index');
	}
	
	
	// Callback: from create()
	function _createTitleCheck($title = '')
	{
		if ($this->news_m->checkTitle($title))
		{
			$this->validation->set_message('_createTitleCheck', $this->lang->line('news_already_exist_error'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	// Private: Create resize of Cropped Image to ensure it's a certain size
	function _create_resize($homeimg = '', $x, $y)
	{
		unset($img_cfg);
		$img_cfg['source_image'] = APPPATH.'assets/img/suppliers/' . $homeimg;
		$img_cfg['new_image'] = APPPATH.'assets/img/suppliers/' . $homeimg;
		$img_cfg['maintain_ratio'] = true;
		$img_cfg['width'] = $x;
		$img_cfg['height'] = $y;
		$this->load->library('image_lib');
		$this->image_lib->initialize($img_cfg);
		$this->image_lib->resize();
	}
}
?>