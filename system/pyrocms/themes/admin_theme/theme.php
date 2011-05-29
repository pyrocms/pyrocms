<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Admin_theme extends Theme {

    public $name			= 'PyroCMS Admin Theme';
    public $author			= 'PyroCMS Dev Team';
    public $author_website	= 'http://pyrocms.com/';
    public $website			= 'http://pyrocms.com/';
    public $description		= 'Default PyroCMS v1.0 Admin Theme - Vertical navigation, CSS3 styling.';
    public $version			= '1.0';
	public $type			= 'admin';

	/**
	 * Initialize is automatically ran when the theme is loaded for use
	 *
	 * This should contain the main logic for the theme.
	 *
	 * @access	public
	 * @return	void
	 */
	public function initialize()
	{
		self::generate_menu();
	}
	
	private function generate_menu()
	{
		// Get a list of all modules available to this user/group
		if ($this->user)
		{
			$modules = $this->module_m->get_all(array(
				'is_backend' => TRUE,
				'group' => $this->user->group,
				'lang' => CURRENT_LANGUAGE
			));

			$grouped_modules = array();

			$grouped_menu[] = 'content';

			foreach ($modules as $module)
			{
				if ($module['menu'] != 'content' && $module['menu'] != 'design' && $module['menu'] != 'users' && $module['menu'] != 'utilities' && $module['menu'] != '0')
				{
					$grouped_menu[] = $module['menu'];
				}
			}

			array_push($grouped_menu, 'design', 'users', 'utilities');

			$grouped_menu = array_unique($grouped_menu);

			foreach ($modules as $module)
			{
				$grouped_modules[$module['menu']][$module['name']] = $module;
			}

			// pass them on as template variables
			$this->template->menu_items = $grouped_menu;
			$this->template->modules = $grouped_modules;
		}
	}
}

/* End of file theme.php */