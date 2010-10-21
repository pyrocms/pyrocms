<nav id="main-nav">

	<ul>
		<li><?php echo anchor('admin', 'Dashboard', 'class="top-link no-submenu' . (empty($this->module) ? ' current' : '').'"');?></li>
		<li><a href="#" class="top-link <?php echo ($this->module_details AND $this->module_details['menu'] == 'content') ? 'current' : ''; ?>"><?php echo lang('cp_nav_content');?></a>
			<ul>
				<?php
					ksort($modules['content']);
					foreach ($modules['content'] as $module):
				?>
				
				<?php if(in_array($module['slug'], $this->permissions) OR $this->user->group_id === '1'): ?>
				<li><?php echo anchor('admin/'.$module['slug'], $module['name'], ($this->module == $module['slug']) ? 'class="current"' : '');?></li>
				<?php endif; ?>
				
				<?php endforeach; ?>
			</ul>
		</li>

		<li><a href="#" class="top-link <?php echo ($this->module_details AND $this->module_details['menu'] == 'design') ? 'current' : ''; ?>"><?php echo lang('cp_nav_design');?></a>
			<ul>
				<?php
					ksort($modules['design']);
					foreach ($modules['design'] as $module):
				?>
				
				<?php if(in_array($module['slug'], $this->permissions) OR $this->user->group_id === '1'): ?>
				<li><?php echo anchor('admin/'.$module['slug'], $module['name'], (($this->module == $module['slug']) ? 'class="current"' : ''));?></li>
				<?php endif; ?>
				
				<?php endforeach; ?>
			</ul>
		</li>
		
		<li>
			<a href="#" class="top-link <?php echo (($this->module_details AND $this->module_details['menu'] == 'users') OR $this->module == 'users') ? 'current' : ''; ?>"><?php echo lang('cp_nav_users');?></a>
			<ul>
				<?php if(in_array('users', $this->permissions) OR $this->user->group_id === '1'): ?>
				<li><?php echo anchor('admin/users', lang('cp_manage_users'), array('style' => 'font-weight: bold;', 'class' => $module == 'modules' ? 'current' : ''));?></li>
				<?php endif; ?>
				
				<?php
					ksort($modules['users']);
					foreach ($modules['users'] as $module):
				?>
				
				<?php if(in_array($module['slug'], $this->permissions) OR $this->user->group_id === '1'): ?>
				<li><?php echo anchor('admin/'.$module['slug'], $module['name'], (($this->module == $module['slug']) ? 'class="current"' : ''));?></li>
				<?php endif; ?>
				
				<?php endforeach; ?>
			</ul>
		</li>
		
		<li>
			<a href="#" class="top-link <?php echo (($this->module_details AND $this->module_details['menu'] == 'utilities') OR $this->module == 'utilities') ? 'current' : ''; ?>"><?php echo lang('cp_nav_utilities');?></a>
			<ul>
				<?php
					ksort($modules['utilities']);
					foreach ($modules['utilities'] as $module):
				?>
				
				<?php if(in_array($module['slug'], $this->permissions) OR $this->user->group_id === '1'): ?>
				<li><?php echo anchor('admin/'.$module['slug'], $module['name'], (($this->module == $module['slug']) ? 'class="current"' : ''));?></li>
				<?php endif; ?>
				
				<?php endforeach; ?>
			</ul>
		</li>
		
		<?php if(in_array('settings', $this->permissions) OR $this->user->group_id === '1'): ?>
		<li><?php echo anchor('admin/settings', lang('cp_nav_settings'), 'class="top-link no-submenu' . (($this->module == 'settings') ? ' current"' : '"'));?></li>
		<?php endif; ?>
		
		<?php if(in_array('modules', $this->permissions) OR $this->user->group_id === '1'): ?>
		<li><?php echo anchor('admin/modules', lang('cp_nav_addons'), 'class="last top-link no-submenu' . (($this->module == 'modules') ? ' current"' : '"'));?></li>
		<?php endif; ?>
	</ul>
</nav>