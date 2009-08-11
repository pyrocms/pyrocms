	<div id="mainMenu">
		  <div class="float-right" style="padding:0.5em;text-align:right">
			<? if($this->user_lib->logged_in()): ?>
				<?= sprintf(lang('logged_in_welcome'), $user->first_name.' '.$user->last_name );?> <a href="<?=site_url('users/logout');?>"><?= lang('logout_label');?></a>
			
				<? if($this->settings->item('enable_profiles')): ?>
					| <?=anchor('edit-profile', lang('edit_profile_label')); ?>
				<? endif; ?>
				
				| <?=anchor('edit-settings', lang('settings_label')); ?>
				
				<? if( $this->user_lib->check_role('admin') ): ?>
					 | <?=anchor('admin', lang('cp_title'), 'target="_blank"'); ?>
				<? endif; ?>
				
			<? else: ?>
				<?=anchor('users/login', lang('user_login_btn')); ?> | <?=anchor('register', lang('user_register_btn')); ?>
			<?endif; ?>
		</div>

		  <ul class="float-left">
			<? if(!empty($navigation['header'])) foreach($navigation['header'] as $nav_link): ?>
			<li><?=anchor($nav_link->url, $nav_link->title, $nav_link->current_link ? 'class="here"' : ''); ?></li>
			<? endforeach; ?>
		  </ul>

	  </div>
