<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!-- And no, we do not support Microsoft Internet Explorer 6 :] -->
		<!-- Meta information -->
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<?php echo "\n"; echo $extra_head_content; ?>
		
		<!-- Stylesheets -->
		<link href="<?php echo base_url(); ?>application/themes/pyrocms/css/reset.css" rel="stylesheet" media="screen" type="text/css" />
		<link href="<?php echo base_url(); ?>application/themes/pyrocms/css/style.css" rel="stylesheet" media="screen" type="text/css" />
		
		<title><?php echo $this->settings->item('site_name'); ?></title>		
	</head>
	<body>
		<!-- Main wrapper -->
		<div id="wrapper">
			<!-- Flash data messages will appear below -->
			<?php if ($this->session->flashdata('notice')) {
		                  echo '<div class="notice notification_box"><p>' . strip_tags($this->session->flashdata('notice')) . '</p></div>';
			}
			if ($this->session->flashdata('success')) {
		                  echo '<div class="success notification_box"><p>' . strip_tags($this->session->flashdata('success')) . '</p></div>';
			}
			if ($this->session->flashdata('error')) {
		                  echo '<div class="error notification_box"><p>' . strip_tags($this->session->flashdata('error')) . '</p></div>';
			}
			?>
			
			<!-- Header -->
			<div id="header">						
				<!-- Site title -->
				<div id="site_title">
					<h1><img src="<?php echo image_path('logo.png', '_theme_'); ?>" alt="PyroCMS" width="200" height="76" /></h1>
				</div>								
				<!-- Navigation -->
				<div id="navigation">
					<ul>
						<?php if(!empty($navigation['header'])) foreach($navigation['header'] as $nav_link): ?>					
						<li><?php echo anchor($nav_link->url, $nav_link->title, $nav_link->current_link ? 'id="current"' : ''); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>	
				<div class="clear"></div>			
			</div>

			<!-- Content -->
			<div id="content">
				<?php echo $page_output; ?>
			</div>
			
			<!-- Sidebar -->
			<div id="sidebar">
				<? if(is_module('news')): ?>
			  	<h2>Latest News</h2>
				<ul>
					<?php foreach ($this->news_m->getNews() as $news): ?>
					<li>
						<h3><?php echo anchor('news/' . date('Y/m') . '/'. strtolower($news->slug), $news->title); ?></h3>
						<p class="post-info">Posted in category : <?php echo anchor('news/category/'.$news->category_slug, $news->category_title);?></p>
					</li>
					<?php endforeach ?>
				</ul>
				<? endif; ?>
			</div>
			
			<!-- Footer -->
			<div id="footer">
				<?php $this->load->view($theme_view_folder.'footer'); ?>
			</div>
		</div>
		<!-- End of wrapper -->
	</body>
</html>
