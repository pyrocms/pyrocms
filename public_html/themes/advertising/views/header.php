<div class="float-left">
	<h1><?=$this->settings->item('site_name'); ?></h1>
	<h2><?=$this->settings->item('site_slogan'); ?></h2>
</div>

<div class="float-right" style="padding:1em;text-align:right">
	<? if($this->session->userdata('user_id')): ?>
		Welcome <?=$user->first_name;?>, you are logged in. <a href="<?=site_url('users/logout');?>">Log out</a><br/>
	
		<? if($this->settings->item('enable_profiles')): ?>
			<?=anchor('edit-profile', 'Edit Profile'); ?> | 
		<? endif; ?>
		
		<?=anchor('edit-settings', 'Settings'); ?>
		
		<? if( $this->user_lib->check_role('admin') ): ?>
			 | <?=anchor('admin', 'Admin Panel', 'target="_blank"'); ?>
		<? endif; ?>
		
	<? else: ?>
		<? $this->load->module_view('users', 'login_small'); ?>
	<?endif; ?>
</div>