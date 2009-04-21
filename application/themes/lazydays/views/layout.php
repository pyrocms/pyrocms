<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-AU">
	<head>
	
	  <title><?=$page_title;?> | <?=$this->settings->item('site_name'); ?></title>
	
	  <!-- Language: <?=DEFAULT_LANGUAGE ?> -->
		
	  <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
	  <?= $this->settings->item('meta_tags'); ?>
	
    	<script type="text/javascript">var APPPATH = "<?=APPPATH_URI;?>";</script>
        
		<?= css('style.css').css('layout.css', '_theme_');?>
	
		<?= js('jquery/jquery.js'); ?>
		<?= js('facebox.js').css('facebox.css');?>
		
		<?= js('front.js'); ?>
		
		<? if(is_module('news')): ?>
		<link rel="alternate" type="application/rss+xml" title="<?=$this->settings->item('site_name'); ?>" href="<?=site_url('news/rss'); ?>" />
		<? endif; ?>
	
	  <? /*<link rel="stylesheet" type="text/css" href="css/print.css" media="print" /> */ ?>
	
	</head>
	
	<body>
	
	<!-- CONTENT: Holds all site content except for the footer.  This is what causes the footer to stick to the bottom -->
	<div id="content">
	
	  <!-- HEADER: Holds title, subtitle and header images -->
	  <div id="header">
		<? $this->load->view($theme_view_folder.'header'); ?>	
	  </div>
	
	
	  <!-- MAIN MENU: Top horizontal menu of the site.  Use class="here" to turn the current page tab on -->
	  <div id="mainMenu">
		  <div class="float-right" style="padding:0.5em;text-align:right">
			<? if($this->session->userdata('user_id')): ?>
				Welcome <?=$user->first_name;?>, you are logged in. <a href="<?=site_url('users/logout');?>">Log out</a>
			
				<? if($this->settings->item('enable_profiles')): ?>
					| <?=anchor('edit-profile', 'Edit Profile'); ?>
				<? endif; ?>
				
				| <?=anchor('edit-settings', 'Settings'); ?>
				
				<? if( $this->user_lib->check_role('admin') ): ?>
					 | <?=anchor('admin', 'Admin Panel', 'target="_blank"'); ?>
				<? endif; ?>
				
			<? else: ?>
				<?=anchor('users/login', lang('user_login_btn')); ?> | <?=anchor('register', lang('user_register_btn')); ?>
			<?endif; ?>
		</div>

		  <ul class="float-left">
			<? if(!empty($navigation['header'])) foreach($navigation['header'] as $nav_link): ?>
			<li><?=anchor($nav_link->url, $nav_link->title, $nav_link->current_link ? 'class="here"' : ''); ?></li>
			<? endforeach; ?>
		  </ul>

	  </div>
	
	
	  <!-- PAGE CONTENT BEGINS: This is where you would define the columns (number, width and alignment) -->
	  <div id="page">
	
	
	    <!-- 25 percent width column, aligned to the left -->
	    <div class="width-quater float-left leftColumn">
	
	        <div id="sideMenu">
				<?=$this->load->view($theme_view_folder.'menu'); ?>
			</div>
			
			<? if(is_module('twitter')): ?>
			<div id="recent-posts">
				<h2>Thoughts</h2>
				<?= $this->load->module_view('twitter', 'fragments/my_tweets'); ?>
			</div>
			
			<? endif; ?>
			<? if(is_module('news')): ?>
			<div id="recent-posts">
				<h2>Recent Posts</h2>
				<?= $this->news_m->getNewsHome(); ?>
			</div>
			<? endif; ?>
	
	    </div>
	

	    <!-- 75 percent width column, aligned to the right -->
	    <div class="float-right rightColumn">
	
	        <a name="fluidity"></a>
	
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
	</div>
	
	<!-- FOOTER: Site footer for links, copyright, etc. -->
	<div id="footer">
		<?$this->load->view($theme_view_folder.'footer'); ?>
	</div>
	
	</body>

</html>