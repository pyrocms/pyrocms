<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $page_title;?> | <?php echo $this->settings->item('site_name'); ?></title>
		<meta http-equiv="Pragma" content="no-cache" />        

	    <?php $this->load->view('admin/fragments/metadata'); ?>
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
		
				<div id="content">
		
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