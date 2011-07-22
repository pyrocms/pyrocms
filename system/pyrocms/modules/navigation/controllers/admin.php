<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin controller for the navigation module. Handles actions such as editing links or creating new ones.
 *
 * @package 		PyroCMS
 * @subpackage 		Navigation module
 * @category		Modules
 * @author			Phil Sturgeon - PyroCMS Development Team
 * @author			Jerel Unruh - PyroCMS Development Team
 *
 */
class Admin extends Admin_Controller
{
	/**
	 * The array containing the rules for the navigation items
	 * @var array
	 * @access private
	 */
	private $validation_rules 	= array(
		array(
			'field' => 'title',
			'label'	=> 'lang:nav_title_label',
			'rules'	=> 'trim|required|max_length[40]'
		),
		array(
			'field' => 'link_type',
			'label'	=> 'lang:nav_type_label',
			'rules'	=> 'trim|required|alpha'
		),
		array(
			'field' => 'url',
			'label'	=> 'lang:nav_url_label',
			'rules'	=> 'trim'
		),
		array(
			'field' => 'uri',
			'label'	=> 'lang:nav_uri_label',
			'rules'	=> 'trim'
		),
		array(
			'field' => 'module_name',
			'label'	=> 'lang:nav_module_label',
			'rules'	=> 'trim|alpha_dash'
		),
		array(
			'field' => 'page_id',
			'label'	=> 'lang:nav_page_label',
			'rules'	=> 'trim|numeric'
		),
		array(
			'field' => 'navigation_group_id',
			'label'	=> 'lang:nav_group_label',
			'rules'	=> 'trim|numeric'
		),
		array(
			'field' => 'current_group_id',
			'label'	=> 'lang:nav_group_label',
			'rules'	=> 'trim|numeric'
		),
		array(
			'field' => 'target',
			'label'	=> 'lang:nav_target_label',
			'rules'	=> 'trim|max_length[10]'
		),
		array(
			'field' => 'class',
			'label'	=> 'lang:nav_class_label',
			'rules'	=> 'trim'
		)
	);

	/**
	 * Constructor method
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->library('form_validation');
		$this->load->model('navigation_m');
		$this->load->model('pages/pages_m');
		$this->lang->load('navigation');

	    $this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
	    $this->template->append_metadata( js('navigation.js', 'navigation') );
		$this->template->append_metadata( css('navigation.css', 'navigation') );

		// Get Navigation Groups
		$this->data->groups 		= $this->navigation_m->get_groups();
		$this->data->groups_select 	= array_for_select($this->data->groups, 'id', 'title');
		$all_modules				= $this->module_m->get_all(array('is_frontend'=>true));

		//only allow modules that user has permissions for
		foreach($all_modules as $module)
		{
			if(in_array($module['slug'], $this->permissions) OR $this->user->group == 'admin') $modules[] = $module;
		}
		
		$this->data->modules_select = array_for_select($modules, 'slug', 'name');

		// Get Pages and create pages tree
		$tree = array();

		if ($pages = $this->pages_m->get_all())
		{
			foreach($pages AS $page)
			{
				$tree[$page->parent_id][] = $page;
			}
		}

		unset($pages);
		$this->data->pages_select = $tree;

		// Set the validation rules for the navigation items
		$this->form_validation->set_rules($this->validation_rules);
	}

	/**
	 * List all navigation elements
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Go through all the groups
		foreach($this->data->groups as $group)
		{
			//... and get navigation links for each one
			$this->data->navigation[$group->id] = $this->navigation_m->get_link_tree($group->id);
		}
		
		$this->data->controller =& $this;
		
		// Create the layout
		$this->template
			->append_metadata( js('jquery/jquery.ui.nestedSortable.js') )
			->append_metadata( js('jquery/jquery.cooki.js') )
			->title($this->module_details['name'])
			->build('admin/index', $this->data);
	}
	
	/**
	 * Order the links and record their children
	 * 
	 * @access public
	 * @return string json message
	 */
	public function order()
	{
		$order = $this->input->post('order');
		$group = (int) $this->input->post('group');

		if (is_array($order))
		{
			//reset all parent > child relations
			$this->navigation_m->update_by_group($group, array('parent' => 0));
			
			foreach ($order as $i => $link)
			{
				//set the order of the root links
				$this->navigation_m->update_by('id', str_replace('link_', '', $link['id']), array('position' => $i));
				
				//iterate through children and set their order and parent
				$this->navigation_m->_set_children($link);
			}
			
			$this->pyrocache->delete_all('navigation_m');
				
			echo 'Success';
		}
		else
		{
			echo 'Fail';
		}
	}

	/**
	 * Get the details of a link using Ajax
	 * @access public
	 * @param int $link_id The ID of the link
	 * @return void
	 */
	public function ajax_link_details($link_id)
	{
		$link = $this->navigation_m->get_url($link_id);

		$this->load->view('admin/ajax/link_details', array('link' => $link['0']));
	}

