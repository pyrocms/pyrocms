<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?=$page_title;?> | <?=$this->settings->item('site_name'); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Pragma" content="no-cache" />        
	    <script type="text/javascript">
	    	var APPPATH_URI = "<?=$this->config->item('asset_dir');?>";
	    	var BASE_URI = "<?=BASE_URI;?>";
	    	var DEFAULT_TITLE = "<?=$this->settings->item('site_name'); ?>";
	    </script>
	        
	    <?= js('jquery/jquery.js'); ?>
		<?= js('jquery/jquery-ui.min.js'); ?>
		
		<?= js('jquery/jquery.dimensions.js'); ?>
		<?= js('jquery/jquery.imgareaselect.js'); ?>
		<?= js('jquery/jquery.simplemodal.js').css('jquery/confirm.css'); ?>
		<?= js('jquery/jquery.tooltip.min.js'); ?>
		<?= js('jquery/jquery.tablesorter.min.js'); ?>
		
		<? /* Added for Ajaxify */ ?>
		<?= js('jquery/jquery.livequery.pack.js'); ?>
		<?= js('jquery/jquery.ajaxify.js'); ?>
		<?= js('jquery/jquery.history.fixed.js'); ?>
		<?= js('jquery/jquery.metadata.min.js'); ?>
		
		<?= js('facebox.js').css('facebox.css'); ?>
			
	    <?= $extra_head_content; ?>        
	    <?= js('functions.js'); ?>
		<?= js('admin.js').css('admin/admin.css');?>
		
		<?//= css('admin/orange.css'); ?>      
	</head>
	<body>
	
		<!-- Header -->
		<div id="header">
			<? $this->load->view('admin/fragments/header'); ?>
		</div>
		<!-- /Header -->
		
		<!-- Content -->
		<div id="page-content">
			<div class="container content">
			
				<!-- Sidebar -->
				<div id="sidebar" class="bImg">
					<? $this->load->view('admin/fragments/sidebar'); ?>
				</div>
		
				<div id="content" class="roundedBorders">
		
					<?=$this->load->view('admin/fragments/inner_header') ?>
					
					<!-- Inner Content -->
					<div id="innerContent">
					
						<div id="confirm" class="hidden">
							<a href='#' title='Close' class='modalCloseX simplemodal-close'>x</a>
							<div class='confirm-header'><span><?= lang('dialog_confirm');?></span></div>
							<div class="confirm-message"></div>
							<div class='confirm-buttons'>
								<div class='no simplemodal-close'><?= lang('dialog_no');?></div><div class='yes'><?= lang('dialog_yes');?></div>
							</div>
					    	<div class="clear-both bBottom"><div></div></div>
						</div>
    
						<?=$this->load->view('admin/result_messages') ?>
					
						<?=$page_output; ?>
					</div>
					
					<div class="bBottom">
						<div></div>
					</div>

				</div>
				
			</div>
		</div>
		<!-- /Content -->
		
		<!-- Footer -->
		<div id="footer">
			<? $this->load->view('admin/fragments/footer'); ?>
		</div>
		<!-- /Footer -->
		
	</body>
</html>