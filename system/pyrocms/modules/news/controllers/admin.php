<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  Categories
 * @category  	Module
 */
class Admin extends Admin_Controller
{
	/**
	 * The id of article
	 * @access protected
	 * @var int
	 */
	protected $id = 0;

	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules = array(
		array(
			'field'	=> 'title',
			'label'	=> 'lang:news_title_label',
			'rules'	=> 'trim|htmlspecialchars|required|max_length[100]|callback__check_title'
		),
		array(
			'field'	=> 'slug',
			'label'	=> 'lang:news_slug_label',
			'rules' => 'trim|required|alpha_dot_dash|max_length[100]|callback__check_slug'
		),
		array(
			'field' => 'category_id',
			'label' => 'lang:news_category_label',
			'rules' => 'trim|numeric'
		),
		array(
			'field' => 'intro',
			'label' => 'lang:news_intro_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'body',
			'label' => 'lang:news_content_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'status',
			'label' => 'lang:news_status_label',
			'rules' => 'trim|alpha'
		),
		array(
			'field' => 'created_on',
			'label' => 'lang:news_date_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'created_on_hour',
			'label' => 'lang:news_created_hour',
			'rules' => 'trim|numeric|required'
		),
		array(
			'field' => 'created_on_minute',
			'label' => 'lang:news_created_minute',
			'rules' => 'trim|numeric|required'
		)
	);

	/** 
	 * The constructor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::Admin_Controller();
		
		$this->load->model('news_m');
		$this->load->model('news_categories_m');
		$this->lang->load('news');
		$this->lang->load('categories');
		
		// Date ranges for select boxes
		$this->data->hours = array_combine($hours = range(0, 23), $hours);
		$this->data->minutes = array_combine($minutes = range(0, 59), $minutes);
		
		$this->data->categories = array(0 => '');
		if ($categories = $this->news_categories_m->order('name')->get_all())
		{
			foreach($categories as $category)
			{
				$this->data->categories[$category->id] = $category->title;
			}
		}
		
		$this->template->append_metadata( css('news.css', 'news') )
				->set_partial('shortcuts', 'admin/partials/shortcuts');
	}
	
	/**
	 * Show all created news articles
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Create pagination links
		$total_rows = $this->news_m->count_by(array('show_future'=>TRUE, 'status' => 'all'));
		$pagination = create_pagination('admin/news/index', $total_rows);
		
		// Using this data, get the relevant results
		$news = $this->news_m->limit($pagination['limit'])->get_many_by(array(
			'show_future' => TRUE,
			'status' => 'all'
		));
		
		
		$this->template
			->title($this->module_details['name'])
			->set('pagination', $pagination)
			->set('news', $news)
			->build('admin/index', $this->data);
	}
	
	/**
	 * Create new article
	 * @access public
	 * @return void
	 */
	public function create()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules($this->validation_rules);

		if ($this->input->post('created_on'))
		{
			$created_on = strtotime(sprintf('%s %s:%s', $this->input->post('created_on'), $this->input->post('created_on_hour'), $this->input->post('created_on_minute')));
		}

		else
		{
			$created_on = now();
		}

		if ($this->form_validation->run())
		{
			$id = $this->news_m->insert(array(
				'title'			=> $this->input->post('title'),
				'slug'			=> $this->input->post('slug'),
				'category_id'	=> $this->input->post('category_id'),
				'intro'			=> $this->input->post('intro'),
				'body'			=> $this->input->post('body'),
				'status'		=> $this->input->post('status'),
				'created_on' => $created_on
			));

			if($id)
			{
				$this->cache->delete_all('news_m');
				$this->session->set_flashdata('success', sprintf($this->lang->line('news_article_add_success'), $this->input->post('title')));
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('news_article_add_error'));
			}

