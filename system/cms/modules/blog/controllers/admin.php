<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog\Controllers
 */
class Admin extends Admin_Controller
{
	/** @var string The current active section */
	protected $section = 'posts';

	/** @var array The validation rules */
	protected $validation_rules = array(
		'title' => array(
			'field' => 'title',
			'label' => 'lang:global:title',
			'rules' => 'trim|htmlspecialchars|required|max_length[200]|callback__check_title'
		),
		'slug' => array(
			'field' => 'slug',
			'label' => 'lang:global:slug',
			'rules' => 'trim|required|alpha_dot_dash|max_length[200]|callback__check_slug'
		),
		array(
			'field' => 'category_id',
			'label' => 'lang:blog:category_label',
			'rules' => 'trim|numeric'
		),
		array(
			'field' => 'keywords',
			'label' => 'lang:global:keywords',
			'rules' => 'trim'
		),
		array(
			'field' => 'body',
			'label' => 'lang:blog:content_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'status',
			'label' => 'lang:blog:status_label',
			'rules' => 'trim|alpha'
		),
		array(
			'field' => 'created_on',
			'label' => 'lang:blog:date_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'created_on_hour',
			'label' => 'lang:blog:created_hour',
			'rules' => 'trim|numeric|required'
		),
		array(
			'field' => 'created_on_minute',
			'label' => 'lang:blog:created_minute',
			'rules' => 'trim|numeric|required'
		),
		array(
			'field' => 'comments_enabled',
			'label' => 'lang:blog:comments_enabled_label',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'preview_hash',
			'label' => '',
			'rules' => 'trim'
		)
	);

	/**
	 * Every time this controller controller is called should:
	 * - load the blog and blog_categories models
	 * - load the keywords and form validation libraries
	 * - set the hours, minutes and categories template variables.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('blog_m', 'blog_categories_m'));
		$this->lang->load(array('blog', 'categories'));

		$this->load->library(array('keywords/keywords', 'form_validation'));

		$_categories = array();
		if ($categories = $this->blog_categories_m->order_by('title')->get_all())
		{
			foreach ($categories as $category)
			{
				$_categories[$category->id] = $category->title;
			}
		}

		// Date ranges for select boxes
		$this->template
			->set('hours', array_combine($hours = range(0, 23), $hours))
			->set('minutes', array_combine($minutes = range(0, 59), $minutes))
			->set('categories', $_categories)

			->append_css('module::blog.css');
	}

	/**
	 * Show all created blog posts
	 */
	public function index()
	{
		//set the base/default where clause
		$base_where = array('show_future' => true, 'status' => 'all');

		//add post values to base_where if f_module is posted
		if ($this->input->post('f_category'))
		{
			$base_where['category'] = $this->input->post('f_category');
		}

		if ($this->input->post('f_status'))
		{
			$base_where['status'] = $this->input->post('f_status');
		}

		if ($this->input->post('f_keywords'))
		{
			$base_where['keywords'] = $this->input->post('f_keywords');
		}

		// Create pagination links
		$total_rows = $this->blog_m->count_by($base_where);
		$pagination = create_pagination('admin/blog/index', $total_rows);

		// Using this data, get the relevant results
		$blog = $this->blog_m
			->limit($pagination['limit'], $pagination['offset'])
			->get_many_by($base_where);

		//do we need to unset the layout because the request is ajax?
		$this->input->is_ajax_request() and $this->template->set_layout(false);

		$this->template
			->title($this->module_details['name'])
			->append_js('admin/filter.js')
			->set_partial('filters', 'admin/partials/filters')
			->set('pagination', $pagination)
			->set('blog', $blog);

		$this->input->is_ajax_request()
			? $this->template->build('admin/tables/posts')
			: $this->template->build('admin/index');

	}

