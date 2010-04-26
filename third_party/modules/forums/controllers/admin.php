<?php

class Admin extends Admin_Controller {

	private $rules = array('category' => array (
							array ('field'   => 'title',
								   'label'   => 'Title',
								   'rules'   => 'trim|xss_clean|required|max_length[100]')
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

	function edit($type, $id)
	{
		switch ($type) {
			case 'category':

				break;
			case 'forum':
				
				break;

			default:
				break;
		}
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
		$this->template->build('admin/form', $this->data);
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
		$this->template->build('admin/form', $this->data);
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
				
				break;

			default:
				break;
		}
	}
}
?>
