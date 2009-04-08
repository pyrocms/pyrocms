<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title><?=$page_title;?> | <?=$this->settings->item('site_name'); ?> Control Panel</title>

		<meta http-equiv="Expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
		<meta http-equiv="Pragma" content="no-cache" />
        
        <?= js('jquery/jquery.js'); ?>
		<?= js('jquery/jquery-ui.min.js'); ?>
		
		<?= js('jquery/jquery.bgiframe.min.js'); ?>
		<?= js('jquery/jquery.dimensions.js'); ?>
		<?= js('jquery/jquery.tooltip.min.js'); ?>
		<?= js('jquery/jquery.tablesorter.min.js'); ?>
		
        <?= js('admin.js'); ?>
        <?=$extra_head_content; ?>
        
		<?= css('admin/admin.css');?>
        
	</head>
	<body>
	
		<!-- Header -->
		<div id="header">
			<? $this->load->view('admin/layout_fragments/header'); ?>
		</div>
		<!-- /Header -->
		
		<!-- Content -->
		<div id="page-content">
			<div class="container content">
			
				<!-- Sidebar -->
				<div id="sidebar" class="bImg">
					<? $this->load->view('admin/layout_fragments/sidebar'); ?>
				</div>
		
				<div id="content" class="roundedBorders">
		
					<?=$this->load->view('admin/layout_fragments/inner_header') ?>
					
					<!-- Inner Content -->
					<div id="innerContent">
						<?=$this->load->view('admin/result_messages') ?>
					
						<?=$page_output; ?>
					</div>
					
				</div>
				
			</div>
		</div>
		<!-- /Content -->
		
		<!-- Footer -->
		<div id="footer">
			<? $this->load->view('admin/layout_fragments/footer'); ?>
		</div>
		<!-- /Footer -->
		
	</body>
</html>