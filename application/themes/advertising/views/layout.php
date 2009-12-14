<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	{theme_view('metadata')}
</head>

<body>

	<div id="header">
		{theme_view('header')}
	</div>
	
	<ul id="menu">
<<<<<<< Updated upstream:application/themes/advertising/views/layout.php
		<?php foreach(navigation('header') as $nav_link): ?>
		<li><?php echo anchor($nav_link->url, $nav_link->title); ?></li>
		<?php endforeach; ?>
=======
		{foreach navigation('header') link}
		<li>{anchor( $link->url, $link->title, array('target' => $link->target))}</li>
		{/foreach}
>>>>>>> Stashed changes:application/themes/advertising/views/layout.php
	</ul>
	
	<div id="content">
	
		<div id="left-column" class="sidebar">
			
			<div id="navigation">
<<<<<<< Updated upstream:application/themes/advertising/views/layout.php
				{theme_view('menu')}
=======
			
				<h2>{lang('navigation_headline')}</h2>
				
				<ul class="spacer-left-dbl">
					{foreach navigation('sidebar') link}
					<li>{anchor( $link->url, $link->title, array('target' => $link->target))}</li>
					{/foreach}
				</ul>
				
>>>>>>> Stashed changes:application/themes/advertising/views/layout.php
			</div>
			
			<?php if(module_exists('newsletters')): ?>
			<div id="subscribe_newsletter">
				<?php $this->load->view('newsletters/subscribe_form') ?>
			</div>
			<?php endif; ?>
	
			<?php if(module_exists('news')): ?>
			<div id="recent-posts">
				<h2>Recent Posts</h2>
				<?php echo $this->news_m->get_news_fragment(); ?>
			</div>
			<?php endif; ?>
			
		</div>


		<div id="right-column">
		
			<div class="breadcrumbs">
<<<<<<< Updated upstream:application/themes/advertising/views/layout.php
				<?php $this->load->view($theme_view_folder.'breadcrumbs'); ?>
=======
				{theme_view('breadcrumbs')}
>>>>>>> Stashed changes:application/themes/advertising/views/layout.php
			</div>
		
			<?php if ($this->session->flashdata('notice')) {
		    	echo '<div class="notice-box">' . $this->session->flashdata('notice') . '</div>';
		    } ?>
		    <?php if ($this->session->flashdata('success')) {
		    	echo '<div class="success-box">' . $this->session->flashdata('success') . '</div>';
		    } ?>
		    <?php if ($this->session->flashdata('error')) {
		    	echo '<div class="error-box">' . $this->session->flashdata('error') . '</div>';
		    } ?>
		
		    {$template.body}
	    		
		</div>
	
	</div>

	<!-- start footer -->
	<div id="footer">
		{theme_view('footer')}
	</div>
	<!-- end footer -->

</body>
</html>	