	/**
	 * Create new post
	 */
	public function create()
	{
		$post = new stdClass();

		// Get the blog stream.
		$this->load->driver('Streams');
		$stream = $this->streams->streams->get_stream('blog', 'blogs');
		$stream_fields = $this->streams_m->get_stream_fields($stream->id, $stream->stream_namespace);

		// Get the validation for our custom blog fields.
		$blog_validation = $this->streams->streams->validation_array($stream->stream_slug, $stream->stream_namespace, 'new');
		
		// Combine our validation rules.
		$rules = array_merge($this->validation_rules, $blog_validation);

		// Set our validation rules
		$this->form_validation->set_rules($rules);

		if ($this->input->post('created_on'))
		{
			$created_on = strtotime(sprintf('%s %s:%s', $this->input->post('created_on'), $this->input->post('created_on_hour'), $this->input->post('created_on_minute')));
		}
		else
		{
			$created_on = now();
		}
		$hash = $this->_preview_hash();

		if ($this->form_validation->run())
		{
			// They are trying to put this live
			if ($this->input->post('status') == 'live')
			{
				role_or_die('blog', 'put_live');

				$hash = "";
			}

			// Insert a new blog entry.
			// These are the values that we don't pass through streams processing.
			$extra = array(
				'title'            => $this->input->post('title'),
				'slug'             => $this->input->post('slug'),
				'category_id'      => $this->input->post('category_id'),
				'keywords'         => Keywords::process($this->input->post('keywords')),
				'body'             => $this->input->post('body'),
				'status'           => $this->input->post('status'),
				'created_on'       => $created_on,
				'created'		   => date('Y-m-d H:i:s', $created_on),
				'comments_enabled' => $this->input->post('comments_enabled'),
				'author_id'        => $this->current_user->id,
				'type'             => $this->input->post('type'),
				'parsed'           => ($this->input->post('type') == 'markdown') ? parse_markdown($this->input->post('body')) : '',
				'preview_hash'     => $hash
			);

			if ($id = $this->streams->entries->insert_entry($_POST, 'blog', 'blogs', array('created'), $extra))
			{
				$this->pyrocache->delete_all('blog_m');
				$this->session->set_flashdata('success', sprintf($this->lang->line('blog:post_add_success'), $this->input->post('title')));

				// Blog article has been updated, may not be anything to do with publishing though
				Events::trigger('post_created', $id);

				// They are trying to put this live
				if ($this->input->post('status') == 'live')
				{
					// Fire an event, we're posting a new blog!
					Events::trigger('post_published', $id);
				}
			}
			else
			{
				$this->session->set_flashdata('error', lang('blog:post_add_error'));
			}

			// Redirect back to the form or main page
			($this->input->post('btnAction') == 'save_exit') ? redirect('admin/blog') : redirect('admin/blog/edit/'.$id);
		}
		else
		{
			// Go through all the known fields and get the post values
			$post = new stdClass;
			foreach ($this->validation_rules as $key => $field)
			{
				$post->$field['field'] = set_value($field['field']);
			}
			$post->created_on = $created_on;

			// if it's a fresh new article lets show them the advanced editor
			$post->type or $post->type = 'wysiwyg-advanced';
		}

		// Set Values
		$values = $this->fields->set_values($stream_fields, null, 'new');

		// Run stream field events
		$this->fields->run_field_events($stream_fields, array(), $values);

		$this->template
			->title($this->module_details['name'], lang('blog:create_title'))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->append_js('jquery/jquery.tagsinput.js')
			->append_js('module::blog_form.js')
			->append_js('module::blog_category_form.js')
			->append_css('jquery/jquery.tagsinput.css')
			->set('stream_fields', $this->streams->fields->get_stream_fields($stream->stream_slug, $stream->stream_namespace, $values))
			->set('post', $post)
			->build('admin/form');
	}

