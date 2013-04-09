<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Permissions Plugin
 *
 * Methods that help determine a user's correct permission level
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Variables\Plugins
 */
class Plugin_Permissions extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Permissions',
		'it' => 'Permessi',
            'fa' => 'اجازه ها',
	);
	public $description = array(
		'en' => 'Access the current user\'s permission level.',
		'it' => 'Accedi al livello di permessi dell\'utente corrente.',
            'fa' => 'دسترسی به سطح دسترسی کاربر حاضر'
	);

	/**
	 * Returns a PluginDoc array
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'admin' => array(
				'single' => true,
				'double' => true,
				'variables' => '',
				'attributes' => array(),
				),
			);

		// dynamically build the array for the magic method __call
		$modules = $this->module_m->get_all(array('installed' => true));

		foreach ($modules as $module)
		{
			$info[$module['slug']]['description'] = array('en' => 'Check if the user has permissions for the '.$module['name'].' module. A single tag returns true or false while a double tag protects its content');
			$info[$module['slug']]['single'] = true;
			$info[$module['slug']]['double'] = true;
			$info[$module['slug']]['variables'] = '';
			
			$roles = implode('|', $this->module_m->roles($module['slug']));

			if ($roles)
			{
				$info[$module['slug']]['params'] = array(
					'can' => array(
						'type' => 'flag',
						'flags' => $roles,
						'default' => '',
						'required' => false,
						),
					);
			}
			else
			{
				$info[$module['slug']]['params'] = array();
			}
		}

		return $info;
	}

	/**
	 * Admin
	 *
	 * Creates a simple alias to {{ if user:group == 'admin' }}
	 *
	 * {{ permissions:admin }}
	 *     // Ooh you got privileges!
	 * {{ /permissions:admin }}
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function admin($name, $arguments)
	{
		if ($this->current_user and $this->current_user->group === 'admin')
		{
			return $this->content() ? $this->content() : true;
		}

		return false;
	}

	/**
	 * Check a user's permission
	 *
	 * {{ permissions:blog can="put_live"}}
	 *     // Ooh you got privileges!
	 * {{ /permissions:blog }}
	 *
	 * @param string $name
	 * @param string $data
	 *
	 * @return string
	 */
	public function __call($name, $data)
	{
		// not logged in? Nothing for you.
		if ( ! $this->current_user) return false;

		// you're an admin? Do anything you like.
		if ($this->current_user->group === 'admin')
		{
			return $this->content() ? $this->content() : true;
		}

		$sub_permission = $this->attribute('can');

		// they have access to the module
		if (isset($this->permissions[$name]))
		{
			// is a sub-permission specified? If so make sure they have that permission
			if ($sub_permission and ! isset($this->permissions[$name][$sub_permission]))
			{
				return false;
			}

			return $this->content() ? $this->content() : true;
		}

		return false;
	}
}

/* End of file plugin.php */