<div class="container content">
	<h1><a href="<?=site_url('admin'); ?>" title="<?=$cpToHome;?>"><?=$this->settings->item('site_name'); ?></a></h1>	
	<a href="<?=site_url(); ?>" target="_blank" class="viewWebsite"><span><?=$cpViewFrontend;?></span></a>
	
	<div class="loginInfos"><?=$cpLoggedInAs;?> <?=$cpLogout;?></div>
</div>