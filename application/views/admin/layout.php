<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $template['title'];?> | <?php echo $this->settings->item('site_name'); ?></title>
		<?php echo $template['partials']['metadata']; ?>
	</head>

	<body>
	
		<div id="container">

			<div id="header">
				<?php echo $template['partials']['header']; ?>
			</div>
		
			<div id="content">
			
				<div id="content-top">
					<h2><?php echo $module_data['name'] ? anchor('admin/', $module_data['name'], $module_data['name']) : lang('cp_admin_home_title'); ?></h2>
					<br class="clear-both"/>
				</div>
			
				<?php $this->load->view('admin/result_messages') ?>
			
				<?php if(!empty($template['partials']['sidebar'])): ?>
				
					<div id="left-col">
						<?php echo $template['partials']['sidebar']; ?>
					</div> <!-- end of div#left-col -->
					
					<div id="mid-col" class="large-col">
						<?php echo $template['body']; ?>
					</div>
					
				<?php else: ?>
					<div id="mid-col" class="full-col">
						<?php echo $template['body']; ?>
					</div>
				<?php endif; ?>
				
				<br class="clear-both" />
			
			</div><!-- end of div#content -->
			<div class="push"></div>
			</div><!-- end of #container -->
		
		<div id="footer-wrap">
			<div id="footer">
			 	<?php echo $template['partials']['footer']; ?>
			</div>
		</div>
	
	</body>
</html>