	/**
	 * Edit blog post
	 *
	 * @param int $id The ID of the blog post to edit
	 */
	public function edit($id = 0)
	{
		$id or redirect('admin/blog');

		$post = $this->blog_m->get($id);

		// If we have keywords before the update, we'll want to remove them from keywords_applied
		$old_keywords_hash = (trim($post->keywords) != '') ? $post->keywords : null;

		$post->keywords = Keywords::get_string($post->keywords);

		// If we have a useful date, use it
		if ($this->input->post('created_on'))
		{
			$created_on = strtotime(sprintf('%s %s:%s', $this->input->post('created_on'), $this->input->post('created_on_hour'), $this->input->post('created_on_minute')));
		}
		else
		{
			$created_on = $post->created_on;
		}

		// Load up streams
		$this->load->driver('Streams');
		$stream = $this->streams->streams->get_stream('blog', 'blogs');
		$stream_fields = $this->streams_m->get_stream_fields($stream->id, $stream->stream_namespace);

		// Get the validation for our custom blog fields.
		$blog_validation = $this->streams->streams->validation_array($stream->stream_slug, $stream->stream_namespace, 'new');
		
		$blog_validation = array_merge($this->validation_rules, array(
			'title' => array(
				'field' => 'title',
				'label' => 'lang:global:title',
				'rules' => 'trim|htmlspecialchars|required|max_length[100]|callback__check_title['.$id.']'
			),
			'slug' => array(
				'field' => 'slug',
				'label' => 'lang:global:slug',
				'rules' => 'trim|required|alpha_dot_dash|max_length[100]|callback__check_slug['.$id.']'
			),
		));

		// Merge and set our validation rules
		$this->form_validation->set_rules(array_merge($this->validation_rules, $blog_validation));

		$hash = $this->input->post('preview_hash');

		if ($this->input->post('status') == 'draft' and $this->input->post('preview_hash') == '')
		{
			$hash = $this->_preview_hash();
		}

		if ($this->form_validation->run())
		{
			// They are trying to put this live
			if ($post->status != 'live' and $this->input->post('status') == 'live')
			{
				role_or_die('blog', 'put_live');
			}

			$author_id = empty($post->display_name) ? $this->current_user->id : $post->author_id;

			$extra = array(
				'title'            => $this->input->post('title'),
				'slug'             => $this->input->post('slug'),
				'category_id'      => $this->input->post('category_id'),
				'keywords'         => Keywords::process($this->input->post('keywords'), $old_keywords_hash),
				'body'             => $this->input->post('body'),
				'status'           => $this->input->post('status'),
				'created_on'       => $created_on,
				'updated_on'       => $created_on,
				'created'		   => date('Y-m-d H:i:s', $created_on),
				'updated'		   => date('Y-m-d H:i:s', $created_on),
				'comments_enabled' => $this->input->post('comments_enabled'),
				'author_id'        => $author_id,
				'type'             => $this->input->post('type'),
				'parsed'           => ($this->input->post('type') == 'markdown') ? parse_markdown($this->input->post('body')) : '',
				'preview_hash'     => $hash,
			);

			if ($this->streams->entries->update_entry($id, $_POST, 'blog', 'blogs', array('updated'), $extra))
			{
				$this->session->set_flashdata(array('success' => sprintf(lang('blog:edit_success'), $this->input->post('title'))));

				// Blog article has been updated, may not be anything to do with publishing though
				Events::trigger('post_updated', $id);

				// They are trying to put this live
				if ($post->status != 'live' and $this->input->post('status') == 'live')
				{
					// Fire an event, we're posting a new blog!
					Events::trigger('post_published', $id);
				}
			}
			else
			{
				$this->session->set_flashdata('error', lang('blog:edit_error'));
			}

			// Redirect back to the form or main page
			($this->input->post('btnAction') == 'save_exit') ? redirect('admin/blog') : redirect('admin/blog/edit/'.$id);
		}

		// Go through all the known fields and get the post values
		foreach ($this->validation_rules as $key => $field)
		{
			if (isset($_POST[$field['field']]))
			{
				$post->$field['field'] = set_value($field['field']);
			}
		}

		$post->created_on = $created_on;

		// Set Values
		$values = $this->fields->set_values($stream_fields, $post, 'edit');

		// Run stream field events
		$this->fields->run_field_events($stream_fields, array(), $values);

		$this->template
			->title($this->module_details['name'], sprintf(lang('blog:edit_title'), $post->title))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->append_js('jquery/jquery.tagsinput.js')
			->append_js('module::blog_form.js')
			->set('stream_fields', $this->streams->fields->get_stream_fields($stream->stream_slug, $stream->stream_namespace, $values))
			->append_css('jquery/jquery.tagsinput.css')
			->set('post', $post)
			->build('admin/form');
	}

