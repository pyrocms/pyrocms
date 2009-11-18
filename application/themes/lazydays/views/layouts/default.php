<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-GB">
	<head>
		<?php theme_view('metadata'); ?>
	</head>
	<body>
	
	<!-- CONTENT: Holds all site content except for the footer.  This is what causes the footer to stick to the bottom -->
	<div id="content">
	
	  <!-- HEADER: Holds title, subtitle and header images -->
	  <div id="header">
		<?php theme_view('header'); ?>	
	  </div>
	
	  <!-- MAIN MENU: Top horizontal menu of the site. -->
	  <?php theme_view('topnav'); ?>	
	
	  <!-- PAGE CONTENT BEGINS: This is where you would define the columns (number, width and alignment) -->
	  <div id="page">
	
	    <!-- 25 percent width column, aligned to the left -->
	    <div class="width-quater float-left leftColumn">
	
	        <div id="sideMenu">
				<?php echo theme_view('leftnav'); ?>
			</div>
			
			<?php if(module_exists('twitter')): ?>
			<div id="recent-posts">
				<h2>Thoughts</h2>
				<?php echo $this->load->view('twitter/fragments/my_tweets'); ?>
			</div>
			
			<?php endif; ?>
			<?php if(module_exists('news')): ?>
			<div id="recent-posts">
				<h2>Recent Posts</h2>
				<?php echo $this->news_m->getNewsHome(); ?>
			</div>
			<?php endif; ?>
	
	    </div>
	

	    <!-- 75 percent width column, aligned to the right -->
	    <div class="float-right rightColumn">
	
	        <a name="fluidity"></a>
	
	        <?php if ($this->session->flashdata('notice')) {
		                  echo '<div class="notice-box">' . $this->session->flashdata('notice') . '</div>';
		    } ?>
		    <?php if ($this->session->flashdata('success')) {
		                  echo '<div class="success-box">' . $this->session->flashdata('success') . '</div>';
		    } ?>
		    <?php if ($this->session->flashdata('error')) {
		                  echo '<div class="error-box">' . $this->session->flashdata('error') . '</div>';
		    } ?>
		
	    	<?=$page_output; ?>
	
	    </div>
	
	  </div>
	</div>
	
	<div id="footer">
		<?php theme_view('footer'); ?>
	</div>
	
	</body>

</html>
