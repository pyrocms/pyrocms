<nav id="main-nav">
	<ul>
		<li><?php echo anchor('admin', lang('cp_admin_home_title'), 'class="top-link no-submenu' . (!$this->module > '' ? ' current' : '').'"');?></li>

		<?php
		foreach ($menu_items as $menu_item)
		{
			$count = 0;

			//Let's see how many menu items they have access to
			if ($this->user->group == 'admin')
			{
				$count = count($modules[$menu_item]);
			}
			else
			{
				if (array_key_exists($menu_item, $modules)) 
				{
					foreach ($modules[$menu_item] as $module)
					{
						$count += array_key_exists($module['slug'], $this->permissions) ? 1 : 0;
					}
				}
				
			}

			// If we are in the users menu, we have to account for the hacked link below
			if ($menu_item == 'users')
			{
				$count += (array_key_exists('users', $this->permissions) OR $this->user->group == 'admin') ? 1 : 0;
			}

			// If they only have access to one item in this menu, why not just have it as the main link?
			if ($count > 0)
			{
				// They have access to more than one menu item, so create a drop menu
				if ($count > 1 )
				{
					echo '<li>';

					$name = lang('cp_nav_'.$menu_item)!=''&&lang('cp_nav_'.$menu_item)!=NULL ? lang('cp_nav_'.$menu_item) : $menu_item;
					$current = (($this->module_details && $this->module_details['menu'] == $menu_item) or $menu_item == $this->module);
					$class = $current ? "top-link current" : "top-link";
					echo anchor('#', $name, array('class' => $class));

					echo '<ul>';
					
				// User has access to Users module only, no other users item
				} 
				elseif ($count == 1 AND ($this->module == 'users' OR $this->module == '') AND $menu_item == 'users') 
				{
					echo '<li>' . anchor('admin/users', lang('cp_manage_users'), array('style' => 'font-weight: bold;', 'class' => $this->module == 'users' ? 'top-link no-submenu  current' : 'top-link no-submenu ')) . '</li>';
				}
				
				// Not a big fan of the following hack, if a module needs two navigation links, we should be able to define that
				if ( (array_key_exists('users', $this->permissions) OR $this->user->group == 'admin') AND $menu_item == 'users' AND $count != 1)
				{
					echo '<li>' . anchor('admin/users', lang('cp_manage_users'), 'class="' . (($this->module == 'users') ? ' current"' : '"')) . '</li>';
				} 

				//Lets get the sub-menu links, or parent link if that is the case
				if (array_key_exists($menu_item, $modules)) 
				{
					if (is_array($modules[$menu_item])) 
					{
						ksort($modules[$menu_item]);
					}
						
					foreach ($modules[$menu_item] as $module)
					{
						if (lang('cp_nav_'.$module['slug'])!=''&&lang('cp_nav_'.$module['slug'])!=NULL)
						{
							$module['name'] = lang('cp_nav_'.$module['slug']);
						}
						$current = $this->module == $module['slug'];
						$class = $current ? "current " : "";
						$class .= $count <= 1 ? "top-link no-submenu " : "";
						
						if (array_key_exists($module['slug'], $this->permissions) OR $this->user->group == 'admin')
						{
							echo '<li>' . anchor('admin/'.$module['slug'], $module['name'], array('class'=>$class)) . '</li>';
						}
					}
				}
			}
			
			// They have access to more than one menu item, so close the drop menu
			if ($count > 1)
			{
				echo '</ul>';
				echo '</li>';
			}
		}
		?>

		<?php if (array_key_exists('settings', $this->permissions) OR $this->user->group == 'admin'): ?>
		<li><?php echo anchor('admin/settings', lang('cp_nav_settings'), 'class="top-link no-submenu' . (($this->module == 'settings') ? ' current"' : '"'));?></li>
		<?php endif; ?>

		<?php if (array_key_exists('modules', $this->permissions) OR $this->user->group == 'admin'): ?>
		<li><?php echo anchor('admin/modules', lang('cp_nav_addons'), 'class="last top-link no-submenu' . (($this->module == 'modules') ? ' current"' : '"'));?></li>
		<?php endif; ?>

	</ul>
</nav>
