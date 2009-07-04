<div class="container content">
	<h1><a href="<?=site_url('admin'); ?>" title="<?= lang('cp_to_home');?>"><?=$this->settings->item('site_name'); ?></a></h1>	
	<a href="<?=site_url(); ?>" target="_blank" class="viewWebsite"><span><?= lang('cp_view_frontend');?></span></a>
	
	<div class="loginInfos">
		<?= sprintf(lang('cp_logged_in_as'), $user->first_name.' '.$user->last_name);?> 
		<?= sprintf(lang('cp_logout'), anchor('edit-profile', lang('cp_edit_profile_label')), anchor('admin/logout', lang('cp_logout_label')));?>
	</div>
	
	<div class="languageSelector">
	
		<? foreach( $this->config->item('supported_languages') as $code => $lang ): ?>
			<a href="?lang=<?=$code;?>">
				<?=image('icons/flags/'.strtolower($code).'.gif', NULL, array('alt' => $lang)); ?>
			</a>
		<? endforeach; ?>
		
	</div>
	
</div>