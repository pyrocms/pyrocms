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
				foreach ($modules[$menu_item] as $module)
				{
					$count += in_array($module['slug'], $this->permissions) ? 1 : 0;
				}
			}

			// If we are in the users menu, we have to account for the hacked link below
			if ($menu_item == 'users')
			{
				$count += (in_array('users', $this->permissions) OR $this->user->group == 'admin') ? 1 : 0;
			}

			// If they only have access to one item in this menu, why not just have it as the main link?
			if ($count > 0)
			{
				// They have access to more than one menu item, so create a drop menu
				if ($count > 1)
				{
					echo '<li>';

					$name = lang('cp_nav_'.$menu_item)!=''&&lang('cp_nav_'.$menu_item)!=NULL ? lang('cp_nav_'.$menu_item) : $menu_item;
					$current = $this->module_details && $this->module_details['menu'] == $menu_item;
					$class = $current ? "top-link current" : "top-link";
					echo anchor('#', $name, array('class' => $class));

					echo '<ul>';
				}
					
					
				// Not a big fan of the following hack, if a module needs two navigation links, we should be able to define that
				if ( (in_array('users', $this->permissions) OR $this->user->group == 'admin') && $menu_item == 'users')
				{
					echo '<li>' . anchor('admin/users', lang('cp_manage_users'), array('style' => 'font-weight: bold;', 'class' => $module == 'modules' ? 'current' : '')) . '</li>';
				}

				//Lets get the sub-menu links, or parent link if that is the case
				ksort($modules[$menu_item]);
				foreach ($modules[$menu_item] as $module)
				{
					if (lang('cp_nav_'.$module['name'])!=''&&lang('cp_nav_'.$module['name'])!=NULL)
					{
						$module['name'] = lang('cp_manage_'.$module['name']);
					}
					$current = $this->module == $module['slug'];
					$class = $current ? "current " : "";
					$class .= $count <= 1 ? "top-link no-submenu " : "";
					
					if (in_array($module['slug'], $this->permissions) OR $this->user->group == 'admin')
					{
						echo '<li>' . anchor('admin/'.$module['slug'], $module['name'], array('class'=>$class)) . '</li>';
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

		<?php if (in_array('settings', $this->permissions) OR $this->user->group == 'admin'): ?>
		<li><?php echo anchor('admin/settings', lang('cp_nav_settings'), 'class="top-link no-submenu' . (($this->module == 'settings') ? ' current"' : '"'));?></li>
		<?php endif; ?>

		<?php if (in_array('modules', $this->permissions) OR $this->user->group == 'admin'): ?>
		<li><?php echo anchor('admin/modules', lang('cp_nav_addons'), 'class="last top-link no-submenu' . (($this->module == 'modules') ? ' current"' : '"'));?></li>
		<?php endif; ?>

	</ul>
</nav>
