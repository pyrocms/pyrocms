<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $template['title'];?> | <?php echo $this->settings->item('site_name'); ?></title>
		<?php $this->load->view('admin/fragments/metadata'); ?>
	</head>

	<body>
	
		<div id="container">

			<div id="header">
				<?php $this->load->view('admin/fragments/header'); ?>
			</div>
		
			<div id="content">
				<!-- div id="content-top">
					<h2>Dashboard</h2>
					<span class="clearFix">&nbsp;</span>
				</div-->
			
				<div id="mid-col" class="full-col"><!-- end of div.box -->
				
					<?php $this->load->view('admin/result_messages') ?>
				
					<?php // a cheeky hack to speed up integration ?>
					<?php if(!strpos($template['body'], 'box-container')): ?>
					<div class="box">
						<h3><?php echo $module_data['name']; ?></h3>
						<div class="box-container">
						<?php echo $template['body']; ?>
						</div>
					</div>
					
					<?php else: ?>
						<?php echo $template['body']; ?>
					<?php endif;?>
				
				</div><!-- end of div#mid-col -->
				
				<div id="right-col">
					<div class="box">
						<h3 class="yellow">Side Menu</h3>
					
						<div class="box-container"><!-- use no-padding wherever you need element padding gone -->
							<ul class="list-links">
								<li><a href="#">Manage Filters</a></li>
								<li><a href="#">Setup a New Site</a>
										<ul>
									<li><a href="#">Configure Paths</a></li>
									<li><a href="#">Define Database Name</a></li>
									</ul>
								</li>
								<li><a href="#">Manage Site Accounts</a></li>
							</ul>
						</div><!--end of div.box-container -->
					</div><!-- end of div.box -->
				</div> <!-- end of div#left-col -->
				
				<span class="clearFix">&nbsp;</span>
					 
			</div><!-- end of div#content -->
			<div class="push"></div>
			</div><!-- end of #container -->
		
		<div id="footer-wrap">
			<div id="footer">
			 	<?php echo $this->load->view('admin/fragments/footer'); ?>
			</div>
		</div>
	
	</body>
</html>