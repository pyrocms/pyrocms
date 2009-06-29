<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $this->load->view($theme_view_folder.'metadata'); ?>
</head>

<body>
	<!-- wrap starts here -->
	<div id="wrap-out">
		<div id="wrap">
			<div id="header">
	  			<h1 id="logo-text"><a href="<?php echo base_url(); ?>"><?php echo $this->settings->item('site_name'); ?></a></h1>
	  			<p id="intro"><?php echo $this->settings->item('site_slogan'); ?></p>
	
	  			<div id="nav">
		    		<ul>
					<?php if(!empty($navigation['header'])) foreach($navigation['header'] as $nav_link): ?>
				      <li><?php echo anchor($nav_link->url, $nav_link->title); ?></li>
					<?php endforeach; ?>
				    </ul>
	 		 	</div> <!-- end #navigation -->
			</div> <!-- end #header -->
	
			<!-- content-wrap starts -->
			<div id="content-wrap">
			  <div id="main">
				<?php echo $page_output; ?>
			  <!-- main ends -->	
			  </div>
	
			  <!-- sidebar starts -->
			  <div id="sidebar">
			  	<? if(is_module('news')): ?>
			  	<h2>Latest News</h2>
				<div id="recent-posts">
					<?php foreach ($this->news_m->getNews() as $news): ?>
						<h3><?php echo anchor('news/' . date('Y/m') . '/'. strtolower($news->slug), $news->title); ?></h3>
						<p class="post-info">Posted in category : <?php echo anchor('news/category/'.$news->category_slug, $news->category_title);?></p>
						<p><?php echo strip_tags($news->intro); ?></p>
					<?php endforeach ?>
				</div>
				<? endif; ?>
			  </div><!-- end #sidebar -->
	
			<!-- content-wrap ends-->	
			</div>
	
			<!-- footer starts here -->	
			<?php $this->load->view($theme_view_folder.'footer'); ?>
			<!-- #footer ends here -->
	
		<!-- wrap ends here -->
		</div>
	</div>
</body>
</html>