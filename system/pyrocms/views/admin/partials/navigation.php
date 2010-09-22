<nav id="main-nav">

	<ul>
		<li><?php echo anchor('admin', 'Dashboard', 'class="top-link no-submenu' . (empty($this->module) ? ' current' : '').'"');?></li>
		<li><a href="#" class="top-link <?php echo ($this->module_data AND $this->module_data['menu'] == 'content') ? 'current' : ''; ?>"><?php echo lang('cp_nav_content');?></a>
			<ul>
				<?php
					ksort($modules['content']);
					foreach ($modules['content'] as $module):
				?>
				<li><?php echo anchor('admin/'.$module['slug'], $module['name'], ($this->module == $module['slug']) ? 'class="current"' : '');?></li>
				<?php endforeach; ?>
			</ul>
		</li>

		<li><a href="#" class="top-link <?php echo ($this->module_data AND $this->module_data['menu'] == 'design') ? 'current' : ''; ?>"><?php echo lang('cp_nav_design');?></a>
			<ul>
				<?php
					ksort($modules['design']);
					foreach ($modules['design'] as $module):
				?>
				<li><?php echo anchor('admin/'.$module['slug'], $module['name'], (($this->module == $module['slug']) ? 'class="current"' : ''));?></li>
				<?php endforeach; ?>
			</ul>
		</li>
		
		<li>
			<a href="#" class="top-link <?php echo (($this->module_data AND $this->module_data['menu'] == 'users') OR $this->module == 'users') ? 'current' : ''; ?>"><?php echo lang('cp_nav_users');?></a>
			<ul>
				<li><?php echo anchor('admin/users', lang('cp_manage_users'), array('style' => 'font-weight: bold;', 'class' => $module == 'modules' ? 'current' : ''));?></li>

				<?php
					ksort($modules['users']);
					foreach ($modules['users'] as $module):
				?>
				<li><?php echo anchor('admin/'.$module['slug'], $module['name'], (($this->module == $module['slug']) ? 'class="current"' : ''));?></li>
				<?php endforeach; ?>
			</ul>
		</li>
		
		<li>
			<a href="#" class="top-link <?php echo (($this->module_data AND $this->module_data['menu'] == 'utilities') OR $this->module == 'utilities') ? 'current' : ''; ?>"><?php echo lang('cp_nav_utilities');?></a>
			<ul>
				<?php
					ksort($modules['utilities']);
					foreach ($modules['utilities'] as $module):
				?>
				<li><?php echo anchor('admin/'.$module['slug'], $module['name'], (($this->module == $module['slug']) ? 'class="current"' : ''));?></li>
				<?php endforeach; ?>
			</ul>
		</li>
		

		<li><?php echo anchor('admin/settings', lang('cp_nav_settings'), 'class="top-link no-submenu' . (($this->module == 'settings') ? ' current"' : '"'));?></li>
		<li><?php echo anchor('admin/modules', lang('cp_nav_addons'), 'class="last top-link no-submenu' . (($this->module == 'modules') ? ' current"' : '"'));?></li>
	</ul>
</nav>