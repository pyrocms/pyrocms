<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * @package  	PyroCMS
 * @subpackage  Categories
 * @category  	Module
 */
class Admin extends Admin_Controller {

	/**
	 * The id of post
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
			'field' => 'title',
			'label' => 'lang:blog_title_label',
			'rules' => 'trim|htmlspecialchars|required|max_length[100]|callback__check_title'
		),
		array(
			'field' => 'slug',
			'label' => 'lang:blog_slug_label',
			'rules' => 'trim|required|alpha_dot_dash|max_length[100]|callback__check_slug'
		),
		array(
			'field' => 'category_id',
			'label' => 'lang:blog_category_label',
			'rules' => 'trim|numeric'
		),
		array(
			'field' => 'intro',
			'label' => 'lang:blog_intro_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'body',
			'label' => 'lang:blog_content_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'status',
			'label' => 'lang:blog_status_label',
			'rules' => 'trim|alpha'
		),
		array(
			'field' => 'created_on',
			'label' => 'lang:blog_date_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'created_on_hour',
			'label' => 'lang:blog_created_hour',
			'rules' => 'trim|numeric|required'
		),
		array(
			'field' => 'created_on_minute',
			'label' => 'lang:blog_created_minute',
			'rules' => 'trim|numeric|required'
		),
                array(
				'field' => 'comments_enabled',
				'label'	=> 'lang:blog_comments_enabled_label',
				'rules'	=> 'trim|numeric'
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

		$this->load->model('blog_m');
		$this->load->model('blog_categories_m');
		$this->lang->load('blog');
		$this->lang->load('categories');

		// Date ranges for select boxes
		$this->data->hours = array_combine($hours = range(0, 23), $hours);
		$this->data->minutes = array_combine($minutes = range(0, 59), $minutes);

		$this->data->categories = array();
		if ($categories = $this->blog_categories_m->order_by('title')->get_all())
		{
			foreach ($categories as $category)
			{
				$this->data->categories[$category->id] = $category->title;
			}
		}

		$this->template
			->append_metadata( css('blog.css', 'blog') )
			->set_partial('shortcuts', 'admin/partials/shortcuts');
	}

	/**
	 * Show all created blog posts
	 * @access public
	 * @return void
	 */
	public function index()
	{
		//set the base/default where clause
		$base_where = array('show_future' => TRUE, 'status' => 'all');

		//add post values to base_where if f_module is posted
		$base_where = $this->input->post('f_category') ? $base_where + array('category' => $this->input->post('f_category')) : $base_where;

		$base_where['status'] = $this->input->post('f_status') ? $this->input->post('f_status') : $base_where['status'];

		$base_where = $this->input->post('f_keywords') ? $base_where + array('keywords' => $this->input->post('f_keywords')) : $base_where;

		// Create pagination links
		$total_rows = $this->blog_m->count_by($base_where);
		$pagination = create_pagination('admin/blog/index', $total_rows);

		// Using this data, get the relevant results
		$blog = $this->blog_m->limit($pagination['limit'])->get_many_by($base_where);

		foreach ($blog as &$post)
		{
			$post->author = $this->ion_auth->get_user($post->author_id);
		}

		//do we need to unset the layout because the request is ajax?
		$this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';

		$this->template
				->title($this->module_details['name'])
				->set_partial('filters', 'admin/partials/filters')
				->append_metadata(js('admin/filter.js'))
				->set('pagination', $pagination)
				->set('blog', $blog)
				->build('admin/index', $this->data);
	}

