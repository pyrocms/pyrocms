<nav id="main-nav">

	<ul>
		<li><?php echo anchor('admin', lang('cp_admin_home_title'), 'class="top-link no-submenu' . (!$this->module > '' ? ' current' : '').'"');?></li>
		
		<?php $display = ''; foreach($modules['content'] as $module) if(in_array($module['slug'], $this->permissions) OR $this->user->group == 'admin') $display = 1; ?>
		<?php if($display === 1): ?>
		<li><a href="#" class="top-link <?php echo ($this->module_details AND $this->module_details['menu'] == 'content') ? 'current' : ''; ?>"><?php echo lang('cp_nav_content');?></a>
			<ul>
				<?php
					ksort($modules['content']);
					foreach ($modules['content'] as $module):
				?>
				
				<?php if(in_array($module['slug'], $this->permissions) OR $this->user->group == 'admin'): ?>
				<li><?php echo anchor('admin/'.$module['slug'], $module['name'], ($this->module == $module['slug']) ? 'class="current"' : '');?></li>
				<?php endif; ?>
				
				<?php endforeach; ?>
			</ul>
		</li>
		<?php endif; ?>
		
		<?php $display = ''; foreach($modules['design'] as $module) if(in_array($module['slug'], $this->permissions) OR $this->user->group == 'admin') $display = 1; ?>
		<?php if($display === 1): ?>
		<li><a href="#" class="top-link <?php echo ($this->module_details AND $this->module_details['menu'] == 'design') ? 'current' : ''; ?>"><?php echo lang('cp_nav_design');?></a>
			<ul>
				<?php
					ksort($modules['design']);
					foreach ($modules['design'] as $module):
				?>
				
				<?php if(in_array($module['slug'], $this->permissions) OR $this->user->group == 'admin'): ?>
				<li><?php echo anchor('admin/'.$module['slug'], $module['name'], (($this->module == $module['slug']) ? 'class="current"' : ''));?></li>
				<?php endif; ?>
				
				<?php endforeach; ?>
			</ul>
		</li>
		<?php endif; ?>
		
		<?php $display = ''; foreach($modules['users'] as $module) if(in_array($module['slug'], $this->permissions) OR $this->user->group == 'admin') $display = 1; ?>
		<?php if($display === 1): ?>
		<li>
			<a href="#" class="top-link <?php echo (($this->module_details AND $this->module_details['menu'] == 'users') OR $this->module == 'users') ? 'current' : ''; ?>"><?php echo lang('cp_nav_users');?></a>
			<ul>
				<?php if(in_array('users', $this->permissions) OR $this->user->group == 'admin'): ?>
				<li><?php echo anchor('admin/users', lang('cp_manage_users'), array('style' => 'font-weight: bold;', 'class' => $module == 'modules' ? 'current' : ''));?></li>
				<?php endif; ?>
				
				<?php
					ksort($modules['users']);
					foreach ($modules['users'] as $module):
				?>
				
				<?php if(in_array($module['slug'], $this->permissions) OR $this->user->group == 'admin'): ?>
				<li><?php echo anchor('admin/'.$module['slug'], $module['name'], ($this->module == $module['slug']) ? 'class="current"' : '');?></li>
				<?php endif; ?>
				
				<?php endforeach; ?>
			</ul>
		</li>
		<?php endif; ?>

		<?php $display = ''; foreach($modules['utilities'] as $module) if(in_array($module['slug'], $this->permissions) OR $this->user->group == 'admin') $display = 1; ?>
		<?php if($display === 1): ?>
		<li>
			<a href="#" class="top-link <?php echo (($this->module_details AND $this->module_details['menu'] == 'utilities') OR $this->module == 'utilities') ? 'current' : ''; ?>"><?php echo lang('cp_nav_utilities');?></a>
			<ul>
				<?php
					ksort($modules['utilities']);
					foreach ($modules['utilities'] as $module):
				?>
				
				<?php if(in_array($module['slug'], $this->permissions) OR $this->user->group == 'admin'): ?>
				<li><?php echo anchor('admin/'.$module['slug'], $module['name'], (($this->module == $module['slug']) ? 'class="current"' : ''));?></li>
				<?php endif; ?>
				
				<?php endforeach; ?>
			</ul>
		</li>
		<?php endif; ?>
		
		<?php if(in_array('settings', $this->permissions) OR $this->user->group == 'admin'): ?>
		<li><?php echo anchor('admin/settings', lang('cp_nav_settings'), 'class="top-link no-submenu' . (($this->module == 'settings') ? ' current"' : '"'));?></li>
		<?php endif; ?>
		
		<?php if(in_array('modules', $this->permissions) OR $this->user->group == 'admin'): ?>
		<li><?php echo anchor('admin/modules', lang('cp_nav_addons'), 'class="last top-link no-submenu' . (($this->module == 'modules') ? ' current"' : '"'));?></li>
		<?php endif; ?>
	</ul>
</nav>