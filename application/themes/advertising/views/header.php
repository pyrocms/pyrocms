<div class="float-left">
	<h1><?=$this->settings->item('site_name'); ?></h1>
	<h2><?=$this->settings->item('site_slogan'); ?></h2>
</div>

<div class="float-right" style="padding:1em;text-align:right">
	<? if($this->session->userdata('user_id')): ?>
		<?=$loggedInWelcome;?> <a href="<?=site_url('users/logout');?>"><?=$logoutLabel;?></a><br/>
	
		<? if($this->settings->item('enable_profiles')): ?>
			<?=anchor('edit-profile', $editProfileLabel); ?> | 
		<? endif; ?>
		
		<?=anchor('edit-settings', $settingsLabel); ?>
		
		<? if( $this->user_lib->check_role('admin') ): ?>
			 | <?=anchor('admin', $cpTitle, 'target="_blank"'); ?>
		<? endif; ?>
		
	<? else: ?>
		<? $this->load->module_view('users', 'login_small'); ?>
	<?endif; ?>
</div>