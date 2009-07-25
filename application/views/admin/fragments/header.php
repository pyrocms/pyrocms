<div class="container content">
	<h1><a href="<?php echo site_url('admin'); ?>" title="<?php echo lang('cp_to_home');?>"><?php echo $this->settings->item('site_name'); ?></a></h1>	
	<a href="<?php echo site_url(); ?>" target="_blank" class="viewWebsite"><span><?php echo lang('cp_view_frontend');?></span></a>
	
	<div class="loginInfos">
		<?php echo sprintf(lang('cp_logged_in_as'), '<strong>'.$user->first_name.' '.$user->last_name.'</strong>');?> 
		<?php echo sprintf(lang('cp_logout'), anchor('edit-profile', lang('cp_edit_profile_label')), anchor('admin/logout', lang('cp_logout_label')));?>
	</div>
	
	<div class="languageSelector">
	
		<?php foreach( $this->config->item('supported_languages') as $lang_code => $lang ): ?>
			<a href="?lang=<?php echo $lang_code;?>" title="<?php echo $lang['name'] ?>">
				<?php echo image('icons/flags/'.$lang_code.'.gif', NULL, array('alt' => $lang['name'])); ?>
			</a>
		<?php endforeach; ?>
		
	</div>
	
</div>