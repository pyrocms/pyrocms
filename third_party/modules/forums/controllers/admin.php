<?php

class Admin extends Admin_Controller {

	private $rules = array(
		'category' => array (
							array (
								'field'   => 'title',
								'label'   => 'Title',
								'rules'   => 'trim|xss_clean|required|max_length[100]'
							)
						),
		'forum' => array (
							array (
								'field'   => 'title',
								'label'   => 'Title',
								'rules'   => 'trim|xss_clean|required|max_length[100]'
							),
							array (
								'field'   => 'description',
								'label'   => 'Description',
								'rules'   => 'trim|xss_clean|required|max_length[255]'
							)
						)
					);

	function __construct()
	{
		parent::Admin_Controller();

		$this->load->model('forums_m');
		$this->load->model('forum_categories_m');
		$this->lang->load('forums');

		$this->template->set_partial('sidebar', 'admin/sidebar');
	}
	
	##### index #####
	function index()
	{
		$categories = $this->forum_categories_m->get_all();

		$this->load->vars(array(
			'categories' => &$categories
		));

		$this->template->build('admin/index', $this->data);
	}

	function list_forums()
	{
		$this->db->select('forums.id, forums.title, forum_categories.title as category');
		$this->db->join('forum_categories', 'forums.category_id = forum_categories.id');
		$this->db->order_by('category', 'ASC');
		$forums = $this->forums_m->get_all();

		$this->load->vars(array(
			'forums' => &$forums
		));

		$this->template->build('admin/forums', $this->data);
	}

	function create_category()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->rules['category']);

		$category->id = 0;
		$category->title = set_value('title');

		if ($this->form_validation->run())
		{
			if($this->forum_categories_m->insert(array('title' => $this->input->post('title'))))
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('forums_category_add_success'), $this->input->post('title')));
				redirect('/admin/forums');
			}

		}

		$this->data->category =& $category;
		$this->template->build('admin/category_form', $this->data);
	}

	function edit_category($id)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->rules['category']);

		$category = $this->forum_categories_m->get($id);

		if ($this->form_validation->run())
		{

			if($this->forum_categories_m->update($this->input->post('id'), array('title' => $this->input->post('title'))))
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('forums_category_edit_success'), $this->input->post('title')));
				redirect('/admin/forums');
			}
			$category->title = set_value('title');
		}

		$this->data->category =& $category;
		$this->template->build('admin/category_form', $this->data);
	}

	function create_forum()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->rules['forum']);

		$forum->id = 0;
		$forum->title = set_value('title');
		$forum->description = set_value('title');
		$forum->category = set_value('category');

		$cats = $this->forum_categories_m->get_all();
		foreach($cats as $cat)
		{
			$forum->categories[$cat->id] = $cat->title;
		}
		if ($this->form_validation->run())
		{
			if($this->forums_m->insert(array('title' => $this->input->post('title'), 'description' => $this->input->post('description'), 'category_id' => $this->input->post('category'))))
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('forums_forum_add_success'), $this->input->post('title')));
				redirect('/admin/forums/list_forums');
			}

		}

		$this->data->forum =& $forum;
		$this->template->build('admin/forum_form', $this->data);
	}

	function edit_forum($id)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->rules['forum']);

		$forum = $this->forums_m->get($id);

		$cats = $this->forum_categories_m->get_all();
		foreach($cats as $cat)
		{
			$forum->categories[$cat->id] = $cat->title;
		}

		if ($this->form_validation->run())
		{
			if($this->forums_m->update($this->input->post('id'), array('title' => $this->input->post('title'), 'description' => $this->input->post('description'), 'category_id' => $this->input->post('category'))))
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('forums_forum_add_success'), $this->input->post('title')));
				redirect('/admin/forums/list_forums');
			}
			$forum->title = set_value('title');
			$forum->description = set_value('description');
			$forum->category = set_value('category');
		}
		$forum->category = $forum->category_id;
		$this->data->forum =& $forum;
		$this->template->build('admin/forum_form', $this->data);
	}


	function delete($type, $id)
	{
		switch ($type) {
			case 'category':
				$this->load->model('forum_posts_m');
				$this->load->model('forum_subscriptions_m');
				$this->forum_categories_m->delete($id);
				foreach($this->forums_m->get_many_by('category_id =', $id) as $forum)
				{
					foreach($this->forum_posts_m->get_many_by(array('forum_id' => $forum->id, 'parent_id' => '0')) as $topic)
					{
						$this->forum_subscriptions_m->delete_by('topic_id', $topic->id);
					}
					$this->forum_posts_m->delete_by('forum_id', $forum->id);
				}
				$this->forums_m->delete_by('category_id =', $id);
				$this->session->set_flashdata('success', $this->lang->line('forums_category_delete_success'));
				redirect('/admin/forums');
				break;
			case 'forum':
				$this->load->model('forum_posts_m');
				$this->load->model('forum_subscriptions_m');
				$this->forums_m->delete($id);

				foreach($this->forum_posts_m->get_many_by(array('forum_id' => $id, 'parent_id' => '0')) as $topic)
				{
					$this->forum_subscriptions_m->delete_by('topic_id', $topic->id);
				}
				$this->forum_posts_m->delete_by('forum_id', $id);

				$this->session->set_flashdata('success', $this->lang->line('forums_forum_delete_success'));
				redirect('/admin/forums/list_forums');
				break;

			default:
				break;
		}
	}
}
?>
