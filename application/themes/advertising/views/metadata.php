	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?=$page_title;?> | <?=$this->settings->item('site_name'); ?></title>
	
	<!-- Language: <?=CURRENT_LANGUAGE ?> -->
	
    <script type="text/javascript">
	    var APPPATH_URI = "<?=$this->config->item('asset_dir');?>";
	    var BASE_URI = "<?=BASE_URI;?>";
    </script>
	
	<?= css('style.css').css('layout.css', '_theme_');?>
	
	<?= js('jquery/jquery.js'); ?>
	<?= js('facebox.js').css('facebox.css');?>
	
	<?= js('front.js'); ?>

    <?=$extra_head_content; ?>