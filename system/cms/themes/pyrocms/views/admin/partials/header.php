<noscript>
	<span>PyroCMS requires that JavaScript be turned on for many of the functions to work correctly. Please turn JavaScript on and reload the page.</span>
</noscript>

<div class="topbar" dir=<?php $vars = $this->load->_ci_cached_vars; echo $vars['lang']['direction']; ?>>
	
	<div id="logo">
		<?php echo $this->settings->site_name; ?>
	</div>
	
	<nav>
		<?php file_partial('navigation'); ?>
	</nav>
	
	<ul id="user-links" class="primary-nav">
		<li id="user-greeting"><a href="#"><?php echo sprintf(lang('cp_logged_in_welcome'), $user->display_name); ?></a>
		
			<ul>
				<li><?php if ($this->settings->enable_profiles) echo anchor('edit-profile', lang('cp_edit_profile_label')) ?></li>
				<li><?php echo anchor('', lang('cp_view_frontend'), 'target="_blank"'); ?></li>
				<li><?php echo anchor('admin/logout', lang('cp_logout_label')); ?></li>
				
				<?php if($module_details['slug']): ?>
					<li id="help-link">
						<?php echo anchor('admin/help/'.$module_details['slug'], lang('help_label'), array('title' => lang('help_label').'->'.$module_details['name'], 'class' => 'modal')); ?>
					</li>
				<?php endif; ?>
			</ul>
		</li>
		<form action="<?php echo current_url(); ?>" id="change_language" method="get">
			<select class="chzn" name="lang" onchange="this.form.submit();">				
				<?php foreach($this->config->item('supported_languages') as $key => $lang): ?>
		    		<option value="<?php echo $key; ?>" <?php echo CURRENT_LANGUAGE == $key ? 'selected="selected"' : ''; ?>>
						<?php echo $lang['name']; ?>
					</option>
        		<?php endforeach; ?>
	    	</select>
		</form>
	</ul>
	
</div>

<header>
	
	<section>
		<h3><?php echo $module_details['name'] ? anchor('admin/' . $module_details['slug'], $module_details['name']) : lang('cp_admin_home_title'); ?></h3>
			<p><?php echo $module_details['description'] ? $module_details['description'] : ''; ?></p>
	</section>

	<?php template_partial('shortcuts'); ?>
	<?php template_partial('filters'); ?>
	<?php file_partial('notices'); ?>
</header>