<div id="mainMenu">
	  <div class="float-right" style="padding:0.5em;text-align:right">
		<?php if($this->user_lib->logged_in()): ?>
			<?php echo sprintf(lang('logged_in_welcome'), $user->first_name.' '.$user->last_name );?> <a href="<?php echo site_url('users/logout');?>"><?php echo lang('logout_label');?></a>
		
			<?php if($this->settings->item('enable_profiles')): ?>
				| <?php echo anchor('edit-profile', lang('edit_profile_label')); ?>
			<?php endif; ?>
			
			| <?php echo anchor('edit-settings', lang('settings_label')); ?>
			
			<?php if( $this->user_lib->check_role('admin') ): ?>
				 | <?php echo anchor('admin', lang('cp_title'), 'target="_blank"'); ?>
			<?php endif; ?>
			
		<?php else: ?>
			<?php echo anchor('users/login', lang('user_login_btn')); ?> | <?php echo anchor('register', lang('user_register_btn')); ?>
		<?endif; ?>
	</div>

	  <ul class="float-left">
		<?php foreach(navigation('header') as $nav_link): ?>
		<li><?php echo anchor($nav_link->url, $nav_link->title, $nav_link->current_link ? 'class="here"' : ''); ?></li>
		<?php endforeach; ?>
	  </ul>

  </div>