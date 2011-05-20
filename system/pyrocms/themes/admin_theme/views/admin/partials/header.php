		<header id="main">
			<div id="logo"></div>
			<h1><?php echo $this->settings->site_name; ?></h1>
		</header>
		<section id="user-links">
			<?php echo sprintf(lang('cp_logged_in_welcome'), $user->display_name); ?>
			<?php if ($this->settings->enable_profiles) echo ' | '.anchor('edit-profile', lang('cp_edit_profile_label')) ?><br />
			<?php echo anchor('', lang('cp_view_frontend'), 'target="_blank"'); ?> | <?php echo anchor('admin/logout', lang('cp_logout_label')); ?>
		</section>