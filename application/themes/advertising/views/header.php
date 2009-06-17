<div class="float-left">
	<h1><?=$this->settings->item('site_name'); ?></h1>
	<h2><?=$this->settings->item('site_slogan'); ?></h2>
</div>

<div class="float-right" style="padding:1em;text-align:right">
	<? if($this->session->userdata('user_id')): ?>
		<?= sprintf(lang('logged_in_welcome'), $user->first_name.' '.$user->last_name );?> <a href="<?=site_url('users/logout');?>"><?= lang('logout_label');?></a><br/>
	
		<? if($this->settings->item('enable_profiles')): ?>
			<?=anchor('edit-profile', lang('edit_profile_label')); ?> | 
		<? endif; ?>
		
		<?=anchor('edit-settings', lang('settings_label')); ?>
		
		<? if( $this->user_lib->check_role('admin') ): ?>
			 | <?=anchor('admin', lang('cp_title'), 'target="_blank"'); ?>
		<? endif; ?>
		
	<? else: ?>
		<? $this->load->module_view('users', 'login_small'); ?>
	<? endif; ?>
</div>