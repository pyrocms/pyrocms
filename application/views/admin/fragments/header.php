<div id="top">
	<h1><?php echo anchor('admin', $this->settings->item('site_name')); ?></h1>
	<p id="userbox">
		<strong><?php echo sprintf(lang('cp_logged_in_welcome'), $user->first_name.' '.$user->last_name); ?></strong>
		&nbsp;| &nbsp;<?php echo anchor('edit-profile', lang('cp_edit_profile_label')); ?>
		&nbsp;| &nbsp;<?php echo anchor('admin/logout', lang('cp_logout_label')); ?>
		<br />
	<small>Last Login: 12 May 2009</small></p>
	<span class="clearFix">&nbsp;</span>
</div>

<ul id="menu">

	<li class="<?php echo empty($module) ? 'selected' : ''; ?> dashboard">
		<?php echo anchor('admin', 'Dashboard');?>
	</li>
	
	<?php foreach($admin_modules as $admin_module): ?>
	<li class="<?php echo $admin_module['slug'] == $module ? 'selected' : ''; ?> <?php echo $admin_module['slug']; ?>">
		<a href="<?php echo site_url('admin/'.$admin_module['slug']); ?>" class="ajax {title:'<?php echo lang('cp_breadcrumb_home_title');?> | <?php echo $admin_module['name'];?> | <?php echo $this->settings->item('site_name');?>'}">
			<?php echo $admin_module['name'];?> 
		</a>
	</li>
	<?php endforeach; ?>
	
	<li class="<?php echo in_array($this->module, array('themes', 'modules', 'settings', 'permissions')) ? 'selected' : ''; ?> settings">
		<a href="#">
			<?php echo lang('cp_nav_settings') ?> <span>&nbsp;</span>
		</a>
		
		<ul>
			<li><?php echo anchor('admin/settings', lang('cp_nav_edit_settings')); ?></li>
			<li><?php echo anchor('admin/modules', lang('cp_nav_modules')); ?></li>
			<li><?php echo anchor('admin/themes', lang('cp_nav_themes')); ?></li>
			<li><?php echo anchor('admin/permissions', lang('cp_nav_permissions')); ?></li>
		</ul>
	</li>
	
</ul>

<br class="clear-both" />