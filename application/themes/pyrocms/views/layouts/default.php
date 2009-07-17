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
		<!-- Header -->
		<div id="header">	
			<!-- Align the header to the center -->		
			<div class="header_align">			
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
		</div>
		
		<!-- Second header -->
		<div id="header_2">
			<!-- Extra div so we can have a "double" border at the bottom -->
			<div id="inside">
				<!-- Align the content to the center -->
				<div class="header_align">
					<!-- Div that will contain the newest article -->
					<div id="latest_article">
						<? if(is_module('news')): ?>
					  	
							<?php foreach($this->news_m->getNews(array('limit' => 1)) as $news): ?>
							<div id="latest_article_top">						
								<h2><?php echo anchor('news/' . date('Y/m') . '/'. strtolower($news->slug), $news->title); ?></h2>
								<p id="post_info">Posted in category : <?php echo anchor('news/category/'.$news->category_slug, $news->category_title);?></p>
							</div>
							<p id="post_intro"><?php echo substr(strip_tags($news->intro),0,300)."..."; ?></p>
							<?php endforeach; ?>				
						
						<? endif; ?>
					</div>
					<!-- Div with the image that belongs to the latest article -->
					<div id="latest_article_image">
						<img src="<?php echo base_url(); ?>application/themes/pyrocms/article_images/<?php echo str_replace(' ','_',strip_tags(trim(strtolower($news->title)))); ?>.jpg" width="400" height="200" alt="Article Image" />
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
			
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

			<!-- Content -->
			<div id="content">
				<?php echo $page_output; ?>
			</div>
			
			<!-- Sidebar -->
			<div id="sidebar">
				<? if(is_module('news')): ?>
			  	<h2>Latest News</h2>
				<ul>
					<?php foreach ($this->news_m->getNews(array('limit' => 4)) as $news): ?>
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