	/**
	 * Create new post
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
			// They are trying to put this live
			if ($this->input->post('status') == 'live')
			{
				role_or_die('blog', 'put_live');
			}

			$id = $this->blog_m->insert(array(
				'title'				=> $this->input->post('title'),
				'slug'				=> $this->input->post('slug'),
				'category_id'		=> $this->input->post('category_id'),
				'intro'				=> $this->input->post('intro'),
				'body'				=> $this->input->post('body'),
				'status'			=> $this->input->post('status'),
				'created_on'		=> $created_on,
				'comments_enabled'	=> $this->input->post('comments_enabled'),
				'author_id'			=> $this->user->id
			));

			if ($id)
			{
				$this->pyrocache->delete_all('blog_m');
				$this->session->set_flashdata('success', sprintf($this->lang->line('blog_post_add_success'), $this->input->post('title')));
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('blog_post_add_error'));
			}

			// Redirect back to the form or main page
			$this->input->post('btnAction') == 'save_exit' ? redirect('admin/blog') : redirect('admin/blog/edit/' . $id);
		}
		else
		{
			// Go through all the known fields and get the post values
			foreach ($this->validation_rules as $key => $field)
			{
				$post->$field['field'] = set_value($field['field']);
			}
			$post->created_on = $created_on;
		}

		$this->template
				->title($this->module_details['name'], lang('blog_create_title'))
				->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				->append_metadata(js('blog_form.js', 'blog'))
				->set('post', $post)
				->build('admin/form');
	}

	/**
	 * Edit blog post
	 * @access public
	 * @param int $id the ID of the blog post to edit
	 * @return void
	 */
	public function edit($id = 0)
	{
		$id OR redirect('admin/blog');

		$this->load->library('form_validation');

		$this->form_validation->set_rules($this->validation_rules);

		$post = $this->blog_m->get($id);
		$post->author = $this->ion_auth->get_user($post->author_id);

		// If we have a useful date, use it
		if ($this->input->post('created_on'))
		{
			$created_on = strtotime(sprintf('%s %s:%s', $this->input->post('created_on'), $this->input->post('created_on_hour'), $this->input->post('created_on_minute')));
		}

		else
		{
			$created_on = $post->created_on;
		}

		$this->id = $post->id;
		
		if ($this->form_validation->run())
		{
			// They are trying to put this live
			if ($post->status != 'live' and $this->input->post('status') == 'live')
			{
				role_or_die('blog', 'put_live');
			}

			$author_id = empty($post->author) ? $this->user->id : $post->author_id;

			$result = $this->blog_m->update($id, array(
				'title'				=> $this->input->post('title'),
				'slug'				=> $this->input->post('slug'),
				'category_id'		=> $this->input->post('category_id'),
				'intro'				=> $this->input->post('intro'),
				'body'				=> $this->input->post('body'),
				'status'			=> $this->input->post('status'),
				'created_on'		=> $created_on,
				'comments_enabled'	=> $this->input->post('comments_enabled'),
				'author_id'			=> $author_id
			));
			
			if ($result)
			{
				$this->session->set_flashdata(array('success' => sprintf($this->lang->line('blog_edit_success'), $this->input->post('title'))));

				// The twitter module is here, and enabled!
//				if ($this->settings->item('twitter_blog') == 1 && ($post->status != 'live' && $this->input->post('status') == 'live'))
//				{
//					$url = shorten_url('blog/'.$date[2].'/'.str_pad($date[1], 2, '0', STR_PAD_LEFT).'/'.url_title($this->input->post('title')));
//					$this->load->model('twitter/twitter_m');
//					if ( ! $this->twitter_m->update(sprintf($this->lang->line('blog_twitter_posted'), $this->input->post('title'), $url)))
//					{
//						$this->session->set_flashdata('error', lang('blog_twitter_error') . ": " . $this->twitter->last_error['error']);
//					}
//				}
			}
			
			else
			{
				$this->session->set_flashdata(array('error' => $this->lang->line('blog_edit_error')));
			}

			// Redirect back to the form or main page
			$this->input->post('btnAction') == 'save_exit' ? redirect('admin/blog') : redirect('admin/blog/edit/' . $id);
		}

		// Go through all the known fields and get the post values
		foreach (array_keys($this->validation_rules) as $field)
		{
			if (isset($_POST[$field]))
			{
				$post->$field = $this->form_validation->$field;
			}
		}

		$post->created_on = $created_on;
		
		// Load WYSIWYG editor
		$this->template
				->title($this->module_details['name'], sprintf(lang('blog_edit_title'), $post->title))
				->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				->append_metadata(js('blog_form.js', 'blog'))
				->set('post', $post)
				->build('admin/form');
	}