	/**
	 * Create a new navigation item
	 * @access public
	 * @return void
	 */
	public function create($group_id = '')
	{
		// Run if valid
		if ($this->form_validation->run())
		{
			// Got post?
			if ($this->navigation_m->insert_link($_POST) > 0)
			{
				$this->pyrocache->delete_all('navigation_m');
				
				$this->session->set_flashdata('success', lang('nav_link_add_success'));
				
				// echo success to let the js refresh the page
				echo 'success';
				return;
			}
			else
			{
				$this->data->messages['error'] = lang('nav_link_add_error');
				
				echo $this->load->view('admin/partials/notices', $this->data);
				return;
			}
		}
		
		// check for errors
		if (validation_errors())
		{
			echo $this->load->view('admin/partials/notices', $this->data);
			return;
		}

		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			$this->data->navigation_link->{$rule['field']} = set_value($rule['field']);
		}
		
		$this->data->navigation_link->navigation_group_id = $group_id;

		// Get Pages and create pages tree
		$this->data->tree_select = $this->_build_tree_select(array('current_parent' => $this->data->navigation_link->page_id));

		$this->load->view('admin/ajax/form', $this->data);
	}

	/**
	 * Edit a navigation item
	 * @access public
	 * @param int $id The ID of the navigation item
	 * @return void
	 */
	public function edit($id = 0)
	{
		// Got ID?
		if (empty($id))
		{
			return;
		}

		// Get the navigation item based on the ID
		$this->data->navigation_link = $this->navigation_m->get_link($id);

		if ( ! $this->data->navigation_link)
		{
			$this->data->messages['error'] = lang('nav_link_not_exist_error');
			
			echo $this->load->view('admin/partials/notices', $this->data);
			return;
		}

		// Valid data?
		if ($this->form_validation->run())
		{
			// Update the link and flush the cache
			$this->navigation_m->update_link($id, $_POST);
			$this->pyrocache->delete_all('navigation_m');
			
			$this->session->set_flashdata('success', lang('nav_link_edit_success'));
				
			// echo success to let the js refresh the page
			echo 'success';
			return;
		}
		
		// check for errors
		if (validation_errors())
		{	
			echo $this->load->view('admin/partials/notices', $this->data);
			return;
		}

		// Loop through each rule
		foreach($this->validation_rules as $rule)
		{
			if($this->input->post($rule['field']) !== FALSE)
			{
				$this->data->navigation_link->{$rule['field']} = $this->input->post($rule['field']);
			}
		}

		// Get Pages and create pages tree
		$this->data->tree_select = $this->_build_tree_select(array('current_parent' => $this->data->navigation_link->page_id));

		// Render the view
		$this->load->view('admin/ajax/form', $this->data);
	}

	/**
	 * Delete an existing navigation link
	 * @access public
	 * @param int $id The ID of the navigation link
	 * @return void
	 */
	public function delete($id = 0)
	{
		$id_array = (!empty($id)) ? array($id) : $this->input->post('action_to');

		// Loop through each item to delete
		if(!empty($id_array))
		{
			foreach ($id_array as $id)
			{
				$this->navigation_m->delete_link($id);
			}
		}
		// Flush the cache and redirect
		$this->pyrocache->delete_all('navigation_m');
		$this->session->set_flashdata('success', $this->lang->line('nav_link_delete_success'));
		redirect('admin/navigation');
	}
	
	/**
	 * Tree select function
	 *
	 * Creates a tree to form select
	 *
	 * @param	array
	 * @return	array
	 */
	function _build_tree_select($params)
	{
		$params = array_merge(array(
			'tree'			=> array(),
			'parent_id'		=> 0,
			'current_parent'=> 0,
			'current_id'	=> 0,
			'level'			=> 0
		), $params);

		extract($params);

		if ( ! $tree)
		{
			if ($pages = $this->db->select('id, parent_id, title')->get('pages')->result())
			{
				foreach($pages as $page)
				{
					$tree[$page->parent_id][] = $page;
				}
			}
		}

		if ( ! isset($tree[$parent_id]))
		{
			return;
		}

		$html = '';

		foreach ($tree[$parent_id] as $item)
		{
			if ($current_id == $item->id)
			{
				continue;
			}

			$html .= '<option value="' . $item->id . '"';
			$html .= $current_parent == $item->id ? ' selected="selected">': '>';

			if ($level > 0) 
			{
				for ($i = 0; $i < ($level*2); $i++)
				{
					$html .= '&nbsp;';
				}

				$html .= '-&nbsp;';
			}

			$html .= $item->title . '</option>';

			$html .= $this->_build_tree_select(array(
				'tree'			=> $tree,
				'parent_id'		=> (int) $item->id,
				'current_parent'=> $current_parent,
				'current_id'	=> $current_id,
				'level'			=> $level + 1
			));
		}

		return $html;
	}

	/**
	 * Build the html for the admin link tree view
	 *
	 * @author Jerel Unruh - PyroCMS Dev Team
	 * @access public
	 * @param array $link Current navigation link
	 */
	public function tree_builder($link, $group_id)
	{
		if ($link['children']):
		
				foreach($link['children'] as $link): ?>
			
					<li id="link_<?php echo $link['id']; ?>">
						<div>
							<a href="#" rel="<?php echo $group_id . '" alt="' . $link['id'] .'">' . $link['title']; ?></a>
						</div>
					
				<?php if ($link['children']): ?>
						<ol>
								<?php $this->tree_builder($link, $group_id); ?>
						</ol>
					</li>
				<?php else: ?>
					</li>
				<?php endif; ?>
				
			<?php endforeach; ?>
			
		<?php endif;
	}
}
?>