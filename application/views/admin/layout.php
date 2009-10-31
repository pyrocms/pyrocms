<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $page_title;?> | <?php echo $this->settings->item('site_name'); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Pragma" content="no-cache" />        
	    <script type="text/javascript">
	    	var APPPATH_URI = "<?php echo $this->config->item('asset_dir');?>";
	    	var BASE_URL = "<?php echo base_url();?>";
	    	var BASE_URI = "<?php echo BASE_URI;?>";
	    	var DEFAULT_TITLE = "<?php echo $this->settings->item('site_name'); ?>";
	    </script>
	        
	    <?php echo js('jquery/jquery.js'); ?>
		<?php echo js('jquery/jquery-ui.min.js'); ?>
		
		<script type="text/javascript">
	    	jQuery.noConflict();
	    </script>
		
		<?php echo js('jquery/jquery.dimensions.js'); ?>
		<?php echo js('jquery/jquery.imgareaselect.js'); ?>
		<?php echo js('jquery/jquery.simplemodal.js').css('jquery/confirm.css'); ?>
		<?php echo js('jquery/jquery.tooltip.min.js'); ?>
		<?php echo js('jquery/jquery.tablesorter.min.js'); ?>
		
		<? /* Added for Ajaxify */ ?>
		<?php echo js('jquery/jquery.livequery.pack.js'); ?>
		<?php echo js('jquery/jquery.ajaxify.js'); ?>
		<?php echo js('jquery/jquery.history.fixed.js'); ?>
		<?php echo js('jquery/jquery.metadata.min.js'); ?>
		
		<?php echo js('facebox.js').css('facebox.css'); ?>
			
	    <?php echo $extra_head_content; ?>        
	    <?php echo js('functions.js'); ?>
		<?php echo js('admin.js').css('admin/admin.css');?>
		
		<?php echo css('admin/orange.css'); ?>      
	</head>
	<body>
	
		<!-- Header -->
		<div id="header">
			<?php $this->load->view('admin/fragments/header'); ?>
		</div>
		<!-- /Header -->
		
		<!-- Content -->
		<div id="page-content">
			<div class="container content">
			
				<!-- Sidebar -->
				<div id="sidebar" class="bImg">
					<?php $this->load->view('admin/fragments/sidebar'); ?>
				</div>
		
				<div id="content" class="roundedBorders">
		
					<?php $this->load->view('admin/fragments/inner_header') ?>
					
					<!-- Inner Content -->
					<div id="innerContent">
					
						<!-- <div id="confirm" class="hidden">
							<a href='#' title='Close' class='modalCloseX simplemodal-close'>x</a>
							<div class='confirm-header'><span><?php echo lang('dialog_confirm');?></span></div>
							<div class="confirm-message"></div>
							<div class='confirm-buttons'>
								<div class='no simplemodal-close'><?php echo lang('dialog_no');?></div><div class='yes'><?php echo lang('dialog_yes');?></div>
							</div>
					    	<div class="clear-both bBottom"><div></div></div>
						</div> -->
    
						<?php // Breadcrumbs disabled as the URL based logic is fundamentally flawed, especially for multi-lingual
						//=$this->load->view('admin/fragments/breadcrumbs') ?>

						<?php $this->load->view('admin/result_messages') ?>
					
						<?php echo $page_output; ?>
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
			<?php $this->load->view('admin/fragments/footer'); ?>
		</div>
		<!-- /Footer -->
		
	</body>
</html>