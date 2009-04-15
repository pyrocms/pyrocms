<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?=$page_title;?> | <?=$this->settings->item('site_name'); ?></title>
	
	<!-- Language: <?=DEFAULT_LANGUAGE ?> -->
	
	<?= $this->settings->item('meta_tags'); ?>
	
	<?= css('style.css').css('layout.css', '_theme_');?>
	
	<?= js('jquery/jquery.js'); ?>
	<?= js('facebox.js').css('facebox.css');?>
	
	<?= js('front.js'); ?>
	
	<? if(is_module('news')): ?>
	<link rel="alternate" type="application/rss+xml" title="<?=$this->settings->item('site_name'); ?>" href="<?=site_url('news/rss'); ?>" />
	<? endif; ?>
	
</head>

<body>

	<div id="header">
		<? $this->load->view($theme_view_folder.'header'); ?>
	</div>
	
	<ul id="menu">
		<? if(!empty($navigation['header'])) foreach($navigation['header'] as $nav_link): ?>
		<li><?=anchor($nav_link->url, $nav_link->title); ?></li>
		<? endforeach; ?>
	</ul>
	
	<div id="content">
	
		<div id="left-column" class="sidebar">
			
			<div id="navigation">
				<?=$this->load->view($theme_view_folder.'menu'); ?>
			</div>
			
			<? if(is_module('newsletters')): ?>
			<div id="subscribe_newsletter">
				<?=$this->load->module_view('newsletters', 'subscribe_form') ?>
			</div>
			<? endif; ?>
	
			<? if(is_module('news')): ?>
			<div id="recent-posts">
				<h2>Recent Posts</h2>
				<?= $this->news_m->getNewsHome(); ?>
			</div>
			<? endif; ?>
			
		</div>


		<div id="right-column">
		
			<div class="breadcrumbs">
				<?$this->load->view($theme_view_folder.'breadcrumbs'); ?>
			</div>
		
			<? if ($this->session->flashdata('notice')) {
		                  echo '<div class="notice-box">' . $this->session->flashdata('notice') . '</div>';
		    } ?>
		    <? if ($this->session->flashdata('success')) {
		                  echo '<div class="success-box">' . $this->session->flashdata('success') . '</div>';
		    } ?>
		    <? if ($this->session->flashdata('error')) {
		                  echo '<div class="error-box">' . $this->session->flashdata('error') . '</div>';
		    } ?>
		
	    	<?=$page_output; ?>
	    		
		</div>
	
	</div>

	<!-- start footer -->
	<div id="footer">
		<? $this->load->view($theme_view_folder.'footer'); ?>
	</div>
	<!-- end footer -->

</body>
</html>	