			// Redirect back to the form or main page
			$this->input->post('btnAction') == 'save_exit' ? redirect('admin/news') : redirect('admin/news/edit/'.$id);
		}

		else
		{
			// Go through all the known fields and get the post values
			foreach($this->validation_rules as $key => $field)
			{
				$article->$field['field'] = set_value($field['field']);
			}
			$article->created_on = $created_on;
		}
		
		$this->template
			->title($this->module_details['name'], lang('news_create_title'))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_metadata( js('news_form.js', 'news') )
			->set('article', $article)
			->build('admin/form');
	}
	
	/**
	 * Edit news article
	 * @access public
	 * @param int $id the ID of the news article to edit
	 * @return void
	 */
	public function edit($id = 0)
	{
		$id OR redirect('admin/news');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);
			
		$article = $this->news_m->get($id);

		// If we have a useful date, use it
		if ($this->input->post('created_on'))
		{
			$created_on = strtotime(sprintf('%s %s:%s', $this->input->post('created_on'), $this->input->post('created_on_hour'), $this->input->post('created_on_minute')));
		}

		else
		{
			$created_on = $article->created_on;
		}

		$this->id = $article->id;
		
		if ($this->form_validation->run())
		{
			$result = $this->news_m->update($id, array(
				'title'			=> $this->input->post('title'),
				'slug'			=> $this->input->post('slug'),
				'category_id'	=> $this->input->post('category_id'),
				'intro'			=> $this->input->post('intro'),
				'body'			=> $this->input->post('body'),
				'status'		=> $this->input->post('status'),
				'created_on' => $created_on
			));
			
			if ($result)
			{
				$this->session->set_flashdata(array('success'=> sprintf($this->lang->line('news_edit_success'), $this->input->post('title'))));
				
				// The twitter module is here, and enabled!
//				if ($this->settings->item('twitter_news') == 1 && ($article->status != 'live' && $this->input->post('status') == 'live'))
//				{
//					$url = shorten_url('news/'.$date[2].'/'.str_pad($date[1], 2, '0', STR_PAD_LEFT).'/'.url_title($this->input->post('title')));
//					$this->load->model('twitter/twitter_m');
//					if ( ! $this->twitter_m->update(sprintf($this->lang->line('news_twitter_posted'), $this->input->post('title'), $url)))
//					{
//						$this->session->set_flashdata('error', lang('news_twitter_error') . ": " . $this->twitter->last_error['error']);
//					}
//				}
				// End twitter code
			}
			
			else
			{
				$this->session->set_flashdata(array('error'=> $this->lang->line('news_edit_error')));
			}
			
			// Redirect back to the form or main page
			$this->input->post('btnAction') == 'save_exit'
				? redirect('admin/news')
				: redirect('admin/news/edit/'.$id);
		}
		
		// Go through all the known fields and get the post values
		foreach(array_keys($this->validation_rules) as $field)
		{
			if (isset($_POST[$field]))
			{
				$article->$field = $this->form_validation->$field;
			}
		}

		$article->created_on = $created_on;
		
		// Load WYSIWYG editor
		$this->template
			->title($this->module_details['name'], sprintf(lang('news_edit_title'), $article->title))
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			->append_metadata( js('news_form.js', 'news') )
			->set('article', $article)
			->build('admin/form');
	}	
	
	/**
	* Preview news article
	* @access public
	* @param int $id the ID of the news article to preview
	* @return void
	*/
	public function preview($id = 0)
	{
		$article = $this->news_m->get($id);

		$this->template
			->set_layout('modal', 'admin')
			->set('article', $article)
			->build('admin/preview');
	}
	
	/**
	 * Helper method to determine what to do with selected items from form post
	 * @access public
	 * @return void
	 */
	public function action()
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
				redirect('admin/news');
			break;
		}
	}
	
	/**
	 * Publish news article
	 * @access public
	 * @param int $id the ID of the news article to make public
	 * @return void
	 */
	public function publish($id = 0)
	{
		// Publish one
		$ids = ($id) ? array($id) : $this->input->post('action_to');
		
		if ( ! empty($ids))
		{
			// Go through the array of slugs to publish
			$article_titles = array();
			foreach ($ids as $id)
			{
				// Get the current page so we can grab the id too
				if ($article = $this->news_m->get($id) )
				{
					$this->news_m->publish($id);
					
					// Wipe cache for this model, the content has changed
					$this->cache->delete('news_m');				
					$article_titles[] = $article->title;
				}
			}
		}
	
		// Some articles have been published
		if ( ! empty($article_titles))
		{
			// Only publishing one article
			if ( count($article_titles) == 1 )
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
		
		redirect('admin/news');
	}
	
	/**
	 * Delete news article
	 * @access public
	 * @param int $id the ID of the news article to delete
	 * @return void
	 */
	public function delete($id = 0)
	{
		// Delete one
		$ids = ($id) ? array($id) : $this->input->post('action_to');
		
		// Go through the array of slugs to delete
		if ( ! empty($ids))
		{
			$article_titles = array();
			foreach ($ids as $id)
			{
				// Get the current page so we can grab the id too
				if ($article = $this->news_m->get($id) )
				{
					$this->news_m->delete($id);
					
					// Wipe cache for this model, the content has changed
					$this->cache->delete('news_m');				
					$article_titles[] = $article->title;
				}
			}
		}
		
		// Some pages have been deleted
		if ( ! empty($article_titles))
		{
			// Only deleting one page
			if ( count($article_titles) == 1 )
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
			$this->session->set_flashdata('notice', lang('news_delete_error'));
		}
		
		redirect('admin/news');
	}
	
	/**
	 * Callback method that checks the title of an article
	 * @access public
	 * @param string title The Title to check
	 * @return bool
	 */
	public function _check_title($title = '')
	{
		if ( ! $this->news_m->check_exists('title', $title, $this->id))
		{
			$this->form_validation->set_message('_check_title', sprintf(lang('news_already_exist_error'), lang('news_title_label')));
			return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	 * Callback method that checks the slug of an article
	 * @access public
	 * @param string slug The Slug to check
	 * @return bool
	 */
	public function _check_slug($slug = '')
	{
		if ( ! $this->news_m->check_exists('slug', $slug, $this->id))
		{
			$this->form_validation->set_message('_check_slug', sprintf(lang('news_already_exist_error'), lang('news_slug_label')));
			return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	 * method to fetch filtered results for news list
	 * @access public
	 * @return void
	 */
	public function ajax_filter()
	{
		$category = $this->input->post('f_category');
		$status = $this->input->post('f_status');
		$keywords = $this->input->post('f_keywords');
	
		$post_data = array();
	
		if ($status == 'live' OR $status == 'draft')
		{
			$post_data['status'] = $status;
		}
	
		if ($category != 0)
		{
			$post_data['category_id'] = $category;
		}
	
		//keywords, lets explode them out if they exist
		if ($keywords)
		{
			$post_data['keywords'] = $keywords;
		}
		$results = $this->news_m->search($post_data);
	
		//set the layout to false and load the view
		$this->template
			->set_layout(FALSE)
			->set('news', $results)
			->build('admin/index');
	}
}