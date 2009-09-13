<div class="bInner"><span class="bTR"></span><span class="bBL"></span>
	<ul id="side-nav">
	
		<? foreach($admin_modules as $admin_module): ?>
		
		<li class="<?php echo $admin_module['slug'] == $this->module ? 'active' : 'inactive'; ?> <?php echo $admin_module['slug']; ?>">
			<a href="<?= site_url('admin/'.$admin_module['slug']); ?>" class="button ajax {title:'<?php echo lang('cp_breadcrumb_home_title');?> | <?php echo $admin_module['name'];?> | <?php echo $this->settings->item('site_name');?>'}">
				<strong>
					<?= image('admin/icons/'.(!empty($admin_module['icon']) ? $admin_module['icon'] : 'folder_48.png'), NULL, array('alt' => $admin_module['name'] .' icon', 'class' => 'icon') ); ?>
					<?=$admin_module['name'];?><span class="expand expanded"></span>
				</strong>
			</a>
		</li>
		<? endforeach; ?>
		
		<li class="<?php echo in_array($this->module, array('themes', 'settings', 'permissions')) ? 'active' : 'inactive'; ?>">
			<a href="#" class="button">
				<strong>
					<?= image('admin/icons/spanner_48.png', NULL, array('alt' => lang('settings_label'), 'class' => 'icon') ); ?>
					<?php echo lang('cp_nav_settings') ?> <span class="expand expanded"></span>
				</strong>
			</a>
			
			<ul>
				<li><?php echo anchor('admin/settings', lang('cp_nav_edit_settings')) ?></li>
				<li><?php echo anchor('admin/themes', lang('cp_nav_themes')) ?></li>
				<li><?php echo anchor('admin/permissions', lang('cp_nav_permissions')) ?></li>
			</ul>
		</li>
			
	</ul>
</div>