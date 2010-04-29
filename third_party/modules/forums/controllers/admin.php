<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 0.9.8-rc2
 * @filesource
 */

/**
 * PyroCMS Forums Admin Controller
 *
 * Provides an admin for the forums module.
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @package		PyroCMS
 * @subpackage	Forums
 */
class Admin extends Admin_Controller {

	/**
	 * @access	private
	 * @var		array	Contains form validation rules.
	 */
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

	/**
	 * Constructor
	 *
	 * Loads dependencies.
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		parent::Admin_Controller();

		$this->load->model('forums_m');
		$this->load->model('forum_categories_m');
		$this->lang->load('forums');

		$this->template->set_partial('sidebar', 'admin/sidebar');
	}
	
	/**
	 * Index
	 *
	 * Lists categories.
	 *
	 * @access	public
	 * @return	void
	 */
	public function index()
	{
		$categories = $this->forum_categories_m->get_all();

		$this->data->categories = &$categories;

		$this->template->build('admin/index', $this->data);
	}

	/**
	 * List Forums
	 * 
	 * Lists all the forums.
	 * 
	 * @access	public
	 * @return	void
	 */
	public function list_forums()
	{
		$this->db->select('forums.id, forums.title, forum_categories.title as category');
		$this->db->join('forum_categories', 'forums.category_id = forum_categories.id');
		$this->db->order_by('category', 'ASC');
		$forums = $this->forums_m->get_all();

		$this->data->forums = &$forums;

		$this->template->build('admin/forums', $this->data);
	}

	/**
	 * Create Category
	 *
	 * Displays a form to create a category.
	 * Creates the category if it passes form validation.
	 *
	 * @todo	Check for duplicate categories.
	 * @access	public
	 * @return	void
	 */
	public function create_category()
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

	/**
	 * Edit Category
	 * 
	 * Allows admins to edit a category
	 * 
	 * @param	int	The id of the category to edit.
	 * @access	public
	 * @return void
	 */
	public function edit_category($id)
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

	/**
	 * Create Forum
	 *
	 * Displays a form to create a forum.
	 * Creates the forum if it passes form validation.
	 *
	 * @todo	Check for duplicate forums.
	 * @access	public
	 * @return	void
	 */
	public function create_forum()
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

	/**
	 * Edit Forum
	 *
	 * Allows admins to edit forums.
	 *
	 * @param	int	The id of the forum to edit.
	 * @access	public
	 * @return	void
	 */
	public function edit_forum($id)
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

	/**
	 * Delete
	 *
	 * This deletes both categories and forums (based on $type).
	 * It recursivly deletes all children.
	 *
	 * @param	string	The type of item to delete.
	 * @param	int		The id of the category or forum to delete.
	 * @access	public
	 * @return	void
	 */
	public function delete($type, $id)
	{
		switch ($type) {
			// Delete the category
			case 'category':
				$this->load->model('forum_posts_m');
				$this->load->model('forum_subscriptions_m');

				// Delete the category
				$this->forum_categories_m->delete($id);

				// Loop through all the forums in the category
				foreach($this->forums_m->get_many_by('category_id =', $id) as $forum)
				{
					// Loop through all the topics in the forum
					foreach($this->forum_posts_m->get_many_by(array('forum_id' => $forum->id, 'parent_id' => '0')) as $topic)
					{
						// Delete the subscriptions to the topic
						$this->forum_subscriptions_m->delete_by('topic_id', $topic->id);
					}
					// Delete all the topics and replies
					$this->forum_posts_m->delete_by('forum_id', $forum->id);
				}

				// Delete all the forums
				$this->forums_m->delete_by('category_id =', $id);

				$this->session->set_flashdata('success', $this->lang->line('forums_category_delete_success'));
				redirect('/admin/forums');
				break;

			// Delete the forum
			case 'forum':
				$this->load->model('forum_posts_m');
				$this->load->model('forum_subscriptions_m');

				// Delete the forum
				$this->forums_m->delete($id);

				// Loop through all the topics in the forum
				foreach($this->forum_posts_m->get_many_by(array('forum_id' => $id, 'parent_id' => '0')) as $topic)
				{
					// Delete the subscriptions to the topic
					$this->forum_subscriptions_m->delete_by('topic_id', $topic->id);
				}
				
				// Delete all the topics
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
