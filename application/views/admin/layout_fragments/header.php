<div class="container content">
	<h1><a href="<?=site_url('admin'); ?>" title="Back to Control Panel home"><?=$this->settings->item('site_name'); ?></a></h1>
	
	<a href="<?=site_url(); ?>" target="_blank" class="viewWebsite"><span>View website</span></a>
	
	<div class="loginInfos">You're logged in as <strong><?=$user->first_name; ?></strong>. <?=anchor('edit-profile', 'Edit profile'); ?>, or <?=anchor('admin/logout', 'logout'); ?></div>
</div>