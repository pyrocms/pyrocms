<nav id="main-nav">
	<ul>
		<li><?php echo anchor('admin', 'Dashboard', 'class="top-link no-submenu' . (empty($module) ? ' current"' : '"'));?></li>
		<li><a href="#" class="top-link <?php echo in_array($this->module, array('comments', 'pages', 'files', 'widgets', 'variables')) ? 'current' : ''; ?>">Content</a>
			<ul>
				<li><?php echo anchor('admin/comments', 'Comments', (($module == 'comments') ? 'class="current"' : ''));?></li>
				<li><?php echo anchor('admin/pages', 'Pages', (($module == 'pages') ? 'class="current"' : ''));?></li>
				<li><?php echo anchor('admin/news', 'News', (($module == 'news') ? 'class="current"' : ''));?></li>
				<li><?php echo anchor('admin/files', 'Files', (($module == 'files') ? 'class="current"' : ''));?></li>
				<li><?php echo anchor('admin/variables', 'Variables', (($module == 'variables') ? 'class="current"' : ''));?></li>
				<li><?php echo anchor('admin/widgets', 'Widgets', (($module == 'widgets') ? 'class="current"' : ''));?></li>
			</ul>
		</li>
		<li><a href="#" class="top-link <?php echo in_array($module, array('themes', 'navigation', 'layouts')) ? 'current' : ''; ?>">Design</a>
			<ul>
				<li><?php echo anchor('admin/themes', 'Themes', (($module == 'themes') ? 'class="current"' : ''));?></li>
				<li><?php echo anchor('admin/navigation', 'Navigation', (($module == 'navigation') ? 'class="current"' : ''));?></li>
				<!-- <li><?php echo anchor('admin/layouts', 'Layouts', (($module == 'layouts') ? 'class="current"' : ''));?></li> -->
			</ul>
		</li>
		<li><a href="#" class="top-link <?php echo ((isset($addon_modules[$module]) OR $module == 'modules') ? 'current"' : '"'); ?>"><?php echo lang('cp_nav_modules'); ?></a>
			<ul>
				<li><?php echo anchor('admin/modules', 'Manage Modules', array('style' => 'font-weight: bold;', 'class' => $module == 'modules' ? 'current' : ''));?></li>
			<?php foreach($addon_modules as $tp_module): ?>
				<li><?php echo anchor('admin/' . $tp_module['slug'], $tp_module['name'], $module == $tp_module['slug'] ? 'class="current"' : ''); ?></li>
			<?php endforeach; ?>
			</ul>
		</li>
		<li>
			<a href="#" class="top-link <?php echo in_array($module, array('users', 'groups', 'permissions')) ? 'current' : ''; ?>">Users</a>
			<ul>
				<li><?php echo anchor('admin/users', 'Manage Users', array('style' => 'font-weight: bold;', 'class' => $module == 'modules' ? 'current' : ''));?></li>
				<li><?php echo anchor('admin/groups', 'Groups', $module == 'groups' ? 'class="current"' : '');?></li>
				<li><?php echo anchor('admin/permissions', 'Permissions', $module == 'permissions' ? 'class="current"' : '');?></li>
			</ul>
		</li>
		<li><?php echo anchor('admin/settings', 'Settings', 'class="last top-link no-submenu' . (($module == 'settings') ? ' current"' : '"'));?></li>
	</ul>
</nav>