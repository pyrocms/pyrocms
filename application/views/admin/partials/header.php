<div id="top">
	<h1><?php echo anchor('admin', $this->settings->item('site_name')); ?></h1>
	<p id="userbox">
		<strong><?php echo sprintf(lang('cp_logged_in_welcome'), $user->first_name.' '.$user->last_name); ?></strong>
		&nbsp;| &nbsp;<?php echo anchor('edit-profile', lang('cp_edit_profile_label')); ?>
		&nbsp;| &nbsp;<?php echo anchor('admin/logout', lang('cp_logout_label')); ?>
		<br />
		<small><?php echo anchor('', lang('cp_view_frontend')); ?></small>
	</p>
	
	<br class="clear-both" />
</div>

<ul id="menu">

	<li class="<?php echo empty($module) ? 'selected' : ''; ?> dashboard">
		<?php echo anchor('admin', 'Dashboard', 'class="ajax"');?>
	</li>
	
	<?php foreach($core_modules as $core_module): ?>
	<li class="<?php echo $core_module['slug'] == $module ? 'selected' : ''; ?> <?php echo $core_module['slug']; ?>">
		<a href="<?php echo site_url('admin/'.$core_module['slug']); ?>" class="ajax {title:'<?php echo lang('cp_breadcrumb_home_title');?> | <?php echo $core_module['name'];?> | <?php echo $this->settings->item('site_name');?>'}">
			<?php echo $core_module['name'];?> 
		</a>
	</li>
	<?php endforeach; ?>
	
	<li class="<?php echo $module == 'modules' ? 'selected' : ''; ?> modules">
		<a href="<?php echo site_url('admin/modules'); ?>" class="ajax">
			<?php echo lang('cp_nav_modules') ?> <span>&nbsp;</span>
		</a>
		
		<ul>
			<?php foreach($third_party_modules as $tp_module): ?>
			<li class="<?php echo $tp_module['slug']; ?>">
				<a href="<?php echo site_url('admin/'.$tp_module['slug']); ?>" class="ajax {title:'<?php echo lang('cp_breadcrumb_home_title');?> | <?php echo $tp_module['name'];?> | <?php echo $this->settings->item('site_name');?>'}">
					<?php echo $tp_module['name'];?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</li>
	
	<li class="<?php echo in_array($this->module, array('themes', 'modules', 'settings', 'permissions')) ? 'selected' : ''; ?> settings">
		<a href="<?php echo site_url('admin/settings'); ?>" class="ajax">
			<?php echo lang('cp_nav_settings') ?> <span>&nbsp;</span>
		</a>
		
		<ul>
			<li><?php echo anchor('admin/settings', lang('cp_nav_edit_settings'), 'class="ajax"'); ?></li>
			<li><?php echo anchor('admin/themes', lang('cp_nav_themes'), 'class="ajax"'); ?></li>
			<li><?php echo anchor('admin/permissions', lang('cp_nav_permissions'), 'class="ajax"'); ?></li>
		</ul>
	</li>
	
</ul>

<br class="clear-both" />