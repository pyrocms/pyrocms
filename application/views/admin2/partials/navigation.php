		<nav id="main-nav">
			<ul>
				<li><?php echo anchor('admin', 'Dashboard', 'class="top-link no-submenu' . (empty($module) ? ' current"' : '"'));?></li>
				<li><a href="#" class="top-link<?php echo in_array($this->module, array('channels', 'pages', 'media')) ? ' current' : ''; ?>">Content</a>
					<ul>
						<li><?php echo anchor('admin/channels', 'Channels', (($module == 'channels') ? 'class="current"' : ''));?></li>
						<li><?php echo anchor('admin/pages', 'Pages', (($module == 'pages') ? 'class="current"' : ''));?></li>
						<li><?php echo anchor('admin/media', 'Media', (($module == 'media') ? 'class="current"' : ''));?></li>
					</ul>
				</li>
				<li><a href="#" class="top-link<?php echo in_array($module, array('themes', 'layouts')) ? ' current' : ''; ?>">Design</a>
					<ul>
						<li><?php echo anchor('admin/themes', 'Themes', (($module == 'themes') ? 'class="current"' : ''));?></li>
						<li><?php echo anchor('admin/layouts', 'Layouts', (($module == 'layouts') ? 'class="current"' : ''));?></li>
					</ul>
				</li>
				<li><a href="#" class="top-link<?php echo ((isset($third_party_modules[$module]) OR $module == 'modules') ? ' current"' : '"'); ?>"><?php echo lang('cp_nav_modules'); ?></a>
					<ul>
						<li><?php echo anchor('admin/modules', 'Manage Modules', 'style="font-weight: bold;" ' . (($module == 'modules') ? 'class="current"' : ''));?></li>
					<?php foreach($third_party_modules as $tp_module): ?>
						<li><?php echo anchor('admin/' . $tp_module['slug'], $tp_module['name'], (($module == $tp_module['slug']) ? 'class="current"' : '')); ?></li>
					<?php endforeach; ?>
					</ul>
				</li>
				<li><?php echo anchor('admin/users', 'Users', 'class="top-link no-submenu' . (($module == 'users') ? ' current"' : '"'));?></li>
				<li><?php echo anchor('admin/settings', 'Settings', 'class="last top-link no-submenu' . (($module == 'settings') ? ' current"' : '"'));?></li>
			</ul>
		</nav>