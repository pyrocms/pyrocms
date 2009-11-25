<div class="float-left">
	<h1><?php echo $this->settings->item('site_name'); ?></h1>
	<h2><?php echo $this->settings->item('site_slogan'); ?></h2>
</div>

<div class="float-right" style="padding:1em;text-align:right">
	<?php if($this->session->userdata('user_id')): ?>
		<?php echo sprintf(lang('logged_in_welcome'), $user->first_name.' '.$user->last_name );?> <a href="<?php echo site_url('users/logout');?>"><?php echo lang('logout_label');?></a><br/>
	
		<?php if($this->settings->item('enable_profiles')): ?>
			<?php echo anchor('edit-profile', lang('edit_profile_label')); ?> | 
		<?php endif; ?>
		
		<?php echo anchor('edit-settings', lang('settings_label')); ?>
		
		<?php if( $this->user_lib->check_role('admin') ): ?>
			 | <?php echo anchor('admin', lang('cp_title'), 'target="_blank"'); ?>
		<?php endif; ?>
		
	<?php else: ?>
		<?php $this->load->view('users/login_small'); ?>
	<?php endif; ?>
</div>