	/**
	 * Preview blog post
	 * @access public
	 * @param int $id the ID of the blog post to preview
	 * @return void
	 */
	public function preview($id = 0)
	{
		$post = $this->blog_m->get($id);

		$this->template
				->set_layout('modal', 'admin')
				->set('post', $post)
				->build('admin/preview');
	}

	/**
	 * Helper method to determine what to do with selected items from form post
	 * @access public
	 * @return void
	 */
	public function action()
	{
		switch ($this->input->post('btnAction'))
		{
			case 'publish':
				role_or_die('blog', 'put_live');
				$this->publish();
				break;
			
			case 'delete':
				role_or_die('blog', 'delete_live');
				$this->delete();
				break;
			
			default:
				redirect('admin/blog');
				break;
		}
	}

	/**
	 * Publish blog post
	 * @access public
	 * @param int $id the ID of the blog post to make public
	 * @return void
	 */
	public function publish($id = 0)
	{
		role_or_die('blog', 'put_live');

		// Publish one
		$ids = ($id) ? array($id) : $this->input->post('action_to');

		if ( ! empty($ids))
		{
			// Go through the array of slugs to publish
			$post_titles = array();
			foreach ($ids as $id)
			{
				// Get the current page so we can grab the id too
				if ($post = $this->blog_m->get($id))
				{
					$this->blog_m->publish($id);

					// Wipe cache for this model, the content has changed
					$this->pyrocache->delete('blog_m');
					$post_titles[] = $post->title;
				}
			}
		}

		// Some posts have been published
		if ( ! empty($post_titles))
		{
			// Only publishing one post
			if (count($post_titles) == 1)
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('blog_publish_success'), $post_titles[0]));
			}
			// Publishing multiple posts
			else
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('blog_mass_publish_success'), implode('", "', $post_titles)));
			}
		}
		// For some reason, none of them were published
		else
		{
			$this->session->set_flashdata('notice', $this->lang->line('blog_publish_error'));
		}

		redirect('admin/blog');
	}

	/**
	 * Delete blog post
	 * @access public
	 * @param int $id the ID of the blog post to delete
	 * @return void
	 */
	public function delete($id = 0)
	{
		// Delete one
		$ids = ($id) ? array($id) : $this->input->post('action_to');

		// Go through the array of slugs to delete
		if ( ! empty($ids))
		{
			$post_titles = array();
			foreach ($ids as $id)
			{
				// Get the current page so we can grab the id too
				if ($post = $this->blog_m->get($id))
				{
					$this->blog_m->delete($id);

					// Wipe cache for this model, the content has changed
					$this->pyrocache->delete('blog_m');
					$post_titles[] = $post->title;
				}
			}
		}

		// Some pages have been deleted
		if ( ! empty($post_titles))
		{
			// Only deleting one page
			if (count($post_titles) == 1)
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('blog_delete_success'), $post_titles[0]));
			}
			// Deleting multiple pages
			else
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('blog_mass_delete_success'), implode('", "', $post_titles)));
			}
		}
		// For some reason, none of them were deleted
		else
		{
			$this->session->set_flashdata('notice', lang('blog_delete_error'));
		}

		redirect('admin/blog');
	}

	/**
	 * Callback method that checks the title of an post
	 * @access public
	 * @param string title The Title to check
	 * @return bool
	 */
	public function _check_title($title = '')
	{
		if ( ! $this->blog_m->check_exists('title', $title, $this->id))
		{
			$this->form_validation->set_message('_check_title', sprintf(lang('blog_already_exist_error'), lang('blog_title_label')));
			return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	 * Callback method that checks the slug of an post
	 * @access public
	 * @param string slug The Slug to check
	 * @return bool
	 */
	public function _check_slug($slug = '')
	{
		if ( ! $this->blog_m->check_exists('slug', $slug, $this->id))
		{
			$this->form_validation->set_message('_check_slug', sprintf(lang('blog_already_exist_error'), lang('blog_slug_label')));
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * method to fetch filtered results for blog list
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
		$results = $this->blog_m->search($post_data);

		//set the layout to false and load the view
		$this->template
				->set_layout(FALSE)
				->set('blog', $results)
				->build('admin/index');
	}
}