	/**
	 * Preview blog post
	 *
	 * @param int $id The ID of the blog post to preview
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
	 */
	public function action()
	{
		switch ($this->input->post('btnAction'))
		{
			case 'publish':
				$this->publish();
				break;

			case 'delete':
				$this->delete();
				break;

			default:
				redirect('admin/blog');
				break;
		}
	}

	/**
	 * Publish blog post
	 *
	 * @param int $id the ID of the blog post to make public
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
				$this->session->set_flashdata('success', sprintf($this->lang->line('blog:publish_success'), $post_titles[0]));
			}
			// Publishing multiple posts
			else
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('blog:mass_publish_success'), implode('", "', $post_titles)));
			}
		}
		// For some reason, none of them were published
		else
		{
			$this->session->set_flashdata('notice', $this->lang->line('blog:publish_error'));
		}

		redirect('admin/blog');
	}

	/**
	 * Delete blog post
	 *
	 * @param int $id The ID of the blog post to delete
	 */
	public function delete($id = 0)
	{
		$this->load->model('comments/comment_m');

		role_or_die('blog', 'delete_live');

		// Delete one
		$ids = ($id) ? array($id) : $this->input->post('action_to');

		// Go through the array of slugs to delete
		if ( ! empty($ids))
		{
			$post_titles = array();
			$deleted_ids = array();
			foreach ($ids as $id)
			{
				// Get the current page so we can grab the id too
				if ($post = $this->blog_m->get($id))
				{
					if ($this->blog_m->delete($id))
					{
						$this->comment_m->where('module', 'blog')->delete_by('entry_id', $id);

						// Wipe cache for this model, the content has changed
						$this->pyrocache->delete('blog_m');
						$post_titles[] = $post->title;
						$deleted_ids[] = $id;
					}
				}
			}

			// Fire an event. We've deleted one or more blog posts.
			Events::trigger('post_deleted', $deleted_ids);
		}

		// Some pages have been deleted
		if ( ! empty($post_titles))
		{
			// Only deleting one page
			if (count($post_titles) == 1)
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('blog:delete_success'), $post_titles[0]));
			}
			// Deleting multiple pages
			else
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('blog:mass_delete_success'), implode('", "', $post_titles)));
			}
		}
		// For some reason, none of them were deleted
		else
		{
			$this->session->set_flashdata('notice', lang('blog:delete_error'));
		}

		redirect('admin/blog');
	}

	/**
	 * Callback method that checks the title of an post
	 *
	 * @param string $title The Title to check
	 * @param string $id
	 *
	 * @return bool
	 */
	public function _check_title($title, $id = null)
	{
		$this->form_validation->set_message('_check_title', sprintf(lang('blog:already_exist_error'), lang('global:title')));

		return $this->blog_m->check_exists('title', $title, $id);
	}

	/**
	 * Callback method that checks the slug of an post
	 *
	 * @param string $slug The Slug to check
	 * @param null   $id
	 *
	 * @return bool
	 */
	public function _check_slug($slug, $id = null)
	{
		$this->form_validation->set_message('_check_slug', sprintf(lang('blog:already_exist_error'), lang('global:slug')));

		return $this->blog_m->check_exists('slug', $slug, $id);
	}

	/**
	 * Generate a preview hash
	 *
	 * @return bool
	 */
	private function _preview_hash()
	{
		return md5(microtime() + mt_rand(0, 1000));
	}
}
